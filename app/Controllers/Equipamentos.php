<?php

namespace App\Controllers;

use App\Models\EquipamentoModel;
use CodeIgniter\RESTful\ResourceController;

class equipamentos extends ResourceController
{
    private $equipamentomodel;

    public function __construct()
    {
        $this->equipamentomodel = new EquipamentoModel();
       
    }

    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        return redirect()->to('equipamentos/listar');

    }
    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function incluir_equipamento()
    {
        helper('form');
        
        //die(var_dump($data['especialidades']));

        return view('layouts/sub_content', ['view' => 'equipamentos/form_incluir_equipamento']);

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

        //die(var_dump($data));

        $rules = [
            'nome' => 'required|max_length[50]|min_length[3]',
            'qtd' => 'required'
        ];

        if ($this->validate($rules)) {

            $data['nome'] = strtoupper($data['nome']);

            if(!empty($this->equipamentomodel->Where('upper(descricao)', $data['nome'])->find())) {

                session()->setFlashdata('failed', 'Equipamento já cadastrado!');

                return view('layouts/sub_content', ['view' => 'equipamentos/form_incluir_equipamento']);            
            } 

            if((int) $data['qtd'] <= 0) {

                session()->setFlashdata('failed', 'A quantidade disponível deve ser maior que zero!');

                return view('layouts/sub_content', ['view' => 'equipamentos/form_incluir_equipamento']);            
            } 

            $db = \Config\Database::connect('default');
            
            $db->transStart();
            
            try {

                $eqpto['descricao'] = $data['nome'];
                $eqpto['qtd'] = $data['qtd'];
                $eqpto['indsituacao'] = 'A';

                //die(var_dump(($data)));

                $this->equipamentomodel->insert($eqpto);

                if ($db->transStatus() === false) {
                    $error = $db->error();
                    $errorMessage = !empty($error['message']) ? $error['message'] : 'Erro desconhecido';
                    $errorCode = !empty($error['code']) ? $error['code'] : 0;

                    throw new \CodeIgniter\Database\Exceptions\DatabaseException(
                        sprintf('Erro ao incluir eqpto! [%d] %s', $errorCode, $errorMessage)
                    );
                }

                $db->transComplete(); 

                if ($db->transStatus() === false) {
                    $error = $db->error();
                    $errorMessage = !empty($error['message']) ? $error['message'] : 'Erro desconhecido';
                    $errorCode = !empty($error['code']) ? $error['code'] : 0;

                    throw new \CodeIgniter\Database\Exceptions\DatabaseException(
                        sprintf('Erro ao incluir eqpto! [%d] %s', $errorCode, $errorMessage)
                    );
                }

                $this->validator->reset();

                session()->setFlashdata('success', 'Operação concluída com sucesso!');

                return redirect()->to('equipamentos/listar');

            } catch (\Throwable $e) {
                $db->transRollback(); 
                $msg = sprintf('Exception - '.$e->getMessage());
                log_message('error', 'Exception: ' . $msg);
                session()->setFlashdata('exception', $msg);
            }

            session()->setFlashdata('error', $this->validator);

            return view('layouts/sub_content', ['view' => 'equipamentos/form_incluir_equipamento']);

        } else {
            session()->setFlashdata('error', $this->validator);

            return view('layouts/sub_content', ['view' => 'equipamentos/form_incluir_equipamento']);
        }

    }
     /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function editar_equipamento($id = null)
    {

        $eqpto = $this->equipamentomodel->find($id);

        if($eqpto){

            $data['nome'] = $eqpto['descricao'];
            $data['qtd'] = $eqpto['qtd'];
            $data['indsituacao'] = $eqpto['indsituacao'];

            //die(var_dump($data));

            return view('layouts/sub_content', ['view' => 'equipamentos/form_editar_equipamento',
                                                'id' => $eqpto['id'],
                                                'nome' => $eqpto['descricao'],
                                                'qtd' => $eqpto['qtd'],
                                                'indsituacao' => $eqpto['indsituacao'],
                                                'data' => $data]);
        }
        
        session()->setFlashdata('failed', 'eqpto não localizado!');
        
        return redirect()->to('equipamentos/listar');

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

        $data['nome'] = strtoupper($data['nome']);

        if(!empty($this->equipamentomodel->Where('upper(descricao)', $data['nome'])->whereNotIn('id', [$data['id']])->find())) {

            session()->setFlashdata('failed', 'Equipamento já cadastrado!');

            return view('layouts/sub_content', ['view' => 'equipamentos/form_editar_equipamento',
                                            'id' => $data['id'],
                                            'nome' => $data['nome'],
                                            'qtd' => $data['qtd'],
                                            'indsituacao' => $data['indsituacao'],
                                            'data' => $data]);         
        } 

        if((int) $data['qtd'] <= 0) {

            session()->setFlashdata('failed', 'A quantidade disponível deve ser maior que zero!');

            return view('layouts/sub_content', ['view' => 'equipamentos/form_editar_equipamento',
                                            'id' => $data['id'],
                                            'nome' => $data['nome'],
                                            'qtd' => $data['qtd'],
                                            'indsituacao' => $data['indsituacao'],
                                            'data' => $data]);                 
        } 

        try {
            
            $db = \Config\Database::connect('default');

            $db->transStart();

            $eqpto['descricao'] = strtoupper($data['nome']);
            $eqpto['qtd'] = $data['qtd'];
            $eqpto['indsituacao'] = $data['indsituacao'];

            $this->equipamentomodel->update($data['id'], $eqpto);

            if ($db->transStatus() === false) {
                $error = $db->error();
                $errorMessage = isset($error['message']) ? $error['message'] : 'Erro desconhecido';
                $errorCode = isset($error['code']) ? $error['code'] : 0;

                throw new \CodeIgniter\Database\Exceptions\DatabaseException(
                    sprintf('Erro ao atualizar Equipamento! [%d] %s', $errorCode, $errorMessage)
                );
            }

            $db->transComplete();

            session()->setFlashdata('success', 'Alteração do equipamento cirúrgico realizado com sucesso!');

            return redirect()->to('equipamentos/listar');
            
        } catch (\Throwable $e) {
            $db->transRollback();
            $msg = 'Erro na alteração da eqpto';
            if($e->getCode() == 1062) {
                $msg .= ' - Já existe uma eqpto com esse id';
            } else {
                $msg .= ' - '.$e->getMessage();
                log_message('error', $msg.': ' . $e->getMessage());
            }
            session()->setFlashdata('failed', $msg);


            return view('layouts/sub_content', ['view' => 'equipamentos/form_editar_equipamento',
                                                'id' => $data['id'],
                                                'nome' => $data['nome'],
                                                'qtd' => $data['qtd'],
                                                'indsituacao' => $data['indsituacao'],
                                                'data' => $data]);         
        }
    }
    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function excluir($id = null)
    {
      
        $data = $this->equipamentomodel->find($id);
        
        if($data){
            try {
                $this->equipamentomodel->delete($id);

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
        $db = \Config\Database::connect('default');

        $builder = $db->table('equipamentos as eqpto');
        $builder->select('
        eqpto.id,
        eqpto.descricao,
        eqpto.qtd,
        eqpto.indsituacao
        ');
        $builder->whereIn('eqpto.indsituacao', ['A', 'I']);
        $builder->orderBy('eqpto.descricao', 'ASC');

        $equipamentos = $builder->get()->getResult();

        //die(var_dump($equipamentos));

        return view('layouts/sub_content', ['view' => 'equipamentos/list_equipamentos',
                                            'equipamentos' => $equipamentos]);
    }

}
