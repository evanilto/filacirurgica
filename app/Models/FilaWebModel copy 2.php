<?php

namespace App\Models;
use CodeIgniter\Model;

use App\Models\EquipamentosModel;
use App\Models\LocalAipContatosPacientesModel;
use App\Models\LocalVwAghuAntimicrobianosModel;
use App\Models\LocalVwAghuEvolAmbModel;
use App\Models\LocalVwAghuEvolIntModel;
use App\Models\LocalVwAghuGmrModel;
use App\Models\LocalVwExamesLiberadosModel;

use Config\Database;
use DateTime;

class FilaWebModel extends Model
{

    private $equipamentosmodel;
    private $localaipcontatospacientesmodel;
    private $localvwaghuantimicrobianos;
    private $localvwaghuevolamb;
    private $localvwaghuevolint;
    private $localvwaghugmr;
    private $localvwexamesliberados;


    public function __construct()
{

    $this->localaipcontatospacientesmodel = new LocalAipContatosPacientesModel();
    $this->localvwaghuantimicrobianos = new LocalVwAghuAntimicrobianosModel();
    $this->localvwaghuevolamb = new LocalVwAghuEvolAmbModel();
    $this->localvwaghuevolint = new LocalVwAghuEvolIntModel();
    $this->localvwaghugmr = new LocalVwAghuGmrModel();
    $this->localvwexamesliberados = new LocalVwExamesLiberadosModel();

}

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    private function listarMedicamentos($resultados) 
    {
        if (empty($resultados)) {
            return 'N/D';
        }

        $medicamentos = [];

        foreach ($resultados as $item) {
            $data = date('d/m/Y', strtotime($item->data_inicio));
            $nome = trim($item->descricao_medicamento);

            // Chave composta para garantir unicidade: data + nome
            $chave = "{$data} - {$nome}";

            $medicamentos[$chave] = true;  // O valor não importa, só a chave para garantir unicidade
        }

        ksort($medicamentos);

        // Retorna os itens separados por "; "
        return implode('; ', array_keys($medicamentos));
    }
/**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    private function listarGmr($resultados) 
    {
        if (empty($resultados)) {
            return 'N/D';
        }

        $gmrs = [];

        foreach ($resultados as $item) {
            $data = date('d/m/Y', strtotime($item->dt_identificacao));
            $nome = trim($item->descr_gmr);

            // Chave composta para garantir unicidade: data + nome
            $chave = "{$data} - {$nome}";

            $gmrs[$chave] = true;  // O valor não importa, só a chave para garantir unicidade
        }

        ksort($gmrs);

        // Retorna os itens separados por "; "
        return implode('; ', array_keys($gmrs));
    }
    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function getTipoSanguineoAtual($prontuario)
    {
        $db = Database::connect('default');
        $builder = $db->table('pacientes');

        return $builder
                ->where('prontuario', $prontuario)
                ->get()
                ->getRow(); // retorna um objeto
    }
   /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function getPacienteNoMapa ($data) 
    {
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

        return $builder->get()->getResult();
    }
    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    private function getQtdEquipamentoReservado ($dtcirurgia, $idequipamento) 
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
    public function atualizaLimiteExcedidoEquipamento ($dtcirurgia, $idequipamento, $excl = null) 
    {
        $qtdEmUso = $this->getQtdEquipamentoReservado($dtcirurgia, (int) $idequipamento);

        $this->equipamentosmodel = new EquipamentosModel();

        $eqpto = $this->equipamentosmodel->find((int) $idequipamento);

        if ($excl) { // equipamento está excluído da contagem (não é considerado)
            $eqpExcedente = ($qtdEmUso > $eqpto->qtd);
        } else {
            $eqpExcedente = ($qtdEmUso >= $eqpto->qtd);
        }

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
            RETURNING ec.id
        ";

        $query = $db->query($sql, [
            $eqpExcedente,
            (int) $idequipamento,
            DateTime::createFromFormat('d/m/Y', $dtcirurgia)->format('Y-m-d')
        ]);

        if (!$query) {
            die(var_dump($db->getLastQuery()));
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
    public function getCirurgiasPDT($data) 
    {
        // lista de palavras-chave a identificar
        $palavras = [
        'Febre',
        'Dor no local cirúrgico',
        'Calor no local da ferida',
        'Eritema',
        'hiperemia',
        'rubor',
        'Edema',
        'Secreção purulenta',
        'Secreção serossanguinolenta',
        'Secreção serosa',
        'Secreção',
        'Exsudato',
        'Flutuação',
        'endurecimento',
        'Deiscência de ferida',
        'Abertura de ponto',
        'soltura de ponto',
        'Mau cheiro',
        'odor fétido',
        'Necrose',
        'Sinais flogísticos',
        'Iniciado antibiótico',
        'Coletado cultura',
        'Solicitado hemocultura',
        'Solicitado cultura de secreção',
        'Solicitado ultrassom de partes moles',
        'Solicitado TC de ferida',
        'Solicitado TC de região cirúrgica',
        'Avaliado pela infectologia',
        'Avaliado pela CCIH',
        'Indicado drenagem',
        'Reabordagem cirúrgica',
        'Reinternação por complicação da ferida',
        'Hemocultura positiva',
        'Cultura de secreção positiva',
        'HMC',
        'hemocultura',
        'ATB',
        'antibiótico',
        'CCIH'
        ];

       function normalizarTexto($texto) {
            $texto = mb_strtolower((string)$texto, 'UTF-8');
            $texto = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $texto);
            $texto = preg_replace('/\s+/', ' ', $texto);
            return trim($texto);
        }

        function palavrasEncontradasEvolucao($texto, $palavras) {
            // recebe $texto como string (uma evolução) e $palavras como array
            $textoNormalizado = normalizarTexto($texto);
            $tokens = preg_split('/[^a-z0-9]+/i', $textoNormalizado, -1, PREG_SPLIT_NO_EMPTY);

            $encontradas = [];
            foreach ($palavras as $p) {
                $pNorm = normalizarTexto($p);

                if (strpos($pNorm, ' ') !== false) {
                    // expressão composta: busca exata no texto normalizado
                    if (strpos($textoNormalizado, $pNorm) !== false) {
                        $encontradas[] = $p;
                    }
                } else {
                    // palavra simples: compara token a token (igualdade exata)
                    if (in_array($pNorm, $tokens, true)) {
                        $encontradas[] = $p;
                    }
                }
            }

            return empty($encontradas) ? null : implode(', ', $encontradas);
        }

        function listarEvolucoes($resultados, $limitePalavras = 1000) {
            // aceita array ou Traversable; garante ordenação em PHP
            if (empty($resultados) || (!is_array($resultados) && !($resultados instanceof \Traversable))) {
                return 'N/D';
            }

            $items = $resultados instanceof \Traversable ? iterator_to_array($resultados) : $resultados;

            // ordena cronologicamente (mais antigo primeiro)
            usort($items, function($a, $b) {
                return strtotime($a->dthr_criacao) <=> strtotime($b->dthr_criacao);
            });

            $evolucoes = [];

            foreach ($items as $item) {
                $data = date('d/m/Y H:i:s', strtotime($item->dthr_criacao));
                $textoCompleto = trim($item->evolucao_descricao);

                // limita o texto às primeiras $limitePalavras palavras
                $palavrasTexto = preg_split('/\s+/', $textoCompleto);
                if (count($palavrasTexto) > $limitePalavras) {
                    $textoLimitado = implode(' ', array_slice($palavrasTexto, 0, $limitePalavras)) . ' ...';
                } else {
                    $textoLimitado = $textoCompleto;
                }

                $evolucoes[] = "**Evolução {$data} - {$textoLimitado}";
            }

            return implode("\n\n", $evolucoes);
        }

        function listarPalavrasEncontradas($resultados, $palavras) {
            if (empty($resultados) || (!is_array($resultados) && !($resultados instanceof \Traversable))) {
                return 'N/D';
            }

            $items = $resultados instanceof \Traversable ? iterator_to_array($resultados) : $resultados;

            // ordena cronologicamente (mais antigo primeiro)
            usort($items, function($a, $b) {
                return strtotime($a->dthr_criacao) <=> strtotime($b->dthr_criacao);
            });

            $saida = [];

            foreach ($items as $item) {
                $data = date('d/m/Y H:i:s', strtotime($item->dthr_criacao));
                $texto = trim($item->evolucao_descricao);

                $encontradas = palavrasEncontradasEvolucao($texto, $palavras);

                $saida[] = "{$data} - " . ($encontradas ?? 'N/D');
            }

            return implode("\n", $saida);
        }

        function listarExames($result)
        {
   
            if (empty($result)) {
                return 'N/D';
            }

            // Ordena pelo campo de data/hora
            usort($result, function ($a, $b) {
                return strtotime($a->dthr_evento_extrato_item) <=> strtotime($b->dthr_evento_extrato_item);
            });

            $saida = '';
            foreach ($result as $row) {
                    $saida .= '[' . date('d/m/Y H:i', strtotime($row->dthr_evento_extrato_item)) . '] '
                        . $row->descricao_mat_analise . ' - '
                        . $row->descricao_usual . ': '
                        . $row->result_descr . "\n";
            }

            return $saida;
        }


        $db = \Config\Database::connect('default');

        $builder = $db->table('local_vw_aghu_cirurgias');

        $builder->distinct()->select('
            local_vw_aghu_cirurgias.crg_seq,
            local_vw_aghu_cirurgias.data_cirurgia,
            local_vw_aghu_cirurgias.dcrg_seqp,
            local_vw_aghu_cirurgias.codigo,
            local_vw_aghu_cirurgias.prontuario,
            local_vw_aghu_cirurgias.nome,
            local_vw_aghu_cirurgias.dt_nascimento,
            local_vw_aghu_cirurgias.eqp_cir,
            local_vw_aghu_cirurgias.eqp_pdt,
            local_vw_aghu_cirurgias.esp_seq,
            local_vw_aghu_cirurgias.nome_especialidade,
            local_vw_aghu_cirurgias.procedimento_cirurgia,
            local_vw_aghu_cirurgias.leito,
            local_vw_aghu_cirurgias.leito_atual,
            local_vw_aghu_cirurgias.dthr_internacao,
            local_vw_aghu_cirurgias.dthr_alta_medica,
            local_vw_aghu_cirurgias.aih_sintomas,
            local_vw_aghu_cirurgias.aih_condicoes,
            local_vw_aghu_cirurgias.indicacao_pdt,
            local_vw_aghu_cirurgias.data_inicio_cirurgia as dthr_inicio_cirurgia,
            local_vw_aghu_cirurgias.data_fim_cirurgia as dthr_fim_cirurgia,
            local_vw_aghu_cirurgias.contaminacao_cir as potencial_contaminacao_cir,
            local_vw_aghu_cirurgias.contaminacao_pdt as potencial_contaminacao_pdt,
            local_vw_aghu_cirurgias.situacao_descr_cir,
            local_vw_aghu_cirurgias.situacao_descr_pdt,
            local_vw_aghu_cirurgias.situacao_cir,
            local_vw_aghu_cirurgias.tipo_cir,
            local_vw_aghu_cirurgias.materiais_usados
        ');
    
        //die(var_dump($data));

        if (!empty($data['dtinicio']) && !empty($data['dtfim'])) {
            $dtInicio = DateTime::createFromFormat('Y-m-d', $data['dtinicio'])->format('Y-m-d 00:00:00');
            $dtFim = DateTime::createFromFormat('Y-m-d', $data['dtfim'])->format('Y-m-d 23:59:59');

            $builder->where("local_vw_aghu_cirurgias.data_cirurgia >=", $dtInicio);
            $builder->where("local_vw_aghu_cirurgias.data_cirurgia <=", $dtFim);
        }

        // Condicional para prontuario
        if (!empty($data['prontuario'])) {
            $builder->where('local_vw_aghu_cirurgias.prontuario', $data['prontuario']);
        }

        // Condicional para nome
        if (!empty($data['nome'])) {
            $builder->like('local_vw_aghu_cirurgias.nome', strtoupper($data['nome']));
        }

        // Condicional para especialidade
        /* if (!empty($data['especialidade'])) {
            $builder->where('local_vw_aghu_cirurgias.idespecialidade', $data['especialidade']);
        }

        // Condicional para fila
        if (!empty($data['fila'])) {
            $builder->where('local_vw_aghu_cirurgias.idfila', $data['fila']);
        } */

        //var_dump($builder->getCompiledSelect());die();
        //var_dump($builder->get()->getResult());die();

        $cirurgias = $builder->get()->getResult();

        foreach ($cirurgias as &$cirurgia) {

            $cirurgia->contatos = $this->localaipcontatospacientesmodel->where('pac_codigo', $cirurgia->codigo)->findAll();

            /************ Antimicrobianos *****************************************************/

            $baseDate = date('Y-m-d', strtotime($cirurgia->data_cirurgia));
            $inicio_cirurgia = $baseDate . ' 00:00:00';
            $fim_cirurgia = $baseDate . ' 23:59:59';

            // ==================================
            // 🔸 No dia da cirurgia
           /*  $result_dia = $this->localvwaghuantimicrobianos
                ->select('data_inicio, descricao_medicamento')
                ->where('pac_codigo', $cirurgia->codigo)
                ->where('data_inicio >=', $inicio_cirurgia)
                ->where('data_inicio <=', $fim_cirurgia)
                ->get()
                ->getResult();
            $cirurgia->antimicrobianos_dia = $this->listarMedicamentos($result_dia); */

            $query_dia = $this->localvwaghuantimicrobianos
                ->select('data_inicio, descricao_medicamento');
                if (!empty($cirurgia->atd_seq)) { // pega a cirurgia pelo atendimento, se disponível
                    $query_dia->where('atd_seq', $cirurgia->atd_seq);
                } else {
                    $query_dia->where('pac_codigo', $cirurgia->codigo);
                }
                $query_dia->where('data_inicio >=', $inicio_cirurgia)
                          ->where('data_inicio <=', $fim_cirurgia);
            $result_dia = $query_dia->get()->getResult();
            $cirurgia->antimicrobianos_dia = $this->listarMedicamentos($result_dia);

            // ==================================
            // 🔸 Até 24 horas após (excluindo o dia da cirurgia)
            $inicio_24h = date('Y-m-d H:i:s', strtotime($fim_cirurgia . ' +1 second'));
            $fim_24h = date('Y-m-d H:i:s', strtotime($fim_cirurgia . ' +1 day'));

            $result_24h = $this->localvwaghuantimicrobianos
                ->select('data_inicio, descricao_medicamento')
                ->where('pac_codigo', $cirurgia->codigo)
                ->where('data_inicio >=', $inicio_24h)
                ->where('data_inicio <=', $fim_24h)
                ->get()
                ->getResult();
            $cirurgia->antimicrobianos_24h = $this->listarMedicamentos($result_24h);

            // ==================================
            // 🔸 Até 48 horas após
            $inicio_48h = date('Y-m-d H:i:s', strtotime($fim_24h . ' +1 second'));
            $fim_48h = date('Y-m-d H:i:s', strtotime($fim_24h . ' +1 day'));

            $result_48h = $this->localvwaghuantimicrobianos
                ->select('data_inicio, descricao_medicamento')
                ->where('pac_codigo', $cirurgia->codigo)
                ->where('data_inicio >=', $inicio_48h)
                ->where('data_inicio <=', $fim_48h)
                ->get()
                ->getResult();
            $cirurgia->antimicrobianos_48h = $this->listarMedicamentos($result_48h);

            // ==================================
            // 🔸 De 48 horas até 30 dias após a cirurgia
            $inicio_30d = date('Y-m-d H:i:s', strtotime($fim_48h . ' +1 second'));
            $fim_30d = date('Y-m-d H:i:s', strtotime($baseDate . ' +30 day')); // ✅ Correção aqui

            $result_30d = $this->localvwaghuantimicrobianos
                ->select('data_inicio, descricao_medicamento')
                ->where('pac_codigo', $cirurgia->codigo)
                ->where('data_inicio >=', $inicio_30d)
                ->where('data_inicio <=', $fim_30d)
                ->get()
                ->getResult();
            $cirurgia->antimicrobianos_30d = $this->listarMedicamentos($result_30d);

            /************ Germes MultiResistentes ***************************************/

            $gmr = $this->localvwaghugmr
                ->select('dt_identificacao, descr_gmr')
                ->where('codigo', $cirurgia->codigo)
                //->where('data_inicio >=', $inicio_30d)
                //->where('data_inicio <=', $fim_30d)
                ->get()
                ->getResult();
            $cirurgia->gmr = $this->listarGmr($gmr);

            /************ Evoluções *****************************************************/

            // Ambulatorio ----------------

            // 🔸 Até 30 dias após a cirurgia
            $inicio_30d = date('Y-m-d H:i:s', strtotime($inicio_cirurgia . ' +1 second'));
            $fim_30d = date('Y-m-d H:i:s', strtotime($baseDate . ' +30 day')); // ✅ Correção aqui

            $result_30d = $this->localvwaghuevolamb
                ->select('dthr_criacao, evolucao_descricao')
                ->where('pac_codigo', $cirurgia->codigo)
                ->where('dthr_criacao >=', $inicio_30d)
                ->where('dthr_criacao <=', $fim_30d)
                ->get()
                ->getResult();
            $cirurgia->evolamb_30d = listarEvolucoes($result_30d);
            $cirurgia->palavras_encontradas_evolamb_30d = listarPalavrasEncontradas($result_30d, $palavras);

            // 🔸 De 30 até 60 dias após a cirurgia
            $inicio_90d = date('Y-m-d H:i:s', strtotime($fim_30d . ' +1 second'));
            $fim_90d = date('Y-m-d H:i:s', strtotime($baseDate . ' +90 day')); // ✅ Correção aqui

            $result_90d = $this->localvwaghuevolamb
                ->select('dthr_criacao, evolucao_descricao')
                ->where('pac_codigo', $cirurgia->codigo)
                ->where('dthr_criacao >=', $inicio_90d)
                ->where('dthr_criacao <=', $fim_90d)
                ->get()
                ->getResult();
            $cirurgia->evolamb_90d = listarEvolucoes($result_90d);
            $cirurgia->palavras_encontradas_evolamb_90d = listarPalavrasEncontradas($result_90d, $palavras);

            // Internacao -------------------

            // 🔸 Até 30 dias após a cirurgia
            /* $result_30d = $this->localvwaghuevolint
                ->select('dthr_criacao, evolucao_descricao')
                ->where('pac_codigo', $cirurgia->codigo)
                ->where('dthr_criacao >=', $inicio_30d)
                ->where('dthr_criacao <=', $fim_30d)
                ->get()
                ->getResult();
            $cirurgia->evolint_30d = listarEvolucoes($result_30d);
            $cirurgia->palavras_encontradas_evolint_30d = listarPalavrasEncontradas($result_30d, $palavras); */

            $query_30d = $this->localvwaghuevolint
                ->select('dthr_criacao, evolucao_descricao');
                if (!empty($cirurgia->atd_seq)) { // pega a cirurgia pelo atendimento, se disponível
                    $query_30d->where('atd_seq', $cirurgia->atd_seq);
                } else {
                    $query_30d->where('pac_codigo', $cirurgia->codigo);
                }
                $query_30d->where('dthr_criacao >=', $inicio_30d)
                          ->where('dthr_criacao <=', $fim_30d);
            $result_30d = $query_30d->get()->getResult();
            $cirurgia->evolint_30d = listarEvolucoes($result_30d);
            $cirurgia->palavras_encontradas_evolint_30d = listarPalavrasEncontradas($result_30d, $palavras);

            // 🔸 De 30 até 60 dias após a cirurgia
            
            $result_90d = $this->localvwaghuevolint
                ->select('dthr_criacao, evolucao_descricao')
                ->where('pac_codigo', $cirurgia->codigo)
                ->where('dthr_criacao >=', $inicio_90d)
                ->where('dthr_criacao <=', $fim_90d)
                ->get()
                ->getResult();
            $cirurgia->evolint_90d = listarEvolucoes($result_90d);           
            $cirurgia->palavras_encontradas_evolint_90d = listarPalavrasEncontradas($result_90d, $palavras);

            /************ Culturas *****************************************************/

            // 🔸 Até 30 dias após a cirurgia
            $inicio_30d = date('Y-m-d H:i:s', strtotime($inicio_cirurgia . ' +1 second'));
            $fim_30d = date('Y-m-d H:i:s', strtotime($baseDate . ' +30 day')); // ✅ Correção aqui

            /* $result_30d = $this->localvwexamesliberados
                ->select('dthr_evento_extrato_item, descricao_mat_analise, descricao_usual, result_descr')
                ->Where('unf_descricao', 'LABORATÓRIO DE MICROBIOLOGIA')
                ->where('pac_codigo', $cirurgia->codigo)
                ->where('dthr_evento_extrato_item >=', $inicio_30d)
                ->where('dthr_evento_extrato_item <=', $fim_30d)
                ->get()
                ->getResult();
            $cirurgia->cultura_30d = listarExames($result_30d); */

            $query_30d = $this->localvwexamesliberados
                ->select('dthr_evento_extrato_item, descricao_mat_analise, descricao_usual, result_descr');
                if (!empty($cirurgia->atd_seq)) { // pega a cirurgia pelo atendimento, se disponível
                    $query_30d->where('atd_seq', $cirurgia->atd_seq);
                } else {
                    $query_30d->where('pac_codigo', $cirurgia->codigo);
                }
                $query_30d->where('unf_descricao', 'LABORATÓRIO DE MICROBIOLOGIA')
                          ->where('dthr_evento_extrato_item >=', $inicio_30d)
                          ->where('dthr_evento_extrato_item <=', $fim_30d);
            $result_30d = $query_30d->get()->getResult();
            $cirurgia->cultura_30d = listarExames($result_30d);

            // 🔸 De 30 até 60 dias após a cirurgia
            $inicio_90d = date('Y-m-d H:i:s', strtotime($fim_30d . ' +1 second'));
            $fim_90d = date('Y-m-d H:i:s', strtotime($baseDate . ' +90 day')); // ✅ Correção aqui

            /* $result_90d = $this->localvwexamesliberados
                ->select('dthr_evento_extrato_item, descricao_mat_analise, descricao_usual, result_descr')
                ->Where('unf_descricao', 'LABORATÓRIO DE MICROBIOLOGIA')
                ->where('pac_codigo', $cirurgia->codigo)
                ->where('dthr_evento_extrato_item >=', $inicio_90d)
                ->where('dthr_evento_extrato_item <=', $fim_90d)
                ->get()
                ->getResult();
            $cirurgia->cultura_90d = listarExames($result_90d); */

            $query_90d = $this->localvwexamesliberados
                ->select('dthr_evento_extrato_item, descricao_mat_analise, descricao_usual, result_descr');
                if (!empty($cirurgia->atd_seq)) { // pega a cirurgia pelo atendimento, se disponível
                    $query_90d->where('atd_seq', $cirurgia->atd_seq);
                } else {
                    $query_90d->where('pac_codigo', $cirurgia->codigo);
                }
                $query_90d->where('unf_descricao', 'LABORATÓRIO DE MICROBIOLOGIA')
                          ->where('dthr_evento_extrato_item >=', $inicio_90d)
                          ->where('dthr_evento_extrato_item <=', $fim_90d);
            $result_90d = $query_90d->get()->getResult();
            $cirurgia->cultura_90d = listarExames($result_90d);

            //$paciente->cirurgias = $this->localvwaghucirurgiasmodel->where('prontuario', $paciente->prontuario)->findAll();

            //print_r($paciente->cirurgias);
        }
            //dd($cirurgias);

        return $cirurgias;

    }

}
