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
            width: 80%;             
            margin: 0 auto;          
            display: flex;
            flex-direction: column;
            align-items: stretch;
        }

        #table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed; /* mantém as larguras respeitadas */
            font-size: 12px;
        }

        /* Linha de título externa */
        .titulo-tabela {
            width: 100%;
            table-layout: fixed;
            background-color: #1b7a81ff;
            color: white;
            border-collapse: collapse;
            margin-bottom: 5px;
            border: none;
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

        .titulo-tabela td {
            padding: 4px 5px;
            font-weight: bold;
            vertical-align: middle;
            border: none;
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
        
        /* Remove margens internas que causam deslocamento */
        #table th, #table td {
            padding: 4px 5px;
            box-sizing: border-box;
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
