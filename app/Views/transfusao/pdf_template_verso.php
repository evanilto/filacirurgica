<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Guia de Requisição Transfusional - Verso</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10.5px;
            margin: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
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
        .small {
            font-size: 9px;
        }
    </style>
</head>
<body>

<h3 class="section-title">HISTÓRICO DE TRANSFUSÕES ANTERIORES</h3>

<table>
    <tr>
        <th>Data</th>
        <th>Tipo</th>
        <th>Nº</th>
        <th>ABO/Rh</th>
        <th>Origem</th>
        <th>PC</th>
        <th>TH</th>
        <th>IV</th>
        <th>Filtro</th>
        <th>Fenot</th>
        <th>Irrad</th>
        <th>Lavada</th>
    </tr>
    <?php for ($i = 1; $i <= 6; $i++): ?>
    <tr>
        <td><?= esc($dados["transfusao_data_$i"] ?? '') ?></td>
        <td><?= esc($dados["transfusao_tipo_$i"] ?? '') ?></td>
        <td><?= esc($dados["transfusao_numero_$i"] ?? '') ?></td>
        <td><?= esc($dados["transfusao_abo_$i"] ?? '') ?></td>
        <td><?= esc($dados["transfusao_origem_$i"] ?? '') ?></td>
        <td><?= esc($dados["transfusao_pc_$i"] ?? '') ?></td>
        <td><?= esc($dados["transfusao_th_$i"] ?? '') ?></td>
        <td><?= esc($dados["transfusao_iv_$i"] ?? '') ?></td>
        <td><?= esc($dados["transfusao_filtro_$i"] ?? '') ?></td>
        <td><?= esc($dados["transfusao_fenot_$i"] ?? '') ?></td>
        <td><?= esc($dados["transfusao_irrad_$i"] ?? '') ?></td>
        <td><?= esc($dados["transfusao_lavada_$i"] ?? '') ?></td>
    </tr>
    <?php endfor; ?>
</table>

<h3 class="section-title">TRANSFUSÃO DE EMERGÊNCIA SEM TESTE DE COMPATIBILIDADE</h3>
<p class="small">
    AUTORIZO A EXPEDIÇÃO DE <?= esc($dados['hemacias'] ?? '____') ?> UNIDADES DE CONCENTRADO DE HEMÁCIAS SEM A FINALIZAÇÃO DOS TESTES PRÉ-TRANSFUSIONAIS,
    JUSTIFICADA PELO RISCO DE MORTE DO PACIENTE, CASO A TRANSFUSÃO NÃO SEJA REALIZADA IMEDIATAMENTE.
</p>

<table>
    <tr>
        <td><strong>Observações:</strong><br><?= nl2br(esc($dados['observacoes_hemoterapia'] ?? '')) ?></td>
    </tr>
    <tr>
        <td><strong>Volume Total:</strong> <?= esc($dados['volume_total'] ?? '') ?> ml</td>
    </tr>
</table>

<h3 class="section-title">TESTES PRÉ-TRANSFUSIONAIS (PREENCHIMENTO EXCLUSIVO DA HEMOTERAPIA)</h3>

<table>
    <tr>
        <td><strong>ABO/Rh:</strong> <?= esc($dados['tipo1_aborh'] ?? '') ?></td>
        <td><strong>PAI I:</strong> <?= esc($dados['tipo2_pai_i'] ?? '') ?></td>
        <td><strong>PAI II:</strong> <?= esc($dados['tipo2_pai_ii'] ?? '') ?></td>
        <td><strong>CD:</strong> <?= esc($dados['tipo2_cd'] ?? '') ?></td>
        <td><strong>AC:</strong> <?= esc($dados['tipo2_ac'] ?? '') ?></td>
    </tr>
    <tr>
        <td><strong>Dia:</strong> <?= esc($dados['data_recebimento'] ?? '') ?></td>
        <td colspan="2"><strong>Hora:</strong> <?= esc($dados['time'] ?? '') ?></td>
        <td colspan="2"><strong>Anticorpos identificados:</strong> <?= esc($dados['anticorpos'] ?? '') ?></td>
    </tr>
</table>

<table>
    <tr>
        <td><strong>Amostra Recebida Por:</strong> <?= esc($dados['recebedor'] ?? '') ?></td>
        <td><strong>Data:</strong> <?= esc($dados['data_recebimento'] ?? '') ?></td>
        <td><strong>Hora:</strong> <?= esc($dados['time'] ?? '') ?></td>
    </tr>
    <tr>
        <td colspan="2"><strong>Médico Solicitante:</strong> <?= esc($dados['medico_solicitante'] ?? '') ?></td>
        <td><strong>Data Solicitação:</strong> <?= esc($dados['dthr_solicitacao'] ?? '') ?></td>
    </tr>
</table>

<p class="small">
    § 2º O médico solicitante deve estar ciente dos riscos das transfusões de urgência ou emergência e será responsável pelas consequências do ato transfusional, 
    se esta situação houver sido criada por seu esquecimento, omissão ou pela indicação da transfusão sem aprovação prévia nos protocolos definidos pelo Comitê Transfusional.
    (PRT MS/GM 158/2016, Art. 171, § 2º)
</p>

<p class="small">
    Portaria de consolidação nº 5 de 03/10/2017.
</p>

</body>
</html>
