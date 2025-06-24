<?= csrf_field() ?>
<?php $validation = \Config\Services::validation(); ?>

<div class="container mt-4 mb-4">
    <div class="card form-container">
        <div class="card-header text-center text-black">
            <b>Requisição Transfusional</b>
        </div>

        <div class="card-body has-validation">
            <form id="formTransfusao" method="post" action="<?= base_url('transfusao/salvar') ?>">
                <!-- Dados do Paciente -->
                <div class="row g-3">
                    <div class="col-md-1">
                        <div class="mb-2">
                            <label for="prontuario" class="form-label">Prontuario<b class="text-danger">*</b></label>
                            <div class="input-group">
                                <input type="text" id="prontuario" maxlength="8" inputmode="numeric" pattern="\d*" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 8);"
                                class="form-control <?php if($validation->getError('prontuario')): ?>is-invalid<?php endif ?>"
                                name="prontuario" value="<?= set_value('prontuario', isset($idprontuario) ? $idprontuario : '') ?>" <?= isset($idprontuario) ? 'readonly' : '' ?> />
                                <?php if ($validation->getError('prontuario')): ?>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('prontuario') ?>
                                        </div>
                                    <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="mb-2">
                            <label for="nome" class="form-label">Nome do Paciente</b></label>
                            <div class="input-group mb-12">
                                <input type="text" id="nome" maxlength="100" 
                                class="form-control <?php if($validation->getError('nome')): ?>is-invalid<?php endif ?>"
                                name="nome" value="<?= set_value('nome') ?>" readonly/>
                                <?php if ($validation->getError('nome')): ?>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('nome') ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 mb-2">
                        <label class="form-label">Data Nascimento<b class="text-danger">*</b></label>
                        <div class="input-group mb-12">
                            <input type="text" name="dtnascimento" id="dtnascimento" class="form-control <?= $validation->hasError('dtnascimento') ? 'is-invalid' : '' ?>" value="<?= set_value('dtnascimento') ?>" disabled/>
                        </div>
                        <div class="invalid-feedback"><?= $validation->getError('dtnascimento') ?></div>
                    </div>
                    <div class="col-md-2 mb-2">
                        <label class="form-label">Sexo<b class="text-danger">*</b></label>
                        <div class="input-group mb-12">
                            <input type="text" name="sexo" id="sexo" class="form-control <?= $validation->hasError('sexo') ? 'is-invalid' : '' ?>" value="<?= set_value('sexo') ?>" disabled/>
                        </div>
                        <div class="invalid-feedback"><?= $validation->getError('sexo') ?></div>
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-md-4 mb-2">
                        <label class="form-label">Enfermaria<b class="text-danger">*</b></label>
                        <div class="input-group mb-12">
                            <input type="text" name="enfermaria" class="form-control <?= $validation->hasError('enfermaria') ? 'is-invalid' : '' ?>" value="<?= set_value('enfermaria') ?>" disabled/>
                        </div>
                        <div class="invalid-feedback"><?= $validation->getError('enfermaria') ?></div>
                    </div>
                    <div class="col-md-2 mb-2">
                        <label class="form-label">Andar<b class="text-danger">*</b></label>
                        <div class="input-group mb-12">
                            <input type="text" name="andar" class="form-control <?= $validation->hasError('andar') ? 'is-invalid' : '' ?>" value="<?= set_value('andar') ?>" disabled/>
                        </div>
                        <div class="invalid-feedback"><?= $validation->getError('andar') ?></div>
                    </div>
                    <div class="col-md-4 mb-2">
                        <label class="form-label">Leito<b class="text-danger">*</b></label>
                        <div class="input-group mb-12">
                            <input type="text" name="leito" class="form-control <?= $validation->hasError('leito') ? 'is-invalid' : '' ?>" value="<?= set_value('leito') ?>" disabled/>
                        </div>
                        <div class="invalid-feedback"><?= $validation->getError('leito') ?></div>
                    </div>
                </div>
                <!-- Diagnóstico e Indicação -->
                <div class="row g-3">
                    <div class="col-md-2 mb-2">
                        <label class="form-label">Peso (Kg)</label>
                        <div class="input-group mb-12">
                            <input type="number" step="0.1" name="peso" class="form-control" value="<?= set_value('peso') ?>" />
                        </div>
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="mb-2">
                            <label class="form-label" for="diagnostico">Diagnóstico</label>
                            <div class="input-group mb-12">
                                <textarea id="diagnostico" maxlength="250" rows="3"
                                        class="form-control <?= isset($validation) && $validation->getError('diagnostico') ? 'is-invalid' : '' ?>"
                                        name="diagnostico"><?= isset($data['diagnostico']) ? $data['diagnostico'] : '' ?></textarea>
                                <?php if (isset($validation) && $validation->getError('diagnostico')): ?>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('diagnostico') ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-2">
                            <label class="form-label" for="indicacao">Indicação</label>
                            <div class="input-group mb-12">
                                <textarea id="indicacao" maxlength="250" rows="3"
                                        class="form-control <?= isset($validation) && $validation->getError('indicacao') ? 'is-invalid' : '' ?>"
                                        name="indicacao"><?= isset($data['indicacao']) ? $data['indicacao'] : '' ?></textarea>
                                <?php if (isset($validation) && $validation->getError('indicacao')): ?>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('indicacao') ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-md-12">
                        <div class="mb-2">
                            <label for="listapaciente" class="form-label">Cirurgia<b class="text-danger">*</b></label>
                            <select class="form-select select2-dropdown <?php if($validation->getError('listapaciente')): ?>is-invalid<?php endif ?>" 
                            id="listapaciente" name="listapaciente">
                                <option value="">Selecione uma opção</option>
                                <!-- As opções serão preenchidas dinamicamente -->
                            </select>
                            <?php if ($validation->getError('listapaciente')): ?>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('listapaciente') ?>
                                    </div>
                                <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Dados laboratoriais -->
                <div class="row g-3">
                    <div class="col-md-12" id="hemocomp-section">
                        <div class="mb-2">
                            <label class="form-label">Dados Laboratoriais</label>
                            <div class="bordered-container p-3">
                                <div class="row g-2">
                                    <div class="col-md-2"><label>Hematócrito (%)</label><input type="number" step="0.1" name="hematocrito" class="form-control" value="<?= set_value('hematocrito') ?>"></div>
                                    <div class="col-md-2"><label>Hemoglobina (g/dL)</label><input type="number" step="0.1" name="hemoglobina" class="form-control" value="<?= set_value('hemoglobina') ?>"></div>
                                    <div class="col-md-2"><label>TAP (seg)</label><input type="number" step="0.1" name="tap" class="form-control" value="<?= set_value('tap') ?>"></div>
                                    <div class="col-md-2"><label>PTT (seg)</label><input type="number" step="0.1" name="ptt" class="form-control" value="<?= set_value('ptt') ?>"></div>
                                    <div class="col-md-2"><label>INR</label><input type="number" step="0.01" name="inr" class="form-control" value="<?= set_value('inr') ?>"></div>
                                    <div class="col-md-2"><label>Fibrinogênio (mg/dL)</label><input type="number" name="fibrinogenio" class="form-control" value="<?= set_value('fibrinogenio') ?>"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Hemocomponentes -->
                 <div class="row g-3">
                    <div class="col-md-12" id="hemocomp-section">
                        <div class="mb-2">
                            <label class="form-label">Hemocomponentes (unid/ml)</label>
                            <div class="bordered-container p-3">
                                <div class="row g-2">
                                    <div class="col-md-3"><label>CH - Concentrado de Hemácias</label><input type="number" step="1" name="ch" class="form-control" value="<?= set_value('ch') ?>"></div>
                                    <div class="col-md-3"><label>CP - Concentrado de Plaquetas</label><input type="number" step="1" name="cp" class="form-control" value="<?= set_value('cp') ?>"></div>
                                    <div class="col-md-3"><label>PFC - Plasma Fresco Congelado</label><input type="number" step="1" name="pfc" class="form-control" value="<?= set_value('pfc') ?>"></div>
                                    <div class="col-md-3"><label>Crioprecipitado</label><input type="number" step="1" name="crio" class="form-control" value="<?= set_value('crio') ?>"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Procedimentos Especiais -->
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="mb-2">
                            <label class="form-label">Procedimentos Especiais</label>
                            <div class="bordered-container p-3">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="procedimento_filtrado" value="1" <?= set_checkbox('procedimento_filtrado', '1') ?>>
                                    <label class="form-check-label">Filtrado</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="procedimento_irradiado" value="1" <?= set_checkbox('procedimento_irradiado', '1') ?>>
                                    <label class="form-check-label">Irradiado</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="procedimento_lavado" value="1" <?= set_checkbox('procedimento_lavado', '1') ?>>
                                    <label class="form-check-label">Lavado</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tipo de Transfusão -->
                     <div class="col-md-6">
                        <div class="mb-2">
                            <label class="form-label">Tipo de Transfusão</label>
                            <div class="bordered-container p-3">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="tipo_transfusao" value="rotina" <?= set_radio('tipo_transfusao', 'rotina') ?>>
                                    <label class="form-check-label">Rotina (até 24h)</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="tipo_transfusao" value="urgencia" <?= set_radio('tipo_transfusao', 'urgencia') ?>>
                                    <label class="form-check-label">Urgência (até 3h)</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="tipo_transfusao" value="emergencia" <?= set_radio('tipo_transfusao', 'emergencia') ?>>
                                    <label class="form-check-label">Emergência (sem compatibilidade)</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Observações -->
                <div class="mb-3">
                    <label class="form-label">Observações</label>
                    <textarea class="form-control" rows="3" name="observacoes"><?= set_value('observacoes') ?></textarea>
                </div>

                <!-- Ações -->
                <div class="text-center">
                    <button class="btn btn-success" type="submit">
                        <i class="fa-solid fa-floppy-disk"></i> Salvar
                    </button>
                    <a href="<?= base_url('transfusao') ?>" class="btn btn-warning">
                        <i class="fa-solid fa-arrow-left"></i> Voltar
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>
<script>
    window.onload = function() {
        const inputs = document.querySelectorAll('input, select, .form-check-input');
        inputs.forEach(input => {
            input.addEventListener('keydown', disableEnter);
        });
    };

    function confirma(button) {
        event.preventDefault(); // Previne a submissão padrão do formulário

        const equipamentos = $('#eqpts').val();

        if (equipamentos && equipamentos.length > 0) {

            const form = button.form;

            const dtcirurgia = form.querySelector('input[name="dtcirurgia"]').value;

            let equipamentosSelecionados = [];
            $('#eqpts option:selected').each(function() {
                let id = $(this).val();
                let qtd = $(this).data('qtd');
                equipamentosSelecionados.push({ id: id, qtd: qtd });
            });

            // Objeto de dados para enviar ao servidor
            const data = {
                dtcirurgia: dtcirurgia,
                equipamentos: equipamentosSelecionados // Adiciona os equipamentos ao JSON
            };

            if (!dtcirurgia || dtcirurgia.trim() === "") {
                return true;
            } else {
                const xhr = new XMLHttpRequest();
                xhr.open('POST', '<?= base_url('listaespera/verificaequipamentos') ?>', true); 
                xhr.setRequestHeader('Content-Type', 'application/json');
                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                
                xhr.onload = function() {
                    if (xhr.status >= 200 && xhr.status < 400) {
                        const response = JSON.parse(xhr.responseText);

                        if (response.success) {
                            Swal.fire({
                                title: 'Limite excedido para reserva de equipamento. A cirurgia ficará pendente de aprovação pela equipe cirúrgica. Deseja prosseguir mesmo assim?',
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonText: 'Ok',
                                cancelButtonText: 'Cancelar'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $('#idsituacao_cirurgia_hidden').val('EA'); // Em Aprovação
                                    $('#janelaAguarde').show();
                                    $('#idForm').off('submit'); 
                                    $('#idForm').submit(); 
                                } else {
                                    $('#janelaAguarde').hide();
                                }
                            });
                        } else {
                            $('#janelaAguarde').show();
                            $('#idForm').off('submit'); 
                            $('#idForm').submit();        
                        }
                    } else {
                        console.error('Erro ao enviar os dados:', xhr.statusText);
                        alert('Erro na comunicação com o servidor.');
                        $('#janelaAguarde').hide();
                        return false;  
                    }
                };

                xhr.onerror = function() {
                    console.error('Erro ao enviar os dados:', xhr.statusText);
                    alert('Erro na comunicação com o servidor.');
                    $('#janelaAguarde').hide();
                    return false;
                };

                // Envia os dados como JSON, incluindo equipamentos
                xhr.send(JSON.stringify(data));
            }
        } else {
            $('#janelaAguarde').show();
            $('#idForm').off('submit'); 
            $('#idForm').submit(); 
        }
    }

    /* let tipoSanguineoOriginal = $('#tipo_sanguineo_original').val();
    let alteracaoConfirmada =  $('#tipo_sanguineo_confirmado').val() == '1';
    let carregandoInicial = false; */

    function fetchPacienteNome(prontuarioValue) {
        if (!prontuarioValue) {
            document.getElementById('nome').value = '';
            return;
        }

        // Controle para evitar múltiplas requisições
        let isSyncInProgress = false;

        fetch('<?= base_url('listaespera/getnomepac/') ?>' + prontuarioValue, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Erro ao buscar nome do paciente');
            }
            return response.json();
        })
        .then(data => {
            if (data.nome) {
                // Paciente encontrado, atualiza o campo
                document.getElementById('nome').value = data.nome;
                document.getElementById('sexo').value = data.sexo;
                document.getElementById('dtnascimento').value = data.dtnascimento;
               
            } else {
                // Paciente não encontrado, exibe modal para sincronizar
                document.getElementById('nome').value = data.error || 'Nome não encontrado';

                Swal.fire({
                    title: 'Paciente não localizado na base local! <br>Deseja sincronizar com a base do AGHUX?',
                    text: 'Obs: isso pode levar alguns minutos',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ok',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed && !isSyncInProgress) {
                        // Prevenir chamadas duplicadas
                        isSyncInProgress = true;

                        $('#janelaAguarde').show();

                        fetch('<?= base_url('listaespera/sincronizaraghux/') ?>' + prontuarioValue, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            }
                        })
                        .then(syncResponse => {
                            if (!syncResponse.ok) {
                                throw new Error('Erro na sincronização');
                            }
                            return syncResponse.json();
                        })
                        .then(syncData => {
                            Swal.fire({
                                title: 'Sincronização concluída!',
                                text: 'Os dados foram atualizados com sucesso.',
                                icon: 'success'
                            });
                            if (syncData.nome) {
                                document.getElementById('nome').value = syncData.nome;
                            } else {
                                document.getElementById('nome').value = 'Não encontrado após sincronização';
                            }
                        })
                        .catch(syncError => {
                            console.error('Erro na sincronização:', syncError);
                            Swal.fire({
                                title: 'Erro',
                                text: 'Não foi possível sincronizar os dados.',
                                icon: 'error'
                            });
                        })
                        .finally(() => {
                            isSyncInProgress = false; // Sincronização concluída ou falhou
                            $('#janelaAguarde').hide(); // Ocultar indicador de carregamento
                        });
                    }
                });
            }
        })
        .catch(error => {
            console.error('Erro ao buscar nome do paciente:', error);
            document.getElementById('nome').value = '';
            Swal.fire({
                title: 'Erro',
                text: 'Houve um problema ao buscar os dados do paciente. Tente novamente.',
                icon: 'error'
            });
        });
    }
    
    

    function updatelistapaciente(prontuario, valorSelecionado = null) {

        const listapacienteSelect = document.getElementById('listapaciente');

        listapacienteSelect.innerHTML = '<option value="">Selecione uma opção</option>'; 

        //alert(valorSelecionado);

        if (prontuario) {

            $('#janelaAguarde').show();

            $.ajax({
                url: '<?= base_url('mapacirurgico/getcirurgias') ?>',
                type: 'POST',
                data: {prontuario: prontuario},
                dataType: 'json',
                success: function(data) {
                    //listapacienteSelect.innerHTML = '<option value="">Selecione uma opção</option>'; // Adiciona o placeholder
                    const option = document.createElement("option"); // Usando createElement para criar uma nova opção
                    option.value = 0; // ID que será usado como valor da opção
                    option.text = `Paciente não está no Mapa`;
                    
                    listapacienteSelect.add(option); // Adiciona a nova opção ao select

                    // Preencher o select com os dados recebidos
                    data.forEach(item => {
                        const option = document.createElement("option");
                        option.value = item.id; // ID que será usado como valor da opção

                        const [data, hora] = item.dthrcirurgia.split(' ');
                        const [ano, mes, dia] = data.split('-');
                        const [horas, minutos] = hora.split(':');
                        const dthrcirurgia = `${dia}/${mes}/${ano} ${horas}:${minutos}`;

                        option.text = `Data/Hora: ${dthrcirurgia} - Especialidade: ${item.especialidade_descricao} - Fila: ${item.fila} - Procedimento: ${item.procedimento_principal}`;
                        
                        // Adicionando atributos data para os IDs
                        option.setAttribute('data-id', item.id);
                        option.setAttribute('data-especialidade-id', item.idespecialidade);
                        option.setAttribute('data-fila-id', item.idtipoprocedimento);
                        option.setAttribute('data-procedimento-id', item.idprocedimento);
                      
                        if (valorSelecionado == item.id) {
                            option.selected = true;
                        }

                        listapacienteSelect.add(option); // Adiciona a nova opção ao select
                    });

                    $('#janelaAguarde').hide();

                },
                error: function(xhr, status, error) {
                    console.error('Erro ao buscar Mapa Cirúrgico:', error);
                }
            });

        } else {
            // Se o prontuário estiver vazio, limpe o select ou mantenha o estado atual
            listapacienteSelect.innerHTML = '<option value="">Selecione uma opção</option>';
        }

    }

    function preencherSelectListaPaciente(dadosServidor) {
        const lista = document.getElementById('listapaciente');

        // Limpar o select antes de adicionar novas opções
        lista.innerHTML = '<option value="">Selecione uma opção</option>'; // Adiciona o placeholder

        //alert(dadosServidor);
        // Preencher o select com os dados recebidos do servidor

        if (Array.isArray(dadosServidor) && dadosServidor.length > 0) {
            dadosServidor.forEach(item => {
                // Dividir a string 'valor:texto'
                const [valor, texto] = item.split(':');
                
                if (valor && texto) { // Verificar se ambos valor e texto estão definidos
                    // Criar e adicionar nova opção
                    const option = document.createElement('option');
                    option.value = valor.trim(); // Atribuir o valor ao option e remover espaços em branco
                    option.text = texto.trim(); // Atribuir o texto ao option e remover espaços em branco

                    lista.add(option); // Adicionar a nova opção ao select
                }
            });
        } else {
            console.warn("Nenhum dado disponível para preencher o select.");
        }
    }

    function fetchPacienteNomeOnLoad() {
        const prontuarioInput = document.getElementById('prontuario');

        fetchPacienteNome(prontuarioInput.value);
    }

   
    $(document).ready(function() {
        
        $('.select2-dropdown').select2({
            //placeholder: "",
            allowClear: true,
            //width: 'resolve' // Corrigir a largura
        });
      

        let lastFocusedInput = null;
        // Captura o último campo de entrada (input ou textarea) focado
        $(document).on('focus', 'input[type="text"], textarea', function() {
            lastFocusedInput = this;
        });
        $(document).on('blur', 'input[type="text"], textarea', function() {
            setTimeout(() => {
                let activeElement = document.activeElement;

                // Se o foco foi para o campo de busca do Select2, retorna o foco ao último campo
                if (activeElement.classList.contains('select2-search__field') && lastFocusedInput) {
                    lastFocusedInput.focus();
                }
            }, 10);
        });

        //-------------------------------------------------------------------------

        const prontuarioInput = document.getElementById('prontuario');

        prontuarioInput.addEventListener('change', function() {
            //alert(prontuarioInput.value);
            fetchPacienteNome(prontuarioInput.value);
            updatelistapaciente(prontuarioInput.value);
        });

        $('#listapaciente').on('change', function() {
            const selectedValue = this.value;

            //alert(this.value);

            if (selectedValue !== "0" && selectedValue) { // Verifica se o valor selecionado não é zero
                // Encontrar a opção correspondente que foi selecionada
                const selectedOption = this.options[this.selectedIndex];

                // Obter os IDs armazenados nos atributos data
                const updated_at = selectedOption.getAttribute('data-updated_at');
                const especialidadeId = selectedOption.getAttribute('data-especialidade-id');
                const filaId = selectedOption.getAttribute('data-fila-id');
                const procedimentoId = selectedOption.getAttribute('data-procedimento-id');
                const origempacienteId = selectedOption.getAttribute('data-origempaciente-id');
                const unidadeorigemId = selectedOption.getAttribute('data-unidadeorigem-id');
                //const tiposanguineoId = selectedOption.getAttribute('data-tiposanguineo-id');
                const justorig = selectedOption.getAttribute('data-justorig') == 'null' ? '' : selectedOption.getAttribute('data-justorig');
                const info = selectedOption.getAttribute('data-info') == 'null' ? '' : selectedOption.getAttribute('data-info');

                const risco = selectedOption.getAttribute('data-risco');
                const dtrisco = selectedOption.getAttribute('data-dtrisco');
                const cid = selectedOption.getAttribute('data-cid');
                const lateralidade = selectedOption.getAttribute('data-lateralidade');
                const congelacao = selectedOption.getAttribute('data-congelacao');
                const opme = selectedOption.getAttribute('data-opme');
                const complexidade = selectedOption.getAttribute('data-complexidade');

                //const dataId = selectedOption.getAttribute('data-id'); // Captura o data-id
                //alert("ID do item selecionado:", dataId);
                //document.getElementById('hiddenDataIdField').value = dataId; // Supondo que você tenha um input escondido para armazená-lo

                // Preencher os campos do formulário com os IDs
                $('#especialidade').val(especialidadeId).trigger('change'); // Define o valor do select de especialidade e atualiza
                $('#fila').val(filaId).trigger('change'); // Define o valor do select de fila e atualiza
                $('#procedimento').val(procedimentoId).trigger('change'); // Define o valor do select de procedimento e atualiza
                $('#origem').val(origempacienteId).trigger('change'); // Define o valor do select de procedimento e atualiza
                $('#unidadeorigem').val(unidadeorigemId).trigger('change'); // Define o valor do select de procedimento e atualiza
                //$('#tipo_sanguineo').val(tiposanguineoId).trigger('change'); // Define o valor do select de procedimento e atualiza
                $('#risco').val(risco).trigger('change'); 
                $('#justorig').val(justorig);
                $('#info').val(info);

                $('#lateralidade').val(lateralidade).trigger('change'); 
                $('#cid').val(cid).trigger('change'); 
                $('input[name="congelacao"][value="' + congelacao + '"]').prop('checked', true);
                $('input[name="opme"][value="' + opme + '"]').prop('checked', true);
                $('input[name="complexidade"][value="' + complexidade + '"]').prop('checked', true);
                $('#dtrisco').val(dtrisco);
                $('input[name="hemoderivados"]').prop('checked', false);

                $('#lista_updated_at_original').val(updated_at);
                $('#especialidade_hidden').val(especialidadeId);
                $('#fila').val(filaId);
                $('#fila_hidden').val(filaId);
                $('#procedimento_hidden').val(procedimentoId);
                $('#origem').val(origempacienteId);
                $('#origem_hidden').val(origempacienteId);
                $('#unidadeorigem').val(unidadeorigemId);
                $('#unidadeorigem_hidden').val(unidadeorigemId);
                //$('#tipo_sanguineo').val(tiposanguineoId);
                //$('#tipo_sanguineo_hidden').val(tiposanguineoId);
                $('#risco').val(risco); 
                $('#risco_hidden').val(risco);
                /* $('#infoadic_hidden').val(info);
                $('#justorig_hidden').val(justorig); */

                // Desabilitar os campos após preencher
                $('#especialidade').prop('disabled', true);
                $('#fila').prop('disabled', true);
                $('#procedimento').prop('disabled', true);
                $('#origem').prop('disabled', true);
                $('#justorig').prop('readonly', true);
                $('#risco').prop('disabled', false);
                $('#dtrisco').prop('readonly', false);
            } else {
                // Limpar os campos se a opção selecionada não for válida
                $('#especialidade').val('').trigger('change');
                $('#fila').val(177).trigger('change');
                $('#origem').val(9).trigger('change');
                $('#risco').val(11).trigger('change');
                $('#dtrisco').val("");
                $('#procedimento').val('').trigger('change');
                $('#unidadeorigem').val("").trigger('change');
                //$('#tipo_sanguineo').val("").trigger('change');

                $('#lateralidade').val('').trigger('change'); 
                $('#cid').val('').trigger('change'); 
                $('#dtrisco').val('');
                $('input[name="congelacao"]').prop('checked', false);
                $('input[name="opme"]').prop('checked', false);
                $('input[name="complexidade"]').prop('checked', false);
                $('input[name="hemoderivados"]').prop('checked', false);

                $('#fila_hidden').val(177);
                $('#origem_hidden').val(9);
                $('#risco_hidden').val(11);
                $('#unidadeorigem_hidden').val("");
                //$('#tipo_sanguineo_hidden').val("");
                $('#info').val("");

                // Habilitar os campos para nova seleção
                $('#especialidade').prop('disabled', false);
                $('#fila').prop('disabled', true);
                $('#procedimento').prop('disabled', false);
                $('#origem').prop('disabled', true);
                $('#justorig').prop('readonly', true);
                $('#risco').prop('disabled', true);
                $('#dtrisco').prop('readonly', true);
            }
        });

        document.getElementById('idForm').addEventListener('submit', function(event) {
            $('#janelaAguarde').show();

            const listaEsperaSelect = document.getElementById('listapaciente');
            const valoresTextos = Array.from(listaEsperaSelect.options)
                .filter(option => option.value)  // Ignora opções sem valor
                .map(option => {
                    // Retorna uma string para cada opção no formato: valor:texto
                    return `${option.value}:${option.text}`;
                });

            // Atribuir valores ao campo oculto
            document.getElementById('listapacienteSelect').value = JSON.stringify(valoresTextos);

            // Opcionalmente envie o formulário agora
            // event.currentTarget.submit(); // Descomente para executar envio padrão após processamento
        });

       

    });
</script>