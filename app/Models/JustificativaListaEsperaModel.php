<?php

namespace App\Models;

use CodeIgniter\Model;

use DateTime;

class JustificativaListaEsperaModel extends Model
{
    protected $table            = 'justificativa_listaespera';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'idlistaespera',
        'idmapacirurgico',
        'idjustificativa',
        'txtjustificativa',
        'dthr_evento',
        'deleted_at',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function getJustificativas($data) 
    {
        // Conexão com o banco de dados
        $db = \Config\Database::connect('default');

        $builder = $db->table('vw_historico_justificativas');

        $builder->join('lista_espera', 'lista_espera.id = vw_historico_justificativas.idlistaespera', 'inner');
        $builder->join('local_aip_pacientes', 'local_aip_pacientes.prontuario = lista_espera.numprontuario', 'left');
        $builder->join('tipos_procedimentos', 'tipos_procedimentos.id = lista_espera.idtipoprocedimento', 'left');
        $builder->join('local_agh_especialidades', 'local_agh_especialidades.seq = lista_espera.idespecialidade', 'left');
        $builder->join('local_fat_itens_proced_hospitalar', 'local_fat_itens_proced_hospitalar.cod_tabela = lista_espera.idprocedimento', 'left');

        //$builder->join('vw_ordem_paciente', 'vw_ordem_paciente.id = vw_mapacirurgico.idlista', 'left');

        $builder->select('
            vw_historico_justificativas.dthr_evento,
            vw_historico_justificativas.evento,
            vw_historico_justificativas.justificativa,
            vw_historico_justificativas.tipojustificativa,
            lista_espera.numprontuario as prontuario,
            local_aip_pacientes.nome as nome_paciente,
            local_agh_especialidades.nome_especialidade as especialidade_descricao,
            tipos_procedimentos.nmtipoprocedimento as fila,
            local_fat_itens_proced_hospitalar.descricao as procedimento_descricao
        ');
    
        
        //dd($data);

        if (!empty($data['dtinicio']) && !empty($data['dtfim'])) {
            $dtInicio = DateTime::createFromFormat('d/m/Y', $data['dtinicio'])->format('Y-m-d 00:00:00');
            $dtFim = DateTime::createFromFormat('d/m/Y', $data['dtfim'])->format('Y-m-d 23:59:59');

            $builder->where("vw_historico_justificativas.dthr_evento >=", $dtInicio);
            $builder->where("vw_historico_justificativas.dthr_evento <=", $dtFim);
        }

        // Condicional para idlista
        if (!empty($data['idlista'])) {
            $builder->where('vw_historico_justificativas.idlistaespera', $data['idlista']);
            if (!empty($data['idmapacirurgico'])) {
                $builder->where('vw_historico_justificativas.idmapacirurgico', $data['idmapacirurgico']);
            }
        } else {
            // Condicional para prontuario
            if (!empty($data['prontuario'])) {
                $builder->where('local_aip_pacientes.prontuario', $data['prontuario']);
            }

            // Condicional para nome
            if (!empty($data['nome'])) {
                $builder->like('local_aip_pacientes.nome', strtoupper($data['nome']));
            }

            // Condicional para especialidade
            if (!empty($data['especialidade'])) {
                $builder->where('lista_espera.idespecialidade', $data['especialidade']);
            }

            // Condicional para fila
            if (!empty($data['fila'])) {
                $builder->where('lista_espera.idtipoprocedimento', $data['fila']);
            }

           /*  if (!empty($data['tipojustificativa'])) {
                $builder->where('vw_historico_justificativas.tipojustificativa', $data['tipojustificativa']);
            } */
        }

        if (!empty($data['tipojustificativa'])) {
            $builder->whereIn(
                'vw_historico_justificativas.tipojustificativa',
                (array) $data['tipojustificativa']
            );
        }

        $builder->orderBy('vw_historico_justificativas.dthr_evento', 'ASC');
        $builder->orderBy('lista_espera.numprontuario', 'ASC');
        
        //var_dump($builder->getCompiledSelect());die();
        //var_dump($builder->get()->getResult());die();

        return $builder->get()->getResult();
    }
}
