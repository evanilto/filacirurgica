<?php use App\Libraries\HUAP_Functions; ?>

<script>$('#janelaAguarde').show();</script>

<div class="table-container">
    <table class="table table-hover table-bordered table-smaller-font table-striped" id="table">
        <thead>
            <tr>
                <th scope="col" colspan="23" class="bg-light text-start"><h5><strong>Lista de Espera</strong></h5></th>
            </tr>
            <tr>
                <th scope="col" data-field="" ></th>
                <th scope="col" class="col-0" data-field="ordem-lista" title="Ordem de entrada na Lista de Espera">#Lista</th>
                <th scope="col" class="col-0" data-field="ordem-fila" title="Ordem de entrada na Fila Cirúrgica"> #Fila</th>
                <th scope="col" data-field="prontuarioaghu" >Dt/Hr.Inscr.</th>
                <th scope="col" data-field="prontuarioaghu" >Prontuário</th>
                <th scope="col" data-field="prontuarioaghu" >Nome</th>
                <th scope="col" data-field="prontuarioaghu" >Fila</th>
                <th scope="col" data-field="prontuarioaghu" >Especialidade</th>
                <th scope="col" data-field="prontuarioaghu" >Informações Adicionais</th>
                <th scope="col" data-field="prontuarioaghu" >Risco</th>
                <th scope="col" data-field="prontuarioaghu" >Procedimento</th>
                <th scope="col" data-field="prontuarioaghu" >CID</th>
                <th scope="col" data-field="prontuarioaghu" >CID Descrição</th>
                <th scope="col" data-field="prontuarioaghu" >Origem</th>
                <th scope="col" data-field="prontuarioaghu" >Justificativas da Origem</th>
                <th scope="col" data-field="prontuarioaghu" >Complexidade</th>
                <th scope="col" data-field="prontuarioaghu" >Lateralidade</th>
                <th scope="col" data-field="prontuarioaghu" >Congelação</th>
                <th scope="col" data-field="prontuarioaghu" >Dt.Risco</th>
                <th scope="col" data-field="acao" colspan="4" style="text-align: center;">Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($listaespera as $itemlista): 
                $itemlista->created_at = \DateTime::createFromFormat('Y-m-d H:i:s', $itemlista->created_at)->format('d/m/Y H:i');
                $itemlista->data_risco = $itemlista->data_risco ? \DateTime::createFromFormat('Y-m-d', $itemlista->data_risco)->format('d/m/Y') : '';
            ?>
                <tr data-ordem="<?= $itemlista->ordem_fila ?>" data-fila="<?= $itemlista->fila ?>">
                    <td><?php echo "" ?></td>
                    <td title="Ordem de entrada na Lista Cirúrgica"><?php echo $itemlista->ordem_lista ?></td>
                    <td title="Ordem na Fila Cirúrgica"><?php echo $itemlista->ordem_fila ?></td>
                    <td><?php echo $itemlista->created_at ?></td>
                    <td><?php echo $itemlista->prontuario ?></td>
                    <td class="break-line" title="<?php echo htmlspecialchars($itemlista->nome_paciente); ?>">
                        <?php echo htmlspecialchars($itemlista->nome_paciente); ?>
                    </td>
                    <td class="break-line" title="<?php echo htmlspecialchars($itemlista->fila); ?>">
                        <?php echo htmlspecialchars($itemlista->fila); ?>
                    </td>
                    <td class="break-line" title="<?php echo htmlspecialchars($itemlista->especialidade_descricao); ?>">
                        <?php echo htmlspecialchars($itemlista->especialidade_descricao); ?>
                    </td>
                    <td class="break-line" title="<?php echo htmlspecialchars($itemlista->info_adicionais); ?>">
                        <?php echo htmlspecialchars($itemlista->info_adicionais); ?>
                    </td>
                    <td class="break-line" title="<?php echo htmlspecialchars($itemlista->risco_descricao); ?>">
                        <?php echo htmlspecialchars($itemlista->risco_descricao); ?>
                    </td>
                    <td class="break-line" title="<?php echo htmlspecialchars($itemlista->procedimento_descricao); ?>">
                        <?php echo htmlspecialchars($itemlista->procedimento_descricao); ?>
                    </td>
                    <td class="break-line"><?php echo $itemlista->cid ?></td>
                    <td class="break-line" title="<?php echo htmlspecialchars($itemlista->cid_descricao); ?>">
                        <?php echo htmlspecialchars($itemlista->cid_descricao); ?>
                    </td>
                    <td class="break-line" title="<?php echo htmlspecialchars($itemlista->origem_descricao); ?>">
                        <?php echo htmlspecialchars($itemlista->origem_descricao); ?>
                        <td class="break-line" title="<?php echo htmlspecialchars($itemlista->just_orig); ?>">
                        <?php echo htmlspecialchars($itemlista->just_orig); ?>
                    </td>
                    </td>
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
                    <td class="break-line"><?php echo $itemlista->nmlateralidade ?></td>
                    <td class="break-line"><?php echo $itemlista->indcongelacao == 'S' ? 'SIM' : 'NÃO' ?></td>
                    
                    <td><?php echo $itemlista->data_risco ?></td>
                    <td style="text-align: center; vertical-align: middle;">
                        <?php 
                            if(HUAP_Functions::tem_permissao('listaespera-alterar')) { 
                                echo anchor('listaespera/editarlista/'.$itemlista->id.'/'.$itemlista->ordem_fila, '<i class="fas fa-pencil-alt"></i>', array('title' => 'Editar Paciente da Lista'));
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
                                echo anchor('listaespera/excluirpaciente/'.$itemlista->id.'/'.$itemlista->ordem_fila, '<i class="fas fa-trash-alt"></i>', 'title="Excluir Paciente da Lista"');
                            } else {
                                echo '<span style="color: gray; cursor: not-allowed;" title="Você não tem permissão para excluir."><i class="fas fa-trash-alt"></i></span>';
                            } 
                        ?>
                    </td>
                    <td style="text-align: center; vertical-align: middle;">
                        <?php
                            if(HUAP_Functions::tem_permissao('listaespera-consultar')) { 
                                //echo anchor('listaespera/excluirpaciente/'.$itemlista->id.'/'.$itemlista->ordem_fila, '<i class="fas fa-trash-alt"></i>');
                                echo '<a href="#" title="Detalhes do Paciente"
                                 data-prontuario="' . $itemlista->prontuario . '"
                                 data-ordem="' . $itemlista->ordem_fila . '"
                                 data-fila="' . $itemlista->fila . '"
                                 data-especialidade="' . $itemlista->especialidade_descricao . '"
                                 data-justorig="' . htmlspecialchars($itemlista->just_orig, ENT_QUOTES, 'UTF-8') . '"
                                 data-risco="' . $itemlista->risco_descricao . '"
                                 data-procedimento="' . $itemlista->procedimento_descricao . '"
                                 data-cid="' . $itemlista->cid . '"
                                 data-ciddescr="' . $itemlista->cid_descricao . '"
                                 data-origem="' . $itemlista->origem_descricao . '"
                                 data-complexidade="' . $itemlista->complexidade . '"
                                 data-lateralidade="' . $itemlista->nmlateralidade . '"
                                 data-congelacao="' . $itemlista->indcongelacao . '"
                                 data-dtrisco="' . $itemlista->data_risco . '"
                                 data-infoadic="' . htmlspecialchars($itemlista->info_adicionais, ENT_QUOTES, 'UTF-8') . '"
                                 onclick="consultaDetalhes(this);"><i class="fa-solid fa-magnifying-glass"></i></a>';
                            } else {
                                echo '<span style="color: gray; cursor: not-allowed;" title="Você não tem permissão para consultar."><i class="fa-solid fa-magnifying-glass"></i></span>';
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

    function carregarDadosModal(dados) {

            var prontuario = dados[0];
            var ordem = dados[1];
            var fila = dados[2];
            var especialidade = dados[3];
            var infoadic = dados[4];
            var risco = dados[5];
            var procedimento = dados[6];
            var cid = dados[7];
            var ciddescr = dados[8];
            var origem = dados[9];
            var justorig = dados[10];
            var complexidade = dados[11];
            var lateralidade = dados[12];
            var congelacao = dados[13];
            var dtrisco = dados[14];

            $.ajax({
                url: '/listaespera/carregadadosmodal', // Rota do seu método PHP
                //url: '<--?= base_url('listaespera/carregadadosmodal/') ?>' + prontuario,
                type: 'GET',
                data: { prontuario: prontuario }, // Envia o ID como parâmetro
                dataType: 'json',
                success: function(paciente) {
                    // Função para verificar se o valor é nulo ou vazio
                    function verificarValor(valor) {
                        
                        return (valor === null || valor === '') ? 'N/D' : valor;
                    }

                    function verificarOutroValor(valor) {
                        
                        return (valor === null || valor === '') ? '' : ', ' + valor;
                    }

                    // Atualiza o conteúdo do modal para a coluna esquerda
                    $('#colunaEsquerda1').html(`
                        <strong>Prontuario:</strong> ${verificarValor(paciente.prontuario)}<br>
                        <strong>Nome:</strong> ${verificarValor(paciente.nome)}<br>
                        <strong>Nome da Mãe:</strong> ${verificarValor(paciente.nm_mae)}<br>
                        <strong>Sexo:</strong> ${verificarValor(paciente.sexo)}<br>
                        <strong>Data Nascimento:</strong> ${verificarValor(paciente.dt_nascimento)}<br>
                        <strong>Idade:</strong> ${verificarValor(paciente.idade)}<br>
                        <strong>CPF:</strong> ${verificarValor(paciente.cpf)}<br>
                        <strong>CNS:</strong> ${verificarValor(paciente.cns)}<br>
                    `);

                    // Atualiza o conteúdo do modal para a coluna direita
                    $('#colunaDireita1').html(`
                        <strong>Tel. Residencial:</strong> ${verificarValor(paciente.tel_1)}<br>
                        <strong>Tel. Recados:</strong> ${verificarValor(paciente.tel_2)}<br>
                        <strong>Email:</strong> ${verificarValor(paciente.email)}<br>
                        <strong>Endereço:</strong> ${verificarValor(paciente.logradouro)}, ${verificarValor(paciente.num_logr)} ${verificarOutroValor(paciente.compl_logr)}<br>
                        <strong>Cidade:</strong> ${verificarValor(paciente.cidade)}<br>
                        <strong>Bairro:</strong> ${verificarValor(paciente.bairro)}<br>
                        <strong>CEP:</strong> ${verificarValor(paciente.cep)}<br>
                    `);
                    $('#colunaEsquerda2').html(`
                        <strong>Ordem na Fila:</strong> ${ordem}<br>
                        <strong>Fila:</strong> ${fila}<br>
                        <strong>Especialidade:</strong> ${especialidade}<br>
                        <strong>Procedimento:</strong> ${procedimento}<br>
                        <strong>Risco:</strong> ${risco}<br>
                        <strong>Data do Risco:</strong> ${verificarValor(dtrisco)}<br>
                        <strong>Informações Adicionais:</strong> ${verificarValor(infoadic)}<br>
                    `);

                    // Atualiza o conteúdo do modal para a coluna direita
                    $('#colunaDireita2').html(`
                        <strong>CID:</strong> ${verificarValor(cid)}<br>
                        <strong>CID Descrição:</strong> ${verificarValor(ciddescr)}<br>
                        <strong>Origem:</strong> ${origem}<br>
                        <strong>Justificativas da Origem:</strong> ${verificarValor(justorig)}<br>
                        <strong>Complexidade:</strong> ${complexidade}<br>
                        <strong>Lateralidade:</strong> ${lateralidade}<br>
                        <strong>Congelação:</strong> ${congelacao}<br>
                    `);

                    $('#linha').html(`
                    `);

                    // Mostra o modal
                    $('#modalDetalhes').modal('show');
                },
                error: function(xhr, status, error) {
                    console.error('Erro ao carregar os dados:', error);
                }
            });
    }

    function consultaDetalhes(element) {
            // Recupera os atributos data-* do elemento clicado
            //const prontuario = element.getAttribute('data-prontuario');

            var dadosLista = [
                element.getAttribute('data-prontuario'), // Prontuario
                element.getAttribute('data-ordem'), // Ordem
                element.getAttribute('data-fila'), // Fila
                element.getAttribute('data-especialidade'), // Especialidade
                element.getAttribute('data-infoadic'), // Informação Adicional
                element.getAttribute('data-risco'), // Risco
                element.getAttribute('data-procedimento'), // Procedimento
                element.getAttribute('data-cid'), // CID
                element.getAttribute('data-ciddescr'), // Descrição do CID
                element.getAttribute('data-origem'), // Origem
                element.getAttribute('data-complexidade') === 'A' ? 'ALTA' :
                element.getAttribute('data-complexidade') === 'M' ? 'MÉDIA' :
                element.getAttribute('data-complexidade') === 'B' ? 'BAIXA' : 'N/D',
                element.getAttribute('data-lateralidade'), // Lateralidade
                element.getAttribute('data-congelacao') === 'S' ? 'SIM' : 'NÃO', // Congelação
                element.getAttribute('data-dtrisco'),  // Data de Risco
                element.getAttribute('data-justorig')
            ];

            carregarDadosModal(dadosLista);
    }
    
  $(document).ready(function() {

        $('#table tbody').on('mouseenter', 'td.break-line', function() {
            var $this = $(this); 
            
            // Verifica se o conteúdo do texto ultrapassa a largura visível da célula
            if ($this[0].scrollWidth > $this.innerWidth()) {
                var tooltip = $('<div class="tooltip"></div>')
                    .text($this.attr('title')) // Usa o atributo title para o texto do tooltip
                    .appendTo('body');
                    
                // Posições o tooltip
                tooltip.css({ 
                    top: $this.offset().top + $this.outerHeight() + 10, // Posiciona abaixo da célula
                    left: $this.offset().left
                }).fadeIn('slow');

                $this.data('tooltip', tooltip); // Salva o tooltip na célula
            } else {
                $(this).data('tooltip', null); // Garante que o tooltip não seja salvo se não necessário
            }

        }).on('mouseleave', 'td.break-line', function() {
            var tooltip = $(this).data('tooltip'); // Recupera o tooltip salvo
            if (tooltip) {
                tooltip.remove(); // Remove o tooltip ao sair
            }
        }).on('mousemove', 'td.break-line', function(e) {
            var tooltip = $(this).data('tooltip'); // Recupera o tooltip
            if (tooltip) {
                tooltip.css({ // Move o tooltip conforme o mouse
                    top: e.pageY + 10,
                    left: e.pageX + 10
                });
            }
        });

        var primeiraVez = true;
        var voltarPaginaAnterior = <?= json_encode($data['pagina_anterior']) ?>;

        $('#janelaAguarde').show();

        $('[data-toggle="tooltip"]').tooltip();

        $('#table').DataTable({
            "order": [[0, 'asc']],
            "lengthChange": true,
            "pageLength": 16,
            "lengthMenu": [[10, 20, 50, 75, -1], [10, 20, 50, 75, "Tudo"]],
            "language": {
                "url": "<?= base_url('assets/DataTables/i18n/pt-BR.json') ?>"
            },
            "autoWidth": false,  /* Desative a largura automática */
            "scrollX": true,  /* Ative a rolagem horizontal */
            "columns": [
                { "width": "0px" },  // Primeira coluna
                null,
                null,
                { "width": "115px" },                
                { "width": "100px" },  // prontuario
                { "width": "300px" }, 
                { "width": "300px" },  // fila
                { "width": "190px" }, 
                { "width": "300px" },  // infoadicionais
                { "width": "120px" },  // risco
                { "width": "300px" },
                { "width": "60px"  },   // CID
                { "width": "300px" },
                { "width": "140px" },
                { "width": "300px" },
                { "width": "120px" }, // complex
                { "width": "150px" },
                { "width": "110px" },
                { "width": "90px" }, // dt risco
                { "width": "35px" },
                { "width": "35px" },
                { "width": "35px" },
                { "width": "35px" }

            ],
            "columnDefs": [
            { "orderable": false, "targets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19] },
            { "visible": false, "targets": [0] },
            { "width": "500px", "targets": [8] }
            ],
            layout: { topStart: {
                buttons: [
                {
                    extend: 'colvis', // Botão para exibir/inibir colunas
                    text: 'Colunas', // Texto do botão
                    //columns: ':not(:first-child):not(:nth-child(2)):not(:last-child)' // Opção para ignorar a primeira e segunda coluna
                    columns: ':not(:nth-child(2)):not(:last-child)' 
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
                $('#table tbody tr td').addClass('break-line');
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

        $('#table tbody').on('dblclick', 'tr', function(event) {
            event.preventDefault();
            
            // Obtenha os dados da linha clicada
            var data = table.row(this).data();

            if (data[2] == 0) {
                data[2] = '-';
            }

            var dadosLista = [
                    data[4], // Prontuario
                    data[2], // Ordem
                    data[6], // Fila
                    data[7], // Especialidade
                    data[8], // Informação Adicional
                    data[9], // Risco
                    data[10], // Procedimento
                    data[11], // CID
                    data[12], // Descrição do CID
                    data[13], // Origem
                    data[14], // Complexidade
                    data[15], // Lateralidade
                    data[16], // Congelação
                    data[17],  // Data de Risco
                    data[18]  // Just Orig
                ];

            //alert(prontuario);
            carregarDadosModal(dadosLista);

            //$('#modalDetalhes').modal('show');
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

           /*  var ordemFila = $(this).data('ordem');
            var fila = $(this).data('fila');
            var data = table.row(this).data(); // Obtenha os dados da linha clicada
            var recordId = data[4];
 */
            //loadAsideContent(recordId, ordemFila, fila); 

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