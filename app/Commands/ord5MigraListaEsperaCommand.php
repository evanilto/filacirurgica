<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class ord5MigraListaEsperaCommand extends BaseCommand
{
    protected $group       = 'ListaEspera';
    protected $name        = 'listaespera:criarlista';
    protected $description = 'Cria lista_espera a partir da lista cirurgica do Gafree.';

    public function run(array $params)
    {
        $controller = new \App\Controllers\ListaEspera();

        $controller->migrarLista();

        CLI::write("Término OK!");
    }
}
