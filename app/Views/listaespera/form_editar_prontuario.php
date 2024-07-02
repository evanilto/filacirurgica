    <form id="prontuarioForm" method="post" action="<?= base_url("prontuarios/editar/$id") ?>">
        <?= csrf_field() ?>
        <?php $validation = \Config\Services::validation(); ?>

        <div class="card">
            
            <div class="card-header text-black"  style="flex: 1; display: flex; justify-content: center; align-items: center;">
                <b><?= 'Alterar Prontuario' ?></b>
            </div>

            <div class="card-body has-validation row g-4">

                <div class="col-md-5">
                    <label for="numProntuarioAGHU" class="form-label">Número AGHU</label>
                    <div class="input-group mb-12">
                        <input type="text" id="numProntuarioAGHU" maxlength="50" readonly
                            class="form-control <?php if($validation->getError('numProntuarioAGHU')): ?>is-invalid<?php endif ?>"
                            name="numProntuarioAGHU" value="<?= $numProntuarioAGHU ?>"/>

                        <?php if ($validation->getError('numProntuarioAGHU')): ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('numProntuarioAGHU') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="col-md-3">
                    <label for="numVolume" class="form-label">Volume</label>
                    <div class="input-group mb-12">
                        <input type="text" id="numVolume" maxlength="50" readonly
                            class="form-control <?php if($validation->getError('numVolume')): ?>is-invalid<?php endif ?>"
                            name="numVolume" value="<?= $numVolume ?>"/>

                        <?php if ($validation->getError('numVolume')): ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('numVolume') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="col-md-4">
                    <label for="numProntuarioMV" class="form-label">Número MV</label>
                    <div class="input-group mb-12">
                        <input type="text" id="numProntuarioMV" maxlength="50" readonly
                            class="form-control <?php if($validation->getError('numProntuarioMV')): ?>is-invalid<?php endif ?>"
                            name="numProntuarioMV" value="<?= $numProntuarioMV ?>"/>

                        <?php if ($validation->getError('numProntuarioMV')): ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('numProntuarioMV') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
            
            <div class="card-body has-validation row g-4">

                <div class="col-md-3">
                    <label for="numSala" class="form-label">Sala</b></label>
                    <div class="input-group mb-12">
                        <input type="text" id="numSala" maxlength="2" 
                            class="form-control <?php if($validation->getError('numSala')): ?>is-invalid<?php endif ?>"
                            name="numSala" value="<?= $numSala ?>"/>

                        <?php if ($validation->getError('numSala')): ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('numSala') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="col-md-3">
                    <label for="numArmario" class="form-label">Armário</b></label>
                    <div class="input-group mb-12">
                        <input type="text" id="numArmario" maxlength="2" 
                            class="form-control <?php if($validation->getError('numArmario')): ?>is-invalid<?php endif ?>"
                            name="numArmario" value="<?= $numArmario ?>"/>

                        <?php if ($validation->getError('numArmario')): ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('numArmario') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="col-md-3">
                    <label for="numLinha" class="form-label">Linha</b></label>
                    <div class="input-group mb-12">
                        <input type="text" id="numLinha" maxlength="2" 
                            class="form-control <?php if($validation->getError('numLinha')): ?>is-invalid<?php endif ?>"
                            name="numLinha" value="<?= $numLinha ?>"/>

                        <?php if ($validation->getError('numLinha')): ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('numLinha') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="col-md-3">
                    <label for="numColuna" class="form-label">Coluna</b></label>
                    <div class="input-group mb-12">
                        <input type="text" id="numColuna" maxlength="2" 
                            class="form-control <?php if($validation->getError('numColuna')): ?>is-invalid<?php endif ?>"
                            name="numColuna" value="<?= $numColuna ?>"/>

                        <?php if ($validation->getError('numColuna')): ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('numColuna') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

            </div>

            <div class="card-body has-validation row g-4">

            <div class="col-md-12">
                <label for="txtObs" class="form-label">Observação</label>
                <div class="input-group mb-12">
                    <textarea id="txtObs" maxlength="200" 
                        class="form-control <?php if($validation->getError('txtObs')): ?>is-invalid<?php endif ?>"
                        name="txtObs"><?= $txtObs ?></textarea>

                    <?php if ($validation->getError('txtObs')): ?>
                        <div class="invalid-feedback">
                            <?= $validation->getError('txtObs') ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>


            </div>

            <input type="hidden" name="id" id="id" value="<?= $id ?>" />
            <input type="hidden" name="nmPaciente" id="nmPaciente" value="<?= $nmPaciente ?>" />
            <input type="hidden" name="nmMae" id="nmMae" value="<?= $nmMae ?>" />
            <input type="hidden" name="dtNascimento" id="dtNascimento" value="<?= $dtNascimento ?>" />
            <input type="hidden" name="nmSetorAtual" id="nmSetorAtual" value="<?= $nmSetorAtual ?>" />


            <!-- <input type="submit" id="submitSetor" value="Cria Setor"> -->

            <hr />
            <div class="col-md-12">
                <div class="card-body text-center">
                    <div class="row">
                        <div class="col-md-6">
                            <button class="btn btn-info mt-1" id="submit" name="submit"  type="submit" value="1"><i class="fa-solid fa-save"></i> Salvar</button>
                        </div>
                        <div class="col-md-6">
                            <a class="btn btn-warning mt-1" href="<?= base_url('prontuarios/consultar')?>"><i class="fa-solid fa-arrow-left"></i> Voltar</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </form>