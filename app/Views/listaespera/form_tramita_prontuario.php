    <form id="tramitaForm" method="post" action="<?= base_url('prontuarios/tramitar') ?>">
        <?= csrf_field() ?>
        <?php $validation = \Config\Services::validation();?>

        <div class="card">
            
            <div class="card-header text-black"  style="flex: 1; display: flex; justify-content: center; align-items: center;">
                <b><?= 'Enviar Prontuário' ?></b>
            </div>

            <div class="card-body has-validation row g-3" style="margin-bottom: -40px;">
                <div class="col-md-8">
                    <label for="login" class="form-label">Prontuario<b class="text-danger">*</b></label>
                    <div class="input-group mb-8">
                    <input type="text" id="prontuario" maxlength="8"
                    class="form-control <?php if($validation->getError('prontuario')): ?>is-invalid<?php endif ?>"
                    autofocus name="prontuario" value="<?= set_value('prontuario', isset($idprontuario) ? $idprontuario : '') ?>" <?= isset($idprontuario) ? 'readonly' : '' ?> />

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
                            name="volume" value="<?= set_value('volume', isset($nuvolume) ? $nuvolume : '') ?>" <?= isset($idprontuario) ? 'readonly' : '' ?> />

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
                    <label for="Setor" class="form-label">Setor de Envio<b class="text-danger">*</b></label>
                    <div class="input-group mb-12">
                        <select
                            class="form-select <?php if($validation->getError('Setor')): ?>is-invalid<?php endif ?>"
                            id="Setor" name="Setor" onchange=""
                            data-placeholder="Selecione uma opção" data-allow-clear="1">
                            <?php
                            foreach ($select['Setor'] as $key => $values) {
                                $selected = (set_value('Setor') == $values['nmSetor']) ? 'selected' : '';
                                echo '<option value="'.$values['nmSetor'].'" '.$selected.'>'.$values['nmSetor'].'</option>';
                            }
                            ?>
                        </select>

                        <?php if ($validation->getError('Setor')): ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('Setor') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="card-body has-validation row g-3">
                <div class="col-md-12">
                    <label for="dtfim" class="form-label">Previsão de Retorno<b class="text-danger">*</b></label>
                    <div class="input-group mb-12">
                        <input type="text" id="dtretorno" maxlength="10" placeholder="DD/MM/AAAA"
                            class="form-control Data <?php if($validation->getError('dtretorno')): ?>is-invalid<?php endif ?>"
                            name="dtretorno" value="<?= set_value('dtretorno', $dtretorno) ?>"/>

                        <?php if ($validation->getError('dtretorno')): ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('dtretorno') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="card-body has-validation row g-3" style="margin-top: -30px;">
                <div class="col-md-12">
                    <label for="txtObs" class="form-label">Observação</label>
                    <div class="input-group mb-12">
                        <textarea type="text" id="txtObs" maxlength="200"
                            class="form-control"
                            name="txtObs" value="<?= set_value('txtObs') ?>"></textarea>

                        <?php if ($validation->getError('txtObs')): ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('txtObs') ?>
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
                            <button class="btn btn-info mt-0" id="submit" name="submit"  type="submit" value="1"><i class="fas fas fa-paper-plane"></i> Enviar</button>
                        </div>
                        <div class="col-md-6">
                            <a class="btn btn-warning mt-0" href="javascript:history.go(-1)"><i class="fa-solid fa-arrow-left"></i> Voltar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </form>