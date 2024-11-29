<?php

namespace App\Models;

use CodeIgniter\Model;

class MapaCirurgicoModel extends Model
{
    protected $table            = 'mapa_cirurgico';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true; // false for migration
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true; // false for migration
    protected $protectFields    = true;
    protected $allowedFields    = [
        /*'id', // include for migration
        'created_at', // for migration
        'updated_at', // for migration */
        'idlistaespera',
        'dthrnocentrocirurgico',
        'dthremcirurgia',
        'dthrsaidasala',
        'dthrsuspensao',
        'dthrcirurgia',
        'dthrsaidacentrocirurgico',
        'dthrtroca',
        'idlistatroca',
        'idcentrocirurgico',
        'idsala',
        'idposoperatorio',
        'indhemoderivados',
        'txtnecessidadesproced',
        'txtjustificativaenvio',
        'txtjustificativasuspensao',
        'txtnecessidadesproced',
        'txtjustificativaurgencia',
        'txtjustificativatroca',
        'numordem',
        'indurgencia',
        'idsuspensao',
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
