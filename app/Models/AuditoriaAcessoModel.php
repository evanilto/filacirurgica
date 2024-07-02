<?php

namespace App\Models;

use CodeIgniter\Model;

class AuditoriaAcessoModel extends Model
{
    protected $DBGroup              = 'default';
    protected $table                = 'Sishuap_AuditoriaAcesso';
    protected $primaryKey           = 'idSishuap_AuditoriaAcesso';
    protected $useAutoIncrement     = true;
    protected $returnType           = 'array';
    protected $protectFields        = true;
    protected $allowedFields        = [
                                        'SessionId',
                                        'Operacao',
                                        'idSishuap_Usuario',
                                        'Ip',
                                        'So',
                                        'Navegador',
                                        'NavegadorVersao',
                                    ];

}
