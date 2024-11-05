<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table            = 'usuarios';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'idlogin',
        'nmusuario',
        'indsituacao',
        'user_ult_atu'
        ];

    /* protected $allowedFields        = [
        'Inativo',
        'Usuario',
        'Nome',
        'Cpf',
        'EmailSecundario',
    ]; */

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
    * Tela inicial
    *
    * @return void
    */
    public function get_user_mysql($data)
    {
        $db = \Config\Database::connect();
        
        $query = $db->query("
            SELECT
                *
            FROM
                usuarios
            WHERE
                idlogin = '" . $data . "' 
            AND indsituacao = 'A'
            "); 
        //die(var_dump($query->getNumRows()));
        return ($query->getNumRows() > 0) ? $query->getRowArray() : FALSE ;

/*         return (true);
 */
    }

    /**
    * Tela inicial do preschuapweb
    *
    * @return void
    */
    public function check_user($data)
    {

        $db = \Config\Database::connect();
        $query = $db->query('
            SELECT
                idSishuap_Usuario
                , Nome
                , Usuario
            FROM
                Sishuap_Usuario
            WHERE
                Usuario = "' . $data . '"
                OR Cpf = "' . $data . '"
            ORDER BY Nome
        ');
        /*echo $db->getLastQuery();
        echo "<pre>";
        print_r($query->getRowArray());
        echo "</pre>";
        exit($data);*/
        return ($query->getNumRows() > 0) ? $query->getRowArray() : FALSE ;

    }
}

