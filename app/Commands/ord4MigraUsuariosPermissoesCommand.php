<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class ord4MigraUsuariosPermissoesCommand extends BaseCommand
{
    protected $group       = 'usuarios';
    protected $name        = 'usuarios:criarpermissoes';
    protected $description = 'Cria tabela de permissões de usuários a partir do sistema do Gafree.';

    public function run(array $params)
    {

        // Instancia seu controller ou o que for necessário
        $controller = new \App\Controllers\Usuarios();

        // Chame a função desejada
        $controller->migrarPermissoes(); 
        
        CLI::write("Término OK!");
    }
}
