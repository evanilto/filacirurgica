<?php

namespace App\Models;

use CodeIgniter\Model;

class AuditoriaLogModel extends Model
{
    protected $DBGroup              = 'default';
    protected $table                = 'Sishuap_AuditoriaLog';
    protected $primaryKey           = 'idSishuap_AuditoriaLog';
    protected $useAutoIncrement     = true;
    protected $returnType           = 'array';
    protected $protectFields        = true;
    protected $allowedFields        = [
                                        'idSishuap_Auditoria',
                                        'Campo',
                                        'ValorAnterior',
                                        'ValorAtual',
                                        'ChavePrimaria',
                                    ];

}
