<table class="table table-hover table-bordered table-smaller-font table-striped" id="table">
    <thead>
        <tr>
            <th scope="col" colspan="13" class="bg-light text-start"><h5><strong>Situação Cirúrgica</strong></h5></th>
        </tr>
        <tr>
            <th scope="col" data-field="" ></th>
            <th scope="col" data-field="prontuarioaghu" >idLista</th>
            <th scope="col" data-field="prontuarioaghu" >idMapa</th>
            <th scope="col" class="col-0" data-field="id" title="Ordem de entrada na Lista Cirúrgica">Ordem Lista</th>
            <th scope="col" class="col-0" data-field="id" title="Ordem de entrada na Lista Cirúrgica">Ordem Fila</th>
            <th scope="col" data-field="prontuarioaghu" >Dt/Hr.Inscr.</th>
            <th scope="col" data-field="prontuarioaghu" >Prontuário</th>
            <th scope="col" data-field="prontuarioaghu" >Nome</th>
            <th scope="col" data-field="prontuarioaghu" >Especialidade</th>
            <th scope="col" data-field="prontuarioaghu" >Fila</th>
            <th scope="col" data-field="prontuarioaghu" >Dt/Hr Cirurgia</th>
            <th scope="col" data-field="prontuarioaghu" >Situação</th>
            <th scope="col" data-field="acao" colspan="1" style="text-align: center;">Hist.</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($listaespera as $itemlista): 
            $itemlista->created_at = $itemlista->dthrinclusao ? \DateTime::createFromFormat('Y-m-d H:i:s', $itemlista->dthrinclusao)->format('d/m/Y H:i') : '';
            $itemlista->dthrinclusao = $itemlista->dthrinclusao ? \DateTime::createFromFormat('Y-m-d H:i:s', $itemlista->dthrinclusao)->format('d/m/Y H:i') : '';
            $itemlista->datacirurgia = $itemlista->datacirurgia ? \DateTime::createFromFormat('Y-m-d H:i:s', $itemlista->datacirurgia)->format('d/m/Y') : '';
        ?>
            <tr>
                <td><?php echo "" ?></td>
                <td><?php echo $itemlista->idlistaespera ?></td>
                <td><?php echo $itemlista->idmapacirurgico ?? '-' ?></td>
                <td title="Ordem na Lista de Espera"><?php echo $itemlista->ordem_lista ?? '-' ?></td>
                <td title="Ordem na Fila Cirúrgica"><?php echo $itemlista->ordem_fila ?? '-' ?></td>
                <td><?php echo $itemlista->dthrinclusao ?></td>
                <td><?php echo $itemlista->prontuario ?></td>
                <td><?php echo $itemlista->nome ?></td>
                <td><?php echo $itemlista->especialidade ?></td>
                <td><?php echo $itemlista->fila ?></td>
                <td><?php echo $itemlista->datacirurgia ?></td>
                <td><?php echo $itemlista->status ?></td>
                <td style="text-align: center; vertical-align: middle;">
                    <?php
                    $queryString = http_build_query(['dados' => $itemlista]);
                    $url = base_url('mapacirurgico/exibirhistorico/') . $itemlista->idlistaespera . '?' . $queryString;
                    echo anchor($url, '<i class="fa-solid fa-timeline"></i>', [
                        'title' => 'Histórico de Atividades',
                        'onclick' => 'mostrarAguarde(event, this.href)'
                    ]);
                     ?>
                </td>
                <?=  session()->set('parametros_consulta_lista', $data); ?>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<div class="col-md-12">
    <a class="btn btn-warning mt-3" href="<?= base_url('listaespera/situacaocirurgica') ?>">
        <i class="fa-solid fa-arrow-left"></i> Voltar
    </a>
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

  function confirma_excluir () {
        if (!confirm('Confirma a exclusão desse paciente da lista de espera?')) {
            return false;
        };
        
        return true;
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

            var data = table.row(this).data(); // Obtenha os dados da linha clicada
            var ordemFila = data[4];
            var fila = data[9];
            var recordId = data[6];

            loadAsideContent(recordId, ordemFila, fila); 

        });

        function markFirstRecordSelected() {
            // Obter o índice do primeiro registro na página
            var firstRecordIndex = table.page.info().start;
            // Selecionar a linha correspondente ao índice
            var $firstRecordRow = $(table.row(firstRecordIndex).node());

            // Remover a classe 'selected' de todas as linhas e adicionar ao primeiro registro da página
            $('#table tbody tr').removeClass('lineselected');
            $firstRecordRow.addClass('lineselected');

            // Obter os dados do registro selecionado e carregar os detalhes no aside
            var data = table.row(firstRecordIndex).data();
            var recordId = data[6];
            var ordemFila = data[4]; 
            var fila = data[9] 
            
            loadAsideContent(recordId, ordemFila, fila);
        }

        // Marcar o primeiro registro como selecionado ao redesenhar a tabela
        table.on('draw.dt', function() {
            markFirstRecordSelected();
        });

    });
</script>

