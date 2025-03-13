<?= csrf_field() ?>
<?php $validation = \Config\Services::validation(); ?>
    
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card form-container">
                <div class="card-header text-center text-black">
                    <b><?= 'Editar Equipamentos Cirúrgicos' ?></b>
                </div>
                <div class="card-body has-validation d-flex flex-column align-items-center">
                    <form id="FilaForm" method="post" action="<?= base_url("equipamentos/editar/$id") ?>" class="w-100">
                        <div class="row g-3">
                            <div class="col-md-9">
                                <div class="mb-2">
                                    <label for="nome" class="form-label">Descrição do Equipamento<b class="text-danger">*</b></label>
                                    <div class="input-group">
                                        <input type="text" id="nome" minlength="3" maxlength="250"
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
                            <div class="col-md-3">
                                <div class="mb-2">
                                    <label for="qtd" class="form-label">Qtd. Disponível<b class="text-danger">*</b></label>
                                    <div class="input-group">
                                        <input type="number" id="qtd" minlength="1"
                                        class="form-control <?php if($validation->getError('qtd')): ?>is-invalid<?php endif ?>"
                                        name="qtd" value="<?= set_value('qtd', $qtd) ?>"/>
                                        <?php if ($validation->getError('qtd')): ?>
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('qtd') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-12">
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
        
       /*  $('.select2-dropdown').select2({
            placeholder: "",
            allowClear: true,
            width: 'resolve' // Corrigir a largura
        }); */
    });
</script>