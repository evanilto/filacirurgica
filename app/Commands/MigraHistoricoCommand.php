<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class MigraHistoricoCommand extends BaseCommand
{
    protected $group       = 'mapa_cirurgico';
    protected $name        = 'mapacirurgico:criarhistorico';
    protected $description = 'Cria histórico a partir do sistema do Gafree.';

    public function run(array $params)
    {
        /* $inicio = $params[0] ?? null;
        $fim = $params[1] ?? null;

        if (empty($inicio) || empty($fim)) {
            CLI::error("Você precisa especificar os parâmetros de início e fim.");
            return;
        } */

        // Instancia seu controller ou o que for necessário
        $controller = new \App\Controllers\MapaCirurgico();

        // Chame a função desejada
        $controller->migrarHistorico();

        CLI::write("Término OK!");
    }
}