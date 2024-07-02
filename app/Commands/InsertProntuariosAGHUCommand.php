<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class InsertProntuariosAGHUCommand extends BaseCommand
{
    protected $group       = 'Prontuarios';
    protected $name        = 'prontuarios:criar';
    protected $description = 'Cria prontuários oriundos da base do AGHU.';

    public function run(array $params)
    {
        $inicio = $params[0] ?? null;
        $fim = $params[1] ?? null;

        if (empty($inicio) || empty($fim)) {
            CLI::error("Você precisa especificar os parâmetros de início e fim.");
            return;
        }

        // Instancia seu controller ou o que for necessário
        $controller = new \App\Controllers\Prontuarios();

        // Chame a função desejada
        $controller->criar_prontuarios_aghu((int) $inicio, (int) $fim);

        CLI::write("Término OK!");
    }
}
