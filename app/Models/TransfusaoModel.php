<?php

namespace App\Models;

use CodeIgniter\Model;

class TransfusaoModel extends Model
{
    protected $table            = 'transfusoes';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true; 
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true; 
    protected $protectFields    = true;
    protected $allowedFields    = [
    'pac_codigo',
    'prontuario',
    'peso',
    'diagnostico',
    'indicacao',
    'idprocedimento',
    'sangramento_ativo',
    'transfusao_anterior',
    'reacao_anterior',
    'hematocrito',
    'hemoglobina',
    'tap',
    'ptt',
    'inr',
    'fibrinogenio',
    'hemacias',
    'plaquetas',
    'plasma',
    'crio',
    'outros',
    'procedimento_especial',
    'justificativa_proc_esp',
    'tipo_transfusao',
    'reserva_data',
    'coletor',
    'dthr_solicitacao',
    'medico_solicitante',
    'observacoes'
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
}
