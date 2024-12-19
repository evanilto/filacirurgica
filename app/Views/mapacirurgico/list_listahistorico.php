<div class="table-container tabela-60 mt-5 mb-5">
    <table class="table table-hover table-bordered table-smaller-font table-striped" id="table">
        <thead>
            <tr>
                <th scope="col" colspan="4" class="bg-light text-start"><h5><strong>Histórico de Atividades</strong></h5></th>
            </tr>
            <tr>
                <th scope="col" data-field="" ></th>
                <th scope="col" data-field="prontuarioaghu" >Dt/Hr Evento</th>
                <th scope="col" data-field="prontuarioaghu" >Evento</th>
                <th scope="col" data-field="prontuarioaghu" >Usuário</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($historico as $itemhistorico): 
                $itemhistorico->dthrevento = \DateTime::createFromFormat('Y-m-d H:i:s', $itemhistorico->dthrevento)->format('d/m/Y H:i');
            ?>
                <tr data-ordem="<?= $data['ordem_fila']?>" data-fila="<?= $data['fila'] ?>" data-prontuario="<?= $data['prontuario'] ?>">
                    <td><?php echo "" ?></td>
                    <td><?php echo $itemhistorico->dthrevento ?></td>
                    <td><?php echo $itemhistorico->nmevento ?></td>
                    <td><?php echo $itemhistorico->idlogin ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="col-md-12">
        <a class="btn btn-warning mt-3" href="<?= base_url('listaespera/exibirsituacao') ?>">
            <i class="fa-solid fa-arrow-left"></i> Voltar
        </a>
    </div>
</div>
<script>
  function mostrarAguarde(event, href) {
    event.preventDefault(); // Prevenir o comportamento padrão do link
    $('#janelaAguarde').show();

    // Redirecionar para o link após um pequeno atraso (1 segundo)
    setTimeout(function() {
      window.location.href = href;
    }, 1000);
  }
      
  $(document).ready(function() {
        $('#table').DataTable({
            "order": [[0, 'asc']],
            "lengthChange": true,
            "pageLength": 15,
            "lengthMenu": [[10, 20, 50, 75, -1], [10, 20, 50, 75, "Tudo"]],
            "language": {
                "url": "<?= base_url('assets/DataTables/i18n/pt-BR.json') ?>"
            },
            "autoWidth": false,  /* Desative a largura automática */
            "scrollX": true,  /* Ative a rolagem horizontal */
            "columns": [
                { "width": "0px" },                
                { "width": "90px" },                
                { "width": "300px" }, 
                { "width": "100px" }
            ],
            "columnDefs": [
            /* { "orderable": false, "targets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11] }, */
            { "visible": false, "targets": [0] }
            ],
            layout: { topStart: { buttons: [
                'copy',
                'csv',
                'excel',
                'pdf',
                'print' 
            ] } }
        });

        var table = $('#table').DataTable();
        var firstRecordId;

        function loadAsideContent(prontuario, ordem, fila) {
            $.ajax({
                url: '<?= base_url('listaespera/carregaaside/') ?>' + prontuario + '/' + ordem + '/' + fila,
                method: 'GET',
                beforeSend: function() {
                    $('#sidebar').html('<p>Carregando...</p>'); // Mostrar mensagem de carregando
                },
                success: function(response) {
                    $('#sidebar').html(response); // Atualizar o conteúdo do sidebar
                },
                error: function(xhr, status, error) {
                    var errorMessage = 'Erro ao carregar os detalhes: ' + status + ' - ' + error;
                    console.error(errorMessage);
                    console.error(xhr.responseText);
                    $('#sidebar').html('<p>' + errorMessage + '</p><p>' + xhr.responseText + '</p>');
                }
            });
        }

        $('#table tbody').on('click', 'tr', function() {

            $(this).toggleClass('lineselected').siblings().removeClass('lineselected');
            /* $('#table tbody tr').removeClass('lineselected');
            $(this).addClass('lineselected'); */

            //var $selectedRow = $('tr.lineselected'); 
            
            var ordemFila = $firstRecordRow.data('ordem'); // 'ordem-fila' se torna 'ordem'
            var fila = $firstRecordRow.data('fila');
            var prontuario =$firstRecordRow.data('prontuario');

            loadAsideContent(prontuario, ordemFila, fila); 

        });

        function markFirstRecordSelected() {
            // Obter o índice do primeiro registro na página
            var firstRecordIndex = table.page.info().start;
            // Selecionar a linha correspondente ao índice
            var $firstRecordRow = $(table.row(firstRecordIndex).node());

            // Remover a classe 'selected' de todas as linhas e adicionar ao primeiro registro da página
            $('#table tbody tr').removeClass('lineselected');
            //$firstRecordRow.addClass('lineselected');

           /*  var data = table.row(firstRecordIndex).data();
            var ordemFila = data.ordem_fila;
            var fila = data.fila; 
            var prontuario = data.prontuario; */

            var ordemFila = $firstRecordRow.data('ordem'); // 'ordem-fila' se torna 'ordem'
            var fila = $firstRecordRow.data('fila');
            var prontuario =$firstRecordRow.data('prontuario');

            loadAsideContent(prontuario, ordemFila, fila);
        }

        // Marcar o primeiro registro como selecionado ao redesenhar a tabela
        table.on('draw.dt', function() {
            markFirstRecordSelected();
        });

    });
</script>

