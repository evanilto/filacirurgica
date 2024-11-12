<?php

namespace App\Models;

use CodeIgniter\Model;

class ListaEsperaModel extends Model
{
    protected $table            = 'lista_espera';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true; //false for migration
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true; //false for migration
    protected $protectFields    = true;
    protected $allowedFields    = [
        /* 'id', // for migration
        'created_at', // for migration
        'updated_at', // for migration */
        'deleted_at',
        'numprontuario',
        'idespecialidade',
        'dtriscocirurgico',
        'numcid',
        'idcomplexidade',
        'idtipoprocedimento',
        'idriscocirurgico',
        'idorigempaciente',
        'idprocedimento',
        'idlateralidade',
        'indsituacao',
        'indcongelacao',
        'indurgencia',
        'indexclusao',
        'txtinfoadicionais',
        'txtorigemjustificativa',
        'txtjustificativaexclusao',
        'txtjustificativarecuperacao',
        'txtinfoadicionais'
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
