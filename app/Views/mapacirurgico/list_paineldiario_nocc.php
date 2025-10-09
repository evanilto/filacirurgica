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

        <!-- Tabela principal -->
        <table id="table" cellspacing="0">
            <thead>
                <tr>
                    <th style="width:10%;">Centro Cirúrgico</th>
                    <th style="width:8%;">Sala</th>
                    <th style="width:10%;">Hora Estimada</th>
                    <th style="width:15%;">Especialidade</th>
                    <th style="width:8%;">Prontuário</th>
                    <th style="width:15%;">Nome do Paciente</th>
                    <th style="width:20%;">Procedimento Principal</th>
                    <th style="width:14%;">Observações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($mapacirurgico as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item->centrocirurgico) ?></td>
                    <td><?= htmlspecialchars($item->sala) ?></td>
                    <td class="center"><?= $item->dthrcirurgia ? DateTime::createFromFormat('Y-m-d H:i:s', $item->dthrcirurgia)->format('H:i') : '' ?></td>
                    <td><?= htmlspecialchars($item->especialidade_descr_reduz) ?></td>
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
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <style>
        .table-wrapper {
            width: 100%;
        }

        /* Linha de título externa */
        .titulo-tabela {
            width: 100%;
            table-layout: fixed;
            background-color: #1b7a81ff;
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
    </script>
</div>
