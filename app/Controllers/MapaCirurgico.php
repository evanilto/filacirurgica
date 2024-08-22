<?php

namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;
use App\Libraries\HUAP_Functions;
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
use App\Models\PosOperatorioModel;
use App\Models\ProcedimentosAdicionaisModel;
use App\Models\EquipeMedicaModel;
use DateTime;
use CodeIgniter\Config\Services;
use Config\Database;
use CodeIgniter\Database\Exceptions\DatabaseException;
use PHPUnit\Framework\Constraint\IsNull;
use CodeIgniter\HTTP\ResponseInterface;


class MapaCirurgico extends ResourceController
{
    private $listaesperamodel;
    private $vwlistaesperamodel;
    private $vwmapacirurgicomodel;
    private $vwstatusfilacirurgicamodel;
    private $vwsalascirurgicasmodel;
    private $mapacirurgicomodel;
    private $filamodel;
    private $riscomodel;
    private $origempacientemodel;
    private $lateralidademodel;
    private $posoperatoriomodel;
    private $procedimentosadicionaismodel;
    private $equipemedicamodel;
    private $usuariocontroller;
    private $aghucontroller;
    private $selectfila;
    private $selectrisco;
    private $selectespecialidade;
    private $selectespecialidadeaghu;
    private $selectprofespecialidadeaghu;
    private $selectcentroscirurgicosaghu;
    private $selectsalascirurgicasaghu;
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
        $this->vwmapacirurgicomodel = new vwMapaCirurgicoModel();
        $this->vwstatusfilacirurgicamodel = new VwStatusFilaCirurgicaModel();
        $this->vwsalascirurgicasmodel = new VwSalasCirurgicasModel();
        $this->mapacirurgicomodel = new MapaCirurgicoModel();
        $this->filamodel = new FilaModel();
        $this->riscomodel = new RiscoModel();
        $this->origempacientemodel = new OrigemPacienteModel();
        $this->lateralidademodel = new LateralidadeModel();
        $this->posoperatoriomodel = new PosOperatorioModel;
        $this->procedimentosadicionaismodel = new ProcedimentosAdicionaisModel();
        $this->equipemedicamodel = new EquipeMedicaModel();
        $this->usuariocontroller = new Usuarios();
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
        //$this->selectsalascirurgicasaghu = $this->vwsalascirurgicasmodel->findAll();
        $this->selectcentroscirurgicosaghu = $this->aghucontroller->getCentroCirurgico();
        $this->selectsalascirurgicasaghu = $this->aghucontroller->getSalasCirurgicas();

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
    public function getDetailsAside($idmapa)
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
    }
    /**
     * Retorna o prontuario cadastrado no aghu
     *
     * @return mixed
     */
    public function getDetalhesCirurgia(int $prontuario) 
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
    public function consultarMapaCirurgico(string $idmapacirurgico = null)
    {
        HUAP_Functions::limpa_msgs_flash();

        //$data['dtinicio'] = date('d/m/Y', strtotime($this->getFirst()['created_at']));
        $data['dtinicio'] = date('d/m/Y');
        $data['dtfim'] = date('d/m/Y');
        $data['filas'] = $this->selectfila;
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

        $data = $this->request->getVar();

        $dataflash = session()->getFlashdata('dataflash');

        if ($dataflash) {
            $data = $dataflash;
        }

        //die(var_dump($dataflash));

        if(!empty($data['prontuario']) && is_numeric($data['prontuario'])) {
            $resultAGHUX = $this->aghucontroller->getPaciente($data['prontuario']);

            if(!empty($resultAGHUX[0])) {
                $prontuario = $data['prontuario'];
            }
        }

        $rules = [
            'prontuario' => 'permit_empty|min_length[1]|max_length[8]|equals['.$prontuario.']',
            'nome' => 'permit_empty|min_length[3]',
        ];

        if (!$dataflash) {
            $rules = $rules + [
                'dtinicio' => 'required|valid_date[d/m/Y]',
                'dtfim' => 'required|valid_date[d/m/Y]',
            ];
        }

        if ($this->validate($rules)) {

            if (DateTime::createFromFormat('d/m/Y', $data['dtfim'])->format('Y-m-d') < DateTime::createFromFormat('d/m/Y', $data['dtinicio'])->format('Y-m-d')) {
                $this->validator->setError('dtinicio', 'A data de início não pode ser maior que a data final!');

                session()->setFlashdata('warning_message', 'Nenhum paciente localizado com os parâmetros informados!');
                return view('layouts/sub_content', ['view' => 'mapacirurgico/form_consulta_mapacirurgico',
                                                    'validation' => $this->validator,
                                                    'data' => $data]);
            }
            
            $this->validator->reset();

            $horaAtual = date('H:i:s');
            $data['dtfim'] = $data['dtfim'] . ' ' . $horaAtual;

            $result = $this->getMapaCirurgico($data);

            //die(var_dump($result));

            if (empty($result)) {

                $data['filas'] = $this->filamodel->Where('indsituacao', 'A')->orderBy('nmtipoprocedimento', 'ASC')->findAll();
                $data['riscos'] = $this->riscomodel->Where('indsituacao', 'A')->orderBy('nmrisco', 'ASC')->findAll();
                $data['especialidades'] = $this->aghucontroller->getEspecialidades();

                session()->setFlashdata('warning_message', 'Nenhum paciente localizado com os parâmetros informados!');
                return view('layouts/sub_content', ['view' => 'mapacirurgico/form_consulta_mapacirurgico',
                                                    'validation' => $this->validator,
                                                    'data' => $data]);
            
            }

            //die(var_dump($result));

            session()->set('mapa_cirurgico_resultados', $result);

            /* $result = session()->get('mapa_cirurgico_resultados');
            die(var_dump($result)); */

            return view('layouts/sub_content', ['view' => 'mapacirurgico/list_mapacirurgico',
                                               'mapacirurgico' => $result,
                                               'data' => $data]);

        } else {
            if(isset($resultAGHUX) && empty($resultAGHUX)) {
                $this->validator->setError('prontuario', 'Esse prontuário não existe na base do AGHUX!');
            }
            
            $data['filas'] = $this->filamodel->Where('indsituacao', 'A')->orderBy('nmtipoprocedimento', 'ASC')->findAll();
            $data['riscos'] = $this->riscomodel->Where('indsituacao', 'A')->orderBy('nmrisco', 'ASC')->findAll();
            $data['especialidades'] = $this->aghucontroller->getEspecialidades();

            return view('layouts/sub_content', ['view' => 'mapacirurgico/form_consulta_mapacirurgico',
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

    // Selecionando campos específicos com aliases
    $builder->select('
        vw_mapacirurgico.*,
        (vw_statusfilacirurgica.campos_mapa).status AS status_fila,
    ');
   
    if (!empty($data['idmapa'])) {
    
        $builder->where('id', $data['idmapa']);

    } else {

        // Adicionando a cláusula WHERE para o intervalo de datas
        $builder->where("vw_mapacirurgico.dthrcirurgia BETWEEN '{$data['dtinicio']}' AND '{$data['dtfim']}'");

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
            $builder->where('vw_mapacirurgico.idtipoprocedimento', $data['fila']);
        }

        // Condicional para risco
        if (!empty($data['risco'])) {
            $builder->where('vw_mapacirurgico.idriscocirurgico', $data['risco']);
        }

        // Condicional para complexidades
        if (!empty($data['complexidades'])) {
            $builder->whereIn('vw_mapacirurgico.complexidade', $data['complexidades']);
        }

       $builder->orderBy('vw_mapacirurgico.dthrcirurgia', 'ASC');

    }
    
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
        $builder->where('idfila', $data['fila'] ?? $data['fila_hidden']);
        $builder->where('DATE(dthrcirurgia)', $data['dtcirurgia']);
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

        //var_dump($data['prof_especialidades']);die();

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

        //die(var_dump($data));

        $rules = [
            'especialidade' => 'required',
            'dtrisco' => 'permit_empty|valid_date[d/m/Y]',
            'dtcirurgia' => 'required|valid_date[d/m/Y H:i]',
            'fila' => 'required',
            'procedimento' => 'required',
            'posoperatorio' => 'required',
            'profissional' => 'required',
            'lateralidade' => 'required',
            'justorig' => 'max_length[1024]|min_length[0]',
            'info' => 'max_length[1024]|min_length[0]',
            'nec_proced' => 'required|max_length[500]|min_length[3]',
        ];

        if ($this->validate($rules)) {

            $db = \Config\Database::connect('default');

            if ($this->mapacirurgicomodel->where('idlistaespera', $this->data['id'])->where('deleted_at', null)->findAll()) {
                session()->setFlashdata('failed', 'Lista com esse paciente já foi enviada ao Mapa Cirúrgico');

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
                    'txtjustificativaenvio' => $this->data['justenvio']
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
     * 
     * @return mixed
     */
    private function carregaMapa() {

        $this->data['especialidade'] = $this->data['especialidade'] ?? $this->data['especialidade_hidden'];
        $this->data['fila'] = $this->data['fila'] ?? $this->data['fila_hidden'];
        $this->data['procedimento'] = $this->data['procedimento'] ?? $this->data['procedimento_hidden'];

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

        $this->data['centros_cirurgicos'] = $this->selectcentroscirurgicosaghu;
        $this->data['salas_cirurgicas'] = $this->selectsalascirurgicasaghu;

    }
    /**
     * 
     * @return mixed
     */
    private function carregaProfissionais($id) {


        die(var_dump($this->equipemedicamodel->where(['idmapacirurgico' => $id])->find()));

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
        $data['ordemfila'] = $mapa->ordem_fila;
        $data['idmapa'] = $mapa->id;
        $data['idlistaespera'] = $mapa->idlista;
        $data['status_fila'] = ($mapa->status_fila != "Suspensa" && $mapa->status_fila != "Cancelada" && $mapa->status_fila != "Realizada") ? 'enabled' : 'disabled';
        $data['dtcirurgia'] = date('d/m/Y H:i', strtotime('+3 days'));
        $data['prontuario'] = $mapa->prontuario;
        $data['especialidade'] = $mapa->idespecialidade;
        $data['risco'] = $mapa->idriscocirurgico;
        $data['dtrisco'] = $mapa->dtrisco ? DateTime::createFromFormat('Y-m-d', $mapa->dtrisco)->format('d/m/Y') : NULL;
        $data['cid'] = $mapa->cid;
        $data['complexidade'] = $mapa->complexidade;
        $data['fila'] = $mapa->idfila;
        $data['origem'] = $mapa->idorigempaciente;
        $data['congelacao'] = $mapa->indcongelacao;
        $data['procedimento'] = $mapa->idprocedimento;
        $data['lateralidade'] = $mapa->lateralidade;
        $data['hemoderivados'] = $mapa->indhemoderivados;
        $data['posoperatorio'] = $mapa->idposoperatorio;
        $data['info'] = $mapa->infoadicionais;
        $data['nec_proced'] = $mapa->necessidadesproced;
        $data['justorig'] = $mapa->origemjustificativa;
        $data['justenvio'] = $mapa->justificativaenvio;
        $data['centrocirurgico'] =  $mapa->idcentrocirurgico;
        $data['sala'] =  $mapa->idsala ?? '';
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
        $codToRemove = $mapa->idprocedimento;
        $procedimentos = $data['procedimentos'];
        $data['procedimentos_adicionais'] = array_filter($procedimentos, function($procedimento) use ($codToRemove) {
            return $procedimento->cod_tabela !== $codToRemove;
        });

       //var_dump($data['sala']);die();
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
            'dtrisco' => 'permit_empty|valid_date[d/m/Y]',
            'dtcirurgia' => 'required|valid_date[d/m/Y H:i]',
            'fila' => 'required',
            'procedimento' => 'required',
            'posoperatorio' => 'required',
            'profissional' => 'required',
            'lateralidade' => 'required',
            'info' => 'max_length[1024]|min_length[3]',
            'nec_proced' => 'required|max_length[500]|min_length[3]',
            'centrocirurgico' => 'required',
            'sala' => 'required'
        ];

        if ($this->validate($rules)) {

            $db = \Config\Database::connect('default');

            $db->transStart();

            try {

                $lista = [
                        'idriscocirurgico' => empty($this->data['risco']) ? NULL : $this->data['risco'],
                        'dtriscocirurgico' => empty($this->data['dtrisco']) ? NULL : $this->data['dtrisco'],
                        'numcid' => empty($this->data['cid']) ? NULL : $this->data['cid'],
                        'idcomplexidade' => $this->data['complexidade'],
                        'indcongelacao' => $this->data['congelacao'],
                        'idlateralidade' => $this->data['lateralidade'],
                        'txtinfoadicionais' => $this->data['info']
                        ];

                $this->listaesperamodel->update($this->data['idlistaespera'], $lista);

                if ($db->transStatus() === false) {
                    $error = $db->error();
                    $errorMessage = !empty($error['message']) ? $error['message'] : 'Erro desconhecido';
                    $errorCode = !empty($error['code']) ? $error['code'] : 0;

                    throw new \CodeIgniter\Database\Exceptions\DatabaseException(
                        sprintf('Erro ao atualizar Lista de Espera [%d] %s', $errorCode, $errorMessage)
                    );
                }

                $mapa = [
                    'idlistaespera' => $this->data['idlistaespera'],
                    'dthrcirurgia' => $this->data['dtcirurgia'],
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

                if (isset($this->data['proced_adic'])) {

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

                if (isset($this->data['profissional'])) {

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
                
            } catch (\Exception $e) {
                $db->transRollback(); // Reverte a transação em caso de erro
                $msg = sprintf('Exception - Falha na atualização do Mapa Cirúrgico - prontuário: %d - cod: (%d) msg: %s', (int) $this->data['prontuario'], (int) $e->getCode(), $e->getMessage());
                log_message('error', 'Exception: ' . $msg);
                session()->setFlashdata('exception', $msg);
            } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
                $db->transRollback(); // Reverte a transação em caso de erro
                $msg = sprintf('DatabaseException -  Falha na atualização do Mapa Cirúrgico - prontuário: %d - cod: (%d) msg: %s', (int) $this->data['prontuario'], (int) $e->getCode(), $e->getMessage());
                log_message('error', 'Exception: ' . $msg);
                session()->setFlashdata('exception', $msg);
            } catch (\CodeIgniter\Database\Exceptions\DataException $e) {
                $db->transRollback(); // Reverte a transação em caso de erro
                $msg = sprintf('DataException -  Falha na atualização do Mapa Cirúrgico - prontuário: %d - cod: (%d) msg: %s', (int) $this->data['prontuario'], (int) $e->getCode(), $e->getMessage());
                log_message('error', 'Exception: ' . $msg);
                session()->setFlashdata('exception', $msg);
            }

            $this->carregaMapa();

            return view('layouts/sub_content', ['view' => 'mapacirurgico/form_atualiza_mapacirurgico',
                                                'data' => $this->data]);

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
    public function ConsultarCirurgia(int $id)
    {
       
        HUAP_Functions::limpa_msgs_flash();

        $mapa = $this->getMapaCirurgico(['idmapa' => $id])[0];

        //die(var_dump($mapa));

        $data = [];
        $data['ordem_fila'] = $mapa->ordem_fila;
        $data['idmapa'] = $mapa->id;
        $data['idlistaespera'] = $mapa->idlista;
        $data['dtcirurgia'] = date('d/m/Y H:i', strtotime('+3 days'));
        $data['prontuario'] = $mapa->prontuario;
        $data['especialidade'] = $mapa->idespecialidade;
        $data['risco'] = $mapa->idriscocirurgico;
        $data['dtrisco'] = $mapa->dtrisco ? DateTime::createFromFormat('Y-m-d', $mapa->dtrisco)->format('d/m/Y') : NULL;
        $data['cid'] = $mapa->cid;
        $data['complexidade'] = $mapa->complexidade;
        $data['fila'] = $mapa->idfila;
        $data['origem'] = $mapa->idorigempaciente;
        $data['congelacao'] = $mapa->indcongelacao;
        $data['procedimento'] = $mapa->idprocedimento;
        $data['lateralidade'] = $mapa->lateralidade;
        $data['hemoderivados'] = $mapa->indhemoderivados;
        $data['posoperatorio'] = $mapa->idposoperatorio;
        $data['info'] = $mapa->infoadicionais;
        $data['nec_proced'] = $mapa->necessidadesproced;
        $data['justorig'] = $mapa->origemjustificativa;
        $data['justenvio'] = $mapa->justificativaenvio;
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
    public function trocarPaciente()
    {
        HUAP_Functions::limpa_msgs_flash();

        $pac1 = $this->request->getVar();

        //die(var_dump($data));

        $mapapac1 = $this->mapacirurgicomodel->find($pac1['idmapa']);

        //die(var_dump($mapapac1));
        //$listapac1 = $this->listaesperamodel->find($mapapac1['idlistaespera']);

        $data = [];
        $data['candidatos'] = $this->vwstatusfilacirurgicamodel->Where('idfila', $pac1['idfila'])
                                                               ->where('(campos_mapa).status', 'Programada')
                                                               ->where('idespecialidade', $pac1['idespecialidade'])->findAll();
        //$data['candidatos'] = $this->vwstatusfilacirurgicamodel->getPacientesDaFila($pac1['idfila'], $pac1['idespecialidade']);
        $data['idlistapac1'] = $mapapac1['idlistaespera'];
        $data['idmapapac1'] = $mapapac1['id'];
        $data['dtcirurgia'] = DateTime::createFromFormat('Y-m-d H:i:s', $mapapac1['dthrcirurgia'])->format('d/m/Y H:i');
        $data['candidato'] = '';
        $data['especialidade'] = $pac1['idespecialidade'];
        $data['risco'] = '';
        $data['dtrisco'] = '';
        $data['cid'] = '';
        $data['complexidade'] = '';
        $data['fila'] = $pac1['idfila'];
        $data['origem'] = '';
        $data['congelacao'] = '';
        $data['procedimento'] = '';
        $data['proced_adic'] = [];
        $data['lateralidade'] = '';
        $data['posoperatorio'] = null;
        $data['info'] = '';
        $data['nec_proced'] = '';
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

        //$codToRemove = $mapapac1['idprocedimento'];
        //$procedimentos = $data['procedimentos'];
        //$data['procedimentos_adicionais'] = array_filter($procedimentos, function($procedimento) use ($codToRemove) {
            //return $procedimento->cod_tabela !== $codToRemove;
        //});
        $data['procedimentos_adicionais'] = $data['procedimentos'];

       //var_dump($data);die();

        $codToRemove = $pac1['prontuario'];
        $candidatos = $data['candidatos'];
        //die(var_dump($candidatos));
        $data['candidatos'] = array_filter($candidatos, function($candidato) use ($codToRemove) {
            return $candidato['prontuario'] !== $codToRemove;
        });

        //var_dump($data['procedimentos']);die();

        return view('layouts/sub_content', ['view' => 'mapacirurgico/form_troca_paciente',
                                            'data' => $data]);
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

        $rules = [
            'especialidade' => 'required',
            'dtrisco' => 'permit_empty|valid_date[d/m/Y]',
            'dtcirurgia' => 'required|valid_date[d/m/Y H:i]',
            'fila' => 'required',
            'procedimento' => 'required',
            'posoperatorio' => 'required',
            'profissional' => 'required',
            'lateralidade' => 'required',
            'info' => 'max_length[1024]|min_length[0]',
            'nec_proced' => 'required|max_length[500]|min_length[3]',
        ];

        if ($this->validate($rules)) {

            $db = \Config\Database::connect('default');

            if ($this->mapacirurgicomodel->where('idlistaespera', $this->data['idlistapac2'])->where('deleted_at', null)->findAll()) {

                session()->setFlashdata('failed', 'Lista com esse paciente já foi enviada ao Mapa Cirúrgico');

                $this->carregaMapa();

                $this->data['candidatos'] = $this->vwstatusfilacirurgicamodel->Where('idtipoprocedimento', $this->data['fila'])
                                                       ->where('idespecialidade', $this->data['especialidade'])->findAll();

                return view('layouts/sub_content', ['view' => 'mapacirurgico/form_troca_paciente',
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
                        ];

                $this->listaesperamodel->update($this->data['idlistapac2'], $lista);

                if ($db->transStatus() === false) {
                    $error = $db->error();
                    $errorMessage = !empty($error['message']) ? $error['message'] : 'Erro desconhecido';
                    $errorCode = !empty($error['code']) ? $error['code'] : 0;

                    throw new \CodeIgniter\Database\Exceptions\DatabaseException(
                        sprintf('Erro ao atualizar Lista de Espera [%d] %s', $errorCode, $errorMessage)
                    );
                }

                $mapa = [
                    'idlistaespera' => $this->data['idlistapac2'],
                    'dthrcirurgia' => $this->data['dtcirurgia'],
                    'idposoperatorio' => $this->data['posoperatorio'],
                    'indhemoderivados' => $this->data['hemoderivados'],
                    'txtnecessidadesproced' => $this->data['nec_proced']
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
                $array['dthrtroca'] = date('Y-m-d H:I:s');
                $array['idlistatroca'] = $this->data['idlistapac2'];

                $this->mapacirurgicomodel->update($this->data['idmapapac1'], $array);

                if ($db->transStatus() === false) {
                    $error = $db->error();
                    $errorMessage = !empty($error['message']) ? $error['message'] : 'Erro desconhecido';
                    $errorCode = !empty($error['code']) ? $error['code'] : 0;

                    throw new \CodeIgniter\Database\Exceptions\DatabaseException(
                        sprintf('Erro ao atualizar o Mapa Cirúrgico! [%d] %s', $errorCode, $errorMessage)
                    );
                }

                $this->mapacirurgicomodel->delete($this->data['idmapapac1']);

                if ($db->transStatus() === false) {
                    $error = $db->error();
                    $errorMessage = !empty($error['message']) ? $error['message'] : 'Erro desconhecido';
                    $errorCode = !empty($error['code']) ? $error['code'] : 0;

                    throw new \CodeIgniter\Database\Exceptions\DatabaseException(
                        sprintf('Erro ao excluir paciente do Mapa Cirúrgico! [%d] %s', $errorCode, $errorMessage)
                    );
                }

                $this->listaesperamodel->where('id', $this->data['idlistapac1'])->set('deleted_at', NULL)->update();

                if ($db->transStatus() === false) {
                    $error = $db->error();
                    $errorMessage = !empty($error['message']) ? $error['message'] : 'Erro desconhecido';
                    $errorCode = !empty($error['code']) ? $error['code'] : 0;

                    throw new \CodeIgniter\Database\Exceptions\DatabaseException(
                        sprintf('Erro ao atualizar paciente na lista de espera! [%d] %s', $errorCode, $errorMessage)
                    );
                }

                $db->transComplete();

                session()->setFlashdata('success', 'Paciente trocado com sucesso!');

                $this->validator->reset();
                
            } catch (\Exception $e) {
                $db->transRollback(); // Reverte a transação em caso de erro
                $msg = sprintf('Exception - Falha na troca de paciente - prontuário: %d - cod: (%d) msg: %s', (int) $this->data['prontuario'], (int) $e->getCode(), $e->getMessage());
                log_message('error', 'Exception: ' . $msg);
                session()->setFlashdata('exception', $msg);
            } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
                $db->transRollback(); // Reverte a transação em caso de erro
                $msg = sprintf('DatabaseException -  Falha na troca de paciente - prontuário: %d - cod: (%d) msg: %s', (int) $this->data['prontuario'], (int) $e->getCode(), $e->getMessage());
                log_message('error', 'Exception: ' . $msg);
                session()->setFlashdata('exception', $msg);
            } catch (\CodeIgniter\Database\Exceptions\DataException $e) {
                $db->transRollback(); // Reverte a transação em caso de erro
                $msg = sprintf('DataException -  FFalha na troca de paciente - prontuário: %d - cod: (%d) msg: %s', (int) $this->data['prontuario'], (int) $e->getCode(), $e->getMessage());
                log_message('error', 'Exception: ' . $msg);
                session()->setFlashdata('exception', $msg);
            }

            $this->carregaMapa();

            $this->data['candidatos'] = $this->vwstatusfilacirurgicamodel->Where('idfila', $this->data['fila'])
                                                                 ->where('idespecialidade', $this->data['especialidade'])->findAll();

            return view('layouts/sub_content', ['view' => 'mapacirurgico/form_troca_paciente',
                                                'data' => $this->data]);

        } else {
            session()->setFlashdata('error', $this->validator);

            $this->carregaMapa();

            $this->data['candidatos'] = $this->vwstatusfilacirurgicamodel->Where('idfila', $this->data['fila'])
                                                                 ->where('idespecialidade', $this->data['especialidade'])->findAll();

            //die(var_dump($this->data));

            return view('layouts/sub_content', ['view' => 'mapacirurgico/form_troca_paciente',
                                                'validation' => $this->validator,
                                                'data' => $this->data]);
        }
    }
    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function incluirUrgencia()
    {
        HUAP_Functions::limpa_msgs_flash();

        $pac1 = $this->request->getVar();

        //die(var_dump($data));

        //$mapapac1 = $this->mapacirurgicomodel->find($pac1['idmapa']);

        //die(var_dump($mapapac1));
        $data = [];
        //$data['listaespera'] = $this->vwlistaesperamodel->Where('prontuario', $prontuario)->findAll();
        $data['listaesperas'] = [];
        $data['candidatos'] = null;
        $data['ordem'] = null;
        $data['dtcirurgia'] = date('d/m/Y');
        //DateTime::createFromFormat('Y-m-d H:i:s', $mapapac1['dthrcirurgia'])->format('d/m/Y H:i');
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
        $data['procedimentos_adicionais'] = $data['procedimentos'];
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
        ini_set('memory_limit', '1024M');

        \Config\Services::session();

        helper(['form', 'url', 'session']);

        $prontuario = null;

        $this->data = [];

        $this->data = $this->request->getVar();

        //die(var_dump($this->data));

        if(!empty($this->data['prontuario']) && is_numeric($this->data['prontuario'])) {
            $resultAGHUX = $this->aghucontroller->getPaciente($this->data['prontuario']);

            if(!empty($resultAGHUX[0])) {
                $prontuario = $this->data['prontuario'];
            }
        }

        $rules = [
            'prontuario' => 'required|min_length[1]|max_length[12]|equals['.$prontuario.']',
            'listapaciente' => 'required',
            'dtrisco' => 'permit_empty|valid_date[d/m/Y]',
            'dtcirurgia' => 'required|valid_date[d/m/Y]',
            'posoperatorio' => 'required',
            'profissional' => 'required',
            'lateralidade' => 'required',
            'origem' => 'required',
            'info' => 'max_length[1024]|min_length[0]',
            'nec_proced' => 'required|max_length[500]|min_length[3]',
            'justorig' => 'max_length[1024]|min_length[0]',
            'justurgencia' => 'required|max_length[250]|min_length[3]',
        ];

        if ($this->data['listapaciente'] == 0) {
            $rules = $rules + [
                'fila' => 'required',
                'especialidade' => 'required',
                'procedimento' => 'required'
            ];
         }

        //die(var_dump($this->data));

        if ($this->validate($rules)) {

            $db = \Config\Database::connect('default');

            if(isset($resultAGHUX) && empty($resultAGHUX)) {
                $this->validator->setError('prontuario', 'Esse prontuário não existe na base do AGHUX!');
            } else {
                if ($this->getPacienteNoMapa($this->data)) {
                    session()->setFlashdata('failed', 'Já existe uma cirurgia programada para esse paciente nesse dia!');
                } else {

                    $this->validator->reset();

                    //$result = $this->getPacienteNaLista($this->data);

                    //if ($result) {

                        //die(var_dump($result));

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
                                ];

                            if ($this->data['listapaciente'] != 0) {
                                $idlista = $this->data['listapaciente'];
                                $this->listaesperamodel->update($this->data['listapaciente'], $lista);
                            } else {
                                $lista = $lista + [
                                    'idespecialidade' => $this->data['especialidade'],
                                    'idtipoprocedimento' => $this->data['fila'],
                                    'idprocedimento' => $this->data['procedimento'],
                                    'numprontuario' => $this->data['prontuario'],
                                    'idorigempaciente' => $this->data['origem'],
                                    'indsituacao' => 'A',
                                    'indurgencia' => 'S'
                                    ];
                                $idlista = $this->listaesperamodel->insert($lista);
                            }

                            if ($db->transStatus() === false) {
                                $error = $db->error();
                                $errorMessage = !empty($error['message']) ? $error['message'] : 'Erro desconhecido';
                                $errorCode = !empty($error['code']) ? $error['code'] : 0;

                                throw new \CodeIgniter\Database\Exceptions\DatabaseException(
                                    sprintf('Erro ao atualizar Lista de Espera [%d] %s', $errorCode, $errorMessage)
                                );
                            }

                            $mapa = [
                                'idlistaespera' => $idlista,
                                'dthrcirurgia' => $this->data['dtcirurgia'],
                                'idposoperatorio' => $this->data['posoperatorio'],
                                'indhemoderivados' => $this->data['hemoderivados'],
                                'txtnecessidadesproced' => $this->data['nec_proced'],
                                'indurgencia' => 'S'
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

                            //die(var_dump(($this->data['idlistapac2'])));

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
                            
                        } catch (\Exception $e) {
                            $db->transRollback(); // Reverte a transação em caso de erro
                            $msg = sprintf('Exception - Falha na inclusão de cirurgia urgente - prontuário: %d - cod: (%d) msg: %s', (int) $this->data['prontuario'], (int) $e->getCode(), $e->getMessage());
                            log_message('error', 'Exception: ' . $msg);
                            session()->setFlashdata('exception', $msg);
                        } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
                            $db->transRollback(); // Reverte a transação em caso de erro
                            $msg = sprintf('DatabaseException - Falha na inclusão de cirurgia urgente - prontuário: %d - cod: (%d) msg: %s', (int) $this->data['prontuario'], (int) $e->getCode(), $e->getMessage());
                            log_message('error', 'Exception: ' . $msg);
                            session()->setFlashdata('exception', $msg);
                        } catch (\CodeIgniter\Database\Exceptions\DataException $e) {
                            $db->transRollback(); // Reverte a transação em caso de erro
                            $msg = sprintf('DataException - Falha na inclusão de cirurgia urgente - prontuário: %d - cod: (%d) msg: %s', (int) $this->data['prontuario'], (int) $e->getCode(), $e->getMessage());
                            log_message('error', 'Exception: ' . $msg);
                            session()->setFlashdata('exception', $msg);
                        }

                    //}

                    $this->carregaMapa();

                    $dados = $this->request->getPost();

                    //$dadosAntigos = session()->getFlashdata('dados') ?? []; // Pega dados existentes ou um array vazio se não houver

                    $dataflash['dtinicio'] = date('d/m/Y');
                    $dataflash['dtfim'] = date('d/m/Y');
                
                    session()->setFlashdata('dataflash', $dataflash);

                    //session()->setFlashdata('dados', $this->request->getPost());
                    return redirect()->to(base_url('mapacirurgico/exibir'));

                   /*  return view('layouts/sub_content', ['view' => 'mapacirurgico/form_inclui_urgencia',
                                                'data' => $this->data]); */
                }
            }

        } 

        session()->setFlashdata('error', $this->validator);

        if(isset($resultAGHUX) && empty($resultAGHUX)) {
            //die(var_dump($this->validator));
            $this->validator->setError('prontuario', 'Esse prontuário não existe na base do AGHUX!');
        }
        
        $this->carregaMapa();

        //die(var_dump($this->data));

        return view('layouts/sub_content', ['view' => 'mapacirurgico/form_inclui_urgencia',
                                            'validation' => $this->validator,
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
        $data['ordemfila'] = $mapa->ordem_fila;
        $data['prontuario'] = $mapa->prontuario;
        $data['especialidade'] = $mapa->idespecialidade;
        $data['especialidades'] = $this->selectespecialidadeaghu;
        $data['fila'] = $mapa->idfila;
        $data['filas'] = $this->selectfila;
        $data['procedimento'] = $mapa->idprocedimento;
        $data['procedimentos'] = $this->selectitensprocedhospit;

        $data['dthrcirurgia'] = DateTime::createFromFormat('Y-m-d H:i:s', $mapa->dthrcirurgia)->format('d/m/Y H:i');
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

        //die(var_dump($this->data));

        $rules = [
            'hrnocentrocirurgico' => 'permit_empty|valid_date[H:i]',
            'hremcirurgia' => 'permit_empty|valid_date[H:i]',
            'hrsaidasala' => 'permit_empty|valid_date[H:i]',
            'hrsaidacentrocirurgico' => 'permit_empty|valid_date[H:i]',
            //'hrsuspensao' => 'permit_empty|valid_date[H:i]',
        ];

        if ($this->validate($rules)) {

            $mapa = [
                'dthrnocentrocirurgico'  => !empty($data['hrnocentrocirurgico']) ? DateTime::createFromFormat('d/m/Y H:i', $data['dthrcirurgia'])->format('Y-m-d').' '.$data['hrnocentrocirurgico'] : NULL,
                'dthremcirurgia'  => !empty($data['hremcirurgia']) ? DateTime::createFromFormat('d/m/Y H:i', $data['dthrcirurgia'])->format('Y-m-d').' '.$data['hremcirurgia'] : NULL,
                'dthrsaidasala' => !empty($data['hrsaidasala']) ? DateTime::createFromFormat('d/m/Y H:i', $data['dthrcirurgia'])->format('Y-m-d').' '.$data['hrsaidasala'] : NULL,
                'dthrsaidacentrocirurgico' => !empty($data['hrsaidacentrocirurgico']) ? DateTime::createFromFormat('d/m/Y H:i', $data['dthrcirurgia'])->format('Y-m-d').' '.$data['hrsaidacentrocirurgico'] : NULL,
                //'dthrsuspensao' => $data['hrsuspensao'],
                ];

               //die(var_dump(DateTime::createFromFormat('Y-m-d H:i', $mapa['dthremcirurgia'])));
               $erro = false;

                $dthrEntrada = $this->createDateTime($mapa['dthrnocentrocirurgico']);
                $dthrInicioCirurgia = $this->createDateTime($mapa['dthremcirurgia']);
                $dthrSaidaSala = $this->createDateTime($mapa['dthrsaidasala']);
                $dthrSaidaCentroCirurgico = $this->createDateTime($mapa['dthrsaidacentrocirurgico']);

                // Lista de campos com a ordem esperada
                $campos = [
                    'hrnocentrocirurgico' => $dthrEntrada,
                    'hremcirurgia' => $dthrInicioCirurgia,
                    'hrsaidasala' => $dthrSaidaSala,
                    'hrsaidacentrocirurgico' => $dthrSaidaCentroCirurgico
                ];

                // Lista organizada de mensagens de erro
                $mensagensErro = [
                    'hremcirurgia' => 'A hora de início da cirurgia não pode ser menor que a hora de entrada no centro cirúrgico!',
                    'hrsaidasala' => 'A hora de saída da sala tem que ser maior que a hora de início de cirurgia!',
                    'hrsaidacentrocirurgico' => 'A hora de saída do centro cirúrgico não pode ser menor que a hora de saída da sala!'
                ];

                // Verificações das datas preenchidas quanto à ordem temporal
                foreach ($campos as $key => $value) {
                    if ($value) {
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
                $data['filas'] = $this->selectfila;
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
                
            } catch (\Exception $e) {
                $db->transRollback(); // Reverte a transação em caso de erro
                $msg = sprintf('Exception - Falha na atualização do Mapa Cirúrgico - prontuário: %d - cod: (%d) msg: %s', (int) $data['prontuario'], (int) $e->getCode(), $e->getMessage());
                log_message('error', 'Exception: ' . $msg);
                session()->setFlashdata('exception', $msg);
            } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
                $db->transRollback(); // Reverte a transação em caso de erro
                $msg = sprintf('DatabaseException -  Falha na atualização do Mapa Cirúrgico - prontuário: %d - cod: (%d) msg: %s', (int) $data['prontuario'], (int) $e->getCode(), $e->getMessage());
                log_message('error', 'Exception: ' . $msg);
                session()->setFlashdata('exception', $msg);
            } catch (\CodeIgniter\Database\Exceptions\DataException $e) {
                $db->transRollback(); // Reverte a transação em caso de erro
                $msg = sprintf('DataException -  Falha na atualização do Mapa Cirúrgico - prontuário: %d - cod: (%d) msg: %s', (int) $data['prontuario'], (int) $e->getCode(), $e->getMessage());
                log_message('error', 'Exception: ' . $msg);
                session()->setFlashdata('exception', $msg);
            }

            $data['especialidades'] = $this->selectespecialidadeaghu;
            $data['filas'] = $this->selectfila;
            $data['procedimentos'] = $this->selectitensprocedhospit;

            return view('layouts/sub_content', ['view' => 'mapacirurgico/form_atualiza_horarioscirurgia',
                                                'data' => $data]);

        } else {

            session()->setFlashdata('error', $this->validator);

            $data['especialidades'] = $this->selectespecialidadeaghu;
            $data['filas'] = $this->selectfila;
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

            //return $this->response->setJSON(['success' => true, 'message' => 'Evento registrado com sucesso no mapa cirúrgico!'.$evento['dthrsaidasala']]);

            $db = Database::connect('default');

            $db->transStart();

            //$this->mapacirurgicomodel->update($idMapa, $evento);
            $this->mapacirurgicomodel->update($arrayid['idMapa'], $evento);

            if ($db->transStatus() === false) {
                $db->transRollback(); 
                $error = $db->error();
                $errorMessage = !empty($error['message']) ? $error['message'] : 'Erro desconhecido';
                $errorCode = !empty($error['code']) ? $error['code'] : 0;

                throw new DatabaseException(sprintf('Erro ao atualizar Mapa Cirúrgico! [%d] %s', $errorCode, $errorMessage));
            }

            if ($evento['dthrsuspensao'] /*|| $evento['dthrcancelamento']*/) {
                //$this->listaesperamodel->update($arrayid['idLista'], ['delete_at' => '']);
                $this->listaesperamodel->where('id', $arrayid['idLista'])->set('deleted_at', NULL)->update();

                if ($db->transStatus() === false) {
                    $db->transRollback(); 
                    $error = $db->error();
                    $errorMessage = !empty($error['message']) ? $error['message'] : 'Erro desconhecido';
                    $errorCode = !empty($error['code']) ? $error['code'] : 0;
    
                    throw new DatabaseException(sprintf('Erro ao atualizar Lista de Espera! [%d] %s', $errorCode, $errorMessage));
                }
            }

            $db->transComplete();

            session()->setFlashdata('success', 'Cirurgia atualizada com sucesso!');

            return $this->response->setJSON(['success' => true, 'message' => 'Evento registrado com sucesso no mapa cirúrgico!']);

        } catch (\Exception $e) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR)
                                  ->setJSON(['success' => false, 'message' => $e->getMessage()]);
        }
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
    // Helper para criar objeto DateTime só se a data não estiver vazia
    function createDateTime($dateString) {
        return empty($dateString) ? null : DateTime::createFromFormat('Y-m-d H:i', $dateString);
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
                SELECT
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
                $mapa['dtxtjustificativasuspensao'] = $reg->justificativa_suspensao;
                $mapa['txtnecessidadesproced'] = $reg->necessidadesprocedimento;
                $mapa['indurgencia'] = 'N';
                $mapa['numordem'] = $reg->ordem;

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

        } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
            $msg = 'Falha na criação do Mapa Cirúrgico ==> '.$e->getMessage();
            log_message('error', $msg.': ' . $e->getMessage());
            throw $e;
        }
    }
   
}