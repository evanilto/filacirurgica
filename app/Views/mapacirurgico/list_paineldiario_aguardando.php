<div class="painel-rotativo">
    <div class="table-wrapper">
        <!-- Linha de título externa -->
        <table class="titulo-tabela">
            <tr>
                <td class="left">Painel Cirúrgico</td>
                <td class="center">Pacientes Aguardando</td>
                <td class="right"><?= date('d/m/Y', strtotime($data)) ?></td>
            </tr>
        </table>
        <div style="height:5px;"></div>
        <!-- Tabela principal -->
        <table id="table" cellspacing="0">
            <colgroup>
                <col style="width: 13%;">
                <col style="width: 5%;">
                <col style="width: 6%;">
                <col style="width: 10%;">
                <col style="width: 5%;">
                <col style="width: 17%;">
                <col style="width: 23%;">
                <col style="width: 23%;">
            </colgroup>
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
            background-color: #8d7908ff;
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
            background-color: #cec670ff; /* azul claro */
            text-align: center;
            font-weight: bold;
            padding: 2px 2px;
            border: 1px solid #999;
        }

        /* Corpo da tabela */
        #table td {
            padding: 3px 5px;
            border: 1px solid #d3d0aeff;
            text-align: left;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Centraliza a coluna “Hora Estimada” */
        #table tbody td:nth-child(3) {
            text-align: center;
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
            // 1️⃣ Plugin de ordenação para hora HH:MM
            jQuery.extend(jQuery.fn.dataTable.ext.type.order, {
                "time-hhmm-pre": function(a) {
                    if (!a) return 0; // trata células vazias
                    var parts = a.split(':');
                    return parseInt(parts[0], 10)*60 + parseInt(parts[1], 10); // converte para minutos
                }
            });

            // 2️⃣ Inicializa o DataTable
            var table = $('#table').DataTable({
                autoWidth: false,
                paging: false,
                ordering: true,         // precisa estar true para ordenar
                info: false,
                searching: false,
                fixedHeader: true,
                scrollX: false,
                scrollCollapse: false,
                columnDefs: [
                    {
                        targets: 2, // coluna "Hora Estimada"
                        type: 'time-hhmm'
                    }
                ],
                order: [[2, 'asc']], // ordena pela coluna de hora
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

        table.columns.adjust().draw(false);
        table.fixedHeader.adjust();

    </script>
</div>
