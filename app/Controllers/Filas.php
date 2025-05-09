<?php

namespace App\Controllers;

use App\Models\FilasModel;
use App\Models\LocalAghEspecialidadesModel;
use CodeIgniter\RESTful\ResourceController;

class Filas extends ResourceController
{
    private $filasmodel;
    private $localaghespecialidadesmodel;
    private $selectespecialidadeaghu;

    public function __construct()
    {
        $this->filasmodel = new FilasModel();
        $this->localaghespecialidadesmodel= new LocalAghEspecialidadesModel();

        $this->selectespecialidadeaghu = $this->localaghespecialidadesmodel->Where('ind_situacao', 'A') 
                                                                           ->orderBy('nome_especialidade', 'ASC')->findAll(); 

    }

    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        return redirect()->to('filas/listar');

    }
    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function incluir_fila()
    {
        helper('form');
        
        $data['especialidades'] = $this->selectespecialidadeaghu;

        //die(var_dump($data['especialidades']));

        return view('layouts/sub_content', ['view' => 'filas/form_incluir_fila',
                                            'data' => $data]);

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
            'especialidade' => 'required'
        ];

        if ($this->validate($rules)) {

            $data['nome'] = strtoupper($data['nome']);

            if(!empty($this->filasmodel->Where('idespecialidade', $data['especialidade'])
                                       ->Where('nmtipoprocedimento', $data['nome'])->find())) {

                session()->setFlashdata('failed', 'Fila já cadastrada!');

                $data['especialidades'] = $this->selectespecialidadeaghu;

                return view('layouts/sub_content', ['view' => 'filas/form_incluir_fila',
                                                    'data' => $data]);            
            } 

            $db = \Config\Database::connect('default');
            
            $db->transStart();
            
            try {

                $fila['nmtipoprocedimento'] = $data['nome'];
                $fila['idespecialidade'] = $data['especialidade'];
                $fila['tipo'] = $data['tipo'];
                $fila['indsituacao'] = 'A';

                //die(var_dump(($data)));

                $this->filasmodel->insert($fila);

                if ($db->transStatus() === false) {
                    $error = $db->error();
                    $errorMessage = !empty($error['message']) ? $error['message'] : 'Erro desconhecido';
                    $errorCode = !empty($error['code']) ? $error['code'] : 0;

                    throw new \CodeIgniter\Database\Exceptions\DatabaseException(
                        sprintf('Erro ao incluir a Fila! [%d] %s', $errorCode, $errorMessage)
                    );
                }

                $db->transComplete(); 

                if ($db->transStatus() === false) {
                    $error = $db->error();
                    $errorMessage = !empty($error['message']) ? $error['message'] : 'Erro desconhecido';
                    $errorCode = !empty($error['code']) ? $error['code'] : 0;

                    throw new \CodeIgniter\Database\Exceptions\DatabaseException(
                        sprintf('Erro ao incluir Fila! [%d] %s', $errorCode, $errorMessage)
                    );
                }

                $this->validator->reset();

                session()->setFlashdata('success', 'Operação concluída com sucesso!');

                return redirect()->to('filas/listar');

            } catch (\Throwable $e) {
                $db->transRollback(); 
                $msg = sprintf('Exception - '.$e->getMessage());
                log_message('error', 'Exception: ' . $msg);
                session()->setFlashdata('exception', $msg);
            }

            session()->setFlashdata('error', $this->validator);

            $data['especialidades'] = $this->selectespecialidadeaghu;

            return view('layouts/sub_content', ['view' => 'filas/form_incluir_fila',
                        'data' => $data]);

        } else {
            session()->setFlashdata('error', $this->validator);

            $data['especialidades'] = $this->selectespecialidadeaghu;

            return view('layouts/sub_content', ['view' => 'filas/form_incluir_fila',
                        'data' => $data]);
        }

    }
     /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function editar_fila($id = null)
    {
       
        //$fila = $this->filasmodel->getWhere(['id' => $id])->getResult();
        $fila = $this->filasmodel->find($id);
        //die(var_dump($fila));

        if($fila){

            $data['especialidades'] = $this->selectespecialidadeaghu;
            $data['especialidade'] = $fila->idespecialidade;
            $data['nome'] = $fila->nmtipoprocedimento;
            $data['tipo'] = $fila->tipo;
            $data['indsituacao'] = $fila->indsituacao;

            //die(var_dump($data));

            return view('layouts/sub_content', ['view' => 'filas/form_editar_fila',
                                                'id' => $fila->id,
                                                'nome' => $fila->nmtipoprocedimento,
                                                'especialidade' => $fila->idespecialidade,
                                                'tipo' => $fila->tipo,
                                                'indsituacao' => $fila->indsituacao,
                                                'data' => $data]);
        }
        
        session()->setFlashdata('failed', 'Fila não localizada!');
        
        return redirect()->to('filas/listar');

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

        //var_dump($data);die();

        if(!empty($this->filasmodel->Where('idespecialidade', $data['especialidade'])
                                   ->Where('nmtipoprocedimento', $data['nome'])
                                   ->whereNotIn('id', [$data['id']])->find())) {


                session()->setFlashdata('failed', 'Fila já cadastrada!');

                $data['especialidades'] = $this->selectespecialidadeaghu;

                $data['especialidades'] = $this->selectespecialidadeaghu;

                return view('layouts/sub_content', ['view' => 'filas/form_editar_fila',
                                                'id' => $data['id'],
                                                'nome' => $data['nome'],
                                                'especialidade' => $data['especialidade'],
                                                'tipo' =>$data['tipo'],
                                                'indsituacao' => $data['indsituacao'],
                                                'data' => $data]);         
        } 

        try {
            
            $db = \Config\Database::connect('default');

            $db->transStart();

            $fila['nmtipoprocedimento'] = strtoupper($data['nome']);
            $fila['idespecialidade'] = $data['especialidade'];
            $fila['tipo'] = $data['tipo'];
            $fila['indsituacao'] = $data['indsituacao'];

            //dd($data['id']);

            $this->filasmodel->update($data['id'], $fila);

            if ($db->transStatus() === false) {
                $error = $db->error();
                $errorMessage = isset($error['message']) ? $error['message'] : 'Erro desconhecido';
                $errorCode = isset($error['code']) ? $error['code'] : 0;

                throw new \CodeIgniter\Database\Exceptions\DatabaseException(
                    sprintf('Erro ao atualizar Fila! [%d] %s', $errorCode, $errorMessage)
                );
            }

            $db->transComplete();

            session()->setFlashdata('success', 'Alteração da Fila realizada com sucesso!');

            return redirect()->to('filas/listar');
            
        } catch (\Throwable $e) {
            $db->transRollback();
            $msg = 'Erro na alteração da Fila';
            if($e->getCode() == 1062) {
                $msg .= ' - Já existe uma Fila com esse id';
            } else {
                $msg .= ' - '.$e->getMessage();
                log_message('error', $msg.': ' . $e->getMessage());
            }
            session()->setFlashdata('failed', $msg);

            $data['especialidades'] = $this->selectespecialidadeaghu;

            return view('layouts/sub_content', ['view' => 'filas/form_editar_fila',
                                                'id' => $data['id'],
                                                'nome' => $data['nome'],
                                                'especialidade' => $data['especialidade'],
                                                'tipo' =>$data['tipo'],
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
      
        $data = $this->filasmodel->find($id);
        
        if($data){
            try {
                $this->filasmodel->delete($id);

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

        $builder = $db->table('tipos_procedimentos as fila');
        $builder->join('local_agh_especialidades as esp', 'esp.seq = fila.idespecialidade', 'inner');
        $builder->select('
        fila.id,
        fila.nmtipoprocedimento as nome,
        esp.nome_especialidade,
        fila.tipo,
        fila.indsituacao
        ');
        $builder->whereIn('fila.indsituacao', ['A', 'I']);
        $builder->orderBy('esp.nome_especialidade, fila.nmtipoprocedimento', 'ASC');

        $filas = $builder->get()->getResult();

        //die(var_dump($filas));

        return view('layouts/sub_content', ['view' => 'filas/list_filas',
                                            'filas' => $filas]);
    }
    /**
     * 
     * @return mixed
     */
    public function migrarFilas() {

        $filasmodel = new FilasModel();

        try {

            $db = \Config\Database::connect('default');

            $sqlTruncate = "truncate tipos_procedimentos RESTART IDENTITY;";
            $sqlDropDefault = "ALTER TABLE tipos_procedimentos ALTER COLUMN id DROP DEFAULT;";
            $sqlSetVal = "SELECT setval('tipos_procedimentos_seq', (SELECT MAX(id) FROM tipos_procedimentos tp));";
            $sqlSetDefault = "ALTER TABLE tipos_procedimentos ALTER COLUMN id SET DEFAULT nextval('tipos_procedimentos_seq');";

            $sql = "
                SELECT
                    tp.codigo,
                    tp.descricao,
                    tp.especialidade,
                    tp.ind_situacao
                FROM cirurgias_tiposprocedimentos tp
                ;";

            $query = $db->query($sql);

            $result = $query->getResult();

            $query = $db->query($sqlTruncate);

            $query = $db->query($sqlDropDefault);

            $db->transStart();

            foreach ($result as $reg) {

                $fila = [];

                $fila['id'] = $reg->codigo;
                $fila['codigo'] = $reg->codigo;
                $fila['nmtipoprocedimento'] = $reg->descricao;
                $fila['idespecialidade'] = $reg->especialidade;
                $fila['indsituacao'] = $reg->ind_situacao;

                $filasmodel->insert($fila);

                if ($db->transStatus() === false) {
                    $error = $db->error();
                    $errorMessage = isset($error['message']) ? $error['message'] : 'Erro desconhecido';
                    $errorCode = isset($error['code']) ? $error['code'] : 0;

                    throw new \CodeIgniter\Database\Exceptions\DatabaseException(
                        sprintf('Erro ao incluir fila! [%d] %s', $errorCode, $errorMessage)
                    );
                }

            }

            $db->transComplete();

            if ($db->transStatus() === false) {
                $error = $db->error();
                $errorMessage = isset($error['message']) ? $error['message'] : 'Erro desconhecido';
                $errorCode = isset($error['code']) ? $error['code'] : 0;

                throw new \CodeIgniter\Database\Exceptions\DatabaseException(
                    sprintf('Erro na criação da tabelas de filas! [%d] %s', $errorCode, $errorMessage)
                );
            }

            $query = $db->query($sqlSetVal);

            $query = $db->query($sqlSetDefault);

        } catch (\Throwable $e) {
            $msg = 'Falha na criação da tabela de filas ==> '.$e->getMessage();
            log_message('error', $msg.': ' . $e->getMessage());
            throw $e;
        }

    }

}
