<?php use App\Libraries\HUAP_Functions; ?>
 
<link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/4.0.1/css/fixedHeader.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/5.0.4/css/fixedColumns.dataTables.min.css">

<script>$('#janelaAguarde').show();</script>

<div class="table-container mt-3">
    <table class="table">
        <thead style="border: 1px solid black;">
            <tr>
                <th scope="row" colspan="21" class="bg-light text-start" >
                    <h5><strong>Requisições Transfusionais</strong></h5>
                </th>
            </tr>
        </thead>
    </table>
    <table class="table table-hover table-bordered table-smaller-font table-striped" id="table">
        <thead>
            <tr>
                <th scope="col" data-field="" >Dt/Hr Requisição</th>
                <th scope="col" data-field="" >Tipo</th>
                <th scope="col" data-field="" >Prontuário</th>
                <th scope="col" data-field="" >Nome</th>
                <th scope="col" data-field="" >Data Nascimento</th>
                <th scope="col" data-field="" >Idade</th>
                <th scope="col" data-field="" >Sexo</th>
                <th scope="col" data-field="" >Leito</th>
                <th scope="col" data-field="" >Unidade</th>
                <th scope="col" data-field="" >Médico Solicitante</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($requisicoes as $requisicao): 
                //$requisicao->created_at = \DateTime::createFromFormat('Y-m-d H:i:s.u', $requisicao->created_at)->format('d/m/Y H:i');
                $createdAt = $requisicao->created_at;
                if (strpos($createdAt, '.') !== false) {
                    $createdAt = explode('.', $createdAt)[0];
                }
                $requisicao->created_at = DateTime::createFromFormat('Y-m-d H:i:s', $createdAt)->format('d/m/Y H:i');
            ?>
                <tr 
                    data-id="<?= $requisicao->idreq ?>" 
                    data-prontuario="<?= $requisicao->prontuario ?>" 
                >
                    <td><?php echo $requisicao->created_at ?></td>
                    <td><?php echo $requisicao->tipotransfusao ?></td>
                    <td><?php echo $requisicao->prontuario ?></td>
                    <td class="break-line" title="<?php echo htmlspecialchars($requisicao->nome_paciente); ?>">
                        <?php echo htmlspecialchars($requisicao->nome_paciente); ?>
                    </td>
                    <td><?php echo $requisicao->dtnascimento ?></td>
                    <td><?php echo $requisicao->idade ?></td>
                    <td><?php echo $requisicao->sexo ?></td>
                    <td class="break-line" title="<?php echo htmlspecialchars($requisicao->leito); ?>">
                        <?php echo htmlspecialchars($requisicao->leito); ?>
                    </td>
                    <?php 
                    $texto = $requisicao->unidade !== null ? htmlspecialchars($requisicao->unidade . ' - ' . $requisicao->andar . 'o. andar') : '';
                    ?>
                    <td class="break-line" <?php if ($texto) echo 'title="'.$texto.'"'; ?>>
                        <?php echo $texto; ?>
                    </td>
                    <td><?php echo $requisicao->medico_solicitante ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="col-md-12 table-actions">
        <a class="btn btn-warning" href="<?= base_url('transfusao/editar') ?>">
            <i class="fa-solid fa-arrow-left"></i> Voltar
        </a>
        <button class="btn btn-primary" id="editar" disabled>
            <!-- <i class="fa-solid fa-magnifying-glass"></i> --> Editar
        </button>
        <button class="btn btn-primary" id="excluir" disabled>
            <!-- <i class="fa-solid fa-paper-plane"></i> --> Excluir
        </button>
        <button class="btn btn-primary" id="imprimir" disabled>
            <!-- <i class="fas fa-pencil-alt"></i> --> Imprimir
        </button>
    </div>
</div>


<script src="https://cdn.datatables.net/fixedheader/4.0.1/js/dataTables.fixedHeader.min.js"></script>
<script src="https://cdn.datatables.net/fixedcolumns/5.0.4/js/dataTables.fixedColumns.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const table = document.getElementById("table");
        const excluir = document.getElementById("excluir");
        const imprimir = document.getElementById("imprimir");
        const editar = document.getElementById("editar");

        let selectedRow = null;

        table.querySelectorAll("tbody tr").forEach(row => {
            row.addEventListener("click", function () {
                if (selectedRow) selectedRow.classList.remove("lineselected");
                
                selectedRow = this;
                //selectedRow.classList.add("selected");
                selectedRow.classList.add("lineselected"); 
                <?php if(HUAP_Functions::tem_permissao('transfusao-atender')) { ?> excluir.disabled = false;  <?php } ?>
                <?php if(HUAP_Functions::tem_permissao('transfusao-atender')) { ?> imprimir.disabled = false; <?php } ?>
                <?php if(HUAP_Functions::tem_permissao('transfusao-atender')) { ?> editar.disabled = false; <?php } ?>
            });
        });

        excluir.addEventListener("click", function () {
            if (selectedRow) {
                const id = selectedRow.dataset.id;
                window.location.href = `/transfusao/excluir/${id}`;
            }
        });

        imprimir.addEventListener("click", function () {
            if (selectedRow) {
                const id = selectedRow.dataset.id;
                window.location.href = `/transfusao/imprimirrequisicao/${id}`;
            }
        });

        editar.addEventListener("click", function () {
            if (selectedRow) {
                const id = selectedRow.dataset.id;
                window.location.href = `/transfusao/editarrequisicao/${id}`;
               //carregarDadosModal(selectedRow);
            }
        });
    });

    function carregarDadosModal(element) {

            prontuario = element.getAttribute('data-prontuario');
            ordem = element.getAttribute('data-ordem');
            fila = element.getAttribute('data-fila'); 
            especialidade = element.getAttribute('data-especialidade'); 
            infoadic = element.getAttribute('data-infoadic');
            risco = element.getAttribute('data-risco'); 
            idprocedimento = element.getAttribute('data-idprocedimento'); 
            procedimento = element.getAttribute('data-procedimento'); 
            cid = element.getAttribute('data-cid'); 
            ciddescr = element.getAttribute('data-ciddescr'); 
            origem = element.getAttribute('data-origem'); 
            unidadeorigem = element.getAttribute('data-unidadeorigem'); 
            complexidade = element.getAttribute('data-complexidade') === 'A' ? 'ALTA'  :
                            element.getAttribute('data-complexidade') === 'M' ? 'MÉDIA'  :
                            element.getAttribute('data-complexidade') === 'B' ? 'BAIXA'  : 'N/D';
            lateralidade = element.getAttribute('data-lateralidade'); 
            congelacao = element.getAttribute('data-congelacao') === 'S' ? 'SIM' : 'NÃO';
            opme = element.getAttribute('data-opme') === 'S' ? 'SIM' :
                    element.getAttribute('data-opme') === 'N' ? 'NÃO' : '';
            dtrisco = element.getAttribute('data-dtrisco');  
            justorig = element.getAttribute('data-justorig');
            tiposangue = element.getAttribute('data-tiposangue'); 
           
            $.ajax({
                url: '/listaespera/carregadadosmodal', // Rota do seu método PHP
                //url: '<--?= base_url('listaespera/carregadadosmodal/') ?>' + prontuario,
                type: 'GET',
                data: { prontuario: prontuario }, 
                dataType: 'json',
                success: function(paciente) {
                    // Função para verificar se o valor é nulo ou vazio
                    function verificarValor(valor) {
                        
                        return (valor === null || valor === '') ? 'N/D' : valor;
                    }

                    function verificarOutroValor(valor) {
                        
                        return (valor === null || valor === '') ? '' : ', ' + valor;
                    }

                    let telefonesHtml = '';
                    
                    if (paciente.contatos && paciente.contatos.length > 0) {
                        // Verifica se há mais de um telefone
                        paciente.contatos.forEach((contato, index) => {
                            const dddFormatado = contato.ddd ? `(${verificarValor(contato.ddd)})` : '';
                            const nroFoneFormatado = verificarValor(contato.nro_fone).replace(/(\d{5})(\d+)/, '$1-$2'); // Adiciona o hífen após o 5º dígito
                            const observacaoFormatada = contato.observacao ? `(${verificarValor(contato.observacao)})` : '';

                            if (paciente.contatos.length > 1) {
                                // Se houver mais de um telefone, exibe o índice
                                telefonesHtml += `<strong>Tel ${index + 1}:</strong> ${dddFormatado} ${nroFoneFormatado} ${observacaoFormatada}<br>`;
                            } else {
                                // Se houver apenas um telefone, não exibe o índice
                                telefonesHtml += `<strong>Tel:</strong> ${dddFormatado} ${nroFoneFormatado} ${observacaoFormatada}<br>`;
                            }
                        });
                    } else {
                        // Se não houver nenhum telefone, exibe "Tel: N/D"
                        telefonesHtml = '<strong>Tel:</strong> N/D<br>';
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
                        <strong>Endereço:</strong> ${verificarValor(paciente.logradouro)}, ${verificarValor(paciente.num_logr)} ${verificarOutroValor(paciente.compl_logr)}<br>
                        <strong>Cidade:</strong> ${verificarValor(paciente.cidade)}<br>
                        <strong>Bairro:</strong> ${verificarValor(paciente.bairro)}<br>
                        <strong>CEP:</strong> ${verificarValor(paciente.cep)}<br>
                        <strong>Email:</strong> ${verificarValor(paciente.email)}<br>
                        ${telefonesHtml}
                    `);

                    $('#colunaEsquerda2').html(`
                        <strong>Ordem na Fila:</strong> ${ordem}<br>
                        <strong>Especialidade:</strong> ${especialidade}<br>
                        <strong>Fila:</strong> ${fila}<br>
                        <strong>Procedimento:</strong> ${idprocedimento} - ${procedimento}<br>
                        <strong>Risco:</strong> ${risco}<br>
                        <strong>Data do Risco:</strong> ${verificarValor(dtrisco)}<br>
                        <strong>CID:</strong> ${verificarValor(cid)} - ${verificarValor(ciddescr)}<br>
                        <strong>Origem:</strong> ${origem}<br>
                        <strong>Unidade Origem:</strong> ${verificarValor(unidadeorigem)}<br>
                    `);

                    // Atualiza o conteúdo do modal para a coluna direita
                    $('#colunaDireita2').html(`
                        <strong>Complexidade:</strong> ${complexidade}<br>
                        <strong>Lateralidade:</strong> ${lateralidade}<br>
                        <strong>Congelação:</strong> ${congelacao}<br>
                        <strong>OPME:</strong> ${verificarValor(opme)}<br>
                        <strong>Tipo Sanguíneo:</strong> ${verificarValor(tiposangue)}<br>
                        <strong>Justificativas da Origem:</strong> ${verificarValor(justorig)}<br>
                        <strong>Informações Adicionais:</strong> ${verificarValor(infoadic)}<br>
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
            /* "lengthChange": true,
            "pageLength": 15,
            "lengthMenu": [[10, 20, 50, 75, -1], [10, 20, 50, 75, "Tudo"]], */
            "language": {
                "url": "<?= base_url('assets/DataTables/i18n/pt-BR.json') ?>"
            },
           /*  "autoWidth": false,  
            "scrollX": true, */ 
            fixedColumns: {
            //leftColumns: 5 // Número de colunas a serem fixadas
            },
            /* paging: true, 
            ordering: true,  */
            fixedHeader: true,
            scrollY: '525px',
            scrollX: true,
            scrollCollapse: true,
            paging: false,
            ordering: true,
            autoWidth: false,
            "columns": [
                //{ "width": "0px" },  // Primeira coluna
                { "width": "120px" },  // 
                { "width": "150px" },  // 
                { "width": "90px" },  // prontuario            
                { "width": "300px" },  // nome 
                { "width": "100px" }, 
                { "width": "70px" },  // idade
                { "width": "100px" }, //Sexo
                { "width": "100px" }, //Leito
                { "width": "250px" }, 
                { "width": "250px" }, // medico
            ],
            "columnDefs": [
            { "orderable": false, "targets": [0, 2, 4] },
            { "visible": false, "targets": [] },
            { "width": "500px", "targets": [] }
            ],
            stateSave: true, // Habilita o salvamento do estado
            layout: { topStart: {
                buttons: [
                {
                    extend: 'colvis', // Botão para exibir/inibir colunas
                    text: 'Colunas', // Texto do botão
                    //columns: ':not(:first-child):not(:nth-child(2)):not(:last-child)' // Opção para ignorar a primeira e segunda coluna
                    columns: ':not(:nth-child(2))' 
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
        }).on('draw.dt', function () {
            $('.DTFC_LeftWrapper thead th tr, .DTFC_RightWrapper thead th').css({
                'background-color': '#ffffff',
                'color': '#000',
                'border-color': '#dee2e6'
            });
        });

        $('#table thead th').css({
            'background-color': '#ffffff', /* Altere para a cor desejada */
            'color': '#000',
            'border-color': '#dee2e6'
        });

        $('#table tbody').on('dblclick', 'tr', function(event) {
            event.preventDefault();
            
            carregarDadosModal(this);

            //$('#modalDetalhes').modal('show');
        });

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
            //markFirstRecordSelected();
        });

    });

</script>