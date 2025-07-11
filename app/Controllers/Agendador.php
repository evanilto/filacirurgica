<?php

namespace App\Controllers;

use App\Models\ListaEsperaModel;
use App\Models\MapaCirurgicoModel;
use App\Models\EquipamentosCirurgiaModel;
use App\Models\HistoricoModel;
use App\Models\FilaWebModel;
use CodeIgniter\Controller;
use Config\Database;

class Agendador extends Controller
{
    private $listaesperamodel;
    private $mapacirurgicomodel;
    private $equipamentoscirurgiamodel;
    private $historicomodel;
    private $filawebmodel;

    public function suspensoesAutomaticas()
    {
        // ⚠️ Segurança: só permite via CLI
        if (!is_cli()) {
            echo "Este método só pode ser executado via CLI.\n";
            return;
        }

        // ⚙️ Setup inicial
        ini_set('display_errors', 1);
        error_reporting(E_ALL);

        echo ">>> Início da rotina de suspensão automática\n";
        log_message('info', 'Rotina de suspensão automática iniciada');

        // ⏺️ Instancia os models
        $this->listaesperamodel = new ListaEsperaModel();
        $this->mapacirurgicomodel = new MapaCirurgicoModel();
        $this->equipamentoscirurgiamodel = new EquipamentosCirurgiaModel();
        $this->historicomodel = new HistoricoModel();
        $this->filawebmodel = new FilaWebModel();

        $db = Database::connect('default');

        try {
            $cirurgias = $this->mapacirurgicomodel
                ->where('indurgencia', 'S')
                ->where('dthrcirurgia <', date('Y-m-d')) // anterior a hoje
                ->where('indsituacao', 'P') // Programada
                ->where('dthrsaidasala', null) // não concluída
                ->findAll();

            $total = count($cirurgias);
            $totalSuspensas = 0;

            echo "Total encontradas: $total\n";

            foreach ($cirurgias as $cirurgia) {
                $db->transStart();

                $this->mapacirurgicomodel->update($cirurgia['id'], [
                    'idsuspensao' => 56,
                    'dthrsuspensao' => date('Y-m-d H:i:s'),
                    'txtjustificativasuspensao' => 'Suspensão automática por data expirada',
                    'indsituacao' => 'SADM'
                ]);

                // Equipamentos
                $equipamentos = $this->equipamentoscirurgiamodel
                    ->where('idmapacirurgico', $cirurgia['id'])
                    ->findAll();

                foreach ($equipamentos as $equipamento) {
                    $this->equipamentoscirurgiamodel->update($equipamento['id'], [
                        'indexcedente' => false
                    ]);

                    $this->filawebmodel->atualizaLimiteExcedidoEquipamento(
                        $cirurgia['datacirurgia'],
                        $equipamento['idequipamento'],
                        true
                    );
                }

                // Lista de espera
                $listaespera = $this->listaesperamodel->withDeleted()->find($cirurgia['idlista']);

                if ($listaespera['indurgencia'] === 'S') {
                    $this->listaesperamodel->withDeleted()->update($cirurgia['idlista'], [
                        'indsituacao' => 'E' // Excluído
                    ]);
                } else {
                    $this->listaesperamodel->withDeleted()->update($cirurgia['idlista'], [
                        'deleted_at' => null,
                        'indsituacao' => 'A' // Aguardando
                    ]);
                }

                // Histórico (ID fixo para rotina automática: 79)
                $this->historicomodel->insert([
                    'dthrevento' => date('Y-m-d H:i:s'),
                    'idlistaespera' => $cirurgia['idlista'],
                    'idevento' => 11, // evento: suspensão automática
                    'idlogin' => 79   // usuário técnico/sistema
                ]);

                $db->transComplete();

                if ($db->transStatus() === false) {
                    throw new \Exception("Erro ao suspender cirurgia ID {$cirurgia['id']}");
                }

                $totalSuspensas++;
                echo "✔ Cirurgia ID {$cirurgia['id']} suspensa\n";
                log_message('info', "Cirurgia ID {$cirurgia['id']} suspensa automaticamente.");
            }

            echo ">>> Fim da rotina. Total suspensas: {$totalSuspensas}\n";
            log_message('info', "Rotina concluída. Total suspensas: {$totalSuspensas}");

        } catch (\Throwable $e) {
            $msg = "Erro na rotina de suspensão: " . $e->getMessage();
            echo "⚠️ $msg\n";
            log_message('error', $msg);
        }
    }
}
