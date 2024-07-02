<?php

namespace App\Models;

use CodeIgniter\Model;

class PerfilModel extends Model
{
    protected $DBGroup              = 'default';
    protected $table                = 'perfis';
    protected $primaryKey           = 'id';
    protected $useAutoIncrement     = true;
    protected $returnType           = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields        = true;
    protected $allowedFields        = [
        'nmPerfil',
        'indSituacao'
                                    ];

                                    
    /**
    * Lista os perfis cadastrados de acordo com o usuário indicado
    *
    * @return array
    */
    public function list_perfil_bd($data, $foreach = NULL)
    {

        $db = \Config\Database::connect();
        $query = $db->query('
        SELECT
            SP.idSishuap_Perfil
            , TP.idTab_Perfil
            , TP.Perfil
            , TP.Descricao
        FROM
            Sishuap_Perfil AS SP
            , Tab_Perfil AS TP
        WHERE
            SP.idTab_Perfil = TP.idTab_Perfil
            AND SP.idSishuap_Usuario = ' . $data . '
        ORDER BY TP.Perfil ASC
        ');

        if ($foreach) {
            if ($query->getNumRows() > 0) {
                $v = array();
                foreach ($query->getResultArray() as $val)
                    $v[$val['idTab_Perfil']] = $val['Perfil'];
                return $v;
            }
            else
                return FALSE;
        }
        else
            return ($query->getNumRows() > 0) ? $query->getResultArray() : FALSE ;

    }

}
