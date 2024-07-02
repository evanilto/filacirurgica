    <form id="tramitaForm" method="post" action="<?= base_url('prontuarios/receber') ?>">
        <?= csrf_field() ?>
        <?php $validation = \Config\Services::validation(); ?>

        <div class="card">
            
            <div class="card-header text-black"  style="flex: 1; display: flex; justify-content: center; align-items: center;">
                <b><?= 'Receber Prontuário' ?></b>
            </div>

            <div class="card-body has-validation row g-3">
                <div class="col-md-8">
                    <label for="login" class="form-label">Prontuario<b class="text-danger">*</b></label>
                    <div class="input-group mb-8">
                        <input type="text" id="prontuario" maxlength="8"
                            class="form-control <?php if($validation->getError('prontuario')): ?>is-invalid<?php endif ?>"
                            autofocus name="prontuario" value="<?= set_value('prontuario', isset($idprontuario) ? $idprontuario : '') ?>"/>


                        <?php if ($validation->getError('prontuario')): ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('prontuario') ?>
                            </div>
                        <?php endif; ?>
                        
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="login" class="form-label">Volume<b class="text-danger"></b></label>
                    <div class="input-group mb-4">
                        <input type="text" id="volume" maxlength="2"
                            class="form-control <?php if($validation->getError('volume')): ?>is-invalid<?php endif ?>"
                            name="volume" value="<?= set_value('volume', isset($nuvolume) ? $nuvolume : '') ?>"/>

                        <?php if ($validation->getError('volume')): ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('volume') ?>
                            </div>
                        <?php endif; ?>
                        
                    </div>
                </div>
            </div>

            <hr />
            <div class="col-md-12">
                <div class="card-body text-center">
                    <div class="row">
                        <div class="col-md-6">
                            <button class="btn btn-info mt-0" id="submit" name="submit"  type="submit" value="1"><i class="fas fa-arrow-down"></i> Receber</button>
                        </div>
                        <div class="col-md-6">
                            <a class="btn btn-warning mt-0" href="javascript:history.go(-1)"><i class="fa-solid fa-arrow-left"></i> Voltar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- <input type="hidden" name="origem_chamado" value="<--?= !isset($idprontuario) ? 'menu_tramite' : '' ?>"> -->

    </form>
