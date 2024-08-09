<?php

namespace App\Models;

use CodeIgniter\Model;

class VwStatusFilaCirurgicaModel extends Model
{
    protected $table            = 'vw_statusfilacirurgica';
    protected $primaryKey       = 'idlistaespera';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = false;
    protected $allowedFields    = [
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

    public function getPacientesDaFila($filaId, $especialidadeId) {
        // Use aliases para as tabelas para garantir que não haverá ambiguidades
        $builder = $this->db->table('public.vw_statusfilacirurgica AS v');
        $builder->select('v.*, p.nome AS nome_paciente');
        $builder->join('remoto.aip_pacientes AS p', 'p.prontuario = v.prontuario', 'left');
        $builder->where('v.idfila', $filaId);
        $builder->where('v.idespecialidade', $especialidadeId);
        $query = $builder->get();
    
        return $query->getResultArray();
    }

}
