<?php

namespace App\Controllers;

use App\Models\PerfilModel;
use CodeIgniter\RESTful\ResourceController;

class Perfis extends ResourceController
{
    private $perfilmodel;
    private $aghucontroller;
    public $select;


    public function __construct()
    {
        $this->perfilmodel = new PerfilModel();
        
    }

    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
  
        return redirect()->to('perfis/listar');
    }

    /**
     * Retorna todos os setors cadastrados
     *
     * @return mixed
     */
    public function getPerfis() {

        //return $this->respond($this->perfilmodel->findAll());
        return $this->perfilmodel->findAll();

    }

    
    public function getPerfil($id = null)
    {
        $data = $this->perfilmodel->getWhere(['id' => $id])->getResult();

        if($data){
            return $data;
        }
        
        return $this->failNotFound('Nenhum perfil encontrado com id '.$id); 
    }
    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function incluir_setor()
    {
        helper('form');
        
        echo view('setores/incluir_setor');

    }
    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function incluir()
    {        
        helper(['form', 'url']);

        $data = $this->request->getVar();

        $rules = [
            //'codSetor' => 'required|max_length[4]|numeric',
            'nmSetor' => 'required|max_length[100]|min_length[3]'
        ];

        if ($this->validate($rules)) {
            
            try {
                $this->perfilmodel->insert($data);
                
                $this->validator->reset();

                session()->setFlashdata('success', 'Operação concluída com sucesso!');

            } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
                $msg = 'Erro na criação do setor';
                if($e->getCode() == 1062) {
                    $msg .= ' - Já existe um Setor com esse nome!';
                } else {
                    $msg .= ' - '.$e->getMessage();
                    log_message('error', $msg.': ' . $e->getMessage());
                }
                session()->setFlashdata('failed', $msg);
            }

            return redirect()->to('setores/listar');

        } else {
            session()->setFlashdata('error', $this->validator);

            return view('setores/incluir_setor', ['validation' => $this->validator]);
        }

    }
     /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function editar_setor($id = null)
    {
       
        //$data = $this->perfilmodel->find($id);
        $data = $this->perfilmodel->getWhere(['id' => $id])->getResult();

        if($data){
            return view('setores/editar_setor',[
            'id' => $id,
            'nmSetor' => $data[0]->nmSetor,
            'indSituacao' => $data[0]->indSituacao,
            ]);
        }
        
        session()->setFlashdata('failed', 'Setor não localizado!');
        return redirect()->to('setores/listar');

    }
    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function editar($id = null)
    {
        helper(['form', 'url']);

        $data = $this->request->getVar();

        $array = [
            'nmSetor' => $data['nmSetor'],
            'indSituacao' => $data['indSituacao'],
        ];


        $rules = [
            'nmSetor' => 'required|max_length[100]|min_length[3]'
        ];

        if ($this->validate($rules)) {

            try {
                    $this->perfilmodel->update($id, $array);
                        
                    if ($this->perfilmodel->affectedRows() > 0) {

                        session()->setFlashdata('success', 'Operação concluída com sucesso!');
                        
                    } else {

                        session()->setFlashdata('nochange', 'Sem dados para atualizar!');

                    }

                    $this->validator->reset();
                
            } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
                $msg = 'Erro na alteração do setor';
                if($e->getCode() == 1062) {
                    $msg .= ' - Já existe um Setor com esse nome!';
                } else {
                    $msg .= ' - '.$e->getMessage();
                    log_message('error', $msg.': ' . $e->getMessage());
                }
                session()->setFlashdata('failed', $msg);
            }

            return redirect()->to('setores/listar');

        } else {
            session()->setFlashdata('error', $this->validator);

            return view('setores/editar_setor', ['validation' => $this->validator,
            'id' => $id,
            'nmSetor' => $data['nmSetor'],
            'indSituacao' => $data['indSituacao'],
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
      
        $data = $this->perfilmodel->find($id);
        
        if($data){
            try {
                $this->perfilmodel->delete($id);

                session()->setFlashdata('success', 'Exclusão concluída com sucesso!');

            } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
                $msg = 'Erro na exclusão do setor';
                log_message('error', $msg.': ' . $e->getMessage());
                session()->setFlashdata('failed', $msg);
            }

            return redirect()->to('setores/listar');
        }
        
        return $this->failNotFound('Nenhum setor encontrado com id '.$id);    
    }
     /**
     * Lista a tabela
     *
     * @return mixed
     */
    public function listar()
    {
        
        $setores[] = $this->getPerfis();

        return view('setores/listar_setores', [
            'setores' => $this->getPerfis()]);

    }
    public function carregarPagina($pagina) {

        $setores[] = $this->getPerfis();

                 
/*         echo view('layouts/main_content', ['this->renderSection(content)' => view($pagina)]);
 */        
            echo view('layouts/main_content', ['subcontent' => view($pagina)]);

    }
}
