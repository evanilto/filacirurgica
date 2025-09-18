<?php use App\Libraries\HUAP_Functions; ?>

<?php 
    function formatarData($data, $formato = 'd/m/Y') {
        if (!$data) return '';
        
        $dt = \DateTime::createFromFormat('Y-m-d H:i:s', $data);
        
        return $dt instanceof \DateTime ? $dt->format($formato) : '';
    }
?>
 
<link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/4.0.1/css/fixedHeader.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/5.0.4/css/fixedColumns.dataTables.min.css">

<script>$('#janelaAguarde').show();</script>

<div class="table-container mt-4">
    <table class="table">
        <thead style="border: 1px solid black;">
            <tr>
                <th scope="row" class="bg-light text-start" >
                    <h5><strong>Cirurgias</strong></h5>
                </th>
            </tr>
        </thead>
    </table>
    <table class="table table-hover table-bordered table-smaller-font table-striped" id="table">
        <thead>
            <tr>
                <th scope="col" data-field="prontuarioaghu" >Código Cirurgia/PDT</th>
                <th scope="col" data-field="prontuarioaghu" >Seq Descr Cirúrgica</th>
                <th scope="col" data-field="prontuarioaghu" >Tipo</th>
                <th scope="col" data-field="prontuarioaghu" >Situação Cirúrgica</th>
                <th scope="col" data-field="prontuarioaghu" >Nome</th>
                <th scope="col" data-field="prontuarioaghu" >Prontuário</th>
                <th scope="col" data-field="prontuarioaghu" >Data Nascimento</th>
                <th scope="col" data-field="prontuarioaghu" >Contatos</th>
                <th scope="col" data-field="prontuarioaghu" >Data Internação</th>
                <th scope="col" data-field="prontuarioaghu" >Motivo Internação</th>
                <th scope="col" data-field="prontuarioaghu" >Data Cirurgia/PDT</th>
                <th scope="col" data-field="prontuarioaghu" >Cirurgião/Executor</th>
                <th scope="col" data-field="prontuarioaghu" >Anestesista</th>     
                <th scope="col" data-field="prontuarioaghu" >Especialidade Cirúrgica</th>
                <th scope="col" data-field="prontuarioaghu" >Procedimento</th>
                <th scope="col" data-field="prontuarioaghu" >Potencial Contaminação</th>
                <th scope="col" data-field="prontuarioaghu" >Início</th>
                <th scope="col" data-field="prontuarioaghu" >Fim</th>                
                <th scope="col" data-field="prontuarioaghu" >Data Alta</th>
                <th scope="col" data-field="prontuarioaghu" >Indicação PDT</th>
                <th scope="col" data-field="prontuarioaghu" >Descrição Cirúrgica</th>
                <th scope="col" data-field="meddia" >Antimicrobianos no dia</th>
                <th scope="col" data-field="meddia" >ATB 24h</th>
                <th scope="col" data-field="meddia" >ATB 48h</th>
                <th scope="col" data-field="meddia" >ATB 30 d</th>
                <th scope="col" data-field="gmr" >Colonização MDR</th>
                <th scope="col" data-field="matusu" >Materiais Utilizados</th>
                <th scope="col" data-field="" >Evo. Hosp. 30 d</th>
                <th scope="col" data-field="" >Evo. Hosp. 30 d-p. chave</th>
                <th scope="col" data-field="" >Evo. Hosp. 90 d</th>
                <th scope="col" data-field="" >Evo. Hosp. 90 d-p. chave</th>
                <th scope="col" data-field="" >Evo. Amb. 30 d</th>
                <th scope="col" data-field="" >Evo. Amb. 30 d-p. chave</th>
                <th scope="col" data-field="" >Evo. Amb. 90 d</th>
                <th scope="col" data-field="" >Evo. Amb. 90 d-p. chave</th>
                <th scope="col" data-field="" >Culturas 30 d</th>
                <th scope="col" data-field="" >Culturas 90 d</th>

            </tr>
        </thead>
        <tbody>
            <?php foreach($cirurgias as $cirurgia): 
           
                $dt_nascimento       = formatarData($cirurgia->dt_nascimento);
                $dt_cirurgia         = formatarData($cirurgia->data_cirurgia);
                $hr_inicio_cirurgia  = formatarData($cirurgia->dthr_inicio_cirurgia, 'H:i');
                $hr_fim_cirurgia     = formatarData($cirurgia->dthr_fim_cirurgia, 'H:i');
                $dt_internacao       = formatarData($cirurgia->dthr_internacao);
                $dt_alta       = formatarData($cirurgia->dthr_alta_medica);
            
                $contatos = !empty($cirurgia->contatos) ? implode(', ', array_map(fn($c) => "({$c->ddd}){$c->nro_fone}", $cirurgia->contatos)) : 'N/D';

                // Equipe --------------------------------------------------------------------
                if ($cirurgia->tipo_cir == 'PDT') {
                    $nomes = array_map('trim', explode(',', $cirurgia->eqp_pdt ?? ''));
                    $potencialcontaminacao = $cirurgia->potencial_contaminacao_pdt;
                    $situacao_descr = $cirurgia->situacao_descr_pdt;
                } else {
                    $nomes = array_map('trim', explode(',', $cirurgia->eqp_cir ?? ''));
                    $potencialcontaminacao = $cirurgia->potencial_contaminacao_cir;
                    $situacao_descr = $cirurgia->situacao_descr_cir;
                }

                $cirg = array_map(
                    fn($n) => substr($n, 5),
                    array_filter($nomes, fn($n) => str_starts_with($n, 'CIRG:'))
                );

                $aux = array_map(
                    fn($n) => substr($n, 5),
                    array_filter($nomes, fn($n) => str_starts_with($n, 'ANES:'))
                );

                 $cirurgioes = implode(', ', $cirg) ?: 'N/D';
                 $anestesistas = implode(', ', $aux) ?: 'N/D';
            ?>
                <tr
                    data-cod_pac="<?= $cirurgia->codigo ?>" 
                    data-crg_seq="<?= $cirurgia->crg_seq ?>"
                >
                    <td><?php echo $cirurgia->crg_seq ?></td>
                    <td><?php echo $cirurgia->dcrg_seqp ?></td>
                    <td><?php echo $cirurgia->tipo_cir ?></td>
                    <td><?php echo $cirurgia->situacao_cir ?></td>
                    <td><?php echo $cirurgia->nome ?></td>
                    <td><?php echo $cirurgia->prontuario ?></td>
                    <td><?php echo $dt_nascimento ?></td>
                    <td class="break-line" title="<?php echo htmlspecialchars($contatos); ?>">
                        <?php echo htmlspecialchars($contatos ?: 'N/D'); ?>
                    </td>
                    <td><?php echo $dt_internacao ?: 'N/D';?></td>
                    <td class="break-line" title="<?php echo htmlspecialchars($cirurgia->aih_sintomas); ?>">
                        <?php echo htmlspecialchars($cirurgia->aih_sintomas ?: 'N/D'); ?>
                    </td>
                    <td><?php echo $dt_cirurgia ?></td>
                    <td class="break-line" title="<?php echo htmlspecialchars($cirurgioes); ?>">
                        <?php echo htmlspecialchars($cirurgioes ?: 'N/D'); ?>
                    </td>
                    <td class="break-line" title="<?php echo htmlspecialchars($anestesistas); ?>">
                        <?php echo htmlspecialchars($anestesistas ?: 'N/D'); ?>
                    </td>
                    <td class="break-line" title="<?php echo htmlspecialchars($cirurgia->nome_especialidade); ?>">
                        <?php echo htmlspecialchars($cirurgia->nome_especialidade); ?>
                    </td>
                    <td class="break-line" title="<?php echo htmlspecialchars($cirurgia->procedimento_cirurgia); ?>">
                        <?php echo htmlspecialchars($cirurgia->procedimento_cirurgia); ?>
                    </td>
                    <td class="break-line" title="<?php echo htmlspecialchars($potencialcontaminacao); ?>">
                        <?php echo htmlspecialchars($potencialcontaminacao ?: 'N/D'); ?>
                    </td>
                    <td><?php echo $hr_inicio_cirurgia ?></td>
                    <td><?php echo $hr_fim_cirurgia ?></td>
                    <td><?php echo $dt_alta ?: 'N/D';?></td>
                    <td class="break-line" title="<?php echo htmlspecialchars($cirurgia->indicacao_pdt); ?>">
                        <?php echo htmlspecialchars($cirurgia->indicacao_pdt ?: 'N/D'); ?>
                    <td><?php echo $situacao_descr ?></td>
                    <td><?= htmlspecialchars($cirurgia->antimicrobianos_dia) ?></td>
                    <td><?= htmlspecialchars($cirurgia->antimicrobianos_24h) ?></td>
                    <td><?= htmlspecialchars($cirurgia->antimicrobianos_48h) ?></td>
                    <td><?= htmlspecialchars($cirurgia->antimicrobianos_30d) ?></td>
                    <td><?= htmlspecialchars($cirurgia->gmr) ?></td>
                    <td class="break-line" title="<?php echo htmlspecialchars($cirurgia->materiais_usados); ?>">
                        <?php echo htmlspecialchars($cirurgia->materiais_usados); ?>
                    </td>
                    <td class="break-line" title="<?php echo htmlspecialchars($cirurgia->evolint_30d); ?>">
                        <?php echo htmlspecialchars($cirurgia->evolint_30d); ?>
                    </td>
                    <td class="break-line" title="<?php echo htmlspecialchars($cirurgia->palavras_encontradas_evolint_30d); ?>">
                        <?php echo htmlspecialchars($cirurgia->palavras_encontradas_evolint_30d); ?>
                    </td>  
                    <td class="break-line" title="<?php echo htmlspecialchars($cirurgia->evolint_90d); ?>">
                        <?php echo htmlspecialchars($cirurgia->evolint_90d); ?>
                    </td>
                    <td class="break-line" title="<?php echo htmlspecialchars($cirurgia->palavras_encontradas_evolint_90d); ?>">
                        <?php echo htmlspecialchars($cirurgia->palavras_encontradas_evolint_90d); ?>
                    </td>    
                    <td class="break-line" title="<?php echo htmlspecialchars($cirurgia->evolamb_30d); ?>">
                        <?php echo htmlspecialchars($cirurgia->evolamb_30d); ?>
                    </td>
                    <td class="break-line" title="<?php echo htmlspecialchars($cirurgia->palavras_encontradas_evolamb_30d); ?>">
                        <?php echo htmlspecialchars($cirurgia->palavras_encontradas_evolamb_30d); ?>
                    </td>  
                    <td class="break-line" title="<?php echo htmlspecialchars($cirurgia->evolamb_90d); ?>">
                        <?php echo htmlspecialchars($cirurgia->evolamb_90d); ?>
                    </td>
                    <td class="break-line" title="<?php echo htmlspecialchars($cirurgia->palavras_encontradas_evolamb_90d); ?>">
                        <?php echo htmlspecialchars($cirurgia->palavras_encontradas_evolamb_90d); ?>
                    </td>            
                    <td class="break-line" title="<?php echo htmlspecialchars($cirurgia->cultura_30d); ?>">
                        <?php echo htmlspecialchars($cirurgia->cultura_30d); ?>
                    </td>      
                     <td class="break-line" title="<?php echo htmlspecialchars($cirurgia->cultura_90d); ?>">
                        <?php echo htmlspecialchars($cirurgia->cultura_90d); ?>
                    </td>   
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="col-md-12 table-actions">
        <a class="btn btn-warning" href="<?= base_url('relatorios/potencialcontaminacao') ?>">
            <i class="fa-solid fa-arrow-left"></i> Voltar
        </a>
    </div>
</div>


<script src="https://cdn.datatables.net/fixedheader/4.0.1/js/dataTables.fixedHeader.min.js"></script>
<script src="https://cdn.datatables.net/fixedcolumns/5.0.4/js/dataTables.fixedColumns.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        /* const table = document.getElementById("table");
        const editar = document.getElementById("editar");
        const enviar = document.getElementById("enviar");
        const excluir = document.getElementById("excluir");
        const consultar = document.getElementById("consultar"); */

        let selectedRow = null;

        table.querySelectorAll("tbody tr").forEach(row => {
            row.addEventListener("click", function () {
                if (selectedRow) selectedRow.classList.remove("lineselected");
                
                selectedRow = this;
                //selectedRow.classList.add("selected");
                selectedRow.classList.add("lineselected"); 
               /*  <-?php if(HUAP_Functions::tem_permissao('listaespera-alterar')) { ?> editar.disabled = false;  <-?php } ?>
                <-?php if(HUAP_Functions::tem_permissao('listaespera-enviar')) { ?> enviar.disabled = false; <-?php } ?>
                <-?php if(HUAP_Functions::tem_permissao('listaespera-excluir')) { ?> excluir.disabled = false; <-?php } ?>
                <-?php if(HUAP_Functions::tem_permissao('listaespera-consultar')) { ?> consultar.disabled = false; <-?php } ?> */
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
            justorig = element.getAttribute('data-justorig')
           
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
                    `);

                    // Atualiza o conteúdo do modal para a coluna direita
                    $('#colunaDireita2').html(`
                        <strong>CID:</strong> ${verificarValor(cid)} - ${verificarValor(ciddescr)}<br>
                        <strong>Origem:</strong> ${origem}<br>
                        <strong>Complexidade:</strong> ${complexidade}<br>
                        <strong>Lateralidade:</strong> ${lateralidade}<br>
                        <strong>Congelação:</strong> ${congelacao}<br>
                        <strong>OPME:</strong> ${verificarValor(opme)}<br>
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
            "order": [[0, 'asc'], [1, 'asc']],
            /* "lengthChange": true,
            "pageLength": 15,
            "lengthMenu": [[10, 20, 50, 75, -1], [10, 20, 50, 75, "Tudo"]], */
            "language": {
                "url": "<?= base_url('assets/DataTables/i18n/pt-BR.json') ?>"
            },
           /*  "autoWidth": false,  
            "scrollX": true, */ 
           /*  fixedColumns: {
            leftColumns: 5 // Número de colunas a serem fixadas
            }, */
            /* paging: true, 
            ordering: true,  */
            fixedHeader: true,
            scrollY: '525px',
            scrollX: true,
            scrollCollapse: true,
            paging: false,
            ordering: true,
            stateSave: false, // Desabilita estado salvo para evitar que ordem antiga sobrescreva
            autoWidth: false,
            "columns": [
                { "width": "120px" },  // Lista
                { "width": "120px" },  // seq
                { "width": "70px" },  // tipo procedimento
                { "width": "120px" },  // sit cir
                { "width": "300px" },  // nome
                { "width": "120px" },  // pront
                { "width": "100px" },  // dt nasc
                { "width": "250px" },  // contat
                { "width": "100px" },  // dt int
                { "width": "300px" },  // motivo
                { "width": "120px" },  // dt cir
                { "width": "300px" },  // cirurgiao
                { "width": "300px" },  // Anestisista
                { "width": "300px" },  // especialidade
                { "width": "300px" },  // procedimento
                { "width": "200px" },  // pot contam
                { "width": "100px" },  // inicio
                { "width": "100px" },  // fim
                { "width": "100px" },  // dt alta
                { "width": "300px" },  // indic pdt
                { "width": "150px" },  // descr cir
                { "width": "300px" },  // Antimicr dia
                { "width": "300px" },  // Antimicr 24h
                { "width": "300px" },  // Antimicr 28h
                { "width": "300px" },  // Antimicr 30d
                { "width": "300px" },  // Gmr
                { "width": "300px" },  // Materiais usados
                { "width": "300px" },  // evol hosp 30 dias
                { "width": "150px" },  // evol hosp 30 dias palavra chave
                { "width": "300px" },  // evol hosp 90 dias
                { "width": "150px" },  // evol hosp 90 dias palavra chave
                { "width": "300px" },  // evol amb 30 dias
                { "width": "150px" },  // evol amb 30 dias palavra chave
                { "width": "300px" },  // evol amb 30 dias
                { "width": "150px" },  // evol amb 30 dias palavra chave
                { "width": "300px" },  // culturas 30 dias
                { "width": "300px" },  // culturas 90 dias

            ],
            "columnDefs": [
           // { "orderable": false, "targets": [] },
            { "visible": false, "targets": [0, 1] },
            ],
            layout: { topStart: {
                buttons: [
                {
                    extend: 'colvis', // Botão para exibir/inibir colunas
                    text: 'Colunas', // Texto do botão
                    //columns: ':not(:first-child):not(:nth-child(2)):not(:last-child)' // Opção para ignorar a primeira e segunda coluna
                    //columns: ':not(:first-child)' 
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