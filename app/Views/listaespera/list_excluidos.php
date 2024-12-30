<script>$('#janelaAguarde').show();</script>

<div class="table-container mt-3">
    <table class="table table-hover table-bordered table-smaller-font table-striped" id="table">
        <thead>
            <tr>
                <th scope="col" colspan="7" class="bg-light text-start"><h5><strong>Pacientes Excluídos</strong></h5></th>
            </tr>
            <tr>
                <th scope="col" data-field="" ></th>
                <!-- <th scope="col" class="col-0" data-field="ordem-lista" title="Ordem de entrada na Fila Cirúrgica">#Lista</th>
                <th scope="col" class="col-0" data-field="ordem-fila" title="Ordem de entrada na Fila Cirúrgica"> #Fila</th> -->
                <th scope="col" data-field="prontuarioaghu" >Dt/Hr.Inscr.</th>
                <th scope="col" data-field="prontuarioaghu" >Prontuário</th>
                <th scope="col" data-field="prontuarioaghu" >Nome</th>
                <th scope="col" data-field="prontuarioaghu" >Fila</th>
                <th scope="col" data-field="prontuarioaghu" >Especialidade</th>
                <th scope="col" data-field="acao" colspan="1" style="text-align: center;">Ação</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($listaespera as $itemlista): 
            //die(var_dump( $itemlista->created_at));
                $itemlista->created_at = \DateTime::createFromFormat('Y-m-d H:i:s', $itemlista->created_at)->format('d/m/Y H:i');
    /*             $itemlista->data_risco = $itemlista->data_risco ? \DateTime::createFromFormat('Y-m-d', $itemlista->data_risco)->format('d/m/Y') : '';
    */        ?>
                <!-- <tr data-ordem="<--?= $itemlista->ordem_fila ?>" data-fila="<--?= $itemlista->fila ?>"> -->
                <tr>
                    <td><?php echo "" ?></td>
                    <!-- <td title="Ordem de entrada na Lista Cirúrgica">--<--?php echo $itemlista->ordem_lista ?></td>
                    <td title="Ordem na Fila Cirúrgica"><--?php echo $itemlista->ordem_fila ?></td> -->
                    <td><?php echo $itemlista->created_at ?></td>
                    <td><?php echo $itemlista->prontuario ?></td>
                    <td><?php echo $itemlista->nome_paciente ?></td>
                    <td><?php echo $itemlista->fila ?></td>
                    <td><?php echo $itemlista->nome_especialidade ?></td>
                    <td style="text-align: center; vertical-align: middle;">
                        <!-- <--?php echo anchor('listaespera/recuperarexcluido/'.$itemlista->id.'/'.$itemlista->ordem_fila, '<i class="fas fa-pencil-alt"></i>', array('title' => 'Recuperar Paciente')) ?> -->
                        <?php echo anchor('listaespera/recuperarexcluido/'.$itemlista->id, '<i class="fa-solid fa-arrow-rotate-left"></i>', array('title' => 'Recuperar Paciente')) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="col-md-12">
        <a class="btn btn-warning mt-3" href="<?= base_url('listaespera/consultarexcluidos') ?>">
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

  window.onload = function() {
    sessionStorage.setItem('previousPage', window.location.href);
  };
    
  $(document).ready(function() {

        var primeiraVez = true;
        var voltarPaginaAnterior = <?= json_encode($data['pagina_anterior']) ?>;

        $('#janelaAguarde').show();

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
                { "width": "0px" },  //
                { "width": "100px" },  // 
                { "width": "90px" },                
                { "width": "400px" },  // 
                { "width": "400px" }, 
                { "width": "400px" }, 
                { "width": "50px" }
            ],
            "columnDefs": [
            { "orderable": false, "targets": [0, 1, 2, 3, 4, 5] },
            { "visible": false, "targets": [0] }
            ],
            layout: { topStart: { buttons: [
                'copy',
                'csv',
                'excel',
                'pdf',
                'print' 
            ] } },
            processing: true, 
            "deferRender": true,
            initComplete: function() {
                $('#janelaAguarde').hide();
            }
        });

        var table = $('#table').DataTable();

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

            var data = table.row(this).data(); // Obtenha os dados da linha clicada
            //var recordId = data[4];
            var recordId = data[2];
            var ordemFila = "Indefinida";
            var fila = data[4];

            //loadAsideContent(recordId, ordemFila, fila); 

        });

        function markFirstRecordSelected() {
            // Obter o índice do primeiro registro na página
            var firstRecordIndex = table.page.info().start;
           // var $firstRecordRow = $(table.row(firstRecordIndex).node());

            // Selecionar a linha correspondente ao índice
            var $firstRecordRow = $(table.row(firstRecordIndex).node());

            // Remover a classe 'selected' de todas as linhas e adicionar ao primeiro registro da página
            $('#table tbody tr').removeClass('lineselected');
            $firstRecordRow.addClass('lineselected');

            //var ordemFila = $firstRecordRow.data('ordem'); 
           
            // Obter os dados do registro selecionado e carregar os detalhes no aside
            var data = table.row(firstRecordIndex).data();

            var recordId = data[2];
            var ordemFila = "Indefinida";
            var fila = data[4];
            //loadAsideContent(recordId, ordemFila, fila);
        }

        // Marcar o primeiro registro como selecionado ao redesenhar a tabela
        table.on('draw.dt', function() {

            if (voltarPaginaAnterior === 'S' && primeiraVez) {
                var paginaAnterior = sessionStorage.getItem('paginaSelecionada');

                if (paginaAnterior !== null) {
                    primeiraVez = false;
                    table.page(parseInt(paginaAnterior)).draw(false);
                }
            } 
            
            var paginaAtual = table.page();
            sessionStorage.setItem('paginaSelecionada', paginaAtual);

            // Chama markFirstRecordSelected, que não deve causar recursão
            markFirstRecordSelected();
        });

    });
</script>

