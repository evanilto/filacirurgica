<?php

namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;
use App\Libraries\HUAP_Functions;
use App\Models\ListaEsperaModel;
use App\Models\VwListaEsperaModel;
use App\Models\MapaCirurgicoModel;
use App\Models\FilaModel;
use App\Models\RiscoModel;
use App\Models\OrigemPacienteModel;
use App\Models\LateralidadeModel;
use App\Models\PosOperatorioModel;
use DateTime;
use CodeIgniter\Config\Services;
use Config\Database;
use CodeIgniter\Database\Exceptions\DatabaseException;



class ListaEspera extends ResourceController
{
    private $listaesperamodel;
    private $vwlistaesperamodel;
    private $mapacirurgicomodel;
    private $filamodel;
    private $riscomodel;
    private $origempacientemodel;
    private $lateralidademodel;
    private $posoperatoriomodel;
    private $usuariocontroller;
    private $aghucontroller;
    private $selectfila;
    private $selectrisco;
    private $selectespecialidade;
    private $selectespecialidadeaghu;
    private $selectcids;
    private $selectitensprocedhospit;
    private $selectorigempaciente;
    private $selectlateralidade;
    private $selectposoperatorio;


    public function __construct()
    {
        $this->listaesperamodel = new ListaEsperaModel();
        $this->vwlistaesperamodel = new VwListaEsperaModel();
        $this->mapacirurgicomodel = new MapaCirurgicoModel();
        $this->filamodel = new FilaModel();
        $this->riscomodel = new RiscoModel();
        $this->origempacientemodel = new OrigemPacienteModel();
        $this->lateralidademodel = new LateralidadeModel();
        $this->posoperatoriomodel = new PosOperatorioModel;
        $this->usuariocontroller = new Usuarios();
        $this->aghucontroller = new Aghu();

        $this->selectfila = $this->filamodel->Where('indsituacao', 'A')->orderBy('nmtipoprocedimento', 'ASC')->findAll();
        $this->selectrisco = $this->riscomodel->Where('indsituacao', 'A')->orderBy('nmrisco', 'ASC')->findAll();
        $this->selectorigempaciente = $this->origempacientemodel->Where('indsituacao', 'A')->orderBy('nmorigem', 'ASC')->findAll();
        $this->selectlateralidade = $this->lateralidademodel->Where('indsituacao', 'A')->orderBy('id', 'ASC')->findAll();
        $this->selectposoperatorio = $this->posoperatoriomodel->Where('indsituacao', 'A')->orderBy('id', 'ASC')->findAll();
        $this->selectespecialidade = $this->listaesperamodel->distinct()->select('idespecialidade')->findAll();
        $this->selectespecialidadeaghu = $this->aghucontroller->getEspecialidades($this->selectespecialidade);
        $this->selectcids = $this->aghucontroller->getCIDs();
        $this->selectitensprocedhospit = $this->aghucontroller->getItensProcedimentosHospitalares();
    }

    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
    }
    /**
     * 
     *
     * @return mixed
     */
    public function getFirst() {
        
        return $this->listaesperamodel->orderBy('created_at', 'ASC')->first();;
    }
     /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function getDetailsAside($numProntuario)
    {
        // Pegue o registro pelos $id e passe os dados para a view
        $data = [
            'paciente' => $this->aghucontroller->getDetalhesPaciente($numProntuario)
        ];

        //die(var_dump($data));

        return view('listaespera/exibe_paciente', $data);
    }
    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function getNomePaciente($numProntuario)
{
    $paciente = $this->aghucontroller->getPaciente($numProntuario);

    if ($paciente && isset($paciente[0]->nome)) {
        return $this->response->setJSON(['nome' => $paciente[0]->nome]);
    }

    return $this->response->setJSON(['error' => 'Paciente não encontrado na base do AGHU'], 404);
}

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function consultarListaEspera(string $idlistaespera = null)
    {
        HUAP_Functions::limpa_msgs_flash();

        $data['dtinicio'] = date('d/m/Y', strtotime($this->getFirst()['created_at']));
        $data['dtfim'] = date('d/m/Y');
        /* $data['filas'] = $this->filamodel->Where('indsituacao', 'A')->orderBy('nmtipoprocedimento', 'ASC')->findAll();
        $data['riscos'] = $this->riscomodel->Where('indsituacao', 'A')->orderBy('nmrisco', 'ASC')->findAll();
        $especialidades = $this->listaesperamodel->distinct()->select('idespecialidade')->findAll();
        $data['especialidades'] = $this->aghucontroller->getEspecialidades($especialidades);
        $data['origens'] = $this->origempacientemodel->Where('indsituacao', 'A')->orderBy('nmorigem', 'ASC')->findAll(); */

        $data['filas'] = $this->selectfila;
        $data['riscos'] = $this->selectrisco;
        $data['origens'] = $this->selectorigempaciente;
        $data['especialidades'] = $this->selectespecialidadeaghu;

        //die(var_dump($data));

        return view('layouts/sub_content', ['view' => 'listaespera/form_consulta_listaespera',
                                            'data' => $data]);

    }
    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function exibirListaEspera()
    {        
        helper(['form', 'url', 'session']);

        \Config\Services::session();

        $prontuario = null;

        $data = $this->request->getVar();

        //die(var_dump($data));

        if(!empty($data['prontuario']) && is_numeric($data['prontuario'])) {
            $resultAGHUX = $this->aghucontroller->getPaciente($data['prontuario']);

            if(!empty($resultAGHUX[0])) {
                $prontuario = $data['prontuario'];
            }
        }

        $rules = [
            'dtinicio' => 'required|valid_date[d/m/Y]',
            'dtfim' => 'required|valid_date[d/m/Y]',
            'prontuario' => 'permit_empty|min_length[1]|max_length[8]|equals['.$prontuario.']',
            'nome' => 'permit_empty|min_length[3]',
        ];

        if ($this->validate($rules)) {

            if (DateTime::createFromFormat('d/m/Y', $data['dtfim'])->format('Y-m-d') < DateTime::createFromFormat('d/m/Y', $data['dtinicio'])->format('Y-m-d')) {
                $this->validator->setError('dtinicio', 'A data de início não pode ser maior que a data final!');

                session()->setFlashdata('warning_message', 'Nenhum paciente da Lista localizado com os parâmetros informados!');
                return view('layouts/sub_content', ['view' => 'listaespera/form_consulta_listaespera',
                                                    'validation' => $this->validator,
                                                    'data' => $data]);
            }
            
            $this->validator->reset();

            $horaAtual = date('H:i:s');
            $data['dtfim'] = $data['dtfim'] . ' ' . $horaAtual;

            $result = $this->getListaEspera($data);

            if (empty($result)) {

                $data['filas'] = $this->filamodel->Where('indsituacao', 'A')->orderBy('nmtipoprocedimento', 'ASC')->findAll();
                $data['riscos'] = $this->riscomodel->Where('indsituacao', 'A')->orderBy('nmrisco', 'ASC')->findAll();
                $data['especialidades'] = $this->aghucontroller->getEspecialidades();

                session()->setFlashdata('warning_message', 'Nenhum paciente da Lista localizado com os parâmetros informados!');
                return view('layouts/sub_content', ['view' => 'listaespera/form_consulta_listaespera',
                                                    'validation' => $this->validator,
                                                    'data' => $data]);
            
            }

            //die(var_dump($result));

            return view('layouts/sub_content', ['view' => 'listaespera/list_listaespera',
                                               'listaespera' => $result,
                                               'data' => $data]);

        } else {
            if(isset($resultAGHUX) && empty($resultAGHUX)) {
                $this->validator->setError('prontuario', 'Esse prontuário não existe na base do AGHUX!');
            }
            
            $data['filas'] = $this->filamodel->Where('indsituacao', 'A')->orderBy('nmtipoprocedimento', 'ASC')->findAll();
            $data['riscos'] = $this->riscomodel->Where('indsituacao', 'A')->orderBy('nmrisco', 'ASC')->findAll();
            $data['especialidades'] = $this->aghucontroller->getEspecialidades();

            return view('layouts/sub_content', ['view' => 'listaespera/form_consulta_listaespera',
                                                'validation' => $this->validator,
                                                'data' => $data]);
        }
    }
    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function getListaEspera ($data) 
    {
        //die(var_dump($data));

        $db = \Config\Database::connect('default');

        $builder = $db->table('vw_listaespera');

        //$clausula_where = " created_at BETWEEN $dt_ini AND $dt_fim";
        $builder->where("created_at BETWEEN '$data[dtinicio]' AND '$data[dtfim]'");

        if (!empty($data['prontuario'])) {
            //$clausula_where .= " AND prontuario = $data[prontuario]";
            $builder->where('prontuario', $data['prontuario']);
        };
        if (!empty($data['nome'])) {
            //$clausula_where .= " AND  nome_paciente LIKE '%".strtoupper($data['nome'])."%'";
            $builder->where('nome_paciente LIKE', '%'.strtoupper($data['nome']).'%');
        };
        if (!empty($data['especialidade'])) {
            //$clausula_where .= " AND  idespecialidade = $data[especialidade]";
            $builder->where('idespecialidade', $data['especialidade']);
        };
        if (!empty($data['fila'])) {
            //$clausula_where .= " AND  idtipoprocedimento = $data[fila]";
            $builder->where('idtipoprocedimento', $data['fila']);
        };
        if (!empty($data['risco'])) {
            //$clausula_where .= " AND  idrisco = $data[risco]";
            $builder->where('idriscocirurgico',  $data['risco']);
        };
        if (!empty($data['complexidades'])) {
            //$clausula_where .= " AND  idrisco = $data[risco]";
            $builder->whereIn('complexidade',  $data['complexidades']);
        };

        //var_dump($builder->getCompiledSelect());die();

        return $builder->get()->getResult();
    }
    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function getPacienteNaLista ($data) 
    {
        //die(var_dump($data));

        $db = \Config\Database::connect('default');

        $builder = $db->table('lista_espera');

        $builder->where('numprontuario', $data['prontuario']);
        $builder->where('idespecialidade', $data['especialidade']);
        $builder->where('idtipoprocedimento', $data['fila']);
        $builder->where('idprocedimento', $data['procedimento']);
        //$builder->where('nmlateralidade', $data['lateralidade']);

        //var_dump($builder->getCompiledSelect());die();

        return $builder->get()->getResult();
    }
    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function incluirPacienteNaLista(string $idlistaespera = null)
    {
        HUAP_Functions::limpa_msgs_flash();

        $data['dtinclusao'] = date('d/m/Y H:i:s');
        $data['filas'] = $this->selectfila;
        $data['riscos'] = $this->selectrisco;
        $data['origens'] = $this->selectorigempaciente;
        $data['lateralidades'] = $this->selectlateralidade;
        $data['especialidades'] = $this->selectespecialidadeaghu;
        $data['cids'] = $this->selectcids;
        $data['procedimentos'] = $this->selectitensprocedhospit;

        //die(var_dump($data));

        return view('layouts/sub_content', ['view' => 'listaespera/form_inclui_paciente_listaespera',
                                            'data' => $data]);

    }
/**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function incluir()
    {

        helper(['form', 'url', 'session']);

        helper('array');

        \Config\Services::session();

        $prontuario = null;

        $data = $this->request->getVar();

        //die(var_dump($data));

        if(!empty($data['prontuario']) && is_numeric($data['prontuario'])) {
            $resultAGHUX = $this->aghucontroller->getPaciente($data['prontuario']);

            if(!empty($resultAGHUX[0])) {
                $prontuario = $data['prontuario'];
            }
        }

        $dataform['dtinclusao'] = date('d/m/Y H:i:s');
        $dataform['dtrisco'] = null;
        $dataform['filas'] = $this->selectfila;
        $dataform['riscos'] = $this->selectrisco;
        $dataform['origens'] = $this->selectorigempaciente;
        $dataform['lateralidades'] = $this->selectlateralidade;
        $dataform['especialidades'] = $this->selectespecialidadeaghu;
        $dataform['cids'] = $this->selectcids;
        $dataform['procedimentos'] = $this->selectitensprocedhospit;

        //die(var_dump($dataform['lateralidade']));

        $rules = [
            'especialidade' => 'required',
            'dtrisco' => 'permit_empty|valid_date[d/m/Y]',
            'prontuario' => 'required|min_length[1]|max_length[12]|equals['.$prontuario.']',
            'fila' => 'required',
            'procedimento' => 'required',
            'origem' => 'required',
            'lateralidade' => 'required',
            'justorig' => 'max_length[250]|min_length[0]',
            'info' => 'max_length[250]|min_length[0]',
        ];

        if ($this->validate($rules)) {

            $this->validator->reset();

            if(isset($resultAGHUX) && empty($resultAGHUX)) {
                $this->validator->setError('prontuario', 'Esse prontuário não existe na base do AGHUX!');
            } else {
                if ($this->getPacienteNaLista($data)) {
                    session()->setFlashdata('failed', 'Paciente já tem cirurgia cadastrada na mesma especialidade, fila e procedimento!');
                } else {

                    $db = \Config\Database::connect('default');

                    $db->transStart();

                    try {

                        $paciente = [
                            'numprontuario' => $data['prontuario'],
                            'idespecialidade' => $data['especialidade'],
                            'idriscocirurgico' => empty($data['risco']) ? NULL : $data['risco'],
                            'dtavaliacao' => empty($data['dtrisco']) ? NULL : $data['dtrisco'],
                            'numcid' => empty($data['cid']) ? NULL : $data['cid'],
                            'nmcomplexidade' => $data['complexidade'],
                            'idtipoprocedimento' => $data['fila'],
                            'idorigempaciente' => $data['origem'],
                            'indcongelacao' => $data['congelacao'],
                            'idprocedimento' => $data['procedimento'],
                            'nmlateralidade' => $data['lateralidade'],
                            /* 'indsituacao' => 'A', */
                            'txtinfoadicionais' => $data['info'],
                            'txtorigemjustificativa' => $data['justorig']
                        ];
                        
                        $this->listaesperamodel->insert($paciente);

                        $db->transComplete();

                        if ($db->transStatus() === false) {
                            $error = $db->error();
                            $errorMessage = isset($error['message']) ? $error['message'] : 'Erro desconhecido';
                            $errorCode = isset($error['code']) ? $error['code'] : 0;

                            throw new \CodeIgniter\Database\Exceptions\DatabaseException(
                                sprintf('Erro ao incluir um paciente da Lista! [%d] %s', $errorCode, $errorMessage)
                            );
                        }

                        session()->setFlashdata('success', 'Paciente incluído da Lista de Espera com sucesso!');

                        return view('layouts/sub_content', ['view' => 'listaespera/form_inclui_paciente_listaespera',
                                                            'data' => $dataform]);     

                    /*  $response = service('response');
                        $response->setHeader('Cache-Control', 'no-cache, no-store, must-revalidate'); // HTTP 1.1.
                        $response->setHeader('Pragma', 'no-cache'); // HTTP 1.0.
                        $response->setHeader('Expires', '0'); // Proxies.
                                                            
                        $data_le['prontuario'] = $data['prontuario'];
                        $data_le['dtinicio'] = date('Y-m-d');
                        $data_le['dtfim'] = date('Y-m-d') . ' ' .date('H:i:s');
                
                        return view('layouts/sub_content', ['view' => 'listaespera/list_listaespera',
                                                            'listaespera' => $this->getListaEspera($data_le),
                                                            'data' => $data_le]); */

                    } catch (\CodeIgniter\Database\Exceptions\DataException $e) {
                        $errorMessage = $e->getMessage();
                        $errorCode = $e->getCode();
                        
                        throw new \CodeIgniter\Database\Exceptions\DataException(
                            sprintf('Erro ao incluir um paciente da Lista! [%d] %s', (int) $errorCode, $errorMessage), (int) $errorCode, $e);

                    } catch (\CodeIgniter\Database\Exceptions\DatabaseException $databaseException) {
                        throw new \CodeIgniter\Database\Exceptions\DataException('Erro de DatabaseException: ' . $databaseException->getMessage());

                    } catch (\CodeIgniter\Database\Exceptions\DataException $databaseException) {
                        throw new \CodeIgniter\Database\Exceptions\DataException('Erro de DataException: ' . $databaseException->getMessage());

                    } catch (\Exception $e) {
                        throw new \Exception('Erro de Exception: ' . $e->getMessage());
                    }
                }
            }
        } 

        //die(var_dump($this->validator));

        if(isset($resultAGHUX) && empty($resultAGHUX)) {
            //die(var_dump($this->validator));
            $this->validator->setError('prontuario', 'Esse prontuário não existe na base do AGHUX!');
        }

       /*  if ($this->validator->hasError('procedimento')) {
            die(var_dump($this->validator->getError('procedimento')));
        } */
              
        return view('layouts/sub_content', ['view' => 'listaespera/form_inclui_paciente_listaespera',
                                            'validation' => $this->validator,
                                            'data' => $dataform]);
    }
    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function editarLista(int $id)
    {
        HUAP_Functions::limpa_msgs_flash();

        //$data = $this->request->getVar();

        $lista = $this->listaesperamodel->find($id);

        //die(var_dump($lista['id']));

        $data = [];
        $data['id'] = $lista['id'];
        $data['dtinclusao'] = DateTime::createFromFormat('Y-m-d H:i:s', $lista['created_at'])->format('d/m/Y H:i');
        $data['prontuario'] = $lista['numprontuario'];
        $data['especialidade'] = $lista['idespecialidade'];
        $data['risco'] = $lista['idriscocirurgico'];
        $data['dtrisco'] = $lista['dtavaliacao'] ? DateTime::createFromFormat('Y-m-d', $lista['dtavaliacao'])->format('d/m/Y') : NULL;
        $data['cid'] = $lista['numcid'];
        $data['complexidade'] = $lista['nmcomplexidade'];
        $data['fila'] = $lista['idtipoprocedimento'];
        $data['origem'] = $lista['idorigempaciente'];
        $data['congelacao'] = $lista['indcongelacao'];
        $data['procedimento'] = $lista['idprocedimento'];
        $data['lateralidade'] = $lista['nmlateralidade'];
        $data['info'] = $lista['txtinfoadicionais'];
        $data['justorig'] = $lista['txtorigemjustificativa'];
        $data['filas'] = $this->selectfila;
        $data['riscos'] = $this->selectrisco;
        $data['origens'] = $this->selectorigempaciente;
        $data['lateralidades'] = $this->selectlateralidade;
        $data['especialidades'] = $this->selectespecialidadeaghu;
        $data['cids'] = $this->selectcids;
        $data['procedimentos'] = $this->selectitensprocedhospit;

        //var_dump($data['id']);die();

        return view('layouts/sub_content', ['view' => 'listaespera/form_edita_listaespera',
                                            'data' => $data]);

    }
    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function editar()
    {
        \Config\Services::session();

        helper(['form', 'url', 'session']);

        $data = $this->request->getVar();

        //die(var_dump($data));

        $rules = [
            'especialidade' => 'required',
            'dtrisco' => 'permit_empty|valid_date[d/m/Y]',
            'fila' => 'required',
            'procedimento' => 'required',
            'origem' => 'required',
            'lateralidade' => 'required',
            'justorig' => 'max_length[250]|min_length[0]',
            'info' => 'max_length[250]|min_length[0]',
        ];

        if ($this->validate($rules)) {

            try {

                $lista = [
                        'idespecialidade' => $data['especialidade'],
                        'idriscocirurgico' => empty($data['risco']) ? NULL : $data['risco'],
                        'dtavaliacao' => empty($data['dtrisco']) ? NULL : $data['dtrisco'],
                        'numcid' => empty($data['cid']) ? NULL : $data['cid'],
                        'nmcomplexidade' => $data['complexidade'],
                        'idtipoprocedimento' => $data['fila'],
                        'idorigempaciente' => $data['origem'],
                        'indcongelacao' => $data['congelacao'],
                        'idprocedimento' => $data['procedimento'],
                        'nmlateralidade' => $data['lateralidade'],
                        'txtinfoadicionais' => $data['info'],
                        'txtorigemjustificativa' => $data['justorig']
                        ];

                $this->listaesperamodel->update($data['id'], $lista);

                if ($this->vwlistaesperamodel->affectedRows() > 0) {
                    session()->setFlashdata('success', 'Operação concluída com sucesso!');
                    
                } else {
                    session()->setFlashdata('nochange', 'Sem dados para atualizar!');
                }

                $this->validator->reset();
                
            } catch (\Exception $e) {
                $msg = sprintf('Exception - Falha na alteração da Lista - prontuário: %d - cod: (%d) msg: %s', (int) $data['prontuario'], (int) $e->getCode(), $e->getMessage());
                log_message('error', 'Exception: ' . $msg);
                session()->setFlashdata('exception', $msg);
            } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
                $msg = sprintf('DatabaseException - Falha na alteração da Lista - prontuário: %d - cod: (%d) msg: %s', (int) $data['prontuario'], (int) $e->getCode(), $e->getMessage());
                log_message('error', 'Exception: ' . $msg);
                session()->setFlashdata('exception', $msg);
            } catch (\CodeIgniter\Database\Exceptions\DataException $e) {
                $msg = sprintf('DataException - Falha na alteração da Lista - prontuário: %d - cod: (%d) msg: %s', (int) $data['prontuario'], (int) $e->getCode(), $e->getMessage());
                log_message('error', 'Exception: ' . $msg);
                session()->setFlashdata('exception', $msg);
            }

            $data['filas'] = $this->selectfila;
            $data['riscos'] = $this->selectrisco;
            $data['origens'] = $this->selectorigempaciente;
            $data['lateralidades'] = $this->selectlateralidade;
            $data['especialidades'] = $this->selectespecialidadeaghu;
            $data['cids'] = $this->selectcids;
            $data['procedimentos'] = $this->selectitensprocedhospit;

            return view('layouts/sub_content', ['view' => 'listaespera/form_edita_listaespera',
                                                'data' => $data]);
        } else {
            session()->setFlashdata('error', $this->validator);

            $data['filas'] = $this->selectfila;
            $data['riscos'] = $this->selectrisco;
            $data['origens'] = $this->selectorigempaciente;
            $data['lateralidades'] = $this->selectlateralidade;
            $data['especialidades'] = $this->selectespecialidadeaghu;
            $data['cids'] = $this->selectcids;
            $data['procedimentos'] = $this->selectitensprocedhospit;

            //die(var_dump($data));

            return view('layouts/sub_content', ['view' => 'listaespera/form_edita_listaespera',
                                                'data' => $data]);
        }
    }
    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function criar_volume(int $id)
    {

        $ListaEsperaAME = $this->vwlistaesperamodel->getWhere(['id' => $id])->getResult();

        $numVolume = $ListaEsperaAME[0]->numVolume ?? 0;

        try {

            if ($numVolume == 0) {
                $array['numVolume'] = ++$numVolume ;
                $this->vwlistaesperamodel->update($id, $array);
            }

            $ListaEsperaame['numProntuarioAGHU'] = $ListaEsperaAME[0]->numProntuarioAGHU;
            $ListaEsperaame['numProntuarioMV'] = $ListaEsperaAME[0]->numProntuarioMV;
            $ListaEsperaame['numVolume'] = ++$numVolume;

            $this->vwlistaesperamodel->insert($ListaEsperaame);
            
        } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
            $msg = 'Erro na criação do volume';
            $msg .= ' - '.$e->getMessage();
            log_message('error', $msg.': ' . $e->getMessage());
            session()->setFlashdata('failed', $msg);
        }

        $result = $this->getListaEspera($ListaEsperaAME[0]->numProntuarioAGHU);

        if ($result[0]->numProntuarioMV) { 
            $resultMV = $this->pacientesmvcontroller->getPacientePorCdPaciente($result[0]->numProntuarioMV);
        }

        $listaespera = [];

        foreach ($result as $key => $ListaEsperaame) {
            $listaespera[$key]['id'] = $ListaEsperaame->id;
            $listaespera[$key]['numProntuarioAGHU'] = $ListaEsperaame->numProntuarioAGHU;
            $listaespera[$key]['numProntuarioMV'] = $ListaEsperaame->numProntuarioMV;
            $listaespera[$key]['numVolume'] = $ListaEsperaame->numVolume;
            $listaespera[$key]['numArmario'] = $ListaEsperaame->numArmario;
            $listaespera[$key]['numSala'] = $ListaEsperaame->numSala;
            $listaespera[$key]['numLinha'] = $ListaEsperaame->numLinha;
            $listaespera[$key]['numColuna'] = $ListaEsperaame->numColuna;
            $listaespera[$key]['txtObs'] = $ListaEsperaame->txtObs;
            $listaespera[$key]['nmSetorAtual'] = $ListaEsperaame->nmSetorAtual;

            $resultAGHU = $this->aghucontroller->getPaciente($ListaEsperaame->numProntuarioAGHU);
            $listaespera[$key]['nmPaciente'] = $resultAGHU[0]->nome;
            $listaespera[$key]['nmMae'] = $resultAGHU[0]->nome_mae;
            $listaespera[$key]['dtNascimento'] = $resultAGHU[0]->dt_nascimento;

            $listaespera[$key]['ultimoVolume'] = count($result) == ($ListaEsperaame->numVolume ?? 1);

            if ($ListaEsperaame->numProntuarioMV && (!$ListaEsperaame->numVolume || $ListaEsperaame->numVolume == 1)) { 
                $listaespera[$key]['txtObs'] = ($resultMV[0]->DS_OBSERVACAO ? 'Obs. MV => '.$resultMV[0]->DS_OBSERVACAO.'<br>' : '').$ListaEsperaame->txtObs;
            } else {
                $listaespera[$key]['txtObs'] = $ListaEsperaame->txtObs;
            }
        }

        //var_dump($ListaEsperaAME);die();

        //return view('ListaEspera/listar_ListaEspera', ['ListaEspera' => $listaespera]);
        return view('layouts/sub_content', ['view' => 'ListaEspera/list_ListaEspera', 'ListaEspera' => $listaespera]);

                       
    }
    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function excluirPacienteDaLista(int $id)
    {
        $data = session()->get('parametros_consulta_lista');
        session()->remove('parametros_consulta_lista');

        //die(var_dump($data));

        $db = \Config\Database::connect('default');

        $db->transStart();

        try {
            $this->listaesperamodel->delete(['id' => $id]);
    
            $db->transComplete(); // Completa a transação
    
            if ($db->transStatus() === false) {
                throw new \CodeIgniter\Database\Exceptions\DatabaseException('Erro ao excluir um paciente da Lista!');
            }
    
        } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
            $db->transRollback(); // Reverte a transação em caso de erro
            $msg = 'Erro na exclusão do paciente da Lista';
            $msg .= ' - '.$e->getMessage();
            log_message('error', $msg.': ' . $e->getMessage());
            session()->setFlashdata('failed', $msg);
        }

        session()->setFlashdata('success', 'Paciente excluído da Lista de Espera com sucesso!');

        $result = $this->getListaEspera($data);

        return view('layouts/sub_content', ['view' => 'listaespera/list_listaespera',
                                            'listaespera' => $result,
                                            'data' => $data]);

       //$client = Services::curlrequest();
        
        //$response = $client->request('POST', base_url('listaespera/exibir'), ['data' => $data]);
        
        // Obter o corpo da resposta
        //$resposta = $response->getBody();

  
    }
    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function enviarMapa(int $id)
    {
       
        HUAP_Functions::limpa_msgs_flash();

        $lista = $this->listaesperamodel->find($id);

        $data = [];
        $data['id'] = $lista['id'];
        $data['dtcirurgia'] = date('d/m/Y H:i', strtotime('+3 days'));
        $data['prontuario'] = $lista['numprontuario'];
        $data['especialidade'] = $lista['idespecialidade'];
        $data['risco'] = $lista['idriscocirurgico'];
        $data['dtrisco'] = $lista['dtavaliacao'] ? DateTime::createFromFormat('Y-m-d', $lista['dtavaliacao'])->format('d/m/Y') : NULL;
        $data['cid'] = $lista['numcid'];
        $data['complexidade'] = $lista['nmcomplexidade'];
        $data['fila'] = $lista['idtipoprocedimento'];
        $data['origem'] = $lista['idorigempaciente'];
        $data['congelacao'] = $lista['indcongelacao'];
        $data['procedimento'] = $lista['idprocedimento'];
        $data['proced_adic'] = [];
        $data['lateralidade'] = $lista['nmlateralidade'];
        $data['posoperatorio'] = null;
        $data['info'] = $lista['txtinfoadicionais'];
        $data['nec_proced'] = '';
        $data['justorig'] = $lista['txtorigemjustificativa'];
        $data['justenvio'] = '';
        $data['filas'] = $this->selectfila;
        $data['riscos'] = $this->selectrisco;
        $data['origens'] = $this->selectorigempaciente;
        $data['lateralidades'] = $this->selectlateralidade;
        $data['posoperatorios'] = $this->selectposoperatorio;
        $data['especialidades'] = $this->selectespecialidadeaghu;
        $data['cids'] = $this->selectcids;
        $data['procedimentos'] = $this->selectitensprocedhospit;

        $codToRemove = $lista['idprocedimento'];
        $procedimentos = $data['procedimentos'];

        //var_dump($codToRemove);die();

        $data['procedimentos_adicionais'] = array_filter($procedimentos, function($procedimento) use ($codToRemove) {
            return $procedimento->cod_tabela !== $codToRemove;
        });

        $data['equipe'] = [];

        $data['equipes'] = [
            (object) ['cod_tabela' => 1, 'descricao' => 'Procedimento 1', 'categoria' => 'Categoria A'],
            (object) ['cod_tabela' => 2, 'descricao' => 'Procedimento 2', 'categoria' => 'Categoria B'],
            (object) ['cod_tabela' => 3, 'descricao' => 'Procedimento 3', 'categoria' => 'Categoria A']
        ];

        $data['filtros'] = ['Categoria A', 'Categoria B', 'Categoria C'];


        //var_dump($data['procedimentos']);die();

        return view('layouts/sub_content', ['view' => 'mapacirurgico/form_envia_mapacirurgico',
                                            'data' => $data]);
    }
    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function tramitarProntuario(int $idlistaespera = null, int $nuvolume = null)
    {
        HUAP_Functions::limpa_msgs_flash();

        return view('ListaEspera/tramitar_listaespera',  ['idlistaespera' => $idlistaespera,
                                                         'nuvolume' => $nuvolume,
                                                         'dtretorno' => date('d-m-Y', strtotime('+3 days')),
                                                         'select' => $this->setorcontroller->select]);

    }
    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function tramitar()
    {        
        helper(['form', 'url', 'session']);

        \Config\Services::session();

        //var_dump($this->request->getPost('listaespera'));die();
       
        $listaespera = '';
        $volume = '100';

        //$perfil_same = true;

        $data = $this->request->getVar();

        //var_dump($data);die;

        if(!empty($data['listaespera']) && is_numeric($data['listaespera'])) {
            $resultAGHUX = $this->aghucontroller->getPaciente($data['listaespera']);

            if(!empty($resultAGHUX[0])) {
                $listaespera = $data['listaespera'];

                $resultSAME = $this->getUltimoVolume($data['listaespera']);

                if((empty($resultSAME) || empty($resultSAME['numVolume']) && (int)$data['volume'] === 0) || ((int)$data['volume'] > 0  && ((int)$resultSAME['numVolume'] >= (int)$data['volume']))) {
                    $volume = $data['volume'];
                }
            }
        }

        $rules = [
            'listaespera' => 'required|max_length[8]|numeric|equals['.$listaespera.']',
            'volume' => 'max_length[2]|equals['.$volume.']',
            'dtretorno' => 'required|valid_date[d/m/Y]',
        ];

        if ($this->validate($rules)) {

            //var_dump(HUAP_Functions::permite_tramitar($data['Setor']));die;

            //if (!HUAP_Functions::permite_tramitar($data['Setor'])) {
               // $this->validator->setError('Setor', 'Esse prontuário já está localizado no setor destino!');
           // } else {
                if(DateTime::createFromFormat('d/m/Y', $data['dtretorno'])->format('Y-m-d') < date('Y-m-d')) {
                    $this->validator->setError('dtretorno', 'A previsão de retorno não pode ser menor que a data atual!');
                } else {
                    if(DateTime::createFromFormat('d/m/Y', $data['dtretorno'])->format('Y-m-d') > date('Y-m-d', strtotime('+3 days'))) {
                        $this->validator->setError('dtretorno', 'A previsão de retorno não pode ser maior que 3 dias a partir da data atual!');
                    } else {

                        $this->validator->reset();

                        $data['dtretorno'] = DateTime::createFromFormat('d/m/Y', $data['dtretorno'])->format('Y-m-d H:i:s');
            
                        //var_dump($data);die();
            
                        $this->envia_listaespera($data);
            
                        return redirect()->to(base_url('ListaEspera/historico/'.$listaespera.'/'.$volume));
                    }
                }
           // }
            return view('ListaEspera/tramitar_listaespera', ['validation' => $this->validator,
                                                            'dtretorno' => $data['dtretorno'],
                                                            'select' => $this->setorcontroller->select]);
        } else {

            if(isset($resultAGHUX) && empty($resultAGHUX)) {
                $this->validator->setError('listaespera', 'Prontuário não existe no AGHUX!');
            }

            if($volume === '100') {
                $this->validator->setError('volume', 'Volume sem correspondência!');
            }

            if (!HUAP_Functions::DataValida($data['dtretorno'], 'd/m/Y')) {
                $this->validator->setError('dtretorno', 'Data inválida!');
            }

            return view('ListaEspera/tramitar_listaespera', ['validation' => $this->validator,
                                                                'dtretorno' => $data['dtretorno'],
                                                                'select' => $this->setorcontroller->select]);
        }

    }
     /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function envia_listaespera($data) {

        $setor_user = $_SESSION['Sessao']['nmSetor'];

        $busca_hist_ant = ['SSGH'];
        //$busca_hist_ant = [];

        $local = $this->getUltimaLocalizacao($data['listaespera'], $data['volume'], $busca_hist_ant);

        //die(var_dump($local));
        if ($local && $local[0]['mov_origem'] != 'same' && $local[0]['tramite']) {
            $local = null;
        }
        
        if (empty($local)) {
            $ult_loc = null;
            $listaespera_movimentado = false;
            $setororigem = $setor_user;
            $resgatador = (int)$_SESSION['Sessao']['id'];
        } else {
            $listaespera_movimentado = true;
            $ult_loc = $local[0];
            $setororigem = $ult_loc['setor'];
            $resgatador = null;
        }

        $ListaEsperaame = $this->getProntuario($data['listaespera'], $data['volume']);

        if (!empty($ListaEsperaame)) {
            $idsame = $ListaEsperaame[0]->id;
        } else {
            $idsame = null;
        }

        //die(var_dump($local));
        if (empty($local) && $_SESSION['Sessao']['nmSetor'] != 'ARQUIVO MÉDICO') {
            session()->setFlashdata('failed', 'Esse prontuário precisa de tramitação inicial pelo ARQUIVO MÉDICO');
        } else {
            if (!$listaespera_movimentado && ($data['Setor'] == $setor_user)) {
                session()->setFlashdata('failed', 'Esse prontuário não pode ser movimentado para o seu próprio setor');
            } else {
                if ($listaespera_movimentado && $ult_loc['tramite']) {
                    session()->setFlashdata('failed', 'Esse prontuário está em trâmite para o setor '.$ult_loc['setortramite']);
                } else {
                    if ($listaespera_movimentado && ($data['Setor'] == $ult_loc['setor'])) {
                        session()->setFlashdata('failed', 'Esse prontuário já está localizado no setor destino! '.$ult_loc['setor']);
                    } else {
                        if ($listaespera_movimentado && (($setor_user != $ult_loc['setor']) && !HUAP_Functions::permite_tramitar($ult_loc['setor']))) {
                            session()->setFlashdata('failed', 'Esse prontuário não se encontra no seu setor!');
                        } else {
                            $setor_solic = null;
                            $solic = $this->solicitacaomodel->getWhere(['idDocumento' => $idsame, 'indSolicitacao' => 'P'])->getResult();
                            if (!empty($solic)) {
                                $setor_solic = $solic[0]->nmSetorSolicitante;
                            }
                            if (!is_null($idsame) && (!is_null($setor_solic) && $setor_solic != $data['Setor'])) {
                                session()->setFlashdata('failed', 'Existe uma solicitação para esse prontuário! ');
                            } else {
                                
                                try 
                                {
                                    $ListaEsperaame = [];
                                    $ListaEsperaame['nmSetorAtual'] = $setororigem;
                                    $ListaEsperaame['nmSetorTramite'] = $data['Setor'];

                                    if (is_null($idsame)) {
                                        $ListaEsperaame['numProntuarioAGHU'] = $data['listaespera'];
                                        $ListaEsperaame['numProntuarioMV'] = $this->pacientesmvcontroller->getProntuarioMV($data['listaespera']);
                                        $idsame = $this->vwlistaesperamodel->insert($ListaEsperaame);
                                    } else {
                                        $this->vwlistaesperamodel->update($idsame, $ListaEsperaame);
                                    }

                                    //var_dump($listaespera_movimentado);die();
                                    if ($listaespera_movimentado && is_null($ult_loc['dtenvio'])) { //Prontuário resgatado
                                        $movimentacao = [];
                                        $movimentacao['mov_origem'] = $ult_loc['mov_origem'];
                                        $movimentacao['dtMovimentacao'] = date('Y-m-d H:i:s');
                                        $movimentacao['idRemetente'] = (int)$_SESSION['Sessao']['id'];
                                        $movimentacao['nmRemetente'] = (int)$_SESSION['Sessao']['NomeCompleto'];
                                        $movimentacao['nmSetorDestino'] = $data['Setor'];
                                        $movimentacao['nmProfissional'] = $data['nome_profissional'] ?? null;
                                        $movimentacao['dtPrazoRetorno'] = $data['dtretorno'];
                                        $movimentacao['txtObs'] = $data['txtObs'];
                                    
                                        $this->movimentacaomodel->update($ult_loc['id'], $movimentacao);
                                    } else {
                                        $movimentacao = [];
                                        $movimentacao['idProntuario'] = $idsame;
                                        $movimentacao['dtMovimentacao'] = date('Y-m-d H:i:s');
                                        $movimentacao['idResgatador'] = $resgatador;
                                        $movimentacao['idRemetente'] = (int)$_SESSION['Sessao']['id'];
                                        $movimentacao['nmSetorOrigem'] = $setororigem;
                                        $movimentacao['nmSetorDestino'] = $data['Setor'];
                                        $movimentacao['nmProfissional'] = $data['nome_profissional'] ?? null;
                                        $movimentacao['dtPrazoRetorno'] = $data['dtretorno'];
                                        $movimentacao['txtObs'] = $data['txtObs'];

                                        $this->movimentacaomodel->insert($movimentacao);
                                    };

                                    if (!is_null($setor_solic)) {
                                        $solicitacao['indSolicitacao'] = 'A';
                                        $this->solicitacaomodel->update($solic[0]->id, $solicitacao);
                                    }

                                    session()->setFlashdata('success', 'Operação concluída com sucesso!');

                                } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
                                    $msg = 'Erro na tramitação';
                                    $msg .= ' - '.$e->getMessage();
                                    log_message('error', $msg.': ' . $e->getMessage());
                                    session()->setFlashdata('failed', $msg);
                                }
                            }
                    
                        }
                    }
                }
            }
        }
    }
    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function solicitarProntuario()
    {
        HUAP_Functions::limpa_msgs_flash();

        return view('ListaEspera/solicitar_listaespera',  ['select' => $this->usuariocontroller->getUsuariosSetor(session()->get('Sessao')['idSetor'])]);

    }
     /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function solicitar()
    {        
        helper(['form', 'url', 'session']);

        \Config\Services::session();
       
        $listaespera = '';
        $volume = '100';

        $data = $this->request->getVar();

        if(!empty($data['listaespera']) && is_numeric($data['listaespera'])) {
            $resultAGHUX = $this->aghucontroller->getPaciente($data['listaespera']);

            if(!empty($resultAGHUX[0])) {
                $listaespera = $data['listaespera'];

                $resultSAME = $this->getUltimoVolume($data['listaespera']);

                if((empty($resultSAME) || empty($resultSAME['numVolume']) && (int)$data['volume'] === 0) || ((int)$data['volume'] > 0  && ((int)$resultSAME['numVolume'] >= (int)$data['volume']))) {
                    $volume = $data['volume'];
                }
            }
        }

        $rules = [
            'listaespera' => 'required|max_length[8]|numeric|equals['.$listaespera.']',
            'volume' => 'max_length[2]|equals['.$volume.']',
            'justificativa' => 'required|max_length[255]|min_length[3]'
        ];

        if ($this->validate($rules)) {
            
            $this->validator->reset();

            $busca_hist_ant = ['SSGH'];

            $local = $this->getUltimaLocalizacao($data['listaespera'], $data['volume'], $busca_hist_ant);

            //var_dump($local);die();

            $setor_user = $_SESSION['Sessao']['nmSetor'];

            $receptor = $data['receptor'];

            $ListaEsperaame = $this->getProntuario($data['listaespera'], $data['volume']);
            $idsame = !empty($ListaEsperaame) ? $ListaEsperaame[0]->id : null;
            //var_dump($ListaEsperaame);die();

            if (empty($local)) {
                //session()->setFlashdata('failed', 'Esse prontuário nunca foi tramitado!');
                $listaespera_movimentado = false;
                $setororigem = $setor_user;
            } else {
                $listaespera_movimentado = true;
                $ult_loc = $local[0];
                $setororigem = $ult_loc['setor'];
            }

            //if ($listaespera_movimentado && $setor_user != $ult_loc['setor']  && $ult_loc['tramite']) {
            if ($listaespera_movimentado && $setor_user == $ult_loc['setortramite'] && $ult_loc['tramite']) {
                session()->setFlashdata('failed', 'Esse prontuário já está em trâmite para o seu setor! ');
            } else {
                if ($listaespera_movimentado && $setor_user == $ult_loc['setor'] && !$ult_loc['tramite']) {
                    session()->setFlashdata('failed', 'Esse prontuário já está localizado no seu setor! ');
                } else {
                    if ($listaespera_movimentado && $ult_loc['tramite']) {
                        session()->setFlashdata('failed', 'Esse prontuário não pode ser solicitado por estar em trâmite para o setor '.$ult_loc['setortramite']);
                    } else {
                        if (!is_null($idsame) && !empty($this->solicitacaomodel->getWhere(['idDocumento' => $idsame, 'indSolicitacao' => 'P'])->getResult())) {
                            session()->setFlashdata('failed', 'Não é possível solicitar o documento pois já existe uma solicitação para o mesmo!');
                        } else {
                            if (!$listaespera_movimentado) {
                                session()->setFlashdata('failed', 'Não é possível solicitar o documento pois esse prontuário não foi tramitado!');
                            } else {

                                try 
                                {
                                    if (is_null($idsame)) {
                                        $ListaEsperaame = [];
                                        $ListaEsperaame['nmsetorAtual'] = $setororigem;
                                        $ListaEsperaame['numProntuarioAGHU'] = $listaespera;
                                        $ListaEsperaame['numProntuarioMV'] = $this->pacientesmvcontroller->getProntuarioMV($data['listaespera'], $resultAGHUX[0]->codigo);
                                        $idsame = $this->vwlistaesperamodel->insert($ListaEsperaame);
                                    }
                                    
                                    $solicitacao = [];
                                    $solicitacao['idDocumento'] = $idsame;
                                    $solicitacao['idReceptor'] = $receptor;
                                    $solicitacao['idSolicitante'] = (int)$_SESSION['Sessao']['id'];
                                    $solicitacao['nmSetorSolicitante'] = $setor_user;
                                    $solicitacao['txtJustificativa'] = $data['justificativa'];

                                    $this->solicitacaomodel->insert($solicitacao);

                                    session()->setFlashdata('success', 'Operação concluída com sucesso!');

                                } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
                                    $msg = 'Erro na solicitação';
                                    $msg .= ' - '.$e->getMessage();
                                    log_message('error', $msg.': ' . $e->getMessage());
                                    session()->setFlashdata('failed', $msg);
                                }
                            }
                        }
                    }
                }
            }

            if (!empty(session()->getFlashdata('failed'))) {
                return redirect()->to(base_url('ListaEspera/historico/'.$listaespera.'/'.$volume));
            } else {
                return redirect()->to(base_url('ListaEspera/solicitacoesdosetor/'));
            }

        } else {
            //session()->setFlashdata('error', $this->validator);
            if(isset($result) && empty($result)) {
                $this->validator->setError('listaespera', 'Esse prontuário não existe na base do AGHUX!');
            }

            if($volume === '100') {
                $this->validator->setError('volume', 'Volume sem correspondência!');
            }

            session()->setFlashdata('error', $this->validator);

            return view('ListaEspera/solicitar_listaespera', ['validation' => $this->validator,
                                                             'select' => $this->usuariocontroller->getUsuariosSetor(session()->get('Sessao')['idSetor'])]);
        }

    }
    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function receberProntuario(string $idlistaespera = null, string $nuvolume = null)
    {
     /*    HUAP_Functions::limpa_msgs_flash(); */

        if (is_null($idlistaespera)) {
            //return view('ListaEspera/receber_listaespera',  ['idlistaespera' => $idlistaespera,'nuvolume' => $nuvolume]);
            return view('ListaEspera/receber_listaespera');
        } else {
            $this->recebe_listaespera(['listaespera' => $idlistaespera, 'volume' => $nuvolume]);
            return redirect()->to(base_url('ListaEspera/historico/'.$idlistaespera.'/'.$nuvolume));
        }

    }
    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function receber()
    {        

        helper(['form', 'url', 'session']);

        \Config\Services::session();

        $listaespera = '';
        $volume = '100';

        $data = $this->request->getVar();

        if(!empty($data['listaespera']) && is_numeric($data['listaespera'])) {
            $resultAGHUX = $this->aghucontroller->getPaciente($data['listaespera']);

            if(!empty($resultAGHUX[0])) {
                $listaespera = $data['listaespera'];

                $resultSAME = $this->getUltimoVolume($data['listaespera']);

                if((empty($resultSAME) || empty($resultSAME['numVolume']) && (int)$data['volume'] === 0) || ((int)$data['volume'] > 0  && ((int)$resultSAME['numVolume'] >= (int)$data['volume']))) {
                    $volume = $data['volume'];
                }
            }
        }

        $rules = [
            'listaespera' => 'required|max_length[8]|numeric|equals['.$listaespera.']',
            'volume' => 'max_length[2]|equals['.$volume.']'
        ];

        if ($this->validate($rules)) {

            $this->validator->reset();

            if ($this->recebe_listaespera($data)) {
                //if ($data['origem_chamado'] === 'menu_tramite') {
                    /* return view('ListaEspera/receber_listaespera',  ['idlistaespera' => null, 'nuvolume' => null]); */
                    return redirect()->to(base_url('ListaEspera/receber/'));
                //} else {
                    //return redirect()->to(base_url('ListaEspera/historico/'.$listaespera.'/'.$volume));
                //}
            } else {
                //if ($data['origem_chamado'] === 'menu_tramite') {
                    return view('ListaEspera/receber_listaespera',  ['idlistaespera' => $listaespera, 'nuvolume' => $volume]);
                //} else {
                    //return redirect()->to(base_url('ListaEspera/historico/'.$listaespera.'/'.$volume));
                //}
            };

        } else {
            //session()->setFlashdata('error', $this->validator);
            if(isset($resultAGHUX) && empty($resultAGHUX)) {
                $this->validator->setError('listaespera', 'Esse prontuário não existe na base do AGHUX!');
            }

            if($volume === '100') {
                $this->validator->setError('volume', 'Volume sem correspondência!');
            }

            return view('ListaEspera/receber_listaespera', ['validation' => $this->validator]);
        }
    }
    /**
     * Retorna um array de consultas agendadas
     *
     * @return mixed
     */
    public function ReceberEmLote() 
    {
        \Config\Services::session();

        helper(['form', 'url', 'session']);

        $ListaEsperaJSON = $this->request->getGet('ListaEspera');

        $ListaEspera = json_decode(urldecode($ListaEsperaJSON), true);

        if (empty($ListaEspera)) {
            session()->setFlashdata('failed', 'Nenhum prontuário selecionado!');
        } else {
            foreach ($ListaEspera as $listaespera) {
                //$data = [];
                //$data["listaespera"] = $listaespera;

                $this->recebe_listaespera($listaespera);

            }

            if (session()->has('failed')) {
                session()->remove('failed');
                $msg = 'Alguns Prontuários não puderam ser Recebidos!';
                session()->setFlashdata('warning_message', $msg);
                log_message('error', $msg);
            } else {
                session()->setFlashdata('success', 'Operação concluída com sucesso!');
            }
        }

        return redirect()->to(base_url('ListaEspera/enviadosparaosetor'));

    }
    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function recebe_listaespera($data) {    

        $setor_user = $_SESSION['Sessao']['nmSetor'];

        $ListaEsperaame = $this->getProntuario($data['listaespera'], $data['volume']);

        if (!empty($ListaEsperaame)) {
            $idsame = $ListaEsperaame[0]->id;
        } else {
            $idsame = null;
        }

        $busca_hist_ant = ['MV', 'SSGH'];
        
        $local = $this->getUltimaLocalizacao($data['listaespera'], $data['volume'], $busca_hist_ant);

        //die(var_dump($local));
        if ($local && $local[0]['mov_origem'] != 'same' && $local[0]['tramite']) {
            $tem_hist_ant = true;
            $local = null;
        } else {
            $tem_hist_ant = false;
        }

        if (empty($local)) {
            //session()->setFlashdata('failed', 'Esse prontuário nunca foi tramitado!');
            //die(var_dump('ok'));
            $listaespera_movimentado = false;
            //$setororigem = $setor_user;
        } else {
            $listaespera_movimentado = true;
            $ult_loc = $local[0];
            //$setororigem = $ult_loc['setor'];
        };

        if ($tem_hist_ant) {
            session()->setFlashdata('failed', 'Só é possível receber prontuário com movimentação no sistema atual!');
        } else {
            if (!$listaespera_movimentado || ($listaespera_movimentado && !$ult_loc['tramite'])) {
                session()->setFlashdata('failed', 'Esse prontuário não se encontra em trâmite para recebimento!');
            } else {
                if (($listaespera_movimentado && $ult_loc['tramite'] && (($setor_user != $ult_loc['setortramite']) && !HUAP_Functions::permite_tramitar($ult_loc['setortramite'])))){
                    session()->setFlashdata('failed', 'Esse prontuário não foi enviado para o seu setor!');
                } else {

                    try 
                    {
                        $ListaEsperaame = [];
                        //$ListaEsperaame['nmSetorAtual'] = $setororigem;
                        $ListaEsperaame['nmSetorAtual'] = $ult_loc['setortramite'];
                        $ListaEsperaame['nmSetorTramite'] = null;

                        if (is_null($idsame)) {
                            $ListaEsperaame['numProntuarioAGHU'] = $data['listaespera'];
                            $ListaEsperaame['numProntuarioMV'] = $this->pacientesmvcontroller->getProntuarioMV($data['listaespera']);
                            $idsame = $this->vwlistaesperamodel->insert($ListaEsperaame);
                        } else {
                            $this->vwlistaesperamodel->update($idsame, $ListaEsperaame);
                        }
                        
                        $movimentacao = [];
                        $movimentacao['mov_origem'] = $ult_loc['mov_origem'];
                        $movimentacao['id'] = $ult_loc['id'];
                        $movimentacao['dtRecebimento'] = date('Y-m-d H:i:s');
                        $movimentacao['idRecebedor'] = (int)$_SESSION['Sessao']['id'];
                        $movimentacao['nmRecebedor'] = $_SESSION['Sessao']['NomeCompleto'];
                        //$movimentacao['nmRecebedor'] = $this->usuariocontroller->getUsuario((int)$_SESSION['Sessao']['id']);
                    
                        $this->movimentacaomodel->editar($ult_loc['id'], $movimentacao);
                    
                        session()->setFlashdata('success', 'Operação concluída com sucesso!');

                        return true;

                    } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
                        $msg = 'Erro no recebimento!';
                        $msg .= ' - '.$e->getMessage();
                        log_message('error', $msg.': ' . $e->getMessage());
                        session()->setFlashdata('failed', $msg);
                    }
                }
            }
        }

        return false;
    }
    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function resgatarProntuario()
    {
        HUAP_Functions::limpa_msgs_flash();

        return view('ListaEspera/resgatar_listaespera');

    }
    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function resgatar()
    {        
        helper(['form', 'url', 'session']);

        \Config\Services::session();

        $listaespera = '';
        $volume = '100';

        //$perfil_same = true;

        $data = $this->request->getVar();

        if(!empty($data['listaespera']) && is_numeric($data['listaespera'])) {
            $resultAGHUX = $this->aghucontroller->getPaciente($data['listaespera']);

            if(!empty($resultAGHUX[0])) {
                $listaespera = $data['listaespera'];

                $resultSAME = $this->getUltimoVolume($data['listaespera']);

                if((empty($resultSAME) || empty($resultSAME['numVolume']) && (int)$data['volume'] === 0) || ((int)$data['volume'] > 0  && ((int)$resultSAME['numVolume'] >= (int)$data['volume']))) {
                    $volume = $data['volume'];
                }
            }
        }

        $rules = [
            'listaespera' => 'required|max_length[8]|numeric|equals['.$listaespera.']',
            'volume' => 'max_length[2]|equals['.$volume.']',
        ];

        if ($this->validate($rules)) {
            
            $this->validator->reset();

            //$local = $this->getUltimaLocalizacao($data['listaespera']);
            $local = $this->getUltimaLocalizacao($listaespera, $data['volume']);

            //var_dump($local[0]['setor']);die    ();

            //if (!empty($local) && empty($local[0]['dtenvio'])) {
            if (!empty($local)) {
                session()->setFlashdata('failed', 'Esse prontuário já foi resgatado!');
            //} else if (!empty($local) && !$local[0]['tramite']) {
            } else if (!HUAP_Functions::permite_tramitar('ARQUIVO MÉDICO')) {
                session()->setFlashdata('failed', 'Você não tem autorização para resgatar esse prontuário!');
            } else {

                $this->validator->reset();
                
                $setor_user = $_SESSION['Sessao']['nmSetor'];

                try 
                {
                    $ListaEsperaame = $this->getProntuario($data['listaespera'], $data['volume']);

                    $ListaEsperaame['nmSetorAtual'] = $_SESSION['Sessao']['nmSetor'];

                    if (!empty($ListaEsperaame)) {
                        //$ListaEsperaame = [];
                        $idsame = $ListaEsperaame[0]->id;
                        $this->vwlistaesperamodel->update($idsame, $ListaEsperaame);
                    } else {
                        $ListaEsperaame['numProntuarioAGHU'] = $listaespera;
                        $ListaEsperaame['numProntuarioMV'] = $this->pacientesmvcontroller->getProntuarioMV($data['listaespera'], $resultAGHUX[0]->codigo);
                        $idsame = $this->vwlistaesperamodel->insert($ListaEsperaame);
                    }
                    $movimentacao = [];
                    $movimentacao['idProntuario'] = $idsame;
                    $movimentacao['nmSetorOrigem'] = $setor_user;
                    $movimentacao['idResgatador'] = (int)$_SESSION['Sessao']['id'];

                    $this->movimentacaomodel->insert($movimentacao);
                
                    session()->setFlashdata('success', 'Operação concluída com sucesso!');

                } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
                    $msg = 'Erro no resgate do prontuário!';
                    $msg .= ' - '.$e->getMessage();
                    log_message('error', $msg.': ' . $e->getMessage());
                    session()->setFlashdata('failed', $msg);
                }
            }

            return redirect()->to(base_url('ListaEspera/historico/'.$listaespera.'/'.$volume));

        } else {
            //session()->setFlashdata('error', $this->validator);

            if(isset($result) && empty($result)) {
                $this->validator->setError('listaespera', 'Esse prontuário não existe na base do AGHUX!');
            }

            if($volume === '100') {
                $this->validator->setError('volume', 'Volume sem correspondência!');
            }

            return view('ListaEspera/resgatar_listaespera', ['validation' => $this->validator]);
        }
    }
    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function listarListaEsperaEnviadosParaSetor()
    {        
        \Config\Services::session();

        //HUAP_Functions::limpa_msgs_flash();

        $setor = $_SESSION['Sessao']['nmSetor'];;

        $db = \Config\Database::connect('default');

        $sql = "SELECT 
                    id,
                    numProntuarioAGHU as listaesperaaghu,
                    numProntuarioMV as listaesperamv,
                    numVolume as volume,
                    numSala as sala,
                    numArmario as armario,
                    numLinha as linha,
                    numColuna as coluna,
                    txtObs as obs
                FROM 
                    ListaEspera pro
                WHERE 
                    pro.nmSetorTramite LIKE '$setor';
                ";

        $query = $db->query($sql);

        $result_same = $query->getResult();

        $ListaEspera = [];

        foreach ($result_same as $ListaEsperaame) {

            if ($this->getUltimaLocalizacao($ListaEsperaame->listaesperaaghu, $ListaEsperaame->volume)) {  // se tem movimentação no SAME

                $result_aghu = $this->aghucontroller->getPaciente($ListaEsperaame->listaesperaaghu);

                if(!empty($result_aghu[0])) {
                    $paciente = $result_aghu[0]->nome;
                    $dt_nascimento = $result_aghu[0]->dt_nascimento;
                }

                array_push($ListaEspera, [
                    'id' => $ListaEsperaame->id,
                    'listaesperaaghu' => $ListaEsperaame->listaesperaaghu,
                    'listaesperamv' => $ListaEsperaame->listaesperamv,
                    'paciente' => $paciente,
                    'dt_nascimento' => $dt_nascimento,
                    'volume' => $ListaEsperaame->volume,
                    'sala' => $ListaEsperaame->sala,
                    'armario' => $ListaEsperaame->armario,
                    'linha' => $ListaEsperaame->linha,
                    'coluna' => $ListaEsperaame->coluna,
                    'obs' => $ListaEsperaame->obs
                ]);
            }
        }
        
        session()->setFlashdata('mensagem_flash', null);

        if (empty($ListaEspera)) {
            session()->setFlashdata('warning_message', 'Não existem Prontuários Encaminhados para o Setor que possuam movimentação no SAME!');
        } else {
            array_multisort(array_column($ListaEspera, 'listaesperaaghu'), SORT_ASC, $ListaEspera);
        } 

        return view('ListaEspera/listar_ListaEspera_enviados_setor', ['ListaEspera' => $ListaEspera,
                                                                      'setoruser' => $setor
                                                                     ]);
    }
     /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function listarListaEsperaRetidos_()
    {        
        \Config\Services::session();

        HUAP_Functions::limpa_msgs_flash();

        $setor = $_SESSION['Sessao']['nmSetor'];;

        $db = \Config\Database::connect('default');

        $sql = "WITH movimentacoes_combined AS (
                    SELECT
                        numProntuarioAGHU AS numProntuario,
                        IFNULL(numVolume, 1) as numVolume,
                        nmSetorOrigem,
                        nmSetorDestino,
                        dtMovimentacao,
                        dtPrazoRetorno,
                        dtRecebimento
                    FROM movimentacoes mov_same
                    inner join ListaEspera pro_same on pro_same.id = mov_same.idProntuario
                    WHERE 
                        ((dtPrazoRetorno IS NOT NULL and date_format(dtPrazoRetorno, '%Y-%m-%d') < curdate()) OR (dtPrazoRetorno IS NULL AND date_add(date_format(dtMovimentacao , '%Y-%m-%d'), INTERVAL 3 DAY) < curdate()))
                        AND dtMovimentacao IS NOT NULL

                    UNION ALL

                    SELECT
                        doc_listaespera AS numProntuario,
                        IFNULL(doc_seq, 1) as numVolume,
                        setororigem AS nmSetorOrigem,
                        setordestino AS nmSetorDestino,
                        tra_dt_env AS dtMovimentacao,
                        NULL AS dtPrazoRetorno,
                        tra_dt_rec as dtRecebimento
                    FROM movimentacoes_ssgh mov_ssgh
                    WHERE 
                        (date_add(date_format(tra_dt_env, '%Y-%m-%d'), INTERVAL 3 DAY) < curdate())
                        AND tra_dt_env IS NOT NULL
                ),
                ranked_movimentacoes AS (
                    SELECT
                        numProntuario,
                        numVolume,
                        nmSetorOrigem,
                        nmSetorDestino,
                        dtMovimentacao,
                        dtPrazoRetorno,
                        dtRecebimento,
                        ROW_NUMBER() OVER (PARTITION BY numProntuario, numVolume ORDER BY dtMovimentacao DESC) AS rn
                    FROM movimentacoes_combined
                )
                SELECT
                    numProntuario,
                    numVolume,
                    nmSetorOrigem,
                    nmSetorDestino,
                    dtMovimentacao,
                    dtPrazoRetorno,
                    dtRecebimento,
                    rn
                FROM ranked_movimentacoes
                WHERE rn = 1 AND dtRecebimento IS NULL
                ORDER BY numProntuario, rn;
            ";

        $query = $db->query($sql);

        $listaespera = $query->getResult();

        $ListaEspera = [];

        foreach ($result as $listaespera) {

            // Volumes null do ssgh entram no histórico dos volumes 1 do same ////////////////////////////////
            $resultUltVol = $this->getUltimoVolume($listaespera->numProntuario);
            $ult_volume = $resultUltVol['numVolume'] ?? 0;

            if (is_null($listaespera->numVolume)) {
                $numVolume = null;  //volumes null tem origem somente no same nessa query
            } else {                
                if ($listaespera->numVolume == 1) { //Trata os volumes null transformados em 1 que seriam do ssgh
                    if ($ult_volume > 0) {
                        $numVolume = 1;
                    } else {
                        $numVolume = null;
                    }
                } else {
                    $numVolume = $listaespera->numVolume;
                }
            }
            /////////////////////////////////////////////////////////////////////////////////////////////////////

           /*  $busca_hist_ant = ['MV', 'SSGH'];
            $local = $this->getUltimaLocalizacao($listaespera->numProntuario, $numVolume, $busca_hist_ant );

            if ($listaespera->numProntuario == 8000){
                die(var_dump($local));
            } */

            array_push($ListaEspera, [
                'listaespera' => $listaespera->numProntuario,
                'volume' => $numVolume,
                'setororigem' => $listaespera->nmSetorOrigem,
                'setordestino' => $listaespera->nmSetorDestino,
                'dtmovimentacao' => $listaespera->dtMovimentacao,
                'dtprazoretorno' => $listaespera->dtPrazoRetorno
            ]);

            //array_multisort(array_column($ListaEspera, 'listaespera'), SORT_ASC, $ListaEspera);
            array_multisort(array_column($ListaEspera, 'listaespera'), SORT_ASC, array_column($ListaEspera, 'volume'), SORT_ASC, $ListaEspera);

        }

        session()->setFlashdata('mensagem_flash', null);

        if (empty($ListaEspera)) {
            session()->setFlashdata('warning_message', 'Não existem Prontuários Retidos!');
        } 

        return view('ListaEspera/listar_ListaEspera_retidos', ['ListaEspera' => $ListaEspera,
                                                               'qtdTotal' => count($result)
                                                              ]);
    }
    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function listarSolicitacoesExternas()
    {        
        //helper(['form', 'url', 'session']);
        \Config\Services::session();

        HUAP_Functions::limpa_msgs_flash();

        //$perfil_same = true;

        /* if (HUAP_Functions::tem_perfil_same()) {
            $setor = '%';
        } else { */
        $setor = $_SESSION['Sessao']['nmSetor'];;
/*         } */
        $db = \Config\Database::connect('default');

        $sql = "SELECT 
                    sol.id,
                    sol.idDocumento,
                    pro.numProntuarioAGHU as listaespera,
                    pro.numVolume as volume,
                    pro.nmSetorAtual as setoratual,
                    sol.nmSetorSolicitante as setorsolicitante,
                    sol.indSolicitacao as situacao,
                    sol.txtJustificativa as justificativa,
                    sol.created_at as dtsolicitacao,
                    usu_sol.nmUsuario as solicitante,
                    usu_rec.nmUsuario as receptor
                FROM 
                    solicitacoes sol
                INNER JOIN 
                    ListaEspera pro ON pro.id = sol.idDocumento
                LEFT JOIN 
                    usuarios usu_sol ON usu_sol.id = sol.idSolicitante
                LEFT JOIN 
                    usuarios usu_rec ON usu_rec.id = sol.idReceptor
                WHERE 
                    pro.nmSetorAtual LIKE '$setor'
                    AND sol.indSolicitacao IN ('A', 'P');
                ";

        $query = $db->query($sql);

        $result_same = $query->getResult();

        $solicitacoes = [];

        foreach ($result_same as $solicitacao) {

            $result_aghu = $this->aghucontroller->getPaciente($solicitacao->listaespera);

            if(!empty($result_aghu[0])) {
                $paciente = $result_aghu[0]->nome;
            }

            //$local = $this->getUltimaLocalizacao($solicitacao->listaespera)[0]['setor'];

            switch ($solicitacao->situacao) {
                case 'P':
                    $situacao = 'Pendente';
                    break;
                case 'A':
                    $situacao = 'Atendido';
                    break;

                default:
                    $situacao = 'Indefinido';
                }


           // var_dump($solicitacao->situacao);die;
            array_push($solicitacoes, [
                'id' => $solicitacao->id,
                'numlistaespera' => $solicitacao->listaespera,
                'numvolume' => $solicitacao->volume,
                'paciente' => $paciente,
                'setorsolicitante' => $solicitacao->setorsolicitante,
                'solicitante' => $solicitacao->solicitante,
                'receptor' => $solicitacao->receptor,
                'justificativa' => $solicitacao->justificativa,
                'dtsolicitacao' => $solicitacao->dtsolicitacao,
                'setoratual' => $solicitacao->setoratual,
                'situacao' => $situacao
            ]);

            array_multisort(array_column($solicitacoes, 'dtsolicitacao'), SORT_DESC, $solicitacoes);

        }

        session()->setFlashdata('mensagem_flash', null);

        if (empty($solicitacoes)) {
            session()->setFlashdata('warning_message', 'Não existem solicitações externas de prontuários para o Setor!');
        } 

        return view('ListaEspera/listar_solicitacoes_externas', ['solicitacoes' => $solicitacoes]);
    }
    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function excluirSolicitacao($id = null)
    {
      
        $data = $this->solicitacaomodel->find($id);
        
        if($data){
            try {
                $this->solicitacaomodel->delete($id);

                session()->setFlashdata('success', 'Exclusão concluída com sucesso!');

            } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
                $msg = 'Erro na exclusão da Solicitação';
                log_message('error', $msg.': ' . $e->getMessage());
                session()->setFlashdata('failed', $msg);
            }

            return redirect()->to('ListaEspera/solicitacoesdosetor');
        }
        
        return $this->failNotFound('Nenhuma Solicitação encontrada com id '.$id);    
    }
    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function recuperar(int $id, int $listaespera, int $volume = null)
    {        

        try 
        {
           $mov = $this->movimentacaocontroller->getMovimentacao($id);

           //die(var_dump($mov));

           if (empty($mov[0]->idResgatador)) {
                $this->movimentacaomodel->delete($id);
           } else {
                $data = [];
                $data['dtMovimentacao'] = null;
                $data['dtPrazoRetorno'] = null;
                $data['nmSetorDestino'] = null;
                $data['idRemetente'] = null;
                $data['nmProfissional'] = null;
                $data['txtObs'] = null;

                $this->movimentacaomodel->update($id, $data);
           }
        
           $ListaEsperaame = [];
           $ListaEsperaame['nmSetorTramite'] = null;
           $this->vwlistaesperamodel->update($mov[0]->idProntuario, $ListaEsperaame);

           session()->setFlashdata('success', 'Operação concluída com sucesso!');

        } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
            $msg = 'Erro na recuperação do prontuário!';
            $msg .= ' - '.$e->getMessage();
            log_message('error', $msg.': ' . $e->getMessage());
            session()->setFlashdata('failed', $msg);
        }

        return redirect()->to(base_url('ListaEspera/historico/'.$listaespera.'/'.$volume));

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

            if(!$this->vwlistaesperamodel->getWhere(['id' => $id])->getResult()) {

                $response = [
                    'status'   => 404,
                    'error'    => 'setor não localizado com id '.$id,
                ];

            } else {
            
                    $this->vwlistaesperamodel->update($id, $data);
                        
                    if ($this->vwlistaesperamodel->affectedRows() > 0) {
                        $response = [
                            'status'   => 200,
                            'error'    => null,
                            'messages' => [
                                'success' => 'setor atualizado!'
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
            $msg = 'Erro na alteração do setor';
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
      
        $data = $this->vwlistaesperamodel->find($id);
        
        if($data){
            try {
                $this->vwlistaesperamodel->delete($id);
                $response = [
                    'status'   => 200,
                    'error'    => null,
                    'messages' => [
                        'success' => 'setor removido com sucesso!'
                    ]
                ];
                return $this->respondDeleted($response);

            } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
                $msg = 'Erro na exclusão do setor';
                log_message('error', $msg.': ' . $e->getMessage());
                return $this->fail($msg.' ('.$e->getCode().')');
            }
        }
        
        return $this->failNotFound('Nenhum setor encontrado com id '.$id);    
    }
    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function criar_ListaEspera_aghu (int $inicio, int $fim)
    {
       /*  $inicio = $this->request->getVar('inicio');
        $fim = $this->request->getVar('fim'); */

        $db = \Config\Database::connect('aghux');

        $sql = "SELECT codigo, listaespera 
                FROM  AGH.AIP_PACIENTES 
                WHERE listaespera NOTNULL 
                AND listaespera BETWEEN $inicio AND $fim 
                ORDER BY listaespera asc";

        $query = $db->query($sql);

        $result = $query->getResult();

        $db = \Config\Database::connect('default');

        foreach ($result as $reg_aghu) {

            $query = $db->query("SELECT * FROM ListaEspera WHERE numProntuarioAGHU = $reg_aghu->listaespera;");
    
            $pro_same = $query->getResult();

            //die(var_dump(!$pro_same));

            if (!$pro_same) {

                $listaesperamv = $this->pacientesmvcontroller->getProntuarioMV($reg_aghu->listaespera, $reg_aghu->codigo);

                //$pacienteaghu = $this->aghucontroller->getPaciente($reg_aghu->listaespera);

                $busca_hist_ant = ['MV', 'SSGH'];
                $local = $this->getUltimaLocalizacao($reg_aghu->listaespera, null, $busca_hist_ant );

                if (empty($local)) {
                    $listaespera_movimentado = false;
                    $setoratual = null;
                    $setortramite = null;
                } else {
                    $listaespera_movimentado = true;
                    $ult_loc = $local[0];
                    $setoratual = $ult_loc['setor'];
                    $setortramite = $ult_loc['setortramite'];
                };

                $ListaEsperaame['numProntuarioAGHU'] = $reg_aghu->listaespera;
                $ListaEsperaame['numProntuarioMV'] = $listaesperamv;
                $ListaEsperaame['nmSetorAtual'] = $setoratual;
                $ListaEsperaame['nmSetorTramite'] = $setortramite;

                try {

                    $this->vwlistaesperamodel->insert($ListaEsperaame);

                } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
                    $msg = 'Erro na criação dos Prontuários - '. $reg_aghu->listaespera .' ==> '.$e->getMessage();
                    log_message('error', $msg.': ' . $e->getMessage());
                    throw $e;
                }
            }
        }
     }
     /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function atualizar_localizacao (int $inicio, int $fim)
    {
       
        $db = \Config\Database::connect('default');

        $sql = "SELECT id, numProntuarioAGHU, numVolume
                FROM  ListaEspera
                WHERE numProntuarioAGHU BETWEEN $inicio AND $fim 
                ORDER BY 2, 3 asc";

        $query = $db->query($sql);

        $result = $query->getResult();

        $busca_hist_ant = ['MV', 'SSGH'];

        foreach ($result as $reg_aghu) {

            //die(var_dump($reg_aghu->numProntuarioAGHU));

            $local = $this->getUltimaLocalizacao($reg_aghu->numProntuarioAGHU, $reg_aghu->numVolume, $busca_hist_ant);

            if (empty($local)) {
                $listaespera_movimentado = false;
                $setoratual = null;
                $setortramite = null;
            } else {
                $listaespera_movimentado = true;
                $ult_loc = $local[0];
                $setoratual = $ult_loc['setor'];
                $setortramite = $ult_loc['setortramite'];
            };

            $ListaEsperaame['nmSetorAtual'] = $setoratual;
            $ListaEsperaame['nmSetorTramite'] = $setortramite;

            //$listaespera = $this->getProntuario($reg_aghu->numProntuarioAGHU, );

            //die(var_dump($listaespera));

            try {

                $this->vwlistaesperamodel->update($reg_aghu->id, $ListaEsperaame);

            } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
                $msg .= 'Erro na atualização dos Prontuários - '.$e->getMessage();
                log_message('error', $msg.': ' . $e->getMessage());
                throw $e;
            }
        }
     }
     /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function importar_vol_mv(int $inicio, int $fim) {
        
        $db = \Config\Database::connect('default');

        $sql = "SELECT listaespera, MAX(volume) as max
                FROM movimentacoes_mv mm
                WHERE volume IS NOT NULL
                AND listaespera BETWEEN $inicio and $fim
                GROUP BY listaespera
                HAVING MAX(volume) > 1
                ORDER BY listaespera;";

        //die(var_dump($sql));

        $query = $db->query($sql);

        $result = $query->getResult();

        //die(var_dump($result));

        foreach ($result as $vol) {

            $pro_aghu = $this->pacientesmvcontroller->getProntuarioAGHU($vol->listaespera);
            //die(var_dump($pro_aghu));

            if ($pro_aghu) {

                $pro_same = $this->getProntuario($pro_aghu);

                if ($pro_same) {

                    try {
                        $array = [];
                        $array['numVolume'] = 1 ;
                        $this->vwlistaesperamodel->update($pro_same[0]->id, $array);

                    } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
                        $msg .= 'Erro na alteração do Prontuario SAME - '.$e->getMessage();
                        log_message('error', $msg.': ' . $e->getMessage());
                        throw $e;
                    }
                }

                for ($i = 1; $i <= $vol->max; $i++) {

                    $pro_same = $this->getProntuario($pro_aghu, $i);

                    if (!$pro_same) {

                        try {

                            $busca_hist_ant = ['MV', 'SSGH'];

                            $ult_loc = $this->getUltimaLocalizacao($pro_aghu, $i, $busca_hist_ant);

                            //die(var_dump($ult_loc));

                            $array = [];
                            $array['numVolume'] = $i ;
                            $array['numProntuarioAGHU'] = $pro_aghu;
                            $array['numProntuarioMV'] = $vol->listaespera;
                            $array['nmSetorAtual'] = $ult_loc ? $ult_loc[0]['setor'] : NULL;
                            $array['nmSetorTramite'] = $ult_loc ? $ult_loc[0]['setortramite'] : NULL;

                            $this->vwlistaesperamodel->insert($array);
        
                        } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
                            $msg .= 'Erro na inclusão do Prontuario SAME - '.$e->getMessage();
                            log_message('error', $msg.': ' . $e->getMessage());
                            throw $e;
                        }
                    }
                }
            }
        }

    }
    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function importar_vol_ssgh(int $inicio, int $fim) {
        
        $db = \Config\Database::connect('ssgh');

        $sql = "SELECT doc_listaespera, MAX(doc_seq)
                FROM pac_documento pd
                WHERE doc_seq IS NOT NULL
                AND doc_listaespera::integer BETWEEN $inicio and $fim
                GROUP BY doc_listaespera
                ORDER BY 1;";

        $query = $db->query($sql);

        $result = $query->getResult();

        //die(var_dump($result));

        foreach ($result as $vol) {

            $pro_same = $this->getProntuario($vol->doc_listaespera);

            if ($pro_same) {

                try {
                    $array = [];
                    $array['numVolume'] = 1 ;
                    $this->vwlistaesperamodel->update($pro_same[0]->id, $array);

                } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
                    $msg .= 'Erro na alteração do Prontuario SAME - '.$e->getMessage();
                    log_message('error', $msg.': ' . $e->getMessage());
                    throw $e;
                }
            }

            for ($i = 1; $i <= $vol->max; $i++) {

                $pro_same = $this->getProntuario($vol->doc_listaespera, $i);

                if (!$pro_same) {

                    try {

                        $busca_hist_ant = ['MV', 'SSGH'];

                        $ult_loc = $this->getUltimaLocalizacao($vol->doc_listaespera, $i, $busca_hist_ant);

                        //die(var_dump($ult_loc));

                        $array = [];
                        $array['numVolume'] = $i ;
                        $array['numProntuarioAGHU'] = $vol->doc_listaespera;
                        $array['numProntuarioMV'] = $this->pacientesmvcontroller->getProntuarioMV($vol->doc_listaespera);
                        $array['nmSetorAtual'] = $ult_loc ? $ult_loc[0]['setor'] : NULL;
                        $array['nmSetorTramite'] = $ult_loc ? $ult_loc[0]['setortramite'] : NULL;

                        $this->vwlistaesperamodel->insert($array);
    
                    } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
                        $msg .= 'Erro na inclusão do Prontuario SAME - '.$e->getMessage();
                        log_message('error', $msg.': ' . $e->getMessage());
                        throw $e;
                    }

                }
                            
            }
        }

    }
    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function atualizar_num_listaespera_mv (int $inicio, int $fim)
    {
        $db = \Config\Database::connect('default');

        $sql = "SELECT id, numProntuarioAGHU nu_listaespera_aghu
                FROM  ListaEspera
                WHERE 
                numProntuarioMV is null
                AND numProntuarioAGHU BETWEEN $inicio AND $fim 
                ORDER BY numProntuarioAGHU asc";

        $query = $db->query($sql);

        $result = $query->getResult();

        $db = \Config\Database::connect('default');

        foreach ($result as $reg_aghu) {

            $nu_listaespera_mv = $this->pacientesmvcontroller->getProntuarioMV($reg_aghu->nu_listaespera_aghu);

            $array = [];
            $array['numProntuarioMV'] = $nu_listaespera_mv ;

            try {

                $this->vwlistaesperamodel->update($reg_aghu->id, $array);

            } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
                $msg .= 'Erro na atualização dos Prontuários - '.$e->getMessage();
                log_message('error', $msg.': ' . $e->getMessage());
                throw $e;
            }
        }
     }

}