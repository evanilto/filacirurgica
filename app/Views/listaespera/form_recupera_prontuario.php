    <form id="idForm" method="post" action="<?= base_url('prontuarios/recuperar') ?>">
        <?= csrf_field() ?>
        <?php $validation = \Config\Services::validation(); ?>

        <div class="card">
            
            <div class="card-header text-black"  style="flex: 1; display: flex; justify-content: center; align-items: center;">
                <b><?= 'Recuperar Prontuário' ?></b>
            </div>

            <div class="card-body has-validation row g-3">
                <div class="col-md-12">
                    <label for="login" class="form-label">Prontuario<b class="text-danger">*</b></label>
                    <div class="input-group mb-12">
                        <input type="text" id="prontuario" maxlength="8"
                            class="form-control <?php if($validation->getError('prontuario')): ?>is-invalid<?php endif ?>"
                            autofocus name="prontuario" value="<?= set_value('prontuario') ?>"/>

                        <?php if ($validation->getError('prontuario')): ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('prontuario') ?>
                            </div>
                        <?php endif; ?>
                        
                    </div>
                </div>
            </div>

            <hr />
            <div class="card col-md-12">
                <div class="card-body text-center">
                    <div class="row">
                        <div class="col-md-12 d-flex justify-content-center">
                            <a class="btn btn-warning m-2" href="javascript:history.go(-1)" style="height: 40px; width: 100px; text-align: center; margin-right: 10px;">
                                <i class="fa-solid fa-arrow-left"></i> Voltar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </form>