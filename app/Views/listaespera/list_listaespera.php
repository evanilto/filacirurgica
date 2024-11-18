<?php use App\Libraries\HUAP_Functions; ?>

<script>$('#janelaAguarde').show();</script>

<!-- Modal -->
<div id="modalDetalhes" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detalhes da Linha</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="detalhesLinha">Carregando...</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>


<table class="table table-hover table-bordered table-smaller-font table-striped" id="table">
    <thead>
        <tr>
            <th scope="col" colspan="20" class="bg-light text-start"><h5><strong>Lista de Espera</strong></h5></th>
        </tr>
        <tr>
            <th scope="col" data-field="" ></th>
            <th scope="col" class="col-0" data-field="ordem-lista" title="Ordem de entrada na Lista de Espera">#Lista</th>
            <th scope="col" class="col-0" data-field="ordem-fila" title="Ordem de entrada na Fila Cirúrgica"> #Fila</th>
            <th scope="col" data-field="prontuarioaghu" >Dt/Hr.Inscr.</th>
            <th scope="col" data-field="prontuarioaghu" >Prontuário</th>
            <th scope="col" data-field="prontuarioaghu" >Nome</th>
            <th scope="col" data-field="prontuarioaghu" >Origem</th>
            <th scope="col" data-field="prontuarioaghu" >Fila</th>
            <th scope="col" data-field="prontuarioaghu" >Especialidade</th>
            <th scope="col" data-field="prontuarioaghu" >Procedimento</th>
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
        <?php foreach($listaespera as $itemlista): 
        //die(var_dump( $itemlista->created_at));
            $itemlista->created_at = \DateTime::createFromFormat('Y-m-d H:i:s', $itemlista->created_at)->format('d/m/Y H:i');
            $itemlista->data_risco = $itemlista->data_risco ? \DateTime::createFromFormat('Y-m-d', $itemlista->data_risco)->format('d/m/Y') : '';
        ?>
            <tr data-ordem="<?= $itemlista->ordem_fila ?>" data-fila="<?= $itemlista->fila ?>">
                <td><?php echo "" ?></td>
                <td title="Ordem de entrada na Lista Cirúrgica"><?php echo $itemlista->ordem_lista ?></td>
                <td title="Ordem na Fila Cirúrgica"><?php echo $itemlista->ordem_fila ?></td>
                <td><?php echo $itemlista->created_at ?></td>
                <td><?php echo $itemlista->prontuario ?></td>
                <td><?php echo $itemlista->nome_paciente ?></td>
                <td><?php echo $itemlista->origem_descricao ?></td>
                <td><?php echo $itemlista->fila ?></td>
                <td><?php echo $itemlista->especialidade_descricao ?></td>
                <td><?php echo $itemlista->procedimento_descricao ?></td>
                <td><?php echo $itemlista->cid ?></td>
                <td><?php echo $itemlista->cid_descricao ?></td>
                <td>
                    <?php 
                    switch ($itemlista->complexidade) {
                        case 'A':
                            echo 'ALTA';
                            break;
                        case 'B':
                            echo 'BAIXA';
                            break;
                        case 'M':
                            echo 'MÉDIA';
                            break;
                        default:
                            echo 'Indefinida'; // caso o valor não seja esperado
                            break;
                    }
                    ?>
                </td>
                <td><?php echo $itemlista->nmlateralidade ?></td>
                <td><?php echo $itemlista->indcongelacao == 'S' ? 'SIM' : 'NÃO' ?></td>
                <td><?php echo $itemlista->risco_descricao ?></td>
                <td><?php echo $itemlista->data_risco ?></td>
                <td style="text-align: center; vertical-align: middle;">
                    <?php 
                        if(HUAP_Functions::tem_permissao('listaespera-alterar')) { 
                            echo anchor('listaespera/editarlista/'.$itemlista->id.'/'.$itemlista->ordem_fila, '<i class="fas fa-pencil-alt"></i>', array('title' => 'Editar Lista'));
                        } else {
                            echo '<span style="color: gray; cursor: not-allowed;" title="Você não tem permissão para editar."><i class="fas fa-pencil-alt"></i></span>';
                        } 
                    ?>
                </td> 
                <td style="text-align: center; vertical-align: middle;">
                    <?php
                        if(HUAP_Functions::tem_permissao('listaespera-alterar')) { 
                            echo anchor('listaespera/enviarmapa/'.$itemlista->id, '<i class="fa-solid fa-paper-plane"></i>', array('title' => 'Enviar para o Mapa Cirúrgico', 'onclick' => 'mostrarAguarde(event, this.href)'));
                        } else {
                            echo '<span style="color: gray; cursor: not-allowed;" title="Você não tem permissão para enviar para o mapa cirúrgico."><i class="fas fa-paper-plane"></i></span>';
                        } 
                    ?>
                </td>
                <td style="text-align: center; vertical-align: middle;">
                    <?php
                        if(HUAP_Functions::tem_permissao('listaespera-excluir')) { 
                            echo anchor('listaespera/excluirpaciente/'.$itemlista->id.'/'.$itemlista->ordem_fila, '<i class="fas fa-trash-alt"></i>');
                        } else {
                            echo '<span style="color: gray; cursor: not-allowed;" title="Você não tem permissão para excluir."><i class="fas fa-trash-alt"></i></span>';
                        } 
                    ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<div class="col-md-12">
    <a class="btn btn-warning mt-3" href="<?= base_url('listaespera/consultar') ?>">
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
            "columnDefs": [
            { "orderable": false, "targets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19] },
            { "visible": false, "targets": [0] }
            ],
            layout: { topStart: {
                buttons: [
                {
                    extend: 'colvis', // Botão para exibir/inibir colunas
                    text: 'Colunas', // Texto do botão
                    columns: ':not(:first-child):not(:nth-child(2)):not(:last-child)' // Opção para ignorar a primeira e segunda coluna
                },
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

        table.on('processing.dt', function(e, settings, processing) {
            if (processing) {
                $('#janelaAguarde').show(); // Exibir o modal
            } else {
                $('#janelaAguarde').hide(); // Esconder o modal
            }
        });

        $('#table tbody').on('dblclick', 'tr', function() {
            // Obtenha os dados da linha clicada
            var data = table.row(this).data();

            // Atualize o conteúdo do modal com os detalhes da linha
            $('#detalhesLinha').html(`
                <strong>ID:</strong> ${data[0]}<br>
                <strong>Nome:</strong> ${data[1]}<br>
                <strong>Outro Campo:</strong> ${data[2]}
            `);

            // Exiba o modal
            $('#modalDetalhes').modal('show');
        });

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

            var ordemFila = $(this).data('ordem');
            var fila = $(this).data('fila');
            var data = table.row(this).data(); // Obtenha os dados da linha clicada
            var recordId = data[4];

            loadAsideContent(recordId, ordemFila, fila); 

        });

        function markFirstRecordSelected() {
            // Obter o índice do primeiro registro na página
            var firstRecordIndex = table.page.info().start;
            var $firstRecordRow = $(table.row(firstRecordIndex).node());

            // Selecionar a linha correspondente ao índice
            var $firstRecordRow = $(table.row(firstRecordIndex).node());

            // Remover a classe 'selected' de todas as linhas e adicionar ao primeiro registro da página
            $('#table tbody tr').removeClass('lineselected');
            $firstRecordRow.addClass('lineselected');

            var ordemFila = $firstRecordRow.data('ordem'); 
            var fila = $firstRecordRow.data('fila'); 

            // Obter os dados do registro selecionado e carregar os detalhes no aside
            var data = table.row(firstRecordIndex).data();
            var recordId = data[4];
            loadAsideContent(recordId, ordemFila, fila);
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