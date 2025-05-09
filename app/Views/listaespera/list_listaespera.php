<?php use App\Libraries\HUAP_Functions; ?>
 
<link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/4.0.1/css/fixedHeader.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/5.0.4/css/fixedColumns.dataTables.min.css">

<script>$('#janelaAguarde').show();</script>

<div class="table-container mt-4">
    <table class="table">
        <thead style="border: 1px solid black;">
            <tr>
                <th scope="row" colspan="20" class="bg-light text-start" >
                    <h5><strong>Fila Cirúrgica</strong></h5>
                </th>
            </tr>
        </thead>
    </table>
    <table class="table table-hover table-bordered table-smaller-font table-striped" id="table">
        <thead>
            <tr>
                <th scope="col" data-field="" ></th>
                <th scope="col" class="col-0" data-field="ordem-lista" title="Ordem de entrada na Fila Cirúrgica">#Lista</th>
                <th scope="col" class="col-0" data-field="ordem-fila" title="Ordem de entrada na Fila Cirúrgica"> #Fila</th>
                <th scope="col" data-field="prontuarioaghu" >Dt/Hr.Inscr.</th>
                <th scope="col" data-field="prontuarioaghu" >Prontuário</th>
                <th scope="col" data-field="prontuarioaghu" >Nome</th>
                <th scope="col" data-field="prontuarioaghu" >Especialidade</th>
                <th scope="col" data-field="prontuarioaghu" >Fila</th>
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
                <th scope="col" data-field="prontuarioaghu" >OPME</th>
                <th scope="col" data-field="prontuarioaghu" >Dt.Risco</th>
                <th scope="col" data-field="tiposangue" >Tipo Sanguíneo</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($listaespera as $itemlista): 
                $itemlista->created_at = \DateTime::createFromFormat('Y-m-d H:i:s', $itemlista->created_at)->format('d/m/Y H:i');
                $itemlista->data_risco = $itemlista->data_risco ? \DateTime::createFromFormat('Y-m-d', $itemlista->data_risco)->format('d/m/Y') : '';
            ?>
                <tr data-id="<?= $itemlista->id ?>" 
                    data-ordem="<?= $itemlista->ordem_fila ?>" 
                    data-fila="<?= $itemlista->fila ?>"
                    data-prontuario="<?= $itemlista->prontuario ?>" 
                    data-ordem="<?= $itemlista->ordem_fila ?>" 
                    data-fila="<?= $itemlista->fila ?>" 
                    data-especialidade="<?= $itemlista->especialidade_descricao ?>" 
                    data-justorig="<?= htmlspecialchars($itemlista->just_orig, ENT_QUOTES, 'UTF-8') ?>" 
                    data-risco="<?= $itemlista->risco_descricao ?>" 
                    data-idprocedimento="<?= $itemlista->idprocedimento ?>" 
                    data-procedimento="<?= $itemlista->procedimento_descricao ?>" 
                    data-cid="<?= $itemlista->cid_codigo ?>" 
                    data-ciddescr="<?= $itemlista->cid_descricao ?>" 
                    data-origem="<?= $itemlista->origem_descricao ?>" 
                    data-complexidade="<?= $itemlista->complexidade ?>" 
                    data-lateralidade="<?= $itemlista->nmlateralidade ?>" 
                    data-congelacao="<?= $itemlista->indcongelacao ?>" 
                    data-opme="<?= $itemlista->opme ?>" 
                    data-dtrisco="<?= $itemlista->data_risco ?>" 
                    data-tiposangue="<?= $itemlista->tiposanguineo ?>"
                    data-infoadic="<?= htmlspecialchars($itemlista->info_adicionais, ENT_QUOTES, 'UTF-8') ?>" 
                >
                    <td><?php echo $itemlista->ordem_lista ?></td>
                    <td title="Ordem de entrada na Lista Cirúrgica"><?php echo $itemlista->ordem_lista ?></td>
                    <td title="Ordem na Fila Cirúrgica"><?php echo $itemlista->ordem_fila ?></td>
                    <td><?php echo $itemlista->created_at ?></td>
                    <td><?php echo $itemlista->prontuario ?></td>
                    <td class="break-line" title="<?php echo htmlspecialchars($itemlista->nome_paciente); ?>">
                        <?php echo htmlspecialchars($itemlista->nome_paciente); ?>
                    </td>
                    <td class="break-line" title="<?php echo htmlspecialchars($itemlista->especialidade_descricao); ?>">
                        <?php echo htmlspecialchars($itemlista->especialidade_descricao); ?>
                    </td>
                    <td class="break-line" title="<?php echo htmlspecialchars($itemlista->fila); ?>">
                        <?php echo htmlspecialchars($itemlista->fila); ?>
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
                    <td class="break-line"><?php echo $itemlista->cid_codigo ?></td>
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
                    <td class="break-line"><?php echo $itemlista->opme == 'S' ? 'SIM' : ($itemlista->opme == 'N' ? 'NÃO' : '') ?></td>
                    <td><?php echo $itemlista->data_risco ?></td>
                    <td><?php echo $itemlista->tiposanguineo ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="col-md-12 table-actions">
        <a class="btn btn-warning" href="<?= base_url('listaespera/consultar') ?>">
            <i class="fa-solid fa-arrow-left"></i> Voltar
        </a>
        <button class="btn btn-primary" id="enviar" disabled>
            <!-- <i class="fa-solid fa-paper-plane"></i> --> Enviar para Mapa
        </button>
        <button class="btn btn-primary" id="editar" disabled>
            <!-- <i class="fas fa-pencil-alt"></i> --> Editar
        </button>
        <button class="btn btn-primary" id="excluir" disabled>
            <!-- <i class="fas fa-trash-alt"></i> --> Excluir
        </button>
        <button class="btn btn-primary" id="consultar" disabled>
            <!-- <i class="fa-solid fa-magnifying-glass"></i> --> Consultar
        </button>

    </div>
</div>


<script src="https://cdn.datatables.net/fixedheader/4.0.1/js/dataTables.fixedHeader.min.js"></script>
<script src="https://cdn.datatables.net/fixedcolumns/5.0.4/js/dataTables.fixedColumns.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const table = document.getElementById("table");
        const editar = document.getElementById("editar");
        const enviar = document.getElementById("enviar");
        const excluir = document.getElementById("excluir");
        const consultar = document.getElementById("consultar");

        let selectedRow = null;

        table.querySelectorAll("tbody tr").forEach(row => {
            row.addEventListener("click", function () {
                if (selectedRow) selectedRow.classList.remove("lineselected");
                
                selectedRow = this;
                //selectedRow.classList.add("selected");
                selectedRow.classList.add("lineselected"); 
                <?php if(HUAP_Functions::tem_permissao('listaespera-alterar') || HUAP_Functions::tem_permissao('exames')) { ?> editar.disabled = false;  <?php } ?>
                <?php if(HUAP_Functions::tem_permissao('listaespera-enviar') || HUAP_Functions::tem_permissao('exames')) { ?> enviar.disabled = false; <?php } ?>
                <?php if(HUAP_Functions::tem_permissao('listaespera-excluir') || HUAP_Functions::tem_permissao('exames')) { ?> excluir.disabled = false; <?php } ?>
                <?php if(HUAP_Functions::tem_permissao('listaespera-consultar') || HUAP_Functions::tem_permissao('exames')) { ?> consultar.disabled = false; <?php } ?>
            });
        });

        editar.addEventListener("click", function () {
            if (selectedRow) {
                const id = selectedRow.dataset.id;
                window.location.href = `/listaespera/editarlista/${id}`;
            }
        });

        enviar.addEventListener("click", function () {
            if (selectedRow) {
                const id = selectedRow.dataset.id;
                window.location.href = `/listaespera/enviarmapa/${id}`;
            }
        });

        excluir.addEventListener("click", function () {
            if (selectedRow) {
                const id = selectedRow.dataset.id;
                window.location.href = `/listaespera/excluirpaciente/${id}`;
            }
        });

        consultar.addEventListener("click", function () {
            if (selectedRow) {
               carregarDadosModal(selectedRow);
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

    function confirma_excluir () {
        if (!confirm('Confirma a exclusão desse paciente da Fila Cirúrgica?')) {
            return false;
        };
        
        return true;
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
            leftColumns: 5 // Número de colunas a serem fixadas
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
                { "width": "0px" },  // Primeira coluna
                { "width": "90px" },  // Lista
                { "width": "60px" },  // Fila
                { "width": "130px" },                
                { "width": "100px" },  // prontuario
                { "width": "300px" }, 
                { "width": "200px" },  // especialidade
                { "width": "250px" }, 
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
                { "width": "110px" },
                { "width": "90px" }, // dt risco
                { "width": "100px" } // tipo sangue

            ],
            "columnDefs": [
            { "orderable": false, "targets": [0, 2, 4, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19] },
            { "visible": false, "targets": [0] },
            { "width": "500px", "targets": [8] }
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