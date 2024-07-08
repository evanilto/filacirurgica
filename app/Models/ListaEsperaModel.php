<?php

namespace App\Models;

use CodeIgniter\Model;

class ListaEsperaModel extends Model
{
    protected $table            = 'lista_espera';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'numprontuario',
        'idespecialidade',
        'dtavaliacao',
        'numcid',
        'nmcomplexidade',
        'idtipoprocedimento',
        'idriscocirurgico',
        'idorigempaciente',
        'idprocedimento',
        'nmlateralidade',
        'indsituacao',
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
