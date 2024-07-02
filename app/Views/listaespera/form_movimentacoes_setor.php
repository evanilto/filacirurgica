<form id="idForm" method="post" action="<?= base_url('relatorios/qtdmovimentacoessetor') ?>" class="w-50" style="margin-left: -10px;">
    <?= csrf_field() ?>
    <?php $validation = \Config\Services::validation(); ?>

    <div class="card">
        <div class="card-header text-black" style="flex: 1; display: flex; justify-content: center; align-items: center;">
            <b><?= 'Movimentações entre Setores' ?></b>
        </div>

        <div class="card-body has-validation">
            <div class="row g-3">
                <!-- Data Início -->
                <div class="col-md-6">
                    <label for="dtinicio" class="form-label">Data Início<b class="text-danger">*</b></label>
                    <div class="input-group mb-3">
                        <input type="text" id="dtinicio" maxlength="10" placeholder="DD/MM/AAAA"
                            class="form-control Data <?php if($validation->getError('dtinicio')): ?>is-invalid<?php endif ?>"
                            autofocus name="dtinicio" value="<?= set_value('dtinicio', $dtinicio) ?>" />

                        <?php if ($validation->getError('dtinicio')): ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('dtinicio') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Data Final -->
                <div class="col-md-6">
                    <label for="dtfim" class="form-label">Data Final<b class="text-danger">*</b></label>
                    <div class="input-group mb-3">
                        <input type="text" id="dtfim" maxlength="10" placeholder="DD/MM/AAAA"
                            class="form-control Data <?php if($validation->getError('dtfim')): ?>is-invalid<?php endif ?>"
                            autofocus name="dtfim" value="<?= set_value('dtfim', $dtfim) ?>" />

                        <?php if ($validation->getError('dtfim')): ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('dtfim') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Setor Origem e Setor Destino -->
            <div class="row g-3">
                <!-- Setor Origem -->
                <div class="col-md-6" id="campoSetorOrigem">
                    <label for="SetorOrigem" class="form-label" autofocus>Setores Origem</label>
                    <div class="input-group mb-12 bordered-container">
                        <div class="container-setor-Destino" style="max-height: 200px; overflow-y: auto;">
                            <?php
                            foreach ($selectSetorOrigem['Setor'] as $key => $setor) {
                                $setorenconded = $setor['idSetor'].'#'.$setor['nmSetor'].'#'.$setor['origSetor'];
                                $checked = (set_value('setorOrigem'.$key) == $setor['nmSetor']) ? 'checked' : '';
                                echo '<div class="form-check"><input class="form-check-input" type="checkbox" id="setorOrigem'.$key.'" name="setorOrigem[]" value="'.$setorenconded.'" '.$checked.'><label class="form-check-label" for="setorOrigem'.$key.'">'.$setor['nmSetor'].'</label></div>';
                            }
                            ?>
                        </div>
                    </div>
                    <?php if ($validation->getError('nmSetor')): ?>
                        <div class="invalid-feedback">
                            <?= $validation->getError('nmSetor'.$i) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <!-- Setor Destino -->
                <div class="col-md-6" id="campoSetorDestino">
                    <label for="SetorDestino" class="form-label" autofocus>Setores Destino</b></label>
                    <div class="input-group mb-12 bordered-container">
                        <div class="container-setor-tramite" style="max-height: 200px; overflow-y: auto;">
                            <?php
                            foreach ($selectSetorDestino['Setor'] as $key => $setor) {
                                $setorenconded = $setor['idSetor'].'#'.$setor['nmSetor'].'#'.$setor['origSetor'];
                                echo '<div class="form-check"><input class="form-check-input" type="checkbox" id="setorDestino'.$key.'" name="setorDestino[]" value="'.$setorenconded.'" ><label class="form-check-label" for="setorDestino'.$key.'">'.$setor['nmSetor'].'</label></div>';
                            }
                            ?>
                        </div>
                    </div>
                    <?php if ($validation->getError('nmSetor')): ?>
                        <div class="invalid-feedback">
                            <?= $validation->getError('nmSetor'.$i) ?>
                        </div>
                    <?php endif; ?>
                </div>                
            </div>

            <hr />

            <!-- Buttons -->
            <div class="card-body text-center">
                <div class="row">
                    <div class="col-md-6">
                        <button class="btn btn-info mt-0" id="submit" name="submit" type="submit" value="1"><i class="fas fa-search"></i> Consultar</button>
                    </div>
                    <div class="col-md-6">
                        <a class="btn btn-warning mt-0" href="javascript:history.go(-1)"><i class="fa-solid fa-arrow-left"></i> Voltar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
