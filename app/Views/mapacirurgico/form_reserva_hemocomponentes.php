<?= csrf_field() ?>
<?php

use App\Models\HemocomponentesModel;

 $validation = \Config\Services::validation(); ?>


<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card form-container">
                <div class="card-header text-center text-black">
                    <b><?= 'Reservar Hemocomponente' ?></b>
                </div>
                <div class="card-body has-validation">
                    <form id="idForm" method="post" action="<?= base_url('mapacirurgico/confirmarreserva') ?>">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <div class="mb-2">
                                    <label for="dthrcirurgia" class="form-label">Data/Hora da Cirurgia</label>
                                    <div class="input-group">
                                        <input type="text" id="dthrcirurgia" placeholder="DD/MM/YYYY HH:MM"
                                            class="form-control <?php if($validation->getError('dthrcirurgia')): ?>is-invalid<?php endif ?>"
                                            name="dthrcirurgia" value="<?= set_value('dthrcirurgia', $data['dthrcirurgia']) ?>" disabled />
                                        <?php if ($validation->getError('dthrcirurgia')): ?>
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('dthrcirurgia') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-2">
                                    <label for="prontuario" class="form-label">Prontuario</label>
                                    <div class="input-group">
                                        <input type="number" id="prontuario" maxlength="8" disabled
                                        class="form-control <?php if($validation->getError('prontuario')): ?>is-invalid<?php endif ?>"
                                        name="prontuario" value="<?= set_value('prontuario', $data['prontuario']) ?>" disabled/>
                                        <?php if ($validation->getError('prontuario')): ?>
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('prontuario') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="mb-2">
                                    <label for="nome" class="form-label">Nome</label>
                                    <div class="input-group">
                                        <input type="text" id="nome" minlength="3" disabled
                                        class="form-control <?php if($validation->getError('nome')): ?>is-invalid<?php endif ?>"
                                        name="nome" value="<?= set_value('nome', $data['nome']) ?>" />
                                        <?php if ($validation->getError('nome')): ?>
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('nome') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-5">
                                <div class="mb-2">
                                    <label for="especialidade" class="form-label">Especialidade</label>
                                    <div class="input-group">
                                        <select class="form-select select2-dropdown <?php if($validation->getError('especialidade')): ?>is-invalid<?php endif ?>"
                                            id="especialidade" name="especialidade"
                                            data-placeholder="Selecione uma opção" data-allow-clear="1" disabled>
                                        <option value="" <?php echo set_select('especialidade', '', TRUE); ?>></option>
                                        <?php
                                        foreach ($data['especialidades'] as $especialidade) {
                                            $selected = ($data['especialidade'] == $especialidade->seq) ? 'selected' : '';
                                            echo '<option value="'.$especialidade->seq.'" '.$selected.'>'.$especialidade->nome_especialidade.'</option>';
                                        }
                                        ?>
                                        </select>
                                        <?php if ($validation->getError('especialidade')): ?>
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('especialidade') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="mb-2">
                                    <label for="fila" class="form-label">Fila Cirúrgica</label>
                                    <div class="input-group">
                                        <select class="form-select select2-dropdown <?php if($validation->getError('fila')): ?>is-invalid<?php endif ?>"
                                            id="fila" name="fila"
                                            data-placeholder="Selecione uma opção" data-allow-clear="1" disabled>
                                            <option value="" <?php echo set_select('fila', '', TRUE); ?> ></option>
                                            <?php
                                            foreach ($data['filas'] as $key => $fila) {
                                                $selected = ($data['fila'] == $fila['id']) ? 'selected' : '';
                                                echo '<option value="'.$fila['id'].'" '.$selected.'>'.$fila['nmtipoprocedimento'].'</option>';
                                            }
                                            ?>
                                        </select>
                                        <?php if ($validation->getError('fila')): ?>
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('fila') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row g-3">
                             <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label">Amostra Enviada<b class="text-danger">*</b></label>
                                    <div class="input-group bordered-container">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="amostra" id="amostraS" value="S" disabled
                                                <?= (isset($data['amostra']) && $data['amostra'] == 'S') ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="amostraS" style="margin-right: 10px;">&nbsp;Sim</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="amostra" id="amostraN" value="N" disabled
                                                <?= (isset($data['amostra']) && $data['amostra'] == 'N') ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="amostraN" style="margin-right: 10px;">&nbsp;Não</label>
                                        </div>
                                    </div>
                                </div>
                                <?php if ($validation->getError('amostra')): ?>
                                    <div class="invalid-feedback d-block">
                                        <?= $validation->getError('amostra') ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label for="tipo_sanguineo" class="form-label">Tipo Sanguíneo <b class="text-danger">*</b></label>
                                    <select class="form-select select2-dropdown <?= ($validation->getError('tipo_sanguineo')) ? 'is-invalid' : '' ?>"
                                        name="tipo_sanguineo" id="tipo_sanguineo"
                                        data-placeholder="Selecione"
                                        data-allow-clear="<?= empty($data['tipo_sanguineo']) ? '1' : '0' ?>">
                                        
                                        <?php
                                            // Define o valor atual (pode vir do POST ou de dados existentes)
                                            $tipoSelecionado = old('tipo_sanguineo', $data['tipo_sanguineo'] ?? '');

                                            // Só mostra a opção vazia se não houver valor selecionado
                                            if (empty($tipoSelecionado)) {
                                                echo '<option value="" selected></option>';
                                            }

                                            $tipos = ['A (+)', 'A (-)', 'B (+)', 'B (-)', 'AB (+)', 'AB (-)', 'O (+)', 'O (-)'];
                                            foreach ($tipos as $tipo):
                                                $selected = ($tipoSelecionado === $tipo) ? 'selected' : '';
                                                echo '<option value="'.$tipo.'" '.$selected.'>'.$tipo.'</option>';
                                            endforeach;
                                        ?>
                                    </select>
                                    
                                    <?php if ($validation->getError('tipo_sanguineo')): ?>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('tipo_sanguineo') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-12">
                                <div class="mb-2">
                                    <div class="bordered-container p-3">
                                        <div style="max-height: 300px; overflow-y: none;">
                                            <?php 
                                            $hemocomponentes_json = $data['hemocomponentes_cirurgia_info'] ?? '[]'; 
                                            $hemocomponentes = json_decode($hemocomponentes_json, true) ?? []; 
                                            
                                            usort($hemocomponentes, function ($a, $b) {
                                                return $a['id'] <=> $b['id'];
                                            });
                                            //dd($hemocomponentes);
                                            ?>
                                            <?php if (!empty($hemocomponentes)): ?>
                                                <!-- Cabeçalhos -->
                                                <div class="d-flex align-items-center mb-3">
                                                    <div style="width: 35%;" class="text-start fw-bold">Hemocomponente</div>
                                                    <div style="width: 20%;" class="text-center fw-bold">Qtd. Solicitada (Bolsa/ml)</div>
                                                    <div style="width: 20%;" class="text-center fw-bold">Qtd. Liberada (Bolsa/ml)<b class="text-danger">*</b></div>
                                                    <div style="width: 25%;" class="text-left fw-bold">Observação</div>
                                                </div>

                                                <?php $i = 1; foreach ($hemocomponentes as $item): ?>
                                                    <div class="form-check d-flex align-items-center" style="margin-bottom: 2rem;">
                                                        <!-- Número + descrição -->
                                                        <div style="width: 35%;" class="d-flex align-items-center me-2">
                                                            <!-- Número e label -->
                                                            <span class="fw-bold"><?= $i ?>.</span>
                                                            <label class="form-check-label mb-0" for="item_<?= $item['id'] ?>"></label>
                                                            <!-- <-?= htmlspecialchars($item['descricao']) ?> -->
                                                            <input type="text" readonly
                                                            name="descricao[<?= $item['id'] ?>]"
                                                            class="form-control"
                                                            id="descricao_<?= $item['id'] ?>"
                                                            value="<?= isset($item['descricao']) ? htmlspecialchars($item['descricao']) : '' ?>">
                                                        </div>

                                                        <!-- Qtd Solicitada -->
                                                        <div style="width: 20%;" class="text-center me-2">
                                                            <input type="number" readonly
                                                                name="qtd_solicitada[<?= $item['id'] ?>]"
                                                                class="form-control"
                                                                id="qtd_solicitada_<?= $item['id'] ?>"
                                                                value="<?= isset($item['qtd_solicitada']) ? htmlspecialchars($item['qtd_solicitada']) : '' ?>"
                                                                min="0" required>
                                                        </div>

                                                        <!-- Qtd Liberada -->
                                                        <div style="width: 20%;" class="text-center me-2">
                                                            <input type="number"
                                                                name="qtd_liberada[<?= $item['id'] ?>]"
                                                                class="form-control"
                                                                id="qtd_liberada_<?= $item['id'] ?>"
                                                                value="<?= isset($item['qtd_liberada']) ? htmlspecialchars($item['qtd_liberada']) : '' ?>"
                                                                min="0" required>
                                                        </div>

                                                        <!-- Observação -->
                                                        <div style="width: 25%;" class="text-center me-2">
                                                            <textarea rows="2"
                                                                name="observacao[<?= $item['id'] ?>]"
                                                                class="form-control"
                                                                id="observacao_<?= $item['id'] ?>"
                                                                placeholder=""><?= isset($item['observacao']) ? htmlspecialchars($item['observacao']) : '' ?></textarea>
                                                        </div>

                                                    </div>
                                                <?php $i++; endforeach; ?>
                                            <?php else: ?>
                                                <p>Nenhum hemocomponente disponível.</p>
                                            <?php endif; ?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-8">
                                <button class="btn btn-primary mt-3" onclick="return confirma(this);">
                                <i class="fa-solid fa-floppy-disk"></i> Salvar
                                </button>
                                <a class="btn btn-warning mt-3" id="btnVoltar" data-link="<?= base_url('mapacirurgico/exibircirurgiacomhemocomps'); ?>">
                                    <i class="fa-solid fa-arrow-left"></i> Voltar
                                </a>
                            </div>
                            </div>
                        </div>
                        <input type="hidden" name="idmapa" value="<?= $data['idmapa'] ?>" />
                        <input type="hidden" name="idlista" value="<?= $data['idlista'] ?>" />
                        <input type="hidden" name="dthrcirurgia" id='dthrcirurgia' value="<?= $data['dthrcirurgia'] ?>" />
                        <input type="hidden" name="ordemfila" id='ordemfila'  value="<?= $data['ordemfila'] ?>" />
                        <input type="hidden" name="prontuario" value="<?= $data['prontuario'] ?>" />
                        <input type="hidden" name="nome" value="<?= $data['nome'] ?>" />
                        <input type="hidden" name="especialidade" value="<?= $data['especialidade'] ?>" />
                        <input type="hidden" name="fila" id="fila-hidden" value="<?= $data['fila'] ?>" />
                        <input type="hidden" name="procedimento" value="<?= $data['procedimento'] ?>" />
                        <input type="hidden" name="alteracao_tipo_sanguineo" id="alteracao_tipo_sanguineo" value="<?= $data['alteracao_tipo_sanguineo'] ?? "0" ?>">
                        <input type="hidden" name="tipo_sanguineo_original" id="tipo_sanguineo_original" value="<?= $data['tipo_sanguineo_original'] ?? "" ?>">
                        <input type="hidden" name="tipo_sanguineo_confirmado" id="tipo_sanguineo_confirmado" value="<?= $data['tipo_sanguineo_confirmado'] ?? "0" ?>">
                        <input type="hidden" name="motivo_alteracao_hidden" id="motivo_alteracao_hidden"  value="<?= $data['motivo_alteracao_hidden'] ?? NULL ?>">
                        <input type="hidden" name="justificativa_alteracao_hidden" id="justificativa_alteracao_hidden" value="<?= $data['justificativa_alteracao_hidden'] ?? NULL ?>">
                        <input type="hidden" name="paciente_updated_at_original" id="paciente_updated_at_original" value="<?= $data['paciente_updated_at_original'] ?? NULL ?>">
                       
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!--  Modal ---->
<div id="modalJustificarAlteracao" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="tituloModal" aria-hidden="true" role="dialog">
    <div class="modal-dialog  modal-dialog-custom" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><strong>Justificar Alteração do Tipo Sanguíneo</strong></h5>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="mb-3">
                            <label for="motivo_alteracao" class="form-label">Motivo da alteração</label>
                            <select id="motivo_alteracao" class="form-select select2-dropdown" name="motivo_alteracao"
                                data-placeholder="Selecione uma opção" data-allow-clear="1">
                                <option value="">Selecione um motivo</option>
                                <option value="1">Erro no cadastro</option>
                                <option value="2">Atualização com novo exame</option>
                            </select>
                        </div>
                        <hr>
                    <div class="row">
                        <div class="mb-3">
                            <label for="justificativa" class="form-label">Justificativa</label>
                            <textarea id="justificativa" class="form-control" rows="3" placeholder="Descreva a justificativa..."></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" id="linha">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="btnCancelarJustificativa" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnSalvarJustificativa">Salvar Justificativa</button>
            </div>
        </div>
    </div>
</div>
<!------->
<script>

    function confirma(button) {

        event.preventDefault(); // Previne a submissão padrão do formulário

        Swal.fire({
            title: 'Confirma a reserva do(s) hemocomponente(s) assinalado(s)?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ok',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#janelaAguarde').show();
                $('#idForm').off('submit'); 
                $('#idForm').submit(); 
            } else {
                $('#janelaAguarde').hide(); // Esconde a janela de aguardo se necessário
            }
        });

        return false; // Queremos prevenir o comportamento padrão do link
    }

    let tipoSanguineoOriginal = $('#tipo_sanguineo').val();
    let alteracaoConfirmada =  $('#tipo_sanguineo_confirmado').val() == '1';
    let carregandoInicial = false;

    function updateTipoSanguineo(valor, bloqueiaClear = true) {
        const $select = $('#tipo_sanguineo');

        // Define o valor
        $select.val(valor);

        // Destroi o select2 anterior
        if ($select.hasClass("select2-hidden-accessible")) {
            $select.select2('destroy');
        }

        // Reinicializa com allowClear correto
        $select.select2({
            placeholder: "Selecione uma opção",
            allowClear: !bloqueiaClear,
            width: '100%'
        });

        // Adiciona ou remove a classe no elemento gerado pelo select2
        const $container = $select.next('.select2-container');

        if (bloqueiaClear) {
            $container.addClass('no-clear');

            // Impede a remoção mesmo se tentarem
            $select.off('select2:unselecting').on('select2:unselecting', function (e) {
                e.preventDefault();
            });
        } else {
            $container.removeClass('no-clear');
            $select.off('select2:unselecting');
        }

        // Dispara o evento de mudança visual
        $select.trigger('change');
    }

    $(document).ready(function() {
        $('.select2-dropdown').select2({
            allowClear: true,
        });

        $('#motivo_alteracao').select2({
            dropdownParent: $('#modalJustificarAlteracao'), // ESSENCIAL para funcionar dentro do modal
            width: '100%',
            placeholder: 'Selecione uma opção'
        });

        const allowClear = $('#tipo_sanguineo').data('allow-clear') == 1;

        $('#tipo_sanguineo').select2({
            placeholder: "Selecione uma opção",
            allowClear: allowClear,
            width: '100%'
        });
        
        $("#btnVoltar").on("click", function(event) {
            event.preventDefault(); // Impede a navegação imediata

            var linkDestino = $(this).data("link"); // Obtém o link do botão

            // Exibe a janela de aguarde
            $("#janelaAguarde").show();

            // Aguarda um curto período e redireciona
            setTimeout(function() {
                window.location.href = linkDestino;
            }, 1000); // Tempo para exibir o "Aguarde"
        });
       
        /* const prontuarioInput = document.getElementById('prontuario');
        prontuarioInput.addEventListener('change', function() {
            fetchPacienteNome(prontuarioInput.value);
        }); */

         $('#tipo_sanguineo').on('change', function () {
            
            const valorAtual = $(this).val();

            if (carregandoInicial || alteracaoConfirmada || !tipoSanguineoOriginal) return;


            if (valorAtual !== tipoSanguineoOriginal) {
                Swal.fire({
                    title: 'Alterar tipo sanguíneo?',
                    //text: `O tipo original era ${tipoSanguineoOriginal}. Deseja realmente alterar para ${valorAtual}?`,
                    text: `O tipo anterior era ${tipoSanguineoOriginal}. Deseja realmente alterar para outro tipo sanguíneo?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sim',
                    cancelButtonText: 'Não'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#modalJustificarAlteracao').modal('show');
                        //$('#modalDetalhes').modal('show');

                    } else {
                        /* $('#tipo_sanguineo').val(tipoSanguineoOriginal).trigger('change'); */
                        updateTipoSanguineo(tipoSanguineoOriginal, true);
                        $('#tipo_sanguineo_confirmado').val('0');
                    }
                });
            }
        });

        $('#btnSalvarJustificativa').on('click', function () {
            const motivo = $('#motivo_alteracao').val();
            const justificativa = $('#justificativa').val().trim();

            //if (!motivo || justificativa === '') {
            if (!motivo) {
                Swal.fire('Campos obrigatórios', 'Por favor, informe o motivo para alteração.', 'warning');
                return;
            }

            $('#modalJustificarAlteracao').modal('hide');
            alteracaoConfirmada = true;

            $('#tipo_sanguineo_confirmado').val('1');
            $('#motivo_alteracao_hidden').val(motivo);
            $('#justificativa_alteracao_hidden').val(justificativa);
        });

        $('#btnCancelarJustificativa').on('click', function () {
            if (tipoSanguineoOriginal !== null) {
                /* $('#tipo_sanguineo').val(tipoSanguineoOriginal).trigger('change'); */
                updateTipoSanguineo(tipoSanguineoOriginal, true);
            }
        });

    });
</script>

