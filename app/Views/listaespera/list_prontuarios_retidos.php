<table class="table table-hover table-bordered table-smaller-font table-striped" id="table">
    <thead>
        <tr>
            <th scope="col" colspan="7" class="bg-light text-center"><h5><strong>Prontuários Retidos</strong></h5></th>
        </tr>
        <tr>
            <th scope="col" data-field="setordestino" >Setor Destino</th>
            <th scope="col" data-field="setororigem" >Setor Origem</th>
            <th scope="col" class="col-0" data-field="prontuario" >Prontuário</th>
            <th scope="col" class="col-0" data-field="volume" >Volume</th>
            <th scope="col" data-field="dtmovimentacao" >Data de Movimentação</th>
            <th scope="col" data-field="dtprazoretorno" >Prazo de Retorno</th>
            <th scope="col" data-field="movorigem" >Origem</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($prontuarios as $prontuario): ?>
            <tr>
                <td><?php echo $prontuario['setordestino'] ?></td>
                <td><?php echo $prontuario['setororigem'] ?></td>
                <td>
                    <?php $link = base_url('prontuarios/historico/'.$prontuario['prontuario'].'/'.$prontuario['volume']); ?>
                    <a href="<?php echo $link; ?>" onclick="mostrarAguarde(event, '<?php echo $link; ?>');"><?php echo $prontuario['prontuario']; ?></a>
                </td>
                <td><?php echo $prontuario['volume'] ?></td>
                <td><?php echo date_format(date_create($prontuario['dtmovimentacao']), 'd/m/Y') ?></td>
                <td><?php echo $prontuario['dtprazoretorno'] ? date_format(date_create($prontuario['dtprazoretorno']), 'd/m/Y') : null?></td>
                <td><?php echo $prontuario['movOrigem'] ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<script>
$(document).ready(function() {
    $('#table').DataTable({
        "order": [[0, 'asc', 2, 'asc', 3, 'asc']],
        "lengthChange": false,
        "language": {
            "url": "<?= base_url('assets/DataTables/i18n/pt-BR.json') ?>"
        },
        "columnDefs": [],
        layout: {
            topStart: {
                buttons: [
                    'copy',
                    'csv',
                    'excel',
                    {
                    text: 'PDF',
                    extend: 'pdfHtml5',
                message: '',
                orientation: 'portrait',
                exportOptions: {
                    columns: ':visible'
                },
                customize: function (doc) {
                    //doc.pageMargins = [10,10,10,10];
                    //doc.defaultStyle.fontSize = 7;
                    //doc.styles.tableHeader.fontSize = 7;
                    //doc.styles.title.fontSize = 9;
                    // Remove spaces around page title
                    doc.content[0].text = doc.content[0].text.trim();

                    // Add extra space after last content row
                    var lastContentRow = doc.content[doc.content.length - 1];
                    lastContentRow.table.body.push([{ text: '\n', colSpan: 7, border: [false, false, false, false, false, false, false] }]); // Adjust colSpan as needed
                    lastContentRow.table.body.push([{ text: 'Qtd. de Prontuários Retidos: <?= $qtdTotal?>', colSpan: 7, border: [false, false, false, false, false, false, false] }]);

                    // Create a footer
                    /* doc['footer']=(function(page, pages) {
                        if (page === pages) {
                            return {
                                columns: [
                                    {
                                        text: 'Qtd. de Movimentações entre os Setores: ',
                                        alignment: 'left'
                                    },
                                    {
                                        alignment: 'right',
                                        text: ['page ', { text: page.toString() }, ' of ', { text: pages.toString() }]
                                    }
                                ],
                                margin: [10, 0]
                            };
                        }
                    }); */
                }
    },
                    /* {
                        extend: 'print',
                        customize: function (win) {
                            $(win.document.body).find('thead tr:first-child').hide();

                            // Remove the title
                            $(win.document.body).find('h1').remove();

                            var header = '<div style="text-align: center; margin-bottom: 50px;">' +
                                         '<img src="<?= base_url('assets/img/huap-logo3.png') ?>" style="max-width: 400px; max-height: 500px; float: left; margin-right: 7px;" />' +
                                         '<div style="font-size: 18px; line-height: 2.0;"><br><br><br><strong>Prontuários Retidos</strong.</div>' +
                                         '</div>';
                            $(win.document.body).prepend(header);

                            // Custom footer
                            var footer = '<br><div style="text-align: left; font-size: 14px; margin-top: 10px;"><strong>Qtd. de Prontuários Retidos: <?= $qtdTotal?> <strong></div>';
                            $(win.document.body).append(footer);

                            // Center the table and its content
                            $(win.document.body).css('text-align', 'center');
                            $(win.document.body).find('table').css({
                                'margin': '10 auto',
                                'text-align': 'center'
                            });

                            // Set the row height for all cells
                            $(win.document.body).find('td').each(function() {
                                $(this).css('height', '30px');
                            });

                            $(win.document.body).find('table').find('th:nth-child(-n+2), td:nth-child(-n+2)').addClass('col-left');
                            $(win.document.body).find('table').find('th:nth-last-child(-n+2), td:nth-last-child(-n+2)').addClass('col-1'); // Últimas duas colunas


                            // Adjust title alignment
                            $(win.document.body).find('th').css('text-align', 'center');

                            // Inject custom CSS for additional styles
                            var css = '@page { size: portrait; margin: 20mm; } ' +
                                      'body { font-size: 10pt; display: inline} ' +
                                      'table { width: 100%; margin: 0 auto; text-align: center; } ' +
                                      'table tr { height: 30px; } ' +
                                      'th, td { padding: 5px; }';
                            var head = win.document.head || win.document.getElementsByTagName('head')[0];
                            var style = win.document.createElement('style');
                            style.type = 'text/css';
                            style.media = 'print';
                            if (style.styleSheet) {
                                style.styleSheet.cssText = css;
                            } else {
                                style.appendChild(win.document.createTextNode(css));
                            }
                            head.appendChild(style);
                        }
                    } */
                    {
                        extend: 'print',
                        text: 'Imprimir',
                        action: function ( e, dt, button, config ) {
                            window.location.href = '<?= base_url("relatorios/imprimirprontuariosretidos") ?>';
                        }
                    }
                ]
            }
        }
    });
});
</script>

