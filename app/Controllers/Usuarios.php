<?php

namespace App\Controllers;

use App\Libraries\HUAP_Functions;
use App\Models\UsuarioModel;
use App\Models\SetorModel;
use App\Models\SetorTramiteModel;
use App\Models\PerfilModel;
use App\Controllers\Setores;
use App\Controllers\Perfis;
use App\Models\PerfisUsuarioModel;
use CodeIgniter\RESTful\ResourceController;

class Usuarios extends ResourceController
{
    private $usuariomodel;
    private $perfilmodel;
    private $perfilcontroller;
    private $perfisusuariomodel;


    public function __construct()
    {
        $this->usuariomodel = new UsuarioModel();
        $this->perfilmodel = new PerfilModel();
        $this->perfilcontroller = new Perfis;
        $this->perfisusuariomodel = new PerfisUsuarioModel();

    }

    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        return redirect()->to('usuarios/listar');

    }

    /**
     * Retorna todos os usuários cadastrados
     *
     * @return mixed
     */
    public function getUsuarios() {

        //return $this->respond($this->usuariomodel->findAll());
        return $this->usuariomodel->findAll();
    }
    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function getUsuario($id = null)
    {
        $data = $this->usuariomodel->getWhere(['id' => $id])->getResult();

        if($data){
            return $data;
        }
        
        return $this->failNotFound('Nenhum usuário encontrado com id '.$id); 
    }
    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function getUsuarioPeloLogin(string $login)
    {
        $data = $this->usuariomodel->getWhere(['login' => $login])->getResult();

        if($data){
            return $data;
        }
        
        return $this->failNotFound('Nenhum usuário encontrado com login '.$login); 
    }
     /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function getUsuariosSetor($id)
    {
        $data = $this->usuariomodel->getWhere(['idSetor' => $id])->getResult();
        
       // var_dump($data);die();

        if($data){
            return $data;
        }
        
        return $this->failNotFound('Nenhum usuário encontrado com id '.$id); 
    }
    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        $data = $this->usuariomodel->getWhere(['id' => $id])->getResult();

        if($data){
            return $this->respond($data);
        }
        
        return $this->failNotFound('Nenhum usuário encontrado com id '.$id); 
    }

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {
        $data = $this->request->getJSON();
       
        try {
            $this->usuariomodel->insert($data);
            $response = [
                'status'   => 201,
                'error'    => null,
                'messages' => [
                'success'  => 'Usuário criado!'
                ]
            ];
            return $this->respondCreated($response);

        } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
            $msg = 'Erro na criação do usuário';
            log_message('error', $msg.': ' . $e->getMessage());
            return $this->fail($msg.' ('.$e->getCode().')');
        }

        //return $this->fail($this->usuariomodel->errors());
    }

    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($id = null)
    {
        $data = $this->request->getJSON();

        try {

            if(!$this->usuariomodel->getWhere(['id' => $id])->getResult()) {

                $response = [
                    'status'   => 404,
                    'error'    => 'Usuário não localizado com id '.$id,
                ];

            } else {
            
                    $this->usuariomodel->update($id, $data);
                        
                    if ($this->usuariomodel->affectedRows() > 0) {
                        $response = [
                            'status'   => 200,
                            'error'    => null,
                            'messages' => [
                                'success' => 'Usuário atualizado!'
                                ]
                        ];
                        
                    } else {
                        $response = [
                            'status'   => 404,
                            'error'    => 'Sem dados para atualizar',
                        ];
                    }
            
            }

            return $this->respond($response);

        } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
            $msg = 'Erro na alteração do usuário';
            log_message('error', $msg.': ' . $e->getMessage());
            return $this->fail($msg.' ('.$e->getCode().')');
        }
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
      
        $data = $this->usuariomodel->find($id);
        
        if($data){
            try {
                $this->usuariomodel->delete($id);
                $response = [
                    'status'   => 200,
                    'error'    => null,
                    'messages' => [
                        'success' => 'Usuário removido com sucesso!'
                    ]
                ];
                return $this->respondDeleted($response);

            } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
                $msg = 'Erro na exclusão do usuário';
                log_message('error', $msg.': ' . $e->getMessage());
                return $this->fail($msg.' ('.$e->getCode().')');
            }
        }
        
        return $this->failNotFound('Nenhum usuário encontrado com id '.$id);    
    }
    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function incluir_usuario()
    {
        helper('form');
        
        $perfis[] = $this->perfilcontroller->getPerfis();

        /* $setorusuario = $_SESSION['Sessao']['nmSetor'];
        $result = array_filter($this->setorcontroller->select['Setor'], function ($item) use ($setorusuario) {
            return $item['nmSetor'] !== $setorusuario;
        });
        
        // Reindexar o array
        $setortramite['Setor'] = array_values($result); */

       //var_dump($perfis[0]);die();

        //echo view('usuarios/incluir_usuario',  ['selectPerfil' => $perfis[0]]);

        return view('layouts/sub_content', ['view' => 'usuarios/form_incluir_usuario',
                                            'selectPerfil' => $perfis[0]]);

    }
    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function incluir()
    {        
        helper(['form', 'url']);

        \Config\Services::session();

        $data = $this->request->getVar();

        //$usuario = Home::getUserNameFromLDAP($data['login']);
        $login = null;
        $usuario = Home::getLDAPUserName($data['login']);

        //var_dump($data);die();

        if(!is_null($usuario)) {
            //$data['nmUsuario'] = $usuario;
            $login = $data['login'];
        }

        $rules = [
            'login' => 'required|max_length[50]|min_length[3]|equals['.$login.']',
            'perfil' => 'required'
        ];

        if ($this->validate($rules)) {

            if(!empty($this->usuariomodel->Where('idlogin', $login)->findAll())) {
                session()->setFlashdata('failed', 'Usuário já cadastrado!');
                return view('usuarios/incluir_usuario', ['validation' => $this->validator, 'selectPerfil' => $this->perfilcontroller->getPerfis()]);
            } 

            $db = \Config\Database::connect('default');
            $db->transStart();
            
            try {

                $data['idlogin'] = mb_strtolower($data['login'], 'UTF-8');
                $data['nmusuario'] = $usuario;
                $data['indsituacao'] = $data['indSituacao'];
                $data['user_ult_atu'] = session()->get('Sessao')['Nome'];;


                //die(var_dump(($data)));

                $this->usuariomodel->insert($data);

                if ($db->transStatus() === false) {
                    $error = $db->error();
                    $errorMessage = !empty($error['message']) ? $error['message'] : 'Erro desconhecido';
                    $errorCode = !empty($error['code']) ? $error['code'] : 0;

                    throw new \CodeIgniter\Database\Exceptions\DatabaseException(
                        sprintf('Erro ao incluir usuário! [%d] %s', $errorCode, $errorMessage)
                    );
                }

                if (isset($data['perfil'])) {

                    $array['idlogin'] = $data['login'];

                    foreach ($data['perfil'] as $key => $perfil) {

                        [$idperfil, $nmperfil] = explode('#', $perfil);
                        $array['idperfil'] = (int)$idperfil;

                        //die(var_dump($array));

                        $this->perfisusuariomodel->insert($array);

                        if ($db->transStatus() === false) {
                            $error = $db->error();
                            $errorMessage = !empty($error['message']) ? $error['message'] : 'Erro desconhecido';
                            $errorCode = !empty($error['code']) ? $error['code'] : 0;
        
                            throw new \CodeIgniter\Database\Exceptions\DatabaseException(
                                sprintf('Erro ao incluir perfis do usuário! [%d] %s', $errorCode, $errorMessage)
                            );
                        }
                    }
                }
                
                $db->transComplete(); 

                if ($db->transStatus() === false) {
                    $error = $db->error();
                    $errorMessage = !empty($error['message']) ? $error['message'] : 'Erro desconhecido';
                    $errorCode = !empty($error['code']) ? $error['code'] : 0;

                    throw new \CodeIgniter\Database\Exceptions\DatabaseException(
                        sprintf('Erro ao incluir usuário! [%d] %s', $errorCode, $errorMessage)
                    );
                }

                $this->validator->reset();

                session()->setFlashdata('success', 'Operação concluída com sucesso!');

                return redirect()->to('usuarios/listar');

            } catch (\Throwable $e) {
                $db->transRollback(); 
                $msg = sprintf('Exception - '.$e->getMessage());
                log_message('error', 'Exception: ' . $msg);
                session()->setFlashdata('exception', $msg);
            }

            return view('usuarios/incluir_usuario', ['validation' => $this->validator,
                                                     'selectPerfil' => $this->perfilcontroller->getPerfis()]);

        } else {
            session()->setFlashdata('error', $this->validator);

            //die(var_dump($this->validator));

            if(is_null($login)) {
                $this->validator->setError('login', 'Não existe usuário com esse login EBSERH!');
            } else {
                if( !isset($data['perfil'])) {
                    session()->setFlashdata('failed', 'Informe ao menos um perfil para o usuário!');

                } else {
                    session()->setFlashdata('error', $this->validator);
                }
            }

            //die(var_dump($this->validator->getError('perfil')));

            return view('usuarios/incluir_usuario', ['validation' => $this->validator,
                                                     'selectPerfil' => $this->perfilcontroller->getPerfis()]);
        }

    }
     /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function editar_usuario($id = null)
    {
       
        $usuario = $this->usuariomodel->getWhere(['id' => $id])->getResult();

        if($usuario){

            return view('layouts/sub_content', ['view' => 'usuarios/form_editar_usuario',
                                                'id' => $id,
                                                'login' => $usuario[0]->idlogin,
                                                'indSituacao' => $usuario[0]->indsituacao,
                                                //'selectPerfisUsuario' => $this->perfisusuariomodel->getWhere(['idlogin' => $usuario[0]->idlogin])->getResult(),
                                                'selectPerfisUsuario' =>$result = $this->perfisusuariomodel->where('idlogin', $usuario[0]->idlogin)->find(),
                                                'selectPerfil' => $this->perfilcontroller->getPerfis()
                                                ]);
        }
        
        session()->setFlashdata('failed', 'Usuario não localizado!');
        
        return redirect()->to('usuarios/listar');

    }
    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function editar()
    {
        \Config\Services::session();

        helper(['form', 'url']);

        $data = $this->request->getVar();

        //var_dump(session()->get('Sessao')['Nome']);die();

        if (!isset($data['perfil'])) {

            session()->setFlashdata('failed', 'Informe pelo menos um perfil para o usuário!');

            return view('layouts/sub_content', ['view' => 'usuarios/form_editar_usuario',
                                                'id' => $data['id'],
                                                'login' => $data['login'],
                                                'indSituacao' => $data['indSituacao'],
                                                'selectPerfisUsuario' =>$result = $this->perfisusuariomodel->where('idlogin', $data['login'])->find(),
                                                'selectPerfil' => $this->perfilcontroller->getPerfis()
                                                ]);

        }

        try {
            
            $db = \Config\Database::connect('default');

            $db->transStart();

            $array['indsituacao'] = $data['indSituacao'];
            $array['user_ult_atu'] = session()->get('Sessao')['Nome'];;

            $this->usuariomodel->update($data['id'], $array);

            if ($db->transStatus() === false) {
                $error = $db->error();
                $errorMessage = isset($error['message']) ? $error['message'] : 'Erro desconhecido';
                $errorCode = isset($error['code']) ? $error['code'] : 0;

                throw new \CodeIgniter\Database\Exceptions\DatabaseException(
                    sprintf('Erro ao atualizar usuário! [%d] %s', $errorCode, $errorMessage)
                );
            }

            //$db->query("DELETE FROM setores_tramite WHERE idUsuario = ?", [$id]);
            $db->query("UPDATE usuarios_perfis SET deleted_at = CURRENT_TIMESTAMP WHERE idlogin = ? AND deleted_at IS NULL", [$data['login']]);

            //die($db->getLastQuery());

            if ($db->transStatus() === false) {
                $error = $db->error();
                $errorMessage = isset($error['message']) ? $error['message'] : 'Erro desconhecido';
                $errorCode = isset($error['code']) ? $error['code'] : 0;

                throw new \CodeIgniter\Database\Exceptions\DatabaseException(
                    sprintf('Erro ao alterar permissões do usuário! [%d] %s', $errorCode, $errorMessage)
                );
            }

            foreach ($data["perfil"] as $perfil) {
                [$idperfil, $nmperfil] = explode('#', $perfil);
                $array['idlogin'] = $data['login'];
                $array['idperfil'] = (int)$idperfil;
                $this->perfisusuariomodel->insert($array);   
                
                if ($db->transStatus() === false) {
                    $error = $db->error();
                    $errorMessage = isset($error['message']) ? $error['message'] : 'Erro desconhecido';
                    $errorCode = isset($error['code']) ? $error['code'] : 0;
    
                    throw new \CodeIgniter\Database\Exceptions\DatabaseException(
                        sprintf('Erro ao alterar permissões do usuário! [%d] %s', $errorCode, $errorMessage)
                    );
                }
            }   

            $db->transComplete();

            session()->setFlashdata('success', 'Alteração do usuário realizada com sucesso!');

            return redirect()->to('usuarios/listar');
            
        } catch (\Throwable $e) {
            $db->transRollback();
            $msg = 'Erro na alteração do Usuario';
            if($e->getCode() == 1062) {
                $msg .= ' - Já existe um Usuario com esse Login!';
            } else {
                $msg .= ' - '.$e->getMessage();
                log_message('error', $msg.': ' . $e->getMessage());
            }
            session()->setFlashdata('failed', $msg);

           /*  return view('usuarios/editar_usuario', ['validation' => $this->validator,
            'id' => $id,
            'login' => $data['login'],
            'nmUsuario' => $data['nmUsuario'],
            'indSituacao' => $data['indSituacao'],
            'Setor' => $data['Setor'],
            'idPerfil' =>  $data['idPerfil'],
            'selectSetor' => $this->setorcontroller->select,
            'selectPerfil' => $this->perfilcontroller->getPerfis(),
            ]); */

            return view('layouts/sub_content', ['view' => 'usuarios/form_editar_usuario',
                                                'id' => $data['id'],
                                                'login' => $data['login'],
                                                'indSituacao' => $data['indSituacao'],
                                                'selectPerfisUsuario' =>$result = $this->perfisusuariomodel->where('idlogin', $data['login'])->find(),
                                                'selectPerfil' => $this->perfilcontroller->getPerfis()
                                                ]);
        }
    }
    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function excluir($id = null)
    {
      
        $data = $this->usuariomodel->find($id);
        
        if($data){
            try {
                $this->usuariomodel->delete($id);

                session()->setFlashdata('success', 'Exclusão concluída com sucesso!');

            } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
                $msg = 'Erro na exclusão do Usuario';
                log_message('error', $msg.': ' . $e->getMessage());
                session()->setFlashdata('failed', $msg);
            }

            return redirect()->to('usuarios/listar');
        }
        
        return $this->failNotFound('Nenhum Usuario encontrado com id '.$id);    
    }
     /**
     * Lista a tabela
     *
     * @return mixed
     */
    public function listar()
    {
        //$usuarios[] = $this->getUsuarios();

        $db = \Config\Database::connect('default');

        $builder = $db->table('usuarios as usu');
       /*  $builder->join('usuarios_perfis as uper', 'uper.idlogin = usu.idlogin', 'inner');
        $builder->join('perfis as per', 'per.id = uper.idperfil', 'inner'); */
        $builder->orderBy('usu.nmusuario', 'ASC');
        $builder->select('
                        usu.id,
                        usu.idlogin,
                        usu.nmusuario,
                        usu.indsituacao
        ');

        //var_dump($builder->getCompiledSelect());die();

        $usuarios = $builder->get()->getResult();

        //die(var_dump($usuarios));

        $options = array();
        foreach ($usuarios as $usuario) {

            //$setor = $this->setorcontroller->getSetor($usuario['idSetor']);
            //$perfil = $this->perfilmodel->find($usuario['idPerfil']);
            //var_dump($usuario);die();

            array_push($options, [
                'id' => $usuario->id,
                'login' => $usuario->idlogin,
                'nmUsuario' => $usuario->nmusuario,
                'indSituacao' => $usuario->indsituacao,
                //'nmPerfil' => $usuario->nmperfil
            ]);
        }

        /* return view('usuarios/listar_usuarios', [
                    'usuarios' => $options]); */

        return view('layouts/sub_content', ['view' => 'usuarios/list_usuarios',
                                            'usuarios' => $options]);


    }
    public function carregarPagina($pagina) {

        $usuarios[] = $this->getUsuarios();

                 
/*         echo view('layouts/main_content', ['this->renderSection(content)' => view($pagina)]);
 */        
            echo view('layouts/main_content', ['subcontent' => view($pagina)]);

    }
    /**
     * 
     * @return mixed
     */
    public function migrarUsuarios() {

        $sqlTruncate = "truncate usuarios;";
        $sqlDropDefault = "ALTER TABLE usuarios ALTER COLUMN id DROP DEFAULT;";
        $sqlSetVal = "SELECT setval('usuario_seq', (SELECT max(id) FROM usuarios));";
        $sqlRestartVal = "ALTER SEQUENCE usuario_seq RESTART WITH 1;";
        $sqlSetDefault = "ALTER TABLE usuarios ALTER COLUMN id SET DEFAULT nextval('usuario_seq');";

        try {

            $db = \Config\Database::connect('default');

            $sql = "
                    select distinct cp.usuarios 
                    from cirurgias_permissoesusuarios cp;
                   ";

            $query = $db->query($sql);

            $result = $query->getResult();

            $query = $db->query($sqlTruncate);
            $query = $db->query($sqlRestartVal);
            //$query = $db->query($sqlDropDefault);

            $db->transStart();

            foreach ($result as $reg) {

                $usuario = [];
                $usuario['idlogin'] = $reg->usuarios;
                $usuario['indsituacao'] = 'I';

                $this->usuariomodel->insert($usuario);
                
                if ($db->transStatus() === false) {
                    $error = $db->error();
                    $errorMessage = isset($error['message']) ? $error['message'] : 'Erro desconhecido';
                    $errorCode = isset($error['code']) ? $error['code'] : 0;

                    throw new \Exception(
                        sprintf('Erro ao incluir usuário! [%d] %s', $errorCode, $errorMessage)
                    );
                }

            }

            $db->transComplete();

            if ($db->transStatus() === false) {
                $error = $db->error();
                $errorMessage = isset($error['message']) ? $error['message'] : 'Erro desconhecido';
                $errorCode = isset($error['code']) ? $error['code'] : 0;

                throw new \Exception(
                    sprintf('Erro na criação do usuário! [%d] %s', $errorCode, $errorMessage)
                );
            }

            $query = $db->query($sqlSetVal);
            $query = $db->query($sqlSetDefault);

        } catch (\Throwable $e) {
            $msg = 'Falha na criação do usuário ==> '.$e->getMessage();
            log_message('error', $msg.': ' . $e->getMessage());
            throw $e;
        }
    }
    /**
     * 
     * @return mixed
     */
    public function migrarPermissoes() {

        $sqlTruncate = "truncate usuarios_perfis;";
        $sqlDropDefault = "ALTER TABLE usuarios_perfis ALTER COLUMN id DROP DEFAULT;";
        //$sqlSetVal = "SELECT setval('usuarios_perfis_seq', 1, false);";
        $sqlSetVal = "SELECT setval('usuarios_perfis_seq', (SELECT max(id) FROM usuarios_perfis));";
        $sqlRestartVal = "ALTER SEQUENCE usuarios_perfis_seq RESTART WITH 1;";
        $sqlSetDefault = "ALTER TABLE usuarios_perfis ALTER COLUMN id SET DEFAULT nextval('usuarios_perfis_seq');";
        //$sqlSetDefault = "ALTER TABLE usuarios_perfis ALTER COLUMN id RESTART WITH 6000";


        try {

            $db = \Config\Database::connect('default');

            $sql = "
                    select *
                    from cirurgias_permissoesusuarios cp;
                   ";

            $query = $db->query($sql);

            $result = $query->getResult();

            $query = $db->query($sqlTruncate);
            $query = $db->query($sqlRestartVal);
            //$query = $db->query($sqlDropDefault);

            $db->transStart();

            foreach ($result as $reg) {

                $permissao = [];
                $permissao['idlogin'] = $reg->usuarios;
                $permissao['idperfil'] = $reg->id_permissao;

                $this->perfisusuariomodel->insert($permissao);
                
                if ($db->transStatus() === false) {
                    $error = $db->error();
                    $errorMessage = isset($error['message']) ? $error['message'] : 'Erro desconhecido';
                    $errorCode = isset($error['code']) ? $error['code'] : 0;

                    throw new \Exception(
                        sprintf('Erro ao incluir permissão! [%d] %s', $errorCode, $errorMessage)
                    );
                }

            }

            $db->transComplete();

            if ($db->transStatus() === false) {
                $error = $db->error();
                $errorMessage = isset($error['message']) ? $error['message'] : 'Erro desconhecido';
                $errorCode = isset($error['code']) ? $error['code'] : 0;

                throw new \Exception(
                    sprintf('Erro na criação da permissão! [%d] %s', $errorCode, $errorMessage)
                );
            }

            $query = $db->query($sqlSetVal);
            $query = $db->query($sqlSetDefault);

        } catch (\Throwable $e) {
            $msg = 'Falha na criação da permissão ==> '.$e->getMessage();
            log_message('error', $msg.': ' . $e->getMessage());
            throw $e;
        }
    }

}
