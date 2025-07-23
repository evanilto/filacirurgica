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

<table>
    <tr>
        <td>
            <img src="<?= 'file://' . FCPATH . 'img/huap-logo1.png' ?>" style="width: 100%; max-height: 50px;">
        </td>
        <td style="position: relative; vertical-align: top;">
            <strong>UNIVERSIDADE FEDERAL FLUMINENSE - UFF</strong><br>
            <strong>HOSPITAL UNIVERSITÁRIO ANTÔNIO PEDRO - HUAP</strong><br>
            <strong>HEMOCENTRO REGIONAL DE NITERÓI - HEMONIT</strong>

            <img src="<?= 'file://' . FCPATH . 'img/hemonit.svg' ?>" 
                 style="position: absolute; top: 0; right: 0; width: 80px; height: auto;">
        </td>
    </tr>
</table>


<h3 class="section-title">SERVIÇO DE HEMOTERAPIA - REQUISIÇÃO DE TRANSFUSÃO</h3>

<!-- Identificação do paciente -->
<table>
    <tr>
        <td colspan="3"><strong>Nome:</strong> <?= esc($dados['nome_paciente'] ?? '') ?></td>
        <td><strong>Prontuário:</strong> <?= esc($dados['prontuario'] ?? '') ?></td>
    </tr>
    <tr>
        <td><strong>Data de Nascimento:</strong> <?= esc($dados['dtnascimento'] ?? '') ?></td>
        <td><strong>Sexo:</strong> <?= esc($dados['sexo'] ?? '') ?></td>
        <td colspan="2"><strong>Peso:</strong> <?= esc($dados['peso'] ?? '') ?> kg</td>
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
    <tr>
        <td colspan="4"><strong>Indicação:</strong> <?= esc($dados['diagnostico'] ?? '') ?></td>
    </tr>
    <tr>
        <td><strong>Sangramento ativo:</strong> <?= ($dados['sangramento_ativo'] ?? '') === 'S' ? 'Sim' : 'Não' ?></td>
        <td><strong>Transfusão anterior:</strong> <?= ($dados['transfusao_anterior'] ?? '') === 'S' ? 'Sim' : 'Não' ?></td>
        <td colspan="2"><strong>Reação anterior:</strong> <?= ($dados['reacao_transf'] ?? '') === 'S' ? 'Sim' : 'Não' ?></td>
    </tr>
</table>

<!-- Hemocomponentes -->

<table>
        <th>Filtrado</th>
        <th>Irradiado</th>
        <th>Lavado</th>

<td></td>
        <td><?= ($dados['filtrado'] ?? '') === 'S' ? 'Sim' : 'Não' ?></td>
        <td><?= ($dados['irradiado'] ?? '') === 'S' ? 'Sim' : 'Não' ?></td>
        <td><?= ($dados['lavado'] ?? '') === 'S' ? 'Sim' : 'Não' ?></td> -->
</table>
<table>
    <tr class="section-title">
        <th><strong>HEMOCOMPONENTE</strong></th>
        <th><strong>PRESCRIÇÃO</strong></th>
        <th colspan="8"><strong>DADOS LABORATORIAIS</strong></th>
    </tr>
    <tr>
        <td>Concentrado de Hemácias</td>
        <td><?= esc($dados['hemacias'] ?? '') ?></td>
        <td colspan="1">Hto.: <?= esc($dados['hematocrito'] ?? '') ?> %</td>
        <td colspan="2">Data: </td>
        <td colspan="2">Hb: <?= esc($dados['hemoglobina'] ?? '') ?> g/dL</td>
        <td colspan="3">Data: </td>
    </tr>
    <tr>
        <td>Plaquetas</td>
        <td><?= esc($dados['plaquetas'] ?? '') ?></td>
        <td colspan="4">No. Plaquetas</td>
        <td colspan="4">Data</td>
    </tr>
    <tr>
        <td>Plasma Fresco</td>
        <td><?= esc($dados['plasma'] ?? '') ?></td>
        <td colspan="1">TAP: <?= esc($dados['tap'] ?? '') ?> seg</td>
        <td colspan="2">Data: </td>
        <td colspan="1">INR: <?= esc($dados['inr'] ?? '') ?></td>
        <td colspan="2">Data: </td>
        <td colspan="1">PTT: <<?= esc($dados['ptt'] ?? '') ?> seg</td>
        <td colspan="1">Data: </td>
    </tr>
    <tr>
        <td>CRIO/Hemoderivados</td>
        <td><?= esc($dados['crio'] ?? '') ?></td>
        <td colspan="4">Fibrinogênio: <?= esc($dados['fibrinogenio'] ?? '') ?> mg/dL</td>
        <td colspan="4">Data</td>
    </tr>
</table>

<!-- Amostra/Procedimentos especiais -->
<table style="width: 100%; border-collapse: collapse; table-layout: fixed;">
  <colgroup>
    <col style="width: 16.66%;">
    <col style="width: 16.66%;">
    <col style="width: 16.66%;">
    <col style="width: 16.66%;">
    <col style="width: 16.66%;">
    <col style="width: 16.66%;">
  </colgroup>

  <tr class="section-title">
    <th colspan="3"><strong>AMOSTRA</strong></th>
    <th colspan="3"><strong>PROCEDIMENTOS ESPECIAIS</strong></th>
  </tr>

  <tr>
    <td colspan="3">Data/Hora da coleta: <?= esc($dados['dthr_coleta'] ?? '') ?></td>
    <td colspan="1">Filtrado: <?= ($dados['filtrado'] ?? '') === 'S' ? 'Sim' : 'Não' ?></td>
    <td colspan="2">Irradiado: <?= ($dados['irradiado'] ?? '') === 'S' ? 'Sim' : 'Não' ?></td>

  </tr>

  <tr>
    <td colspan="3" style="border-bottom: none;">Coletor: <?= esc($dados['coletor'] ?? '') ?></td>
    <td colspan="1">Lavado <?= ($dados['lavado'] ?? '') === 'S' ? 'Sim' : 'Não' ?></td>
    <td colspan="2">Outros: <?= ($dados['outros'] ?? '') ?></td>
  </tr>

  <tr>
    <td colspan="3" style="border-top: none;"></td>
    <td colspan="3">Justificativa:</td>
  </tr>
</table>

<!-- Tipo de transfusão -->
<table>
     <colgroup>
        <col style="width: 25%;">
        <col style="width: 25%;">
        <col style="width: 25%;">
        <col style="width: 25%;">
    </colgroup>

    <tr>
        <th colspan="4" class="section-title">TIPO DE TRANSFUSÃO</th>
    </tr>
    <tr>
        <td style="border-bottom: none;"><strong>Programada:</strong> <?= ($dados['tipotransfusao'] ?? '') === 'PROGRAMADA' ? 'Sim' : 'Não' ?></td>
        <td style="border-bottom: none;"><strong>Emergência:</strong> <?= ($dados['tipotransfusao'] ?? '') === 'EMERGÊNCIA' ? 'Sim' : 'Não' ?></td>
        <td style="border-bottom: none;"><strong>Rotina:</strong> <?= ($dados['tipotransfusao'] ?? '') === 'ROTINA' ? 'Sim' : 'Não' ?></td>
        <td style="border-bottom: none;"><strong>Urgência:</strong> <?= ($dados['tipotransfusao'] ?? '') === 'URGENTE' ? 'Sim' : 'Não' ?></td>
    </tr>
    <tr>
        <td style="border-top: none;">Reserva para o dia: <?= esc($dados['reserva_data'] ?? '') ?> <?= esc($dados['time'] ?? '') ?></td>
        <td style="border-top: none;">Imediate (vide verso) </td>
        <td style="border-top: none;">Realizada em até 24h </td>
        <td style="border-top: none;">Realizada em até 3h </td>
    </tr>
    <tr>
        <td colspan="2"><strong>Médico Solicitante:</strong> <?= esc($dados['medico_solicitante'] ?? '') ?></td>
        <td><strong>Data da Solicitação: </td>
        <td><strong>Hora da Solicitação: </td>
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
    <tr>
        <td>
            <p></p><p></p><p></p><p></p><p></p><p></p><p></p>
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
