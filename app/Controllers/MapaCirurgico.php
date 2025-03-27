<?php

namespace App\Controllers;
use App\Libraries\HUAP_Functions;
use CodeIgniter\RESTful\ResourceController;
use App\Controllers\ListaEspera;
use App\Models\ListaEsperaModel;
use App\Models\VwListaEsperaModel;
use App\Models\VwMapaCirurgicoModel;
use App\Models\VwStatusFilaCirurgicaModel;
use App\Models\VwSalasCirurgicasModel;
use App\Models\MapaCirurgicoModel;
use App\Models\FilaModel;
use App\Models\RiscoModel;
use App\Models\OrigemPacienteModel;
use App\Models\LateralidadeModel;
use App\Models\HemocomponentesModel;
use App\Models\EquipamentosModel;
use App\Models\EquipamentosCirurgiaModel;
use App\Models\HemocomponentesCirurgiaModel;
use App\Models\PosOperatorioModel;
use App\Models\ProcedimentosAdicionaisModel;
use App\Models\EquipeMedicaModel;
use App\Models\HistoricoModel;
use App\Models\VwOrdemPacienteModel;
use App\Models\LocalFatItensProcedHospitalarModel;
use App\Models\LocalAghCidsModel;
use App\Models\LocalAghEspecialidadesModel;
use App\Models\LocalAipPacientesModel;
use App\Models\LocalCentrosCirurgicosModel;
use App\Models\LocalMbcSalasCirurgicasModel;
use App\Models\LocalProfEspecialidadesModel;
use App\Models\JustificativasModel;
use App\Models\FilaWebModel;
use DateTime;
use CodeIgniter\Config\Services;
use Config\Database;
use CodeIgniter\Database\Exceptions\DatabaseException;
use PHPUnit\Framework\Constraint\IsNull;
use CodeIgniter\HTTP\ResponseInterface;

class MapaCirurgico extends ResourceController
{
    private $listaesperamodel;
    //private $listaesperacontroller;
    private $filawebmodel;
    private $vwlistaesperamodel;
    private $vwmapacirurgicomodel;
    private $vwstatusfilacirurgicamodel;
    private $vwsalascirurgicasmodel;
    private $vwordempacientemodel;
    private $mapacirurgicomodel;
    private $mapacirurgicocontroller;
    private $filamodel;
    private $riscomodel;
    private $origempacientemodel;
    private $lateralidademodel;
    private $hemocomponentesmodel;
    private $posoperatoriomodel;
    private $procedimentosadicionaismodel;
    private $equipemedicamodel;
    private $historicomodel;
    private $localfatitensprocedhospitalarmodel;
    private $selectequipamentos;
    private $localaghcidsmodel;
    private $localaghespecialidadesmodel;
    private $localprofespecialidadesmodel;
    private $localmbcsalascirurgicasmodel;
    private $localcentroscirurgicosmodel;
    private $localaippacientesmodel;
    private $justificativasmodel;
    private $usuariocontroller;
    private $aghucontroller;
    private $selectfilaativas;
    private $selectfila;
    private $selectrisco;
    private $selectriscoativos;
    private $selectespecialidade;
    private $selectespecialidadeaghu;
    private $selectprofespecialidadeaghu;
    private $selectcentroscirurgicosaghu;
    private $selectsalascirurgicasaghu;
    private $selectcids;
    private $selectitensprocedhospit;
    private $selectitensprocedhospitativos;
    private $selectorigempaciente;
    private $selectorigempacienteativos;
    private $selectlateralidade;
    private $selecthemocomponentes;
    private $selectlateralidadeativos;
    private $selectposoperatorio;
    private $selectjustificativastroca;
    private $selectjustificativassuspensao;
    private $selectjustificativassuspensaoadm;
    private $data;
    private $equipamentosmodel;
    private $equipamentoscirurgiamodel;
    private $hemocomponentescirurgiamodel;


    public function __construct()
    {
        ini_set('memory_limit', '512M');

        //$this->listaesperacontroller = new ListaEspera();
        $this->filawebmodel = new FilaWebModel(); 
        $this->listaesperamodel = new ListaEsperaModel();
        $this->vwlistaesperamodel = new VwListaEsperaModel();
        $this->vwmapacirurgicomodel = new vwMapaCirurgicoModel();
        $this->vwstatusfilacirurgicamodel = new VwStatusFilaCirurgicaModel();
        $this->vwsalascirurgicasmodel = new VwSalasCirurgicasModel();
        $this->vwordempacientemodel = new VwOrdemPacienteModel();
        $this->mapacirurgicomodel = new MapaCirurgicoModel();
        $this->filamodel = new FilaModel();
        $this->riscomodel = new RiscoModel();
        $this->origempacientemodel = new OrigemPacienteModel();
        $this->lateralidademodel = new LateralidadeModel();
        $this->hemocomponentesmodel = new HemocomponentesModel();
        $this->posoperatoriomodel = new PosOperatorioModel;
        $this->procedimentosadicionaismodel = new ProcedimentosAdicionaisModel();
        $this->equipemedicamodel = new EquipeMedicaModel();
        $this->historicomodel = new HistoricoModel();
        $this->localfatitensprocedhospitalarmodel = new LocalFatItensProcedHospitalarModel();
        $this->localaghcidsmodel = new LocalAghCidsModel();
        $this->localaghespecialidadesmodel = new LocalAghEspecialidadesModel();
        $this->localprofespecialidadesmodel = new LocalProfEspecialidadesModel();
        $this->localmbcsalascirurgicasmodel = new LocalMbcSalasCirurgicasModel();
        $this->localcentroscirurgicosmodel = new LocalCentrosCirurgicosModel();
        $this->localaippacientesmodel = new LocalAipPacientesModel();
        $this->justificativasmodel = new JustificativasModel();
        $this->usuariocontroller = new Usuarios();
        $this->equipamentosmodel = new EquipamentosModel();
        $this->equipamentoscirurgiamodel = new EquipamentosCirurgiaModel();
        $this->hemocomponentescirurgiamodel = new HemocomponentesCirurgiaModel();

        //$this->aghucontroller = new Aghu();

        $this->selectfila = $this->filamodel->orderBy('nmtipoprocedimento', 'ASC')->findAll();
        $this->selectfilaativas= $this->filamodel->Where('indsituacao', 'A')->orderBy('nmtipoprocedimento', 'ASC')->findAll();
        $this->selectrisco = $this->riscomodel->orderBy('nmrisco', 'ASC')->findAll();
        $this->selectriscoativos = $this->riscomodel->Where('indsituacao', 'A')->orderBy('nmrisco', 'ASC')->findAll();
        $this->selectorigempaciente = $this->origempacientemodel->orderBy('nmorigem', 'ASC')->findAll();
        $this->selectorigempacienteativos = $this->origempacientemodel->Where('indsituacao', 'A')->orderBy('nmorigem', 'ASC')->findAll();
        $this->selectlateralidade = $this->lateralidademodel->orderBy('id', 'ASC')->findAll();
        $this->selecthemocomponentes = $this->hemocomponentesmodel->orderBy('id', 'ASC')->findAll();
        $this->selectlateralidadeativos = $this->lateralidademodel->Where('indsituacao', 'A')->orderBy('id', 'ASC')->findAll();
        $this->selectposoperatorio = $this->posoperatoriomodel->Where('indsituacao', 'A')->orderBy('id', 'ASC')->findAll();
        $this->selectespecialidade = $this->listaesperamodel->distinct()->select('idespecialidade')->findAll();
        //$this->selectespecialidadeaghu = $this->aghucontroller->getEspecialidades($this->selectespecialidade);
        $this->selectespecialidadeaghu = $this->localaghespecialidadesmodel->Where('ind_situacao', 'A')
                                                                           ->whereIn('seq', array_column($this->selectespecialidade, 'idespecialidade'))
                                                                           ->orderBy('nome_especialidade', 'ASC')->findAll(); // disable for migration
        //die(var_dump($this->aghucontroller->getProfEspecialidades($this->selectespecialidade)));
        //$this->selectprofespecialidadeaghu = $this->aghucontroller->getProfEspecialidades($this->selectespecialidade);
        $this->selectjustificativassuspensao = $this->justificativasmodel->Where('tipojustificativa', 'S')->Where('indsituacao', 'A')->orderBy('descricao', 'ASC')->findAll();
        $this->selectjustificativassuspensaoadm = $this->justificativasmodel->Where('tipojustificativa', 'SADM')->Where('indsituacao', 'A')->orderBy('descricao', 'ASC')->findAll();
        $this->selectprofespecialidadeaghu = $this->localprofespecialidadesmodel->whereIn('esp_seq', array_column($this->selectespecialidade, 'idespecialidade'))
                                                                               ->orderBy('nome', 'ASC')->findAll(); // disable for migration
        //$this->selectcids = $this->aghucontroller->getCIDs();
        $this->selectjustificativastroca = $this->justificativasmodel->Where('tipojustificativa', 'T')->Where('indsituacao', 'A')->orderBy('descricao', 'ASC')->findAll();
        //$this->selectjustificativassuspensao = $this->justificativasmodel->Where('tipojustificativa', 'S')->Where('indsituacao', 'A')->orderBy('descricao', 'ASC')->findAll();
        $this->selectcids = $this->localaghcidsmodel->Where('ind_situacao', 'A')->orderBy('descricao', 'ASC')->findAll();
        //$this->selectitensprocedhospit = $this->aghucontroller->getItensProcedimentosHospitalares();
        $this->selectitensprocedhospit = $this->localfatitensprocedhospitalarmodel->orderBy('descricao', 'ASC')->findAll();
        $this->selectitensprocedhospitativos = $this->localfatitensprocedhospitalarmodel->Where('ind_situacao', 'A')->orderBy('descricao', 'ASC')->findAll();        //$this->selectsalascirurgicasaghu = $this->vwsalascirurgicasmodel->findAll();
        //$this->selectcentroscirurgicosaghu = $this->aghucontroller->getCentroCirurgico();
        $this->selectcentroscirurgicosaghu = $this->localcentroscirurgicosmodel->findAll();
        //$this->selectsalascirurgicasaghu = $this->aghucontroller->getSalasCirurgicas();
        $this->selectsalascirurgicasaghu = $this->localmbcsalascirurgicasmodel->Where('situacao', 'A')->orderBy('nome', 'ASC')->findAll();
        $this->selectequipamentos = $this->equipamentosmodel->Where('indsituacao', 'A')->orderBy('descricao', 'ASC')->findAll();

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
        
        return $this->mapacirurgicomodel->orderBy('created_at', 'ASC')->first();;
    }
     /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
   /*  public function getDetailsAside($idmapa)
    {

        //$cirurgia = $this->vwmapacirurgicomodel->where(['idmapa' => $idmapa])->find();
        //$cirurgia = $this->mapacirurgicomodel->find($idmapa);
        //die(var_dump($idmapa));
        $paciente = $this->aghucontroller->getDetalhesPaciente('864104');

        $data = [
            //'cirurgia' => $cirurgia,
            'paciente' => $paciente
        ];

        //die(var_dump($data));

        return view('listaespera/exibe_paciente', $data);
    } */
    /**
     * Retorna o prontuario cadastrado no aghu
     *
     * @return mixed
     */
    /* public function getDetalhesCirurgia(int $prontuario) 
    {

        $paciente = $this->aghucontroller->getPaciente($prontuario);

        $cirurgia = $this->mapacirurgicomodel->find();

        $sql = "
            select
                pac.codigo,
                pac.prontuario,
                pac.nome,
                pac.nome_mae nm_mae,
                pac.email,
                resp.nome nm_resp,
                to_char(pac.dt_nascimento, 'dd/mm/yyyy') dt_nascimento,
                EXTRACT (YEAR FROM AGE(CURRENT_DATE, pac.dt_nascimento)) idade,
                nac.descricao,
                cid.uf_sigla uf,
                case
                when pac.cor = 'B' then 'Branca'
                when pac.cor = 'P' then 'Preta'
                when pac.cor = 'M' then 'Parda'
                when pac.cor = 'A' then 'Amarela'
                when pac.cor = 'I' then 'Indígena'
                when pac.cor = 'O' then 'Sem Declaração'
                end cor,
                case
                when pac.sexo =  'M' then 'Masculino'
                when pac.sexo =  'F' then 'Feminino'
                when pac.sexo =  'I' then 'Ignorado'
                end sexo,
                nac.descricao nacionalidade,
                coalesce('(' || pac.ddd_fone_residencial || ')' || pac.fone_residencial, to_char(pac.fone_residencial, '9999999')) tel_1,
                coalesce('(' || pac.ddd_fone_recado || ')' || pac.fone_recado, pac.fone_recado) tel_2,
                tipolog.descricao || ' ' || lograd.nome logradouro,
                ender.nro_logradouro num_logr,
                ender.compl_logradouro compl_logr,
                bai.descricao bairro,
                cid.nome cidade,
                bcl.CLO_CEP::text cep,
                pac.cpf,
                pac.rg,
                pac.orgao_emis_rg,
                oed.descricao, 
                to_char(pac_dados.data_emissao_docto, 'dd/mm/yyyy') data_emissao_docto, 
                pac_dados.uf_sigla_emitiu_docto, 
                coalesce('CPF ' || REGEXP_REPLACE(pac.cpf::text,'([[:digit:]]{3})([[:digit:]]{3})([[:digit:]]{3})([[:digit:]]{2})','\\1.\\2.\\3-\\4') || ' ', '') || ' RG ' || pac.rg || ' ' || coalesce(pac.orgao_emis_rg, '') || coalesce(' - ' || pac_dados.uf_sigla_emitiu_docto, '') || coalesce(' Emissão: ' || to_char(pac_dados.data_emissao_docto, 'dd/mm/yyyy'), '') as doc,
                pac.nro_cartao_saude cns,
                pac.id_sistema_legado be
            from agh.aip_pacientes pac
            left join agh.aip_cidades cidade on cidade.codigo = pac.cdd_codigo
            left join agh.aip_nacionalidades nac on nac.codigo = pac.nac_codigo
            left join agh.aip_enderecos_pacientes ender on ender.pac_codigo = pac.codigo
            left join agh.aip_bairros_cep_logradouro bcl on bcl.clo_lgr_codigo = ender.bcl_clo_lgr_codigo and bcl.clo_cep = ender.bcl_clo_cep and bcl.bai_codigo = ender.bcl_bai_codigo
            left join agh.aip_bairros bai on bai.codigo = bcl.bai_codigo
            left join AGH.AIP_LOGRADOUROS lograd on lograd.CODIGO = bcl.CLO_LGR_CODIGO
            left join AGH.AIP_TIPO_LOGRADOUROS tipolog on lograd.TLG_CODIGO=tipolog.CODIGO
            left join agh.aip_cidades cid on cid.CODIGO = lograd.CDD_CODIGO
            left join agh.aip_ufs uf on uf.sigla = cid.uf_sigla
            left join AGH.AGH_RESPONSAVEIS resp on resp.pac_codigo = pac.codigo
            left join AGH.AIP_PACIENTES_DADOS_CNS pac_dados on pac_dados.pac_codigo = pac.codigo
            left join AGH.AIP_orgaos_emissores oed on oed.codigo = pac_dados.oed_codigo where pac.prontuario = ?";

        $query = $this->db->query($sql, [$prontuario]);

        $result = $query->getResult();

        return $result;

    } */
    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function getNomePaciente($numProntuario)
{
    //$paciente = $this->aghucontroller->getPaciente($numProntuario);
    $paciente = $this->localaippacientesmodel->find($numProntuario);

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
    public function consultarMapaCirurgico(string $idmapacirurgico = null)
    {
        HUAP_Functions::limpa_msgs_flash();

        $_SESSION['mapacirurgico'] = NULL;

        //$data['dtinicio'] = date('d/m/Y', strtotime($this->getFirst()['created_at']));
        //$data['dtinicio'] = date('d/m/Y');
        //$data['dtfim'] = date('d/m/Y');
        $data['dtinicio'] = NULL;
        $data['dtfim'] = NULL;
        $data['filas'] = $this->selectfilaativas;
        $data['riscos'] = $this->selectrisco;
        $data['especialidades'] = $this->selectespecialidadeaghu;

        //die(var_dump($data));

        return view('layouts/sub_content', ['view' => 'mapacirurgico/form_consulta_mapacirurgico',
                                            'data' => $data]);

    }
    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function exibirMapaCirurgico()
    {        
        helper(['form', 'url', 'session']);

        \Config\Services::session();

        $prontuario = null;

        $dataflash = session()->getFlashdata('dataflash');
        if ($dataflash) {
            $data = $dataflash;
        } else {
            $data = $this->request->getVar();
        }

        if (isset($_SESSION['mapacirurgico']) && $_SESSION['mapacirurgico']) {
            //$data = $dataflash;
            $data = $_SESSION['mapacirurgico'];
        }

        //die(var_dump($dataflash));

        if(!empty($data['prontuario']) && is_numeric($data['prontuario'])) {
            //$resultAGHUX = $this->aghucontroller->getPaciente($data['prontuario']);
            $paciente = $this->localaippacientesmodel->find($data['prontuario']);

            //if(!empty($resultAGHUX[0])) {
            if($paciente) {
                $prontuario = $data['prontuario'];
            }
        }

        $rules = [
            'prontuario' => 'permit_empty|min_length[1]|max_length[8]|equals['.$prontuario.']',
            'nome' => 'permit_empty|min_length[3]',
        ];

        if (!$dataflash) {
            if ((!isset($_SESSION['mapacirurgico']) || !$_SESSION['mapacirurgico'])) {
                $rules = $rules + [
                    'dtinicio' => 'permit_empty|valid_date[d/m/Y]',
                    'dtfim' => 'permit_empty|valid_date[d/m/Y]',
                ];
            }
        }

        if ($this->validate($rules)) {
            if ($data['dtinicio'] || $data['dtfim']) {

                $data['filas'] = $this->selectfilaativas;
                $data['riscos'] = $this->selectrisco;
                $data['especialidades'] = $this->selectespecialidadeaghu;

                if (empty($data['dtinicio'])) {
                    $this->validator->setError('dtinicio', 'Informe a data de início!');
                    return view('layouts/sub_content', ['view' => 'mapacirurgico/form_consulta_mapacirurgico',
                    'validation' => $this->validator,
                    'data' => $data]);
                }
                if (!$data['dtfim']) {
                    $this->validator->setError('dtfim', 'Informe a data final!');
                    return view('layouts/sub_content', ['view' => 'mapacirurgico/form_consulta_mapacirurgico',
                    'validation' => $this->validator,
                    'data' => $data]);
                }
                if (DateTime::createFromFormat('d/m/Y', $data['dtfim'])->format('Y-m-d') < DateTime::createFromFormat('d/m/Y', $data['dtinicio'])->format('Y-m-d')) {
                    $this->validator->setError('dtinicio', 'A data de início não pode ser maior que a data final!');
                    return view('layouts/sub_content', ['view' => 'mapacirurgico/form_consulta_mapacirurgico',
                                                        'validation' => $this->validator,
                                                        'data' => $data]);
                }
            
                //$hora = '23:59:59';
                //$data['dtinicio'] = $data['dtinicio'] . ' ' . '00:00:00';
                //$data['dtfim'] = $data['dtfim'] . ' ' . '23:59:59';
            
            }
            
            $this->validator->reset();

            /* $horaAtual = date('H:i:s');
            $data['dtfim'] = $data['dtfim'] . ' ' . $horaAtual; */

            $result = $this->getMapaCirurgico($data);

            //die(var_dump($result));

            if (empty($result)) {

                $data['filas'] = $this->filamodel->Where('indsituacao', 'A')->orderBy('nmtipoprocedimento', 'ASC')->findAll();
                $data['riscos'] = $this->riscomodel->Where('indsituacao', 'A')->orderBy('nmrisco', 'ASC')->findAll();
                //$data['especialidades'] = $this->aghucontroller->getEspecialidades();
                $data['especialidades'] = $this->selectespecialidadeaghu;

                session()->setFlashdata('warning_message', 'Nenhum paciente localizado com os parâmetros informados!');
                return view('layouts/sub_content', ['view' => 'mapacirurgico/form_consulta_mapacirurgico',
                                                    'validation' => $this->validator,
                                                    'data' => $data]);
            
            }

            //die(var_dump($result));

            //session()->set('mapa_cirurgico_resultados', $result);

            /* $result = session()->get('mapa_cirurgico_resultados');
            die(var_dump($result)); */

            if (isset($_SESSION['mapacirurgico']) && $_SESSION['mapacirurgico']) {
                $data['pagina_anterior'] = 'S';
            } else {
                $data['pagina_anterior'] = 'N';
            }

            $_SESSION['mapacirurgico'] = $data;

            return view('layouts/sub_content', ['view' => 'mapacirurgico/list_mapacirurgico',
                                               'mapacirurgico' => $result,
                                               'data' => $data]);

        } else {
            if((!empty($data['prontuario']) && is_numeric($data['prontuario'])) && is_null($paciente)) {
                $this->validator->setError('prontuario', 'Esse prontuário não existe na base do AGHUX!');
            }
            
            $data['filas'] = $this->filamodel->Where('indsituacao', 'A')->orderBy('nmtipoprocedimento', 'ASC')->findAll();
            $data['riscos'] = $this->riscomodel->Where('indsituacao', 'A')->orderBy('nmrisco', 'ASC')->findAll();
            //$data['especialidades'] = $this->aghucontroller->getEspecialidades();
            $data['especialidades'] = $this->selectespecialidadeaghu;

            return view('layouts/sub_content', ['view' => 'mapacirurgico/form_consulta_mapacirurgico',
                                                'validation' => $this->validator,
                                                'data' => $data]);
        }
    }
    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function exibirCirurgiasEmAprovacao()
    {        
        helper(['form', 'url', 'session']);

        \Config\Services::session();

        $prontuario = null;

        $dataflash = session()->getFlashdata('dataflash');
        if ($dataflash) {
            $data = $dataflash;
        } else {
            $data = $this->request->getVar();
        }

        if (isset($_SESSION['mapacirurgico']) && $_SESSION['mapacirurgico']) {
            $data = $_SESSION['mapacirurgico'];
        }


        if(!empty($data['prontuario']) && is_numeric($data['prontuario'])) {
            $paciente = $this->localaippacientesmodel->find($data['prontuario']);

            if($paciente) {
                $prontuario = $data['prontuario'];
            }
        }

        $rules = [
            'prontuario' => 'permit_empty|min_length[1]|max_length[8]|equals['.$prontuario.']',
            'nome' => 'permit_empty|min_length[3]',
        ];

        if (!$dataflash) {
            if ((!isset($_SESSION['mapacirurgico']) || !$_SESSION['mapacirurgico'])) {
                $rules = $rules + [
                    'dtinicio' => 'permit_empty|valid_date[d/m/Y]',
                    'dtfim' => 'permit_empty|valid_date[d/m/Y]',
                ];
            }
        }

        if ($this->validate($rules)) {
            if ($data['dtinicio'] || $data['dtfim']) {

                $data['filas'] = $this->selectfilaativas;
                $data['riscos'] = $this->selectrisco;
                $data['especialidades'] = $this->selectespecialidadeaghu;

                if (empty($data['dtinicio'])) {
                    $this->validator->setError('dtinicio', 'Informe a data de início!');
                    return view('layouts/sub_content', ['view' => 'mapacirurgico/form_consulta_mapacirurgicoemaprovacao',
                    'validation' => $this->validator,
                    'data' => $data]);
                }
                if (!$data['dtfim']) {
                    $this->validator->setError('dtfim', 'Informe a data final!');
                    return view('layouts/sub_content', ['view' => 'mapacirurgico/form_consulta_mapacirurgicoemaprovacao',
                    'validation' => $this->validator,
                    'data' => $data]);
                }
                if (DateTime::createFromFormat('d/m/Y', $data['dtfim'])->format('Y-m-d') < DateTime::createFromFormat('d/m/Y', $data['dtinicio'])->format('Y-m-d')) {
                    $this->validator->setError('dtinicio', 'A data de início não pode ser maior que a data final!');
                    return view('layouts/sub_content', ['view' => 'mapacirurgico/form_consulta_mapacirurgicoemaprovacao',
                                                        'validation' => $this->validator,
                                                        'data' => $data]);
                }
 
            }
            
            $this->validator->reset();

            $result = $this->getCirurgiaEmAprovacao($data);

            if (empty($result)) {

                $data['filas'] = $this->filamodel->Where('indsituacao', 'A')->orderBy('nmtipoprocedimento', 'ASC')->findAll();
                $data['riscos'] = $this->riscomodel->Where('indsituacao', 'A')->orderBy('nmrisco', 'ASC')->findAll();
                $data['especialidades'] = $this->selectespecialidadeaghu;

                session()->setFlashdata('warning_message', 'Nenhum paciente localizado com os parâmetros informados!');
                return view('layouts/sub_content', ['view' => 'mapacirurgico/form_consulta_mapacirurgicoemaprovacao',
                                                    'validation' => $this->validator,
                                                    'data' => $data]);
            
            }

            if (isset($_SESSION['mapacirurgico']) && $_SESSION['mapacirurgico']) {
                $data['pagina_anterior'] = 'S';
            } else {
                $data['pagina_anterior'] = 'N';
            }

            $_SESSION['mapacirurgico'] = $data;

            return view('layouts/sub_content', ['view' => 'mapacirurgico/list_cirurgiasemaprovacao',
                                               'mapacirurgico' => $result,
                                               'data' => $data]);

        } else {
            if((!empty($data['prontuario']) && is_numeric($data['prontuario'])) && is_null($paciente)) {
                $this->validator->setError('prontuario', 'Esse prontuário não existe na base do AGHUX!');
            }
            
            $data['filas'] = $this->filamodel->Where('indsituacao', 'A')->orderBy('nmtipoprocedimento', 'ASC')->findAll();
            $data['riscos'] = $this->riscomodel->Where('indsituacao', 'A')->orderBy('nmrisco', 'ASC')->findAll();
            $data['especialidades'] = $this->selectespecialidadeaghu;

            return view('layouts/sub_content', ['view' => 'mapacirurgico/form_consulta_mapacirurgicoemaprovacao',
                                                'validation' => $this->validator,
                                                'data' => $data]);
        }
    }
    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function exibirCirurgiaComHemocomponentes()
    {        
        helper(['form', 'url', 'session']);

        \Config\Services::session();

        $prontuario = null;

        $dataflash = session()->getFlashdata('dataflash');
        if ($dataflash) {
            $data = $dataflash;
        } else {
            $data = $this->request->getVar();
        }

        if (isset($_SESSION['mapacirurgico']) && $_SESSION['mapacirurgico']) {
            $data = $_SESSION['mapacirurgico'];
        }


        if(!empty($data['prontuario']) && is_numeric($data['prontuario'])) {
            $paciente = $this->localaippacientesmodel->find($data['prontuario']);

            if($paciente) {
                $prontuario = $data['prontuario'];
            }
        }

        $rules = [
            'prontuario' => 'permit_empty|min_length[1]|max_length[8]|equals['.$prontuario.']',
            'nome' => 'permit_empty|min_length[3]',
        ];

        if (!$dataflash) {
            if ((!isset($_SESSION['mapacirurgico']) || !$_SESSION['mapacirurgico'])) {
                $rules = $rules + [
                    'dtinicio' => 'permit_empty|valid_date[d/m/Y]',
                    'dtfim' => 'permit_empty|valid_date[d/m/Y]',
                ];
            }
        }

        if ($this->validate($rules)) {
            if ($data['dtinicio'] || $data['dtfim']) {

                $data['filas'] = $this->selectfilaativas;
                $data['riscos'] = $this->selectrisco;
                $data['especialidades'] = $this->selectespecialidadeaghu;

                if (empty($data['dtinicio'])) {
                    $this->validator->setError('dtinicio', 'Informe a data de início!');
                    return view('layouts/sub_content', ['view' => 'mapacirurgico/form_consulta_mapacirurgicoemaprovacao',
                    'validation' => $this->validator,
                    'data' => $data]);
                }
                if (!$data['dtfim']) {
                    $this->validator->setError('dtfim', 'Informe a data final!');
                    return view('layouts/sub_content', ['view' => 'mapacirurgico/form_consulta_mapacirurgicoemaprovacao',
                    'validation' => $this->validator,
                    'data' => $data]);
                }
                if (DateTime::createFromFormat('d/m/Y', $data['dtfim'])->format('Y-m-d') < DateTime::createFromFormat('d/m/Y', $data['dtinicio'])->format('Y-m-d')) {
                    $this->validator->setError('dtinicio', 'A data de início não pode ser maior que a data final!');
                    return view('layouts/sub_content', ['view' => 'mapacirurgico/form_consulta_mapacirurgicoreservahemocomps',
                                                        'validation' => $this->validator,
                                                        'data' => $data]);
                }
 
            }
            
            $this->validator->reset();

            $result = $this->getCirurgiaComHemocomponentes($data);

            if (empty($result)) {

                $data['filas'] = $this->filamodel->Where('indsituacao', 'A')->orderBy('nmtipoprocedimento', 'ASC')->findAll();
                $data['riscos'] = $this->riscomodel->Where('indsituacao', 'A')->orderBy('nmrisco', 'ASC')->findAll();
                $data['especialidades'] = $this->selectespecialidadeaghu;

                session()->setFlashdata('warning_message', 'Nenhum paciente localizado com os parâmetros informados!');
                return view('layouts/sub_content', ['view' => 'mapacirurgico/form_consulta_mapacirurgicoemaprovacao',
                                                    'validation' => $this->validator,
                                                    'data' => $data]);
            
            }

            if (isset($_SESSION['mapacirurgico']) && $_SESSION['mapacirurgico']) {
                $data['pagina_anterior'] = 'S';
            } else {
                $data['pagina_anterior'] = 'N';
            }

            $_SESSION['mapacirurgico'] = $data;

            return view('layouts/sub_content', ['view' => 'mapacirurgico/list_cirurgiascomhemocomponentes',
                                               'mapacirurgico' => $result,
                                               'data' => $data]);

        } else {
            if((!empty($data['prontuario']) && is_numeric($data['prontuario'])) && is_null($paciente)) {
                $this->validator->setError('prontuario', 'Esse prontuário não existe na base do AGHUX!');
            }
            
            $data['filas'] = $this->filamodel->Where('indsituacao', 'A')->orderBy('nmtipoprocedimento', 'ASC')->findAll();
            $data['riscos'] = $this->riscomodel->Where('indsituacao', 'A')->orderBy('nmrisco', 'ASC')->findAll();
            $data['especialidades'] = $this->selectespecialidadeaghu;

            return view('layouts/sub_content', ['view' => 'mapacirurgico/form_consulta_mapacirurgicoreservahemocomps',
                                                'validation' => $this->validator,
                                                'data' => $data]);
        }
    }
    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function getMapaCirurgico($data) 
{
    // Conexão com o banco de dados
    $db = \Config\Database::connect('default');

    // Iniciando o Query Builder na tabela vw_mapacirurgico
    $builder = $db->table('vw_mapacirurgico');

    // Adicionando o JOIN com vw_statusfilacirurgica
    $builder->join('vw_statusfilacirurgica', 'vw_mapacirurgico.idlista = vw_statusfilacirurgica.idlistaespera', 'inner');
    $builder->join('vw_ordem_paciente', 'vw_ordem_paciente.id = vw_mapacirurgico.idlista', 'left');


    // Selecionando campos específicos com aliases
    $builder->select('
        vw_mapacirurgico.*,
        (vw_statusfilacirurgica.campos_mapa).status AS status_fila,
        COALESCE(vw_ordem_paciente.ordem_fila, 0) AS ordem_fila
    ');
   
    if (!empty($data['idmapa'])) {
    
        $builder->where('vw_mapacirurgico.id', $data['idmapa']);

    } else {
        //die(var_dump($data));

        if (!empty($data['dtinicio']) && !empty($data['dtfim'])) {
            $dtInicio = DateTime::createFromFormat('d/m/Y', $data['dtinicio'])->format('Y-m-d 00:00:00');
            $dtFim = DateTime::createFromFormat('d/m/Y', $data['dtfim'])->format('Y-m-d 23:59:59');

            $builder->where("vw_mapacirurgico.dthrcirurgia >=", $dtInicio);
            $builder->where("vw_mapacirurgico.dthrcirurgia <=", $dtFim);
        }

        // Condicional para prontuario
        if (!empty($data['prontuario'])) {
            $builder->where('vw_mapacirurgico.prontuario', $data['prontuario']);
        }

        // Condicional para nome
        if (!empty($data['nome'])) {
            $builder->like('vw_mapacirurgico.nome_paciente', strtoupper($data['nome']));
        }

        // Condicional para especialidade
        if (!empty($data['especialidade'])) {
            $builder->where('vw_mapacirurgico.idespecialidade', $data['especialidade']);
        }

        // Condicional para fila
        if (!empty($data['fila'])) {
            $builder->where('vw_mapacirurgico.idfila', $data['fila']);
        }

        // Condicional para risco
        if (!empty($data['risco'])) {
            $builder->where('vw_mapacirurgico.idriscocirurgico', $data['risco']);
        }

        // Condicional para complexidades
        if (!empty($data['complexidades'])) {
            $builder->whereIn('vw_mapacirurgico.complexidade', $data['complexidades']);
        }

        // Condicional para complexidades
        if (!empty($data['situacao'])) {
            $builder->whereIn('vw_mapacirurgico.indsituacao', $data['situacao']);
        }

       $builder->orderBy('vw_mapacirurgico.dthrcirurgia', 'ASC');

    }
    
    //var_dump($builder->getCompiledSelect());die();
    //var_dump($builder->get()->getResult());die();

    return $builder->get()->getResult();
}
    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function exibirCirurgiasComHemocomponentes(string $idmapacirurgico = null)
    {
        HUAP_Functions::limpa_msgs_flash();

        $_SESSION['mapacirurgico'] = NULL;

        $dataflash = session()->getFlashdata('dataflash');

        if (isset($_SESSION['mapacirurgico']) && $_SESSION['mapacirurgico']) {
            $data = $_SESSION['mapacirurgico'];
        }

            $result = $this->getCirurgiaComHemocomponentes([]);

            if (empty($result)) {

                $data['filas'] = $this->filamodel->Where('indsituacao', 'A')->orderBy('nmtipoprocedimento', 'ASC')->findAll();
                $data['riscos'] = $this->riscomodel->Where('indsituacao', 'A')->orderBy('nmrisco', 'ASC')->findAll();
                $data['especialidades'] = $this->selectespecialidadeaghu;

                session()->setFlashdata('warning_message', 'Não existem cirurgias com hemocomponentes no período!');
            }

            if (isset($_SESSION['mapacirurgico']) && $_SESSION['mapacirurgico']) {
                $data['pagina_anterior'] = 'S';
            } else {
                $data['pagina_anterior'] = 'N';
            }

            $_SESSION['mapacirurgico'] = $data;

            return view('layouts/sub_content', ['view' => 'mapacirurgico/list_cirurgiascomhemocomponentes',
                                               'mapacirurgico' => $result,
                                               'data' => $data]);

    }
     /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function avaliarCirurgias(string $idmapacirurgico = null)
    {
        HUAP_Functions::limpa_msgs_flash();

        $_SESSION['mapacirurgico'] = NULL;

        //$data['dtinicio'] = date('d/m/Y', strtotime($this->getFirst()['created_at']));
        //$data['dtinicio'] = date('d/m/Y');
        //$data['dtfim'] = date('d/m/Y');
        $data['dtinicio'] = NULL;
        $data['dtfim'] = NULL;
        $data['filas'] = $this->selectfilaativas;
        $data['riscos'] = $this->selectrisco;
        $data['especialidades'] = $this->selectespecialidadeaghu;

        //die(var_dump($data));

        return view('layouts/sub_content', ['view' => 'mapacirurgico/form_consulta_mapacirurgicoemaprovacao',
                                            'data' => $data]);

    }
    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function verCirurgiasEmAprovacao()
    {
        HUAP_Functions::limpa_msgs_flash();

        $_SESSION['mapacirurgico'] = NULL;

        $dataflash['dtinicio'] = NULL;
        $dataflash['dtfim'] = NULL;
        $dataflash['fila'] = NULL;
        $dataflash['risco'] = NULL;
        $dataflash['especialidade'] = NULL;
        $dataflash['complexidades'] = NULL;
        session()->setFlashdata('dataflash', $dataflash);

        //die(var_dump($data));

        return redirect()->to(base_url('mapacirurgico/exibircirurgiasemaprovacao'));

    }
    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function getCirurgiaEmAprovacao($data) 
{
    $db = \Config\Database::connect('default');

    $builder = $db->table('vw_cirurgiasemaprovacao');

    $builder->join('vw_statusfilacirurgica', 'vw_cirurgiasemaprovacao.idlista = vw_statusfilacirurgica.idlistaespera', 'inner');
    $builder->join('vw_ordem_paciente', 'vw_ordem_paciente.id = vw_cirurgiasemaprovacao.idlista', 'left');

    $builder->select('
        vw_cirurgiasemaprovacao.*,
        (vw_statusfilacirurgica.campos_mapa).status AS status_fila,
        COALESCE(vw_ordem_paciente.ordem_fila, 0) AS ordem_fila
    ');
   
    if (!empty($data['idmapa'])) {
    
        $builder->where('vw_cirurgiasemaprovacao.id', $data['idmapa']);

    } else {

        if (!empty($data['dtinicio']) && !empty($data['dtfim'])) {
            $dtInicio = DateTime::createFromFormat('d/m/Y', $data['dtinicio'])->format('Y-m-d 00:00:00');
            $dtFim = DateTime::createFromFormat('d/m/Y', $data['dtfim'])->format('Y-m-d 23:59:59');

            $builder->where("vw_cirurgiasemaprovacao.dthrcirurgia >=", $dtInicio);
            $builder->where("vw_cirurgiasemaprovacao.dthrcirurgia <=", $dtFim);
        }

        if (!empty($data['prontuario'])) {
            $builder->where('vw_cirurgiasemaprovacao.prontuario', $data['prontuario']);
        }

        if (!empty($data['nome'])) {
            $builder->like('vw_cirurgiasemaprovacao.nome_paciente', strtoupper($data['nome']));
        }

        if (!empty($data['especialidade'])) {
            $builder->where('vw_cirurgiasemaprovacao.idespecialidade', $data['especialidade']);
        }

        if (!empty($data['fila'])) {
            $builder->where('vw_cirurgiasemaprovacao.idfila', $data['fila']);
        }

        if (!empty($data['risco'])) {
            $builder->where('vw_cirurgiasemaprovacao.idriscocirurgico', $data['risco']);
        }

        if (!empty($data['complexidades'])) {
            $builder->whereIn('vw_cirurgiasemaprovacao.complexidade', $data['complexidades']);
        }

        if (!empty($data['indsituacao']) && $data['indsituacao'] === 'EA') {
            $builder->whereIn('vw_cirurgiasemaprovacao.complexidade', $data['complexidades']);
        }

       $builder->orderBy('vw_cirurgiasemaprovacao.dthrcirurgia', 'ASC');

    }
    
    return $builder->get()->getResult();
}
/**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function getCirurgiaComHemocomponentes($data) 
{
    $db = \Config\Database::connect('default');

    $builder = $db->table('vw_mapacirurgico');

    $builder->join('vw_statusfilacirurgica', 'vw_mapacirurgico.idlista = vw_statusfilacirurgica.idlistaespera', 'inner');
    $builder->join('vw_ordem_paciente', 'vw_ordem_paciente.id = vw_mapacirurgico.idlista', 'left');

    $builder->select('
        vw_mapacirurgico.*,
        (vw_statusfilacirurgica.campos_mapa).status AS status_fila,
        COALESCE(vw_ordem_paciente.ordem_fila, 0) AS ordem_fila
    ');
   
    $builder->where('vw_mapacirurgico.dthrcirurgia >= ', (new DateTime())->format('Y-m-d'));
    $builder->where('vw_mapacirurgico.dthrsuspensao IS NULL'); 
    $builder->where('vw_mapacirurgico.dthrtroca IS NULL'); 
    $builder->where('vw_mapacirurgico.hemocomponentes_cirurgia IS NOT NULL'); 

    if (!empty($data['idmapa'])) {
    
        $builder->where('vw_mapacirurgico.id', $data['idmapa']); 

    } else {

        if (!empty($data['dtinicio']) && !empty($data['dtfim'])) {
            $dtInicio = DateTime::createFromFormat('d/m/Y', $data['dtinicio'])->format('Y-m-d 00:00:00');
            $dtFim = DateTime::createFromFormat('d/m/Y', $data['dtfim'])->format('Y-m-d 23:59:59');

            $builder->where("vw_mapacirurgico.dthrcirurgia >=", $dtInicio);
            $builder->where("vw_mapacirurgico.dthrcirurgia <=", $dtFim);
        }

        if (!empty($data['prontuario'])) {
            $builder->where('vw_mapacirurgico.prontuario', $data['prontuario']);
        }

        if (!empty($data['nome'])) {
            $builder->like('vw_mapacirurgico.nome_paciente', strtoupper($data['nome']));
        }

        if (!empty($data['especialidade'])) {
            $builder->where('vw_mapacirurgico.idespecialidade', $data['especialidade']);
        }

        if (!empty($data['fila'])) {
            $builder->where('vw_mapacirurgico.idfila', $data['fila']);
        }

        if (!empty($data['risco'])) {
            $builder->where('vw_mapacirurgico.idriscocirurgico', $data['risco']);
        }

        if (!empty($data['complexidades'])) {
            $builder->whereIn('vw_mapacirurgico.complexidade', $data['complexidades']);
        }

        if (!empty($data['indsituacao']) && $data['indsituacao'] === 'EA') {
            $builder->whereIn('vw_mapacirurgico.complexidade', $data['complexidades']);
        }

       $builder->orderBy('vw_mapacirurgico.dthrcirurgia', 'ASC');

    }
    
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
        $builder->where('DATE(dthrcirurgia)', $data['dtcirurgia']);
        //$builder->where('nmlateralidade', $data['lateralidade']);

        //var_dump($builder->getCompiledSelect());die();

        return $builder->get()->getResult();
    }
    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function getPacienteNoMapa ($data) 
    {
        //die(var_dump($data));
        
        $db = Database::connect('default');

        $builder = $db->table('vw_mapacirurgico');

        $builder->where('idlista', $data['listapaciente']);
        $builder->where('idespecialidade', $data['especialidade'] ?? $data['especialidade_hidden']);
        if(!empty($data['fila']) || !empty($data['fila_hidden'])) {
            $builder->where('idfila', $data['fila'] ?? $data['fila_hidden']);
        };
        $builder->where('DATE(dthrcirurgia)', $data['dtcirurgia']);
        $builder->where('dthrsuspensao', null);
        $builder->where('dthrtroca', null);
        $builder->where('dthrsaidacentrocirurgico', null);

        //$builder->where('nmlateralidade', $data['lateralidade']);

        //var_dump($builder->getCompiledSelect());die();

        //die(var_dump($builder->get()->getResult()));

        return $builder->get()->getResult();
    }
    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function getStatusCirurgia ($data) 
    {
        //die(var_dump($data));

        $db = \Config\Database::connect('default');

        $builder = $db->table('vw_statusfilacirurgica');

        $builder->where('idlistaespera', $data['id_listaespera']);
       
        //var_dump($builder->getCompiledSelect());die();

        return $builder->get()->getResult();
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
     * 
     * @return mixed
     */
    private function carregaMapa($oper = null) {

        //die(var_dump($this->data));

        $this->data['especialidade'] = $this->data['especialidade'] ?? (isset($this->data['especialidade_hidden']) ? $this->data['especialidade_hidden'] : '' );
        $this->data['fila'] = $this->data['fila'] ?? (isset($this->data['fila_hidden']) ? $this->data['fila_hidden'] : '' );
        $this->data['procedimento'] = $this->data['procedimento'] ?? (isset($this->data['procedimento_hidden']) ? $this->data['procedimento_hidden'] : '' );
        //$this->data['info'] = $this->data['info'] ?? $this->data['infoadic_hidden'];
        //$this->data['justorig'] = $this->data['justorig'] ?? $this->data['justorig_hidden'];

        $this->data['filas'] = $this->selectfila;
        if ($oper == 'I') {
            $this->data['riscos'] = $this->selectrisco;
            $this->data['lateralidades'] = $this->selectlateralidadeativos;
            $this->data['origens'] = $this->selectorigempaciente;
        } else {
            $this->data['riscos'] = $this->selectrisco;
            $this->data['lateralidades'] = $this->selectlateralidade;
            $this->data['origens'] = $this->selectorigempaciente;
        }
        $this->data['posoperatorios'] = $this->selectposoperatorio;
        $this->data['especialidades'] = $this->selectespecialidadeaghu;
        $this->data['cids'] = $this->selectcids;
        $this->data['procedimentos'] = $this->selectitensprocedhospit;
        $this->data['especialidades_med'] = $this->selectespecialidadeaghu;
        $this->data['prof_especialidades'] = $this->selectprofespecialidadeaghu;

        $codToRemove = $this->data['procedimento'];
        $procedimentos = $this->data['procedimentos'];
        $this->data['procedimentos_adicionais'] = array_filter($procedimentos, function($procedimento) use ($codToRemove) {
            return $procedimento->cod_tabela !== $codToRemove;
        });

        $this->data['centros_cirurgicos'] = $this->selectcentroscirurgicosaghu;
        $this->data['salas_cirurgicas'] = $this->selectsalascirurgicasaghu;
        $this->data['equipamentos'] = $this->selectequipamentos;
        $this->data['hemocomponentes'] = $this->selecthemocomponentes;

    }
    /**
     * 
     * @return mixed
     */
    private function carregaProfissionais($id) {


        die(var_dump($this->equipemedicamodel->where(['idmapacirurgico' => $id])->find()));

        $this->data['filas'] = $this->selectfilaativas;
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

        $this->data['centros_cirurgicos'] = $this->selectcentroscirurgicosaghu;
        $this->data['salas_cirurgicas'] = $this->selectsalascirurgicasaghu;
    }
    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function AtualizarCirurgia(int $id)
    {
       
        HUAP_Functions::limpa_msgs_flash();

        $mapa = $this->getMapaCirurgico(['idmapa' => $id])[0];

        //die(var_dump($mapa));

        $data = [];
        //$data['ordemfila'] = $mapa->ordem_fila;
        $array = $this->vwordempacientemodel->select('ordem_fila')->where('id', $mapa->idlista)->first();
        $data['ordemfila'] = !is_null($array) ? $array['ordem_fila'] : 0;
        $data['idmapa'] = $mapa->id;
        $data['idlistaespera'] = $mapa->idlista;
        $data['status_fila'] = ($mapa->dthrsuspensao || $mapa->dthrtroca || $mapa->dthrsaidacentrocirurgico || !HUAP_Functions::tem_permissao('mapacirurgico-alterar')) ? 'disabled' : 'enabled';
        //$data['dtcirurgia'] = date('d/m/Y H:i', strtotime('+3 days'));
        $data['dtcirurgia'] = DateTime::createFromFormat('Y-m-d H:i:s', $mapa->dthrcirurgia)->format('d/m/Y');
        $data['hrcirurgia'] = DateTime::createFromFormat('Y-m-d H:i:s', $mapa->dthrcirurgia)->format('H:i');
        $data['tempoprevisto'] = !is_null($mapa->tempoprevisto) ? DateTime::createFromFormat('H:i:s', $mapa->tempoprevisto)->format('H:i') : NULL;
        $data['prontuario'] = $mapa->prontuario;
        $data['nome'] = $mapa->nome_paciente;
        $data['especialidade'] = $mapa->idespecialidade;
        $data['risco'] = $mapa->idriscocirurgico;
        $data['dtrisco'] = $mapa->dtrisco ? DateTime::createFromFormat('Y-m-d', $mapa->dtrisco)->format('d/m/Y') : NULL;
        $data['cid'] = $mapa->cid;
        $data['complexidade'] = $mapa->complexidade;
        $data['fila'] = $mapa->idfila;
        $data['origem'] = $mapa->idorigempaciente;
        $data['congelacao'] = $mapa->indcongelacao;
        $data['opme'] = $mapa->indopme;
        $data['procedimento'] = $mapa->idprocedimento;
        $data['lateralidade'] = $mapa->lateralidade;
        $data['hemoderivados'] = $mapa->indhemoderivados;
        $data['posoperatorio'] = $mapa->idposoperatorio;
        $data['info'] = $mapa->infoadicionais;
        $data['nec_proced'] = $mapa->necessidadesproced;
        $data['justorig'] = $mapa->origemjustificativa;
        $data['justenvio'] = $mapa->justificativaenvio;
        $data['centrocirurgico'] =  $mapa->idcentrocirurgico;
        $data['sala'] =  $mapa->idsala ?? ' ';
        $data['profissional'] = array_column($this->equipemedicamodel->where(['idmapacirurgico' => $id])->select('codpessoa')->findAll(), 'codpessoa');
        $data['proced_adic'] = array_column($this->procedimentosadicionaismodel->where(['idmapacirurgico' => $id])->select('codtabela')->findAll(), 'codtabela');
        $data['eqpts'] = array_column($this->equipamentoscirurgiamodel->where(['idmapacirurgico' => $id])->select('idequipamento')->findAll(), 'idequipamento');
        $data['hemocomps'] = array_column($this->hemocomponentescirurgiamodel->where(['idmapacirurgico' => $id])->select('idhemocomponente')->findAll(), 'idhemocomponente');
        //dd($this->equipamentoscirurgiamodel->getLastQuery());
        $data['filas'] = $this->selectfila;
        $data['riscos'] = $this->selectrisco;
        $data['origens'] = $this->selectorigempaciente;
        $data['lateralidades'] = $this->selectlateralidade;
        $data['posoperatorios'] = $this->selectposoperatorio;
        $data['especialidades'] = $this->selectespecialidadeaghu;
        $data['cids'] = $this->selectcids;
        $data['procedimentos'] = $this->selectitensprocedhospitativos;
        $data['especialidades_med'] = $this->selectespecialidadeaghu;
        $data['prof_especialidades'] = $this->selectprofespecialidadeaghu;
        $data['centros_cirurgicos'] = $this->selectcentroscirurgicosaghu;
        $data['salas_cirurgicas'] = $this->selectsalascirurgicasaghu;
        $codToRemove = $mapa->idprocedimento;
        $procedimentos = $data['procedimentos'];
        $data['procedimentos_adicionais'] = array_filter($procedimentos, function($procedimento) use ($codToRemove) {
            return $procedimento->cod_tabela !== $codToRemove;
        });
        $data['equipamentos'] = $this->selectequipamentos;
        $data['usarEquipamentos'] = empty($data['eqpts']) ? 'N' : 'S';
        $data['usarHemocomponentes'] = empty($data['hemocomps']) ? 'N' : 'S';
        $data['hemocomponentes'] = $this->selecthemocomponentes;

       //var_dump($this->data['eqpts']);die();
       //var_dump($data['salas_cirurgicas']);die();
        
        return view('layouts/sub_content', ['view' => 'mapacirurgico/form_atualiza_mapacirurgico',
                                            'data' => $data]);
    }
    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function atualizar()
    {
        \Config\Services::session();

        helper(['form', 'url', 'session']);

        $this->data = [];

        $this->data = $this->request->getVar();

        //die(var_dump($this->data));

        $rules = [
            'especialidade' => 'required',
            //'dtrisco' => 'required|valid_date[d/m/Y]',
            'dtcirurgia' => 'required|valid_date[d/m/Y]',
            'hrcirurgia' => 'required|valid_time[H:i]',
            'tempoprevisto' => 'required|valid_time[H:i]',
            'fila' => 'required',
            'procedimento' => 'required',
            'posoperatorio' => 'required',
            'profissional' => 'required',
            'lateralidade' => 'required',
            'congelacao' => 'required',
            'complexidade' => 'required',
            'hemoderivados' => 'required',
            'opme' => 'required',
            'cid' => 'required',
            'risco' => 'required',
            'eqpts' => ($this->data['usarEquipamentos'] ?? '') == 'S' ? 'required' : 'permit_empty',
            'hemocomps' => ($this->data['usarHemocomponentes'] ?? '') == 'S' ? 'required' : 'permit_empty',
            'nec_proced' => 'required|max_length[500]|min_length[3]',
            'centrocirurgico' => 'required',
            'sala' => 'required'
        ];

        if ($this->validate($rules)) {

            /* if (DateTime::createFromFormat('d/m/Y H:i', $this->data['dtcirurgia'])->format('Y-m-d H:i') < date('Y-m-d H:i')) {
                $this->validator->setError('dtcirurgia', 'A data/hora da cirurgia não pode ser menor que a data/hora atual!');

                session()->setFlashdata('error', $this->validator);

                $this->carregaMapa();

                return view('layouts/sub_content', ['view' => 'mapacirurgico/form_atualiza_mapacirurgico',
                                                    'validation' => $this->validator,
                                                    'data' => $this->data]);
            } */

            if ($this->data['tempoprevisto'] == '00:00') {
                $this->validator->setError('tempoprevisto', 'Informe um tempo previsto maior que zero!');

                $this->carregaMapa();

                return view('layouts/sub_content', ['view' => 'mapacirurgico/form_atualiza_mapacirurgico',
                                                    'data' => $this->data]);
            }

            $db = \Config\Database::connect('default');

            $db->transStart();

            try {

                $lista = [
                        'idriscocirurgico' => empty($this->data['risco']) ? NULL : $this->data['risco'],
                        'dtriscocirurgico' => empty($this->data['dtrisco']) ? NULL : $this->data['dtrisco'],
                        'numcid' => empty($this->data['cid']) ? NULL : $this->data['cid'],
                        'idcomplexidade' => $this->data['complexidade'],
                        'indcongelacao' => $this->data['congelacao'],
                        'indopme' => $this->data['opme'],
                        'idlateralidade' => $this->data['lateralidade'],
                        //'txtinfoadicionais' => $this->data['info']
                        ];

                $this->listaesperamodel->update($this->data['idlistaespera'], $lista);

                if ($db->transStatus() === false) {
                    $error = $db->error();
                    $errorMessage = !empty($error['message']) ? $error['message'] : 'Erro desconhecido';
                    $errorCode = !empty($error['code']) ? $error['code'] : 0;

                    throw new \CodeIgniter\Database\Exceptions\DatabaseException(
                        sprintf('Erro ao atualizar Fila Cirúrgica [%d] %s', $errorCode, $errorMessage)
                    );
                }

                $dataCirurgia = DateTime::createFromFormat('d/m/Y H:i', $this->data['dtcirurgia'] . ' ' . substr($this->data['hrcirurgia'], 0, 5));

                $mapa = [
                    'idlistaespera' => $this->data['idlistaespera'],
                    'dthrcirurgia' => $dataCirurgia->format('d/m/Y H:i:s'),
                    'tempoprevisto' => $this->data['tempoprevisto'],
                    'idposoperatorio' => $this->data['posoperatorio'],
                    'indhemoderivados' => $this->data['hemoderivados'],
                    'txtnecessidadesproced' => $this->data['nec_proced'],
                    'idcentrocirurgico' => $this->data['centrocirurgico'],
                    'idsala' => $this->data['sala']
                    ];

                $this->mapacirurgicomodel->update($this->data['idmapa'], $mapa);

                if ($db->transStatus() === false) {
                    $error = $db->error();
                    $errorMessage = !empty($error['message']) ? $error['message'] : 'Erro desconhecido';
                    $errorCode = !empty($error['code']) ? $error['code'] : 0;

                    throw new \CodeIgniter\Database\Exceptions\DatabaseException(
                        sprintf('Erro ao atualizar Mapa [%d] %s', $errorCode, $errorMessage)
                    );
                }

                // Trata os procedimentos adicionais -------------------------------------

                $array['idmapacirurgico'] = (int) $this->data['idmapa'];

                $this->procedimentosadicionaismodel->where('idmapacirurgico', $array['idmapacirurgico'])->delete();

                if ($db->transStatus() === false) {
                    $error = $db->error();
                    $errorMessage = !empty($error['message']) ? $error['message'] : 'Erro desconhecido';
                    $errorCode = !empty($error['code']) ? $error['code'] : 0;

                    throw new \CodeIgniter\Database\Exceptions\DatabaseException(
                        sprintf('Erro ao excluir procedimento adicional [%d] %s', $errorCode, $errorMessage)
                    );
                }

                if (isset($this->data['proced_adic'])) {

                    foreach ($this->data['proced_adic'] as $key => $procedimento) {

                        $array['codtabela'] = (int) $procedimento;

                        $this->procedimentosadicionaismodel->insert($array);

                        if ($db->transStatus() === false) {
                            $error = $db->error();
                            $errorMessage = !empty($error['message']) ? $error['message'] : 'Erro desconhecido';
                            $errorCode = !empty($error['code']) ? $error['code'] : 0;
        
                            throw new \CodeIgniter\Database\Exceptions\DatabaseException(
                                sprintf('Erro ao atualizar procedimento adicional [%d] %s', $errorCode, $errorMessage)
                            );
                        }

                    }
                }

                // Trata Profissionais -------------------------------------

                $array['idmapacirurgico'] = (int) $this->data['idmapa'];

                $this->equipemedicamodel->where('idmapacirurgico', $array['idmapacirurgico'])->delete();
                //$this->equipemedicamodel->where('idmapacirurgico', $array['idmapacirurgico'])->purgeDeleted();

                if ($db->transStatus() === false) {
                    $error = $db->error();
                    $errorMessage = !empty($error['message']) ? $error['message'] : 'Erro desconhecido';
                    $errorCode = !empty($error['code']) ? $error['code'] : 0;

                    throw new \CodeIgniter\Database\Exceptions\DatabaseException(
                        sprintf('Erro ao excluir equipe médica [%d] %s', $errorCode, $errorMessage)
                    );
                }

                if (isset($this->data['profissional'])) {

                    foreach ($this->data['profissional'] as $key => $profissional) {

                        $array['codpessoa'] = (int) $profissional;

                        $this->equipemedicamodel->insert($array);

                        if ($db->transStatus() === false) {
                            $error = $db->error();
                            $errorMessage = !empty($error['message']) ? $error['message'] : 'Erro desconhecido';
                            $errorCode = !empty($error['code']) ? $error['code'] : 0;
        
                            throw new \CodeIgniter\Database\Exceptions\DatabaseException(
                                sprintf('Erro ao atualizar equipe médica [%d] %s', $errorCode, $errorMessage)
                            );
                        }

                    }
                }

                // Trata equipamentos -------------------------------------

                $dtcirurgia = $this->data['dtcirurgia'];

                $equipamentos = $this->equipamentoscirurgiamodel->where('idmapacirurgico', $this->data['idmapa'])->findAll();

                foreach ( $equipamentos as $key => $equipamento) { // exclui os equipamentos anteriores

                    $this->equipamentoscirurgiamodel->update($equipamento['id'], ['indexcedente' => false]);

                    $this->equipamentoscirurgiamodel->delete($equipamento['id']);

                    if ($db->transStatus() === false) {
                        $error = $db->error();
                        $errorMessage = isset($error['message']) ? $error['message'] : 'Erro desconhecido';
                        $errorCode = isset($error['code']) ? $error['code'] : 0;
    
                        throw new \CodeIgniter\Database\Exceptions\DatabaseException(
                            sprintf('Erro ao excluir equipamentos cirúrgicos! [%d] %s', $errorCode, $errorMessage)
                        );
                    }

                    $this->filawebmodel->atualizaLimiteExcedidoEquipamento($dtcirurgia, $equipamento['idequipamento'], true);

                    if ($db->transStatus() === false) {
                        $error = $db->error();
                        $errorMessage = isset($error['message']) ? $error['message'] : 'Erro desconhecido';
                        $errorCode = isset($error['code']) ? $error['code'] : 0;
    
                        throw new \CodeIgniter\Database\Exceptions\DatabaseException(
                            sprintf('Erro ao suspender cirurgia! [%d] %s', $errorCode, $errorMessage)
                        );
                    }
                }

                if (isset($this->data['eqpts'])) {

                    foreach ($this->data['eqpts'] as $key => $equipamento) {

                        $eqpExcedente = $this->filawebmodel->atualizaLimiteExcedidoEquipamento($dtcirurgia, (int) $equipamento);
                        $array['idmapacirurgico'] = (int) $this->data['idmapa'];
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

                // Trata hemocomponentes --------------------------------------------------------------

                if (!isset($this->data['hemocomps'])) {

                    $this->hemocomponentescirurgiamodel->where('idmapacirurgico', $this->data['idmapa'])->delete();

                } else {

                    $hemocomponentes_ant = $this->hemocomponentescirurgiamodel->where('idmapacirurgico', $this->data['idmapa'])->findAll();

                    foreach ( $hemocomponentes_ant as $key => $hemocomponente) { // exclui os hemomcomponentes que foram removidos

                        if (!in_array($hemocomponente['idhemocomponente'], $this->data['hemocomps'], )) {
    
                            $this->hemocomponentescirurgiamodel->delete($hemocomponente['id']);
    
                            if ($db->transStatus() === false) {
                                $error = $db->error();
                                $errorMessage = isset($error['message']) ? $error['message'] : 'Erro desconhecido';
                                $errorCode = isset($error['code']) ? $error['code'] : 0;
            
                                throw new \CodeIgniter\Database\Exceptions\DatabaseException(
                                    sprintf('Erro ao excluir homocomponentes [%d] %s', $errorCode, $errorMessage)
                                );
                            }
                        }
                    }

                    foreach ($this->data['hemocomps'] as $key => $hemocomponente) { // inclui os novos hemocomponentes

                        if (!in_array($hemocomponente, array_column($hemocomponentes_ant, 'idhemocomponente'))) {


                            $array['idmapacirurgico'] = (int) $this->data['idmapa'];
                            $array['idhemocomponente'] = (int) $hemocomponente;

                            $this->hemocomponentescirurgiamodel->insert($array);

                            if ($db->transStatus() === false) {
                                $error = $db->error();
                                $errorMessage = !empty($error['message']) ? $error['message'] : 'Erro desconhecido';
                                $errorCode = !empty($error['code']) ? $error['code'] : 0;
            
                                throw new \CodeIgniter\Database\Exceptions\DatabaseException(
                                    sprintf('Erro ao inserir hemocomponente [%d] %s', $errorCode, $errorMessage)
                                );
                            }
                        }
                    }
                }

                //--------------------------------------------------------------------------------------

                $array = [
                    'dthrevento' => date('Y-m-d H:i:s'),
                    'idlistaespera' => $this->data['idlistaespera'],
                    'idevento' => 8,
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
                        sprintf('Erro ao atualizar Mapa Cirúrgico! [%d] %s', $errorCode, $errorMessage)
                    );
                }

                session()->setFlashdata('success', 'Cirurgia atualizada com sucesso!');

                $this->validator->reset();
                
            } catch (\Throwable $e) {
                $db->transRollback(); // Reverte a transação em caso de erro
                $msg = sprintf('Exception - Falha na atualização do Mapa Cirúrgico - prontuário: %d - cod: (%d) msg: %s', (int) $this->data['prontuario'], (int) $e->getCode(), $e->getMessage());
                log_message('error', 'Exception: ' . $msg);
                session()->setFlashdata('exception', $msg);
            }

            //$this->carregaMapa();

            //return view('layouts/sub_content', ['view' => 'mapacirurgico/form_atualiza_mapacirurgico',
                                                //'data' => $this->data]);

            return redirect()->to(base_url('mapacirurgico/exibir'));


        } else {

            session()->setFlashdata('error', $this->validator);

            $this->carregaMapa();

            //die(var_dump($this->data));

            return view('layouts/sub_content', ['view' => 'mapacirurgico/form_atualiza_mapacirurgico',
                                                'validation' => $this->validator,
                                                'data' => $this->data]);
        }
    }
    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function consultarCirurgia(int $id, $linkorigem = null)
    {
       
        HUAP_Functions::limpa_msgs_flash();

        $mapa = $this->getMapaCirurgico(['idmapa' => $id])[0];

        //die(var_dump($mapa));

        $data = [];
        //$data['ordemfila'] = $mapa->ordem_fila;
        $data['linkorigem'] = $linkorigem;
        $array = $this->vwordempacientemodel->select('ordem_fila')->where('id', $mapa->idlista)->first();
        $data['ordemfila'] = !is_null($array) ? $array['ordem_fila'] : 0;
        $data['idmapa'] = $mapa->id;
        $data['idlistaespera'] = $mapa->idlista;
        //$data['dtcirurgia'] = date('d/m/Y H:i', strtotime('+3 days'));
        $data['enable_fila'] = ($mapa->dthrsuspensao || $mapa->dthrtroca || $mapa->dthrsaidacentrocirurgico || !HUAP_Functions::tem_permissao('mapacirurgico-alterar')) ? 'disabled' : 'enabled';
        $data['status_fila'] = $mapa->status_fila;
        $data['dtcirurgia'] = DateTime::createFromFormat('Y-m-d H:i:s', $mapa->dthrcirurgia)->format('d/m/Y H:i');
        $data['tempoprevisto'] = $mapa->tempoprevisto ? DateTime::createFromFormat('H:i:s', $mapa->tempoprevisto)->format('H:i') : '';
        $data['prontuario'] = $mapa->prontuario;
        $data['especialidade'] = $mapa->idespecialidade;
        $data['risco'] = $mapa->idriscocirurgico;
        $data['dtrisco'] = $mapa->dtrisco ? DateTime::createFromFormat('Y-m-d', $mapa->dtrisco)->format('d/m/Y') : NULL;
        $data['cid'] = $mapa->cid;
        $data['complexidade'] = $mapa->complexidade;
        $data['fila'] = $mapa->idfila;
        $data['origem'] = $mapa->idorigempaciente;
        $data['congelacao'] = $mapa->indcongelacao;
        $data['opme'] = $mapa->indopme;
        $data['procedimento'] = $mapa->idprocedimento;
        $data['lateralidade'] = $mapa->lateralidade;
        $data['hemoderivados'] = $mapa->indhemoderivados;
        $data['posoperatorio'] = $mapa->idposoperatorio;
        $data['info'] = $mapa->infoadicionais;
        $data['nec_proced'] = $mapa->necessidadesproced;
        $data['justorig'] = $mapa->origemjustificativa;
        $data['justenvio'] = $mapa->justificativaenvio;
        $data['idsuspensao'] = $mapa->idsuspensao;
        //$data['dtsuspensao'] = $mapa->dthrsuspensao;
        $data['dtsuspensao'] = $mapa->dthrsuspensao ? DateTime::createFromFormat('Y-m-d H:i:s', $mapa->dthrsuspensao)->format('d/m/Y H:i') : NULL;
        $data['justsuspensao'] = $mapa->justificativasuspensao;
        $data['justificativassuspensao'] = $this->selectjustificativassuspensao;
        $data['dttroca'] = $mapa->dthrtroca ? DateTime::createFromFormat('Y-m-d H:i:s', $mapa->dthrtroca)->format('d/m/Y H:i') : NULL;
        $data['justtroca'] = $mapa->justificativatroca;
        $data['justurgencia'] = $mapa->justificativaurgencia;
        $data['indurgencia'] = $mapa->indurgencia;
        $data['centrocirurgico'] =  $mapa->idcentrocirurgico;
        $data['sala'] =  $mapa->idsala;
        $data['profissional'] = array_column($this->equipemedicamodel->where(['idmapacirurgico' => $id])->select('codpessoa')->findAll(), 'codpessoa');
        $data['proced_adic'] = array_column($this->procedimentosadicionaismodel->where(['idmapacirurgico' => $id])->select('codtabela')->findAll(), 'codtabela');
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
        $data['centros_cirurgicos'] = $this->selectcentroscirurgicosaghu;
        $data['salas_cirurgicas'] = $this->selectsalascirurgicasaghu;
        $data['equipamentos'] = $this->selectequipamentos;
        $data['eqpts'] = array_column($this->equipamentoscirurgiamodel->where(['idmapacirurgico' => $id])->select('idequipamento')->findAll(), 'idequipamento');
        $data['hemocomps'] = array_column($this->hemocomponentescirurgiamodel->where(['idmapacirurgico' => $id])->select('idhemocomponente')->findAll(), 'idhemocomponente');
        $data['hemocomponentes'] = $this->selecthemocomponentes;

        $codToRemove = $mapa->idprocedimento;
        $procedimentos = $data['procedimentos'];
        $data['procedimentos_adicionais'] = array_filter($procedimentos, function($procedimento) use ($codToRemove) {
            return $procedimento->cod_tabela !== $codToRemove;
        });

        //var_dump($data['salas_cirurgicas'][0]['salas']);die();
        //var_dump($data['salas_cirurgicas']);die();
        
        return view('layouts/sub_content', ['view' => 'mapacirurgico/form_consulta_cirurgia',
                                            'data' => $data]);
    }
    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function consultarCirurgiaEmAprovacao(int $id, $linkorigem = null)
    {
       
        HUAP_Functions::limpa_msgs_flash();

        $mapa = $this->getCirurgiaEmAprovacao(['idmapa' => $id])[0];

        //die(var_dump($mapa));

        $data = [];
        //$data['ordemfila'] = $mapa->ordem_fila;
        $data['linkorigem'] = $linkorigem;
        $array = $this->vwordempacientemodel->select('ordem_fila')->where('id', $mapa->idlista)->first();
        $data['ordemfila'] = !is_null($array) ? $array['ordem_fila'] : 0;
        $data['idmapa'] = $mapa->id;
        $data['idlistaespera'] = $mapa->idlista;
        //$data['dtcirurgia'] = date('d/m/Y H:i', strtotime('+3 days'));
        $data['enable_fila'] = ($mapa->dthrsuspensao || $mapa->dthrtroca || $mapa->dthrsaidacentrocirurgico || !HUAP_Functions::tem_permissao('mapacirurgico-alterar')) ? 'disabled' : 'enabled';
        $data['status_fila'] = $mapa->status_fila;
        $data['dtcirurgia'] = DateTime::createFromFormat('Y-m-d H:i:s', $mapa->dthrcirurgia)->format('d/m/Y H:i');
        $data['tempoprevisto'] = $mapa->tempoprevisto ? DateTime::createFromFormat('H:i:s', $mapa->tempoprevisto)->format('H:i') : '';
        $data['prontuario'] = $mapa->prontuario;
        $data['especialidade'] = $mapa->idespecialidade;
        $data['risco'] = $mapa->idriscocirurgico;
        $data['dtrisco'] = $mapa->dtrisco ? DateTime::createFromFormat('Y-m-d', $mapa->dtrisco)->format('d/m/Y') : NULL;
        $data['cid'] = $mapa->cid;
        $data['complexidade'] = $mapa->complexidade;
        $data['fila'] = $mapa->idfila;
        $data['origem'] = $mapa->idorigempaciente;
        $data['congelacao'] = $mapa->indcongelacao;
        $data['opme'] = $mapa->indopme;
        $data['procedimento'] = $mapa->idprocedimento;
        $data['lateralidade'] = $mapa->lateralidade;
        $data['hemoderivados'] = $mapa->indhemoderivados;
        $data['posoperatorio'] = $mapa->idposoperatorio;
        $data['info'] = $mapa->infoadicionais;
        $data['nec_proced'] = $mapa->necessidadesproced;
        $data['justorig'] = $mapa->origemjustificativa;
        $data['justenvio'] = $mapa->justificativaenvio;
        $data['idsuspensao'] = $mapa->idsuspensao;
        //$data['dtsuspensao'] = $mapa->dthrsuspensao;
        $data['dtsuspensao'] = $mapa->dthrsuspensao ? DateTime::createFromFormat('Y-m-d H:i:s', $mapa->dthrsuspensao)->format('d/m/Y H:i') : NULL;
        $data['justsuspensao'] = $mapa->justificativasuspensao;
        $data['justificativassuspensao'] = $this->selectjustificativassuspensao;
        $data['dttroca'] = $mapa->dthrtroca ? DateTime::createFromFormat('Y-m-d H:i:s', $mapa->dthrtroca)->format('d/m/Y H:i') : NULL;
        $data['justtroca'] = $mapa->justificativatroca;
        $data['justurgencia'] = $mapa->justificativaurgencia;
        $data['indurgencia'] = $mapa->indurgencia;
        $data['centrocirurgico'] =  $mapa->idcentrocirurgico;
        $data['sala'] =  $mapa->idsala;
        $data['profissional'] = array_column($this->equipemedicamodel->where(['idmapacirurgico' => $id])->select('codpessoa')->findAll(), 'codpessoa');
        $data['proced_adic'] = array_column($this->procedimentosadicionaismodel->where(['idmapacirurgico' => $id])->select('codtabela')->findAll(), 'codtabela');
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
        $data['centros_cirurgicos'] = $this->selectcentroscirurgicosaghu;
        $data['salas_cirurgicas'] = $this->selectsalascirurgicasaghu;
        $data['equipamentos'] = $this->selectequipamentos;
        $data['eqpts'] = array_column($this->equipamentoscirurgiamodel->where(['idmapacirurgico' => $id])->select('idequipamento')->findAll(), 'idequipamento');

        $codToRemove = $mapa->idprocedimento;
        $procedimentos = $data['procedimentos'];
        $data['procedimentos_adicionais'] = array_filter($procedimentos, function($procedimento) use ($codToRemove) {
            return $procedimento->cod_tabela !== $codToRemove;
        });

        //var_dump($data['salas_cirurgicas'][0]['salas']);die();
        //var_dump($data['salas_cirurgicas']);die();
        
        return view('layouts/sub_content', ['view' => 'mapacirurgico/form_consulta_cirurgiaemaprovacao',
                                            'data' => $data]);
    }
    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function verificaCirurgiasEmAprovacao()
    {
       
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Requisição inválida.'
            ])->setStatusCode(400);
        }

        $data = [];
        $cirurgias = $this->getCirurgiaEmAprovacao($data);

        //die(var_dump($mapa));

        if ($cirurgias) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Existe Cirurgias'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Não Existem Cirurgias Em Aprovação.'
            ]);
        }
    }
    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function verificaCirurgiasComHemocomponentes()
    {
       
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Requisição inválida.'
            ])->setStatusCode(400);
        }

        $data = [];
        $cirurgias = $this->getCirurgiaComHemocomponentes($data);

        //die(var_dump($mapa));

        if ($cirurgias) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Existe Cirurgias'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Não Existem Cirurgias Com Hemocomponentes no Período.'
            ]);
        }
    }
    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function trocarPaciente()
    {
        HUAP_Functions::limpa_msgs_flash();

        $pacatrocar = $this->request->getVar();

        //die(var_dump($pacatrocar));

        $data = [];
        /* $data['candidatos'] = $this->vwstatusfilacirurgicamodel->where('idfila', $pacatrocar['idfila']) */
        $data['candidatos'] = $this->vwstatusfilacirurgicamodel->whereIn('(campos_mapa).status', ['Aguardando', 'Suspensa'])
                                                               ->where('idespecialidade', $pacatrocar['idespecialidade'])->findAll();
        //$data['candidatos'] = $this->vwstatusfilacirurgicamodel->getPacientesDaFila($pac1['idfila'], $pac1['idespecialidade']);

        if (!$data['candidatos']) {
            session()->setFlashdata('failed', 'Não existem candidatos a troca nessa Fila!');
            return redirect()->to(base_url('mapacirurgico/exibir'));
        } else {
            $data['candidatos'] = array_filter($data['candidatos'], function ($candidato) {
                // Exclui os candidatos que estão em fila de urgência
                return !in_array($candidato['idfila'], [178, 179, 180, 181, 189, 190, 191, 192, 193, 194, 195, 196, 197, 201, 202, 203, 204, 205, 206, 210, 177]);
            });         

            //die(var_dump( $data['candidatos']));

            //foreach ($data['candidatos'] as &$candidato) {
            foreach ($data['candidatos'] as &$candidato) {
                $ordempaciente = $this->vwordempacientemodel->find($candidato['idlistaespera']);
                $candidato['ordem_fila'] = $ordempaciente['ordem_fila'];
                $candidato['fila'] = $this->filamodel->find($ordempaciente['idfila'])['nmtipoprocedimento'];
                $trimmed = trim($candidato['campos_mapa'], '()');
                $values = str_getcsv($trimmed);
                $candidato['riscocirurgico'] = $values[4];
                $candidato['congelacao'] = $values[5];
                $candidato['lateralidade'] = $values[7];
                $candidato['cid'] = $values[8];
                $candidato['datariscocirurgico'] = $values[9] ?? '';
                $candidato['complexidade'] = $values[10];
                $candidato['infoadicionais'] = $values[11];
                $candidato['opme'] = $values[14];
            }
        }

        //die(var_dump($data['candidatos']));

        /* array_multisort(array_column($data['candidatos'], 'ordem_fila'), SORT_ASC, $data['candidatos']); */
        $filas = array_column($data['candidatos'], 'fila');
        $ordens = array_column($data['candidatos'], 'ordem_fila');
        array_multisort($filas, SORT_ASC, $ordens, SORT_ASC, $data['candidatos']);
      
        unset($candidato);

        $data['idlistapacatrocar'] = $pacatrocar['idlista'];
        $data['idmapapacatrocar'] = $pacatrocar['idmapa'];
        //$data['dtcirurgia'] = DateTime::createFromFormat('Y-m-d H:i:s', $pacatrocar['dthrcirurgia'])->format('d/m/Y H:i');
        $data['dtcirurgia'] = DateTime::createFromFormat('Y-m-d H:i:s', $pacatrocar['dthrcirurgia'])->format('d/m/Y');
        $data['hrcirurgia'] = DateTime::createFromFormat('Y-m-d H:i:s', $pacatrocar['dthrcirurgia'])->format('H:i');
        $data['tempoprevisto'] = '';
        $data['candidato'] = '';
        $data['especialidade'] = $pacatrocar['idespecialidade'];
        $data['risco'] = '';
        $data['dtrisco'] = '';
        $data['cid'] = '';
        $data['complexidade'] = '';
        $data['fila'] = $pacatrocar['idfila'];
        $data['origem'] = '';
        $data['congelacao'] = '';
        $data['procedimento'] = $pacatrocar['idprocedimento'];
        $data['proced_adic'] = [];
        $data['lateralidade'] = '';
        $data['posoperatorio'] = null;
        $data['info'] = '';
        $data['nec_proced'] = '';
        $data['justtroca'] = '';
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
        $data['usarEquipamentos'] = 'N';
        $data['equipamentos'] = $this->selectequipamentos;
        $data['eqpts'] = [];
        $data['usarHemocomponentes'] = 'N';
        $data['hemocomponentes'] = $this->selecthemocomponentes;
        $data['hemocomps'] = [];


        //$codToRemove = $mapapac1['idprocedimento'];
        //$procedimentos = $data['procedimentos'];
        //$data['procedimentos_adicionais'] = array_filter($procedimentos, function($procedimento) use ($codToRemove) {
            //return $procedimento->cod_tabela !== $codToRemove;
        //});
        $data['procedimentos_adicionais'] = $data['procedimentos'];

        //var_dump($data['candidatos']);die();

        $codToRemove = $pacatrocar['idlista'];
        $candidatos = $data['candidatos'];
        //die(var_dump($candidatos));
        $data['candidatos'] = array_filter($candidatos, function($candidato) use ($codToRemove) {
            return $candidato['idlistaespera'] !== $codToRemove;
        });

        //var_dump($data['procedimentos']);die();

        $_SESSION['candidatos'] =  $data['candidatos'];
        $_SESSION['pacatrocar'] = $pacatrocar;

        return view('layouts/sub_content', ['view' => 'mapacirurgico/form_troca_paciente',
                                            'data' => $data,
                                            'pacatrocar' =>$pacatrocar
                                            ]);
    }
    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function trocar()
    {
        \Config\Services::session();

        helper(['form', 'url', 'session']);

        $this->data = [];

        $this->data = $this->request->getVar();

        //die(var_dump($this->data));

        $this->data['fila'] = $this->data['fila_hidden'];
        $this->data['procedimento'] = $this->data['procedimento_hidden'];

        $rules = [
            'candidato' => 'required',
            'especialidade' => 'required',
            'risco' => 'required',
            'dtrisco' => 'required|valid_date[d/m/Y]',
            'dtcirurgia' => 'required|valid_date[d/m/Y]',
            'hrcirurgia' => 'required|valid_time[H:i]',            'tempoprevisto' => 'required|valid_time[H:i]',
            'fila' => 'required',
            'posoperatorio' => 'required',
            'profissional' => 'required',
            'lateralidade' => 'required',
            'congelacao' => 'required',
            'opme' => 'required',
            'hemoderivados' => 'required',
            'complexidade' => 'required',
            'nec_proced' => 'required|max_length[500]|min_length[3]',
            'justtroca' => 'required|max_length[500]|min_length[3]',
            'eqpts' => ($this->data['usarEquipamentos'] ?? '') == 'S' ? 'required' : 'permit_empty',
            'hemocomps' => ($this->data['usarHemocomponentes'] ?? '') == 'S' ? 'required' : 'permit_empty',
        ];

        //die(var_dump($_SESSION['candidatos']));

        if ($this->validate($rules)) {

            $db = \Config\Database::connect('default');

            //if ($this->mapacirurgicomodel->where('idlistaespera', $this->data['idlistapac2'])->where('deleted_at', null)->findAll()) {
            if ($this->vwstatusfilacirurgicamodel->where('idlistaespera', $this->data['idlistapac2'])->where('(campos_mapa).status', 'Programada')->findAll()) {

                session()->setFlashdata('failed', 'Esse paciente já foi enviada ao Mapa Cirúrgico');

                $this->carregaMapa();

                //$this->data['candidatos'] = $this->vwstatusfilacirurgicamodel->Where('idtipoprocedimento', $this->data['fila'])
                                                       //->where('idespecialidade', $this->data['especialidade'])->findAll();

                $this->data['candidatos'] = $_SESSION['candidatos'];                                   

                return view('layouts/sub_content', ['view' => 'mapacirurgico/form_troca_paciente',
                                                    'data' => $this->data,
                                                    'pacatrocar' => $_SESSION['pacatrocar']]);            
            }

            if ($this->data['risco'] != 8) { // Risco Liberado
                $this->validator->setError('risco', 'Para envio do paciente ao mapa o risco cirúrgico deve estar liberado!');

                $this->carregaMapa();

                $this->data['candidatos'] = $_SESSION['candidatos'];                                   

                return view('layouts/sub_content', ['view' => 'mapacirurgico/form_troca_paciente',
                                                    'data' => $this->data,
                                                    'pacatrocar' => $_SESSION['pacatrocar']]);   
            }

            if ($this->data['tempoprevisto'] == '00:00') {
                $this->validator->setError('tempoprevisto', 'Informe um tempo previsto maior que zero!');

                $this->carregaMapa();

                $this->data['candidatos'] = $_SESSION['candidatos'];                                   

                return view('layouts/sub_content', ['view' => 'mapacirurgico/form_troca_paciente',
                                                    'data' => $this->data,
                                                    'pacatrocar' => $_SESSION['pacatrocar']]);   
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
                        'indopme' => $this->data['opme'],
                        'indsituacao' => 'P' // Programada
                        ];

                $this->listaesperamodel->update($this->data['idlistapac2'], $lista);

                if ($db->transStatus() === false) {
                    $error = $db->error();
                    $errorMessage = !empty($error['message']) ? $error['message'] : 'Erro desconhecido';
                    $errorCode = !empty($error['code']) ? $error['code'] : 0;

                    throw new \CodeIgniter\Database\Exceptions\DatabaseException(
                        sprintf('Erro ao atualizar Fila Cirúrgica [%d] %s', $errorCode, $errorMessage)
                    );
                }

                $mapa = [
                    'idlistaespera' => $this->data['idlistapac2'],
                    //'dthrcirurgia' => DateTime::createFromFormat('d/m/Y H:i', $this->data['dtcirurgia'] . ' ' . substr($this->data['hrcirurgia'], 0, 5)),
                    'dthrcirurgia' => $this->data['dtcirurgia'] . ' ' . substr($this->data['hrcirurgia'], 0, 5),
                    'tempoprevisto' => $this->data['tempoprevisto'],
                    'idposoperatorio' => $this->data['posoperatorio'],
                    'indhemoderivados' => $this->data['hemoderivados'],
                    'txtnecessidadesproced' => $this->data['nec_proced'],
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
                
                $array = [
                    'dthrevento' => date('Y-m-d H:i:s'),
                    'idlistaespera' => $this->data['idlistapac2'],
                    'idevento' => 10,
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

                //die(var_dump($this->data));

                if (isset($this->data['proced_adic'])) {

                    foreach ($this->data['proced_adic'] as $key => $procedimento) {

                        $array = [];
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

                        $array = [];
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

                //die(var_dump(($this->data['idlistapac2'])));

                $this->listaesperamodel->delete($this->data['idlistapac2']);

                if ($db->transStatus() === false) {
                    $error = $db->error();
                    $errorMessage = !empty($error['message']) ? $error['message'] : 'Erro desconhecido';
                    $errorCode = !empty($error['code']) ? $error['code'] : 0;

                    throw new \CodeIgniter\Database\Exceptions\DatabaseException(
                        sprintf('Erro ao excluir paciente da lista [%d] %s', $errorCode, $errorMessage)
                    );
                }

                $array = [];
                $array['dthrtroca'] = date('Y-m-d H:i:s');
                $array['idlistatroca'] = $this->data['idlistapac2'];
                $array['txtjustificativatroca'] = $this->data['justtroca'];
                $array['indsituacao'] = 'T'; // Trocada


                //die(var_dump($array));

                $this->mapacirurgicomodel->update($this->data['idmapapacatrocar'], $array);

                if ($db->transStatus() === false) {
                    $error = $db->error();
                    $errorMessage = !empty($error['message']) ? $error['message'] : 'Erro desconhecido';
                    $errorCode = !empty($error['code']) ? $error['code'] : 0;

                    throw new \CodeIgniter\Database\Exceptions\DatabaseException(
                        sprintf('Erro ao atualizar o Mapa Cirúrgico! [%d] %s', $errorCode, $errorMessage)
                    );
                }

                //---------- Equipamentos ----------------------------------------

                /* $this->equipamentoscirurgiamodel->where('idmapacirurgico', $this->data['idmapapacatrocar'])->set('indexcedente', FALSE)->update();
               
                if ($db->transStatus() === false) {
                    $error = $db->error();
                    $errorMessage = !empty($error['message']) ? $error['message'] : 'Erro desconhecido';
                    $errorCode = !empty($error['code']) ? $error['code'] : 0;

                    throw new \CodeIgniter\Database\Exceptions\DatabaseException(
                        sprintf('Erro ao atualizar equipamento cirúrgico [%d] %s', $errorCode, $errorMessage)
                    );
                } */

                $dtcirurgia = $this->data['dtcirurgia'];

                $equipamentos = $this->equipamentoscirurgiamodel->where('idmapacirurgico', $this->data['idmapapacatrocar'])->findAll();

                foreach ( $equipamentos as $key => $equipamento) {

                    $this->equipamentoscirurgiamodel->update($equipamento['id'], ['indexcedente' => false]);

                    if ($db->transStatus() === false) {
                        $error = $db->error();
                        $errorMessage = isset($error['message']) ? $error['message'] : 'Erro desconhecido';
                        $errorCode = isset($error['code']) ? $error['code'] : 0;
    
                        throw new \CodeIgniter\Database\Exceptions\DatabaseException(
                            sprintf('Erro ao atualizar equipamentos cirúrgicos! [%d] %s', $errorCode, $errorMessage)
                        );
                    }

                    $this->filawebmodel->atualizaLimiteExcedidoEquipamento($dtcirurgia, $equipamento['idequipamento'], true);

                    if ($db->transStatus() === false) {
                        $error = $db->error();
                        $errorMessage = isset($error['message']) ? $error['message'] : 'Erro desconhecido';
                        $errorCode = isset($error['code']) ? $error['code'] : 0;
    
                        throw new \CodeIgniter\Database\Exceptions\DatabaseException(
                            sprintf('Erro ao suspender cirurgia! [%d] %s', $errorCode, $errorMessage)
                        );
                    }
                }

                if (isset($this->data['eqpts'])) {

                    foreach ($this->data['eqpts'] as $key => $equipamento) {

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

                //-------------- Hemocomponentes -----------------------------------------------------------------

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

                // ----------------------------------------------------------------------------------

                $this->listaesperamodel->withDeleted()->where('id', $this->data['idlistapacatrocar'])->set('deleted_at', NULL)
                                                                                                        ->set('indsituacao', 'A') // Aguardando
                                                                                                        ->update();

                if ($db->transStatus() === false) {
                    $error = $db->error();
                    $errorMessage = !empty($error['message']) ? $error['message'] : 'Erro desconhecido';
                    $errorCode = !empty($error['code']) ? $error['code'] : 0;

                    throw new \CodeIgniter\Database\Exceptions\DatabaseException(
                        sprintf('Erro ao atualizar paciente na Fila Cirúrgica! [%d] %s', $errorCode, $errorMessage)
                    );
                }

                $array = [
                    'dthrevento' => date('Y-m-d H:i:s'),
                    'idlistaespera' => $this->data['idlistapacatrocar'],
                    'idevento' => 3,
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

                session()->setFlashdata('success', 'Paciente trocado com sucesso!');

                $this->validator->reset();

            } catch (\Throwable $e) {
                $db->transRollback(); 
                $msg = sprintf('Exception - Falha na troca de paciente - idmapa: %d - cod: (%d) msg: %s', (int) $this->data['idmapapacatrocar'], (int) $e->getCode(), $e->getMessage());
                log_message('error', 'Exception: ' . $msg);
                session()->setFlashdata('exception', $msg);
            }

            return redirect()->to(base_url('mapacirurgico/exibir'));

        } else {
            session()->setFlashdata('error', $this->validator);

            $this->carregaMapa();

            //$this->data['candidatos'] = $this->vwstatusfilacirurgicamodel->Where('idfila', $this->data['fila'])->where('idespecialidade', $this->data['especialidade'])->findAll();

            $this->data['candidatos'] = $_SESSION['candidatos'];                                   

            //die(var_dump($this->data));
            return view('layouts/sub_content', ['view' => 'mapacirurgico/form_troca_paciente',
                                                'validation' => $this->validator,
                                                'data' => $this->data,
                                                'pacatrocar' => $_SESSION['pacatrocar']]);
        }
    }
    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function suspenderCirurgia(int $id, $suspadm = null)
    {
        HUAP_Functions::limpa_msgs_flash();

        //$data = $this->request->getVar();

        $mapa = $this->vwmapacirurgicomodel->find($id);

        //die(var_dump($lista));

        $data = [];
        $data['id'] = $mapa['id'];
        $data['datacirurgia'] = DateTime::createFromFormat('Y-m-d H:i:s', $mapa['dthrcirurgia'])->format('d/m/Y');
        $data['idlista'] = $mapa['idlista'];
        $data['ordemfila'] = '-';
        $data['prontuario'] = $mapa['prontuario'];
        $data['especialidade'] = $mapa['idespecialidade'];
        $data['fila'] = $mapa['idfila'];
        $data['filas'] = $this->selectfilaativas;
        $data['especialidades'] = $this->selectespecialidadeaghu;
        $data['justificativassuspensao'] = $suspadm ? $this->selectjustificativassuspensaoadm : $this->selectjustificativassuspensao;
        $data['idsuspensao'] = null;
        $data['justsuspensao'] = '';
        $data['suspensaoadm'] = isset($suspadm);

        //var_dump($data['id']);die();

        return view('layouts/sub_content', ['view' => 'mapacirurgico/form_suspende_cirurgia',
                                            'data' => $data]);

    }
    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function suspender()
    {
        //$data = session()->get('excluidos');

        $data = $this->request->getVar();

        //die(var_dump($data));

        $rules = [
            'especialidade' => 'required',
            'fila' => 'required',
            'idsuspensao' => 'required'
        ];

        if ($this->validate($rules)) {

            try {

                $db = \Config\Database::connect('default');

                $db->transStart();

                $mapa = [
                    'idsuspensao' => $data['idsuspensao'],
                    'dthrsuspensao' => date('Y-m-d H:i:s'),
                    'txtjustificativasuspensao' => $data['justsuspensao'],
                    'indsituacao' => $data['suspadm'] ? 'SADM' : 'S' // SUSPENSA ADMINISTRATIVAMENTE ou simplesmente SUSPENSA
                    ];

                $this->mapacirurgicomodel->update($data['id'], $mapa);

                //die(var_dump($mapa));

                if ($db->transStatus() === false) {
                    $error = $db->error();
                    $errorMessage = isset($error['message']) ? $error['message'] : 'Erro desconhecido';
                    $errorCode = isset($error['code']) ? $error['code'] : 0;

                    throw new \CodeIgniter\Database\Exceptions\DatabaseException(
                        sprintf('Erro ao suspender cirurgia! [%d] %s', $errorCode, $errorMessage)
                    );
                }

                $equipamentos = $this->equipamentoscirurgiamodel->where('idmapacirurgico', $data['id'])->findAll();

                foreach ( $equipamentos as $key => $equipamento) {

                    $this->equipamentoscirurgiamodel->update($equipamento['id'], ['indexcedente' => false]);

                    if ($db->transStatus() === false) {
                        $error = $db->error();
                        $errorMessage = isset($error['message']) ? $error['message'] : 'Erro desconhecido';
                        $errorCode = isset($error['code']) ? $error['code'] : 0;
    
                        throw new \CodeIgniter\Database\Exceptions\DatabaseException(
                            sprintf('Erro ao suspender cirurgia! [%d] %s', $errorCode, $errorMessage)
                        );
                    }

                    $this->filawebmodel->atualizaLimiteExcedidoEquipamento($data['datacirurgia'], $equipamento['idequipamento'], true);

                    if ($db->transStatus() === false) {
                        $error = $db->error();
                        $errorMessage = isset($error['message']) ? $error['message'] : 'Erro desconhecido';
                        $errorCode = isset($error['code']) ? $error['code'] : 0;
    
                        throw new \CodeIgniter\Database\Exceptions\DatabaseException(
                            sprintf('Erro ao suspender cirurgia! [%d] %s', $errorCode, $errorMessage)
                        );
                    }
                }

                $listaespera = $this->listaesperamodel->withDeleted()->find($data['idlista']);

                if ($listaespera['indurgencia'] == 'S') {

                    $lista = [
                        'indsituacao' => 'E' // Excluído
                        ];

                } else {

                    $lista = [
                        'deleted_at' => NULL,
                        'indsituacao' => 'A' // Aguardando
                        ];
                    
                }

                $this->listaesperamodel->withDeleted()->update($data['idlista'], $lista);

                if ($db->transStatus() === false) {
                    $error = $db->error();
                    $errorMessage = isset($error['message']) ? $error['message'] : 'Erro desconhecido';
                    $errorCode = isset($error['code']) ? $error['code'] : 0;

                    throw new \CodeIgniter\Database\Exceptions\DatabaseException(
                        sprintf('Erro ao suspender cirurgia! [%d] %s', $errorCode, $errorMessage)
                    );
                }

                if ($listaespera['indurgencia'] == 'S') {

                    $array = [
                        'dthrevento' => date('Y-m-d H:i:s'),
                        'idlistaespera' => $data['idlista'],
                        'idevento' => 11,
                        'idlogin' => session()->get('Sessao')['login']
                    ];

                } else {

                    $array = [
                        'dthrevento' => date('Y-m-d H:i:s'),
                        'idlistaespera' => $data['idlista'],
                        'idevento' => $data['suspadm'] ? 15 : 2,
                        'idlogin' => session()->get('Sessao')['login']
                    ];

                }

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

                session()->setFlashdata('success', 'Cirurgia suspensa com sucesso!');

                $this->validator->reset();
        
            } catch (\Throwable $e) {
                $msg = sprintf('Falha na suspensão da cirurgia - prontuário: %d - cod: (%d) msg: %s', (int) $data['prontuario'], (int) $e->getCode(), $e->getMessage());
                log_message('error', 'Exception: ' . $msg);
                session()->setFlashdata('exception', $msg);
            }

            return redirect()->to(base_url('mapacirurgico/exibir'));

        } else {
            session()->setFlashdata('error', $this->validator);

            $data['filas'] = $this->selectfilaativas;
            $data['especialidades'] = $this->selectespecialidadeaghu;
            $data['justificativassuspensao'] = $data['suspadm'] ? $this->selectjustificativassuspensaoadm : $this->selectjustificativassuspensao;

            return view('layouts/sub_content', ['view' => 'mapacirurgico/form_suspende_cirurgia',
                                                'data' => $data]);
        }
    }
    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function aprovarCirurgia(int $idlista, int $idmapa)
    {
        
        try {

            $db = \Config\Database::connect('default');

            $db->transStart();

            $this->mapacirurgicomodel->onlyDeleted()->update($idmapa, ['deleted_at' => NULL]);
           /*  $builder = $db->table('mapa_cirurgico');
            $builder->set('deleted_at', NULL)
                    ->where('id', $idmapa)
                    ->update(); */
            
            //dd($db->getLastQuery());

            if ($db->transStatus() === false) {
                $error = $db->error();
                $errorMessage = isset($error['message']) ? $error['message'] : 'Erro desconhecido';
                $errorCode = isset($error['code']) ? $error['code'] : 0;

                throw new \CodeIgniter\Database\Exceptions\DatabaseException(
                    sprintf('Erro ao aprovar cirurgia! [%d] %s', $errorCode, $errorMessage)
                );
            }
                
            $this->listaesperamodel->withDeleted()->update($idlista, ['indsituacao' => 'P']); // Programada

            if ($db->transStatus() === false) {
                $error = $db->error();
                $errorMessage = isset($error['message']) ? $error['message'] : 'Erro desconhecido';
                $errorCode = isset($error['code']) ? $error['code'] : 0;

                throw new \CodeIgniter\Database\Exceptions\DatabaseException(
                    sprintf('Erro ao aprovar cirurgia! [%d] %s', $errorCode, $errorMessage)
                );
            }

            $array = [
                'dthrevento' => date('Y-m-d H:i:s'),
                'idlistaespera' => $idlista,
                'idevento' => 13,
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
            $msg = 'Erro na aprovação da cirurgia';
            $msg .= ' - '.$e->getMessage();
            log_message('error', $msg.': ' . $e->getMessage());
            session()->setFlashdata('failed', $msg);
        }

        if ($db->transStatus() === false) {
            $dataflash['idlista'] = $idlista;
            session()->setFlashdata('dataflash', $dataflash);

        } else {
            session()->setFlashdata('success', 'Cirurgia aprovada com sucesso!');
        }

        return redirect()->to(base_url('mapacirurgico/exibircirurgiasemaprovacao'));

    }
    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function desaprovarCirurgia(int $idlista, int $idmapa)
    {
        
        try {

            $db = \Config\Database::connect('default');

            $db->transStart();

            $lista = [
                'deleted_at' => NULL,
                'indsituacao' => 'A' // Aguardando
            ];

            $this->listaesperamodel->withDeleted()->update($idlista, $lista); // Programada

            if ($db->transStatus() === false) {
                $error = $db->error();
                $errorMessage = isset($error['message']) ? $error['message'] : 'Erro desconhecido';
                $errorCode = isset($error['code']) ? $error['code'] : 0;

                throw new \CodeIgniter\Database\Exceptions\DatabaseException(
                    sprintf('Erro ao não aprovar cirurgia! [%d] %s', $errorCode, $errorMessage)
                );
            }

            $array = [
                'dthrevento' => date('Y-m-d H:i:s'),
                'idlistaespera' => $idlista,
                'idevento' => 14,
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
            $msg = 'Erro na não aprovação da cirurgia';
            $msg .= ' - '.$e->getMessage();
            log_message('error', $msg.': ' . $e->getMessage());
            session()->setFlashdata('failed', $msg);
        }

        if ($db->transStatus() === false) {
            $dataflash['idlista'] = $idlista;
            session()->setFlashdata('dataflash', $dataflash);

        } else {
            session()->setFlashdata('success', 'Cirurgia reprovada com sucesso!');
        }

        return redirect()->to(base_url('mapacirurgico/exibircirurgiasemaprovacao'));

    }
    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function confirmarReserva()
    {
        helper(['form', 'url']);

        \Config\Services::session();

        $data = $this->request->getVar();

        //var_dump($data);die();

        $db = \Config\Database::connect('default');
        $db->transStart();
        
        try {

            if (isset($data['inddisponibilidade'])) {

                foreach ($data['inddisponibilidade'] as $key => $inddisponibilidade) {

                    $this->hemocomponentescirurgiamodel->update($key, ['inddisponibilidade' => $inddisponibilidade]);

                    if ($db->transStatus() === false) {
                        $error = $db->error();
                        $errorMessage = !empty($error['message']) ? $error['message'] : 'Erro desconhecido';
                        $errorCode = !empty($error['code']) ? $error['code'] : 0;
    
                        throw new \CodeIgniter\Database\Exceptions\DatabaseException(
                            sprintf('Erro ao reservar hemocomponente! [%d] %s', $errorCode, $errorMessage)
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

            session()->setFlashdata('success', 'Operação concluída com sucesso!');

        } catch (\Throwable $e) {
            $db->transRollback(); 
            $msg = sprintf('Exception - '.$e->getMessage());
            log_message('error', 'Exception: ' . $msg);
            session()->setFlashdata('exception', $msg);
        }

        return redirect()->to('mapacirurgico/exibircirurgiacomhemocomps');

    }
    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function incluirUrgencia()
    {
        HUAP_Functions::limpa_msgs_flash();

        $pacatrocar = $this->request->getVar();

        if (isset($_SESSION['mapacirurgico'])) {
            unset($_SESSION['mapacirurgico']);
        }

        //die(var_dump($mapapac1));
        $data = [];
        //$data['listaespera'] = $this->vwlistaesperamodel->Where('prontuario', $prontuario)->findAll();
        $data['listaesperas'] = [];
        $data['listapaciente'] = '0';
        $data['candidatos'] = null;
        $data['ordem'] = null;
        $data['dtcirurgia'] = date('d/m/Y');
        $data['hrcirurgia'] = '';
        $data['tempoprevisto'] = '';
        $data['especialidade'] = null;
        $data['risco'] = '';
        $data['dtrisco'] = '';
        $data['cid'] = '';
        $data['complexidade'] = '';
        $data['fila'] = null;
        $data['origem'] = '';
        $data['congelacao'] = '';
        $data['procedimento'] = '';
        $data['proced_adic'] = [];
        $data['lateralidade'] = '';
        $data['posoperatorio'] = null;
        $data['info'] = '';
        $data['nec_proced'] = '';
        $data['sala'] =  '';
        $data['centrocirurgico'] =  '';
        $data['profissional'] = [];
        $data['filas'] = $this->selectfila;
        $data['riscos'] = $this->selectrisco;
        $data['origens'] = $this->selectorigempaciente;
        $data['lateralidades'] = $this->selectlateralidadeativos;
        $data['posoperatorios'] = $this->selectposoperatorio;
        $data['especialidades'] = $this->selectespecialidadeaghu;
        $data['cids'] = $this->selectcids;
        $data['procedimentos'] = $this->selectitensprocedhospitativos;
        $data['especialidades_med'] = $this->selectespecialidadeaghu;
        $data['prof_especialidades'] = $this->selectprofespecialidadeaghu;
        $data['procedimentos_adicionais'] = $data['procedimentos'];
        $data['centros_cirurgicos'] = $this->selectcentroscirurgicosaghu;
        $data['salas_cirurgicas'] = $this->selectsalascirurgicasaghu;
        $data['usarEquipamentos'] = '';
        $data['equipamentos'] = $this->selectequipamentos;
        $data['eqpts'] = [];
        $data['usarHomponentes'] = [];
        $data['hemocomponentes'] = $this->selecthemocomponentes;
        $data['hemocomps'] = [];

        $data['listapacienteSelect'] = [];

        //$codToRemove = $pac1['prontuario'];
        //$candidatos = $data['candidatos'];
        //die(var_dump($candidatos));
        /* $data['candidatos'] = array_filter($candidatos, function($candidato) use ($codToRemove) {
            return $candidato['prontuario'] !== $codToRemove;
        }); */

        //var_dump($data['procedimentos']);die();

        return view('layouts/sub_content', ['view' => 'mapacirurgico/form_inclui_urgencia',
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

        $this->data = $this->request->getVar();

        $this->data['fila'] = $this->data['fila'] ?? $this->data['fila_hidden'];
        $this->data['origem'] = $this->data['origem'] ?? $this->data['origem_hidden'];
        $this->data['risco'] = $this->data['risco'] ?? $this->data['risco_hidden'];
        $this->data['especialidade'] = $this->data['especialidade'] ?? $this->data['especialidade_hidden'];
        $this->data['procedimento'] = $this->data['procedimento'] ?? $this->data['procedimento_hidden'];

        if (empty($this->data['risco'])) {
            $this->data['risco'] = 11;
        };

        if(!empty($this->data['prontuario']) && is_numeric($this->data['prontuario'])) {
            //$resultAGHUX = $this->aghucontroller->getPaciente($this->data['prontuario']);
            $paciente = $this->localaippacientesmodel->find($this->data['prontuario']);

            //if(!empty($resultAGHUX[0])) {
            if($paciente) {
                $prontuario = $this->data['prontuario'];
            }
        }

        $rules = [
            'prontuario' => 'required|min_length[1]|max_length[12]|equals['.$prontuario.']',
            'listapaciente' => 'required',
            'dtcirurgia' => 'required|valid_date[d/m/Y]',
            'hrcirurgia' => 'required|valid_time[H:i]',
            'tempoprevisto' => 'required|valid_time[H:i]',
            'posoperatorio' => 'required',
            'profissional' => 'required',
            'lateralidade' => 'required',
            'congelacao' => 'required',
            'hemoderivados' => 'required',
            'opme' => 'required',
            'complexidade' => 'required',
            'cid' => 'required',
            //'risco' => 'required',
            //'dtrisco' => 'required',
            'centrocirurgico' => 'required',
            'sala' => 'required',
            'eqpts' => ($this->data['usarEquipamentos'] ?? '') == 'S' ? 'required' : 'permit_empty',
            'hemocomps' => ($this->data['usarHemocomponentes'] ?? '') == 'S' ? 'required' : 'permit_empty',
            'info' => 'max_length[1024]|min_length[0]',
            'nec_proced' => 'required|max_length[500]|min_length[3]',
            //'justorig' => 'max_length[1024]|min_length[0]',
            'justurgencia' => 'required|max_length[250]|min_length[3]',
            'usarEquipamentos' => 'required'
        ];

        //dd($this->data);

        if ($this->data['listapaciente'] == 0 || is_null($this->data['listapaciente'])) {
            $rules = $rules + [
                //'fila' => 'required',
                'especialidade' => 'required',
                'procedimento' => 'required',
                //'origem' => 'required'
            ];
        } else {
            $rules = $rules + [
                //'especialidade' => 'required',
                //'procedimento' => 'required',
                //'dtrisco' => 'required',
            ];        
        }

        //die(var_dump($this->data));

        if ($this->validate($rules)) {

            $db = \Config\Database::connect('default');

            if(isset($resultAGHUX) && empty($resultAGHUX)) {
                $this->validator->setError('prontuario', 'Esse prontuário não existe na base do AGHUX!');

            } else {
                //dd($this->data);
                if ($this->getPacienteNoMapa($this->data)) {
                    session()->setFlashdata('failed', 'Já existe uma cirurgia programada para esse paciente nesse dia!');

                } else {

                   /*  if (isset($this->data['origem']) && ($this->data['origem'] == 3 || $this->data['origem'] == 4) && empty($this->data['justorig'])) { // Interesse Acadêmico ou Judicialização
                        $this->validator->setError('justorig', 'Informe a justificativa para essa origem do paciente!');

                    } else { */

                       /*  if ($this->data['risco'] != 8) { // Risco Liberado
                            $this->validator->setError('risco', 'Para envio do paciente ao mapa o risco cirúrgico deve estar liberado!');
            
                        } else { */

                         if (DateTime::createFromFormat('d/m/Y', $this->data['dtcirurgia'])->format('Y-m-d') < date('Y-m-d')) {
                            $this->validator->setError('dtcirurgia', 'Não é possível agendar a cirurgia para uma data anterior a data atual!');

                        } else {

                            if ($this->data['tempoprevisto'] == '00:00') {
                                $this->validator->setError('tempoprevisto', 'Informe um tempo previsto maior que zero!');
    
                            } else {

                                $this->validator->reset();

                                $db->transStart();
                        
                                try {

                                    $lista = [
                                        'idriscocirurgico' => empty($this->data['risco']) ? NULL : $this->data['risco'],
                                        'dtriscocirurgico' => empty($this->data['dtrisco']) ? NULL : $this->data['dtrisco'],
                                        'numcid' => empty($this->data['cid']) ? NULL : $this->data['cid'],
                                        'idcomplexidade' => $this->data['complexidade'],
                                        'indcongelacao' => $this->data['congelacao'],
                                        'indopme' => $this->data['opme'],
                                        'idlateralidade' => $this->data['lateralidade'],
                                        'txtinfoadicionais' => $this->data['info'],
                                        'indsituacao' => 'P' // Programada
                                        ];

                                    if ($this->data['listapaciente'] != 0) {
                                        $idlista = $this->data['listapaciente'];

                                        $this->listaesperamodel->update($this->data['listapaciente'], $lista);

                                        if ($db->transStatus() === false) {
                                            $error = $db->error();
                                            $errorMessage = !empty($error['message']) ? $error['message'] : 'Erro desconhecido';
                                            $errorCode = !empty($error['code']) ? $error['code'] : 0;
            
                                            throw new \CodeIgniter\Database\Exceptions\DatabaseException(
                                                sprintf('Erro ao atualizar Fila Cirúrgica [%d] %s', $errorCode, $errorMessage)
                                            );
                                        }

                                        $array = [
                                            'dthrevento' => date('Y-m-d H:i:s'),
                                            'idlistaespera' => $this->data['listapaciente'],
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
                            

                                    } else {
                                        $lista = $lista + [
                                            'idespecialidade' => $this->data['especialidade'],
                                            'idtipoprocedimento' => $this->data['fila'],
                                            'idprocedimento' => $this->data['procedimento'],
                                            'numprontuario' => $this->data['prontuario'],
                                            'idriscocirurgico' => $this->data['risco'],
                                            'dtriscocirurgico' => $this->data['dtrisco'],
                                            'idorigempaciente' => $this->data['origem'],
                                            'txtorigemjustificativa' => $this->data['justorig'],
                                            //'indsituacao' => 'A',
                                            'indsituacao' => 'P', // Programada
                                            'indurgencia' => 'S'
                                            ];

                                        $idlista = $this->listaesperamodel->insert($lista);

                                        if ($db->transStatus() === false) {
                                            $error = $db->error();
                                            $errorMessage = !empty($error['message']) ? $error['message'] : 'Erro desconhecido';
                                            $errorCode = !empty($error['code']) ? $error['code'] : 0;
            
                                            throw new \CodeIgniter\Database\Exceptions\DatabaseException(
                                                sprintf('Erro ao incluir paciente na Fila Cirúrgica [%d] %s', $errorCode, $errorMessage)
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
                                    }

                                    $mapa = [
                                        'idlistaespera' => $idlista,
                                        'dthrcirurgia' => $this->data['dtcirurgia'] . ' ' . substr($this->data['hrcirurgia'], 0, 5),
                                        'tempoprevisto' => $this->data['tempoprevisto'],
                                        'idposoperatorio' => $this->data['posoperatorio'],
                                        'indhemoderivados' => $this->data['hemoderivados'],
                                        'txtnecessidadesproced' => $this->data['nec_proced'],
                                        'txtjustificativaurgencia' => $this->data['justurgencia'],
                                        'idcentrocirurgico' => $this->data['centrocirurgico'],
                                        'idsala' => $this->data['sala'],
                                        'indurgencia' => 'S',
                                        'indsituacao' => 'P' // Programada
                                        ];

                                        //die(var_dump($mapa));

                                    $idmapa = $this->mapacirurgicomodel->insert($mapa);

                                    if ($db->transStatus() === false) {
                                        $error = $db->error();
                                        $errorMessage = !empty($error['message']) ? $error['message'] : 'Erro desconhecido';
                                        $errorCode = !empty($error['code']) ? $error['code'] : 0;

                                        throw new \CodeIgniter\Database\Exceptions\DatabaseException(
                                            sprintf('Erro ao inserir paciente no Mapa [%d] %s', $errorCode, $errorMessage)
                                        );
                                    }

                                    $array = [
                                        'dthrevento' => date('Y-m-d H:i:s'),
                                        'idlistaespera' => $idlista,
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

                                    if (isset($this->data['proced_adic'])) {

                                        $this->procedimentosadicionaismodel->where('id', $idlista)->delete();

                                        if ($db->transStatus() === false) {
                                            $error = $db->error();
                                            $errorMessage = !empty($error['message']) ? $error['message'] : 'Erro desconhecido';
                                            $errorCode = !empty($error['code']) ? $error['code'] : 0;
                        
                                            throw new \CodeIgniter\Database\Exceptions\DatabaseException(
                                                sprintf('Erro ao excluir procedimento adicional [%d] %s', $errorCode, $errorMessage)
                                            );
                                        }


                                        foreach ($this->data['proced_adic'] as $key => $procedimento) {

                                            $array = [];
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

                                        $this->equipemedicamodel->where('id', $idlista)->delete();

                                        if ($db->transStatus() === false) {
                                            $error = $db->error();
                                            $errorMessage = !empty($error['message']) ? $error['message'] : 'Erro desconhecido';
                                            $errorCode = !empty($error['code']) ? $error['code'] : 0;
                        
                                            throw new \CodeIgniter\Database\Exceptions\DatabaseException(
                                                sprintf('Erro ao excluir equipe médica [%d] %s', $errorCode, $errorMessage)
                                            );
                                        }

                                        foreach ($this->data['profissional'] as $key => $profissional) {

                                            $array = [];
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
                    
                                            $dtcirurgia = $this->data['dtcirurgia'];
                   
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

                                    //$this->listaesperamodel->delete($this->data['listapaciente']);
                                    $this->listaesperamodel->where('id', $idlista)->delete();

                                    if ($db->transStatus() === false) {
                                        $error = $db->error();
                                        $errorMessage = !empty($error['message']) ? $error['message'] : 'Erro desconhecido';
                                        $errorCode = !empty($error['code']) ? $error['code'] : 0;

                                        throw new \CodeIgniter\Database\Exceptions\DatabaseException(
                                            sprintf('Erro ao excluir paciente da lista [%d] %s', $errorCode, $errorMessage)
                                        );
                                    }

                                    $db->transComplete();

                                    session()->setFlashdata('success', 'Cirurgia urgente incluída com sucesso!');

                                    $this->validator->reset();

                                } catch (\Throwable $e) {
                                    $db->transRollback(); // Reverte a transação em caso de erro
                                    $msg = sprintf('Exception - Falha na inclusão de cirurgia urgente - prontuário: %d - cod: (%d) msg: %s', (int) $this->data['prontuario'], (int) $e->getCode(), $e->getMessage());
                                    log_message('error', 'Exception: ' . $msg);
                                    session()->setFlashdata('exception', $msg);

                                    $this->carregaMapa('I');
                                    return view('layouts/sub_content', ['view' => 'mapacirurgico/form_inclui_urgencia',
                                                    'validation' => $this->validator,
                                                    'data' => $this->data]);
                                }

                                $this->carregaMapa('I');

                                //$dados = $this->request->getPost();

                                //$dadosAntigos = session()->getFlashdata('dados') ?? []; // Pega dados existentes ou um array vazio se não houver

                                $dataflash['dtinicio'] = DateTime::createFromFormat('d/m/Y', $this->data['dtcirurgia'])->format('d/m/Y');
                                $dataflash['dtfim'] = DateTime::createFromFormat('d/m/Y', $this->data['dtcirurgia'])->format('d/m/Y');
                            
                                session()->setFlashdata('dataflash', $dataflash);

                                //session()->setFlashdata('dados', $this->request->getPost());
                                return redirect()->to(base_url('mapacirurgico/exibir'));
                            }
                        }

                       /*  } */
                  /*   } */
                }
            }

        } 

        session()->setFlashdata('error', $this->validator);

        if(isset($resultAGHUX) && empty($resultAGHUX)) {
            //die(var_dump($this->validator));
            $this->validator->setError('prontuario', 'Esse prontuário não existe na base do AGHUX!');
        }

       //die(var_dump($this->data['listapaciente']));
        if (empty($this->data['prontuario']) || $this->data['listapaciente'] == '') {
            $this->data = [];
            $this->data['listaesperas'] = [];
            $this->data['candidatos'] = null;
            $this->data['ordem'] = null;
            $this->data['dtcirurgia'] = date('d/m/Y');
            $this->data['hrcirurgia'] = '';
            $this->data['tempoprevisto'] = '';
            $this->data['especialidade'] = null;
            $this->data['risco'] = '';
            $this->data['dtrisco'] = '';
            $this->data['cid'] = '';
            $this->data['complexidade'] = '';
            $this->data['fila'] = null;
            $this->data['origem'] = '';
            $this->data['congelacao'] = '';
            $this->data['procedimento'] = '';
            $this->data['proced_adic'] = [];
            $this->data['lateralidade'] = '';
            $this->data['posoperatorio'] = null;
            $this->data['info'] = '';
            $this->data['nec_proced'] = '';
            $this->data['sala'] =  '';
            $this->data['centrocirurgico'] =  '';
            $this->data['profissional'] = [];
            $this->data['filas'] = $this->selectfila;
            $this->data['riscos'] = $this->selectrisco;
            $this->data['origens'] = $this->selectorigempaciente;
            $this->data['lateralidades'] = $this->selectlateralidadeativos;
            $this->data['posoperatorios'] = $this->selectposoperatorio;
            $this->data['especialidades'] = $this->selectespecialidadeaghu;
            $this->data['cids'] = $this->selectcids;
            $this->data['procedimentos'] = $this->selectitensprocedhospitativos;
            $this->data['especialidades_med'] = $this->selectespecialidadeaghu;
            $this->data['prof_especialidades'] = $this->selectprofespecialidadeaghu;
            $this->data['procedimentos_adicionais'] = $this->data['procedimentos'];
            $this->data['centros_cirurgicos'] = $this->selectcentroscirurgicosaghu;
            $this->data['salas_cirurgicas'] = $this->selectsalascirurgicasaghu;
            $this->data['equipamentos'] = $this->selectequipamentos;
            $this->data['hemocomponentes'] = $this->selecthemocomponentes;

            $this->data['listapacienteSelect'] = [];
            $this->data['listapaciente'] = '';
        
        } else {

            $this->carregaMapa('I');
        }
        
        //dd($this->data);
        return view('layouts/sub_content', ['view' => 'mapacirurgico/form_inclui_urgencia',
                                            /* 'validation' => $this->validator, */
                                            'data' => $this->data]);
    }
    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function atualizarHorariosCirurgia(int $id)
    {
       
        HUAP_Functions::limpa_msgs_flash();

        $mapa = $this->getMapaCirurgico(['idmapa' => $id])[0];

        //die(var_dump($mapa));

        $data = [];
        $data['idmapa'] = $mapa->id;
        $data['idlista'] = $mapa->idlista;
        $data['ordemfila'] = $mapa->ordem_fila;
        $data['prontuario'] = $mapa->prontuario;
        $data['especialidade'] = $mapa->idespecialidade;
        $data['especialidades'] = $this->selectespecialidadeaghu;
        $data['fila'] = $mapa->idfila;
        $data['filas'] = $this->selectfilaativas;
        $data['procedimento'] = $mapa->idprocedimento;
        $data['procedimentos'] = $this->selectitensprocedhospit;

        $data['dthrcirurgia'] = DateTime::createFromFormat('Y-m-d H:i:s', $mapa->dthrcirurgia)->format('d/m/Y H:i');
        $data['hrpacientesolicitado'] = $mapa->dthrpacientesolicitado ? DateTime::createFromFormat('Y-m-d H:i:s', $mapa->dthrpacientesolicitado)->format('H:i') : '';
        $data['hrnocentrocirurgico'] = $mapa->dthrnocentrocirurgico ? DateTime::createFromFormat('Y-m-d H:i:s', $mapa->dthrnocentrocirurgico)->format('H:i') : '';
        $data['hremcirurgia'] = $mapa->dthremcirurgia ? DateTime::createFromFormat('Y-m-d H:i:s', $mapa->dthremcirurgia)->format('H:i') : '';
        $data['hrsaidasala'] = $mapa->dthrsaidasala ? DateTime::createFromFormat('Y-m-d H:i:s', $mapa->dthrsaidasala)->format('H:i') : '';
        $data['hrsaidacentrocirurgico'] = $mapa->dthrsaidacentrocirurgico ? DateTime::createFromFormat('Y-m-d H:i:s', $mapa->dthrsaidacentrocirurgico)->format('H:i') : '';
        //$data['hrsuspensao'] = $mapa->dthrsuspensao ? DateTime::createFromFormat('Y-m-s H:i:s', $mapa->dthrsuspensao)->format('H:i') : '';
        //$data['hrtroca'] = $mapa->dthrsuspensao ? DateTime::createFromFormat('Y-m-s H:i:s', $mapa->dthrsuspensao)->format('H:i') : '';
             
        return view('layouts/sub_content', ['view' => 'mapacirurgico/form_atualiza_horarioscirurgia',
                                            'data' => $data]);
    }
    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function atualizarHorarios()
    {
        \Config\Services::session();

        helper(['form', 'url', 'session']);

        $data = [];

        $data = $this->request->getVar();

        //die(var_dump($data));

        $rules = [
            'hrpacientesolicitado' => 'permit_empty|valid_date[H:i]',
            'hrnocentrocirurgico' => 'permit_empty|valid_date[H:i]',
            'hremcirurgia' => 'permit_empty|valid_date[H:i]',
            'hrsaidasala' => 'permit_empty|valid_date[H:i]',
            'hrsaidacentrocirurgico' => 'permit_empty|valid_date[H:i]',
            //'hrsuspensao' => 'permit_empty|valid_date[H:i]',
        ];

        if ($this->validate($rules)) {

            /* if (DateTime::createFromFormat('d/m/Y H:i', $data['dthrcirurgia'])->format('Y-m-d') != date('Y-m-d')) {
                $this->validator->setError('dthrcirurgia', 'A cirurgia não pode ser realizada fora da data prevista!');

                session()->setFlashdata('error', $this->validator);

                $data['especialidades'] = $this->selectespecialidadeaghu;
                $data['filas'] = $this->selectfilaativas;
                $data['procedimentos'] = $this->selectitensprocedhospit;

                return view('layouts/sub_content', ['view' => 'mapacirurgico/form_atualiza_horarioscirurgia',
                                                    'validation' => $this->validator,
                                                    'data' => $data]);
            } */

            $mapa = [
                'dthrpacientesolicitado'  => !empty($data['hrpacientesolicitado']) ? DateTime::createFromFormat('d/m/Y H:i', $data['dthrcirurgia'])->format('Y-m-d').' '.$data['hrpacientesolicitado'] : NULL,
                'dthrnocentrocirurgico'  => !empty($data['hrnocentrocirurgico']) ? DateTime::createFromFormat('d/m/Y H:i', $data['dthrcirurgia'])->format('Y-m-d').' '.$data['hrnocentrocirurgico'] : NULL,
                'dthremcirurgia'  => !empty($data['hremcirurgia']) ? DateTime::createFromFormat('d/m/Y H:i', $data['dthrcirurgia'])->format('Y-m-d').' '.$data['hremcirurgia'] : NULL,
                'dthrsaidasala' => !empty($data['hrsaidasala']) ? DateTime::createFromFormat('d/m/Y H:i', $data['dthrcirurgia'])->format('Y-m-d').' '.$data['hrsaidasala'] : NULL,
                'dthrsaidacentrocirurgico' => !empty($data['hrsaidacentrocirurgico']) ? DateTime::createFromFormat('d/m/Y H:i', $data['dthrcirurgia'])->format('Y-m-d').' '.$data['hrsaidacentrocirurgico'] : NULL,
                ];

              /*   $mapa = [
                    'dthrpacientesolicitado'  => !empty($data['hrpacientesolicitado']) ? DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'))->format('Y-m-d').' '.$data['hrpacientesolicitado'] : NULL,
                    'dthrnocentrocirurgico'  => !empty($data['hrnocentrocirurgico']) ? DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'))->format('Y-m-d').' '.$data['hrnocentrocirurgico'] : NULL,
                    'dthremcirurgia'  => !empty($data['hremcirurgia']) ? DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'))->format('Y-m-d').' '.$data['hremcirurgia'] : NULL,
                    'dthrsaidasala' => !empty($data['hrsaidasala']) ? DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'))->format('Y-m-d').' '.$data['hrsaidasala'] : NULL,
                    'dthrsaidacentrocirurgico' => !empty($data['hrsaidacentrocirurgico']) ?DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'))->format('Y-m-d').' '.$data['hrsaidacentrocirurgico'] : NULL,
                    ]; */

               //die(var_dump(DateTime::createFromFormat('Y-m-d H:i', $mapa['dthremcirurgia'])));
               $erro = false;

                $dthrPacienteSolicitado = $this->createDateTime($mapa['dthrpacientesolicitado']);
                $dthrEntrada = $this->createDateTime($mapa['dthrnocentrocirurgico']);
                $dthrInicioCirurgia = $this->createDateTime($mapa['dthremcirurgia']);
                $dthrSaidaSala = $this->createDateTime($mapa['dthrsaidasala']);
                $dthrSaidaCentroCirurgico = $this->createDateTime($mapa['dthrsaidacentrocirurgico']);

                // Lista de campos com a ordem esperada
                $campos = [
                    'hrnocentrocirurgico' => $dthrPacienteSolicitado,
                    'hrnocentrocirurgico' => $dthrEntrada,
                    'hremcirurgia' => $dthrInicioCirurgia,
                    'hrsaidasala' => $dthrSaidaSala,
                    'hrsaidacentrocirurgico' => $dthrSaidaCentroCirurgico
                ];

                // Lista organizada de mensagens de erro
                $mensagensErro = [
                    'hrnocentrocirurgico' => 'A hora de entrada no centro cirúrgico não pode ser menor que a hora de solicitação do paciente!',
                    'hremcirurgia' => 'A hora de início da cirurgia não pode ser menor que a hora de entrada no centro cirúrgico!',
                    'hrsaidasala' => 'A hora de saída da sala tem que ser maior que a hora de início de cirurgia!',
                    'hrsaidacentrocirurgico' => 'A hora de saída do centro cirúrgico não pode ser menor que a hora de saída da sala!'
                ];

                // Verificações das datas preenchidas quanto à ordem temporal
                foreach ($campos as $key => $value) {
                    if ($value) {
                        if ($key === 'hrnocentrocirurgico' && $dthrPacienteSolicitado && $dthrEntrada < $dthrPacienteSolicitado) {
                            $this->validator->setError('hrnocentrocirurgico', $mensagensErro['hrnocentrocirurgico']);
                            $erro = true;
                            break;
                        }
                        if ($key === 'hremcirurgia' && $dthrEntrada && $dthrInicioCirurgia < $dthrEntrada) {
                            $this->validator->setError('hremcirurgia', $mensagensErro['hremcirurgia']);
                            $erro = true;
                            break;
                        }
                        if ($key === 'hrsaidasala' && $dthrInicioCirurgia && $dthrSaidaSala <= $dthrInicioCirurgia) {
                            $this->validator->setError('hrsaidasala', $mensagensErro['hrsaidasala']);
                            $erro = true;
                            break;
                        }
                        if ($key === 'hrsaidacentrocirurgico' && $dthrSaidaSala && $dthrSaidaCentroCirurgico < $dthrSaidaSala) {
                            $this->validator->setError('hrsaidacentrocirurgico', $mensagensErro['hrsaidacentrocirurgico']);
                            $erro = true;
                            break;
                        }
                    }
                }

                // Verificações de presença de datas intermediárias
                foreach ($campos as $key => $value) {
                    if (!$value) {
                        $next_non_empty = false;
                        foreach ($campos as $key_check => $value_check) {
                            if ($key_check === $key) {
                                $next_non_empty = true;
                                continue;
                            }

                            if ($next_non_empty && $value_check) {
                                // Define o erro para a primeira data intermediária vazia quando há subsequentes preenchidas
                                $this->validator->setError($key, 'Existem tempos intermediários obrigatórios não preenchidos.');
                                $erro = true;
                                break 2; // Encerra ambos os loops
                            }
                        }
                    }
                }
               
               if ($erro) {
                $data['especialidades'] = $this->selectespecialidadeaghu;
                $data['filas'] = $this->selectfilaativas;
                $data['procedimentos'] = $this->selectitensprocedhospit;

                return view('layouts/sub_content', ['view' => 'mapacirurgico/form_atualiza_horarioscirurgia',
                                                    'validation' => $this->validator,
                                                    'data' => $data]);
               }

            $db = \Config\Database::connect('default');

            $db->transStart();

            try {

                $this->mapacirurgicomodel->update($data['idmapa'], $mapa);

                if ($db->transStatus() === false) {
                    $error = $db->error();
                    $errorMessage = !empty($error['message']) ? $error['message'] : 'Erro desconhecido';
                    $errorCode = !empty($error['code']) ? $error['code'] : 0;

                    throw new \CodeIgniter\Database\Exceptions\DatabaseException(
                        sprintf('Erro ao atualizar Mapa [%d] %s', $errorCode, $errorMessage)
                    );
                }

                $array = [
                    'dthrevento' => date('Y-m-d H:i:s'),
                    'idlistaespera' => $data['idlista'],
                    'idevento' => (is_null($campos['hrsaidacentrocirurgico']) ? 8 : 4),
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
                        sprintf('Erro ao atualizar Horários do Mapa Cirúrgico! [%d] %s', $errorCode, $errorMessage)
                    );
                }

                session()->setFlashdata('success', 'Cirurgia atualizada com sucesso!');

                $this->validator->reset();
                
            } catch (\Throwable $e) {
                $db->transRollback(); // Reverte a transação em caso de erro
                $msg = sprintf('Exception - Falha na atualização do Mapa Cirúrgico - prontuário: %d - cod: (%d) msg: %s', (int) $data['prontuario'], (int) $e->getCode(), $e->getMessage());
                log_message('error', 'Exception: ' . $msg);
                session()->setFlashdata('exception', $msg);
            }

            return redirect()->to(base_url('mapacirurgico/exibir'));

        } else {

            session()->setFlashdata('error', $this->validator);

            $data['especialidades'] = $this->selectespecialidadeaghu;
            $data['filas'] = $this->selectfilaativas;
            $data['procedimentos'] = $this->selectitensprocedhospit;

            //die(var_dump($this->validator->getErrors()));

            return view('layouts/sub_content', ['view' => 'mapacirurgico/form_atualiza_horarioscirurgia',
                                                'validation' => $this->validator,
                                                'data' => $data]);
        }
    }
    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function tratarEventoCirurgico()
    {
        try {
            $request = service('request');

            if (!$request->isAJAX()) {
                throw new \Exception('Acesso não autorizado');
            }

            //$idMapa = $this->request->getPost('idMapa');
            $arrayidJson = $this->request->getPost('arrayid');
            $eventoJson = $this->request->getPost('evento');

            //if (empty($idMapa) || empty($eventoJson)) {
            if (empty($arrayidJson) || empty($eventoJson)) {
                throw new \Exception('Parâmetros ausentes');
            }

            $arrayid = json_decode($arrayidJson, true);
            $evento = json_decode($eventoJson, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception('Erro ao decodificar JSON: ' . json_last_error_msg());
            }

            $db = Database::connect('default');

            $db->transStart();

            die(var_dump($arrayid['idMapa']));
            //$this->mapacirurgicomodel->update($idMapa, $evento);
            $this->mapacirurgicomodel->update($arrayid['idMapa'], $evento);

            if ($db->transStatus() === false) {
                $db->transRollback(); 
                $error = $db->error();
                $errorMessage = !empty($error['message']) ? $error['message'] : 'Erro desconhecido';
                $errorCode = !empty($error['code']) ? $error['code'] : 0;

                throw new DatabaseException(sprintf('Erro ao atualizar Mapa Cirúrgico! [%d] %s', $errorCode, $errorMessage));
            }

            if (isset($evento['dthrsuspensao']) /*|| $evento['dthrcancelamento']*/) {
                //$this->listaesperamodel->withDeleted()->update($arrayid['idLista'], ['deleted_at' => '']);
                $this->listaesperamodel->withDeleted()->where('id', $arrayid['idLista'])->set('deleted_at', NULL)
                                                                                        ->set('indsituacao', 'E') // Excluído
                                                                                        ->update();
            }

            if ($db->transStatus() === false) {
                $db->transRollback(); 
                $error = $db->error();
                $errorMessage = !empty($error['message']) ? $error['message'] : 'Erro desconhecido';
                $errorCode = !empty($error['code']) ? $error['code'] : 0;

                throw new DatabaseException(sprintf('Erro ao atualizar Mapa Cirúrgico! [%d] %s', $errorCode, $errorMessage));
            }

            if (isset($evento['dthrsaidacentrocirurgico'])) {
                $hist_evento = 4;
            } else {
                if (isset($evento['dthrsuspensao'])) {
                    $hist_evento = 2;
                } else {
                    $hist_evento = 8; // atualização genérica no mapa
                }
            }

            $array = [
                'dthrevento' => date('Y-m-d H:i:s'),
                'idlistaespera' => $arrayid['idLista'],
                'idevento' => $hist_evento,
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
                $db->transRollback(); 
                $error = $db->error();
                $errorMessage = !empty($error['message']) ? $error['message'] : 'Erro desconhecido';
                $errorCode = !empty($error['code']) ? $error['code'] : 0;

                throw new DatabaseException(sprintf('Erro ao atualizar Mapa Cirúrgico! [%d] %s', $errorCode, $errorMessage));
            }

            session()->setFlashdata('success', 'Cirurgia atualizada com sucesso!');

            return $this->response->setJSON(['success' => true, 'message' => 'Evento registrado com sucesso no mapa cirúrgico!']);

        } catch (\Throwable $e) {

            return $this->response->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR)
                                  ->setJSON(['success' => false, 'message' => $e->getMessage()]);
        }
    }
     /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function reservarHemocomponente(int $id)
    {
       
        HUAP_Functions::limpa_msgs_flash();

        $mapa = $this->getMapaCirurgico(['idmapa' => $id])[0];

        //die(var_dump($mapa));

        $data = [];
        $data['idmapa'] = $mapa->id;
        $data['idlista'] = $mapa->idlista;
        $data['ordemfila'] = $mapa->ordem_fila;
        $data['prontuario'] = $mapa->prontuario;
        $data['especialidade'] = $mapa->idespecialidade;
        $data['especialidades'] = $this->selectespecialidadeaghu;
        $data['fila'] = $mapa->idfila;
        $data['filas'] = $this->selectfilaativas;
        $data['procedimento'] = $mapa->idprocedimento;
        $data['procedimentos'] = $this->selectitensprocedhospit;
        $data['hemocomponentes_cirurgia_info'] = $mapa->hemocomponentes_cirurgia_info;

        $data['dthrcirurgia'] = DateTime::createFromFormat('Y-m-d H:i:s', $mapa->dthrcirurgia)->format('d/m/Y H:i');
                     
        return view('layouts/sub_content', ['view' => 'mapacirurgico/form_reserva_hemocomponentes',
                                            'data' => $data]);
    }
    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function mostrarMapaCirurgicoSalvo()
    {
        \Config\Services::session();

        $result = session()->get('mapa_cirurgico_resultados');

        foreach ($result as &$row) {
            if (isset($row->created_at)) {
                $row->created_at = \DateTime::createFromFormat('d/m/Y H:i', $row->created_at)->format('Y-m-d H:i:s');
            }
        }

       //die(var_dump($result));

        if ($result) {
            return view('layouts/sub_content', [
                'view' => 'mapacirurgico/list_mapacirurgico',
                'mapacirurgico' => $result
            ]);
        } else {
            session()->setFlashdata('warning_message', 'Nenhum mapa cirúrgico encontrado na sessão.');
            return redirect()->to('mapacirurgico/mostrarmapa');
        }
    }
    /**
     * Helper para criar objeto DateTime só se a data não estiver vaziat
     *
     * @return mixed
     */
    function createDateTime($dateString) {
        return empty($dateString) ? null : DateTime::createFromFormat('Y-m-d H:i', $dateString);
    }
    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function exibirHistorico(int $idlista)
    {        
        helper(['form', 'url', 'session']);

        \Config\Services::session();

        //die(var_dump($_GET));

        $queryData = $this->request->getGet('dados');
        
        //die(var_dump(isset($queryData['ordem_fila'])));

        if (!isset($queryData['ordem_fila'])) {
            $queryData['ordem_fila'] = '-';
        }

        $result = $this->getHistorico($idlista);

        if (empty($result)) {

            $data['filas'] = $this->filamodel->Where('indsituacao', 'A')->orderBy('nmtipoprocedimento', 'ASC')->findAll();

            session()->setFlashdata('warning_message', 'Histórico de Atividades não localizado para este paciente!');
            /* return view('layouts/sub_content', ['view' => 'listaespera/exibirsituacao',
                                                'validation' => $this->validator]); */
            return redirect()->to(base_url('listaespera/exibirsituacao'));

        
        }

        //die(var_dump($queryData));

        return view('layouts/sub_content', ['view' => 'mapacirurgico/list_listahistorico',
                                            'historico' => $result,
                                            'data' => $queryData]);
    }
     /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function getHistorico(int $idlista)
    {

        $db = \Config\Database::connect('default');

        $builder = $db->table('historico as hist');
        $builder->join('eventos as even', 'even.id = hist.idevento', 'inner');
        $builder->where('hist.idlistaespera', $idlista);
        
        $builder->select('
                         hist.dthrevento,
                         hist.idlogin,
                         even.nmevento'
                        );

        //var_dump($builder->getCompiledSelect());die();

        return $builder->get()->getResult();
    }
    /**
     * 
     * @return mixed
     */
    public function migrarHistorico() {

        $sqlTruncate = "truncate historico;";
        $sqlDropDefault = "ALTER TABLE historico ALTER COLUMN id DROP DEFAULT;";
        $sqlSetVal = "SELECT setval('historico_seq', (SELECT max(id) FROM historico));";
        $sqlRestartVal = "ALTER SEQUENCE historico_seq RESTART WITH 1;";
        $sqlSetDefault = "ALTER TABLE historico ALTER COLUMN id SET DEFAULT nextval('historico_seq');";

        try {

            $db = \Config\Database::connect('default');

            $sql = "
                SELECT
                    ch.data,
                    ch.idlistacirurgica,
                    ch.idevento,
                    ch.usuario
                FROM cirurgias_historico ch
            ";

            $query = $db->query($sql);

            $result = $query->getResult();

            $query = $db->query($sqlTruncate);
            $query = $db->query($sqlRestartVal);
            //$query = $db->query($sqlDropDefault);

            $db->transStart();

            foreach ($result as $reg) {

                $historico = [];
                $historico['dthrevento'] = $reg->data;
                $historico['idlistaespera'] = $reg->idlistacirurgica;
                $historico['idevento'] = $reg->idevento;
                $historico['idlogin'] = $reg->usuario;

                $this->historicomodel->insert($historico);
                
                if ($db->transStatus() === false) {
                    $error = $db->error();
                    $errorMessage = isset($error['message']) ? $error['message'] : 'Erro desconhecido';
                    $errorCode = isset($error['code']) ? $error['code'] : 0;

                    throw new \Exception(
                        sprintf('Erro ao incluir historico! [%d] %s', $errorCode, $errorMessage)
                    );
                }

            }

            $db->transComplete();

            if ($db->transStatus() === false) {
                $error = $db->error();
                $errorMessage = isset($error['message']) ? $error['message'] : 'Erro desconhecido';
                $errorCode = isset($error['code']) ? $error['code'] : 0;

                throw new \Exception(
                    sprintf('Erro na criação do histórico! [%d] %s', $errorCode, $errorMessage)
                );
            }

            $query = $db->query($sqlSetVal);
            $query = $db->query($sqlSetDefault);

        } catch (\Throwable $e) {
            $msg = 'Falha na criação do histórico ==> '.$e->getMessage();
            log_message('error', $msg.': ' . $e->getMessage());
            throw $e;
        }
    }
    /**
     * 
     * @return mixed
     */
    public function migrarMapa() {

        try {

            $db = \Config\Database::connect('default');

            $sqlTruncate = "truncate mapa_cirurgico RESTART IDENTITY;";
            $sqlDropDefault = "ALTER TABLE mapa_cirurgico ALTER COLUMN id DROP DEFAULT;";
            $sqlSetVal = "SELECT setval('mapa_cirurgico_seq', (SELECT MAX(id) FROM mapa_cirurgico mc));";
            $sqlSetDefault = "ALTER TABLE mapa_cirurgico ALTER COLUMN id SET DEFAULT nextval('mapa_cirurgico_seq');";
            $sqlTruncateEqpMed = "truncate equipe_medica;";
            $sqlDropDefaultEqpMed = "ALTER TABLE equipe_medica ALTER COLUMN id DROP DEFAULT;";
            $sqlSetValEqpMed = "SELECT setval('equipe_medica_seq', 1);";
            $sqlSetDefaultEqpMed = "ALTER TABLE equipe_medica ALTER COLUMN id SET DEFAULT nextval('equipe_medica_seq');";

            $sql = "
                SELECT DISTINCT
                cm.idmapacirurgico,
                cm.idlistacirurgica,
                cm.aguardando,
                cm.nocentrocirurgico,
                cm.cirurgia,
                cm.saida,
                cm.suspensa,
                cm.cancelada,
                cm.datacirurgia,
                cm.idcentrocirurgico,
                cm.idsala,
                cl.datainclusao,
                CASE 
                    WHEN cm.posoperatorio = 'UTIAD' THEN 1
                    WHEN cm.posoperatorio = 'UTINEO' THEN 2
                    WHEN cm.posoperatorio = 'UCO' THEN 3
                    WHEN cm.posoperatorio = 'UTINEOHOSPITAL DIA' THEN 4
                    WHEN cm.posoperatorio = 'ENFERMARIA' THEN 5
                    WHEN cm.posoperatorio = 'UUE' THEN 6
                    WHEN cm.posoperatorio = 'DIP' THEN 7
                END AS posoperatorio,
                cm.saidacentrocirurgico,
                CASE 
                    WHEN ch.hemoderivado = 0 THEN 'N'
                    WHEN ch.hemoderivado = 1 THEN 'S'
                    END AS hemoderivado,
                    cjm.justificativa as justificativa_envio,
                    cjs.justificativa as justificativa_suspensao,
                    cnp.necessidadesprocedimento,
                    cm.ordem
                FROM cirurgias_mapacirurgico cm
                INNER JOIN cirurgias_listacirurgica cl ON cl.idlistacirurgica = cm.idlistacirurgica 
                LEFT JOIN cirurgias_hemoderivado ch ON ch.idlistacirurgica = cl.idlistacirurgica
                LEFT JOIN cirurgias_justificativas_mapa cjm ON cjm.idlistacirurgica = cl.idlistacirurgica
                LEFT JOIN cirurgias_justificativa_suspensao cjs ON cjs.idmapacirurgico = cm.idmapacirurgico
                LEFT JOIN cirurgias_necessidadesprocedimento cnp ON cnp.idlistacirurgica = cl.idlistacirurgica
            ";

            $query = $db->query($sql);

            $result = $query->getResult();

            $query = $db->query($sqlTruncateEqpMed);
            $query = $db->query($sqlDropDefaultEqpMed);
            $query = $db->query($sqlSetValEqpMed);
            $query = $db->query($sqlSetDefaultEqpMed);

            $query = $db->query($sqlTruncate);
            $query = $db->query($sqlDropDefault);

            $db->transStart();

            foreach ($result as $reg) {

                $mapa = [];
                $mapa['id'] = $reg->idmapacirurgico;
                $mapa['idlistaespera'] = $reg->idlistacirurgica;
                $mapa['dthrnocentrocirurgico'] = $reg->nocentrocirurgico;
                $mapa['dthremcirurgia'] = $reg->cirurgia;
                $mapa['dthrsaidasala'] = $reg->saida;
                $mapa['dthrsaidacentrocirurgico'] = $reg->saidacentrocirurgico;
                $mapa['dthrsuspensao'] = $reg->cancelada;
                $mapa['dthrtroca'] = $reg->suspensa;
                $mapa['dthrcirurgia'] = $reg->aguardando;
                $mapa['idcentrocirurgico'] = $reg->idcentrocirurgico;
                $mapa['idsala'] = $reg->idsala;
                $mapa['idposoperatorio'] = $reg->posoperatorio;
                $mapa['indhemoderivados'] = $reg->hemoderivado;
                $mapa['txtjustificativaenvio'] = $reg->justificativa_envio;
                $mapa['txtjustificativasuspensao'] =  $reg->justificativa_suspensao;
                $mapa['txtnecessidadesproced'] = $reg->necessidadesprocedimento;
                $mapa['numordem'] = $reg->ordem;

                if ($reg->justificativa_suspensao) {
                    $resultjust = $this->justificativasmodel->Where('tipojustificativa', 'S')->Where('descricao', $reg->justificativa_suspensao)->select('id')->find();

                    if (!empty($resultjust[0])) {
                        $mapa['idsuspensao'] = $resultjust[0]['id'];
                    } else {
                        $mapa['idsuspensao'] = 49;
                    }
                } else {
                    $mapa['idsuspensao'] = NULL;
                }

                $dataLista = new DateTime($reg->datainclusao);
                $dataMapa = new DateTime($reg->datacirurgia);

                $diferenca = $dataMapa->diff($dataLista);

                if ($diferenca->days < 3 ) {
                    $mapa['indurgencia'] = 'S';
                } else {
                    $mapa['indurgencia'] = 'N';
                }
                
                $this->mapacirurgicomodel->insert($mapa);

                if ($db->transStatus() === false) {
                    $error = $db->error();
                    $errorMessage = isset($error['message']) ? $error['message'] : 'Erro desconhecido';
                    $errorCode = isset($error['code']) ? $error['code'] : 0;

                    throw new \CodeIgniter\Database\Exceptions\DatabaseException(
                        sprintf('Erro ao incluir Mapa! [%d] %s', $errorCode, $errorMessage)
                    );
                }

                $sql = "
                    select *
                    FROM cirurgias_equipemedica ce
                    WHERE ce.idmapacirurgico = $reg->idmapacirurgico
                    ";

                $query = $db->query($sql);

                $result_eqpmed = $query->getResult();

                foreach ($result_eqpmed as $reg_eqpmed) {

                    $mapa = [];
                    $mapa['idmapacirurgico'] = $reg_eqpmed->idmapacirurgico;
                    $mapa['idprofissional'] = $reg_eqpmed->idprofissional;
                    $mapa['codpessoa'] = $reg_eqpmed->idpessoa;

                    $this->equipemedicamodel->insert($mapa);

                    if ($db->transStatus() === false) {
                        $error = $db->error();
                        $errorMessage = isset($error['message']) ? $error['message'] : 'Erro desconhecido';
                        $errorCode = isset($error['code']) ? $error['code'] : 0;

                        throw new \CodeIgniter\Database\Exceptions\DatabaseException(
                            sprintf('Erro ao incluir equipe médica! [%d] %s', $errorCode, $errorMessage)
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
                    sprintf('Erro na criação do mapa cirurgico! [%d] %s', $errorCode, $errorMessage)
                );
            }

            $query = $db->query($sqlSetVal);
            $query = $db->query($sqlSetDefault);

        } catch (\Throwable $e) {
            $msg = 'Falha na criação do Mapa Cirúrgico ==> '.$e->getMessage();
            log_message('error', $msg.': ' . $e->getMessage());
            throw $e;
        }
    }
   
}