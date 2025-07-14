<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TransfusaoModel;
use App\Models\LocalFatItensProcedHospitalarModel;
use App\Models\HemocomponentesModel;
use App\Models\LocalProfEspecialidadesModel;
use App\Models\HistoricoModel;
use App\Models\LocalVwServidoresModel;
use App\Models\LocalAipPacientesModel;
use App\Models\transfusaoExpHemocompModel;

use DateTime;
use App\Libraries\HUAP_Functions;


class Transfusao extends BaseController
{
    protected $transfusaoModel;

    private $hemocomponentesmodel;
    private $selecthemocomponentes;
    private $selectitensprocedhospitativos;
    private $selectservidores;
    private $selectprofespecialidadeaghu;
    private $localfatitensprocedhospitalarmodel;
    private $localprofespecialidadesmodel;
    private $transfusaomodel;
    private $historicomodel;
    private $localvwservidoresmodel;
    private $localaippacientesmodel;
    private $transfusaoexphemocompmodel;

    private $data;

    public function __construct()
    {
        $this->transfusaoModel = new TransfusaoModel();
        $this->hemocomponentesmodel = new HemocomponentesModel();
        $this->localfatitensprocedhospitalarmodel = new LocalFatItensProcedHospitalarModel();
        $this->localprofespecialidadesmodel = new LocalProfEspecialidadesModel();
        $this->transfusaomodel = new TransfusaoModel();
        $this->historicomodel = new HistoricoModel();
        $this->localvwservidoresmodel = new LocalVwServidoresModel();
        $this->localaippacientesmodel = new LocalAipPacientesModel();
        $this->transfusaoexphemocompmodel = new transfusaoExpHemocompModel();
              
        $this->selecthemocomponentes = $this->hemocomponentesmodel->orderBy('id', 'ASC')->findAll();
        $this->selectitensprocedhospitativos = $this->localfatitensprocedhospitalarmodel->Where('ind_situacao', 'A')->orderBy('descricao', 'ASC')->findAll();        //$this->selectsalascirurgicasaghu = $this->vwsalascirurgicasmodel->findAll();
        $this->selectprofespecialidadeaghu = $this->localprofespecialidadesmodel->like('conselho', 'CRM', 'after')->orderBy('nome', 'ASC')->findAll(); 
        $this->selectservidores = $this->localvwservidoresmodel->orderBy('nome', 'ASC')->findAll();

    }

    public function index()
    {
        $dados['registros'] = $this->transfusaoModel->findAll();
        return view('transfusao/listar', $dados);
    }

    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function RequisitarTransfusao()
    {
        HUAP_Functions::limpa_msgs_flash();

        //session()->remove('inclusao_sucesso');

       //dd($data);

       $data = [];
        //$data['listaespera'] = $this->vwlistaesperamodel->Where('prontuario', $prontuario)->findAll();
        $data['coletor'] = null;
        $data['pac_codigo'] = '';
        $data['procedimentos'] = $this->selectitensprocedhospitativos;
        $data['prof_especialidades'] = $this->selectprofespecialidadeaghu;
        $data['servidores'] = $this->selectservidores;

        return view('layouts/sub_content', ['view' => 'transfusao/form_req_transfusao',
                                           'data' => $data]);

    }
    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function incluir()
    {
        //ini_set('memory_limit', '1024M');

        \Config\Services::session();

        helper(['form', 'url', 'session']);

        $prontuario = null;

        $this->data = [];

        $this->data = $this->request->getPost();

        //dd($this->data);

        $rules = [
            //'prontuario' => 'required|min_length[1]|max_length[12]|equals['.$prontuario.']',
            'prontuario' => 'required|integer',
            'diagnostico' => 'required|max_length[250]|min_length[3]',
            'indicacao' => 'required|max_length[250]|min_length[3]',
            //'listapaciente' => string (0) ""
            'peso' => 'required|numeric',
            'sangramento' => 'required',
            'transfusao_anterior' => 'required',
            'reacao_transf' => 'required',
            'ch' => 'required|numeric',
            'cp' => 'required|numeric',
            'pfc' => 'required|numeric',
            'crio' => 'required|numeric',
            'hematocrito' => 'required|numeric',
            'dt_hematocrito' => 'required|valid_date[Y-m-d]',
            'hemoglobina' => 'required|numeric',
            'dt_hemoglobina' => 'required|valid_date[Y-m-d]',
            'plaquetas' => 'required|numeric',
            'dt_plaquetas' => 'required|valid_date[Y-m-d]',
            'tap' => 'required|numeric',
            'dt_tap' => 'required|valid_date[Y-m-d]',
            'inr' => 'required|numeric',
            'dt_inr' => 'required|valid_date[Y-m-d]',
            'ptt' => 'required|numeric',
            'dt_ptt' => 'required|valid_date[Y-m-d]',
            'fibrinogenio' => 'required|numeric',
            'dt_fibrinogenio' => 'required|valid_date[Y-m-d]',
            //'tipo_transfusao' => string (6) "rotina"
            'reserva_data' => 'permit_empty|valid_date[Y-m-d]',
            //'nome_coletor' => string (8) "eeeeeeee"
            'dt_coleta' => 'required|valid_date[Y-m-d]',
            'hr_coleta' => 'required|valid_time[H:i]',
            'medico_solicitante' => 'required|integer',
            'medico_solicitante' => 'required|integer',
            'dt_solicitacao' => 'required|valid_date[Y-m-d]',
            'hr_solicitacao' => 'required|valid_time[H:i]',
            //'observacoes' => 'required|max_length[250]|min_length[3]',
        ];

        $camposData = [
            'dt_hematocrito',
            'dt_hemoglobina',
            'dt_plaquetas',
            'dt_tap',
            'dt_inr',
            'dt_ptt',
            'dt_fibrinogenio',
            'reserva_data',
            'dt_coleta',
            'dt_solicitacao'
        ];

        // Formatar os campos de data simples
        foreach ($camposData as $campo) {
            if (!empty($this->data[$campo])) {
                $this->data[$campo] = date('d/m/Y', strtotime($this->data[$campo]));
            }
        }

        // Campos que têm data e hora separadas — vamos sobrescrevê-los com a junção formatada
        $camposDataHora = [
            ['data' => 'dt_coleta', 'hora' => 'hr_coleta'],
            ['data' => 'dt_solicitacao', 'hora' => 'hr_solicitacao'],
        ];

        foreach ($camposDataHora as $par) {
            $campoData = $par['data'];
            $campoHora = $par['hora'];

            if (!empty($this->data[$campoData]) && !empty($this->data[$campoHora])) {
                $dataHora = DateTime::createFromFormat('d/m/Y H:i', $this->data[$campoData] . ' ' . $this->data[$campoHora]);
                if ($dataHora) {
                    // Sobrescreve o campo de data com a data formatada completa
                    $this->data[$campoData] = $dataHora->format('d/m/Y H:i');
                    // Opcional: zera o campo de hora (ou você pode remover, se preferir)
                    unset($this->data[$campoHora]);
                }
            }
        }

        $this->data['idmapacirurgico'] = $this->data['cirurgia'] ?? NULL;
        $this->data['pac_codigo'] = $this->data['pac_codigo_hidden'];

        //dd($this->data);

        if (empty($this->data['reserva_data'])) {
            $this->data['reserva_data'] = NULL;
        }

        if ($this->validate($rules)) {

            $db = \Config\Database::connect('default');

            $this->validator->reset();

            $db->transStart();
    
            try {

                $camposPermitidos = array_intersect_key($this->data, array_flip($this->transfusaomodel->allowedFields));

                $idreq = $this->transfusaomodel->insert($camposPermitidos);

                /* $builder = $this->transfusaomodel->builder();
                $builder->insert($camposPermitidos);
                dd($builder->db()->getLastQuery()); */

                if ($db->transStatus() === false) {
                    $error = $db->error();
                    $errorMessage = !empty($error['message']) ? $error['message'] : 'Erro desconhecido';
                    $errorCode = !empty($error['code']) ? $error['code'] : 0;

                    throw new \CodeIgniter\Database\Exceptions\DatabaseException(
                        sprintf('Erro ao incluir Requisição [%d] %s', $errorCode, $errorMessage)
                    );
                }

                $db->transComplete();

                session()->setFlashdata('success', 'Requerimento incluído com sucesso!');
                //session()->setFlashdata('inclusao_sucesso', true);

                $this->validator->reset();

                $_SESSION['requisicoes'] = ["dtinicio" => date('Y-m-d'),
                                           "dtfim" => date('Y-m-d') . ' 23:59:59'];

                return redirect()->to(base_url('transfusao/exibir'));


            } catch (\Throwable $e) {
                $db->transRollback();
                $msg = sprintf('Exception - Falha na requisição - prontuário: %d - cod: (%d) msg: %s', (int) $this->data['prontuario'], (int) $e->getCode(), $e->getMessage());
                log_message('error', 'Exception: ' . $msg);
                session()->setFlashdata('exception', $msg);

                $this->data['procedimentos'] = $this->selectitensprocedhospitativos;
                $this->data['prof_especialidades'] = $this->selectprofespecialidadeaghu;
                $this->data['servidores'] = $this->selectservidores;

                return view('layouts/sub_content', ['view' => 'transfusao/form_req_transfusao',
                                'validation' => $this->validator,
                                'data' => $this->data]);
            }

        } else {
            session()->setFlashdata('error', $this->validator);
        }

        $this->data['procedimentos'] = $this->selectitensprocedhospitativos;
        $this->data['prof_especialidades'] = $this->selectprofespecialidadeaghu;
        $this->data['servidores'] = $this->selectservidores;

        //dd($this->data);
        //dd($this->validator->getErrors());

        return view('layouts/sub_content', ['view' => 'transfusao/form_req_transfusao',
                                            /* 'validation' => $this->validator, */
                                            'data' => $this->data]);
    }
    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function AtenderRequisicao($idreq)
    {
        HUAP_Functions::limpa_msgs_flash();

        $requisicao = $this->transfusaoModel->find($idreq);

        //dd($requisicao);

        $data = [];
        $data = $requisicao;
        $data['idreq'] = $idreq;
        $data['dthrequisicao'] = DateTime::createFromFormat('Y-m-d H:i:s', $requisicao['created_at'])->format('d/m/Y H:i');
        $data['hora_recebimento'] = DateTime::createFromFormat('H:i:s', $requisicao['hora_recebimento'])->format('H:i');
        $data['expedicoes'] = $this->transfusaoexphemocompmodel->Where('transfusao_id', $idreq)->findAll();
        $data['procedimentos'] = $this->selectitensprocedhospitativos;
        $data['prof_especialidades'] = $this->selectprofespecialidadeaghu;
        $data['servidores'] = $this->selectservidores;

        $data['tipo1_'] = [
            'ABO/RH' => $data['tipo1_aborh'],
            'A'      => $data['tipo1_a'],
            'B'      => $data['tipo1_b'],
            'AB'     => $data['tipo1_ab'],
            'D'      => $data['tipo1_d'],
            'C'      => $data['tipo1_c'],
            'RA1'    => $data['tipo1_ra1'],
            'RB'     => $data['tipo1_rb'],
        ];

        $data['tipo2_'] = [
            'PAI I' => $data['tipo2_pai_i'],
            'PAI II' => $data['tipo2_pai_ii'],
            'CD' => $data['tipo2_cd'],
            'AC' => $data['tipo2_ac'],
        ];

        $data['fenotipo_'] = [
            'C' => $data['fenotipo_c'],
            'Cw' => $data['fenotipo_cw'],
            'c' => $data['fenotipo_c'],
            'E' => $data['fenotipo_e'],
            'e' => $data['fenotipo_e_min'],
            'K' => $data['fenotipo_k'],
        ];

        //dd($data);
        return view('layouts/sub_content', ['view' => 'transfusao/form_atender_req_transfusao',
                                           'data' => $data]);

    }
    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
     public function incluirTestes()
    {

        \Config\Services::session();

        helper(['form', 'url', 'session']);

        $prontuario = null;

        $this->data = [];

        $this->data = $this->request->getPost();

        //dd($this->data);

        $rules = [
           'prontuario' => 'required|integer',
        ];

        $camposData = [
            'dt_hematocrito',
            'dt_hemoglobina',
            'dt_plaquetas',
            'dt_tap',
            'dt_inr',
            'dt_ptt',
            'dt_fibrinogenio',
            'reserva_data',
            'dt_coleta',
            'dt_solicitacao'
        ];

        // Formatar os campos de data simples
        foreach ($camposData as $campo) {
            if (!empty($this->data[$campo])) {
                $this->data[$campo] = date('d/m/Y', strtotime($this->data[$campo]));
            }
        }

        // Campos que têm data e hora separadas — vamos sobrescrevê-los com a junção formatada
        $camposDataHora = [
            ['data' => 'dt_coleta', 'hora' => 'hr_coleta'],
            ['data' => 'dt_solicitacao', 'hora' => 'hr_solicitacao'],
        ];

        foreach ($camposDataHora as $par) {
            $campoData = $par['data'];
            $campoHora = $par['hora'];

            if (!empty($this->data[$campoData]) && !empty($this->data[$campoHora])) {
                $dataHora = DateTime::createFromFormat('d/m/Y H:i', $this->data[$campoData] . ' ' . $this->data[$campoHora]);
                if ($dataHora) {
                    // Sobrescreve o campo de data com a data formatada completa
                    $this->data[$campoData] = $dataHora->format('d/m/Y H:i');
                    // Opcional: zera o campo de hora (ou você pode remover, se preferir)
                    unset($this->data[$campoHora]);
                }
            }
        }

        //dd($this->data);

        if ($this->validate($rules)) {

            $db = \Config\Database::connect('default');

            $this->validator->reset();

            $db->transStart();
    
            try {

                //dd($this->data['tipo_1']);
                //dd($this->data);

                // Lista de campos do tipo array associativo para tratar (tipo1, tipo2, fenotipo, etc)
                // 1. tipo_1 e tipo2 continuam com sanitização
                $arraysAssociativos = [
                    'tipo_1' => 'tipo1_',
                    'tipo2'  => 'tipo2_'
                ];

                foreach ($arraysAssociativos as $campoForm => $prefixoBanco) {
                    $valores = $this->request->getPost($campoForm);
                    if (is_array($valores)) {
                        foreach ($valores as $chave => $valor) {
                            $campoFormatado = $prefixoBanco . strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $chave));
                            $this->data[$campoFormatado] = $valor;
                        }
                    }
                }

                // 2. fenotipo com mapa explícito
                $fenotipoMap = [
                    'C'  => 'fenotipo_c',
                    'Cw' => 'fenotipo_cw',
                    'E'  => 'fenotipo_e',
                    'e'  => 'fenotipo_e_min',
                    'K'  => 'fenotipo_k',
                ];

                $valoresFenotipo = $this->request->getPost('fenotipo');
                if (is_array($valoresFenotipo)) {
                    foreach ($valoresFenotipo as $chave => $valor) {
                        if (isset($fenotipoMap[$chave])) {
                            $this->data[$fenotipoMap[$chave]] = $valor;
                        }
                    }
                }

                // Campos simples
                $this->data = array_merge($this->data, [
                    'dthrequisicao' => $this->request->getPost('dthrequisicao'),
                    'prontuario'    => $this->request->getPost('prontuario'),
                    'nome'          => $this->request->getPost('nome'),
                    'recebedor'     => $this->request->getPost('recebedor'),
                    'data_recebimento' => $this->request->getPost('data_recebimento'),
                    'hora_recebimento' => $this->request->getPost('hora_recebimento'),
                    'responsavel_tipo1' => $this->request->getPost('responsavel_tipo1'),
                    'responsavel_tipo2' => $this->request->getPost('responsavel_tipo2'),
                    'anticorpos' => $this->request->getPost('anticorpos'),
                    'observacoes_hemoterapia' => $this->request->getPost('observacoes_hemoterapia')
                ]);

                //dd($this->data);

                // Expedição: arrays indexados com múltiplas linhas (ex: data_expedicao[0], tipo[0], ...)
                $linhasExpedicao = $this->request->getPost('data_expedicao');
                $expedicoes = [];

                if (is_array($linhasExpedicao)) {
                    $total = count($linhasExpedicao);
                    for ($i = 0; $i < $total; $i++) {
                        $linha = [
                            'transfusao_id' => $this->data['idreq'],
                            'data_expedicao'          => !empty($this->request->getPost('data_expedicao')[$i]) ? $this->request->getPost('data_expedicao')[$i] : null,
                            'tipo'                    => $this->request->getPost('tipo')[$i],
                            'numero'                  => $this->request->getPost('numero')[$i],
                            'abo_rh_expedicao'        => $this->request->getPost('abo_rh_expedicao')[$i],
                            'volume'                  => $this->request->getPost('volume')[$i],
                            'origem'                  => $this->request->getPost('origem')[$i],
                            'pc'                      => $this->request->getPost("pc_$i"), // Radio
                            'th'                      => $this->request->getPost("th_$i"),
                            'iv'                      => $this->request->getPost("iv_$i"),
                            'responsavel_expedicao'   => $this->request->getPost('responsavel_expedicao')[$i],
                            'hora_expedicao'          => !empty($this->request->getPost('hora_expedicao')[$i]) ? $this->request->getPost('hora_expedicao')[$i] : null,
                            'hora_inicio'             => !empty($this->request->getPost('hora_inicio')[$i]) ? $this->request->getPost('hora_inicio')[$i] : null,
                            'hora_termino'            => !empty($this->request->getPost('hora_termino')[$i]) ? $this->request->getPost('hora_termino')[$i] : null,
                            'responsavel_administracao' => $this->request->getPost('responsavel_administracao')[$i]
                        ];

                        // Ignora linhas em que todos os campos (exceto transfusao_id) estão vazios
                        $dadosSemId = $linha;
                        unset($dadosSemId['transfusao_id']);
                        if (empty(array_filter($dadosSemId, fn($v) => $v !== null && $v !== ''))) {
                            continue;
                        }

                        $expedicoes[] = $linha;
                    }

                    $this->transfusaoexphemocompmodel->where('transfusao_id', $this->data['idreq'])->delete();

                    foreach ($expedicoes as $exped) {
                        $this->transfusaoexphemocompmodel->insert($exped);

                        if ($db->transStatus() === false) {
                            $error = $db->error();
                            $errorMessage = !empty($error['message']) ? $error['message'] : 'Erro desconhecido';
                            $errorCode = !empty($error['code']) ? $error['code'] : 0;

                            throw new \CodeIgniter\Database\Exceptions\DatabaseException(
                                sprintf('Erro ao incluir Dados de Testes de Expedições [%d] %s', $errorCode, $errorMessage)
                            );
                        }
                    }
                }
                //dd($this->data);
                $this->transfusaomodel->update($this->data['idreq'], $this->data);

                /* $builder = $this->transfusaomodel->builder();
                $builder->insert($camposPermitidos);
                dd($builder->db()->getLastQuery()); */

                if ($db->transStatus() === false) {
                    $error = $db->error();
                    $errorMessage = !empty($error['message']) ? $error['message'] : 'Erro desconhecido';
                    $errorCode = !empty($error['code']) ? $error['code'] : 0;

                    throw new \CodeIgniter\Database\Exceptions\DatabaseException(
                        sprintf('Erro ao incluir Dados de Testes [%d] %s', $errorCode, $errorMessage)
                    );
                }

                $db->transComplete();

                session()->setFlashdata('success', 'Dados de Testes para atendimento da Requisição incluídos com sucesso!');
                session()->setFlashdata('inclusao_sucesso', true);

                $this->validator->reset();

                return redirect()->to(base_url('transfusao/exibir'));


            } catch (\Throwable $e) {
                $db->transRollback();
                $msg = sprintf('Exception - Falha na requisição - prontuário: %d - cod: (%d) msg: %s', (int) $this->data['prontuario'], (int) $e->getCode(), $e->getMessage());
                log_message('error', 'Exception: ' . $msg);
                session()->setFlashdata('exception', $msg);

                $this->data['procedimentos'] = $this->selectitensprocedhospitativos;
                $this->data['prof_especialidades'] = $this->selectprofespecialidadeaghu;
                $this->data['servidores'] = $this->selectservidores;

                return view('layouts/sub_content', ['view' => 'transfusao/form_atender_req_transfusao',
                                'validation' => $this->validator,
                                'data' => $this->data]);
            }

        } else {
            session()->setFlashdata('error', $this->validator);
        }

        $this->data['procedimentos'] = $this->selectitensprocedhospitativos;
        $this->data['prof_especialidades'] = $this->selectprofespecialidadeaghu;
        $this->data['servidores'] = $this->selectservidores;

        //dd($this->data);
        //dd($this->validator->getErrors());

        return view('layouts/sub_content', ['view' => 'transfusao/form_atender_req_transfusao',
                                            /* 'validation' => $this->validator, */
                                            'data' => $this->data]);
    }
    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function consultarRequisicoes()
    {
        HUAP_Functions::limpa_msgs_flash();

        $_SESSION['requisicoes'] = NULL;

        //$data['dtinicio'] = date('d/m/Y', strtotime($this->getFirst()['created_at']));
        //$data['dtinicio'] = date('d/m/Y');
        //$data['dtfim'] = date('d/m/Y');
        $data['dtinicio'] = NULL;
        $data['dtfim'] = NULL;

        //die(var_dump($data));

        return view('layouts/sub_content', ['view' => 'transfusao/form_consulta_requisicoes',
                                            'data' => $data]);

    }
/**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function exibirRequisicoes()
    {        
        helper(['form', 'url', 'session']);

        \Config\Services::session();

        $prontuario = null;

        $data = $this->request->getVar();

        //die(var_dump($data));

        //$dataflash = session()->getFlashdata('dataflash');

        if ($_SESSION['requisicoes']) {
            //$data = $dataflash;
            $data = $_SESSION['requisicoes'];
        }

        //dd($data);

        if (!empty($data['dtinicio']) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $data['dtinicio'])) {
            $data['dtinicio'] = \DateTime::createFromFormat('Y-m-d', $data['dtinicio'])->format('d/m/Y');
        }
        if (!empty($data['dtfim']) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $data['dtfim'])) {
            $data['dtfim'] = \DateTime::createFromFormat('Y-m-d', $data['dtfim'])->format('d/m/Y');
        }

        //dd($data);

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

        if (!$_SESSION['requisicoes']) {
            $rules = $rules + [
                'prontuario' => 'permit_empty|min_length[1]|max_length[8]|equals['.$prontuario.']'
            ];
        }

        if ($this->validate($rules)) {

            //die(var_dump($dataflash));

            if (!$_SESSION['requisicoes']) {
                if (($data['dtinicio'] ?? null) || ($data['dtfim'] ?? null)) {

                    if (empty($data['dtinicio'])) {
                        $this->validator->setError('dtinicio', 'Informe a data de início!');
                        return view('layouts/sub_content', ['view' => 'transfusao/form_consulta_requisicoes',
                        'validation' => $this->validator,
                        'data' => $data]);
                    }
                    if (!$data['dtfim']) {
                        $this->validator->setError('dtfim', 'Informe a data final!');
                        return view('layouts/sub_content', ['view' => 'transfusao/form_consulta_requisicoes',
                        'validation' => $this->validator,
                        'data' => $data]);
                    }
                    if (DateTime::createFromFormat('d/m/Y', $data['dtfim'])->format('Y-m-d') < DateTime::createFromFormat('d/m/Y', $data['dtinicio'])->format('Y-m-d')) {
                        $this->validator->setError('dtinicio', 'A data de início não pode ser maior que a data final!');
                        return view('layouts/sub_content', ['view' => 'transfusao/form_consulta_requisicoes',
                                                            'validation' => $this->validator,
                                                            'data' => $data]);
                    }
                
                    if (DateTime::createFromFormat('d/m/Y', $data['dtfim'])->format('Y-m-d') < DateTime::createFromFormat('d/m/Y', $data['dtinicio'])->format('Y-m-d')) {
                        $this->validator->setError('dtinicio', 'A data de início não pode ser maior que a data final!');
                        return view('layouts/sub_content', ['view' => 'transfusao/form_consulta_requisicoes',
                                                            'validation' => $this->validator,
                                                            'data' => $data]);
                    }
            
                    $hora = '23:59:59';
                    $data['dtfim'] = $data['dtfim'] . ' ' . $hora;
                }
            }

            $this->validator->reset();

            //dd($data);

            $result = $this->getRequisicoes($data);

            //dd($result);

            if (empty($result)) {

                $data['dtinicio'] = NULL;
                $data['dtfim'] = NULL;

                session()->setFlashdata('warning_message', 'Nenhum paciente da Lista localizado com os parâmetros informados!');
                return view('layouts/sub_content', ['view' => 'transfusao/form_consulta_requisicoes',
                                                    'validation' => $this->validator,
                                                    'data' => $data]);
            
            }

            //die(var_dump($result));

            if ($_SESSION['requisicoes']) {
                $data['pagina_anterior'] = 'S';
            } else {
                $data['pagina_anterior'] = 'N';
            }

            $_SESSION['requisicoes'] = $data;

            return view('layouts/sub_content', ['view' => 'transfusao/list_requisicoes',
                                               'requisicoes' => $result,
                                               'data' => $data]);
        } else {
            //if(isset($resultAGHUX) && empty($resultAGHUX)) {
            if((!empty($data['prontuario']) && is_numeric($data['prontuario'])) && is_null($paciente)) {
                $this->validator->setError('prontuario', 'Esse prontuário não existe na base do AGHUX!');
            }
          
            return view('layouts/sub_content', ['view' => 'transfusao/form_consulta_requisicoes',
                                               'validation' => $this->validator,
                                                'data' => $data]);
        }
    }

    
    public function editar($id)
    {
        $dados['registro'] = $this->transfusaoModel->find($id);
        return view('transfusao/form', $dados);
    }

    public function excluir($id)
    {
        $this->transfusaoModel->delete($id);
        return redirect()->to('/transfusao')->with('success', 'Registro excluído com sucesso!');
    }
    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function getRequisicoes ($data) 
    {
        //die(var_dump($data));

        $db = \Config\Database::connect('default');

        $builder = $db->table('vw_transfusoes as req');

        $builder->select('*');

        //die(var_dump($data));

        if (!empty($data['id'])) {
        
            $builder->where('req.id', $data['id']);
    
        } else {

            if (!empty($data['dtinicio']) && !empty($data['dtfim'])) {
                $builder->where("req.created_at BETWEEN '$data[dtinicio]' AND '$data[dtfim]'");
            };
            if (!empty($data['prontuario'])) {
                //$clausula_where .= " AND prontuario = $data[prontuario]";
                $builder->where('req.prontuario', $data['prontuario']);
            };
            if (!empty($data['nome'])) {
                //$clausula_where .= " AND  nome_paciente LIKE '%".strtoupper($data['nome'])."%'";
                $builder->where('req.nome_paciente LIKE', '%'.strtoupper($data['nome']).'%');
            };
            if (!empty($data['tipo_transf'])) {
                $builder->whereIn('tipo_transfusao', $data['tipo_transf']);
            }
        }

        $builder->orderBy('req.idreq', 'ASC');

        //var_dump($builder->getCompiledSelect());die();

        return $builder->get()->getResult();

        //die(var_dump($builder->get()->getResult()));
    }
    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function consultarRequisicao($id)
    {

        HUAP_Functions::limpa_msgs_flash();

        $requisicao = $this->getRequisicoes(['idreq' => $id])[0];
        //$paciente = $this->pacientesmodel->find($mapa->prontuario);

        //die(var_dump($mapa));

        $data = [];
        $data = (array) $requisicao;
        $data['prof_especialidades'] = $this->selectprofespecialidadeaghu;
        $data['servidores'] = $this->selectservidores;
        $data = [
            'nome' => 'João da Silva',
            'observacoes' => 'Paciente estável',
            // Outros dados necessários para frente e verso
        ];

        return view('layouts/sub_content', ['view' => 'transfusao/form_requisicao',
                                            'data' => $data]);
    }

}
