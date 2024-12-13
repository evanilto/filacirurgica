<?php

namespace App\Controllers;

/* class Home extends BaseController
{
    //public function index(): string
    public function index()
    {
        //return view('welcome_message');
        //return view('hello_same');
        echo view('templates/header');
        echo view('templates/nav');
        echo view('templates/footer');
    }
} */

use App\Models\SolicitacaoModel;
use CodeIgniter\RESTful\ResourceController;
use App\Models\UsuarioModel;
use App\Models\PerfilModel;
use App\Models\PerfisUsuarioModel;
use App\Models\AuditoriaAcessoModel;
use App\Libraries\HUAP_Functions;

class Home extends ResourceController
{
    #private $v;

    public function __construct()
    {

        helper(['form', 'url', 'session']);
    }

    //public function index(): string
    public function index_home()
    {
     
        return view('layouts/form_home', ['timer' => env('huap.session.expires')]);

    }

    public function index()
    {
        \Config\Services::session();
        session_write_close();
        unset($v,$_SESSION);
        return view('home/form_login');

    }

    /**
    * Formulário de Acesso a aplicação web, com validação e registro no Banco
    * de dados (POST)
    *
    * @return void
    */
    public function login()
    {
        $session = \Config\Services::session();
        $usuario = new UsuarioModel();
        //$perfil = new PerfilModel();
        $perfilusu = new PerfisUsuarioModel();
        $acesso = new AuditoriaAcessoModel();

        $v = $this->request->getVar(['Usuario', 'Senha']);
        $v['Usuario'] = preg_replace('/((\w+).(\w+))(\b@ebserh.gov.br)/i', '$1', $v['Usuario']);

        $inputs = $this->validate([
            'Usuario' => 'required',
            'Senha' => 'required'
        ]);

        #verifica se os campos foram preenchidos
        if (!$inputs) {
            session()->setFlashdata('failed', HUAP_MSG_ERROR);
            return view('home/form_login', [
                'validation' => $this->validator
            ]);
        }

        $func = new HUAP_Functions();

        //$usuario = new UsuarioModel();
        $usuario = $usuario->get_user_mysql($v['Usuario']);
        
        if (!isset($usuario) || !$usuario) {
            session()->setFlashdata('failed', 'Erro ao autenticar. <br> Usuário não encontrado ou não autorizado.');
            return view('home/form_login');
        }
        if ($usuario['indsituacao'] == 'I') {
            session()->setFlashdata('failed', 'Erro ao autenticar. <br> Usuário inativo.');
            return view('home/form_login');
        }

        /* $perfil = $perfil->list_perfil_bd($usuario['idSishuap_Usuario'], TRUE);

        if (!isset($perfil) || !$perfil) {
            session()->setFlashdata('failed', 'Erro ao autenticar. <br> Usuário não possui nenhum perfil associado.');
            return view('home/form_login');
        }  */

       if (!$this->validate_ldap($v['Usuario'], $v['Senha'])) {
            session()->setFlashdata('failed', 'Erro ao autenticar. <br> Senha incorreta.');
            return view('home/form_login');
        } 

        session()->set('isLoggedIn', true);

        $usuario = $v['Usuario'];

        $perfis = $perfilusu->Where('idlogin', $usuario)->select('idperfil')->findAll();
        session()->set('Sessao', ['idPerfil' => array_column($perfis, 'idperfil')]);

        unset($v['Senha']); 
        $_SESSION['Sessao']['login'] = $usuario;
        //$_SESSION['Sessao'] = [];


        //$v['Nome'] = explode(' ', $_SESSION['Sessao']['nmUsuario']);
        //$_SESSION['Sessao']['NomeCompleto'] = $_SESSION['Sessao']['nmUsuario'];
        //$_SESSION['Sessao']['Nome'] = $v['Nome'][0] . ' ' . $v['Nome'][count($v['Nome'])-1];
        
        //var_dump( $_SESSION);die();

        $_SESSION['Sessao']['NomeCompleto'] = $this->getLDAPUserName($v['Usuario']);
        $_SESSION['Sessao']['Nome'] = $v['Usuario'];
        //die(var_dump($v['Usuario']));
       // var_dump($_SESSION['Sessao']);die();

       /*  $_SESSION['Sessao']['Perfil'] = $perfil;
        $acesso->insert($func->set_acesso('LOGIN'), TRUE); */

        /**
         * Sessão e cookies são definidas para durarem 2h (120minutos)
         * Tempo definido em segundos no arquivo .env, variável huap.session.expires
         * A variável huap.session.expires também é carregada nos seguintes aqruivos:
         * - Home.php (Controller)
         * - HUAP_jquery.js (public/assets/js)
         * - BaseController.php (Controller)
         * - Auth.php (Filter)
         */
        $_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp
        setcookie("SishuapCookie", "", time()+env('huap.session.expires'));

        /*
        echo "<pre>";
        print_r($v);
        echo "</pre>";
        echo "<pre>";
        print_r($_SESSION);
        echo "</pre>";
        exit('oi');
        #*/
        //return redirect()->to('/admin');
        //var_dump($_SESSION);die();
        return redirect()->to('/home_index');

    }

    /**
    * Formulário de Acesso a aplicação web, com validação e registro no Banco
    * de dados (POST)
    *
    * @return void
    */
    public function logout($data = NULL)
    {

        $session = \Config\Services::session();
        $usuario = new UsuarioModel();
        $acesso = new AuditoriaAcessoModel();

        $func = new HUAP_Functions();

        $operacao = (!$data) ? 'LOGOUT' : 'TIMEOUT';
        //$acesso->insert($func->set_acesso($operacao), TRUE);

        setcookie("SishuapCookie", "", time()-env('huap.session.expires'));
        #session_write_close();
        #unset($v,$_SESSION);
        #session()->remove();
        (isset($_SESSION)) ? $session->destroy($_SESSION) : NULL;
        //(isset($v)) ? $session->destroy($v) : NULL;
        #$session->stop();
        #$session = \Config\Services::session();
        #session()->setFlashdata('failed', 'Tempo de sessão expirado.');
        /*echo "<pre>";
        print_r($_SESSION);
        echo "</pre>";
        exit('??');*/
        return redirect()->to('/');

    }

    /**
    * Função de validação no AD via protocolo LDAP
    * como usar:
    * validate_ldap("servidor", "domíniousuário", "senha");
    *
    * @return bool
    *
    */
    private function validate_ldap($usr, $pwd){

        #Apenas para testar o sistema sem a necessidade de consultar o AD - APAGAR
        #return TRUE;

        #Tenta se conectar com o servidor LDAP Master
        if (FALSE !== $ldap1=@ldap_connect(env('srv.ldap1')))
            $ldap_conn = $ldap1;
        #Tenta se conectar com o servidor LDAP Slave caso não consiga conexão com o Master
        elseif (FALSE !== $ldap2=@ldap_connect(env('srv.ldap2')))
            $ldap_conn = $ldap2;
        else
            return FALSE;

        # Tenta autenticar no servidor
        return (!@ldap_bind($ldap_conn, $usr.'@ebserh.gov.br', $pwd)) ? FALSE : TRUE;

    }
    /**
    * 
    *
    * @return bool
    *
    */
    public static function userExistsInLDAP($usr) {
   
        # Tenta se conectar com o servidor LDAP Master
        if (FALSE !== $ldap1 = @ldap_connect(env('srv.ldap1'))) {
            $ldap_conn = $ldap1;
        }
        # Tenta se conectar com o servidor LDAP Slave caso não consiga conexão com o Master
        elseif (FALSE !== $ldap2 = @ldap_connect(env('srv.ldap2'))) {
            $ldap_conn = $ldap2;
        } else {
            return FALSE;
        }
    
        # Tenta realizar a busca do usuário no LDAP
        $filter = "(sAMAccountName=$usr)";
        $base_dn = "dc=ebserh,dc=gov,dc=br";
        $result = @ldap_search($ldap_conn, $base_dn, $filter);
    
        # Verifica se a busca retornou algum resultado
        if ($result) {
            $entries = ldap_get_entries($ldap_conn, $result);
    
            # Se existirem entradas, o usuário foi encontrado
            if ($entries['count'] > 0) {
                return TRUE;
            }
        }
    
        return FALSE;
    }
    /**
    * 
    *
    * @return string
    *
    */
    public static function getLDAPUserName($usr) {
            
            # Tenta se conectar com o servidor LDAP Master
            if (FALSE !== $ldap1 = @ldap_connect(env('srv.ldap1'))) {
                $ldap_conn = $ldap1;
            }
            # Tenta se conectar com o servidor LDAP Slave caso não consiga conexão com o Master
            elseif (FALSE !== $ldap2 = @ldap_connect(env('srv.ldap2'))) {
                $ldap_conn = $ldap2;
            } else {
                return null;
            }
        
            ldap_set_option($ldap_conn, LDAP_OPT_PROTOCOL_VERSION, 3);
            ldap_set_option($ldap_conn, LDAP_OPT_REFERRALS, 0);

            ldap_bind($ldap_conn, env('ldap.usr'), env('ldap.pwd'));

            # Tenta realizar a busca do usuário no LDAP
            $filter = "(sAMAccountName=$usr)";
            $attributes = array("name", "sAMAccountName"); 

            //$base_dn = "DC=ebserh, DC=gov, DC=br";
            //$ldap_dn = "OU=Usuarios,OU=HUAP,OU=EBSERH,DC=ebserhnet,DC=ebserh,DC=gov,DC=br";
            
            $result = ldap_search($ldap_conn, env('ldap.dn'), $filter);
/* 
            $ldap_dn = "OU=Usuarios,OU=HUAP,OU=EBSERH,DC=ebserhnet,DC=ebserh,DC=gov,DC=br";
            $attributes = array("name", "sAMAccountName"); 
            $filter = "(&(objectCategory=person)(sAMAccountName=$usr))";
            $result = ldap_search($ldap_conn, $ldap_dn, $filter, $attributes); */

            # Verifica se a busca retornou algum resultado
            if ($result) {
                $entries = ldap_get_entries($ldap_conn, $result);

                # Se existirem entradas, o usuário foi encontrado
                if ($entries['count'] > 0) {
                    # Substitua 'displayname' pelo atributo que contém o nome do usuário
                    return isset($entries[0]['displayname'][0]) ? $entries[0]['displayname'][0] : null;
                }
            }
        
            return null;
        }
        
}