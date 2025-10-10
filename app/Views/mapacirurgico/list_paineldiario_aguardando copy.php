<div class="painel-rotativo">
    <div class="table-wrapper">
        <!-- Linha de título dividida em 3 células -->
        <table class="titulo-tabela">
                <tr>
                    <td class="left">Painel Cirúrgico</td>
                    <td class="center">Pacientes Aguardando</td>
                    <td class="right"><?= date('d/m/Y', strtotime($data)) ?></td>
                </tr>
            </table>

        <div class="table-responsive-custom">
            <table id="table" cellspacing="0">
                <thead>
                    <tr>
                        <th>Centro Cirúrgico</th>
                        <th>Sala</th>
                        <th>Hora Estimada</th>
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
                        <td class="break-line"><?= htmlspecialchars($item->centrocirurgico) ?></td>
                        <td><?= htmlspecialchars($item->sala) ?></td>
                        <td><?= DateTime::createFromFormat('Y-m-d H:i:s', $item->dthrcirurgia)->format('H:i') ?></td>
                        <td><?= htmlspecialchars($item->especialidade_descr_reduz) ?></td>
                        <td><?= htmlspecialchars($item->prontuario) ?></td>
                        <td><?= htmlspecialchars($item->nome_paciente) ?></td>
                        <td><?= htmlspecialchars($item->procedimento_principal) ?></td>
                        <td class="break-line">
                            <?php
                            $obs = [];
                            // Hemocomponentes
                            $hemocomp = [];
                            if (!empty($item->hemocomponentes_cirurgia_info)) {
                                $dados = json_decode($item->hemocomponentes_cirurgia_info, true);
                                if (json_last_error() === JSON_ERROR_NONE && is_array($dados)) {
                                    foreach ($dados as $equip) {
                                        $nome = trim($equip['nome'] ?? $equip['descricao'] ?? '');
                                        if ($nome !== '') {
                                            if (strpos($nome, '-') !== false) {
                                                $partes = explode('-', $nome, 2);
                                                $sigla = trim($partes[0]);
                                                if ($sigla !== '') $hemocomp[] = $sigla;
                                            } else {
                                                $hemocomp[] = $nome;
                                            }
                                        }
                                    }
                                }
                            }

                            // Equipamentos
                            $equipamentos = [];
                            if (!empty($item->equipamentos_cirurgia_info)) {
                                $dados = json_decode($item->equipamentos_cirurgia_info, true);
                                if (json_last_error() === JSON_ERROR_NONE && is_array($dados)) {
                                    foreach ($dados as $equip) {
                                        $nome = trim($equip['nome'] ?? $equip['descricao'] ?? '');
                                        if ($nome !== '') {
                                            if (strpos($nome, '-') !== false) {
                                                $partes = explode('-', $nome, 2);
                                                $nomeAposHifen = trim($partes[1]);
                                                if ($nomeAposHifen !== '') $equipamentos[] = $nomeAposHifen;
                                            } else {
                                                $equipamentos[] = $nome;
                                            }
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
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <style>
        .table-wrapper {
            width: 100%;
        }

        /* Linha de título externa */
        .titulo-tabela {
            width: 100%;
            table-layout: fixed;
            background-color: #c4a80cff;
            color: white;
            border-collapse: collapse;
            margin-bottom: 5px;
        }

        .titulo-tabela td {
            padding: 4px 5px;
            font-weight: bold;
            vertical-align: middle;
        }

        .titulo-tabela .left { text-align:left; }
        .titulo-tabela .center { text-align:center; }
        .titulo-tabela .right { text-align:right; }

        /* Tabela principal */
        #table {
            width: 100%;
            table-layout: fixed;
            border-collapse: collapse;
            font-size: 12px;
        }

        #table th {
            background-color: white;
            padding: 4px 5px;
            text-align: left;
        }

        #table td {
            padding: 3px 5px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        #table td.center { text-align:center; }
        #table td.right { text-align:right; }

        /* Responsividade */
        @media screen and (max-width: 1024px) { #table, .titulo-tabela { font-size: 11px; } }
        @media screen and (max-width: 768px)  { #table, .titulo-tabela { font-size: 10px; padding: 2px; } }
        @media screen and (max-width: 480px)  { #table, .titulo-tabela { font-size: 9px; padding: 1px; } }
    </style>

    <style>
        /* Títulos das colunas da tabela principal em br */
        #table thead th {
            background-color: #ffffff !important;
            text-align: center;
            font-weight: bold;
        }

        /* Centraliza a coluna “Hora Estimada” */
        #table tbody td:nth-child(3) {
            text-align: center;
        }

        /* Alinha o “Prontuário” à direita */
        #table tbody td:nth-child(5) {
            text-align: right;
        }
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
                createdRow: function(row, data) {
                    $(row).css('background-color', '#fff3cd');
                },
                language: { emptyTable: `⚠️ Nenhum Paciente Aguardando ⚠️` },
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
    </script>
</div>
