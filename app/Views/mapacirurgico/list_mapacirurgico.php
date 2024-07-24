<table class="table table-hover table-bordered table-smaller-font table-striped" id="table">
    <thead>
        <tr>
            <th scope="col" colspan="18" class="bg-light text-start"><h5><strong>Mapa Cirúrgico</strong></h5></th>
        </tr>
        <tr>
            <th scope="col" class="col-0" data-field="id" >Ordem</th>
            <th scope="col" data-field="prontuarioaghu" >Dt/Hr.Inscr.</th>
            <th scope="col" data-field="prontuarioaghu" >Prontuário</th>
            <th scope="col" data-field="prontuarioaghu" >Nome</th>
            <th scope="col" data-field="prontuarioaghu" >Origem</th>
            <th scope="col" data-field="prontuarioaghu" >Fila</th>
            <th scope="col" data-field="prontuarioaghu" >Especialidade</th>
            <th scope="col" data-field="prontuarioaghu" >Procedimento Principal</th>
            <th scope="col" data-field="prontuarioaghu" >CID</th>
            <th scope="col" data-field="prontuarioaghu" >CID Descrição</th>
            <th scope="col" data-field="prontuarioaghu" >Complexidade</th>
            <th scope="col" data-field="prontuarioaghu" >Lateralidade</th>
            <th scope="col" data-field="prontuarioaghu" >Congelação</th>
            <th scope="col" data-field="prontuarioaghu" >Risco</th>
            <th scope="col" data-field="prontuarioaghu" >Dt.Risco</th>
            <th scope="col" data-field="acao" colspan="3" style="text-align: center;">Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($mapacirurgico as $itemmapa): 
            $itemmapa->created_at = \DateTime::createFromFormat('Y-m-d H:i:s', $itemmapa->created_at)->format('d/m/Y H:i');
            $itemmapa->data_risco = $itemmapa->data_risco ? \DateTime::createFromFormat('Y-m-d', $itemmapa->data_risco)->format('d/m/Y') : '';
        ?>
            <tr>
                <td><?php echo $itemmapa->ordem_mapa ?></td>
                <td><?php echo $itemmapa->created_at ?></td>
                <td><?php echo $itemmapa->prontuario ?></td>
                <td><?php echo $itemmapa->nome_paciente ?></td>
                <td><?php echo $itemmapa->origem_descricao ?></td>
                <td><?php echo $itemmapa->fila ?></td>
                <td><?php echo $itemmapa->especialidade_descricao ?></td>
                <td><?php echo $itemmapa->procedimento_principal ?></td>
                <td><?php echo $itemmapa->cid ?></td>
                <td><?php echo $itemmapa->cid_descricao ?></td>
                <td><?php echo $itemmapa->complexidade ?></td>
                <td><?php echo $itemmapa->lateralidade ?></td>
                <td><?php echo $itemmapa->indcongelacao ?></td>
                <td><?php echo $itemmapa->risco_descricao ?></td>
                <td><?php echo $itemmapa->data_risco ?></td>
                <td style="text-align: center; vertical-align: middle;">
                    <?php echo anchor('mapacirurgico/editarmapa/'.$itemmapa->idmapa, '<i class="fas fa-pencil-alt"></i>', array('title' => 'Editar Lista')) ?>
                </td> <td style="text-align: center; vertical-align: middle;">
                    <?php echo anchor('mapacirurgico/enviarmapa/'.$itemmapa->idmapa, '<i class="fa-solid fa-paper-plane"></i>', array('title' => 'Enviar para o Mapa Cirúrgico')) ?>
                </td>
                <?=  session()->set('parametros_consulta_mapa', $data); ?>
                <td style="text-align: center; vertical-align: middle;">
                    <?php echo anchor('mapacirurgico/excluir/'.$itemmapa->idmapa, '<i class="fas fa-trash-alt"></i>', array('title' => 'Excluir Paciente', 'onclick' => 'return confirma_excluir()')) ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<div class="col-md-12">
    <a class="btn btn-warning mt-3" href="<?= base_url('mapacirurgico/consultar') ?>">
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
            { "orderable": false, "targets": [14] },
            /*{ "visible": false, "targets": [0] } */
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

        function loadAsideContent(recordId) {
            $.ajax({
                url: '<?= base_url('mapacirurgico/carregaaside/') ?>' + recordId,
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
            var recordId = data[2];

            loadAsideContent(recordId); 

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
            var recordId = data[2];
            loadAsideContent(recordId);
        }

        // Marcar o primeiro registro como selecionado ao redesenhar a tabela
        table.on('draw.dt', function() {
            markFirstRecordSelected();
        });
    });
</script>

