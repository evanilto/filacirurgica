<div class="painel-rotativo">
    <!-- Linha de título dividida em 3 células -->
    <table style="width:100%; margin-bottom:5px; border-collapse:collapse; background-color:#bea03aff; color:white; border:none;">
        <tr>
            <td style="text-align:left; font-weight:bold; font-size:0.75rem;">Painel Cirúrgico</td>
            <td style="text-align:center; font-weight:bold; font-size:0.95rem;">Pacientes Aguardando</td>
            <td style="text-align:right; font-weight:bold; font-size:0.75rem;"><?= date('d/m/Y', strtotime($data)) ?></td>
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
            const table = $('#table').DataTable({
                autoWidth: false,
                paging: false,
                ordering: false,
                info: false,
                searching: false,
                fixedHeader: true,
                scrollX: true,
                scrollCollapse: true,
                createdRow: function(row, data) {
                    $(row).css('background-color', '#fff3cd');
                },
                language: {
                    emptyTable: "⚠️ Nenhum Paciente no Centro Cirúrgico ⚠️"
                },
                drawCallback: function(settings) {
                    const api = this.api();
                    const hasData = api.data().any();
                    if (!hasData) $('#table thead').hide();
                    else $('#table thead').show();

                    // Sincronizar largura do título com colunas da tabela
                    const ths = $('#table-aguardando thead th');
                    const tds = $('#titulo-tabela td');
                    ths.each(function(index) {
                        const width = $(this).outerWidth();
                        $(tds[index]).css('width', width + 'px');
                    });
                }
            });

            // Atualiza o título quando a janela muda de tamanho
            $(window).resize(function() {
                $('#table').DataTable().draw();
            });
        });
    </script>
</div>
