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
    'recebedor',
    'data_recebimento',
    'hora_recebimento',
    'tipo1_aborh', 'tipo1_a', 'tipo1_b', 'tipo1_ab', 'tipo1_d', 'tipo1_c', 'tipo1_ra1', 'tipo1_rb',
    'responsavel_tipo1',
    'tipo2_pai_i', 'tipo2_pai_ii', 'tipo2_cd', 'tipo2_ac',
    'responsavel',
    'fenotipo_c', 'fenotipo_cw',
    'fenotipo_e', 'fenotipo_e_min', 'fenotipo_k',
    'anticorpos',
    'observacoes',
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
