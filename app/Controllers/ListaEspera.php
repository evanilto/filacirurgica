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
use App\Models\EquipamentosModel;
use App\Models\EquipeMedicaModel;
use App\Models\EquipamentosCirurgiaModel;
use App\Models\HemocomponentesModel;
use App\Models\HemocomponentesCirurgiaModel;

use App\Models\FilasModel;
use App\Models\FilaWebModel;
use App\Models\HistoricoModel;
use App\Models\JustificativasModel;
//use App\Models\JustificativasExclusaoModel;
use App\Models\LocalFatItensProcedHospitalarModel;
use App\Models\LocalAghCidsModel;
use App\Models\LocalAghEspecialidadesModel;
use App\Models\LocalAipPacientesModel;
use App\Models\LocalProfEspecialidadesModel;
use App\Models\VwOrdemPacienteModel;
use App\Models\LocalVwDetalhesPacientesModel;
use App\Models\LocalAipContatosPacientesModel;
use App\Models\PacientesModel;

//use App\Controllers\MapaCirurgico;
use DateTime;
use CodeIgniter\Config\Services;
use Config\Database;
use CodeIgniter\Database\Exceptions\DatabaseException;
use PHPUnit\Framework\Constraint\IsNull;
use CodeIgniter\HTTP\ResponseInterface;


class ListaEspera extends ResourceController
{
    private $listaesperamodel;
    private $vwlistaesperamodel;

    private $vwstatusfilacirurgicamodel;
    private $vwordempacientemodel;
    private $mapacirurgicomodel;
    private $filamodel;
    private $riscomodel;
    private $origempacientemodel;
    private $lateralidademodel;
    private $posoperatoriomodel;
    private $justificativasmodel;
    //private $justificativasexclusaomodel;
    private $localfatitensprocedhospitalarmodel;
    private $localaghcidsmodel;
    private $localaghespecialidadesmodel;
    private $localprofespecialidadesmodel;
    private $localaippacientesmodel;
    private $localaipcontatospacientesmodel;
    private $localvwdetalhespacientesmodel;
    private $procedimentosadicionaismodel;
    private $equipamentosmodel;
    private $equipemedicamodel;
    private $equipamentoscirurgiamodel;
    private $historicomodel;
    private $usuariocontroller;
    //private $mapacirurgicocontroller;
    private $filawebmodel;
    private $aghucontroller;
    private $selectfila;
    private $selectrisco;
    private $selectriscoativos;
    private $selectespecialidade;
    private $selectespecialidadeaghu;
    private $selectprofespecialidadeaghu;
    private $selectcids;
    private $selectitensprocedhospit;
    private $selectequipamentos;
    private $selectitensprocedhospitativos;
    private $selectorigempaciente;
    private $selectorigempacienteativos;
    private $selectlateralidade;
    private $selectlateralidadeativos;
    private $selectposoperatorio;
    private $selectjustificativastroca;
    private $selectjustificativassuspensao;
    private $selectjustificativasexclusao;
    private $data;
    private $hemocomponentesmodel;
    private $selecthemocomponentes;
    private $hemocomponentescirurgiamodel;
    private $pacientesmodel;


    public function __construct()
    {
        ini_set('memory_limit', '512M');

        $this->listaesperamodel = new ListaEsperaModel();
        $this->vwlistaesperamodel = new VwListaEsperaModel();
        $this->pacientesmodel = new PacientesModel();
        $this->vwstatusfilacirurgicamodel = new VwStatusFilaCirurgicaModel();
        $this->vwordempacientemodel = new VwOrdemPacienteModel();
        $this->mapacirurgicomodel = new MapaCirurgicoModel();
        $this->filamodel = new FilaModel();
        $this->riscomodel = new RiscoModel();
        $this->origempacientemodel = new OrigemPacienteModel();
        $this->lateralidademodel = new LateralidadeModel();
        $this->justificativasmodel = new JustificativasModel();
        //$this->justificativasexclusaomodel = new JustificativasExclusaoModel();
        $this->posoperatoriomodel = new PosOperatorioModel;
        $this->procedimentosadicionaismodel = new ProcedimentosAdicionaisModel();
        $this->equipamentosmodel = new EquipamentosModel();
        $this->equipemedicamodel = new EquipeMedicaModel();
        $this->equipamentoscirurgiamodel = new EquipamentosCirurgiaModel();
        $this->localfatitensprocedhospitalarmodel = new LocalFatItensProcedHospitalarModel();
        $this->localaghcidsmodel = new LocalAghCidsModel();
        $this->localaghespecialidadesmodel = new LocalAghEspecialidadesModel();
        $this->localprofespecialidadesmodel = new LocalProfEspecialidadesModel();
        $this->localaippacientesmodel = new LocalAipPacientesModel();
        $this->historicomodel = new HistoricoModel();
        $this->usuariocontroller = new Usuarios();
        //$this->mapacirurgicocontroller = new MapaCirurgico(); // disable for migration
        $this->filawebmodel = new FilaWebModel(); // disable for migration
        $this->localvwdetalhespacientesmodel = new LocalVwDetalhesPacientesModel();
        $this->localaipcontatospacientesmodel = new LocalAipContatosPacientesModel();
        $this->hemocomponentesmodel = new HemocomponentesModel();
        $this->hemocomponentescirurgiamodel = new HemocomponentesCirurgiaModel();
        //$this->aghucontroller = new Aghu();

        $this->selectfila = $this->filamodel->Where('indsituacao', 'A')->orderBy('nmtipoprocedimento', 'ASC')->findAll();
        $this->selectrisco = $this->riscomodel->orderBy('nmrisco', 'ASC')->findAll();
        $this->selectriscoativos = $this->riscomodel->Where('indsituacao', 'A')->orderBy('nmrisco', 'ASC')->findAll();
        $this->selectorigempaciente = $this->origempacientemodel->orderBy('nmorigem', 'ASC')->findAll();
        $this->selectorigempacienteativos = $this->origempacientemodel->Where('indsituacao', 'A')->orderBy('nmorigem', 'ASC')->findAll();
        $this->selectlateralidade = $this->lateralidademodel->orderBy('id', 'ASC')->findAll();
        $this->selectlateralidadeativos = $this->lateralidademodel->Where('indsituacao', 'A')->orderBy('id', 'ASC')->findAll();
        $this->selectjustificativastroca = $this->justificativasmodel->Where('tipojustificativa', 'T')->Where('indsituacao', 'A')->orderBy('descricao', 'ASC')->findAll();
        $this->selectjustificativassuspensao = $this->justificativasmodel->Where('tipojustificativa', 'S')->Where('indsituacao', 'A')->orderBy('descricao', 'ASC')->findAll();
        $this->selectjustificativasexclusao = $this->justificativasmodel->Where('tipojustificativa', 'E')->Where('indsituacao', 'A')->orderBy('descricao', 'ASC')->findAll();
        $this->selectposoperatorio = $this->posoperatoriomodel->Where('indsituacao', 'A')->orderBy('id', 'ASC')->findAll();
        $this->selectespecialidade = $this->listaesperamodel->distinct()->select('idespecialidade')->findAll();
        $this->selectespecialidadeaghu = $this->localaghespecialidadesmodel->Where('ind_situacao', 'A') // disable for migration
                                                                           ->whereIn('seq', array_column($this->selectespecialidade, 'idespecialidade'))
                                                                           ->orderBy('nome_especialidade', 'ASC')->findAll(); 
        $this->selectprofespecialidadeaghu = $this->localprofespecialidadesmodel->whereIn('esp_seq', array_column($this->selectespecialidade, 'idespecialidade'))
                                                                               ->orderBy('nome', 'ASC')->findAll(); // disable for migration
        //$this->selectcids = $this->aghucontroller->getCIDs();
        $this->selectcids = $this->localaghcidsmodel->Where('ind_situacao', 'A')->orderBy('descricao', 'ASC')->findAll();
        //$this->selectitensprocedhospit = $this->aghucontroller->getItensProcedimentosHospitalares();
        $this->selectitensprocedhospit = $this->localfatitensprocedhospitalarmodel->orderBy('descricao', 'ASC')->findAll();
        $this->selectequipamentos = $this->equipamentosmodel->Where('indsituacao', 'A')->orderBy('descricao', 'ASC')->findAll();
        $this->selectitensprocedhospitativos = $this->localfatitensprocedhospitalarmodel->Where('ind_situacao', 'A')->orderBy('descricao', 'ASC')->findAll();
        $this->selecthemocomponentes = $this->hemocomponentesmodel->orderBy('id', 'ASC')->findAll();

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
        $ordemfila = $this->vwordempacientemodel->find($idlista);

        //die(var_dump($statusfila));

        return $ordemfila['ordem_fila'] ?? null;
    }
     /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    /* public function getDetailsAside($numProntuario, $ordemFila = 'A Definir', $fila = 'A Definir')
    {
        // Pegue o registro pelos $id e passe os dados para a view
        $data = [
            //'paciente' => $this->aghucontroller->getDetalhesPaciente($numProntuario),
            'paciente' => $this->localaippacientesmodel->find($numProntuario),
            'ordemfila' => $ordemFila,
            'fila' => $fila
        ];

        //die(var_dump($data['ordemfila']));

        return view('listaespera/exibe_paciente', $data);
    } */
    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function getDadosModal()
    {
        $prontuario = $this->request->getGet('prontuario'); // Captura o parâmetro via GET
    
        // Valida se o parâmetro foi enviado
        if (!$prontuario) {
            return $this->response->setJSON(['erro' => 'Parâmetro prontuario é obrigatório'], 400);
        }
    
        // Busca o paciente pelo prontuário
        //$paciente = $this->localaippacientesmodel->find($prontuario);
        $paciente = $this->localvwdetalhespacientesmodel->find($prontuario);
        $paciente->contatos = $this->localaipcontatospacientesmodel->Where('pac_codigo', $paciente->codigo)->findAll();
                   
        // Retorna como JSON
        return $this->response->setJSON($paciente);
    }
    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function getNomePaciente($numProntuario)
{
    //return $this->response->setJSON(['error' => $numProntuario], 404);

    //$paciente = $this->aghucontroller->getPaciente($numProntuario);
    $paciente = $this->localaippacientesmodel->find($numProntuario);
    //die(var_dump($paciente));

    //if ($paciente && isset($paciente[0]->nome)) {
    if ($paciente && isset($paciente->nome)) {

        $pac = $this->filawebmodel->getTipoSanguineoAtual($numProntuario);

        if ($pac) {
            $tiposanguineo = $pac->tiposanguineo;
            $updated_at = $pac->updated_at;
        } else {
            $tiposanguineo = NULL;
            $updated_at = NULL;
        }

        return $this->response->setJSON(['nome' => $paciente->nome,
                                         'tiposanguineo' => $tiposanguineo,
                                         'updated_at' => $updated_at]);
    }

    return $this->response->setJSON(['error' => 'Paciente não localizado'], 404);
}
    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function consultarListaEspera(string $idlistaespera = null)
    {
        HUAP_Functions::limpa_msgs_flash();

        $_SESSION['listaespera'] = NULL;

        //$data['dtinicio'] = date('d/m/Y', strtotime($this->getFirst()['created_at']));
        $data['dtinicio'] = NULL;
        //$data['dtfim'] = date('d/m/Y');
        $data['dtfim'] = NULL;

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

        //die(var_dump($data));

        //$dataflash = session()->getFlashdata('dataflash');

        if ($_SESSION['listaespera']) {
            //$data = $dataflash;
            $data = $_SESSION['listaespera'];
        }

        if(!empty($data['prontuario']) && is_numeric($data['prontuario'])) {
            //$resultAGHUX = $this->aghucontroller->getPaciente($data['prontuario']);
            $paciente = $this->localaippacientesmodel->find($data['prontuario']);

            //if(!empty($resultAGHUX[0])) {
            if($paciente) {
                $prontuario = $data['prontuario'];
            }
        }

        $rules = [
            'nome' => 'permit_empty|min_length[3]',
         ];

        if (!$_SESSION['listaespera']) {
            $rules = $rules + [
                'prontuario' => 'permit_empty|min_length[1]|max_length[8]|equals['.$prontuario.']'
            ];
        }

        if ($this->validate($rules)) {

            //die(var_dump($dataflash));

            if (!$_SESSION['listaespera']) {
                if ($data['dtinicio'] || $data['dtfim']) {

                    $data['filas'] = $this->selectfila;
                    $data['riscos'] = $this->selectrisco;
                    $data['especialidades'] = $this->selectespecialidadeaghu;

                    if (empty($data['dtinicio'])) {
                        $this->validator->setError('dtinicio', 'Informe a data de início!');
                        return view('layouts/sub_content', ['view' => 'listaespera/form_consulta_listaespera',
                        'validation' => $this->validator,
                        'data' => $data]);
                    }
                    if (!$data['dtfim']) {
                        $this->validator->setError('dtfim', 'Informe a data final!');
                        return view('layouts/sub_content', ['view' => 'listaespera/form_consulta_listaespera',
                        'validation' => $this->validator,
                        'data' => $data]);
                    }
                    if (DateTime::createFromFormat('d/m/Y', $data['dtfim'])->format('Y-m-d') < DateTime::createFromFormat('d/m/Y', $data['dtinicio'])->format('Y-m-d')) {
                        $this->validator->setError('dtinicio', 'A data de início não pode ser maior que a data final!');
                        return view('layouts/sub_content', ['view' => 'listaespera/form_consulta_listaespera',
                                                            'validation' => $this->validator,
                                                            'data' => $data]);
                    }
                
                    if (DateTime::createFromFormat('d/m/Y', $data['dtfim'])->format('Y-m-d') < DateTime::createFromFormat('d/m/Y', $data['dtinicio'])->format('Y-m-d')) {
                        $this->validator->setError('dtinicio', 'A data de início não pode ser maior que a data final!');
                        return view('layouts/sub_content', ['view' => 'listaespera/form_consulta_listaespera',
                                                            'validation' => $this->validator,
                                                            'data' => $data]);
                    }
            
                    $hora = '23:59:59';
                    $data['dtfim'] = $data['dtfim'] . ' ' . $hora;
                }
            }

            $this->validator->reset();

            //die(var_dump($data));

            $result = $this->getListaEspera($data);

            if (empty($result)) {

                $data['filas'] = $this->filamodel->Where('indsituacao', 'A')->orderBy('nmtipoprocedimento', 'ASC')->findAll();
                $data['riscos'] = $this->riscomodel->Where('indsituacao', 'A')->orderBy('nmrisco', 'ASC')->findAll();
                //$data['especialidades'] = $this->aghucontroller->getEspecialidades();
                $data['especialidades'] = $this->selectespecialidadeaghu;

                session()->setFlashdata('warning_message', 'Nenhum paciente da Lista localizado com os parâmetros informados!');
                return view('layouts/sub_content', ['view' => 'listaespera/form_consulta_listaespera',
                                                    'validation' => $this->validator,
                                                    'data' => $data]);
            
            }

            //die(var_dump($result));

            if ($_SESSION['listaespera']) {
                $data['pagina_anterior'] = 'S';
            } else {
                $data['pagina_anterior'] = 'N';
            }

            $_SESSION['listaespera'] = $data;

            return view('layouts/sub_content', ['view' => 'listaespera/list_listaespera',
                                               'listaespera' => $result,
                                               'data' => $data]);
        } else {
            //if(isset($resultAGHUX) && empty($resultAGHUX)) {
            if((!empty($data['prontuario']) && is_numeric($data['prontuario'])) && is_null($paciente)) {
                $this->validator->setError('prontuario', 'Esse prontuário não existe na base do AGHUX!');
            }
            
            $data['filas'] = $this->filamodel->Where('indsituacao', 'A')->orderBy('nmtipoprocedimento', 'ASC')->findAll();
            $data['riscos'] = $this->riscomodel->Where('indsituacao', 'A')->orderBy('nmrisco', 'ASC')->findAll();
            //$data['especialidades'] = $this->aghucontroller->getEspecialidades();
            $data['especialidades'] = $this->selectespecialidadeaghu;

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
        $builder->join('vw_ordem_paciente as vo', 'vl.id = vo.id', 'inner');

        $builder->select('vl.*, vo.ordem_lista, vo.ordem_fila');

        //die(var_dump($data));

        if (!empty($data['idlista'])) {
        
            $builder->where('vl.id', $data['idlista']);
    
        } else {

            if (!empty($data['dtinicio']) && !empty($data['dtfim'])) {
                $builder->where("vl.created_at BETWEEN '$data[dtinicio]' AND '$data[dtfim]'");
            };
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

        $builder->orderBy('vl.id', 'ASC');

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

        if (isset($data['especialidade']) && isset($data['procedimento'])) {
            $builder->where('numprontuario', $data['prontuario']);
            $builder->where('idespecialidade', $data['especialidade']);
            $builder->where('idtipoprocedimento', $data['fila']);
            $builder->where('idprocedimento', $data['procedimento']);
            //$builder->where('nmlateralidade', $data['lateralidade']);

        } else {
            $builder->where('numprontuario', $data['prontuario']);
        }

        $builder->where('deleted_at IS NULL');

        //var_dump($builder->getCompiledSelect());die();
        //var_dump($builder->get()->getResult());die();

        return $builder->get()->getResult();
    }
   /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function verificaPacienteNaLista()
    {
        // Configuração para aceitar somente requisições AJAX
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Requisição inválida.'
            ])->setStatusCode(400);
        }

        // Capturar os dados enviados pela requisição POST
        $data = $this->request->getJSON(true);

        // Verificar se o prontuário foi enviado
        if (empty($data['prontuario'])) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Prontuário não informado.'
            ])->setStatusCode(422);
        }

        // Procurar o paciente na lista
        $paciente = $this->getPacienteNaLista($data);

        if ($paciente) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Paciente encontrado.',
                'data' => $paciente
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Paciente não encontrado.'
            ]);
        }
    }
    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function verificaUsoEquipamentos()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Requisição inválida.'
            ])->setStatusCode(400);
        }

        //$data = $this->request->getJSON(true);
        $data = json_decode(file_get_contents('php://input'), true);

        $idmapa = $data['idmapa'] ?? null;
        $dtcirurgia = $data['dtcirurgia'];
        $equipamentos = $data['equipamentos'];

        foreach ($equipamentos as $equip) {
            $id = (int) $equip['id'];
            $qtd = (int) $equip['qtd'];

            $qtdEmUso = $this->getQtdEquipamentoReservado($dtcirurgia, $id, $idmapa);
            
            if ( $qtdEmUso >= $qtd) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Equipamento Reservado',
                    'data' => "ideqpto=$id qtdEmUso=$qtdEmUso idMapa=$idmapa"
                ]);
            }
        }

        return $this->response->setJSON([
            'success' => false,
            'message' => 'Equipamento liberado.'
        ]);

    }
    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    private function getQtdEquipamentoReservado ($dtcirurgia, $idequipamento, $idmapa = null) 
    {
        //die(var_dump($data));

        $db = \Config\Database::connect('default');

        $builder = $db->table('equipamentos_cirurgia as ec');
        $builder->select('COUNT(*) as total');
        $builder->join('mapa_cirurgico as mc', 'mc.id = ec.idmapacirurgico');
        $builder->where('ec.idequipamento', $idequipamento);
        $builder->where('ec.deleted_at IS NULL'); 
        //$builder->where('mc.dthrcirurgia::DATE', DateTime::createFromFormat('d/m/Y', $dtcirurgia)->format('Y-m-d')); 
        $builder->where("DATE(mc.dthrcirurgia) =", DateTime::createFromFormat('d/m/Y', $dtcirurgia)->format('Y-m-d'));
        $builder->where('mc.deleted_at IS NULL'); 
        $builder->where('mc.dthrsuspensao IS NULL'); 
        $builder->where('mc.dthrtroca IS NULL'); 
        //$builder->where('mc.dthrsaidacentrocirurgico IS NULL'); 
        if ($idmapa) {
            $builder->where('mc.id !=', $idmapa); 
        }

        $query = $builder->get();
        $result = $query->getRow();

        return $result->total ?? 0;

        //die(var_dump($builder->get()->getResult()));
    }
    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function atualizaLimiteExcedidoEquipamento ($dtcirurgia, $idequipamento) 
    {
        //die(var_dump($data));

        $qtdEmUso = $this->getQtdEquipamentoReservado($dtcirurgia, (int) $idequipamento);

        $eqpto = $this->equipamentosmodel->find((int) $idequipamento);

        $eqpExcedente = ($qtdEmUso >= $eqpto->qtd);

        $db = \Config\Database::connect('default');

        $sql = "
            UPDATE equipamentos_cirurgia ec
            SET indexcedente = ?
            FROM mapa_cirurgico mc
            WHERE mc.id = ec.idmapacirurgico
            AND ec.idequipamento = ?
            AND ec.deleted_at IS NULL
            AND mc.deleted_at IS NULL
            AND mc.dthrsuspensao IS NULL
            AND mc.dthrtroca IS NULL
            AND CAST(mc.dthrcirurgia AS DATE) = ?
        ";

        $db->query($sql, [
            $eqpExcedente,
            (int) $idequipamento,
            DateTime::createFromFormat('d/m/Y', $dtcirurgia)->format('Y-m-d')
        ]);

        //die(var_dump($builder->getCompiledSelect()));
        if (!$db->affectedRows() > 0) {
            $error = $db->error();
            $errorMessage = !empty($error['message']) ? $error['message'] : 'Erro desconhecido';
            $errorCode = !empty($error['code']) ? $error['code'] : 0;

            throw new \CodeIgniter\Database\Exceptions\DatabaseException(
                sprintf('Erro ao atualizar equipamento cirúrgico excedido [%d] %s', $errorCode, $errorMessage)
            );
        }

       return $eqpExcedente;
    
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
        $builder->join('vw_ordem_paciente as vo', 'vo.id = vs.idlistaespera', 'left');
        $builder->join('local_agh_especialidades as esp', 'esp.seq = vs.idespecialidade', 'left');
        $builder->join('tipos_procedimentos as fila', 'fila.id = vs.idfila', 'left');
        //$builder->join('vw_mapacirurgico as vm', 'vs.idlistaespera = vm.idlista', 'left');
        $builder->orderBy('vs.idfila', 'ASC');
        $builder->orderBy('vo.ordem_fila', 'ASC');

        $builder->select('(vs.campos_mapa).status,
                          (vs.campos_mapa).datacirurgia,
                          (vs.campos_mapa).idmapacirurgico,
                          vs.dthrinclusao,
                          vs.idlistaespera,
                          vs.prontuario,
                          vs.nome,
                          esp.nome_especialidade as especialidade,
                          fila.nmtipoprocedimento as fila,
                          vo.ordem_lista,
                          vo.ordem_fila');

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
    public function consultarExcluidos(string $idlistaespera = null)
    {
        HUAP_Functions::limpa_msgs_flash();

        $_SESSION['listaespera'] = NULL;
        session()->remove('excluidos');

        //$data['dtinicio'] = date('d/m/Y', strtotime($this->getFirst()['created_at']));
        $data['dtinicio'] =  NULL;
        //$data['dtfim'] = date('d/m/Y');
        $data['dtfim'] = NULL;
        /* $data['filas'] = $this->filamodel->Where('indsituacao', 'A')->orderBy('nmtipoprocedimento', 'ASC')->findAll();
        $data['riscos'] = $this->riscomodel->Where('indsituacao', 'A')->orderBy('nmrisco', 'ASC')->findAll();
        $especialidades = $this->listaesperamodel->distinct()->select('idespecialidade')->findAll();
        $data['especialidades'] = $this->aghucontroller->getEspecialidades($especialidades);
        $data['origens'] = $this->origempacientemodel->Where('indsituacao', 'A')->orderBy('nmorigem', 'ASC')->findAll(); */

        $data['filas'] = $this->selectfila;
        $data['especialidades'] = $this->selectespecialidadeaghu;

        //die(var_dump($data));

        return view('layouts/sub_content', ['view' => 'listaespera/form_consulta_excluidos',
                                            'data' => $data]);

    }
    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function exibirExcluidos()
    {        
        helper(['form', 'url', 'session']);

        \Config\Services::session();

        $prontuario = null;

        $data = $this->request->getVar();

        //$dataflash = session()->getFlashdata('dataflash');

        if (session()->get('excluidos')) {
            //$data = $dataflash;
            $data = session()->get('excluidos');
        }

        if(!empty($data['prontuario']) && is_numeric($data['prontuario'])) {
            //$resultAGHUX = $this->aghucontroller->getPaciente($data['prontuario']);
            $paciente = $this->localaippacientesmodel->find($data['prontuario']);

            //if(!empty($resultAGHUX[0])) {
            if($paciente) {
                $prontuario = $data['prontuario'];
            }
            
        }

        //die(var_dump(is_null($paciente)));

        $rules = [
            'nome' => 'permit_empty|min_length[3]',
         ];

        if (!session()->get('excluidos')) {
            $rules = $rules + [
                'prontuario' => 'permit_empty|min_length[1]|max_length[8]|equals['.$prontuario.']',
            ];
        }

        if ($this->validate($rules)) {

            //die(var_dump($data['dtfim']));

            if (!session()->get('excluidos')) {
                if (!empty($data['dtinicio']) || !empty($data['dtfim'])) {

                    $data['filas'] = $this->selectfila;
                    $data['especialidades'] = $this->selectespecialidadeaghu;

                    if (empty($data['dtinicio'])) {
                        $this->validator->setError('dtinicio', 'Informe a data de início!');
                        return view('layouts/sub_content', ['view' => 'listaespera/form_consulta_excluidos',
                        'validation' => $this->validator,
                        'data' => $data]);
                    }
                    if (empty($data['dtfim'])) {
                        $this->validator->setError('dtfim', 'Informe a data final!');
                        return view('layouts/sub_content', ['view' => 'listaespera/form_consulta_excluidos',
                        'validation' => $this->validator,
                        'data' => $data]);
                    }
                    if (DateTime::createFromFormat('d/m/Y', $data['dtfim'])->format('Y-m-d') < DateTime::createFromFormat('d/m/Y', $data['dtinicio'])->format('Y-m-d')) {
                        $this->validator->setError('dtinicio', 'A data de início não pode ser maior que a data final!');
                        return view('layouts/sub_content', ['view' => 'listaespera/form_consulta_excluidos',
                                                            'validation' => $this->validator,
                                                            'data' => $data]);
                    }
                
                    $horaAtual = date('H:i:s');
                    $data['dtfim'] = $data['dtfim'] . ' ' . $horaAtual;
                }
            }

            $this->validator->reset();

            $result = $this->getExcluidos($data);

            if (empty($result)) {

                $data['filas'] = $this->filamodel->Where('indsituacao', 'A')->orderBy('nmtipoprocedimento', 'ASC')->findAll();
                $data['especialidades'] = $this->selectespecialidadeaghu;

                session()->setFlashdata('warning_message', 'Nenhum paciente a recuperar localizado com os parâmetros informados!');
                return view('layouts/sub_content', ['view' => 'listaespera/form_consulta_excluidos',
                                                    'validation' => $this->validator,
                                                    'data' => $data]);
            
            }

            //die(var_dump($result));

            if (session()->get('excluidos')) {
                $data['pagina_anterior'] = 'S';
            } else {
                $data['pagina_anterior'] = 'N';
            }

            session()->set('excluidos', $data);

            //die(var_dump($result));

            return view('layouts/sub_content', ['view' => 'listaespera/list_excluidos',
                                               'listaespera' => $result,
                                               'data' => $data]);

        } else {
            //if(isset($resultAGHUX) && empty($resultAGHUX)) {
            //die(var_dump(is_null($paciente)));
            if((!empty($data['prontuario']) && is_numeric($data['prontuario'])) && is_null($paciente)) {
                $this->validator->setError('prontuario', 'Esse prontuário não existe na base do AGHUX!');
            }
            
            $data['filas'] = $this->filamodel->Where('indsituacao', 'A')->orderBy('nmtipoprocedimento', 'ASC')->findAll();
            $data['especialidades'] = $this->selectespecialidadeaghu;

            return view('layouts/sub_content', ['view' => 'listaespera/form_consulta_excluidos',
                                               'validation' => $this->validator,
                                                'data' => $data]);
        }
    }
    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function recuperarPaciente(int $id)
    {
        HUAP_Functions::limpa_msgs_flash();

        //$data = $this->request->getVar();

        $lista = $this->listaesperamodel->withdeleted()->find($id);

        //die(var_dump($lista));

        $data = [];
        $data['id'] = $lista['id'];
        $data['ordemfila'] = '-';
        $data['prontuario'] = $lista['numprontuario'];
        $data['especialidade'] = $lista['idespecialidade'];
        $data['fila'] = $lista['idtipoprocedimento'];
        $data['justrecuperacao'] = '';
        $data['filas'] = $this->selectfila;
        $data['especialidades'] = $this->selectespecialidadeaghu;

        //var_dump($data['id']);die();

        return view('layouts/sub_content', ['view' => 'listaespera/form_recupera_listaespera',
                                            'data' => $data]);

    }
    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function recuperar()
    {
        //$data = session()->get('excluidos');

        $data = $this->request->getVar();

        //die(var_dump($data));

        $rules = [
            'especialidade' => 'required',
            'fila' => 'required',
            'justrecuperacao' => 'required'
        ];

        if ($this->validate($rules)) {

            if (!$this->filamodel->Where('indsituacao', 'A')->find($data['fila'])) {

                $this->validator->setError('fila', 'Não é possível recuperar - Fila Inativada!');

                $data['filas'] = $this->selectfila;
                $data['especialidades'] = $this->selectespecialidadeaghu;

                return view('layouts/sub_content', ['view' => 'listaespera/form_recupera_listaespera',
                                                    'data' => $data]);
            }

            try {

                $db = \Config\Database::connect('default');

                $db->transStart();

                $lista = [
                    'txtjustificativarecuperacao' => $data['justrecuperacao'],
                    'indsituacao' => 'A',
                    'dtrecuperacao' => date('Y-m-d H:i:s'),
                    'deleted_at' => NULL
                    ];

                $this->listaesperamodel->update($data['id'], $lista);

                if ($db->transStatus() === false) {
                    $error = $db->error();
                    $errorMessage = isset($error['message']) ? $error['message'] : 'Erro desconhecido';
                    $errorCode = isset($error['code']) ? $error['code'] : 0;

                    throw new \CodeIgniter\Database\Exceptions\DatabaseException(
                        sprintf('Erro ao ativar paciente na Lista! [%d] %s', $errorCode, $errorMessage)
                    );
                }

                $array = [
                    'dthrevento' => date('Y-m-d H:i:s'),
                    'idlistaespera' => $data['id'],
                    'idevento' => 9,
                    'idlogin' => session()->get('Sessao')['login']
                ];

                $this->historicomodel->insert($array);

                if ($db->transStatus() === false) {
                    $error = $db->error();
                    $errorMessage = isset($error['message']) ? $error['message'] : 'Erro desconhecido';
                    $errorCode = isset($error['code']) ? $error['code'] : 0;

                    throw new \CodeIgniter\Database\Exceptions\DatabaseException(
                        sprintf('Erro ao atualizar histórico! [%d] %s', $errorCode, $errorMessage)
                    );
                }

                $db->transComplete();
        
            } catch (\Throwable $e) {
                $db->transRollback(); // Reverte a transação em caso de erro
                $msg = 'Erro na recuperação do paciente da Lista';
                $msg .= ' - '.$e->getMessage();
                log_message('error', $msg.': ' . $e->getMessage());
                session()->setFlashdata('failed', $msg);
            }

            if ($db->transStatus() === false) {
                $dados = $this->request->getPost();
                $dataflash['idlista'] = $data['id'];
                session()->setFlashdata('dataflash', $dataflash);

            } else {
                session()->setFlashdata('success', 'Paciente recuperado com sucesso!');
            }

            return redirect()->to(base_url('listaespera/exibirexcluidos'));

        } else {
            session()->setFlashdata('error', $this->validator);

            $data['filas'] = $this->selectfila;
            $data['especialidades'] = $this->selectespecialidadeaghu;

            return view('layouts/sub_content', ['view' => 'listaespera/form_recupera_listaespera',
                                                'data' => $data]);
        }

    }
    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function getExcluidos ($data) 
    {
        //die(var_dump($data));

        $db = \Config\Database::connect('default');

        $builder = $db->table('lista_espera as le');
        $builder->join('local_aip_pacientes pac', 'le.numprontuario = pac.prontuario', 'inner');
        $builder->join('local_agh_especialidades esp', 'le.idespecialidade = esp.seq', 'inner');
        $builder->join('tipos_procedimentos as fila', 'le.idtipoprocedimento = fila.id', 'inner');

        $builder->select('
                          le.id,
                          le.created_at,
                          pac.prontuario,
                          pac.nome as nome_paciente,
                          esp.nome_especialidade,
                          fila.nmtipoprocedimento as fila
                         ');

        //die(var_dump($data));

        if (!empty($data['idlista'])) {
        
            $builder->where('le.id', $data['idlista']);
    
        } else {

            //$clausula_where = " created_at BETWEEN $dt_ini AND $dt_fim";
            if (!empty($data['dtinicio'])) {
                $builder->where("le.created_at BETWEEN '$data[dtinicio]' AND '$data[dtfim]'");
            }

            if (!empty($data['prontuario'])) {
                //$clausula_where .= " AND prontuario = $data[prontuario]";
                $builder->where('le.numprontuario', $data['prontuario']);
            };
            if (!empty($data['nome'])) {
                //$clausula_where .= " AND  nome_paciente LIKE '%".strtoupper($data['nome'])."%'";
                $builder->where('pac.nome LIKE', '%'.strtoupper($data['nome']).'%');
            };
            if (!empty($data['especialidade'])) {
                //$clausula_where .= " AND  idespecialidade = $data[especialidade]";
                $builder->where('le.idespecialidade', $data['especialidade']);
            };
            if (!empty($data['fila'])) {
                //$clausula_where .= " AND  idtipoprocedimento = $data[fila]";
                $builder->where('le.idtipoprocedimento', $data['fila']);
            };
           /*  if (!empty($data['risco'])) {
                //$clausula_where .= " AND  idrisco = $data[risco]";
                $builder->where('le.idriscocirurgico',  $data['risco']);
            };
            if (!empty($data['complexidades'])) {
                //$clausula_where .= " AND  idrisco = $data[risco]";
                $builder->whereIn('le.complexidade',  $data['complexidades']);
            }; */
        }

        $builder->where('le.indsituacao', 'E');
        $builder->where('le.indurgencia', 'N');
        $builder->where('le.deleted_at IS NOT NULL', null, false);

        $builder->orderBy('le.id', 'ASC');

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

        $data['dtinclusao'] = date('d/m/Y H:i');
        $data['ordem'] = '';
        $data['tipo_sanguineo'] = '';
        $data['filas'] = $this->selectfila;
        $data['riscos'] = $this->selectriscoativos;
        $data['origens'] = $this->selectorigempacienteativos;
        $data['lateralidades'] = $this->selectlateralidadeativos;
        $data['especialidades'] = $this->selectespecialidadeaghu;
        $data['cids'] = $this->selectcids;
        $data['procedimentos'] = $this->selectitensprocedhospitativos;
        $data['habilitasalvar'] = true;

        //var_dump($data['dtinclusao']);die();

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

        //dd($data);

        if(!empty($data['prontuario']) && is_numeric($data['prontuario'])) {
            //$resultAGHUX = $this->aghucontroller->getPaciente($data['prontuario']);
            //$paciente = $this->localaippacientesmodel->find($data['prontuario']);
            $paciente = $this->localvwdetalhespacientesmodel->find($data['prontuario']);

            //if(!empty($resultAGHUX[0])) {
            if($paciente) {
                $prontuario = $data['prontuario'];
            }
        }

        $dataform = $data;
        //$dataform['dtinclusao'] = date('d/m/Y H:i');
        //$dataform['dtrisco'] = null;
        $dataform['ordem'] = 'A definir';
        $dataform['filas'] = $this->selectfila;
        $dataform['riscos'] = $this->selectriscoativos;
        $dataform['origens'] = $this->selectorigempacienteativos;
        $dataform['lateralidades'] = $this->selectlateralidadeativos;
        $dataform['especialidades'] = $this->selectespecialidadeaghu;
        $dataform['cids'] = $this->selectcids;
        $dataform['procedimentos'] = $this->selectitensprocedhospitativos;
        $dataform['habilitasalvar'] = true;

        //die(var_dump($data['cid']));

        $rules = [
            'especialidade' => 'required',
            'dtrisco' => 'permit_empty|valid_date[d/m/Y]',
            'prontuario' => 'required|min_length[1]|max_length[12]|equals['.$prontuario.']',
            'fila' => 'required',
            'procedimento' => 'required',
            'origem' => 'required',
            'lateralidade' => 'required',
            'congelacao' => 'required',
            'complexidade' => 'required',
            'opme' => 'required',
            'cid' => 'required',
            //'risco' => 'required',
            'opme' => 'required',
            'justorig' => 'max_length[1024]|min_length[0]',
            'info' => 'max_length[1024]|min_length[0]',
        ];

        if ($this->validate($rules)) {

            $this->validator->reset();

            if((!empty($data['prontuario']) && is_numeric($data['prontuario'])) && is_null($paciente)) {
                $this->validator->setError('prontuario', 'Esse prontuário não existe na base do AGHUX!');

                return view('layouts/sub_content', ['view' => 'listaespera/form_inclui_paciente_listaespera',
                                                    //'validation' => $this->validator,
                                                    'data' => $dataform]);
            }

              /*   if ($this->getPacienteNaLista($data)) {
                    session()->setFlashdata('failed', 'Paciente já tem cirurgia cadastrada nesse dia para a mesma especialidade, fila e procedimento!');

                    return view('layouts/sub_content', ['view' => 'listaespera/form_inclui_paciente_listaespera',
                                                    //'validation' => $this->validator,
                                                    'data' => $dataform]);
                } else { */

            if (($data['origem'] == 3 || $data['origem'] == 4) && empty($data['justorig'])) { // Interesse Acadêmico
                $this->validator->setError('justorig', 'Informe a justificativa para essa origem do paciente!');

                return view('layouts/sub_content', ['view' => 'listaespera/form_inclui_paciente_listaespera',
                                                //'validation' => $this->validator,
                                                'data' => $dataform]);
            }

            if ($paciente->idade > 18) {
                if (empty($data['risco'])) {
                    $this->validator->setError('risco', 'Para maiores de 18 anos informe a situação do risco cirúrgico!');

                    return view('layouts/sub_content', ['view' => 'listaespera/form_inclui_paciente_listaespera',
                                                //'validation' => $this->validator,
                                                'data' => $dataform]);

                } else {
                    if  ($data['risco'] == 8 && empty($data['dtrisco'])) { // Risco Liberado
                        $this->validator->setError('dtrisco', 'Informe a data do risco cirúrgico!');

                        return view('layouts/sub_content', ['view' => 'listaespera/form_inclui_paciente_listaespera',
                                                        //'validation' => $this->validator,
                                                        'data' => $dataform]);

                       
                    }
                }
            }

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
                    'indopme' => $data['opme'],
                    'idprocedimento' => $data['procedimento'],
                    'idlateralidade' => $data['lateralidade'],
                    'indsituacao' => 'A',
                    'txtinfoadicionais' => $data['info'],
                    'txtorigemjustificativa' => $data['justorig'],
                ];
                
                $pacienteregistroAtual = $this->pacientesmodel->find($data['prontuario']);

                if ($pacienteregistroAtual && ($pacienteregistroAtual['updated_at'] != $data['paciente_updated_at_original'])){
                    $msg = "Este registro foi alterado por outro usuário. Recarregue a página antes de salvar.";
                    log_message('error', 'Exception: ' . $msg);
                    throw new \Exception($msg);
                }

                $idlista = $this->listaesperamodel->insert($paciente);

                if ($db->transStatus() === false) {
                    $error = $db->error();
                    $errorMessage = isset($error['message']) ? $error['message'] : 'Erro desconhecido';
                    $errorCode = isset($error['code']) ? $error['code'] : 0;

                    throw new \CodeIgniter\Database\Exceptions\DatabaseException(
                        sprintf('Erro ao incluir um paciente da Lista! [%d] %s', $errorCode, $errorMessage)
                    );
                }

                $tiposangue = [
                    'prontuario' => $data['prontuario'],
                    'tiposanguineo' => $data['tipo_sanguineo'],
                    'idalttiposanguelogin' => session()->get('Sessao')['login']
                ];

/*                 $pac = $this->pacientesmodel->find($data['prontuario']);
 */                

                //dd($data);
                if (!$pacienteregistroAtual && !empty($data['tipo_sanguineo']) ) {
                    $this->pacientesmodel->insert($tiposangue);
                } else {
                    if ($data['tipo_sanguineo_confirmado'] == '1') {
                        $tiposangue['idalttiposanguemotivo'] = $data['motivo_alteracao_hidden'];
                        $tiposangue['txtalttiposanguejustificativa'] = $data['justificativa_alteracao_hidden'];
                        $this->pacientesmodel->update($data['prontuario'], $tiposangue);
                    }
                }

                if ($db->transStatus() === false) {
                    $error = $db->error();
                    $errorMessage = isset($error['message']) ? $error['message'] : 'Erro desconhecido';
                    $errorCode = isset($error['code']) ? $error['code'] : 0;

                    throw new \CodeIgniter\Database\Exceptions\DatabaseException(
                        sprintf('Erro ao atualizar tipo de sangue do paciente! [%d] %s', $errorCode, $errorMessage)
                    );
                }

                $array = [
                    'dthrevento' => date('Y-m-d H:i:s'),
                    'idlistaespera' => $idlista,
                    'idevento' => 5,
                    'idlogin' => session()->get('Sessao')['login']
                ];

                $this->historicomodel->insert($array);

                if ($db->transStatus() === false) {
                    $error = $db->error();
                    $errorMessage = isset($error['message']) ? $error['message'] : 'Erro desconhecido';
                    $errorCode = isset($error['code']) ? $error['code'] : 0;

                    throw new \CodeIgniter\Database\Exceptions\DatabaseException(
                        sprintf('Erro ao atualizar histórico! [%d] %s', $errorCode, $errorMessage)
                    );
                }

                $db->transComplete();

                if ($db->transStatus() === false) {
                    $error = $db->error();
                    $errorMessage = isset($error['message']) ? $error['message'] : 'Erro desconhecido';
                    $errorCode = isset($error['code']) ? $error['code'] : 0;

                    throw new \CodeIgniter\Database\Exceptions\DatabaseException(
                        sprintf('Erro ao incluir um paciente da Lista! [%d] %s', $errorCode, $errorMessage)
                    );
                }

                session()->setFlashdata('success', 'Paciente incluído da Fila Cirúrgica com sucesso!');

                $ordemfila = $this->getOrdemFila($idlista);
                $dataform['ordem'] = $ordemfila ?? 'A Definir';
                $dataform['habilitasalvar'] = false;

                /* return view('layouts/sub_content', ['view' => 'listaespera/form_inclui_paciente_listaespera',
                                                    'data' => $dataform]);  */    
                $_SESSION['listaespera'] = ["fila" => $data['fila']];
                //die(var_dump($_SESSION['listaespera']));
                return redirect()->to(base_url('listaespera/exibir'));

            } catch (\Throwable $e) {
                $db->transRollback(); 
                $msg = sprintf('Erro ao incluir um paciente da Lista! - prontuário: %d - cod: (%d) msg: %s', (int) $data['prontuario'], (int) $e->getCode(), $e->getMessage());
                log_message('error', 'Exception: ' . $msg);
                session()->setFlashdata('exception', $msg);
            }
           
        } else {

            if((!empty($data['prontuario']) && is_numeric($data['prontuario'])) && is_null($paciente)) {
                $this->validator->setError('prontuario', 'Esse prontuário não existe na base do AGHUX!');
            }
        }
              
        return view('layouts/sub_content', ['view' => 'listaespera/form_inclui_paciente_listaespera',
                                            //'validation' => $this->validator,
                                            'data' => $dataform]); 

    }
    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function consultarItemLista($id, $ordemfila = null)
    {
        HUAP_Functions::limpa_msgs_flash();

        //die(var_dump($id));

        //$lista = $this->listaesperamodel->find($id);
        $lista = $this->listaesperamodel->withDeleted()->find($id);

        $data = [];
        $data['id'] = $lista['id'];
        $data['ordemfila'] = $ordemfila ?? '-';
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
        $data['idexclusao'] = $lista['idexclusao'];
        $data['justexclusao'] = $lista['txtjustificativaexclusao'];
        $data['justrecuperacao'] = $lista['txtjustificativarecuperacao'];
        $data['justificativasexclusao'] = $this->selectjustificativasexclusao;
        $data['justorig'] = $lista['txtorigemjustificativa'];
        $data['filas'] = $this->selectfila;
        $data['riscos'] = $this->selectrisco;
        $data['origens'] = $this->selectorigempaciente;
        $data['lateralidades'] = $this->selectlateralidade;
        $data['especialidades'] = $this->selectespecialidadeaghu;
        $data['cids'] = $this->selectcids;
        $data['procedimentos'] = $this->selectitensprocedhospitativos;

        /* if ($data['idexclusao']) {
            $historico = $this->historicomodel->where('idevento', 7)->where('idlistaespera', $lista['id'])->orderby('dthrevento', 'DESC')->select('dthrevento')->find();
            $data['dtexclusao'] = DateTime::createFromFormat('Y-m-d H:i:s', $historico[0]['dthrevento'])->format('d/m/Y H:i');
        } else {
            $data['dtexclusao'] = NULL;
        }

        if ($data['justrecuperacao']) {
            $historico = $this->historicomodel->where('idevento', 9)->where('idlistaespera', $lista['id'])->orderby('dthrevento', 'DESC')->select('dthrevento')->find();
            $data['dtrecuperacao'] = DateTime::createFromFormat('Y-m-d H:i:s', $historico[0]['dthrevento'])->format('d/m/Y H:i');
        } else {
            $data['dtrecuperacao'] = NULL;
        } */
        $data['dtexclusao'] = $lista['dtexclusao'];
        $data['dtrecuperacao'] = $lista['dtrecuperacao'];

        return view('layouts/sub_content', ['view' => 'listaespera/form_consulta_itemlista',
                                            'data' => $data]);

    }
    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function consultarPacienteExcluido(int $id)
    {
        HUAP_Functions::limpa_msgs_flash();

        $lista = $this->listaesperamodel->withDeleted()->find($id);

        $data = [];
        $data['id'] = $lista['id'];
        $data['ordemfila'] = '-';
        $data['dtinclusao'] = DateTime::createFromFormat('Y-m-d H:i:s', $lista['created_at'])->format('d/m/Y H:i');
        $data['dtexclusao'] = DateTime::createFromFormat('Y-m-d H:i:s', $lista['deleted_at'])->format('d/m/Y H:i');
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
        $data['procedimentos'] = $this->selectitensprocedhospitativos;
        $data['justificativasexclusao'] = $this->selectjustificativasexclusao;
        $data['idexclusao'] = $lista['idexclusao'];
        $data['justexclusao'] = $lista['txtjustificativaexclusao'];

        return view('layouts/sub_content', ['view' => 'listaespera/form_consulta_pacienteexcluido',
                                            'data' => $data]);

    }
    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function editarLista(int $id, $ordemfila = null)
    {
        HUAP_Functions::limpa_msgs_flash();

        //$data = $this->request->getVar();

        $lista = $this->listaesperamodel->find($id);
        $paciente = $this->pacientesmodel->find($lista['numprontuario']);

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
        $data['opme'] = $lista['indopme'];
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
        $data['tipo_sanguineo'] = isset($paciente) ? $paciente['tiposanguineo'] : NULL;
        $data['paciente_updated_at'] = isset($paciente) ? $paciente['updated_at'] : NULL; 
        $data['lista_updated_at'] = $lista['updated_at']; 

        //var_dump($data['procedimentos']);die();

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

        //dd($data);

        $rules = [
            'especialidade' => 'required',
            'dtrisco' => 'permit_empty|valid_date[d/m/Y]',
            'fila' => 'required',
            'procedimento' => 'required',
            'complexidade' => 'required',
            'origem' => 'required',
            'lateralidade' => 'required',
            'congelacao' => 'required',
            'opme' => 'required',
            'justorig' => 'max_length[1024]|min_length[0]',
            'info' => 'max_length[1024]|min_length[0]',
        ];

        if ($this->validate($rules)) {

            if ($data['origem'] == 3 && empty($data['justorig'])) { // Interesse Acadêmico
                $this->validator->setError('justorig', 'Informe a justificativa para essa origem do paciente!');

                $data['filas'] = $this->selectfila;
                $data['riscos'] = $this->selectrisco;
                $data['origens'] = $this->selectorigempaciente;
                $data['lateralidades'] = $this->selectlateralidade;
                $data['especialidades'] = $this->selectespecialidadeaghu;
                $data['cids'] = $this->selectcids;
                $data['procedimentos'] = $this->selectitensprocedhospit;

                return view('layouts/sub_content', ['view' => 'listaespera/form_edita_listaespera',
                                                //'validation' => $this->validator,
                                                'data' => $data]);
            }
            
            $paciente = $this->localvwdetalhespacientesmodel->find($data['prontuario']);

            if ($paciente->idade > 18) {
                if (empty($data['risco'])) {
                    $this->validator->setError('risco', 'Para maiores de 18 anos informe a situação do risco cirúrgico!');

                    $data['filas'] = $this->selectfila;
                    $data['riscos'] = $this->selectrisco;
                    $data['origens'] = $this->selectorigempaciente;
                    $data['lateralidades'] = $this->selectlateralidade;
                    $data['especialidades'] = $this->selectespecialidadeaghu;
                    $data['cids'] = $this->selectcids;
                    $data['procedimentos'] = $this->selectitensprocedhospit;

                    return view('layouts/sub_content', ['view' => 'listaespera/form_edita_listaespera',
                                                    //'validation' => $this->validator,
                                                    'data' => $data]);
                } else {
                    if ($data['risco'] == 8 && empty($data['dtrisco'])) { // Risco Liberado
                        $this->validator->setError('dtrisco', 'Informe a data do risco cirúrgico!');

                        $data['filas'] = $this->selectfila;
                        $data['riscos'] = $this->selectrisco;
                        $data['origens'] = $this->selectorigempaciente;
                        $data['lateralidades'] = $this->selectlateralidade;
                        $data['especialidades'] = $this->selectespecialidadeaghu;
                        $data['cids'] = $this->selectcids;
                        $data['procedimentos'] = $this->selectitensprocedhospit;

                        return view('layouts/sub_content', ['view' => 'listaespera/form_edita_listaespera',
                                                        //'validation' => $this->validator,
                                                        'data' => $data]);

                    }
                }
            }

            try {

                $db = \Config\Database::connect('default');

                $db->transStart();

                $lista = [
                        'idespecialidade' => $data['especialidade'],
                        'idriscocirurgico' => empty($data['risco']) ? NULL : $data['risco'],
                        'dtriscocirurgico' => empty($data['dtrisco']) ? NULL : $data['dtrisco'],
                        'numcid' => empty($data['cid']) ? NULL : $data['cid'],
                        'idcomplexidade' => $data['complexidade'],
                        'idtipoprocedimento' => $data['fila'],
                        'idorigempaciente' => $data['origem'],
                        'indcongelacao' => $data['congelacao'],
                        'indopme' => $data['opme'],
                        'idprocedimento' => $data['procedimento'],
                        'idlateralidade' => $data['lateralidade'],
                        'txtinfoadicionais' => $data['info'],
                        'txtorigemjustificativa' => $data['justorig'],
                        ];

                $pac = [
                    'prontuario' => $data['prontuario'],
                    'tiposanguineo' => $data['tipo_sanguineo'],
                    'idalttiposanguelogin' => session()->get('Sessao')['login']
                ];

                $listaregistroAtual = $this->listaesperamodel->find($data['id']);
                $pacienteregistroAtual = $this->pacientesmodel->find($data['prontuario']);

                if (($listaregistroAtual['updated_at'] != $data['lista_updated_at_original']) ||
                    ($pacienteregistroAtual && ($pacienteregistroAtual['updated_at'] != $data['paciente_updated_at_original'])) ) {
                    $msg = "Este registro foi alterado por outro usuário. Recarregue a página antes de salvar.";
                    log_message('error', 'Exception: ' . $msg);
                    throw new \Exception($msg);
                }

                if (!$pacienteregistroAtual) {

                    if (!empty($data['tipo_sanguineo'])) {
                        $this->pacientesmodel->insert($pac);
                    }

                } else {

                    if ($data['tipo_sanguineo_confirmado'] == '1') {
                        $pac['idalttiposanguemotivo'] = $data['motivo_alteracao_hidden'];
                        $pac['txtalttiposanguejustificativa'] = $data['justificativa_alteracao_hidden'];
                        $this->pacientesmodel->update($data['prontuario'], $pac);
                    }
                }

                if ($db->transStatus() === false) {
                    $error = $db->error();
                    $errorMessage = isset($error['message']) ? $error['message'] : 'Erro desconhecido';
                    $errorCode = isset($error['code']) ? $error['code'] : 0;

                    throw new \CodeIgniter\Database\Exceptions\DatabaseException(
                        sprintf('Erro ao atualizar o tipo sanguíneo do paciente! [%d] %s', $errorCode, $errorMessage)
                    );
                }

                $this->listaesperamodel->update($data['id'], $lista);

                if ($db->transStatus() === false) {
                    $error = $db->error();
                    $errorMessage = isset($error['message']) ? $error['message'] : 'Erro desconhecido';
                    $errorCode = isset($error['code']) ? $error['code'] : 0;

                    throw new \CodeIgniter\Database\Exceptions\DatabaseException(
                        sprintf('Erro ao atualizar paciente na Fila Cirúrgica! [%d] %s', $errorCode, $errorMessage)
                    );
                }

                $array = [
                    'dthrevento' => date('Y-m-d H:i:s'),
                    'idlistaespera' => $data['id'],
                    'idevento' => 6,
                    'idlogin' => session()->get('Sessao')['login']
                ];

                $this->historicomodel->insert($array);

                if ($db->transStatus() === false) {
                    $error = $db->error();
                    $errorMessage = isset($error['message']) ? $error['message'] : 'Erro desconhecido';
                    $errorCode = isset($error['code']) ? $error['code'] : 0;

                    throw new \CodeIgniter\Database\Exceptions\DatabaseException(
                        sprintf('Erro ao atualizar histórico! [%d] %s', $errorCode, $errorMessage)
                    );
                }

                $db->transComplete();

                if ($db->transStatus() === false) {
                    $error = $db->error();
                    $errorMessage = isset($error['message']) ? $error['message'] : 'Erro desconhecido';
                    $errorCode = isset($error['code']) ? $error['code'] : 0;

                    throw new \CodeIgniter\Database\Exceptions\DatabaseException(
                        sprintf('Erro ao atualizar paciente na Fila Cirúrgica! [%d] %s', $errorCode, $errorMessage)
                    );
                }

                session()->setFlashdata('success', 'Paciente alterado na Fila Cirúrgica com sucesso!');

                $this->validator->reset();
                
            } catch (\Throwable $e) {
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

            //$dados = $this->request->getPost();

            //$dataflash['idlista'] = $data['id'];

            //session()->setFlashdata('dataflash', $dataflash);
            //die(var_dump('ok'));

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

            //die(var_dump($data));
            return view('layouts/sub_content', ['view' => 'listaespera/form_edita_listaespera',
                                                'data' => $data]);
        }
    }
    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function excluirPaciente(int $id, $ordemfila = null)
    {
        HUAP_Functions::limpa_msgs_flash();

        //$data = $this->request->getVar();

        $lista = $this->listaesperamodel->find($id);

        //die(var_dump($lista));

        $data = [];
        $data['id'] = $lista['id'];
        $data['ordemfila'] = $ordemfila;
        $data['prontuario'] = $lista['numprontuario'];
        $data['especialidade'] = $lista['idespecialidade'];
        $data['fila'] = $lista['idtipoprocedimento'];
        $data['idexclusao'] = $lista['idexclusao'];
        $data['justexclusao'] = $lista['txtjustificativaexclusao'];
        $data['filas'] = $this->selectfila;
        $data['especialidades'] = $this->selectespecialidadeaghu;
        $data['justificativasexclusao'] = $this->selectjustificativasexclusao;

        //var_dump($data['id']);die();

        return view('layouts/sub_content', ['view' => 'listaespera/form_exclui_listaespera',
                                            'data' => $data]);

    }
    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function excluirPacienteDaLista()
    {
        $data_lista = session()->get('parametros_consulta_lista');
        session()->remove('parametros_consulta_lista');

        $data = $this->request->getVar();

        //die(var_dump($data));

        $rules = [
            'especialidade' => 'required',
            'fila' => 'required',
            'idexclusao' => 'required'
        ];

        if ($this->validate($rules)) {

            try {

                $db = \Config\Database::connect('default');

                $db->transStart();

                $lista = [
                    'idexclusao' => $data['idexclusao'],
                    'dtexclusao' => date('Y-m-d H:i:s'),
                    'txtjustificativaexclusao' => $data['justexclusao'],
                    'indsituacao' => 'E'
                    ];
                    
                $this->listaesperamodel->update($data['id'], $lista);

                if ($db->transStatus() === false) {
                    $error = $db->error();
                    $errorMessage = isset($error['message']) ? $error['message'] : 'Erro desconhecido';
                    $errorCode = isset($error['code']) ? $error['code'] : 0;

                    throw new \CodeIgniter\Database\Exceptions\DatabaseException(
                        sprintf('Erro ao inativar paciente da Lista! [%d] %s', $errorCode, $errorMessage)
                    );
                }

                $this->listaesperamodel->delete(['id' => $data['id']]);
        
                if ($db->transStatus() === false) {
                    $error = $db->error();
                    $errorMessage = isset($error['message']) ? $error['message'] : 'Erro desconhecido';
                    $errorCode = isset($error['code']) ? $error['code'] : 0;

                    throw new \CodeIgniter\Database\Exceptions\DatabaseException(
                        sprintf('Erro ao excluir um paciente da Lista! [%d] %s', $errorCode, $errorMessage)
                    );
                }

                $array = [
                    'dthrevento' => date('Y-m-d H:i:s'),
                    'idlistaespera' => $data['id'],
                    'idevento' => 7,
                    'idlogin' => session()->get('Sessao')['login']
                ];

                $this->historicomodel->insert($array);

                if ($db->transStatus() === false) {
                    $error = $db->error();
                    $errorMessage = isset($error['message']) ? $error['message'] : 'Erro desconhecido';
                    $errorCode = isset($error['code']) ? $error['code'] : 0;

                    throw new \CodeIgniter\Database\Exceptions\DatabaseException(
                        sprintf('Erro ao atualizar histórico! [%d] %s', $errorCode, $errorMessage)
                    );
                }

                $db->transComplete();
        
            } catch (\Throwable $e) {
                $db->transRollback(); // Reverte a transação em caso de erro
                $msg = 'Erro na exclusão do paciente da Lista';
                $msg .= ' - '.$e->getMessage();
                log_message('error', $msg.': ' . $e->getMessage());
                session()->setFlashdata('failed', $msg);
            }

            if ($db->transStatus() === false) {
                $dados = $this->request->getPost();
                $dataflash['idlista'] = $data['id'];
                session()->setFlashdata('dataflash', $dataflash);

            } else {
                session()->setFlashdata('success', 'Paciente excluído da Fila Cirúrgica com sucesso!');
            }

            return redirect()->to(base_url('listaespera/exibir'));

        } else {
            session()->setFlashdata('error', $this->validator);

            $data['filas'] = $this->selectfila;
            $data['especialidades'] = $this->selectespecialidadeaghu;
            $data['justificativasexclusao'] = $this->selectjustificativasexclusao;

            return view('layouts/sub_content', ['view' => 'listaespera/form_exclui_listaespera',
                                                'data' => $data]);
        }

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
        $data['ordemfila'] = $this->getListaEspera(['idlista' => $id])[0]->ordem_fila;
        $data['id'] = $lista['id'];
        $data['dtcirurgia'] = date('d/m/Y', strtotime('+3 days'));
        $data['hrcirurgia'] = '';
        $data['tempoprevisto'] = '';
        $data['prontuario'] = $lista['numprontuario'];
        $data['especialidade'] = $lista['idespecialidade'];
        $data['risco'] = $lista['idriscocirurgico'];
        $data['dtrisco'] = $lista['dtriscocirurgico'] ? DateTime::createFromFormat('Y-m-d', $lista['dtriscocirurgico'])->format('d/m/Y') : NULL;
        $data['cid'] = $lista['numcid'];
        $data['complexidade'] = $lista['idcomplexidade'];
        $data['fila'] = $lista['idtipoprocedimento'];
        $data['origem'] = $lista['idorigempaciente'];
        $data['congelacao'] = $lista['indcongelacao'];
        $data['opme'] = $lista['indopme'];
        $data['procedimento'] = $lista['idprocedimento'];
        $data['proced_adic'] = [];
        $data['eqpts'] = [];
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
        $data['usarEquipamentos'] = 'N';
        $data['equipamentos'] = $this->selectequipamentos;
        $data['procedimentos'] = $this->selectitensprocedhospitativos;
        $data['especialidades_med'] = $this->selectespecialidadeaghu;
        $data['prof_especialidades'] = $this->selectprofespecialidadeaghu;
        $data['usarHemocomponentes'] = 'N';
        $data['hemocomponentes'] = $this->selecthemocomponentes;
        $data['hemocomps'] = [];
        $data['tipo_sanguineo'] = $lista['tiposanguineo'];

        $codToRemove = $lista['idprocedimento'];
        $procedimentos = $data['procedimentos'];
        $data['procedimentos_adicionais'] = array_filter($procedimentos, function($procedimento) use ($codToRemove) {
            return $procedimento->cod_tabela !== $codToRemove;
        });

        //var_dump($data);die();

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

        //dd($this->data);

        $rules = [
            'especialidade' => 'required',
            //'dtrisco' => 'required|valid_date[d/m/Y]',
            'dtcirurgia' => 'required|valid_date[d/m/Y]',
            'hrcirurgia' => 'required|valid_time[H:i]',
            'tempoprevisto' => 'required|valid_time[H:i]',
            'hemoderivados' => 'required',
            //'risco' => 'required',
            'procedimento' => 'required',
            'posoperatorio' => 'required',
            'profissional' => 'required',
            'lateralidade' => 'required',
            'complexidade' => 'required',
            'congelacao' => 'required',
            'opme' => 'required',
            'eqpts' => ($this->data['usarEquipamentos'] ?? '') == 'S' ? 'required' : 'permit_empty',
            'hemocomps' => ($this->data['usarHemocomponentes'] ?? '') == 'S' ? 'required' : 'permit_empty',
            'justorig' => 'max_length[1024]|min_length[0]',
            'info' => 'max_length[1024]|min_length[0]',
            'nec_proced' => 'required|max_length[250]|min_length[3]',
        ];

        if ($this->validate($rules)) {

            $db = \Config\Database::connect('default');

            //$dataCirurgia = DateTime::createFromFormat('d/m/Y H:i', $this->data['dtcirurgia'])->setTime(0, 0);
            $dataCirurgia = DateTime::createFromFormat('d/m/Y H:i', $this->data['dtcirurgia'] . ' ' . substr($this->data['hrcirurgia'], 0, 5));

            //dd($dataCirurgia);

            $dataComparacao = new DateTime();
            $dataComparacao->modify('+'.DIAS_AGENDA_CIRURGICA.' days')->setTime(0, 0);
            
            if ($dataCirurgia->getTimestamp() < $dataComparacao->getTimestamp()) {
                $this->validator->setError('dtcirurgia', 'O tempo mínimo para agendar uma cirurgia eletiva é de '.DIAS_AGENDA_CIRURGICA.' dias!');

                $this->carregaMapa();

                return view('layouts/sub_content', ['view' => 'listaespera/form_envia_mapacirurgico',
                                                    'data' => $this->data]);
            }

            if (empty($this->data['justenvio'])) {

                $tempacfila = $this->vwordempacientemodel->where('idfila', $this->data['fila'])
                                                         ->where('ordem_fila <', $this->data['ordemfila'])->findAll();

                if ($tempacfila) {
                    $this->validator->setError('justenvio', 'Informe a justificativa para o envio ao mapa cirúrgico um paciente fora da ordem da lista!');

                    $this->carregaMapa();

                    return view('layouts/sub_content', ['view' => 'listaespera/form_envia_mapacirurgico',
                                                        'data' => $this->data]);
                }

            }

            $paciente = $this->localvwdetalhespacientesmodel->find($this->data['prontuario']);

            if ($paciente->idade > 18) {
                if (empty($this->data['risco'])) {
                    $this->validator->setError('risco', 'Para maiores de 18 anos informe a situação do risco cirúrgico!');

                    $this->carregaMapa();

                    return view('layouts/sub_content', ['view' => 'listaespera/form_envia_mapacirurgico',
                                                        'data' => $this->data]);

                } else {
                    if ($this->data['risco'] != 8) { // Risco Liberado
                        $this->validator->setError('risco', 'Para envio do paciente ao mapa o risco cirúrgico deve estar liberado!');
                        $this->carregaMapa();
        
                        return view('layouts/sub_content', ['view' => 'listaespera/form_envia_mapacirurgico',
                                                            'data' => $this->data]);
                    }
                }
            }

            $data_clone = $this->data;
            $data_clone['listapaciente'] = $this->data['id'];
            //$data_clone['dtcirurgia'] = DateTime::createFromFormat('d/m/Y H:i', $this->data['dtcirurgia'])->format('Y-m-d');
            $data_clone['dtcirurgia'] = $dataCirurgia->format('Y-m-d');
            if ($this->filawebmodel->getPacienteNoMapa($data_clone)) {
                session()->setFlashdata('failed', 'Esse paciente já tem uma cirurgia programada para esse dia!');

                $this->carregaMapa();

                return view('layouts/sub_content', ['view' => 'listaespera/form_envia_mapacirurgico',
                                                    'data' => $this->data]);
            }

            if (!$this->localfatitensprocedhospitalarmodel->Where('ind_situacao', 'A')->find($this->data['procedimento'])) {
                $this->validator->setError('procedimento', 'Esse procedimento foi desativado no AGHUX!');

                $this->carregaMapa();

                return view('layouts/sub_content', ['view' => 'listaespera/form_envia_mapacirurgico',
                                                    'data' => $this->data]);
            }

            if (!$this->lateralidademodel->Where('indsituacao', 'A')->find($this->data['lateralidade'])) {
                $this->validator->setError('lateralidade', 'Informe a Lateralidade!');

                $this->carregaMapa();

                return view('layouts/sub_content', ['view' => 'listaespera/form_envia_mapacirurgico',
                                                    'data' => $this->data]);
            }

            if (!$this->origempacientemodel->Where('indsituacao', 'A')->find($this->data['origem'])) {
                $this->validator->setError('origem', 'Esse tipo de origem foi desativado!');

                $this->carregaMapa();

                return view('layouts/sub_content', ['view' => 'listaespera/form_envia_mapacirurgico',
                                                    'data' => $this->data]);
            }

            if ($this->data['tempoprevisto'] == '00:00') {
                $this->validator->setError('tempoprevisto', 'Informe um tempo previsto maior que zero!');

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
                        'indopme' => $this->data['opme'],
                        'tiposanguineo' => $this->data['tipo_sanguineo'],
                        'idlateralidade' => $this->data['lateralidade'],
                        'txtinfoadicionais' => $this->data['info'],
                        'txtorigemjustificativa' => $this->data['justorig'],
                        //'indsituacao' => $this->data['idsituacao_cirurgia_hidden'] // (P) Programada ou (EA) Em Aprovação
                        'indsituacao' => 'P' // Programada
                        ];

                        //dd($lista);
                $this->listaesperamodel->update($this->data['id'], $lista);

                if ($db->transStatus() === false) {
                    $error = $db->error();
                    $errorMessage = !empty($error['message']) ? $error['message'] : 'Erro desconhecido';
                    $errorCode = !empty($error['code']) ? $error['code'] : 0;

                    throw new \CodeIgniter\Database\Exceptions\DatabaseException(
                        sprintf('Erro ao atualizar Fila Cirúrgica [%d] %s', $errorCode, $errorMessage)
                    );
                }

                $mapa = [
                    'idlistaespera' => $this->data['id'],
                    //'dthrcirurgia' => $this->data['dtcirurgia'],
                    'dthrcirurgia' => $dataCirurgia->format('d/m/Y H:i:s'),
                    'tempoprevisto' => $this->data['tempoprevisto'],
                    //'tempoprevisto' => $tempoprevisto = DateTime::createFromFormat('H:i', $this->data['tempoprevisto']),
                    'idposoperatorio' => $this->data['posoperatorio'],
                    'indhemoderivados' => $this->data['hemoderivados'],
                    'txtnecessidadesproced' => $this->data['nec_proced'],
                    'txtjustificativaenvio' => $this->data['justenvio'],
                    'numordem' => $this->data['ordemfila'],
                    'indsituacao' => 'P' // Programada
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

                if (isset($this->data['eqpts'])) {

                    foreach ($this->data['eqpts'] as $key => $equipamento) {

                        $dtcirurgia = $dataCirurgia->format('d/m/Y');

                        /* $qtdEmUso = $this->getQtdEquipamentoReservado($dtcirurgia, (int) $equipamento);

                        $eqpto = $this->equipamentosmodel->find((int) $equipamento);

                        $eqpExcedente = ($qtdEmUso >= $eqpto->qtd); 

                        if ($eqpExcedente) {
                        
                            if (!$this->atualizaLimiteExcedidoEquipamento($dtcirurgia, (int) $equipamento)) {

                                $error = $db->error();
                                $errorMessage = !empty($error['message']) ? $error['message'] : 'Erro desconhecido';
                                $errorCode = !empty($error['code']) ? $error['code'] : 0;
            
                                throw new \CodeIgniter\Database\Exceptions\DatabaseException(
                                    sprintf('Erro ao atualizar equipamento cirúrgico excedido [%d] %s', $errorCode, $errorMessage)
                                );

                            }
                        }
                        */

                        $eqpExcedente = $this->filawebmodel->atualizaLimiteExcedidoEquipamento($dtcirurgia, (int) $equipamento);
                        $array['idmapacirurgico'] = (int) $idmapa;
                        $array['idequipamento'] = (int) $equipamento;
                        $array['indexcedente'] = $eqpExcedente;

                        $this->equipamentoscirurgiamodel->insert($array);

                        if ($db->transStatus() === false) {
                            $error = $db->error();
                            $errorMessage = !empty($error['message']) ? $error['message'] : 'Erro desconhecido';
                            $errorCode = !empty($error['code']) ? $error['code'] : 0;
        
                            throw new \CodeIgniter\Database\Exceptions\DatabaseException(
                                sprintf('Erro ao inserir equipamento cirúrgico [%d] %s', $errorCode, $errorMessage)
                            );
                        }

                    }
                }

                if (isset($this->data['hemocomps'])) {

                    foreach ($this->data['hemocomps'] as $key => $hemocomponente) {

                        $array['idmapacirurgico'] = (int) $idmapa;
                        $array['idhemocomponente'] = (int) $hemocomponente;
                        $array['inddisponibilidade'] = false;

                        $this->hemocomponentescirurgiamodel->insert($array);

                        if ($db->transStatus() === false) {
                            $error = $db->error();
                            $errorMessage = !empty($error['message']) ? $error['message'] : 'Erro desconhecido';
                            $errorCode = !empty($error['code']) ? $error['code'] : 0;
        
                            throw new \CodeIgniter\Database\Exceptions\DatabaseException(
                                sprintf('Erro ao inserir hemocomponente cirúrgico [%d] %s', $errorCode, $errorMessage)
                            );
                        }

                    }
                }

                $this->listaesperamodel->delete($this->data['id']);

                /* if ($this->data['idsituacao_cirurgia_hidden'] === 'EA') { // Em Aprovação
                    $this->mapacirurgicomodel->delete($idmapa);
                } */

                if ($db->transStatus() === false) {
                    $error = $db->error();
                    $errorMessage = !empty($error['message']) ? $error['message'] : 'Erro desconhecido';
                    $errorCode = !empty($error['code']) ? $error['code'] : 0;

                    throw new \CodeIgniter\Database\Exceptions\DatabaseException(
                        sprintf('Erro ao excluir paciente da lista [%d] %s', $errorCode, $errorMessage)
                    );
                }

                $array = [
                    'dthrevento' => date('Y-m-d H:i:s'),
                    'idlistaespera' => $this->data['id'],
                    //'idevento' => $this->data['idsituacao_cirurgia_hidden'] === 'P' ? 1 : 12,
                    'idevento' => 1,
                    'idlogin' => session()->get('Sessao')['login']
                ];

                $this->historicomodel->insert($array);

                if ($db->transStatus() === false) {
                    $error = $db->error();
                    $errorMessage = isset($error['message']) ? $error['message'] : 'Erro desconhecido';
                    $errorCode = isset($error['code']) ? $error['code'] : 0;

                    throw new \CodeIgniter\Database\Exceptions\DatabaseException(
                        sprintf('Erro ao atualizar histórico! [%d] %s', $errorCode, $errorMessage)
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
                
            } catch (\Throwable $e) {
                $db->transRollback(); // Reverte a transação em caso de erro
                $msg = sprintf('Falha no envio do paciente para o Mapa Cirúrgico - prontuário: %d - cod: (%d) msg: %s', (int) $this->data['prontuario'], (int) $e->getCode(), $e->getMessage());
                log_message('error', 'Exception: ' . $msg);
                session()->setFlashdata('exception', $msg);
            }

            //$this->carregaMapa();

            //return view('layouts/sub_content', ['view' => 'listaespera/form_envia_mapacirurgico',
                                                //'data' => $this->data]);

            return redirect()->to(base_url('listaespera/exibir'));

        } else {
            session()->setFlashdata('error', $this->validator);

            $this->carregaMapa();

           // die(var_dump($this->data));

            return view('layouts/sub_content', ['view' => 'listaespera/form_envia_mapacirurgico',
                                                //'validation' => $this->validator,
                                                'data' => $this->data]);
        }
    }
    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function verPacienteNaFrente()
    {

        try {
            $request = service('request');

            if (!$request->isAJAX()) {
                throw new \Exception('Acesso não autorizado');
            }

            $arrayidJson = $this->request->getPost('arrayid');

            if (empty($arrayidJson)) {
                throw new \Exception('Parâmetros ausentes');
            }

            $arrayid = json_decode($arrayidJson, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception('Erro ao decodificar JSON: ' . json_last_error_msg());
            }


            $tempaciente = $this->vwordempacientemodel->where('idfila', $arrayid['idFila'])
                                            ->where('ordem_fila <', $arrayid['nuOrdem'])->findAll();

            if (!empty($tempaciente))
                return $this->response->setJSON(['success' => true, 'message' => 'Tem paciente']);
            else
                return $this->response->setJSON(['success' => true, 'message' => 'NÂO tem paciente']);

        } catch (\Throwable $e) {

            return $this->response->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR)
                                    ->setJSON(['success' => false, 'message' => $e->getMessage()]);
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

        } catch (\Throwable $e) {
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

            } catch (\Throwable $e) {
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
        $this->data['equipamentos'] = $this->selectequipamentos;
        $this->data['procedimentos'] = $this->selectitensprocedhospit;
        $this->data['especialidades_med'] = $this->selectespecialidadeaghu;
        $this->data['prof_especialidades'] = $this->selectprofespecialidadeaghu;
        $this->data['hemocomponentes'] = $this->selecthemocomponentes;

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

        session()->remove('listsituacaocirurgica');

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

        $listsituacaocirurgica = session()->get('listsituacaocirurgica');

        if ($listsituacaocirurgica) {
            $data = $listsituacaocirurgica;
        } else {
            $data = $this->request->getVar();
        }

        if(!empty($data['prontuario']) && is_numeric($data['prontuario'])) {
            //$resultAGHUX = $this->aghucontroller->getPaciente($data['prontuario']);
            $paciente = $this->localaippacientesmodel->find($data['prontuario']);

            //if(!empty($resultAGHUX[0])) {
            if($paciente) {
                $prontuario = $data['prontuario'];
            }
        }

        $rules = [
            'nome' => 'permit_empty|min_length[3]',
         ];

        if (!$listsituacaocirurgica) {
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

            if ($listsituacaocirurgica) {
                $data['pagina_anterior'] = 'S';
            } else {
                $data['pagina_anterior'] = 'N';
            }

            $listsituacaocirurgica = session()->set('listsituacaocirurgica', $data);

            return view('layouts/sub_content', ['view' => 'listaespera/list_listasituacaocirurgica',
                                               'listaespera' => $result,
                                                'data' => $data]);
        } else {
            //die(var_dump(is_null($paciente)));
            //if(isset($resultAGHUX) && empty($resultAGHUX)) {
            if((!empty($data['prontuario']) && is_numeric($data['prontuario'])) && is_null($paciente)) {
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
    public function sincronizar($prontuario) {

        $db = \Config\Database::connect();

        $db->transStart();

        $db->table('local_aip_pacientes')->truncate();
        $db->table('local_aip_contatos_pacientes')->truncate();
        $db->table('local_vw_detalhes_pacientes')->truncate();

        $insertStatus = 'starting';
        $insertStatus = $db->query('INSERT INTO local_aip_pacientes SELECT * FROM remoto.aip_pacientes');
        $insertStatus = $db->query('INSERT INTO local_aip_contatos_pacientes SELECT * FROM remoto.aip_contatos_pacientes;');
        $insertStatus = $db->query('INSERT INTO local_vw_detalhes_pacientes SELECT * FROM remoto.vw_detalhes_pacientes;');

        $db->transComplete(); 

        if ($db->transStatus() === FALSE) {
            $error = $db->error();
            $msg = 'Falha na sincronização - ' . $error['message'];
            echo json_encode(['error' => $msg]);
        } else {
            $paciente = $this->localvwdetalhespacientesmodel->find($prontuario);
            echo json_encode(['nome' => $paciente->nome]);
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
                SELECT DISTINCT
                    cl.idlistacirurgica,
                    cl.prontuario,
                    cl.datainclusao,
                    CAST(cl.datainclusao || ' ' || cl.horainclusao AS TIMESTAMP) AS dthr_inclusao,
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
                    --CASE 
                        --WHEN cl.situacao = 0
                        --WHEN cl.situacao = 1
                    --END AS situacao,
                    cl.situacao,
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
                $lista['txtinfoadicionais'] = $reg->informacoesadicionais;
                $lista['txtorigemjustificativa'] = $reg->justificativa;
                $lista['txtjustificativaexclusao'] = $reg->justificativa_exclusao;
                $lista['indcongelacao'] = $reg->congelacao;
                $lista['created_at'] = $reg->dthr_inclusao;
                $lista['updated_at'] = $reg->dthr_inclusao;

                switch ($reg->situacao) {
                    case 0:

                        $sql = "
                        select *
                        from cirurgias_mapacirurgico cm 
                        where idlistacirurgica = $reg->idlistacirurgica
                        ;";

                        $query = $db->query($sql);
            
                        $result1 = $query->getResult();

                        if (!$result1) {
                            $historico = $this->historicomodel->where('idevento', 7)->where('idlistaespera', $reg->idlistacirurgica)->orderby('dthrevento', 'DESC')->select('dthrevento')->find();


                            $lista['deleted_at'] = empty($historico[0]) ? date('Y-m-d H:i:s') : $historico[0]['dthrevento'];
                            $lista['dtexclusao'] =  $lista['deleted_at'];
                            $lista['idexclusao'] = 48; // SEM IDENTIFICAÇÃO - MIGRAÇÃO SISTEMA LEGADO

                            $lista['indsituacao'] = 'E'; // Excluído

                        } else {

                            /* $sql = "
                                    select *
                                    from cirurgias_historico ch 
                                    where idlistacirurgica = $reg->idlistacirurgica
                                    order by ch.data desc 
                                    limit 1;
                                    ";
            
                            $query = $db->query($sql);
                
                            $result2 = $query->getResult(); */

                            $result2 = $this->historicomodel->where('idlistaespera', $reg->idlistacirurgica)->orderby('dthrevento', 'DESC')->find();

                            if (!empty($result2[0])) {

                                //die(var_dump($result2));

                                switch ($result2[0]['idevento']) {
                                    case 1: // envio ao mapa
                                        $lista['deleted_at'] = $result2[0]['dthrevento'];
                                        $lista['dtexclusao'] =  $lista['deleted_at'];

                                        $lista['indsituacao'] = 'P'; // Programada

                                        break;

                                    case 2: // cancelamento por suspensão
                                        $lista['deleted_at'] =$result2[0]['dthrevento'];
                                        $lista['dtexclusao'] =  $lista['deleted_at'];
                                        $lista['idexclusao'] = 48; // SEM IDENTIFICAÇÃO - MIGRAÇÃO SISTEMA LEGADO

                                        $lista['indsituacao'] = 'E'; // Excluído

                                        break;

                                    case 4: // cirurgia realizada

                                       /*  $sql = "
                                            select *
                                            from cirurgias_historico ch 
                                            where idlistacirurgica = $reg->idlistacirurgica
                                            and idevento = 1
                                            order by ch.data desc 
                                            limit 1;
                                            ";
                
                                        $query = $db->query($sql);
                            
                                        $resulthist = $query->getResult(); */

                                        // verifica quando foi enviado ao mapa
                                        $resulthist = $this->historicomodel->where('idevento', 1)->where('idlistaespera', $reg->idlistacirurgica)->orderby('dthrevento', 'DESC')->select('dthrevento')->find();

                                        if (!empty($resulthist[0])) {
                                            $lista['deleted_at'] = $resulthist[0]['dthrevento']; // data do ultimo envio ao mapa

                                        } else {
                                            $lista['deleted_at'] = $result2[0]['dthrevento']; // pegar a data da realização da cirurgia
                                        }

                                        $lista['indsituacao'] = 'P'; // Programada

                                        break;

                                    case 7: // exclusão
                                        $lista['deleted_at'] = $result2[0]['dthrevento'];
                                        $lista['dtexclusao'] =  $lista['deleted_at'];
                                        $lista['idexclusao'] = 48; // SEM IDENTIFICAÇÃO - MIGRAÇÃO SISTEMA LEGADO

                                        $lista['indsituacao'] = 'E'; // Excluído

                                        break;

                                    default:
                                        $lista['deleted_at'] = date('Y-m-d H:i:s');

                                        $lista['indsituacao'] = 'P'; // Programado
                                }

                            } else {
                                $lista['deleted_at'] = date('Y-m-d H:i:s');

                                $lista['indsituacao'] = 'P'; // Programado
                            }
                        }

                        break;

                    case 1:
                        $temaghu = $this->localaippacientesmodel->Where('prontuario', $reg->prontuario)->findAll();

                        if ($temaghu) {
                            $lista['deleted_at'] = NULL;

                            $lista['indsituacao'] = 'A'; // Aguardando


                        } else {
                            $lista['deleted_at'] = date('Y-m-d H:i:s'); 

                            $lista['indsituacao'] = 'X'; // Erro
                        }
                       
                        break;

                    default:
                        $lista['deleted_at'] = NULL;

                        $lista['indsituacao'] = 'I'; // Indefinido

                }

                $sql = "
                    select *
                    from cirurgias_listacirurgica lista 
                    inner join cirurgias_mapacirurgico mapa on mapa.idlistacirurgica = lista.idlistacirurgica 
                    where lista.idlistacirurgica = $reg->idlistacirurgica
                    order by mapa.idmapacirurgico 
                    limit 1;
                ";

                $query = $db->query($sql);

                $result2 = $query->getResult();

                if ($result2) {

                    $dataHoraLista = new DateTime($reg->datainclusao);
                    $dataHoraMapa = new DateTime($result2[0]->datacirurgia);

                    $diferenca = $dataHoraMapa->diff($dataHoraLista);

                    if ($diferenca->days < 3 ) {
                        $lista['indurgencia'] = 'S';
                    } else {
                        $lista['indurgencia'] = 'N';
                    }
                } else {

                    $lista['indurgencia'] = 'N';
                }

                $this->listaesperamodel->insert($lista);

                if ($db->transStatus() === false) {
                    $error = $db->error();
                    $errorMessage = isset($error['message']) ? $error['message'] : 'Erro desconhecido';
                    $errorCode = isset($error['code']) ? $error['code'] : 0;

                    throw new \CodeIgniter\Database\Exceptions\DatabaseException(
                        sprintf('Erro ao incluir Fila Cirúrgica! [%d] %s', $errorCode, $errorMessage)
                    );
                }

            }

            $db->transComplete();

            if ($db->transStatus() === false) {
                $error = $db->error();
                $errorMessage = isset($error['message']) ? $error['message'] : 'Erro desconhecido';
                $errorCode = isset($error['code']) ? $error['code'] : 0;

                throw new \CodeIgniter\Database\Exceptions\DatabaseException(
                    sprintf('Erro na criação da Fila Cirúrgica! [%d] %s', $errorCode, $errorMessage)
                );
            }

            $query = $db->query($sqlSetVal);

            $query = $db->query($sqlSetDefault);

        } catch (\Throwable $e) {
            $msg = 'Falha na criação da Fila Cirúrgica - '. (isset($reg->prontuario) ? $reg->prontuario : '') .' ==> '.$e->getMessage();
            log_message('error', $msg.': ' . $e->getMessage());
            throw $e;
        }

    }

}