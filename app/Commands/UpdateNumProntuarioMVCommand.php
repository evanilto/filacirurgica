<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class UpdateNumProntuarioMVCommand extends BaseCommand
{
    protected $group       = 'Prontuarios';
    protected $name        = 'prontuarios:atualizar';
    protected $description = 'Atualiza o número de prontuários entre intervalos definidos.';

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
        $controller->atualizar_num_prontuario_mv((int) $inicio, (int) $fim);

        CLI::write("Término OK!");
    }
}
