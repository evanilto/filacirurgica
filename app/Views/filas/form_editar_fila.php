<?= csrf_field() ?>
<?php $validation = \Config\Services::validation(); ?>
    
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card form-container">
                <div class="card-header text-center text-black">
                    <b><?= 'Editar Fila' ?></b>
                </div>
                <div class="card-body has-validation d-flex flex-column align-items-center">
                    <form id="FilaForm" method="post" action="<?= base_url("filas/editar/$id") ?>" class="w-100">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <div class="mb-2">
                                    <label for="especialidade" class="form-label">Especialidade<b class="text-danger">*</b></label>
                                    <div class="input-group">
                                        <select class="form-select select2-dropdown <?php if($validation->getError('especialidade')): ?>is-invalid<?php endif ?>"
                                            id="especialidade" name="especialidade">
                                            <option value="" <?= set_select('especialidade', '', TRUE); ?> ></option>
                                            <?php foreach ($data['especialidades'] as $especialidade): ?>
                                                <option value="<?= $especialidade->seq ?>" 
                                                    <?= ($especialidade->seq == $data['especialidade'] || set_value('especialidade') == $especialidade->seq) ? 'selected' : '' ?>>
                                                    <?= $especialidade->nome_especialidade ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <?php if ($validation->getError('especialidade')): ?>
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('especialidade') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-12">
                                <div class="mb-2">
                                    <label for="nome" class="form-label">Nome da Fila<b class="text-danger">*</b></label>
                                    <div class="input-group">
                                        <input type="text" id="nome" minlength="3"
                                        class="form-control <?php if($validation->getError('nome')): ?>is-invalid<?php endif ?>"
                                            name="nome" value="<?= set_value('nome', $nome) ?>"/>
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
                                    <label class="form-label">Tipo<b class="text-danger">*</b></label>
                                    <div class="input-group mb-2 bordered-container">
                                        <div class="form-check form-check-inline">
                                            <?php $checked = ($tipo == 'C' ? 'checked' : ''); ?>
                                            <input class="form-check-input" type="radio" name="tipo" id="tipoC" value="C" <?= $checked ?>>
                                            <label class="form-check-label" for="tipoC" style="margin-right: 10px;">&nbsp;Cirurgia</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <?php $checked = ($tipo == 'E' ? 'checked' : ''); ?>
                                            <input class="form-check-input" type="radio" name="tipo" id="tipoE" value="E" <?= $checked ?>>
                                            <label class="form-check-label" for="tipoE" style="margin-right: 10px;">&nbsp;PDT</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label class="form-label">Situação<b class="text-danger">*</b></label>
                                    <div class="input-group mb-12 bordered-container">
                                    <div class="form-check form-check-inline">
                                        <?php $checked = ($indsituacao == 'A' ? 'checked' : ''); ?>
                                        <input class="form-check-input" type="radio" name="indsituacao" id="indsituacaoA" value="A" <?= $checked ?>>
                                        <label class="form-check-label" for="indsituacaoA" style="margin-right: 10px;">&nbsp;Ativo</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php $checked = ($indsituacao == 'I' ? 'checked' : ''); ?>
                                        <input class="form-check-input" type="radio" name="indsituacao" id="indsituacaoI" value="I" <?= $checked ?>>
                                        <label class="form-check-label" for="indsituacaoI" style="margin-right: 10px;">&nbsp;Inativo</label>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                        <hr  />

                        <div class="row g-3">
                            <div class="col-md-8">
                                <button class="btn btn-primary mt-3" id="submit" name="submit" type="submit" value="1">
                                    <i class="fa-solid fa-save"></i> Salvar
                                </button>
                                <a class="btn btn-warning mt-3" href="javascript:window.history.back();">
                                    <i class="fa-solid fa-arrow-left"></i> Voltar
                                </a>
                            </div>
                        </div>

                        <input type="hidden" name="id" id="id" value="<?= $id ?>" />

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#idForm').submit(function() {
            $('#janelaAguarde').show();
            setTimeout(function() {
                window.location.href = href;
            }, 1000);
        });
        
        $('.select2-dropdown').select2({
            placeholder: "",
            allowClear: true,
            width: 'resolve' // Corrigir a largura
        });
    });
</script>