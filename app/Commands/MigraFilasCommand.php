<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class MigraFilasCommand extends BaseCommand
{
    protected $group       = 'filas';
    protected $name        = 'filas:criarfilas';
    protected $description = 'Cria tabela de filas (tipos_procedimentos) a partir do sistema do Gafree.';

    public function run(array $params)
    {

        // Instancia seu controller ou o que for necessário
        $controller = new \App\Controllers\Filas();

        // Chame a função desejada
        $controller->migrarFilas(); 
        
        CLI::write("Término OK!");
    }
}
