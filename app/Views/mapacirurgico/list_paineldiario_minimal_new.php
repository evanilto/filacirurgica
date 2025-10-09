<!DOCTYPE html>
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
?>
<html>
<head>
    <meta charset="UTF-8">
    <title>Painel Cirúrgico</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/4.0.1/css/fixedHeader.dataTables.min.css">
<style>
    body {
        margin: 0;
        padding: 10px; /* reduzido de 20px */
        font-family: 'Montserrat', sans-serif;
        background-color: #f8f9fa;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    h5 {
        font-size: 0.9rem; /* um pouco menor */
        margin-bottom: 8px;
    }

    .table-responsive-custom {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    #table {
        width: 100%;
        table-layout: fixed;
        font-size: 9px; /* reduzido de 11px */
        line-height: 1.4; /* reduzido de 1.1 */
        border-collapse: collapse;
    }

    #table th, #table td {
        padding: 3px 2px; /* reduzido de 2px 4px */
        text-align: center;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    #table thead th {
        font-size: 9px; /* reduzido de 11px */
        text-align: left;
        line-height: 1.4;     /* aumenta altura do header */

    }

    #table tbody td {
        text-align: left;
        font-size: 9px; /* reduzido de 12px */
        line-height: 1.4;
    }

    .break-line {
        white-space: normal;
        word-wrap: break-word;
        word-break: break-word;
    }

    @media (max-width: 1280px) {
        #table {
            font-size: 8px; /* fonte menor para telas menores */
        }
        #table th, #table td {
            padding: 1px 1px;
        }
    }

    @media (max-width: 768px) {
        #table {
            font-size: 7px; /* para mobile */
        }
        #table th, #table td {
            padding: 1px 1px;
        }
    }
</style>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/fixedheader/4.0.1/js/dataTables.fixedHeader.min.js"></script>
</head>
<body>
    <h5><strong>Painel Cirúrgico - <?= date('d/m/Y', strtotime($data)) ?></strong></h5>

    <div class="table-responsive-custom">
        <table id="table" class="display" style="width:100%;">
            <thead>
                <tr>
                    <th>Centro Cirúrgico</th>
                    <th>Sala</th>
                    <th scope="col" class="col-0" style="text-align: center; vertical-align: middle;" title="Paciente Solicitado">
                        <i class="fa-solid fa-circle" style="color: <?= $corPacienteSolicitado ?>; "></i>
                    </th>
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
                    <th>Prontuário</th>
                    <th>Nome do Paciente</th>
                    <th>Procedimento Principal</th>
                    <th>Observações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($mapacirurgico as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item->centrocirurgico) ?></td>
                    <td><?= htmlspecialchars($item->sala) ?></td>
                    <td><?= $item->dthrnocentrocirurgico ? DateTime::createFromFormat('Y-m-d H:i:s', $item->dthrnocentrocirurgico)->format('H:i') : '' ?></td>
                    <td><?= $item->dthremcirurgia ? DateTime::createFromFormat('Y-m-d H:i:s', $item->dthremcirurgia)->format('H:i') : '' ?></td>
                    <td><?= $item->dthrsaidasala ? DateTime::createFromFormat('Y-m-d H:i:s', $item->dthrsaidasala)->format('H:i') : '' ?></td>
                    <td><?= htmlspecialchars($item->especialidade_descr_reduz) ?></td>
                    <td><?= htmlspecialchars($item->prontuario) ?></td>
                    <td><?= htmlspecialchars($item->nome_paciente) ?></td>
                    <td><?= htmlspecialchars($item->procedimento_principal) ?></td>
                    <td class="break-line">
                    <?php
                        $obs = [];

                        // ----------------------------------------------------
                        // 1️⃣ HEMOCOMPONENTES (usa só a sigla antes do hífen)
                        // ----------------------------------------------------
                        $hemocomp = [];
                        if (!empty($item->hemocomponentes_cirurgia_info)) {
                            $dados = json_decode($item->hemocomponentes_cirurgia_info, true);
                            if (json_last_error() === JSON_ERROR_NONE && is_array($dados)) {
                                foreach ($dados as $equip) {
                                    $nome = trim($equip['nome'] ?? $equip['descricao'] ?? '');
                                    if ($nome !== '') {
                                        if (strpos($nome, '-') !== false) {
                                            // tem hífen → usa a sigla (antes do hífen)
                                            $partes = explode('-', $nome, 2);
                                            $sigla = trim($partes[0]);
                                            if ($sigla !== '') {
                                                $hemocomp[] = $sigla;
                                            }
                                        } else {
                                            // sem hífen → usa o nome completo
                                            $hemocomp[] = $nome;
                                        }
                                    }
                                }
                            }
                        }

                        // ----------------------------------------------------
                        // 2️⃣ EQUIPAMENTOS (usa a parte após o hífen, se houver)
                        // ----------------------------------------------------
                        $equipamentos = [];
                        if (!empty($item->equipamentos_cirurgia_info)) {
                            $dados = json_decode($item->equipamentos_cirurgia_info, true);
                            if (json_last_error() === JSON_ERROR_NONE && is_array($dados)) {
                                foreach ($dados as $equip) {
                                    $nome = trim($equip['nome'] ?? $equip['descricao'] ?? '');
                                    if ($nome !== '') {
                                        if (strpos($nome, '-') !== false) {
                                            // tem hífen → usa parte após o hífen
                                            $partes = explode('-', $nome, 2);
                                            $nomeAposHifen = trim($partes[1]);
                                            if ($nomeAposHifen !== '') {
                                                $equipamentos[] = $nomeAposHifen;
                                            }
                                        } else {
                                            // sem hífen → usa o nome completo
                                            $equipamentos[] = $nome;
                                        }
                                    }
                                }
                            }
                        }

                        // ----------------------------------------------------
                        // 3️⃣ Montagem das observações
                        // ----------------------------------------------------
                    /*  if (strtoupper($item->opme) === 'NÃO') {
                            $obs[] = 'Sem OPME';
                        } */

                        $partes = [];

                        if (strtoupper($item->opme) === 'SIM') {
                            $partes[] = 'OPME';
                        }

                        if (!empty($equipamentos)) {
                            $partes = array_merge($partes, $equipamentos);
                        }

                        if (!empty($hemocomp)) {
                            $partes = array_merge($partes, $hemocomp);
                        }

                        if (!empty($partes)) {
                            //$obs[] = 'Utiliza ' . implode(', ', $partes);
                            $obs[] = implode(', ', $partes);
                        }

                        if (empty($obs)) {
                            $obs[] = '';
                        }

                        echo htmlspecialchars(implode(', ', $obs));
                    ?>
                </td>

                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function() {
            $('#table').DataTable({
                autoWidth: false,
                paging: false,
                ordering: false,
                info: false,
                searching: false,
                order: [[2, 'desc'], [0, 'asc']],
                columnDefs: [
                    { width: "45px", targets: 0 },
                    { width: "45px", targets: 1 },
                    { width: "45px", targets: 2 },
                    { width: "45px", targets: 3 },
                    { width: "45px", targets: 4 },
                    { width: "90px", targets: 5 },
                    { width: "80px", targets: 6 },
                    { width: "150px", targets: 7 },
                    { width: "130px", targets: 8 },
                    { width: "200px", targets: 9 }
                ],
                createdRow: function(row, data) {
                    if (!data[2] || data[2].trim() === '') {
                        $(row).css('background-color', '#fff3cd');
                    } else {
                        $(row).css('background-color', '#c1e9ecff');
                    }
                }
            });

            setInterval(function() {
                window.location.reload();
            }, 30000);
        });
    </script>
</body>
</html>
