<?= csrf_field() ?>
<?php $validation = \Config\Services::validation(); ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card form-container">
                <div class="card-header text-center text-black">
                    <b><?= 'Editar Fila Cirúrgica/PDT' ?></b>
                </div>
                <div class="card-body has-validation">
                    <form id="idForm" method="post" action="<?= base_url('listaespera/editar') ?>">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <div class="mb-2">
                                    <label for="dtinclusao" class="form-label">Data/Hora de Inclusão</label>
                                    <div class="input-group">
                                        <input type="text" id="dtinclusao" placeholder="DD/MM/AAAA HH:MM:SS" disabled
                                            class="form-control<?php if($validation->getError('dtinclusao')): ?>is-invalid<?php endif ?>"
                                            name="dtinclusao" value="<?= set_value('dtinclusao', $data['dtinclusao']) ?>" disabled/>
                                        <?php if ($validation->getError('dtinclusao')): ?>
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('dtinclusao') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-2">
                                    <label for="prontuario" class="form-label">Prontuario<b class="text-danger">*</b></label>
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
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label for="nome" class="form-label">Nome</label>
                                    <div class="input-group">
                                        <input type="text" id="nome" minlength="3" readonly
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
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label for="especialidade" class="form-label">Especialidade<b class="text-danger">*</b></label>
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
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label for="fila" class="form-label">Fila Cirúrgica<b class="text-danger">*</b></label>
                                    <div class="input-group">
                                        <select class="form-select select2-dropdown <?php if($validation->getError('fila')): ?>is-invalid<?php endif ?>"
                                            id="fila" name="fila"
                                            data-placeholder="Selecione uma opção" data-allow-clear="1">
                                            <option value="" <?php echo set_select('fila', '', TRUE); ?> ></option>
                                            <?php
                                            foreach ($data['filas'] as $key => $fila) {
                                                $selected = (set_value('fila') == $fila['id']) ? 'selected' : '';
                                                echo '<option value="'.$fila['id'].'" data-especialidade="'.$fila['idespecialidade'].'" '.$selected.'>'.$fila['nmtipoprocedimento'].'</option>';
                                                /* echo "<!-- id: {$fila['id']}, idespecialidade: {$fila['idespecialidade']}, nmtipoprocedimento: {$fila['nmtipoprocedimento']} -->"; */

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
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label for="procedimento" class="form-label">Procedimento<b class="text-danger">*</b></label>
                                    <div class="input-group">
                                        <select class="form-select select2-dropdown <?php if($validation->getError('procedimento')): ?>is-invalid<?php endif ?>"
                                            id="procedimento" name="procedimento" 
                                            data-placeholder="Selecione uma opção" data-allow-clear="1" > 
                                            <option value="" <?php echo set_select('procedimento', '', TRUE); ?> ></option>
                                            <?php
                                            foreach ($data['procedimentos'] as $key => $procedimento) {
                                                $selected = ($data['procedimento'] == $procedimento->cod_tabela) ? 'selected' : '';
                                                $enabled = ($procedimento->ind_situacao == 'I') ? 'disabled' : ''; 
                                                echo '<option value="'.$procedimento->cod_tabela.'" '.$selected.' '.$enabled.'>'.$procedimento->cod_tabela.' - '.$procedimento->descricao.'</option>';
                                            }
                                            ?>
                                        </select>
                                        <?php if ($validation->getError('procedimento')): ?>
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('procedimento') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label for="cid" class="form-label">CID<b class="text-danger">*</b></label>
                                    <div class="input-group">
                                        <select class="form-select select2-dropdown <?php if($validation->getError('cid')): ?>is-invalid<?php endif ?>"
                                            id="cid" name="cid" style="width: 100px;"
                                            data-placeholder="" data-allow-clear="1">
                                            <option value="" <?php echo set_select('cid', '', TRUE); ?> ></option>
                                            <?php
                                            foreach ($data['cids'] as $key => $cid) {
                                                $selected = ($data['cid'] == $cid->seq) ? 'selected' : '';
                                                echo '<option value="'.$cid->seq.'" '.$selected.'>'.$cid->codigo.' - '.$cid->descricao.'</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <?php if ($validation->getError('cid')): ?>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('cid') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-3">
                                <div class="mb-2">
                                    <label for="risco" class="form-label">Risco Cirúrgico</label>
                                    <div class="input-group">
                                        <select class="form-select select2-dropdown <?php if($validation->getError('risco')): ?>is-invalid<?php endif ?>"
                                            id="risco" name="risco" 
                                            data-placeholder="Selecione uma opção" data-allow-clear="1">
                                            <option value="" <?php echo set_select('risco', '', TRUE); ?> ></option>
                                            <?php
                                            foreach ($data['riscos'] as $key => $risco) {
                                                $selected = ($data['risco'] == $risco['id']) ? 'selected' : '';
                                                $enabled = ($risco['indsituacao'] == 'I') ? 'disabled' : ''; 
                                                echo '<option value="'.$risco['id'].'" '.$selected.' '.$enabled.'>'.$risco['nmrisco'].'</option>';
                                            }
                                            ?>
                                        </select>
                                        <?php if ($validation->getError('risco')): ?>
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('risco') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-2">
                                    <label for="dtrisco" class="form-label">Data Risco</label>
                                    <div class="input-group">
                                        <input type="text" id="dtrisco" maxlength="10" placeholder="DD/MM/AAAA"
                                            class="form-control Data <?php if($validation->getError('dtrisco')): ?>is-invalid<?php endif ?>"
                                            name="dtrisco" value="<?= set_value('dtrisco', $data['dtrisco']) ?>"/>
                                        <?php if ($validation->getError('dtrisco')): ?>
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('dtrisco') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-2">
                                    <label for="origem" class="form-label">Origem Paciente<b class="text-danger">*</b></label>
                                    <div class="input-group">
                                        <select class="form-select select2-dropdown <?php if($validation->getError('origem')): ?>is-invalid<?php endif ?>"
                                            id="origem" name="origem"
                                            data-placeholder="Selecione uma opção" data-allow-clear="1">
                                            <option value="" <?php echo set_select('origem', '', TRUE); ?> ></option>
                                            <?php
                                            foreach ($data['origens'] as $key => $origem) {
                                                $selected = ($data['origem'] == $origem['id']) ? 'selected' : '';
                                                $enabled = ($origem['indsituacao'] == 'I') ? 'disabled' : ''; 
                                                echo '<option value="'.$origem['id'].'" '.$selected.' '.$enabled.'>'.$origem['nmorigem'].'</option>';
                                            }
                                            ?>
                                        </select>
                                        <?php if ($validation->getError('origem')): ?>
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('origem') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-2">
                                    <label for="unidadeorigem" class="form-label">Unidade de Origem</label>
                                    <select class="form-select select2-dropdown <?php if($validation->getError('cid')): ?>is-invalid<?php endif ?>"
                                            id="unidadeorigem" name="unidadeorigem"
                                            data-placeholder="Selecione uma opção" data-allow-clear="1">
                                            <option value="" <?php echo set_select('unidadeorigem', '', TRUE); ?> ></option>
                                            <?php
                                            foreach ($data['unidades'] as $key => $unidade) {
                                                $selected = ($data['unidadeorigem'] == $unidade->seq) ? 'selected' : '';
                                                echo '<option value="'.$unidade->seq.'" '.$selected.'>'.$unidade->nome.'</option>';
                                            }
                                            ?>
                                        </select>
                                        <?php if ($validation->getError('unidadeorigem')): ?>
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('unidadeorigem') ?>
                                            </div>
                                        <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-2">
                                <div class="mb-2">
                                    <label for="lateralidade" class="form-label">Lateralidade<b class="text-danger">*</b></label>
                                    <div class="input-group">
                                        <select class="form-select select2-dropdown <?php if($validation->getError('lateralidade')): ?>is-invalid<?php endif ?>"
                                            id="lateralidade" name="lateralidade"
                                            data-placeholder="Selecione uma opção" data-allow-clear="1">
                                            <option value="" <?php echo set_select('lateralidade', '', TRUE); ?> ></option>
                                            <?php
                                            foreach ($data['lateralidades'] as $key => $lateralidade) {
                                                $selected = ($data['lateralidade'] == $lateralidade['id']) ? 'selected' : '';
                                                $enabled = ($lateralidade['indsituacao'] == 'I') ? 'disabled' : ''; 
                                                echo '<option value="'.$lateralidade['id'].'" '.$selected.' '.$enabled.'>'.$lateralidade['descricao'].'</option>';
                                            }
                                            ?>
                                        </select>
                                        <?php if ($validation->getError('lateralidade')): ?>
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('lateralidade') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-2">
                                    <label class="form-label">Congelação<b class="text-danger">*</b></label>
                                    <div class="input-group mb-2 bordered-container">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="congelacao" id="congelacaoN" value="N"
                                                <?= (isset($data['congelacao']) && $data['congelacao'] == 'N') ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="congelacaoN" style="margin-right: 10px;">&nbsp;Não</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="congelacao" id="congelacaoS" value="S"
                                                <?= (isset($data['congelacao']) && $data['congelacao'] == 'S') ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="congelacaoS" style="margin-right: 10px;">&nbsp;Sim</label>
                                        </div>
                                    </div>
                                </div>
                                <?php if ($validation->getError('congelacao')): ?>
                                    <div class="invalid-feedback d-block">
                                        <?= $validation->getError('congelacao') ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-2">
                                    <label class="form-label">OPME<b class="text-danger">*</b></label>
                                    <div class="input-group mb-2 bordered-container">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="opme" id="opmeN" value="N"
                                                <?= (isset($data['opme']) && $data['opme'] == 'N') ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="opmeN" style="margin-right: 10px;">&nbsp;Não</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="opme" id="opmeS" value="S"
                                                <?= (isset($data['opme']) && $data['opme'] == 'S') ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="opmeS" style="margin-right: 10px;">&nbsp;Sim</label>
                                        </div>
                                    </div>
                                    <?php if ($validation->getError('opme')): ?>
                                    <div class="invalid-feedback d-block">
                                        <?= $validation->getError('opme') ?>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label class="form-label">Complexidade<b class="text-danger">*</b></label>
                                    <div class="input-group mb-2 bordered-container">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="complexidade" id="complexidadeA" value="A"
                                                <?= (isset($data['complexidade']) && $data['complexidade'] == 'A') ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="complexidadeA" style="margin-right: 10px;">&nbsp;Alta</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="complexidade" id="complexidadeM" value="M"
                                                <?= (isset($data['complexidade']) && $data['complexidade'] == 'M') ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="complexidadeM" style="margin-right: 10px;">&nbsp;Média</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="complexidade" id="complexidadeB" value="B"
                                                <?= (isset($data['complexidade']) && $data['complexidade'] == 'B') ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="complexidadeB" style="margin-right: 10px;">&nbsp;Baixa</label>
                                        </div>
                                    </div>
                                </div>
                                <?php if ($validation->getError('complexidade')): ?>
                                    <div class="invalid-feedback d-block">
                                        <?= $validation->getError('complexidade') ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label class="form-label" for="justorig">Justificativa p/ Origem Paciente</label>
                                    <textarea id="justorig" maxlength="1000" rows="3"
                                            class="form-control <?= isset($validation) && $validation->getError('justorig') ? 'is-invalid' : '' ?>"
                                            name="justorig"><?= isset($data['justorig']) ? $data['justorig'] : '' ?></textarea>
                                    <?php if (isset($validation) && $validation->getError('justorig')): ?>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('justorig') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label class="form-label" for="info">Informações adicionais</label>
                                    <textarea id="info" maxlength="1000" rows="3"
                                            class="form-control <?= isset($validation) && $validation->getError('info') ? 'is-invalid' : '' ?>"
                                            name="info"><?= isset($data['info']) ? $data['info'] : '' ?></textarea>
                                    <?php if (isset($validation) && $validation->getError('info')): ?>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('info') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-12">
                                <button class="btn btn-primary mt-3" id="submit" name="submit" type="submit" value="1">
                                    <i class="fa-solid fa-save"></i> Salvar
                                </button>
                                <a class="btn btn-warning mt-3" href="<?= base_url('listaespera/exibir') ?>">
                                    <i class="fa-solid fa-arrow-left"></i> Voltar
                                </a>
                            </div>
                        </div>

                        <input type="hidden" name="id" value="<?= $data['id'] ?>" />
                        <input type="hidden" name="ordemfila" id="ordemfila" value="<?= $data['ordemfila'] ?>" />
                        <input type="hidden" name="dtinclusao" value="<?= $data['dtinclusao'] ?>" />
                        <input type="hidden" name="prontuario" value="<?= $data['prontuario'] ?>" />
                        <input type="hidden" name="especialidade" id="especialidade-hidden" value="<?php echo $data['especialidade']; ?>">
                        <input type="hidden" name="fila" id="fila-hidden" value="<?php echo $data['fila']; ?>">
                        <input type="hidden" name="procedimento" id="procedimento" value="<?php echo $data['procedimento']; ?>">
                        <input type="hidden" name="origem" value="<?= $data['origem'] ?>" />
                        <input type="hidden" name="lateralidade" value="<?= $data['lateralidade'] ?>">
                        <input type="hidden" name="risco" value="<?= $data['risco'] ?>" />
                        <input type="hidden" name="alteracao_tipo_sanguineo" id="alteracao_tipo_sanguineo" value="<?= $data['alteracao_tipo_sanguineo'] ?? "0" ?>">
                        <input type="hidden" name="tipo_sanguineo_confirmado" id="tipo_sanguineo_confirmado" value="<?= $data['tipo_sanguineo_confirmado'] ?? "0" ?>">
                        <input type="hidden" name="motivo_alteracao_hidden" id="motivo_alteracao_hidden"  value="<?= $data['motivo_alteracao_hidden'] ?? NULL ?>">
                        <input type="hidden" name="justificativa_alteracao_hidden" id="justificativa_alteracao_hidden" value="<?= $data['justificativa_alteracao_hidden'] ?? NULL ?>">
                        <input type="hidden" name="lista_updated_at_original" value="<?= $data['lista_updated_at_original'] ?? NULL ?>">
                        <input type="hidden" name="paciente_updated_at_original" id="paciente_updated_at_original" value="<?= $data['paciente_updated_at_original'] ?? NULL ?>">

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
    window.onload = function() {
        // Adiciona o listener de "keydown" a todos os elementos de entrada
        const inputs = document.querySelectorAll('input, select, .form-check-input');
        inputs.forEach(input => {
            input.addEventListener('keydown', disableEnter);
        });
    };

    function voltarERecarregar() {
        const previousPage = sessionStorage.getItem('previousPage');
        if (previousPage) {
            window.location.href = previousPage; // Redireciona para a página anterior
        } else {
            window.history.back(); // Usa o histórico se não houver página armazenada
        }
    }
    /* $('#especialidade').on('select2:opening', function(e) {
        e.preventDefault();  // Impede a abertura do dropdown
    }); */
    /* $('#fila').on('select2:opening', function(e) {
        e.preventDefault();  // Impede a abertura do dropdown
    }); */

    let tipoSanguineoOriginal = $('#tipo_sanguineo').val();
    let alteracaoConfirmada =  $('#tipo_sanguineo_confirmado').val() == '1';
    let carregandoInicial = false;

    /*
    function fetchPacienteNome(prontuarioValue) {
      if (prontuarioValue) {
        fetch('<-?= base_url('listaespera/getnomepac/') ?>' + prontuarioValue, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          }
        })
        .then(response => {
          if (!response.ok) {
            throw new Error('Network response was not ok');
          }
          return response.json();
        })
        .then(data => {
          if (data.nome) {
            document.getElementById('nome').value = data.nome;
            const ordemfila = document.getElementById('ordemfila').value;
            var selectElement = document.getElementById('fila');
            var filaText = selectElement.options[selectElement.selectedIndex].text;

            tipoSanguineoOriginal = data.tiposanguineo;
            alteracaoConfirmada = false;

            $('#tipo_sanguineo').val(tipoSanguineoOriginal).trigger('change');
            $('#alteracao_tipo_sanguineo').val('0');

            carregandoInicial = false; // <- libera para disparar alerta depois

            //loadAsideContent(prontuarioValue, ordemfila, filaText);
        } else {
            document.getElementById('nome').value = data.error;
            console.error(data.error || 'Nome não encontrado');
            $('#sidebar').html('<p>'+data.error+'</p>'); 
          }
        })
        .catch(error => {
            document.getElementById('nome').value = '';
            console.error('Erro ao buscar nome do paciente:', error);
            Swal.fire({
                title: 'Erro',
                text: 'Houve um problema ao buscar os dados do paciente. Tente novamente.',
                icon: 'error'
            });
        });
      } else {
        document.getElementById('nome').value = '';
      }
    }
    */
    
    /* function fetchPacienteNomeOnLoad() {
        const prontuarioInput = document.getElementById('prontuario');
        fetchPacienteNome(prontuarioInput.value);
    }

    fetchPacienteNomeOnLoad(); */

    $(document).ready(function() {
        $('#idForm').submit(function() {
            $('#janelaAguarde').show();
            setTimeout(function() {
                window.location.href = href;
            }, 1000);
        });

        $('.select2-dropdown').select2({
            //dropdownCssClass: 'custom-dropdown',
            //placeholder: $(this).data('placeholder'), // Utiliza o placeholder definido no HTML
            allowClear: true
        });

        $('#motivo_alteracao').select2({
/*             theme: 'bootstrap-5', */
            dropdownParent: $('#modalJustificarAlteracao'), // ESSENCIAL para funcionar dentro do modal
            width: '100%',
            placeholder: 'Selecione uma opção'
        });

        $('#fila').on('change', function () {
            var selectedFilter = $(this).val();
            $('input[name="fila"]').val(selectedFilter);
        });
        $('#procedimento').change(function() {
            var selectedFilter = $(this).val();
            $('input[name="procedimento"]').val(selectedFilter);
        })
        $('#risco').change(function() {
            var selectedFilter = $(this).val();
            $('input[name="risco"]').val(selectedFilter);
        })
        $('#origem').change(function() {
            var selectedFilter = $(this).val();
            $('input[name="origem"]').val(selectedFilter);
        })
        $('#lateralidade').change(function() {
            var selectedFilter = $(this).val();
            $('input[name="lateralidade"]').val(selectedFilter);
        })

      /*   $('#procedimento').select2().on('select2:opening', function(e) {
         e.preventDefault(); // Impede a abertura do dropdown
        }); */

        const prontuarioInput = document.getElementById('prontuario');
        /* prontuarioInput.addEventListener('change', function() {
            fetchPacienteNome(prontuarioInput.value);
        }); */

        document.getElementById('idForm').addEventListener('submit', function(event) {
            $('#janelaAguarde').show();
        });

        const filas = <?= json_encode($data['filas']) ?>;

        // Atualizar filas ao mudar a especialidade
        $('#especialidade').change(function () {
            const selectedEspecialidade = <?= $data['especialidade'] ?>;

            // Limpar opções de fila
            $('#fila').empty().append('<option value="">Selecione uma opção</option>');

            // Adicionar opções com base na especialidade selecionada
            filas.forEach(fila => {
                if (fila.idespecialidade == selectedEspecialidade) {
                    $('#fila').append(new Option(fila.nmtipoprocedimento, fila.id));
                }
            });

            // Atualizar select2
            $('#fila').val('<?= $data['fila'] ?>').trigger('change.select2');
            //alert($('#fila').val());
        });

        // Disparar evento de mudança para inicializar
        $('#especialidade').trigger('change');

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
                        $('#tipo_sanguineo').val(tipoSanguineoOriginal).trigger('change');
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
                $('#tipo_sanguineo').val(tipoSanguineoOriginal).trigger('change');
            }
        });

    });
</script>
