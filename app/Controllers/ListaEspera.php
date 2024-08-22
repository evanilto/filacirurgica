<?php

namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;
use App\Controllers\MapaCirurgico;
use App\Libraries\HUAP_Functions;
use App\Models\ListaEsperaModel;
use App\Models\VwListaEsperaModel;
use App\Models\VwStatusFilaCirurgicaModel;
use App\Models\MapaCirurgicoModel;
use App\Models\FilaModel;
use App\Models\RiscoModel;
use App\Models\OrigemPacienteModel;
use App\Models\LateralidadeModel;
use App\Models\PosOperatorioModel;
use App\Models\ProcedimentosAdicionaisModel;
use App\Models\EquipeMedicaModel;
use App\Models\JustificativasModel;
//use App\Controllers\MapaCirurgico;
use DateTime;
use CodeIgniter\Config\Services;
use Config\Database;
use CodeIgniter\Database\Exceptions\DatabaseException;
use PHPUnit\Framework\Constraint\IsNull;


class ListaEspera extends ResourceController
{
    private $listaesperamodel;
    private $vwlistaesperamodel;

    private $vwstatusfilacirurgicamodel;
    private $mapacirurgicomodel;
    private $filamodel;
    private $riscomodel;
    private $origempacientemodel;
    private $lateralidademodel;
    private $posoperatoriomodel;
    private $justificativasmodel;

    private $procedimentosadicionaismodel;
    private $equipemedicamodel;
    private $usuariocontroller;
    private $mapacirurgicocontroller;
    private $aghucontroller;
    private $selectfila;
    private $selectrisco;
    private $selectespecialidade;
    private $selectespecialidadeaghu;
    private $selectprofespecialidadeaghu;
    private $selectcids;
    private $selectitensprocedhospit;
    private $selectorigempaciente;
    private $selectlateralidade;
    private $selectposoperatorio;
    private $data;


    public function __construct()
    {
        $this->listaesperamodel = new ListaEsperaModel();
        $this->vwlistaesperamodel = new VwListaEsperaModel();
        $this->vwstatusfilacirurgicamodel = new VwStatusFilaCirurgicaModel();
        $this->mapacirurgicomodel = new MapaCirurgicoModel();
        $this->filamodel = new FilaModel();
        $this->riscomodel = new RiscoModel();
        $this->origempacientemodel = new OrigemPacienteModel();
        $this->lateralidademodel = new LateralidadeModel();
        $this->justificativasmodel = new JustificativasModel();
        $this->posoperatoriomodel = new PosOperatorioModel;
        $this->procedimentosadicionaismodel = new ProcedimentosAdicionaisModel();
        $this->equipemedicamodel = new EquipeMedicaModel();
        $this->usuariocontroller = new Usuarios();
        $this->mapacirurgicocontroller = new MapaCirurgico();
        $this->aghucontroller = new Aghu();

        $this->selectfila = $this->filamodel->Where('indsituacao', 'A')->orderBy('nmtipoprocedimento', 'ASC')->findAll();
        $this->selectrisco = $this->riscomodel->Where('indsituacao', 'A')->orderBy('nmrisco', 'ASC')->findAll();
        $this->selectorigempaciente = $this->origempacientemodel->Where('indsituacao', 'A')->orderBy('nmorigem', 'ASC')->findAll();
        $this->selectlateralidade = $this->lateralidademodel->Where('indsituacao', 'A')->orderBy('id', 'ASC')->findAll();
        $this->selectposoperatorio = $this->posoperatoriomodel->Where('indsituacao', 'A')->orderBy('id', 'ASC')->findAll();
        $this->selectespecialidade = $this->listaesperamodel->distinct()->select('idespecialidade')->findAll();
        $this->selectespecialidadeaghu = $this->aghucontroller->getEspecialidades($this->selectespecialidade);
        //die(var_dump($this->aghucontroller->getProfEspecialidades($this->selectespecialidade)));
        $this->selectprofespecialidadeaghu = $this->aghucontroller->getProfEspecialidades($this->selectespecialidade);
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
    public function getOrdemFila($idlista)
    {
        $statusfila = $this->vwstatusfilacirurgicamodel->find($idlista);

        //die(var_dump($statusfila));

        return $statusfila['ordem_fila'] ?? null;
    }
     /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function getDetailsAside($numProntuario, $ordemFila = 'A Definir', $fila = 'A Definir')
    {
        // Pegue o registro pelos $id e passe os dados para a view
        $data = [
            'paciente' => $this->aghucontroller->getDetalhesPaciente($numProntuario),
            'ordemfila' => $ordemFila,
            'fila' => $fila
        ];

        //die(var_dump($data['ordemfila']));

        return view('listaespera/exibe_paciente', $data);
    }
    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function getNomePaciente($numProntuario)
{
    //return $this->response->setJSON(['error' => $numProntuario], 404);

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
        //$data['origens'] = $this->selectorigempaciente;
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

        $dataflash = session()->getFlashdata('dataflash');

        if ($dataflash) {
            $data = $dataflash;
        }

        if(!empty($data['prontuario']) && is_numeric($data['prontuario'])) {
            $resultAGHUX = $this->aghucontroller->getPaciente($data['prontuario']);

            if(!empty($resultAGHUX[0])) {
                $prontuario = $data['prontuario'];
            }
        }

        $rules = [
            'nome' => 'permit_empty|min_length[3]',
         ];

        if (!$dataflash) {
            $rules = $rules + [
                'prontuario' => 'permit_empty|min_length[1]|max_length[8]|equals['.$prontuario.']',
                'dtinicio' => 'required|valid_date[d/m/Y]',
                'dtfim' => 'required|valid_date[d/m/Y]',
            ];
        }

        if ($this->validate($rules)) {

            //die(var_dump($dataflash));

            if (!$dataflash) {
                if (DateTime::createFromFormat('d/m/Y', $data['dtfim'])->format('Y-m-d') < DateTime::createFromFormat('d/m/Y', $data['dtinicio'])->format('Y-m-d')) {
                    $this->validator->setError('dtinicio', 'A data de início não pode ser maior que a data final!');

                    session()->setFlashdata('warning_message', 'Nenhum paciente da Lista localizado com os parâmetros informados!');
                    return view('layouts/sub_content', ['view' => 'listaespera/form_consulta_listaespera',
                                                        'validation' => $this->validator,
                                                        'data' => $data]);
                }
            
                $horaAtual = date('H:i:s');
                $data['dtfim'] = $data['dtfim'] . ' ' . $horaAtual;
            }

            $this->validator->reset();

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

        $builder = $db->table('vw_listaespera as vl');
        $builder->join('vw_mapacirurgico as vm', 'vl.id = vm.idlista', 'inner');

        $builder->select('vl.*, vm.ordem_lista, vm.ordem_fila');

        //die(var_dump($data));

        if (!empty($data['idlista'])) {
        
            $builder->where('vl.id', $data['idlista']);
    
        } else {

            //$clausula_where = " created_at BETWEEN $dt_ini AND $dt_fim";
            $builder->where("vl.created_at BETWEEN '$data[dtinicio]' AND '$data[dtfim]'");

            if (!empty($data['prontuario'])) {
                //$clausula_where .= " AND prontuario = $data[prontuario]";
                $builder->where('vl.prontuario', $data['prontuario']);
            };
            if (!empty($data['nome'])) {
                //$clausula_where .= " AND  nome_paciente LIKE '%".strtoupper($data['nome'])."%'";
                $builder->where('vl.nome_paciente LIKE', '%'.strtoupper($data['nome']).'%');
            };
            if (!empty($data['especialidade'])) {
                //$clausula_where .= " AND  idespecialidade = $data[especialidade]";
                $builder->where('vl.idespecialidade', $data['especialidade']);
            };
            if (!empty($data['fila'])) {
                //$clausula_where .= " AND  idtipoprocedimento = $data[fila]";
                $builder->where('vl.idtipoprocedimento', $data['fila']);
            };
            if (!empty($data['risco'])) {
                //$clausula_where .= " AND  idrisco = $data[risco]";
                $builder->where('vl.idriscocirurgico',  $data['risco']);
            };
            if (!empty($data['complexidades'])) {
                //$clausula_where .= " AND  idrisco = $data[risco]";
                $builder->whereIn('vl.complexidade',  $data['complexidades']);
            };
        }

        //var_dump($builder->getCompiledSelect());die();

        return $builder->get()->getResult();

        //die(var_dump($builder->get()->getResult()));
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
    public function getSituacaoCirurgica ($data) 
    {
        //die(var_dump($data));

        $db = \Config\Database::connect('default');

        $builder = $db->table('vw_statusfilacirurgica as vs');
        $builder->join('vw_mapacirurgico as vm', 'vs.idlistaespera = vm.idlista', 'left');

        $builder->select('(vs.campos_mapa).status,
                          (vs.campos_mapa).datacirurgia,
                          vs.dthrinclusao,
                          vs.idlistaespera,
                          vs.prontuario,
                          vs.nome,
                          vs.especialidade,
                          vs.fila,
                          vm.ordem_lista,
                          vm.ordem_fila');

        //die(var_dump($data));

        if (!empty($data['idlista'])) {
        
            $builder->where('vs.id', $data['idlista']);
    
        } else {

            if (!empty($data['prontuario'])) {
                //$clausula_where .= " AND prontuario = $data[prontuario]";
                $builder->where('vs.prontuario', $data['prontuario']);
            };
            if (!empty($data['nome'])) {
                //$clausula_where .= " AND  nome_paciente LIKE '%".strtoupper($data['nome'])."%'";
                $builder->where('vs.nome LIKE', '%'.strtoupper($data['nome']).'%');
            };
            if (!empty($data['fila'])) {
                //$clausula_where .= " AND  idtipoprocedimento = $data[fila]";
                $builder->where('vs.idfila', $data['fila']);
            };
        }

        //var_dump($builder->getCompiledSelect());die();

        return $builder->get()->getResult();

        //die(var_dump($builder->get()->getResult()));
    }
    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function incluirPacienteNaLista(string $idlistaespera = null)
    {
        HUAP_Functions::limpa_msgs_flash();

        //die(var_dump($this->vwstatusfilacirurgicamodel->find(7267)));

        $data['dtinclusao'] = date('d/m/Y H:i:s');
        $data['ordem'] = '';
        $data['filas'] = $this->selectfila;
        $data['riscos'] = $this->selectrisco;
        $data['origens'] = $this->selectorigempaciente;
        $data['lateralidades'] = $this->selectlateralidade;
        $data['especialidades'] = $this->selectespecialidadeaghu;
        $data['cids'] = $this->selectcids;
        $data['procedimentos'] = $this->selectitensprocedhospit;

        //var_dump($data['filas']);die();

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
        $dataform['ordem'] = 'A definir';
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
            'congelacao' => 'required',
            'justorig' => 'max_length[1024]|min_length[0]',
            'info' => 'max_length[1024]|min_length[0]',
        ];

        if ($this->validate($rules)) {

            $this->validator->reset();

            if(isset($resultAGHUX) && empty($resultAGHUX)) {
                $this->validator->setError('prontuario', 'Esse prontuário não existe na base do AGHUX!');
            } else {
                if ($this->getPacienteNaLista($data)) {
                    session()->setFlashdata('failed', 'Paciente já tem cirurgia cadastrada nesse dia para a mesma especialidade, fila e procedimento!');
                } else {

                    $db = \Config\Database::connect('default');

                    $db->transStart();

                    try {

                        $paciente = [
                            'numprontuario' => $data['prontuario'],
                            'idespecialidade' => $data['especialidade'],
                            'idriscocirurgico' => empty($data['risco']) ? NULL : $data['risco'],
                            'dtriscocirurgico' => empty($data['dtrisco']) ? NULL : $data['dtrisco'],
                            'numcid' => empty($data['cid']) ? NULL : $data['cid'],
                            'idcomplexidade' => $data['complexidade'],
                            'idtipoprocedimento' => $data['fila'],
                            'idorigempaciente' => $data['origem'],
                            'indcongelacao' => $data['congelacao'],
                            'idprocedimento' => $data['procedimento'],
                            'idlateralidade' => $data['lateralidade'],
                            /* 'indsituacao' => 'A', */
                            'txtinfoadicionais' => $data['info'],
                            'txtorigemjustificativa' => $data['justorig']
                        ];
                        
                        $idlista = $this->listaesperamodel->insert($paciente);

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

                        $ordemfila = $this->getOrdemFila($idlista);
                        $dataform['ordem'] = $ordemfila ?? 'A Definir';

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
    public function editarLista(int $id, $ordemfila)
    {
        HUAP_Functions::limpa_msgs_flash();

        //$data = $this->request->getVar();

        $lista = $this->listaesperamodel->find($id);

        //die(var_dump($lista));

        $data = [];
        $data['id'] = $lista['id'];
        $data['ordemfila'] = $ordemfila;
        $data['dtinclusao'] = DateTime::createFromFormat('Y-m-d H:i:s', $lista['created_at'])->format('d/m/Y H:i');
        $data['prontuario'] = $lista['numprontuario'];
        $data['especialidade'] = $lista['idespecialidade'];
        $data['risco'] = $lista['idriscocirurgico'];
        $data['dtrisco'] = $lista['dtriscocirurgico'] ? DateTime::createFromFormat('Y-m-d', $lista['dtriscocirurgico'])->format('d/m/Y') : NULL;
        $data['cid'] = $lista['numcid'];
        $data['complexidade'] = $lista['idcomplexidade'];
        $data['fila'] = $lista['idtipoprocedimento'];
        $data['origem'] = $lista['idorigempaciente'];
        $data['congelacao'] = $lista['indcongelacao'];
        $data['procedimento'] = $lista['idprocedimento'];
        $data['lateralidade'] = $lista['idlateralidade'];
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

        //die(var_dump($dataflash));

        $rules = [
            'especialidade' => 'required',
            'dtrisco' => 'permit_empty|valid_date[d/m/Y]',
            'fila' => 'required',
            'procedimento' => 'required',
            'origem' => 'required',
            'lateralidade' => 'required',
            'justorig' => 'max_length[1024]|min_length[0]',
            'info' => 'max_length[1024]|min_length[0]',
        ];

        if ($this->validate($rules)) {

            try {

                $lista = [
                        'idespecialidade' => $data['especialidade'],
                        'idriscocirurgico' => empty($data['risco']) ? NULL : $data['risco'],
                        'dtriscocirurgico' => empty($data['dtrisco']) ? NULL : $data['dtrisco'],
                        'numcid' => empty($data['cid']) ? NULL : $data['cid'],
                        'idcomplexidade' => $data['complexidade'],
                        'idtipoprocedimento' => $data['fila'],
                        'idorigempaciente' => $data['origem'],
                        'indcongelacao' => $data['congelacao'],
                        'idprocedimento' => $data['procedimento'],
                        'idlateralidade' => $data['lateralidade'],
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

            $dados = $this->request->getPost();

            $dataflash['idlista'] = $data['id'];

            session()->setFlashdata('dataflash', $dataflash);

            //die(var_dump($dataflash));

            return redirect()->to(base_url('listaespera/exibir'));

            /* return view('layouts/sub_content', ['view' => 'listaespera/form_edita_listaespera',
                                                'data' => $data]); */
        } else {
            session()->setFlashdata('error', $this->validator);

            $data['filas'] = $this->selectfila;
            $data['riscos'] = $this->selectrisco;
            $data['origens'] = $this->selectorigempaciente;
            $data['lateralidades'] = $this->selectlateralidade;
            $data['especialidades'] = $this->selectespecialidadeaghu;
            $data['cids'] = $this->selectcids;
            $data['procedimentos'] = $this->selectitensprocedhospit;

            return view('layouts/sub_content', ['view' => 'listaespera/form_edita_listaespera',
                                                'data' => $data]);
        }
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
            $this->listaesperamodel->update($id, ['indsituacao' => 'I']);

            if ($db->transStatus() === false) {
                throw new \CodeIgniter\Database\Exceptions\DatabaseException('Erro ao inativar paciente da Lista!');
            }

            $this->listaesperamodel->delete(['id' => $id]);
    
                if ($db->transStatus() === false) {
                throw new \CodeIgniter\Database\Exceptions\DatabaseException('Erro ao excluir um paciente da Lista!');
            }

            $db->transComplete();
    
        } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
            $db->transRollback(); // Reverte a transação em caso de erro
            $msg = 'Erro na exclusão do paciente da Lista';
            $msg .= ' - '.$e->getMessage();
            log_message('error', $msg.': ' . $e->getMessage());
            session()->setFlashdata('failed', $msg);
        }

        if ($db->transStatus() === false) {
            $dados = $this->request->getPost();
            $dataflash['idlista'] = $id;
            session()->setFlashdata('dataflash', $dataflash);

            return redirect()->to(base_url('listaespera/exibir'));
        }

        session()->setFlashdata('success', 'Paciente excluído da Lista de Espera com sucesso!');

        return view('layouts/sub_content', ['view' => 'listaespera/list_listaespera',
        'listaespera' => []]);


        $result = $this->getListaEspera($data);

        return view('layouts/sub_content', ['view' => 'listaespera/list_listaespera',
                                            'listaespera' => $result,
                                            'data' => $data]);
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

        //die(var_dump($id));

        $data = [];
        $data['ordem'] = $this->getListaEspera(['idlista' => $id])[0]->ordem_fila;
        $data['id'] = $lista['id'];
        $data['dtcirurgia'] = date('d/m/Y H:i', strtotime('+3 days'));
        $data['prontuario'] = $lista['numprontuario'];
        $data['especialidade'] = $lista['idespecialidade'];
        $data['risco'] = $lista['idriscocirurgico'];
        $data['dtrisco'] = $lista['dtriscocirurgico'] ? DateTime::createFromFormat('Y-m-d', $lista['dtriscocirurgico'])->format('d/m/Y') : NULL;
        $data['cid'] = $lista['numcid'];
        $data['complexidade'] = $lista['idcomplexidade'];
        $data['fila'] = $lista['idtipoprocedimento'];
        $data['origem'] = $lista['idorigempaciente'];
        $data['congelacao'] = $lista['indcongelacao'];
        $data['procedimento'] = $lista['idprocedimento'];
        $data['proced_adic'] = [];
        $data['lateralidade'] = $lista['idlateralidade'];
        $data['posoperatorio'] = null;
        $data['info'] = $lista['txtinfoadicionais'];
        $data['nec_proced'] = '';
        $data['justorig'] = $lista['txtorigemjustificativa'];
        $data['justenvio'] = '';
        $data['profissional'] = [];
        $data['filas'] = $this->selectfila;
        $data['riscos'] = $this->selectrisco;
        $data['origens'] = $this->selectorigempaciente;
        $data['lateralidades'] = $this->selectlateralidade;
        $data['posoperatorios'] = $this->selectposoperatorio;
        $data['especialidades'] = $this->selectespecialidadeaghu;
        $data['cids'] = $this->selectcids;
        $data['procedimentos'] = $this->selectitensprocedhospit;
        $data['especialidades_med'] = $this->selectespecialidadeaghu;
        $data['prof_especialidades'] = $this->selectprofespecialidadeaghu;

        $codToRemove = $lista['idprocedimento'];
        $procedimentos = $data['procedimentos'];
        $data['procedimentos_adicionais'] = array_filter($procedimentos, function($procedimento) use ($codToRemove) {
            return $procedimento->cod_tabela !== $codToRemove;
        });

        //var_dump($data['filas']);die();

        return view('layouts/sub_content', ['view' => 'listaespera/form_envia_mapacirurgico',
                                            'data' => $data]);
    }
    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function enviar()
    {
        \Config\Services::session();

        helper(['form', 'url', 'session']);

        $this->data = [];

        $this->data = $this->request->getVar();

        //die(var_dump($this->data));

        $rules = [
            'especialidade' => 'required',
            'dtrisco' => 'permit_empty|valid_date[d/m/Y]',
            'dtcirurgia' => 'required|valid_date[d/m/Y H:i]',
            'fila' => 'required',
            'procedimento' => 'required',
            'posoperatorio' => 'required',
            'profissional' => 'required',
            'lateralidade' => 'required',
            'hemoderivados' => 'required',
            'congelacao' => 'required',
            'justorig' => 'max_length[1024]|min_length[0]',
            'info' => 'max_length[1024]|min_length[0]',
            'nec_proced' => 'required|max_length[250]|min_length[3]',
        ];

        if ($this->validate($rules)) {

            $db = \Config\Database::connect('default');

            if (DateTime::createFromFormat('d/m/Y H:i', $this->data['dtcirurgia'])->getTimestamp() < strtotime(date('Y-m-d H:i') . ' +'.DIAS_AGENDA_CIRURGICA.' days')) {
                $this->validator->setError('dtcirurgia', 'O tempo mínimo para agendar uma cirurgia eletiva é de '.DIAS_AGENDA_CIRURGICA.' dias!');

                $this->carregaMapa();

                return view('layouts/sub_content', ['view' => 'listaespera/form_envia_mapacirurgico',
                                                    'data' => $this->data]);
            }

            $data_clone = $this->data;
            $data_clone['listapaciente'] = $this->data['id'];
            $data_clone['dtcirurgia'] = DateTime::createFromFormat('d/m/Y H:i', $this->data['dtcirurgia'])->format('Y-m-d');
            if ($this->mapacirurgicocontroller->getPacienteNoMapa($data_clone)) {
                session()->setFlashdata('failed', 'Esse paciente já tem uma cirurgia programada para esse dia!');

                $this->carregaMapa();

                return view('layouts/sub_content', ['view' => 'listaespera/form_envia_mapacirurgico',
                                                    'data' => $this->data]);
            }

            $db->transStart();

            try {

                $lista = [
                        'idriscocirurgico' => empty($this->data['risco']) ? NULL : $this->data['risco'],
                        'dtriscocirurgico' => empty($this->data['dtrisco']) ? NULL : $this->data['dtrisco'],
                        'numcid' => empty($this->data['cid']) ? NULL : $this->data['cid'],
                        'idcomplexidade' => $this->data['complexidade'],
                        'indcongelacao' => $this->data['congelacao'],
                        'idlateralidade' => $this->data['lateralidade'],
                        'txtinfoadicionais' => $this->data['info'],
                        'txtorigemjustificativa' => $this->data['justorig']
                        ];

                $this->listaesperamodel->update($this->data['id'], $lista);

                if ($db->transStatus() === false) {
                    $error = $db->error();
                    $errorMessage = !empty($error['message']) ? $error['message'] : 'Erro desconhecido';
                    $errorCode = !empty($error['code']) ? $error['code'] : 0;

                    throw new \CodeIgniter\Database\Exceptions\DatabaseException(
                        sprintf('Erro ao atualizar Lista de Espera [%d] %s', $errorCode, $errorMessage)
                    );
                }

                $mapa = [
                    'idlistaespera' => $this->data['id'],
                    'dthrcirurgia' => $this->data['dtcirurgia'],
                    'idposoperatorio' => $this->data['posoperatorio'],
                    'indhemoderivados' => $this->data['hemoderivados'],
                    'txtnecessidadesproced' => $this->data['nec_proced'],
                    'txtjustificativaenvio' => $this->data['justenvio'],
                    'numordem' => $this->data['ordem']
                    ];

                $idmapa = $this->mapacirurgicomodel->insert($mapa);

                if ($db->transStatus() === false) {
                    $error = $db->error();
                    $errorMessage = !empty($error['message']) ? $error['message'] : 'Erro desconhecido';
                    $errorCode = !empty($error['code']) ? $error['code'] : 0;

                    throw new \CodeIgniter\Database\Exceptions\DatabaseException(
                        sprintf('Erro ao inserir paciente no Mapa [%d] %s', $errorCode, $errorMessage)
                    );
                }

                if (isset($this->data['proced_adic'])) {

                    foreach ($this->data['proced_adic'] as $key => $procedimento) {

                        $array['idmapacirurgico'] = (int) $idmapa;
                        $array['codtabela'] = (int) $procedimento;

                        $this->procedimentosadicionaismodel->insert($array);

                        if ($db->transStatus() === false) {
                            $error = $db->error();
                            $errorMessage = !empty($error['message']) ? $error['message'] : 'Erro desconhecido';
                            $errorCode = !empty($error['code']) ? $error['code'] : 0;
        
                            throw new \CodeIgniter\Database\Exceptions\DatabaseException(
                                sprintf('Erro ao inserir procedimento adicional [%d] %s', $errorCode, $errorMessage)
                            );
                        }

                    }
                }

                if (isset($this->data['profissional'])) {

                    foreach ($this->data['profissional'] as $key => $profissional) {

                        $array['idmapacirurgico'] = (int) $idmapa;
                        $array['codpessoa'] = (int) $profissional;

                        $this->equipemedicamodel->insert($array);

                        if ($db->transStatus() === false) {
                            $error = $db->error();
                            $errorMessage = !empty($error['message']) ? $error['message'] : 'Erro desconhecido';
                            $errorCode = !empty($error['code']) ? $error['code'] : 0;
        
                            throw new \CodeIgniter\Database\Exceptions\DatabaseException(
                                sprintf('Erro ao inserir equipe médica [%d] %s', $errorCode, $errorMessage)
                            );
                        }

                    }
                }

                $this->listaesperamodel->delete($this->data['id']);

                if ($db->transStatus() === false) {
                    $error = $db->error();
                    $errorMessage = !empty($error['message']) ? $error['message'] : 'Erro desconhecido';
                    $errorCode = !empty($error['code']) ? $error['code'] : 0;

                    throw new \CodeIgniter\Database\Exceptions\DatabaseException(
                        sprintf('Erro ao excluir paciente da lista [%d] %s', $errorCode, $errorMessage)
                    );
                }

                $db->transComplete();

                if ($db->transStatus() === false) {
                    $error = $db->error();
                    $errorMessage = !empty($error['message']) ? $error['message'] : 'Erro desconhecido';
                    $errorCode = !empty($error['code']) ? $error['code'] : 0;

                    throw new \CodeIgniter\Database\Exceptions\DatabaseException(
                        sprintf('Erro ao enviar paciente para o Mapa Cirúrgico! [%d] %s', $errorCode, $errorMessage)
                    );
                }

                session()->setFlashdata('success', 'Paciente emviado ao Mapa Cirúrgico com sucesso!');

                $this->validator->reset();
                
            } catch (\Exception $e) {
                $db->transRollback(); // Reverte a transação em caso de erro
                $msg = sprintf('Exception - Falha no envio do paciente para o Mapa Cirúrgico - prontuário: %d - cod: (%d) msg: %s', (int) $this->data['prontuario'], (int) $e->getCode(), $e->getMessage());
                log_message('error', 'Exception: ' . $msg);
                session()->setFlashdata('exception', $msg);
            } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
                $db->transRollback(); // Reverte a transação em caso de erro
                $msg = sprintf('DatabaseException -  Falha no envio do paciente para o Mapa Cirúrgico - prontuário: %d - cod: (%d) msg: %s', (int) $this->data['prontuario'], (int) $e->getCode(), $e->getMessage());
                log_message('error', 'Exception: ' . $msg);
                session()->setFlashdata('exception', $msg);
            } catch (\CodeIgniter\Database\Exceptions\DataException $e) {
                $db->transRollback(); // Reverte a transação em caso de erro
                $msg = sprintf('DataException -  Falha no envio do paciente para o Mapa Cirúrgico - prontuário: %d - cod: (%d) msg: %s', (int) $this->data['prontuario'], (int) $e->getCode(), $e->getMessage());
                log_message('error', 'Exception: ' . $msg);
                session()->setFlashdata('exception', $msg);
            }

            $this->carregaMapa();

            return view('layouts/sub_content', ['view' => 'listaespera/form_envia_mapacirurgico',
                                                'data' => $this->data]);

        } else {
            session()->setFlashdata('error', $this->validator);

            $this->carregaMapa();

            return view('layouts/sub_content', ['view' => 'listaespera/form_envia_mapacirurgico',
                                                'validation' => $this->validator,
                                                'data' => $this->data]);
        }
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
     * 
     * @return mixed
     */
    private function carregaMapa() {

        $this->data['filas'] = $this->selectfila;
        $this->data['riscos'] = $this->selectrisco;
        $this->data['origens'] = $this->selectorigempaciente;
        $this->data['lateralidades'] = $this->selectlateralidade;
        $this->data['posoperatorios'] = $this->selectposoperatorio;
        $this->data['especialidades'] = $this->selectespecialidadeaghu;
        $this->data['cids'] = $this->selectcids;
        $this->data['procedimentos'] = $this->selectitensprocedhospit;
        $this->data['especialidades_med'] = $this->selectespecialidadeaghu;
        $this->data['prof_especialidades'] = $this->selectprofespecialidadeaghu;

        $this->data['proced_adic'] = is_array($this->data['proced_adic_hidden']) ? $this->data['proced_adic_hidden'] : explode(',', $this->data['proced_adic_hidden']);
        $this->data['proced_adic'] = array_filter($this->data['proced_adic']);

        $codToRemove = $this->data['procedimento'];
        $procedimentos = $this->data['procedimentos'];
        $this->data['procedimentos_adicionais'] = array_filter($procedimentos, function($procedimento) use ($codToRemove) {
            return $procedimento->cod_tabela !== $codToRemove;
        });
    }
    /**
     * 
     * @return mixed
     */
    public function getListaPaciente() {

        $prontuario = $this->request->getPost('prontuario');

        $db = Database::connect('default');

        $listaesperas = $this->vwlistaesperamodel->where('prontuario', $prontuario)->findAll();
        
        return $this->response->setJSON($listaesperas);

    }
    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function consultarSituacaoCirurgica(string $idlistaespera = null)
    {
        HUAP_Functions::limpa_msgs_flash();

        $data['filas'] = $this->filamodel->Where('indsituacao', 'A')->orderBy('nmtipoprocedimento', 'ASC')->findAll();

        $data['filas'] = $this->selectfila;

        //die(var_dump($data));

        return view('layouts/sub_content', ['view' => 'listaespera/form_consulta_situacaocirurgica',
                                            'data' => $data]);

    }
    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function exibirSituacaoCirurgica()
    {        
        helper(['form', 'url', 'session']);

        \Config\Services::session();

        $prontuario = null;

        $data = $this->request->getVar();

        $dataflash = session()->getFlashdata('dataflash');

        if ($dataflash) {
            $data = $dataflash;
        }

        if(!empty($data['prontuario']) && is_numeric($data['prontuario'])) {
            $resultAGHUX = $this->aghucontroller->getPaciente($data['prontuario']);

            if(!empty($resultAGHUX[0])) {
                $prontuario = $data['prontuario'];
            }
        }

        $rules = [
            'nome' => 'permit_empty|min_length[3]',
         ];

        if (!$dataflash) {
            $rules = $rules + [
                'prontuario' => 'permit_empty|min_length[1]|max_length[8]|equals['.$prontuario.']',
            ];
        }

        if ($this->validate($rules)) {

            //die(var_dump($dataflash));

            $this->validator->reset();

            $result = $this->getSituacaoCirurgica($data);

            if (empty($result)) {

                $data['filas'] = $this->filamodel->Where('indsituacao', 'A')->orderBy('nmtipoprocedimento', 'ASC')->findAll();

                session()->setFlashdata('warning_message', 'Nenhum paciente da Lista localizado com os parâmetros informados!');
                return view('layouts/sub_content', ['view' => 'listaespera/form_consulta_situacaocirurgica',
                                                    'validation' => $this->validator,
                                                    'data' => $data]);
            
            }

            //die(var_dump($result));

            return view('layouts/sub_content', ['view' => 'listaespera/list_listasituacaocirurgica',
                                               'listaespera' => $result,
                                                'data' => $data]);
        } else {
            if(isset($resultAGHUX) && empty($resultAGHUX)) {
                $this->validator->setError('prontuario', 'Esse prontuário não existe na base do AGHUX!');
            }
            
            $data['filas'] = $this->filamodel->Where('indsituacao', 'A')->orderBy('nmtipoprocedimento', 'ASC')->findAll();

            return view('layouts/sub_content', ['view' => 'listaespera/form_consulta_situacaocirurgica',
                                               'validation' => $this->validator,
                                                'data' => $data]);
        }
    }
    /**
     * 
     * @return mixed
     */
    public function migrarLista() {

        try {

            $db = \Config\Database::connect('default');

            $sqlTruncate = "truncate lista_espera RESTART IDENTITY;";
            $sqlDropDefault = "ALTER TABLE lista_espera ALTER COLUMN id DROP DEFAULT;";
            $sqlSetVal = "SELECT setval('lista_espera_seq', (SELECT MAX(id) FROM lista_espera le));";
            $sqlSetDefault = "ALTER TABLE lista_espera ALTER COLUMN id SET DEFAULT nextval('lista_espera_seq');";

            $sql = "
                SELECT
                    cl.idlistacirurgica,
                    cl.prontuario,
                    CAST(cl.datainclusao || ' ' || cl.horainclusao AS TIMESTAMP) AS data_inclusao,
                    cl.especialidade,
                    cl.dataavaliacao,
                    cl.cid,
                    CASE
                        WHEN cl.complexidade = 1 THEN 'A'
                        WHEN cl.complexidade = 2 THEN 'M'
                        WHEN cl.complexidade = 3 THEN 'B'
                    END AS complexidade,
                    cl.tipoprocedimento,
                    cl.riscocirurgico,
                    cl.origempaciente,
                    cl.procedimento,
                    cl.lateralidade,
                    cl.idlistacirurgica,
                    CASE 
                        WHEN cc.congelacao = 0 THEN 'N'
                        WHEN cc.congelacao = 1 THEN 'S'
                    END AS congelacao,
                    ci.informacoesadicionais,
                    cn.necessidadesprocedimento,
                    CASE 
                        WHEN cl.situacao = 0 THEN 'A'
                        WHEN cl.situacao = 1 THEN 'I'
                    END AS situacao,
                    cj.justificativa,
                    cje.justificativa as justificativa_exclusao
                FROM cirurgias_listacirurgica cl
                LEFT JOIN cirurgias_congelacao cc ON cc.idlistacirurgica = cl.idlistacirurgica
                LEFT JOIN cirurgias_necessidadesprocedimento cn ON cn.idlistacirurgica = cl.idlistacirurgica
                LEFT JOIN cirurgias_informacoesadicionais ci ON ci.idlistacirurgica = cl.idlistacirurgica
                LEFT JOIN cirurgias_justificativas cj on cj.idlistacirurgica = cl.idlistacirurgica
                LEFT JOIN cirurgias_justificativa_exclusao cje on cje.idlistacirurgica = cl.idlistacirurgica
                --INNER JOIN remoto.aip_pacientes pac ON pac.prontuario = cl.prontuario
                ;";

            $query = $db->query($sql);

            $result = $query->getResult();

            $query = $db->query($sqlTruncate);

            $query = $db->query($sqlDropDefault);

            $db->transStart();

            foreach ($result as $reg) {

                $lista = [];
                $lista['id'] = $reg->idlistacirurgica;
                $lista['numprontuario'] = $reg->prontuario;
                $lista['idespecialidade'] = $reg->especialidade;
                $lista['dtriscocirurgico'] = $reg->dataavaliacao;
                $lista['numcid'] = $reg->cid;
                $lista['idcomplexidade'] = $reg->complexidade;
                $lista['idtipoprocedimento'] = $reg->tipoprocedimento;
                $lista['idriscocirurgico'] = $reg->riscocirurgico;
                $lista['idorigempaciente'] = $reg->origempaciente;
                $lista['idprocedimento'] = $reg->procedimento;
                $lista['idlateralidade'] = $reg->lateralidade;
                $lista['indsituacao'] = $reg->situacao;
                $lista['txtinfoadicionais'] = $reg->informacoesadicionais;
                $lista['txtorigemjustificativa'] = $reg->justificativa;
                $lista['txtjustificativaexclusao'] = $reg->justificativa_exclusao;
                $lista['indcongelacao'] = $reg->congelacao;
                $lista['created_at'] = $reg->data_inclusao;
                $lista['updated_at'] = $reg->data_inclusao;
                $lista['indurgencia'] = 'N';

                $this->listaesperamodel->insert($lista);

                if ($db->transStatus() === false) {
                    $error = $db->error();
                    $errorMessage = isset($error['message']) ? $error['message'] : 'Erro desconhecido';
                    $errorCode = isset($error['code']) ? $error['code'] : 0;

                    throw new \CodeIgniter\Database\Exceptions\DatabaseException(
                        sprintf('Erro ao incluir lista de espera! [%d] %s', $errorCode, $errorMessage)
                    );
                }

                if ($reg->situacao == 'I') {
                    $this->listaesperamodel->delete($reg->idlistacirurgica);

                    if ($db->transStatus() === false) {
                        $error = $db->error();
                        $errorMessage = isset($error['message']) ? $error['message'] : 'Erro desconhecido';
                        $errorCode = isset($error['code']) ? $error['code'] : 0;

                        throw new \CodeIgniter\Database\Exceptions\DatabaseException(
                            sprintf('Erro ao excluir lista de espera! [%d] %s', $errorCode, $errorMessage)
                        );
                    }
                }
            }

            $db->transComplete();

            if ($db->transStatus() === false) {
                $error = $db->error();
                $errorMessage = isset($error['message']) ? $error['message'] : 'Erro desconhecido';
                $errorCode = isset($error['code']) ? $error['code'] : 0;

                throw new \CodeIgniter\Database\Exceptions\DatabaseException(
                    sprintf('Erro na criação da lista de espera! [%d] %s', $errorCode, $errorMessage)
                );
            }

            $query = $db->query($sqlSetVal);

            $query = $db->query($sqlSetDefault);

        } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
            $msg = 'Falha na criação da lista de espera - '. $reg->prontuario .' ==> '.$e->getMessage();
            log_message('error', $msg.': ' . $e->getMessage());
            throw $e;
        }

    }

}
