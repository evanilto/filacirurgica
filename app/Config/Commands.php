<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Commands extends BaseConfig
{
    public $commands = [
        'prontuarios:criar' => \App\Commands\InsertProntuariosAGHUCommand::class,
        'prontuarios:atualizar' => \App\Commands\UpdateNumProntuarioMVCommand::class,

    ];
    
}
