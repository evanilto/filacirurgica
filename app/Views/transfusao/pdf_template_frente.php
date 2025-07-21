<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Guia de Requisição Transfusional</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            margin: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        td, th {
            border: 1px solid #333;
            padding: 4px;
            vertical-align: top;
        }
        .section-title {
            background: #eee;
            font-weight: bold;
            text-align: center;
        }
        .no-border {
            border: none !important;
        }
    </style>
</head>
<body>

<<table>
    <tr>
        <td>
            <img src="<?= 'file://' . FCPATH . 'img/huap-logo1.png' ?>" style="width: 100%; max-height: 50px;">
        </td>
        <td style="vertical-align: top;">
            <strong>UNIVERSIDADE FEDERAL FLUMINENSE - UFF</strong><br>
            <strong>HOSPITAL UNIVERSITÁRIO ANTÔNIO PEDRO - HUAP</strong><br>
            <strong>HEMOCENTRO REGIONAL DE NITERÓI - HEMONIT</strong>

            <div style="text-align: right;">
                <img src="<?= 'file://' . FCPATH . 'img/hemonit.svg' ?>" style="width: 80px; height: auto; vertical-align: top;">
            </div>
        </td>
    </tr>
</table>

<h3 class="section-title">SERVIÇO DE HEMOTERAPIA - REQUISIÇÃO DE TRANSFUSÃO</h3>

<!-- Identificação do paciente -->
<table>
    <tr>
        <td><strong>Nome:</strong> <?= esc($dados['nome_paciente'] ?? '') ?></td>
        <td><strong>Data de Nascimento:</strong> <?= esc($dados['dtnascimento'] ?? '') ?></td>
        <td><strong>Sexo:</strong> <?= esc($dados['sexo'] ?? '') ?></td>
        <td><strong>Peso:</strong> <?= esc($dados['peso'] ?? '') ?> kg</td>
    </tr>
    <tr>
        <td colspan="2"><strong>Prontuário:</strong> <?= esc($dados['prontuario'] ?? '') ?></td>
        <td colspan="2"><strong>Telefone/Ramal:</strong> <?= esc($dados['telefone'] ?? '') ?></td>
    </tr>
    <tr>
        <td><strong>Unidade:</strong> <?= esc($dados['unidade'] ?? '') ?></td>
        <td><strong>Andar:</strong> <?= esc($dados['andar'] ?? '') ?></td>
        <td><strong>Leito:</strong> <?= esc($dados['leito'] ?? '') ?></td>
        <td><strong>Data Solicitação:</strong> <?= esc($dados['dthr_solicitacao'] ?? '') ?></td>
    </tr>
</table>

<!-- Diagnóstico -->
<table>
    <tr>
        <td colspan="4"><strong>Diagnóstico:</strong> <?= esc($dados['diagnostico'] ?? '') ?></td>
    </tr>
</table>

<!-- Dados laboratoriais -->
<table>
    <tr>
        <th colspan="6" class="section-title">DADOS LABORATORIAIS</th>
    </tr>
    <tr>
        <td><strong>Hemoglobina:</strong><br><?= esc($dados['hemoglobina'] ?? '') ?> g/dL</td>
        <td><strong>Hematócrito:</strong><br><?= esc($dados['hematocrito'] ?? '') ?> %</td>
        <td><strong>TAP:</strong><br><?= esc($dados['tap'] ?? '') ?> seg</td>
        <td><strong>INR:</strong><br><?= esc($dados['inr'] ?? '') ?></td>
        <td><strong>PTT:</strong><br><?= esc($dados['ptt'] ?? '') ?> seg</td>
        <td><strong>Fibrinogênio:</strong><br><?= esc($dados['fibrinogenio'] ?? '') ?> mg/dL</td>
    </tr>
</table>

<!-- Indicação -->
<table>
    <tr>
        <th colspan="4" class="section-title">INDICAÇÃO</th>
    </tr>
    <tr>
        <td colspan="4"><?= esc($dados['indicacao'] ?? '') ?></td>
    </tr>
    <tr>
        <td><strong>Sangramento ativo:</strong> <?= ($dados['sangramento_ativo'] ?? '') === 'S' ? 'Sim' : 'Não' ?></td>
        <td><strong>Transfusão anterior:</strong> <?= ($dados['transfusao_anterior'] ?? '') === 'S' ? 'Sim' : 'Não' ?></td>
        <td><strong>Reação anterior:</strong> <?= ($dados['reacao_transf'] ?? '') === 'S' ? 'Sim' : 'Não' ?></td>
        <td><strong>Pré-medicação:</strong> <?= ($dados['premedicacao'] ?? '') === 'S' ? 'Sim' : 'Não' ?></td>
    </tr>
</table>

<!-- Tipo de transfusão -->
<table>
    <tr>
        <th colspan="4" class="section-title">TIPO DE TRANSFUSÃO</th>
    </tr>
    <tr>
        <td><strong>Rotina:</strong> <?= ($dados['tipotransfusao'] ?? '') === 'ROTINA' ? 'Sim' : 'Não' ?></td>
        <td><strong>Urgência:</strong> <?= ($dados['tipotransfusao'] ?? '') === 'URGENTE' ? 'Sim' : 'Não' ?></td>
        <td><strong>Programada:</strong> <?= ($dados['tipotransfusao'] ?? '') === 'PROGRAMADA' ? 'Sim' : 'Não' ?></td>
        <td><strong>Reserva para o dia:</strong> <?= esc($dados['reserva_data'] ?? '') ?> <?= esc($dados['time'] ?? '') ?></td>
    </tr>
</table>

<!-- Hemocomponentes -->
<table>
    <tr>
        <th colspan="6" class="section-title">HEMOCOMPONENTES SOLICITADOS</th>
    </tr>
    <tr>
        <th>Componente</th>
        <th>Unidades</th>
        <th>mL</th>
        <th>Filtrado</th>
        <th>Irradiado</th>
        <th>Lavado</th>
    </tr>
    <tr>
        <td>Concentrado de Hemácias</td>
        <td><?= esc($dados['hemacias'] ?? '') ?></td>
        <td></td>
        <td><?= ($dados['filtrado'] ?? '') === 'S' ? 'Sim' : 'Não' ?></td>
        <td><?= ($dados['irradiado'] ?? '') === 'S' ? 'Sim' : 'Não' ?></td>
        <td><?= ($dados['lavado'] ?? '') === 'S' ? 'Sim' : 'Não' ?></td>
    </tr>
    <tr>
        <td>Plaquetas</td>
        <td><?= esc($dados['plaquetas'] ?? '') ?></td>
        <td></td>
        <td colspan="3"></td>
    </tr>
    <tr>
        <td>Plasma Fresco</td>
        <td><?= esc($dados['plasma'] ?? '') ?></td>
        <td></td>
        <td colspan="3"></td>
    </tr>
</table>

<!-- Coleta -->
<table>
    <tr>
        <td><strong>Data da Coleta:</strong> <?= esc($dados['dthr_coleta'] ?? '') ?></td>
        <td><strong>Hora da Coleta:</strong> <?= esc($dados['time'] ?? '') ?></td>
        <td><strong>Coletor:</strong> <?= esc($dados['coletor'] ?? '') ?></td>
    </tr>
</table>

<!-- Observações -->
<table>
    <tr>
        <td><strong>Observações:</strong><br><?= nl2br(esc($dados['observacoes'] ?? '')) ?></td>
    </tr>
</table>

<!-- Médico -->
<table>
    <tr>
        <td><strong>Nome do Médico:</strong> <?= esc($dados['medico_solicitante'] ?? '') ?></td>
        <td><strong>CRM:</strong> <?= esc($dados['crm'] ?? '') ?></td>
    </tr>
</table>

<!-- Informações fixas -->
<table>
    <tr>
        <td style="font-size: 10px; line-height: 1.4;">
            <strong>Observações:</strong><p>
            As transfusões serão realizadas, preferencialmente, no período diurno. Portaria de consolidação nº 5 de 03/10/2017.<br>
            Só serão atendidas as requisições corretamente preenchidas e assinadas por médicos (registro CRM).<br>
            Os concentrados de plaquetas serão liberados na forma de pool de 4 ou 5 unidades ou por aférese.
        </td>
    </tr>
</table>

<!-- Rodapé -->
<table>
    <tr>
        <td>
            <div style="text-align: left; margin-bottom: 10px; width: 20%; max-height: 15px;">
                <img src="<?= 'file://' . FCPATH . 'img/ebserh_logo.jpg' ?>" style="width: 100%; max-height: 120px;">
            </div>
            <div style="text-align: right; margin-top: 10px; ">
                Formulário FilaWeb - 31/07/2025
            </div>
        </td>
    </tr>
</table>

</body>
</html>
