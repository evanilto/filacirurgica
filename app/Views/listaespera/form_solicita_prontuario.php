    <form id="tramitaForm" method="post" action="<?= base_url('prontuarios/solicitar') ?>">
        <?= csrf_field() ?>
        <?php $validation = \Config\Services::validation(); ?>

        <div class="card">
            
            <div class="card-header text-black"  style="flex: 1; display: flex; justify-content: center; align-items: center;">
                <b><?= 'Solicitar Prontuário' ?></b>
            </div>

            <div class="card-body has-validation row g-3" style="margin-bottom: -35px;">
                <div class="col-md-8">
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
                <div class="col-md-4">
                    <label for="login" class="form-label">Volume<b class="text-danger"></b></label>
                    <div class="input-group mb-4">
                        <input type="text" id="volume" maxlength="2"
                            class="form-control <?php if($validation->getError('volume')): ?>is-invalid<?php endif ?>"
                            autofocus name="volume" value="<?= set_value('volume') ?>"/>

                        <?php if ($validation->getError('volume')): ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('volume') ?>
                            </div>
                        <?php endif; ?>
                        
                    </div>
                </div>
            </div>

            <div class="card-body has-validation row g-3">
                <div class="col-md-12">
                    <label for="receptor" class="form-label">Receptor<b class="text-danger">*</b></label>
                    <div class="input-group mb-12">
                        <select
                            class="form-select <?php if($validation->getError('receptor')): ?>is-invalid<?php endif ?>"
                            id="receptor" name="receptor" onchange=""
                            data-placeholder="Selecione uma opção" data-allow-clear="1">
                            <?php
                            foreach ($select as $usuario) {
                                $selected = (set_value('receptor') == $usuario->id) ? 'selected' : '';
                                echo '<option value="'.$usuario->id.'" '.$selected.'>'.$usuario->nmUsuario.'</option>';
                            }
                            ?>
                        </select>

                        <?php if ($validation->getError('receptor')): ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('receptor'.$i) ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="card-body has-validation row g-3">
                <div class="col-md-12">
                    <label for="justificativa" class="form-label">Justificativa<b class="text-danger">*</b></label>
                    <div class="input-group mb-12">
                        <textarea type="text" id="justificativa" maxlength="255"
                            class="form-control <?php if($validation->getError('justificativa')): ?>is-invalid<?php endif ?>"
                            autofocus name="justificativa" value="<?= set_value('justificativa') ?>"></textarea>

                        <?php if ($validation->getError('justificativa')): ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('justificativa') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <hr />
                <div class="col-md-12">
                    <div class="card-body text-center">
                        <div class="row">
                            <div class="col-md-6">
                                <button class="btn btn-info mt-0" id="submit" name="submit"  type="submit" value="1"><i class="fas fa-envelope"></i> Solicitar</button>
                            </div>
                            <div class="col-md-6">
                                <a class="btn btn-warning mt-0" href="javascript:history.go(-1)"><i class="fa-solid fa-arrow-left"></i> Voltar</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </form>