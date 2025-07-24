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
        .linha-alta td 
        {
            height: 40px;
        }
    </style>
</head>
<body>
    <h3 class="section-title">TRANSFUSÃO DE EMERGÊNCIA SEM TESTE DE COMPATIBILIDADE</h3>
    <table>
        <colgroup>
        <col style="width: 50%;">
        <col style="width: 50%;">
    </colgroup>
        <tr>
            <td colspan="2">
                <p class="small">
                    Art. 170. Na hipótese de transfusão de urgência ou emergência, a liberação de sangue total ou concentrado de hemácias antes do término dos testes pré-transfusionais poderá ser feita.
                    <br> § 2º O médico solicitante deve estar ciente dos riscos das transfusões de urgência ou emergência e será responsável pelas consequências do ato transfusional, se esta situação houver sido criada por seu esquecimento, omissão ou pela indicação da transfusão sem aprovação prévia nos protocolos definidos pelo Comitê Transfusional. ( PRT MS/GM 158/2016, Art. 171, § 2º) .     
                </p>
            </td>
        </tr>
        </tr>
            <td colspan="2" style="border-bottom: none;">
                <p class="small">
                    AUTORIZO A EXPEDIÇÃO DE <?= esc($dados['hemacias'] ?? '____') ?> UNIDADES DE CONCENTRADO DE HEMÁCIAS SEM A FINALIZAÇÃO DOS TESTES PRÉ-TRANSFUSIONAIS,
                    JUSTIFICADA PELO RISCO DE MORTE DO PACIENTE, CASO A TRANSFUSÃO NÃO SEJA REALIZADA IMEDIATAMENTE.
                </p>
            </td>
        <tr>
            <td colspan="2" style="border-top: none; border-bottom: none;"><p></td>
        </tr>
        <tr>
            <td style="border-top: none; border-right: none;"><strong>Médico Solicitante:</strong> <?= esc($dados['medico_solicitante'] ?? '') ?></td>
            <td style="border-top: none; border-left: none;"><strong>Data/Hora da Solicitação:</strong> <?= esc($dados['dthr_solicitacao'] ?? '') ?></td>
        </tr>
    </table>

    <h3 class="section-title">TESTES PRÉ-TRANSFUSIONAIS (PREENCHIMENTO EXCLUSIVO DA HEMOTERAPIA)</h3>
    <table>
        <tr>
            <td><strong>Amostra Recebida Por:</strong> <?= esc($dados['recebedor'] ?? '') ?></td>
            <td><strong>Data/Hora:</strong> <?= esc($dados['data_recebimento'] ?? '') ?></td>
        </tr>
    </table>

    <table style="width: 100%; table-layout: fixed;">
        <colgroup>
            <col style="width: 6.25%;">
            <col style="width: 6.25%;">
            <col style="width: 6.25%;">
            <col style="width: 6.25%;">
            <col style="width: 6.25%;">
            <col style="width: 6.25%;">
            <col style="width: 6.25%;">
            <col style="width: 6.25%;">
            <col style="width: 6.25%;">
            <col style="width: 6.25%;">
            <col style="width: 6.25%;">
            <col style="width: 6.25%;">
            <col style="width: 6.25%;">
            <col style="width: 6.25%;">
            <col style="width: 6.25%;">
            <col style="width: 6.25%;">
        </colgroup>

        <tr>
            <td colspan="2"><strong>ABO/Rh:</strong> <?= esc($dados['tipo1_aborh'] ?? '') ?></td>
            <td colspan="2"><strong>A:</strong> <?= esc($dados['tipo1_aborh'] ?? '') ?></td>
            <td><strong>B:</strong> <?= esc($dados['tipo1_aborh'] ?? '') ?></td>
            <td><strong>AB:</strong> <?= esc($dados['tipo1_aborh'] ?? '') ?></td>   
            <td><strong>D:</strong> <?= esc($dados['tipo1_aborh'] ?? '') ?></td>
            <td><strong>C:</strong> <?= esc($dados['tipo1_aborh'] ?? '') ?></td>
            <td><strong>RA1:</strong> <?= esc($dados['tipo1_aborh'] ?? '') ?></td>
            <td><strong>RB:</strong> <?= esc($dados['tipo1_aborh'] ?? '') ?></td> 
            <td colspan="7"><strong>Resp:</strong> <?= esc($dados['tipo1_aborh'] ?? '') ?></td>
        </tr>
    </table>

    <table style="width: 100%; table-layout: fixed;">
        <colgroup>
            <col style="width: 6.25%;">
            <col style="width: 6.25%;">
            <col style="width: 6.25%;">
            <col style="width: 6.25%;">
            <col style="width: 6.25%;">
            <col style="width: 6.25%;">
            <col style="width: 6.25%;">
            <col style="width: 6.25%;">
            <col style="width: 6.25%;">
            <col style="width: 6.25%;">
            <col style="width: 6.25%;">
            <col style="width: 6.25%;">
            <col style="width: 6.25%;">
            <col style="width: 6.25%;">
            <col style="width: 6.25%;">
            <col style="width: 6.25%;">
        </colgroup>

        <tr>
            <td colspan="2"><strong>PAI I:</strong> <?= esc($dados['tipo2_pai_i'] ?? '') ?></td>
            <td colspan="2"><strong>PAI II:</strong> <?= esc($dados['tipo2_pai_ii'] ?? '') ?></td>
            <td colspan="2"><strong>Di:</strong> <?= esc($dados['tipo2_cd'] ?? '') ?></td>
            <td colspan="2"><strong>CD:</strong> <?= esc($dados['tipo2_cd'] ?? '') ?></td>
            <td colspan="2"><strong>AC:</strong> <?= esc($dados['tipo2_ac'] ?? '') ?></td>
            <td colspan="2" style="border-right: none;"><strong>Fenotipo</strong> <?= esc($dados['tipo2_ac'] ?? '') ?></td>
            <td style="border-left: none; border-right: none;"><strong>C:</strong> <?= esc($dados['tipo2_ac'] ?? '') ?></td>
            <td colspan="2" style="border-left: none; border-right: none;"><strong>Cw:</strong> <?= esc($dados['tipo2_ac'] ?? '') ?></td>
            <td style="border-left: none; border-right: none;"><strong>c:</strong> <?= esc($dados['tipo2_ac'] ?? '') ?></td>
            <td style="border-left: none; border-right: none;"><strong>E:</strong> <?= esc($dados['tipo2_ac'] ?? '') ?></td>
            <td style="border-left: none; border-right: none;"><strong>e:</strong> <?= esc($dados['tipo2_ac'] ?? '') ?></td>
            <td style="border-left: none; border-right: none;"><strong>K:</strong> <?= esc($dados['tipo2_ac'] ?? '') ?></td>
            <td colspan="2" style="border-left: none; border-right: none;"><strong>JKa:</strong> <?= esc($dados['tipo2_ac'] ?? '') ?></td>
            <td colspan="2" style="border-left: none;"><strong>JKb:</strong> <?= esc($dados['tipo2_ac'] ?? '') ?></td>
        </tr>
         <tr>
            <td colspan="23"><strong>Anticorpos Identificados:</strong> <?= esc($dados['tipo2_pai_i'] ?? '') ?></td>
        </tr>
    </table>

    <table style="width: 100%; table-layout: fixed;">
        <colgroup>
            <col style="width: 5%;">
            <col style="width: 5%;">
            <col style="width: 5%;">
            <col style="width: 5%;">
            <col style="width: 5%;">
            <col style="width: 5%;">
            <col style="width: 5%;">
            <col style="width: 5%;">
            <col style="width: 5%;">
            <col style="width: 5%;">
            <col style="width: 5%;">
            <col style="width: 5%;">
            <col style="width: 5%;">
            <col style="width: 5%;">
            <col style="width: 5%;">
            <col style="width: 5%;">
            <col style="width: 5%;">
            <col style="width: 5%;">
            <col style="width: 5%;">
            <col style="width: 5%;">
        </colgroup>

        <tr>
            <th colspan="16" class="section-title">EXPEDIÇÃO DE HEMOCOMPONENTES</th>
            <th colspan="8" class="section-title">PROCEDIMENTOS</th>
        </tr>
        <tr>
            <th colspan="2">Data</th>
            <th>Tipo</th>
            <th colspan="2">Nº</th>
            <th colspan="2">ABO/Rh</th>
            <th colspan="2">VOL:</th>
            <th colspan="2">Origem</th>
            <th>PC</th>
            <th>TH</th>
            <th>IV</th>
            <th colspan="2">Resp</th>
            <th colspan="2">Filtro</th>
            <th colspan="2">Fenot</th>
            <th colspan="2">Irrad</th>
            <th colspan="2">Lavada</th>
        </tr>
        <?php for ($i = 1; $i <= 6; $i++): ?>
        <tr class="linha-alta">
            <td colspan="2"><?= esc($dados["transfusao_data_$i"] ?? '') ?></td>
            <td><?= esc($dados["transfusao_tipo_$i"] ?? '') ?></td>
            <td colspan="2"><?= esc($dados["transfusao_numero_$i"] ?? '') ?></td>
            <td colspan="2"><?= esc($dados["transfusao_abo_$i"] ?? '') ?></td>
            <td colspan="2"><?= esc($dados["transfusao_origem_$i"] ?? '') ?></td>
            <td colspan="2"><?= esc($dados["transfusao_pc_$i"] ?? '') ?></td>
            <td><?= esc($dados["transfusao_th_$i"] ?? '') ?></td>
            <td><?= esc($dados["transfusao_iv_$i"] ?? '') ?></td>
            <td><?= esc($dados["transfusao_filtro_$i"] ?? '') ?></td>
            <td colspan="2"><?= esc($dados["transfusao_fenot_$i"] ?? '') ?></td>
            <td colspan="2"><?= esc($dados["transfusao_fenot_$i"] ?? '') ?></td>
            <td colspan="2"><?= esc($dados["transfusao_irrad_$i"] ?? '') ?></td>
            <td colspan="2"><?= esc($dados["transfusao_lavada_$i"] ?? '') ?></td>
            <td colspan="2"><?= esc($dados["transfusao_lavada_$i"] ?? '') ?></td>
        </tr>
        <?php endfor; ?>
    </table>

    <table>
        <tr>
            <td style="border-bottom: none;"><strong>Observações</strong><br></td>
        </tr>
        <tr>
            <td style="border-top: none;">
                Legendas:<br>
                ORIGEM 1= HUAP,  2 = IEHE ou SIGLA correspondente / PC= prova cruzada,  C = compatível, I = Incompatível<br>
                TH = Teste de Hemólise / IV =Inspeção visual  
                <p><p>
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
