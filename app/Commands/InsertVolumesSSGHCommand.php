<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class InsertVolumesSSGHCommand extends BaseCommand
{
    protected $group       = 'Prontuarios';
    protected $name        = 'prontuarios:criarvolumessgh';
    protected $description = 'Importa os volumes do SSGH';

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
        $controller->importar_vol_ssgh((int) $inicio, (int) $fim);

        CLI::write("Término OK!");
    }
}
