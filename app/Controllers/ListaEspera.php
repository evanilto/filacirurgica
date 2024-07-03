<?php

namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;
use App\Controllers\Exception;
use App\Libraries\HUAP_Functions;
use App\Models\VwListaEsperaModel;

class ListaEspera extends ResourceController
{
    private $vwlistaesperamodel;
    private $movimentacaomodel;
    private $solicitacaomodel;
    private $pacientesmvmodel;
    private $setortramitemodel;
    private $movimentacaocontroller;
    private $setorcontroller;
    private $usuariocontroller;
    private $aghucontroller;
    private $pacientesmvcontroller;
    //private $function;


    public function __construct()
    {
        $this->vwlistaesperamodel = new VwListaEsperaModel();
        $this->usuariocontroller = new Usuarios();
        $this->aghucontroller = new Aghu();
    }

    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        $pager = service('pager');
        $page    = (int) ($this->request->getGet('page') ?? 1);
        $perPage = 10;
        $total   = 100;

        // Call makeLinks() to make pagination links.
        $pager_links = $pager->makeLinks($page, $perPage, $total, 'default_full');

        echo view('templates/header', ['menu' => 'Setores']);
        echo view('setores/maincontent', [
        'setores' => $this->vwlistaesperamodel->paginate(10),
        'pager_links' => $pager_links,
        ]);
        echo view('templates/footer');

    }
    /**
     * 
     *
     * @return mixed
     */
    public function getListaEspera(int $listaespera = null) {
        
        if ($listaespera) {
            return $this->vwlistaesperamodel->getWhere(['numProntuarioAGHU' => $listaespera])->getResult();
        } else {
            return $this->respond($this->vwlistaesperamodel->findAll());
        }
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
    public function getUltimoVolume($nu_listaespera)
    {
        $data = $this->vwlistaesperamodel->Where('numProntuarioAGHU', $nu_listaespera)->orderBy('numVolume', 'desc')->first();

        return $data;
    }
    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        $data = $this->vwlistaesperamodel->getWhere(['id' => $id])->getResult();

        if($data){
            return $this->respond($data);
        }
        
        return $this->failNotFound('Nenhum setor encontrado com id '.$id); 
    }
    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function consultarMovimentacoesSetor()
    {
        helper('form');

        //die(var_dump($this->setorcontroller->select));

        return view('ListaEspera/consultar_movimentacoes_setor', ['selectSetorOrigem' => $this->setorcontroller->select,  
                                                                  'selectSetorDestino' => $this->setorcontroller->select,    
                                                                  'dtinicio' => date('d/m/Y'),
                                                                  'dtfim' => date('d/m/Y')
                                                                 ]);

    }
    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function qtdMovimentacoesSetor()
    {        
        helper(['form', 'url']);

        HUAP_Functions::limpa_msgs_flash();

        $data = $this->request->getVar();

        //die(var_dump($data));
        //var_dump($arraySetOrigem);
        //var_dump($arraySetDestino);die();

        $rules = [
            'dtinicio' => 'required|valid_date[d/m/Y]',
            'dtfim' => 'required|valid_date[d/m/Y]'
        ];

        if ($this->validate($rules)) {

            if (DateTime::createFromFormat('d/m/Y', $data['dtfim'])->format('Y-m-d') < DateTime::createFromFormat('d/m/Y', $data['dtinicio'])->format('Y-m-d')) {
                $this->validator->setError('dtinicio', 'A data de início não pode ser maior que a data final!');

                //die(var_dump($data));
                return view('ListaEspera/consultar_movimentacoes_setor', ['validation' => $this->validator,
                'dtinicio' => $data['dtinicio'],
                'dtfim' => $data['dtfim'],
                'selectSetorOrigem' => $this->setorcontroller->select,
                'selectSetorDestino' => $this->setorcontroller->select
                ]);

            } else {

                $qtdTotal = $qtdEnv = $qtdRec = 0;
                $array = array(array('', ''));
                $arraySetores = [];

                //die(var_dump($data));
                //die(var_dump(json_decode($data['setorOrigem'], true)));

                if (empty($data['setorOrigem'])) {
                    $data['setorOrigem'] = $this->setorcontroller->select['Setor'];
                    //die(var_dump($data['setorOrigem']));
                }

                if (empty($data['setorDestino'])) {
                    $data['setorDestino'] = $this->setorcontroller->select['Setor'];
                }

                foreach ($data['setorOrigem'] as $key => $setorOrigem) {
                    if (!is_array($setorOrigem)) {
                        [$idSetoOrigem, $nmSetorOrigem, $idSetorOrigOrigem] = explode('#', $setorOrigem);
                    } else {
                        $nmSetorOrigem = $setorOrigem['nmSetor'];
                    }
                    //die($nmSetorOrigem);
                    foreach ($data['setorDestino'] as $key => $setorDestino) {
                        if (!is_array($setorDestino)) {
                            [$idSetoDestino, $nmSetorDestino, $idSetorOrigDestino] = explode('#', $setorDestino);
                        } else {
                            $nmSetorDestino = $setorDestino['nmSetor'];
                        }
                        //$setor = json_decode($setorDestino, true);
                        //$nmSetorDestino = $setorDestino['nmSetor'];

                        if ($nmSetorOrigem != $nmSetorDestino) {

                            $qtdEnv = $this->movimentacaocontroller->getMovimentacoesSetor($data['dtinicio'], $data['dtfim'], $nmSetorOrigem, $nmSetorDestino);
                            $qtdRec = $this->movimentacaocontroller->getMovimentacoesSetor($data['dtinicio'], $data['dtfim'], $nmSetorDestino, $nmSetorOrigem);

                            if (!($qtdEnv == 0 && $qtdRec == 0)) { 

                                $arraySetores[] = [
                                    'nmSetorOrigem' => $nmSetorOrigem,
                                    'nmSetorDestino' => $nmSetorDestino,
                                    'qtdEnv' => $qtdEnv,
                                    'qtdRec' => $qtdRec,
                                ];
                                

                            //foreach ($array as $setor) {
                                //if (!(($setor[0] == $nmSetorOrigem && $setor[1] == $nmSetorDestino) || ($setor[0] == $nmSetorDestino && $setor[1] == $nmSetorOrigem))) {
                                if (!(in_array(array($nmSetorOrigem, $nmSetorDestino), $array) || in_array(array($nmSetorDestino, $nmSetorOrigem), $array))) {

                                    $qtdTotal += ($qtdEnv + $qtdRec);

                                    $array[] = array($nmSetorOrigem, $nmSetorDestino);           
                                    
                                    //die(var_dump($array));

                                }
                            //}

                            //$qtdEnv = $qtdRec = 0;
                            }

                        }

                    }
                }

                //die(var_dump($array));

                return view('ListaEspera/listar_movimentacoes_setor', ['dtinicio' => $data['dtinicio'],
                                                                       'dtfim' => $data['dtfim'],
                                                                       'arraySetores' => $arraySetores,
                                                                       'qtdTotal' => $qtdTotal]);
            }
            
        } else {

            return view('ListaEspera/consultar_movimentacoes_setor', ['validation' => $this->validator]);
        }

    }
    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function consultarMovimentacoes()
    {
        helper('form');

        return view('ListaEspera/consultar_historico');

    }
    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function consultarListaEsperaRetidos()
    {
        helper('form');

        return view('ListaEspera/consultar_ListaEspera_retidos', ['selectSetorDestino' => $this->setorcontroller->select]);

    }
    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function listarListaEsperaRetidos()
    {        
        helper(['form', 'url']);

        HUAP_Functions::limpa_msgs_flash();

        $data = $this->request->getVar();

        //$arraySetores[] = [];

        if (!empty($data['setorDestino'])) {
            foreach ($data['setorDestino'] as $key => $setorDestino) {
                if (!is_array($setorDestino)) {
                    [$idSetoDestino, $nmSetorDestino, $idSetorOrigDestino] = explode('#', $setorDestino);
                } else {
                    $nmSetorDestino = $setorDestino['nmSetor'];
                }
            
                $arraySetores[] = $nmSetorDestino;
            }
        }

        $clausula_where_same = 'TRUE';
        $clausula_where_ssgh = 'TRUE';

        //var_dump($arraySetores);die();

        //if (!is_null($arraySetores[0])) {
        if (isset($arraySetores)) {

            $quotedArray = array_map(function($value) {
                return "'" . $value . "'";
            }, $arraySetores);
            $array = implode(", ",  $quotedArray);
            $setores = "($array)";

            $clausula_where_same .= " AND  (nmSetorDestino IS NOT NULL AND nmSetorDestino in $setores) ";
            $clausula_where_ssgh .= " AND  (setordestino IS NOT NULL AND setordestino in $setores ) ";
        }

        $db = \Config\Database::connect('default');

        $sql = "WITH movimentacoes_combined AS (
                    SELECT
                        numProntuarioAGHU AS numProntuario,
                        IFNULL(numVolume, 1) as numVolume,
                        nmSetorOrigem,
                        nmSetorDestino,
                        IFNULL(dtMovimentacao, NOW()) as dtMovimentacao,
                        dtPrazoRetorno,
                        dtRecebimento,
                        'SAME' as movOrigem
                    FROM movimentacoes mov_same
                    inner join ListaEspera pro_same on pro_same.id = mov_same.idProntuario
                    WHERE 
                        ((dtPrazoRetorno IS NOT NULL and date_format(dtPrazoRetorno, '%Y-%m-%d') < curdate()) 
                        OR (dtPrazoRetorno IS NULL AND date_add(date_format(dtMovimentacao , '%Y-%m-%d'), INTERVAL 3 DAY) < curdate())
                        OR (nmSetorDestino IS NULL))
                        AND (".$clausula_where_same." OR nmSetorDestino IS NULL)
                        
                    UNION ALL

                    SELECT
                        doc_listaespera AS numProntuario,
                        IFNULL(doc_seq, 1) as numVolume,
                        setororigem AS nmSetorOrigem,
                        setordestino AS nmSetorDestino,
                        IFNULL(tra_dt_env, NOW()) as dtMovimentacao,
                        NULL AS dtPrazoRetorno,
                        tra_dt_rec as dtRecebimento,
                        'SSGH' as movOrigem
                    FROM movimentacoes_ssgh mov_ssgh
                    WHERE 
                        ((date_add(date_format(tra_dt_env, '%Y-%m-%d'), INTERVAL 3 DAY) < curdate())
                        OR (setordestino IS NULL)) 
                        AND (".$clausula_where_ssgh." OR setordestino IS NULL)
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
                        movOrigem,
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
                    movOrigem,
                    rn
                FROM ranked_movimentacoes
                WHERE rn = 1 AND nmSetorDestino IS NOT NULL AND dtRecebimento IS NULL
                ORDER BY numProntuario, rn;
            ";

        //var_dump($sql);die();

        $query = $db->query($sql);

        $result = $query->getResult();

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

            array_push($ListaEspera, [
                'listaespera' => $listaespera->numProntuario,
                'volume' => $numVolume,
                'setororigem' => $listaespera->nmSetorOrigem,
                'setordestino' => $listaespera->nmSetorDestino,
                'dtmovimentacao' => $listaespera->dtMovimentacao,
                'dtprazoretorno' => $listaespera->dtPrazoRetorno,
                'movOrigem' => $listaespera->movOrigem
            ]);

            array_multisort(array_column($ListaEspera, 'setordestino'), SORT_ASC,array_column($ListaEspera, 'listaespera'), SORT_ASC, array_column($ListaEspera, 'volume'), SORT_ASC, $ListaEspera);

        }

        session()->setFlashdata('mensagem_flash', null);

        if (empty($ListaEspera)) {
            session()->setFlashdata('warning_message', 'Não existem Prontuários Retidos!');
        } 

        $_SESSION['ListaEspera'] = $ListaEspera;
        $_SESSION['qtdTotal'] = count($result);

        return view('ListaEspera/listar_ListaEspera_retidos', ['ListaEspera' => $ListaEspera,
                                                               'qtdTotal' => count($result)
                                                              ]);
    
    }
     /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function imprimirListaEsperaRetidos()
    {
        //die(var_dump($_SESSION['ListaEspera']));
      
        return view('ListaEspera/listar_ListaEspera_retidos_print', ['ListaEspera' => $_SESSION['ListaEspera'],
                                                                     'qtdTotal' => $_SESSION['qtdTotal']]);
    }
    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function consultarHistorico()
    {        
        helper(['form', 'url']);

        HUAP_Functions::limpa_msgs_flash();

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
            'listaespera' => 'required|min_length[1]|max_length[8]|numeric|equals['.$listaespera.']',
            'volume' => 'max_length[2]|equals['.$volume.']'
        ];

        if ($this->validate($rules)) {
            
            $this->validator->reset();

            $busca_hist_ant = ['MV', 'SSGH'];
            $historico = $this->getHistorico($data['listaespera'], $data['volume'], $busca_hist_ant);
            $local = $this->getUltimaLocalizacao($listaespera, $data['volume'], $busca_hist_ant);

            if (!empty($local) && $local[0]['mov_origem'] == 'mv') { //movimentações legadas incompletas não pode ser recebidas
                $local = null;
            }
            //var_dump($historico);die();

            $json = json_encode(['listaespera' => $listaespera,
                                'volume' => $data['volume'],
                                'nome' => $resultAGHUX[0]->nome,
                                'dt_nascimento' => $resultAGHUX[0]->dt_nascimento,
                                ]);

            $obj_pront = json_decode($json, false);

            //die(var_dump('ok'));
            //return view('ListaEspera/listar_historico',
            return view('layouts/sub_content', ['view' => 'ListaEspera/list_historico',
                                                'paciente' => $obj_pront,
                                                'historico' => $historico,
                                            /*  'permiteEnviar' => !empty($local) ? !$local[0]['tramite'] : (HUAP_Functions::tem_perfil_same() ? TRUE : FALSE),
                                                'permiteReceber' => !empty($local) ? $local[0]['tramite'] : FALSE, */
                                                'permiteEnviar' => !empty($local) ? !$local[0]['tramite'] && HUAP_Functions::permite_tramitar($local[0]['setortramite'] ?? $local[0]['setor']) : HUAP_Functions::permite_tramitar('ARQUIVO MÉDICO'),
                                                'permiteReceber' => !empty($local) ? $local[0]['tramite'] && HUAP_Functions::permite_tramitar($local[0]['setortramite'] ?? $local[0]['setor']): FALSE,
                                                'autocomplete' => 'off']);

        } else {
            //session()->setFlashdata('error', $this->validator);
            if(isset($resultAGHUX) && empty($resultAGHUX)) {
                $this->validator->setError('listaespera', 'Esse prontuário não existe na base do AGHUX!');
            }

            if($volume === '100') {
                $this->validator->setError('volume', 'Volume sem correspondência!');
            }

            return view('ListaEspera/consultar_historico', ['validation' => $this->validator]);
        }

    }
    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function listarHistorico(int $listaespera, int $volume = null)
    {        
        helper(['form', 'url', 'session']);

        //HUAP_Functions::limpa_msgs_flash();

        $busca_hist_ant = ['MV', 'SSGH'];
        
        $result = $this->aghucontroller->getPaciente($listaespera);
        $historico = $this->getHistorico($listaespera, $volume, $busca_hist_ant);
        $local = $this->getUltimaLocalizacao($listaespera, $volume, $busca_hist_ant);
        //var_dump($historico);die;
        if (!empty($local) && $local[0]['mov_origem'] != 'same') { //movimentações legadas incompletas não podem ser recebidas
            $local = null;
        }

/*         $this->response->noCache();
 */
        $this->response->setHeader('Cache-Control', 'no-cache, private');
        $this->response->setHeader('Connection', 'Keep-Alive');
    
        //var_dump($local);die();

        $json = json_encode(['listaespera' => $listaespera,
                            'volume' => $volume,
                            'nome' => $result[0]->nome,
                            'dt_nascimento' => $result[0]->dt_nascimento,
                            ]);

        $obj_pront = json_decode($json, false);

        //return view('ListaEspera/listar_historico',
        return view('layouts/sub_content', ['view' => 'ListaEspera/list_historico',
                                            'paciente' => $obj_pront,
                                            'historico' => $historico,
                                            'permiteEnviar' => !empty($local) ? !$local[0]['tramite'] && HUAP_Functions::permite_tramitar($local[0]['setortramite'] ?? $local[0]['setor']) : HUAP_Functions::permite_tramitar('ARQUIVO MÉDICO'),
                                            'permiteReceber' => !empty($local) ? $local[0]['tramite'] && HUAP_Functions::permite_tramitar($local[0]['setortramite'] ?? $local[0]['setor']): FALSE,
                                            'autocomplete' => 'off']);
    }
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function getHistorico($listaespera, $volume = null, $busca_hist_ant = [])
    {
        helper(['form', 'url']);

        $db = \Config\Database::connect('default');

        $movimentacoes = array();

        /***** SAME ******************************/

        $sql = "SELECT 
                    mov.id ,
                    mov.idProntuario ,
                    mov.nmProfissional,
                    mov.txtObs ,
                    pro.numProntuarioAGHU ,
                    pro.numVolume ,
                    mov.dtMovimentacao,
                    mov.dtRecebimento,
                    mov.dtPrazoRetorno,
                    usu_env.nmUsuario as Transportador ,
                    usu_rec.nmUsuario as Recebedor ,
                    usu_res.nmUsuario as Resgatador ,
                    mov.nmSetorOrigem as SetorOrigem,
                    mov.nmSetorDestino as SetorDestino
                FROM ListaEspera pro
                INNER JOIN movimentacoes mov ON pro.id = mov.idProntuario
                LEFT JOIN usuarios usu_env ON usu_env.id = mov.idRemetente 
                LEFT JOIN usuarios usu_rec ON usu_rec.id = mov.idRecebedor 
                LEFT JOIN usuarios usu_res ON usu_res.id = mov.idResgatador 
                WHERE pro.numProntuarioAGHU = $listaespera
                AND mov.deleted_at is null";

                if (!is_null($volume) && $volume != "") {
                    $sql .= " AND pro.numVolume = $volume;";
                } else {
                    $sql .= " AND pro.numVolume IS NULL;";
                }

                //var_dump($sql);die();

        $query = $db->query($sql);

        $result_same = $query->getResult();

        foreach ($result_same as $movimentacao) {

            array_push($movimentacoes, [
                'mov_origem' => 'same',
                'id' => $movimentacao->id,
                'protocolo' => '',
                'listaespera' => $movimentacao->idProntuario,
                'volume' => $movimentacao->numVolume,
                'saida' => $movimentacao->dtMovimentacao,
                'saida_sort' => $movimentacao->dtMovimentacao ?? date('Y-m-d'),
                'prevretorno' => $movimentacao->dtPrazoRetorno,
                'dtRecebimento' => $movimentacao->dtRecebimento,
                'motivo' => '',
                'profissional' => $movimentacao->nmProfissional,
                'agenda' => '',
                /* 'idOrigem' => $movimentacao->idSetorOrigem, */
                'origem' => $movimentacao->SetorOrigem,
                /* 'idDestino' => $movimentacao->idSetorDestino, */
                'destino' => $movimentacao->SetorDestino,
                'portadorOrigem' => $movimentacao->Transportador,
                'portadorDestino' => '',
                'resgatador' => $movimentacao->Resgatador,
                'solicitante' => '',
                'recebedor' => $movimentacao->Recebedor,
                'recebedoroLogin' => '',
                'obs' => $movimentacao->txtObs,
            ]);

        }

        /***** MV ******************************/

        if (in_array('MV', $busca_hist_ant)) {

            $pac_same = $this->getProntuario($listaespera, $volume)[0] ?? NULL;

            if ($pac_same) {
                $cd_paciente = $pac_same->numProntuarioMV;
            } else {
                $cd_paciente = null;
            }

            if (is_null($cd_paciente)) {
                $cd_paciente = $this->pacientesmvcontroller->getProntuarioMV($listaespera);
            }

            if (!is_null($cd_paciente)) {
                $sql = "SELECT * FROM movimentacoes_mv mv WHERE listaespera = $cd_paciente";
                if (!is_null($volume) && $volume != "") {
                    $sql .= " AND mv.volume = $volume;";
                } else {
                    $sql .= " AND mv.volume = 1;";
                }

                $query = $db->query($sql);

                $result_mv = $query->getResult();

                foreach ($result_mv as $row) {

                    array_push($movimentacoes, [
                        'mov_origem' => 'mv',
                        'id' => $row->id,
                        'protocolo' => $row->protocolo,
                        'listaespera' => $listaespera,
                        'volume' => $row->volume,
                        'saida' => $row->saida,
                        'saida_sort' => $row->saida ?? date('Y-m-d'),
                        'prevretorno' => $row->prevRetorno,
                        'dtRecebimento' => $row->recebidoData,
                        'motivo' => '',
                        'profissional' => '',
                        'agenda' => '',
                        'origem' => $row->portadorOrigem,
                        'destino' => $row->portadorDestino,
                        'portadorOrigem' => '',
                        'portadorDestino' => '',
                        'resgatador' => '',
                        'solicitante' => '',
                        'recebedor' => $row->recebidoPor,
                        'recebedoroLogin' => $row->recebidoLogin,
                        'obs' => '',
                    ]);
                }
            }
        }

        /** SSGH *****************************************************/

        if (in_array('SSGH', $busca_hist_ant)) {

            $sql = "SELECT * FROM movimentacoes_ssgh mov WHERE doc_listaespera = $listaespera";

            if (!is_null($volume) && $volume != "") {
                if ($volume == 1) {
                    $sql .= " AND (mov.doc_seq IS NULL || mov.doc_seq = 1)"; // ListaEspera sem volume ficam agregados no listaespera de volume 1 (ou null) do same
                } else {
                    $sql .= " AND mov.doc_seq = $volume";
                }
            } else {
                $sql .= " AND mov.doc_seq IS NULL";
            }

            $query = $db->query($sql);

            $result_ssgh = $query->getResult();

            foreach ($result_ssgh as $row) {

                array_push($movimentacoes, [
                    'mov_origem' => 'ssgh',
                    'id' => $row->id,
                    'protocolo' => '',
                    'listaespera' => $row->doc_listaespera,
                    'volume' => $row->doc_seq,
                    'saida' => $row->tra_dt_env,
                    'saida_sort' => $row->tra_dt_env ?? date('Y-m-d'),
                    'prevretorno' => '',
                    'dtRecebimento' => $row->tra_dt_rec,
                    'motivo' => '',
                    'profissional' => $row->tra_profissional,
                    'agenda' => '',
                    'origem' => $row->setororigem,
                    'destino' => $row->setordestino,
                    'portadorOrigem' => $row->nmremetente,
                    'portadorDestino' => '',
                    'resgatador' => $row->nmresgatador,
                    'solicitante' => '',
                    'recebedor' => $row->nmrecebedor,
                    'recebedoroLogin' => '',
                    'obs' => $row->tra_obs,
                ]);
            }
        }

        array_multisort(
            array_column($movimentacoes, 'saida_sort'), SORT_DESC,
            array_column($movimentacoes, 'dtRecebimento'), SORT_DESC,
            $movimentacoes
        );

        //die(var_dump($movimentacoes));

        return $movimentacoes;

    }
/**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function getUltimaLocalizacao($listaespera, $volume, $busca_hist_ant = [])
    {
        $ultLoc = [];
        
        $historico = $this->getHistorico($listaespera, $volume, $busca_hist_ant);

        /*  if ($listaespera == 733240 && $volume == 4) {
            die(var_dump($historico));
        } */

        //var_dump($historico);die();

        if(!empty($historico)) {
            if (!empty($historico[0]['destino'])) {
                if (!empty($historico[0]['dtRecebimento'])) {
                    $setor_atual = $historico[0]['destino'];
                    $setor_tramite = null;
                } else {
                    $setor_atual = $historico[0]['origem'];
                    $setor_tramite = $historico[0]['destino'];
                }
            } else {
                $setor_atual = $historico[0]['origem'];
                //if (!empty($historico[0]['saida'])) {
                //    $setor_tramite = $historico[0]['destino'];
                //} else {
                    $setor_tramite = null;
                //}
            }

            $ultLoc[] = [
                'mov_origem' => $historico[0]['mov_origem'],
                'id' => $historico[0]['id'],
                'setor' => $setor_atual,
                'setortramite' => $setor_tramite,
                'dtenvio' => !empty($historico[0]['portadorOrigem']) ? $historico[0]['saida'] : null,
                'tramite' => !empty($historico[0]['portadorOrigem']) && empty($historico[0]['dtRecebimento']) ? true : false
            ];
        }
        
       /*  if ($listaespera == 860552 && $volume == 1) {
            die(var_dump($ultLoc));
        } */

        return $ultLoc;
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
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function consultarListaEspera(string $idlistaespera = null)
    {
        HUAP_Functions::limpa_msgs_flash();

        return view('layouts/sub_content', ['view' => 'listaespera/form_consulta_listaespera']);

    }
    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function exibir()
    {        
        helper(['form', 'url', 'session']);

        \Config\Services::session();

        $listaespera = null;
        $listaesperamv = null;

        $data = $this->request->getVar();

        if(!empty($data['listaespera']) && is_numeric($data['listaespera'])) {
            $resultAGHUX = $this->aghucontroller->getPaciente($data['listaespera']);

            if(!empty($resultAGHUX[0])) {
                $listaespera = $data['listaespera'];
            }
        }

        if(!empty($data['listaesperamv']) && is_numeric($data['listaesperamv'])) {
            //var_dump($data['listaesperamv']);die();
            $resultMV = $this->pacientesmvcontroller->getPacientePorCdPaciente((int)$data['listaesperamv']);

            if(!empty($resultMV[0])) {
                $listaesperamv = $data['listaesperamv'];
            }
        }

        $rules = [
            'listaespera' => 'permit_empty|min_length[1]|max_length[8]|equals['.$listaespera.']',
            'listaesperamv' => 'permit_empty|min_length[1]|max_length[7]|equals['.$listaesperamv.']',
            'nmpaciente' => 'permit_empty|max_length[100]|min_length[10]',
            'nmmae' => 'permit_empty|min_length[10]|max_length[100]'
        ];

        if ($this->validate($rules)) {
            if(empty($data['listaespera']) && empty($data['listaesperamv']) && empty($data['nmmae']) && empty($data['nmpaciente'])) {
                session()->setFlashdata('failed', 'Preencha pelo menos um campo do formulário!');
                //return view('ListaEspera/consultar_listaespera', ['validation' => $this->validator]);
                return view('layouts/sub_content', ['view' => 'ListaEspera/form_consulta_listaespera', 'validation' => $this->validator]);

            } 
            
            $this->validator->reset();

            $clausula_where = 'TRUE';
            if (!empty($data['listaespera'])) {
                $clausula_where .= " AND numProntuarioAGHU = $data[listaespera]";
            } else {
                if (!empty($data['listaesperamv'])) {
                    $clausula_where .= " AND numProntuarioMV = $data[listaesperamv]";
                }
            }

            if (!empty($data['listaespera']) || !empty($data['listaesperamv'])) {

                $db = \Config\Database::connect('default');

                $sql = "SELECT * FROM ListaEspera WHERE $clausula_where";

                $query = $db->query($sql);

                $result = $query->getResult();

                if (empty($result)) {

                    $ListaEsperaame = [];
                    $ListaEsperaame['numProntuarioAGHU'] = $listaespera ?? $this->pacientesmvcontroller->getProntuarioAGHU($data['listaesperamv']);
                    $ListaEsperaame['numProntuarioMV'] = $listaesperamv ?? $this->pacientesmvcontroller->getProntuarioMV($data['listaespera']);
                    if (!empty($ListaEsperaame['numProntuarioAGHU'])) { // existem ListaEspera no mv sem correspondência no aghu! Estes não serão considerados no sistema
                        $id_same = $this->vwlistaesperamodel->insert($ListaEsperaame);
                    } else {
                        session()->setFlashdata('failed', 'Esse prontuário do MV não tem correspondência no AGHU!');
                        //return view('ListaEspera/consultar_listaespera', ['validation' => $this->validator]);
                        return view('layouts/sub_content', ['view' => 'ListaEspera/form_consulta_listaespera', 'validation' => $this->validator]);
                    }

                    $listaespera = [];
                    $listaespera[0]['id'] = $id_same;
                    $listaespera[0]['numProntuarioAGHU'] = $ListaEsperaame['numProntuarioAGHU'];
                    $listaespera[0]['numProntuarioMV'] = $ListaEsperaame['numProntuarioMV'];
                    $listaespera[0]['numVolume'] = 1;
                    $listaespera[0]['numArmario'] = null;
                    $listaespera[0]['numSala'] = null;
                    $listaespera[0]['numLinha'] = null;
                    $listaespera[0]['numColuna'] = null;
                    $listaespera[0]['txtObs'] = null;
                    $listaespera[0]['nmSetorAtual'] = null;

                    $resultAGHU = $this->aghucontroller->getPaciente($ListaEsperaame['numProntuarioAGHU']);
                    $listaespera[0]['nmPaciente'] = $resultAGHU[0]->nome;
                    $listaespera[0]['nmMae'] = $resultAGHU[0]->nome_mae;
                    $listaespera[0]['dtNascimento'] = $resultAGHU[0]->dt_nascimento;

                    $listaespera[0]['ultimoVolume'] = true;

                } else {

                    $listaespera = [];

                    //var_dump($result);die();

                    foreach ($result as $key => $ListaEsperaame) {
                        $listaespera[$key]['id'] = $ListaEsperaame->id;
                        $listaespera[$key]['numProntuarioAGHU'] = $ListaEsperaame->numProntuarioAGHU;
                        $listaespera[$key]['numProntuarioMV'] = $ListaEsperaame->numProntuarioMV;
                        $listaespera[$key]['numVolume'] = $ListaEsperaame->numVolume;
                        $listaespera[$key]['numArmario'] = $ListaEsperaame->numArmario;
                        $listaespera[$key]['numSala'] = $ListaEsperaame->numSala;
                        $listaespera[$key]['numLinha'] = $ListaEsperaame->numLinha;
                        $listaespera[$key]['numColuna'] = $ListaEsperaame->numColuna;
                        $listaespera[$key]['nmSetorAtual'] = $ListaEsperaame->nmSetorAtual;

                        $resultAGHU = $this->aghucontroller->getPaciente($ListaEsperaame->numProntuarioAGHU);
                        $listaespera[$key]['nmPaciente'] = $resultAGHU[0]->nome;
                        $listaespera[$key]['nmMae'] = $resultAGHU[0]->nome_mae;
                        $listaespera[$key]['dtNascimento'] = $resultAGHU[0]->dt_nascimento;

                        $listaespera[$key]['ultimoVolume'] = count($result) == ($ListaEsperaame->numVolume ?? 1);

                        if (!$listaespera[$key]['numVolume'] || $listaespera[$key]['numVolume'] == 1) {
                            if(isset($resultMV) && !empty($resultMV[0])) {
                                $listaespera[$key]['txtObs'] = ($resultMV[0]->DS_OBSERVACAO ? 'Obs. MV => '.$resultMV[0]->DS_OBSERVACAO.'<br>' : '').$ListaEsperaame->txtObs;
                            } else {
                                if ($ListaEsperaame->numProntuarioMV) {
                                    $resultMV = $this->pacientesmvcontroller->getPacientePorCdPaciente($ListaEsperaame->numProntuarioMV);
                                    $listaespera[$key]['txtObs'] = ($resultMV[0]->DS_OBSERVACAO ? 'Obs. MV => '.$resultMV[0]->DS_OBSERVACAO.'<br>' : '').$ListaEsperaame->txtObs;
                                } else {
                                    $listaespera[$key]['txtObs'] = $ListaEsperaame->txtObs;
                                }
                            }
                        } else {
                            $listaespera[$key]['txtObs'] = $ListaEsperaame->txtObs;
                        }
                    }
                }

                //var_dump($listaespera);die();

                $result = $listaespera;

            } else {

                if (!empty($data['nmpaciente'])) {
                    $result = $this->aghucontroller->getPacientePorNome('%'.$data['nmpaciente'].'%');
                } else {
                    if (!empty($data['nmmae'])) {
                        $result = $this->aghucontroller->getPacientePorNomeMae('%'.$data['nmmae'].'%');
                    }
                }

                if (!empty($result)) {

                    $listaespera = [];

                    foreach ($result as $key => $listaesperaaghu) {

                        $resultSAME = $this->getProntuario($listaesperaaghu->listaespera);

                        if (empty($resultSAME)) {

                            $ListaEsperaame = [];
                            $ListaEsperaame['numProntuarioAGHU'] = $listaesperaaghu->listaespera;
                            $ListaEsperaame['numProntuarioMV'] = $this->pacientesmvcontroller->getProntuarioMV($listaesperaaghu->listaespera, $listaesperaaghu->codigo);
                           
                            $id_same = $this->vwlistaesperamodel->insert($ListaEsperaame);

                            $listaespera[$key]['id'] = $id_same;
                            $listaespera[$key]['numProntuarioAGHU'] = $ListaEsperaame['numProntuarioAGHU'];
                            $listaespera[$key]['numProntuarioMV'] = $ListaEsperaame['numProntuarioMV'];
                            $listaespera[$key]['numVolume'] = null;
                            $listaespera[$key]['numArmario'] = null;
                            $listaespera[$key]['numSala'] = null;
                            $listaespera[$key]['numLinha'] = null;
                            $listaespera[$key]['numColuna'] = null;
                            $listaespera[$key]['txtObs'] = null;
                            $listaespera[$key]['nmSetorAtual'] = null;
                            $listaespera[$key]['nmPaciente'] = $listaesperaaghu->nome;
                            $listaespera[$key]['nmMae'] = $listaesperaaghu->nome_mae;
                            $listaespera[$key]['dtNascimento'] = $listaesperaaghu->dt_nascimento;
                            $listaespera[$key]['ultimoVolume'] = true;

                        } else {

                            $listaespera[$key]['id'] = $resultSAME[0]->id;
                            $listaespera[$key]['numProntuarioAGHU'] = $resultSAME[0]->numProntuarioAGHU;
                            $listaespera[$key]['numProntuarioMV'] = $resultSAME[0]->numProntuarioMV;
                            $listaespera[$key]['numVolume'] = $resultSAME[0]->numVolume;
                            $listaespera[$key]['numArmario'] = $resultSAME[0]->numArmario;
                            $listaespera[$key]['numSala'] = $resultSAME[0]->numSala;
                            $listaespera[$key]['numLinha'] = $resultSAME[0]->numLinha;
                            $listaespera[$key]['numColuna'] = $resultSAME[0]->numColuna;
                            $listaespera[$key]['txtObs'] = $resultSAME[0]->txtObs;
                            $listaespera[$key]['nmSetorAtual'] = $resultSAME[0]->nmSetorAtual;
                            $listaespera[$key]['nmPaciente'] = $listaesperaaghu->nome;
                            $listaespera[$key]['nmMae'] = $listaesperaaghu->nome_mae;
                            $listaespera[$key]['dtNascimento'] = $listaesperaaghu->dt_nascimento;
                            $listaespera[$key]['ultimoVolume'] = count($resultSAME) == ($resultSAME[0]->numVolume ?? 1);
                        }
                    }

                    $result = $listaespera;

                    //var_dump($result);die();

                }

            }

            if (empty($result)) {
                
                session()->setFlashdata('failed', 'Nenhum Prontuário localizado com os parâmetros informados!');
                //return view('ListaEspera/consultar_listaespera', ['validation' => $this->validator]);
                return view('layouts/sub_content', ['view' => 'ListaEspera/form_consulta_listaespera', 'validation' => $this->validator]);

            }

            HUAP_Functions::limpa_msgs_flash();
            //return view('ListaEspera/listar_ListaEspera', ['ListaEspera' => $result]);
            return view('layouts/sub_content', ['view' => 'listaspera/list_listalspera',
                                               'ListaEspera' => $result]);


        } else {
            //session()->setFlashdata('error', $this->validator);
            if(isset($resultAGHUX) && empty($resultAGHUX)) {
                $this->validator->setError('listaespera', 'Esse prontuário não existe na base do AGHUX!');
            }
            //var_dump(isset($resultMV));die();
            if(!empty($data['listaesperamv']) && is_null($resultMV)) {
                $this->validator->setError('listaesperamv', 'Esse prontuário não existe na base do MV!');
            }
            
            //return view('ListaEspera/consultar_listaespera', ['validation' => $this->validator]);
            return view('layouts/sub_content', ['view' => 'listaespera/list_listaespera', 'validation' => $this->validator]);

        }
    }
    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function editar_listaespera($id = null)
    {
       
        $ListaEsperaAME = $this->vwlistaesperamodel->getWhere(['id' => $id])->getResult();

        if($ListaEsperaAME){

            $listaesperaAGHU = $this->aghucontroller->getPaciente($ListaEsperaAME[0]->numProntuarioAGHU);

            return view('ListaEspera/editar_listaespera',[
            'id' => $id,
            'numProntuarioAGHU' => $ListaEsperaAME[0]->numProntuarioAGHU,
            'numProntuarioMV' => $ListaEsperaAME[0]->numProntuarioMV,
            'numVolume' => $ListaEsperaAME[0]->numVolume,
            'nmPaciente' => $listaesperaAGHU[0]->nome,
            'nmMae' => $listaesperaAGHU[0]->nome_mae,
            'dtNascimento' => $listaesperaAGHU[0]->dt_nascimento,
            'numArmario' => $ListaEsperaAME[0]->numArmario,
            'numLinha' => $ListaEsperaAME[0]->numLinha,
            'numSala' => $ListaEsperaAME[0]->numSala,
            'numColuna' => $ListaEsperaAME[0]->numColuna,
            'txtObs' => $ListaEsperaAME[0]->txtObs,
            'nmSetorAtual' => $ListaEsperaAME[0]->nmSetorAtual
            ]);
        }
        
        return redirect()->to('ListaEspera/listar');

    }
    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function editar($id = null)
    {
        \Config\Services::session();

        helper(['form', 'url', 'session']);

        $data = $this->request->getVar();

        //var_dump($data);die();

        $rules = [
            'numSala' => 'max_length[2]|min_length[0]',
            'numArmario' => 'max_length[2]|min_length[0]',
            'numLinha' => 'max_length[2]|min_length[0]',
            'numColuna' => 'max_length[2]|min_length[0]',
            'txtObs' => 'max_length[250]|min_length[0]',
        ];

        if ($this->validate($rules)) {

            try {
                    $array['numSala'] = !empty($data['numSala']) ? $data['numSala'] : null ;
                    $array['numArmario'] = !empty($data['numArmario']) ? $data['numArmario'] : null ;
                    $array['numVolume'] = !empty($data['numVolume']) ? $data['numVolume'] : null ;
                    $array['numLinha'] = !empty($data['numLinha']) ? $data['numLinha'] : null ;
                    $array['numColuna'] = !empty($data['numColuna']) ? $data['numColuna'] : null ;
                    $array['txtObs'] = $data['txtObs'];

                    $this->vwlistaesperamodel->update($id, $array);
                        
                    if ($this->vwlistaesperamodel->affectedRows() > 0) {

                        session()->setFlashdata('success', 'Operação concluída com sucesso!');
                        
                    } else {

                        session()->setFlashdata('nochange', 'Sem dados para atualizar!');

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

            $result = $this->getListaEspera($data['numProntuarioAGHU']);

            $listaespera = [];

            if ($result[0]->numProntuarioMV) { 
                $resultMV = $this->pacientesmvcontroller->getPacientePorCdPaciente($data['numProntuarioMV']);
            }
           
            foreach ($result as $key => $ListaEsperaame) {
                $listaespera[$key]['id'] = $ListaEsperaame->id;
                $listaespera[$key]['numProntuarioAGHU'] = $ListaEsperaame->numProntuarioAGHU;
                $listaespera[$key]['numProntuarioMV'] = $ListaEsperaame->numProntuarioMV;
                $listaespera[$key]['numVolume'] = $ListaEsperaame->numVolume;
                $listaespera[$key]['numArmario'] = $ListaEsperaame->numArmario;
                $listaespera[$key]['numSala'] = $ListaEsperaame->numSala;
                $listaespera[$key]['numLinha'] = $ListaEsperaame->numLinha;
                $listaespera[$key]['numColuna'] = $ListaEsperaame->numColuna;
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

            //return view('ListaEspera/listar_ListaEspera', ['ListaEspera' => $listaespera]);
            return view('layouts/sub_content', ['view' => 'ListaEspera/list_ListaEspera', 'ListaEspera' => $listaespera]);

        } else {
            session()->setFlashdata('error', $this->validator);

            //var_dump($data); die();
            return view('ListaEspera/editar_listaespera', ['validation' => $this->validator, 
            'id' => $data['id'],
            'numProntuarioAGHU' => $data['numProntuarioAGHU'],
            'numProntuarioMV' => $data['numProntuarioMV'],
            'numVolume' => $data['numVolume'],
            'numArmario' => $data['numArmario'],
            'numLinha' => $data['numLinha'],
            'numSala' => $data['numSala'],
            'numColuna' => $data['numColuna'],
            'txtObs' => $data['txtObs']
            ]);
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
    public function excluir_volume(int $id)
    {
        $mov = $this->movimentacaocontroller->getMovimentacoes($id);

        $ListaEsperaAME = $this->vwlistaesperamodel->getWhere(['id' => $id])->getResult();

        if (!$ListaEsperaAME) {
            //return redirect()->back();
            return redirect()->to(base_url('ListaEspera/consultar')); //para resolver problema no refresh
        }

        if (!empty($mov)) {
            session()->setFlashdata('failed', 'Não é possível excluir um volume que já tenha sido tramitado!');
        } else {
            $db = \Config\Database::connect('default');

            $db->transStart();

            try {
                $where = ['id' => $id];
                $this->vwlistaesperamodel->delete($where);
        
                $result = $this->getListaEspera($ListaEsperaAME[0]->numProntuarioAGHU);
        
                if (count($result) === 1) {
                    $this->vwlistaesperamodel->update($result[0]->id, ['numVolume' => NULL]);
                }
        
                $db->transComplete(); // Completa a transação
        
                if ($db->transStatus() === false) {
                    throw new \CodeIgniter\Database\Exceptions\DatabaseException('Erro ao completar a transação.');
                }
        
                // Operações concluídas com sucesso, redireciona ou exibe mensagem de sucesso
        
            } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
                $db->transRollback(); // Reverte a transação em caso de erro
                $msg = 'Erro na exclusão do volume';
                $msg .= ' - '.$e->getMessage();
                log_message('error', $msg.': ' . $e->getMessage());
                session()->setFlashdata('failed', $msg);
        
                // Redireciona ou exibe mensagem de erro
            }
        };

        //var_dump($ListaEsperaAME);die();

        $result = $this->getListaEspera($ListaEsperaAME[0]->numProntuarioAGHU);

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
        }

        //var_dump($listaespera);die();

        //return view('ListaEspera/listar_ListaEspera', ['ListaEspera' => $listaespera]);
        return view('layouts/sub_content', ['view' => 'ListaEspera/list_ListaEspera', 'ListaEspera' => $listaespera]);
                       
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
    public function recuperarProntuario()
    {        
        \Config\Services::session();

        if ($_SESSION['Sessao']['idPerfil'] == 1) { // Super
            $setoresusu = " LIKE '%' ";
        } else {
            $setorpermtramite = $this->setortramitemodel->getSetores($_SESSION['Sessao']['id']);
            $setores = array_column($setorpermtramite, 'nmSetor');
            //$setor = "(" . implode(', ', $setores) . ',' . $_SESSION['Sessao']['nmSetor'] . ') ';
            $setoresusu = " IN (";
            foreach ($setores as $setortramite) {
                $setoresusu .= "'".$setortramite."', ";
            }
            $setoresusu .= "'".$_SESSION['Sessao']['nmSetor']."') ";
        }

        $db = \Config\Database::connect('default');

        $sql = "SELECT 
                    mov.id as id_mov,
                    pro.numProntuarioAGHU as listaespera,
                    pro.numVolume as volume,
                    mov.nmSetorOrigem as SetorOrigem,
                    mov.nmSetorDestino as SetorDestino
                FROM 
                    movimentacoes mov
                INNER JOIN 
                    ListaEspera pro ON pro.id = mov.idProntuario
                LEFT JOIN 
                    usuarios usu_env ON usu_env.id = mov.idRemetente 
                WHERE 
                    mov.nmSetorOrigem $setoresusu
                    AND mov.dtMovimentacao IS NOT NULL
                    AND mov.dtRecebimento IS NULL
                    AND mov.deleted_at IS NULL;
                ";

        //var_dump(($sql));die;
        $query = $db->query($sql);

        $result_same = $query->getResult();

        $ListaEspera = [];

        foreach ($result_same as $movimentacao) {

            $result_aghu = $this->aghucontroller->getPaciente($movimentacao->listaespera);

            if(!empty($result_aghu[0])) {
                $paciente = $result_aghu[0]->nome;
            }

            array_push($ListaEspera, [
                'id_mov' => $movimentacao->id_mov,
                'numlistaespera' => $movimentacao->listaespera,
                'numvolume' => $movimentacao->volume,
                'paciente' => $paciente,
                'setororigem' => $movimentacao->SetorOrigem,
                'setordestino' => $movimentacao->SetorDestino,
            ]);

            array_multisort(array_column($ListaEspera, 'numlistaespera'), SORT_ASC, $ListaEspera);

        }

        session()->setFlashdata('mensagem_flash', null);

        if (empty($ListaEspera)) {
            session()->setFlashdata('warning_message', 'Não existem prontuários passíveis de recuperação!');
        } 

        return view('ListaEspera/listar_ListaEspera_arecuperar', ['ListaEspera' => $ListaEspera]);
        
    }
    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function listarListaEsperaNoSetor()
    {        
        \Config\Services::session();

        HUAP_Functions::limpa_msgs_flash();

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
                    pro.nmSetorAtual LIKE '$setor';
                ";

        $query = $db->query($sql);

        $result_same = $query->getResult();

        $ListaEspera = [];

        foreach ($result_same as $ListaEsperaame) {

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

            array_multisort(array_column($ListaEspera, 'listaesperaaghu'), SORT_ASC, $ListaEspera);

        }

        session()->setFlashdata('mensagem_flash', null);

        if (empty($ListaEspera)) {
            session()->setFlashdata('warning_message', 'Não existem Prontuários localizados no Setor!');
        } 

        return view('ListaEspera/listar_ListaEspera_localizados_setor', ['ListaEspera' => $ListaEspera,
                                                                         'setoruser' => $setor
                                                                        ]);
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
    public function exibirListaEspera()
    {        
        \Config\Services::session();

        $listaespera = $this->vwlistaesperamodel->findAll();

        //die(var_dump($result));

        if (empty($listaespera)) {
            session()->setFlashdata('warning_message', 'Lista de Espera sem Pacientes Ativos!');
        } 

        return view('layouts/sub_content', ['view' => 'listaespera/list_listaespera',
                                            'listaespera' => $listaespera,
                                            'qtd' => count($listaespera)]);
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