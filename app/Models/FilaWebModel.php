<?php

namespace App\Models;
use CodeIgniter\Model;

use App\Models\EquipamentosModel;
use App\Models\LocalAipContatosPacientesModel;

use Config\Database;
use DateTime;

class FilaWebModel extends Model
{

    private $equipamentosmodel;
    private $localaipcontatospacientesmodel;

    public function __construct()
{

    $this->localaipcontatospacientesmodel = new LocalAipContatosPacientesModel();

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

        $db = \Config\Database::connect('default');

        $builder = $db->table('local_vw_aghu_cirurgias');

        $builder->distinct()->select('
            local_vw_aghu_cirurgias.crg_seq,
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
            local_vw_aghu_cirurgias.tipo_cir

        ');
    
        //die(var_dump($data));

        if (!empty($data['dtinicio']) && !empty($data['dtfim'])) {
            $dtInicio = DateTime::createFromFormat('Y-m-d', $data['dtinicio'])->format('Y-m-d 00:00:00');
            $dtFim = DateTime::createFromFormat('Y-m-d', $data['dtfim'])->format('Y-m-d 23:59:59');

            $builder->where("local_vw_aghu_cirurgias.data_inicio_cirurgia >=", $dtInicio);
            $builder->where("local_vw_aghu_cirurgias.data_fim_cirurgia <=", $dtFim);
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

            //$paciente->cirurgias = $this->localvwaghucirurgiasmodel->where('prontuario', $paciente->prontuario)->findAll();

            //print_r($paciente->cirurgias);
        }

        //die(var_dump($cirurgias));

        return $cirurgias;

    }

}
