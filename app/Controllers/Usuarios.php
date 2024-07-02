<?php

namespace App\Controllers;

use App\Libraries\HUAP_Functions;
use App\Models\UsuarioModel;
use App\Models\SetorModel;
use App\Models\SetorTramiteModel;
use App\Models\PerfilModel;
use App\Controllers\Setores;
use App\Controllers\Perfis;
use CodeIgniter\RESTful\ResourceController;

class Usuarios extends ResourceController
{
    private $usuariomodel;
    private $perfilmodel;
    private $perfilcontroller;


    public function __construct()
    {
        $this->usuariomodel = new UsuarioModel();
        $this->perfilmodel = new PerfilModel();
        $this->perfilcontroller = new Perfis;

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

        echo view('usuarios/incluir_usuario',  ['selectSetor' => $this->setorcontroller->select,
                                                'selectSetorTramite' => $this->setorcontroller->select,
                                                'selectPerfil' => $perfis[0]]);

                                               // var_dump($this->setorcontroller->select['Setor']);die();

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
            $data['nmUsuario'] = $usuario;
            $login = $data['login'];
        }

        $rules = [
            'login' => 'required|max_length[50]|min_length[3]|equals['.$login.']'
        ];

        if ($this->validate($rules)) {

            $db = \Config\Database::connect('default');
            $db->transStart();
            
            try {

                [$idsetor, $nmsetor, $idsetororig] = explode('#', $data["Setor"]);
                $data['idSetor'] = (int)$idsetor;
                $data['login'] = mb_strtolower($data['login'], 'UTF-8');
                $data['nmSetor'] = $nmsetor;
                $data['idSetorOrig'] = $idsetororig;
                $data['nmUsuario'] = mb_convert_case($data['nmUsuario'], MB_CASE_TITLE, 'UTF-8');
                $data['user_ult_atu'] = $_SESSION['Sessao']['login'];

                $this->usuariomodel->insert($data);

                if ($db->transStatus() === false) {
                    throw new \CodeIgniter\Database\Exceptions\DatabaseException($db->error()["message"], $db->error()["code"]);
                }

                if (!isset($data['setorTramite']) && $data['idPerfil'] == '2') {
                    throw new \Exception('Setores de Tramitação não informados');
                } else {

                    if (isset($data['setorTramite']) && $data['idPerfil'] == '2') {
                        foreach ($data['setorTramite'] as $key => $setor) {

                            [$idsetor, $nmsetor, $idsetororig] = explode('#', $setor);
                            $array['idSetor'] = (int)$idsetor;
                            $usuario = $this->getUsuarioPeloLogin($data['login']);

                            $array['idUsuario'] = (int)$usuario[0]->id;

                            //die(var_dump($array));

                            $this->setortramitemodel->insert($array);

                            if ($db->transStatus() === false) {
                                throw new \CodeIgniter\Database\Exceptions\DatabaseException($db->error()["message"], $db->error()["code"]);
                            }
                        }
                    }
                }

                $db->transComplete(); // Completa a transação

                if ($db->transStatus() === false) {
                    throw new \CodeIgniter\Database\Exceptions\DatabaseException('Erro ao completar a transação.');
                }

                $this->validator->reset();

                session()->setFlashdata('success', 'Operação concluída com sucesso!');

            } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
                $db->transRollback();

                $msg = 'Erro na criação do Usuario';
                if($e->getCode() == 1062) {
                    $msg .= ' - Já existe um Usuário com esse Login!';
                    session()->setFlashdata('failed', $msg);
                } else {
                    $msg .= ' - '.$e->getMessage();
                    session()->setFlashdata('failed', $msg);
                }
                log_message('error', $msg);

                return view('usuarios/incluir_usuario', ['validation' => $this->validator,
                                                     'selectSetor' => $this->setorcontroller->select,
                                                     'selectSetorTramite' => $this->setorcontroller->select,
                                                     'selectPerfil' => $this->perfilcontroller->getPerfis()]);
            }

            return redirect()->to('usuarios/listar');

        } else {
            session()->setFlashdata('error', $this->validator);

            if(!is_null($usuario) && is_null($login)) {
                $this->validator->setError('login', 'Não existe usuário com esse login EBSERH!');
            } else {
                session()->setFlashdata('error', $this->validator);
            }

            return view('usuarios/incluir_usuario', ['validation' => $this->validator,
                                                     'selectSetor' => $this->setorcontroller->select,
                                                     'selectSetorTramite' => $this->setorcontroller->select,
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

            //var_dump($usuario);die();

            $setoresTramUsu = [];
            
            if ($usuario[0]->idPerfil == 2) {
                $setoresTramUsu = $this->setortramitemodel->getSetores($id);
            }
                        
             return view('usuarios/editar_usuario',[
            'id' => $id,
            'login' => $usuario[0]->login,
            'nmUsuario' => $usuario[0]->nmUsuario,
            'indSituacao' => $usuario[0]->indSituacao,
            'Setor' => $usuario[0]->idSetor.'#'.$usuario[0]->nmSetor.'#'.$usuario[0]->idSetorOrig,
            'idPerfil' =>  $usuario[0]->idPerfil,
            'selectSetor' => $this->setorcontroller->select,
            'selectPerfil' => $this->perfilcontroller->getPerfis(),
            'selectSetorTramite' => $setoresTramUsu,
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
    public function editar($id = null)
    {
        \Config\Services::session();

        helper(['form', 'url']);

        $data = $this->request->getVar();

        //var_dump($data);die();

        try {
            
            $db = \Config\Database::connect('default');
            $db->transStart();

            [$idsetor, $nmsetor, $idsetororig] = explode('#', $data["Setor"]);
            $array['idSetor'] = (int)$idsetor;
            $array['nmSetor'] = $nmsetor;
            $array['idSetorOrig'] = $idsetororig;
            $array['idPerfil'] = $data['idPerfil'];
            $array['indSituacao'] = $data['indSituacao'];
            $array['user_ult_atu'] = $_SESSION['Sessao']['login'];

            $this->usuariomodel->update($id, $array);

            if ($db->transStatus() === false) {
                throw new \CodeIgniter\Database\Exceptions\DatabaseException($db->error()["message"], $db->error()["code"]);
            }

            //$db->query("DELETE FROM setores_tramite WHERE idUsuario = ?", [$id]);
            $db->query("UPDATE setores_tramite SET deleted_at = CURRENT_TIMESTAMP() WHERE idUsuario = ?", [$id]);

            //var_dump($id);die();
            
            if ($db->transStatus() === false) {
                throw new \CodeIgniter\Database\Exceptions\DatabaseException($db->error()["message"], $db->error()["code"]);
            }

            if ($data['idPerfil'] == 2) {

                if ($db->transStatus() === false) {
                    throw new \CodeIgniter\Database\Exceptions\DatabaseException($db->error()["message"], $db->error()["code"]);
                }

                foreach ($data["setorTramite"] as $setor) {
                    [$idsetor, $nmsetor, $idsetororig] = explode('#', $setor);
                    $array['idUsuario'] = (int)$id;
                    $array['idSetor'] = (int)$idsetor;
                    $this->setortramitemodel->insert($array);   
                    
                    if ($db->transStatus() === false) {
                        throw new \CodeIgniter\Database\Exceptions\DatabaseException($db->error()["message"], $db->error()["code"]);
                    }
                }   

            }

            $db->transComplete();

            session()->setFlashdata('success', 'Operação concluída com sucesso!');

            return redirect()->to('usuarios/listar');
            
        } catch (\Exception $e) {
            $db->transRollback();
            $msg = 'Erro na alteração do Usuario';
            if($e->getCode() == 1062) {
                $msg .= ' - Já existe um Usuario com esse Login!';
            } else {
                $msg .= ' - '.$e->getMessage();
                log_message('error', $msg.': ' . $e->getMessage());
            }
            session()->setFlashdata('failed', $msg);

            return view('usuarios/editar_usuario', ['validation' => $this->validator,
            'id' => $id,
            'login' => $data['login'],
            'nmUsuario' => $data['nmUsuario'],
            'indSituacao' => $data['indSituacao'],
            'Setor' => $data['Setor'],
            'idPerfil' =>  $data['idPerfil'],
            'selectSetor' => $this->setorcontroller->select,
            'selectPerfil' => $this->perfilcontroller->getPerfis(),
            ]);
        }
    }
    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function setores_a_tramitar($id = null)
    {
        $usuario = $this->usuariomodel->getWhere(['id' => $id])->getResult();

        if($usuario){
            
            //$setor = $this->setorcontroller->select;
            //var_dump($usuario[0]->idSetor.'#'.$usuario[0]->nmSetor.'#'.$usuario[0]->idSetorOrig);die();

            return view('usuarios/editar_usuario',[
            'id' => $id,
            'login' => $usuario[0]->login,
            'nmUsuario' => $usuario[0]->nmUsuario,
            'indSituacao' => $usuario[0]->indSituacao,
            'Setor' => $usuario[0]->idSetor.'#'.$usuario[0]->nmSetor.'#'.$usuario[0]->idSetorOrig,
            'idPerfil' =>  $usuario[0]->idPerfil,
            'selectSetor' => $this->setorcontroller->select,
            'selectPerfil' => $this->perfilcontroller->getPerfis(),
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
    public function definir_setores($id = null)
    {
        \Config\Services::session();

        helper(['form', 'url']);

        $data = $this->request->getVar();

        //var_dump($data);die();

        $array = [
            'nmUsuario' => mb_convert_case($data['nmUsuario'], MB_CASE_TITLE, 'UTF-8'),
            'indSituacao' => $data['indSituacao'],
            //'login' => $data['login'],
            'idPerfil' => $data['idPerfil'],
        ];


        $rules = [
            'login' => 'required|max_length[50]|min_length[3]',
            'nmUsuario' => 'required|max_length[100]|min_length[3]'
        ];

        if ($this->validate($rules)) {

            try {

                    [$idsetor, $nmsetor, $idsetororig] = explode('#', $data["Setor"]);
                    $array['idSetor'] = (int)$idsetor;
                    $array['nmSetor'] = $nmsetor;
                    $array['idSetorOrig'] = $idsetororig;
                    $array['nmUsuario'] = mb_convert_case($array['nmUsuario'], MB_CASE_TITLE, 'UTF-8');
                    $array['user_ult_atu'] = $_SESSION['Sessao']['login'];

                    $this->usuariomodel->update($id, $array);
                        
                    if ($array['idPerfil'] == 2) {
                        return redirect()->to('usuarios/setoresparatramitar/'.$id);
                    }

                    $this->validator->reset();
                
            } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
                $msg = 'Erro na alteração do Usuario';
                if($e->getCode() == 1062) {
                    $msg .= ' - Já existe um Usuario com esse Login!';
                } else {
                    $msg .= ' - '.$e->getMessage();
                    log_message('error', $msg.': ' . $e->getMessage());
                }
                session()->setFlashdata('failed', $msg);
            }

            return redirect()->to('usuarios/listar');

        } else {
            session()->setFlashdata('error', $this->validator);

            return view('usuarios/editar_usuario', ['validation' => $this->validator,
            'id' => $id,
            'login' => $data['login'],
            'nmUsuario' => $data['nmUsuario'],
            'indSituacao' => $data['indSituacao'],
            'Setor' => $data['Setor'],
            'idPerfil' =>  $data['idPerfil'],
            'selectSetor' => $this->setorcontroller->select,
            'selectPerfil' => $this->perfilcontroller->getPerfis(),
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
        $usuarios[] = $this->getUsuarios();

        $options = array();
        foreach ($usuarios[0] as $usuario) {

            //$setor = $this->setorcontroller->getSetor($usuario['idSetor']);
            $perfil = $this->perfilmodel->find($usuario['idPerfil']);

            //var_dump($perfil);die();

            array_push($options, [
                'id' => $usuario['id'],
                'login' => $usuario['login'],
                'nmUsuario' => $usuario['nmUsuario'],
                'indSituacao' => $usuario['indSituacao'],
                'idSetor' => $usuario['idSetor'],
                'nmSetor' => $usuario['nmSetor'],
                'nmPerfil' => $perfil['nmPerfil']
            ]);
        }

        return view('usuarios/listar_usuarios', [
                    'usuarios' => $options]);


    }
    public function carregarPagina($pagina) {

        $usuarios[] = $this->getUsuarios();

                 
/*         echo view('layouts/main_content', ['this->renderSection(content)' => view($pagina)]);
 */        
            echo view('layouts/main_content', ['subcontent' => view($pagina)]);

    }
}
