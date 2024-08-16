<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class MigraListaEsperaCommand extends BaseCommand
{
    protected $group       = 'lista_espera';
    protected $name        = 'listaespera:criarlista';
    protected $description = 'Cria lista_espera a partir da lista cirurgica do Gafree.';

    public function run(array $params)
    {
        /* $inicio = $params[0] ?? null;
        $fim = $params[1] ?? null;

        if (empty($inicio) || empty($fim)) {
            CLI::error("Você precisa especificar os parâmetros de início e fim.");
            return;
        } */

        // Instancia seu controller ou o que for necessário
        $controller = new \App\Controllers\ListaEspera();

        // Chame a função desejada
        $controller->migrarLista();

        CLI::write("Término OK!");
    }
}
