<?php

namespace App\Models;

use CodeIgniter\Model;

class AuditoriaModel extends Model
{
    protected $DBGroup              = 'default';
    protected $table                = 'Sishuap_Auditoria';
    protected $primaryKey           = 'idSishuap_Auditoria';
    protected $useAutoIncrement     = true;
    protected $returnType           = 'array';
    protected $protectFields        = true;
    protected $allowedFields        = [
                                        'Tabela',
                                        'idSishuap_Usuario',
                                        'Operacao',
                                        'ChavePrimaria',
                                        'Ip',
                                        'So',
                                        'Navegador',
                                        'NavegadorVersao',
                                    ];

}
