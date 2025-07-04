<?php

namespace App\Models;

use CodeIgniter\Model;

class TransfusaoExpHemocompModel extends Model
{
    protected $table            = 'transfusao_exp_hemocomp';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true; 
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true; 
    protected $protectFields    = true;
    protected $allowedFields    = [
        'transfusao_id',
        'data_expedicao',
        'tipo',
        'numero',
        'abo_rh_expedicao',
        'volume',
        'origem',
        'pc',
        'th',
        'iv',
        'responsavel_expedicao',
        'hora_expedicao',
        'hora_inicio',
        'hora_termino',
        'responsavel_administracao'
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
