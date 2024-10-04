<?php

namespace App\Models;

use CodeIgniter\Model;

class LocalProfEspecialidadesModel extends Model
{
    protected $table            = 'local_prof_especialidades';
    protected $primaryKey       = 'esp_seq';
    protected $useAutoIncrement = false;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nome',                     
        'esp_seq',
        'esp_sigla',
        'esp_nome_reduzido',
        'esp_nome',
        'pes_codigo',                     
        'ser_vin_codigo',
        'ser_matricula',
        'conselho',   
    ];

    // Dates
    protected $useTimestamps = false;
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
