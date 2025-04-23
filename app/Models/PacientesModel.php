<?php

namespace App\Models;

use CodeIgniter\Model;

class ListaEsperaModel extends Model
{
    protected $table            = 'pacientes';
    protected $primaryKey       = 'numprontuario';
    protected $useAutoIncrement = true; //false for migration
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true; //false for migration
    protected $protectFields    = true;
    protected $allowedFields    = [
        'numprontuario',
        'tiposanguineo'
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
