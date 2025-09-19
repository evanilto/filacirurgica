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

        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        $db = \Config\Database::connect();

        $db->transStart();

        $insertStatus = 'locking';
        $db->query('LOCK TABLE
            local_agh_cids,
            local_agh_especialidades,
            local_agh_unidades_funcionais,
            local_fat_itens_proced_hospitalar,
            local_mbc_sala_cirurgicas,
            local_aip_pacientes,
            local_prof_especialidades,
            local_centros_cirurgicos,
            local_aip_contatos_pacientes, 
            local_vw_detalhes_pacientes,
            local_agh_instituicoes_hospitalares
        IN ACCESS EXCLUSIVE MODE');

        $insertStatus = 'truncing';
        $db->table('local_agh_cids')->truncate();
        $db->table('local_agh_especialidades')->truncate();
        $db->table('local_agh_unidades_funcionais')->truncate();
        $db->table('local_fat_itens_proced_hospitalar')->truncate();
        $db->table('local_mbc_sala_cirurgicas')->truncate();
        $db->table('local_aip_pacientes')->truncate();
        $db->table('local_prof_especialidades')->truncate();
        $db->table('local_centros_cirurgicos')->truncate();
        $db->table('local_aip_contatos_pacientes')->truncate();
        $db->table('local_vw_detalhes_pacientes')->truncate();
        $db->table('local_vw_aghu_cirurgias')->truncate();
        $db->table('local_agh_instituicoes_hospitalares')->truncate();
        $db->table('local_vw_aghu_antimicrobianos')->truncate();
        $db->table('local_vw_aghu_gmr')->truncate();
        $db->table('local_vw_servidores')->truncate();
        $db->table('local_vw_leitos_pacientes')->truncate();
        $db->table('local_vw_aghu_evol_amb')->truncate();
        $db->table('local_vw_aghu_evol_int')->truncate();
        $db->table('local_vw_exames_liberados')->truncate();

        $insertStatus = 'starting';
        $insertStatus = $db->query('INSERT INTO local_agh_cids SELECT * FROM remoto.agh_cids');
        $insertStatus = $db->query('INSERT INTO local_agh_especialidades SELECT * FROM remoto.agh_especialidades');
        $insertStatus = $db->query('INSERT INTO local_agh_unidades_funcionais SELECT * FROM remoto.agh_unidades_funcionais');
        $insertStatus = $db->query('INSERT INTO local_fat_itens_proced_hospitalar SELECT * FROM remoto.fat_itens_proced_hospitalar');
        $insertStatus = $db->query('INSERT INTO local_mbc_sala_cirurgicas SELECT * FROM remoto.mbc_sala_cirurgicas');
        $insertStatus = $db->query('INSERT INTO local_prof_especialidades SELECT * FROM remoto.vw_prof_especialidades');
        $insertStatus = $db->query('INSERT INTO local_centros_cirurgicos SELECT * FROM remoto.vw_centros_cirurgicos');
        $insertStatus = $db->query('INSERT INTO local_aip_pacientes SELECT * FROM remoto.aip_pacientes');
        $insertStatus = $db->query('INSERT INTO local_aip_contatos_pacientes SELECT * FROM remoto.aip_contatos_pacientes;');
        $insertStatus = $db->query('INSERT INTO local_vw_detalhes_pacientes SELECT * FROM remoto.vw_detalhes_pacientes;');
        $insertStatus = $db->query('INSERT INTO local_vw_aghu_cirurgias SELECT * FROM remoto.vw_aghu_cirurgias;');
        $insertStatus = $db->query('INSERT INTO local_agh_instituicoes_hospitalares SELECT * FROM remoto.agh_instituicoes_hospitalares;');
        $insertStatus = $db->query('INSERT INTO local_vw_aghu_antimicrobianos SELECT * FROM remoto.vw_aghu_antimicrobianos');
        $insertStatus = $db->query('INSERT INTO local_vw_aghu_gmr SELECT * FROM remoto.vw_aghu_gmr');
        $insertStatus = $db->query('INSERT INTO local_vw_servidores SELECT * FROM remoto.vw_servidores');
        $insertStatus = $db->query('INSERT INTO local_vw_leitos_pacientes SELECT * FROM remoto.vw_leitos_pacientes');
        $insertStatus = $db->query('INSERT INTO local_vw_aghu_evol_amb SELECT * FROM remoto.vw_aghu_evol_amb');
        $insertStatus = $db->query('INSERT INTO local_vw_aghu_evol_int SELECT * FROM remoto.vw_aghu_evol_int');
        $insertStatus = $db->query('INSERT INTO local_vw_exames_liberados SELECT * FROM remoto.vw_exames_liberados');

        $insertStatus = 'finishing';

        $db->transComplete();

        if ($db->transStatus() === FALSE) {
            $error = $db->error();
            $db->transRollback();
            echo 'Erro na transação - ' . $insertStatus . ' - ' . ($error['message'] ?? 'Erro não identificado') . PHP_EOL;
            echo 'Código do erro: ' . ($error['code'] ?? 'N/A') . PHP_EOL;
            echo 'Última query: ' . $db->showLastQuery() . PHP_EOL;
        } else {
            echo 'Atualização das tabelas concluídas com sucesso!' . PHP_EOL;
        }

    }

}