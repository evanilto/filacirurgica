<?php
    $corProgramada = 'yellow';
    $corPacienteSolicitado = 'gold';
    $corNoCentroCirúrgico = '#97DA4B';
    $corEmCirurgia = '#277534';//'#804616';
    $corSaídaDaSala = '#87CEFA';
    $corSaídaCentroCirúrgico = '#00008B'; //'#277534'; /* Entrada no RPA */
    $corLeitoPosOper = '#5d4037'; // '#8d6e63'
    $corAltaDayClinic = '#78909c';
    $corTrocaPaciente = 'DarkOrange'; //'#FF7F7F';//'#E9967A';
    $corCirurgiaSuspensa = 'Red';
    $corCirurgiaSuspensaAdm = 'purple';
    $corAtualizarHorarios = '#2c3e50';
    $corEditar = $corAtualizarHorarios;
    $corConsultar = $corEditar;
    $corCirurgiaCancelada = $corCirurgiaSuspensa;
    $corReqTransf = $corEditar;


    $coresBotoes = [
        'pacientesolicitado' => $corPacienteSolicitado,
        'nocentrocirurgico' => $corNoCentroCirúrgico,
        'emcirurgia' => $corEmCirurgia,
        'saidadasala' => $corSaídaDaSala,
        'saidadoccirurgico' => $corSaídaCentroCirúrgico,
        'leitoposoper' => $corLeitoPosOper,
        'altadayclinic' => $corAltaDayClinic,
        'suspender' => $corCirurgiaSuspensa,
        'suspenderadm' => $corCirurgiaSuspensaAdm,
        'trocar' => $corTrocaPaciente,
        'atualizarhorarios' => $corAtualizarHorarios,
        'editar' => $corEditar,
        'consultar' => $corConsultar,
        'reqtransf' => $corReqTransf
    ];

    function textoCorLinha($corHex) {
        // Remove # se existir
        $corHex = str_replace('#', '', $corHex);

        // Divide em RGB
        $r = hexdec(substr($corHex, 0, 2));
        $g = hexdec(substr($corHex, 2, 2));
        $b = hexdec(substr($corHex, 4, 2));

        // Calcula luminância (percepção humana)
        $luminancia = (0.299*$r + 0.587*$g + 0.114*$b);

        // Se a luminância for menor que 128, o fundo é escuro
        return ($luminancia < 128) ? 'white' : 'black';
    }

    function corLinhaPaciente($item, $coresBotoes) {
        if ($item->dthraltadayclinic) return $coresBotoes['altadayclinic'];
        if ($item->dthrleitoposoper) return $coresBotoes['leitoposoper'];
        if ($item->dthrsaidacentrocirurgico) return $coresBotoes['saidadoccirurgico'];
        if ($item->dthrsaidasala) return $coresBotoes['saidadasala'];
        if ($item->dthremcirurgia) return $coresBotoes['emcirurgia'];
        if ($item->dthrnocentrocirurgico) return $coresBotoes['nocentrocirurgico'];
        
        return $coresBotoes['pacientesolicitado']; // cor padrão
    }

?>
<div class="painel-rotativo">
    <div class="table-wrapper">
        <!-- Linha de título externa -->
        <table class="titulo-tabela">
            <tr>
                <td class="left">Painel Cirúrgico</td>
                <td class="center">Pacientes no Centro Cirúrgico</td>
                <td class="right"><?= date('d/m/Y', strtotime($data)) ?></td>
            </tr>
        </table>
        <div style="height:5px;"></div>
        <!-- Tabela principal -->
        <table id="table" cellspacing="0">
            <colgroup>
                <col style="width: 5%;">
                <col style="width: 6%;">
                <col style="width: 4%;">
                <col style="width: 4%;">
                <col style="width: 4%;">
                <col style="width: 4%;">
                <col style="width: 4%;">
                <col style="width: 4%;">
                <col style="width: 9%;">
                <col style="width: 11%;">
                <col style="width: 6%;">
                <col style="width: 12%;">
                <col style="width: 11%;">
                <col style="width: 13%;">
                <col style="width: 12%;">
            </colgroup>
            <thead>
                <tr>
                    <th>C. Cir.</th>
                    <th>Sala</th>
                    <th scope="col" class="col-0" style="text-align: center; vertical-align: middle;" title="Entrada no Centro Cirúrgico">
                            <i class="fa-solid fa-circle" style="color: <?= $corNoCentroCirúrgico ?>; "></i>
                    </th>
                    <th scope="col" class="col-0" style="text-align: center; vertical-align: middle;" title="Entrada em Sala">
                            <i class="fa-solid fa-circle" style="color: <?= $corEmCirurgia ?>; "></i>
                    </th>
                    <th scope="col" class="col-0" style="text-align: center; vertical-align: middle;" title="Saída da Sala">
                            <i class="fa-solid fa-circle" style="color: <?= $corSaídaDaSala ?>; "></i>
                    </th>
                    <th scope="col" class="col-0" style="text-align: center; vertical-align: middle;" title="Cirurgia Realizada">
                            <i class="fa-solid fa-circle" style="color: <?= $corSaídaCentroCirúrgico ?>; "></i>
                    </th>
                    <th scope="col" class="col-0" style="text-align: center; vertical-align: middle;" title="Encaminhado ao Leito Pós-Operatório">
                            <i class="fa-solid fa-circle" style="color: <?= $corLeitoPosOper ?>; "></i>
                    </th>
                    <th scope="col" class="col-0" style="text-align: center; vertical-align: middle;" title="Alta Hospitalar Day Clinic">
                            <i class="fa-solid fa-circle" style="color: <?= $corAltaDayClinic ?>; "></i>
                    </th>
                    <th>Especialidade</th>
                    <th>Equipe Médica</th>
                    <th>Prontuário</th>
                    <th>Nome do Paciente</th>
                    <th>Procedimento Principal</th>
                    <th>Observações Cirurgia</th>
                    <th>Observações Enfermagem</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($mapacirurgico as $item): 
                    $corLinha = corLinhaPaciente($item, $coresBotoes);
                    $corTexto = 'white'; //textoCorLinha($corLinha);
                ?>
                <tr style="background-color: <?= $corLinha ?>; color: <?= $corTexto ?>; font-weight: bold;">
                    <td><?= htmlspecialchars(nomeCentroCirurgico($item->centrocirurgico)) ?></td>
                    <td><?= htmlspecialchars($item->sala) ?></td>
                    <td><?php echo $item->dthrnocentrocirurgico ? DateTime::createFromFormat('Y-m-d H:i:s', $item->dthrnocentrocirurgico)->format('H:i') : ' ' ?></td>
                    <td><?php echo $item->dthremcirurgia ? DateTime::createFromFormat('Y-m-d H:i:s', $item->dthremcirurgia)->format('H:i') : ' ' ?></td>
                    <td><?php echo $item->dthrsaidasala ? DateTime::createFromFormat('Y-m-d H:i:s', $item->dthrsaidasala)->format('H:i') : ' ' ?></td>
                    <td><?php echo $item->dthrsaidacentrocirurgico ? DateTime::createFromFormat('Y-m-d H:i:s', $item->dthrsaidacentrocirurgico)->format('H:i') : ' ' ?></td>
                    <td><?php echo $item->dthrleitoposoper ? DateTime::createFromFormat('Y-m-d H:i:s', $item->dthrleitoposoper)->format('H:i') : ' ' ?></td>
                    <td><?php echo $item->dthraltadayclinic ? DateTime::createFromFormat('Y-m-d H:i:s', $item->dthraltadayclinic)->format('H:i') : ' ' ?></td>
                    <td><?= htmlspecialchars($item->especialidade_descr_reduz) ?></td>
                    <td><?= htmlspecialchars($item->equipe_cirurgica) ?></td>
                    <td class="right"><?= htmlspecialchars($item->prontuario) ?></td>
                    <td><?= htmlspecialchars($item->nome_paciente) ?></td>
                    <td><?= htmlspecialchars($item->procedimento_principal) ?></td>
                    <td>
                        <?php
                        $obs = [];
                        $hemocomp = [];
                        if (!empty($item->hemocomponentes_cirurgia_info)) {
                            $dados = json_decode($item->hemocomponentes_cirurgia_info, true);
                            if (json_last_error() === JSON_ERROR_NONE && is_array($dados)) {
                                foreach ($dados as $equip) {
                                    $nome = trim($equip['nome'] ?? $equip['descricao'] ?? '');
                                    if ($nome !== '') {
                                        $hemocomp[] = strpos($nome, '-') !== false ? trim(explode('-', $nome)[0]) : $nome;
                                    }
                                }
                            }
                        }
                        $equipamentos = [];
                        if (!empty($item->equipamentos_cirurgia_info)) {
                            $dados = json_decode($item->equipamentos_cirurgia_info, true);
                            if (json_last_error() === JSON_ERROR_NONE && is_array($dados)) {
                                foreach ($dados as $equip) {
                                    $nome = trim($equip['nome'] ?? $equip['descricao'] ?? '');
                                    if ($nome !== '') {
                                        $equipamentos[] = strpos($nome, '-') !== false ? trim(explode('-', $nome)[1]) : $nome;
                                    }
                                }
                            }
                        }
                        $partes = [];
                        if (strtoupper($item->opme) === 'SIM') $partes[] = 'OPME';
                        if (!empty($equipamentos)) $partes = array_merge($partes, $equipamentos);
                        if (!empty($hemocomp)) $partes = array_merge($partes, $hemocomp);
                        $obs[] = !empty($partes) ? implode(', ', $partes) : '';
                        echo htmlspecialchars(implode(', ', $obs));
                        ?>
                    </td>
                    <td><?= htmlspecialchars($item->obsenfermagem) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div style="height:20px;"></div>
        <!-- Legenda de ícones -->
        <div class="legenda-icones" style="margin-bottom:10px; font-size:11px; display:flex; gap:12px; flex-wrap:wrap;">
            <div>Legenda: </div>
            <div><i class="fa-solid fa-circle" style="color: <?= $corNoCentroCirúrgico ?>;"></i> Entrada no Centro Cirúrgico</div>
            <div><i class="fa-solid fa-circle" style="color: <?= $corEmCirurgia ?>;"></i> Entrada na Sala Cirúrgica</div>
            <div><i class="fa-solid fa-circle" style="color: <?= $corSaídaDaSala ?>;"></i> Saída da Sala Cirúrgica</div>
            <div><i class="fa-solid fa-circle" style="color: <?= $corSaídaCentroCirúrgico ?>;"></i> Entrada no RPA</div>
            <div><i class="fa-solid fa-circle" style="color: <?= $corLeitoPosOper ?>;"></i> No Leito Pós-Operatório</div>
            <div><i class="fa-solid fa-circle" style="color: <?= $corAltaDayClinic ?>;"></i> Alta Day Clinic</div>
        </div>
    </div>

    <style>
        .table-wrapper {
            width: 85%;             
            margin: 0 auto;          
            display: flex;
            flex-direction: column;
            align-items: stretch;
        }

        /* Linha de título externa */
        .titulo-tabela {
            width: 100%;
            table-layout: fixed;
            background-color: #1b7a81ff;
            color: white;
            font-size: 20px;
            border-collapse: collapse;
            margin-bottom: 25px;
        }

         .titulo-tabela td {
            padding: 4px 5px;
            font-size: 14px !important;  /* garante que sobrescreva qualquer outro estilo */
            font-weight: bold;
            vertical-align: middle;
            border: none;
            height: 20px;              /* altura desejada da linha */
            line-height: 20px;         /* centraliza texto verticalmente */
        }

        /* Força alinhamento mesmo com regras globais */
        .titulo-tabela td.left {
            text-align: left !important;
            justify-content: flex-start;
        }
        .titulo-tabela td.center {
            text-align: center !important;
            justify-content: center;
        }
        .titulo-tabela td.right {
            text-align: right !important;
            justify-content: flex-end;
        }

        /* Corrige comportamento se DataTables aplicar display:flex em contêiner pai */
        .painel-rotativo .titulo-tabela td {
            display: table-cell !important;
        }

        .titulo-tabela,
        .dataTables_wrapper,
        #table {
            width: 100% !important;
            margin: 0 !important;
            border-spacing: 0 !important;
            table-layout: fixed !important;
        }

        /* Remove possíveis deslocamentos criados pelo DataTables */
        .dataTables_scrollHead,
        .dataTables_scrollBody {
            width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        .dataTables_empty {
            text-align: center !important;
            font-weight: bold;
            padding: 20px 0; /* opcional: aumenta o espaçamento vertical */
        }

        #table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed; /* mantém as larguras respeitadas */
            font-size: 12px;
        }

       /* Cabeçalho da tabela principal */
        #table thead th {
            background-color: #bdd9e2ff; /* azul claro */
            text-align: center;
            font-weight: bold;
            padding: 2px 2px;
            border: 1px solid #999;
        }

        /* Corpo da tabela */
        #table td {
            padding: 3px 5px;
            border: 1px solid #999;
            text-align: left;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        #table tbody td:nth-child(3),
        #table tbody td:nth-child(4),
        #table tbody td:nth-child(5),
        #table tbody td:nth-child(6),
        #table tbody td:nth-child(7),
        #table tbody td:nth-child(8) {
            text-align: center !important;
        }


        /* Alinha o “Prontuário” à direita */
        #table tbody td:nth-child(5) {
            text-align: right;
        }

        #table td.center { text-align:center; }
        #table td.right { text-align:right; }

        /* Garante que o cabeçalho e corpo fiquem perfeitamente alinhados */
        table.dataTable {
            border-collapse: collapse !important;
            width: 100% !important;
        }

        /* Responsividade */
        @media screen and (max-width: 1024px) { #table, .titulo-tabela { font-size: 11px; } }
        @media screen and (max-width: 768px)  { #table, .titulo-tabela { font-size: 10px; padding: 2px; } }
        @media screen and (max-width: 480px)  { #table, .titulo-tabela { font-size: 9px; padding: 1px; } }
    </style>

    <script>
        $(document).ready(function() {
            var table = $('#table').DataTable({
                autoWidth: false,
                paging: false,
                ordering: false,
                info: false,
                searching: false,
                fixedHeader: true,
                scrollX: false,
                scrollCollapse: false,
                /* createdRow: function(row, data) {
                    $(row).css('background-color', '#fff3cd');
                }, */
                language: { emptyTable: `⚠️ Nenhum Paciente no Centro Cirúrgico ⚠️` },
                drawCallback: function(settings) {
                    const api = this.api();
                    const hasData = api.data().any();
                    if (!hasData) $('#table thead').hide();
                    else $('#table thead').show();
                }
            });

            table.columns.adjust();
            table.fixedHeader.adjust();
        });

        table.columns.adjust().draw(false);
        table.fixedHeader.adjust();

    </script>
</div>
