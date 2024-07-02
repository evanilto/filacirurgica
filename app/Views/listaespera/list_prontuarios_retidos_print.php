<body>
<main role="main">
    <section class="tabs">
        <div class="tabbed-content">
                <?php 
                $primVez = true; 
                $quebraAnt = null; 
                $totalProntuarios = 0;
                ?>
                <?php foreach($prontuarios as $prontuario): ?>

                    <?php if (is_null($quebraAnt) || ($quebraAnt != $prontuario['setordestino'])) { ?>

                        <?php if(!$primVez) { ?>
                            <tr>
                                <td colspan="5" class="text-right"><strong>Total Prontuários: <?= $totalProntuarios; ?></strong></td>
                            </tr>
                            </tbody>
                            </table>
                        <?php 
                            $totalProntuarios = 0;
                        } ?>

                        <table id="table" class="table table-hover table-bordered table-smaller-font printable <?= !is_null($quebraAnt) ? 'page-break' : 'no-page-break' ?> ">
                        <thead>
                            <tr>
                                <th scope="col" colspan="7" class="bg-light text-center"><h5><strong>Prontuários Retidos</strong></h5></th>
                            </tr>
                            <tr><strong>
                                <th scope="col" colspan="7" class="bg-light text-left"><h6><strong>Setor: <?= $prontuario['setordestino'] ?></strong></h6></th>
                            </strong></tr>
                            <tr>
                            <th scope="col" data-field="setororigem" >Setor Origem</th>
                            <th scope="col" data-field="prontuario" >Prontuário</th>
                            <th scope="col" data-field="volume" >Volume</th>
                            <th scope="col" data-field="dtmovimentacao" >Data de Movimentação</th>
                            <th scope="col" data-field="dtprazoretorno" >Prazo de Retorno</th>
                            <th scope="col" data-field="movorigem" >Origem</th>
                            </tr>
                        </thead>
                        <tbody id="table-body">

                        <?php 
                        $quebraAnt = $prontuario['setordestino']; 
                        $primVez = false;
                        } ?>

                    <tr>
                        <td><?php echo $prontuario['setororigem'] ?></td>
                        <td><?php echo $prontuario['prontuario']; ?></td>
                        <td><?php echo $prontuario['volume'] ?></td>
                        <td><?php echo date_format(date_create($prontuario['dtmovimentacao']), 'd/m/Y') ?></td>
                        <td><?php echo $prontuario['dtprazoretorno'] ? date_format(date_create($prontuario['dtprazoretorno']), 'd/m/Y') : null?></td>
                        <td><?php echo $prontuario['movOrigem'] ?></td>
                    </tr>
                    <?php $totalProntuarios++; ?>
                <?php endforeach; ?>
                <!-- Linha de total para o último setor de destino -->
                <tr>
                    <td colspan="6" class="text-right"><strong>Total Prontuários: <?= $totalProntuarios; ?></strong></td>
                </tr>
                </tbody>
                </table>
        </div>
    </section>
</main>
</body>
<script>
    $(document).ready(function() {
        var previousValue = null;
        $('#table tbody tr').each(function() {
            var currentValue = $(this).find('td:eq(1)').text();
            if (previousValue !== null && currentValue !== previousValue) {
                $('<tr class="tab"><td colspan="10" style="border: 0;"></td></tr>').insertBefore($(this));
            }
            previousValue = currentValue;
        });

        window.onafterprint = function() {
            window.location.href = '<?= base_url("relatorios/prontuariosretidos") ?>';
        };

        window.print();
    });
</script>