<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\Finalization;
use CodeIgniter\CLI\CLI;

class UpdateTablesCommand extends BaseCommand
{
    protected $group       = 'Database';
    protected $name        = 'update:tables';
    protected $description = 'Atualiza tabelas locais a partir de tabelas remotas do AGHU';

    public function run(array $params)
    {
        $db = \Config\Database::connect();

        $db->transStart(); // Inicia a transação

        // Truncar a tabela local
        $db->table('local_agh_cids')->truncate();
        $db->table('local_agh_especialidades')->truncate();
        $db->table('local_agh_unidades_funcionais')->truncate();
        $db->table('local_fat_itens_proced_hospitalar')->truncate();
        $db->table('local_mbc_sala_cirurgicas')->truncate();

        $insertStatus = 'starting';
        $insertStatus = $db->query('INSERT INTO local_agh_cids SELECT * FROM remoto.agh_cids');
        $insertStatus = $db->query('INSERT INTO local_agh_especialidades SELECT * FROM remoto.agh_especialidades');
        $insertStatus = $db->query('INSERT INTO local_agh_unidades_funcionais SELECT * FROM remoto.agh_unidades_funcionais');
        $insertStatus = $db->query('INSERT INTO local_fat_itens_proced_hospitalar SELECT * FROM remoto.fat_itens_proced_hospitalar');
        $insertStatus = $db->query('INSERT INTO local_mbc_sala_cirurgicas SELECT * FROM remoto.mbc_sala_cirurgicas');

        $db->transComplete(); // Completa a transação

        if ($db->transStatus() === FALSE) {
            // Obter a mensagem de erro
            $error = $db->error();
            echo 'Erro na atualização das tabelas: ' . $error['message'] . PHP_EOL;
            echo 'InsertStatus: ' . $insertStatus . PHP_EOL;
        } else {
            echo 'Tabelas locais atualizadas com sucesso!' . PHP_EOL;
        }

    }

}