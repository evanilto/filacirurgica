<?= csrf_field() ?>
<?php $validation = \Config\Services::validation(); ?>

<?= $this->include('layouts/div_flashdata') ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card form-container">
                <div class="card-header text-center text-black">
                    <b><?= 'Consultar Lista de Espera' ?></b>
                </div>
                <div class="card-body has-validation">
                    <form id="idForm" method="post" action="<?= base_url('listaespera/exibir') ?>">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="dtinicio" class="form-label">Data Início<b class="text-danger">*</b></label>
                                    <div class="input-group">
                                        <input type="text" id="dtinicio" maxlength="10" placeholder="DD/MM/AAAA"
                                            class="form-control Data <?php if($validation->getError('dtinicio')): ?>is-invalid<?php endif ?>"
                                            name="dtinicio" value="<!--?= set_value('dtinicio', $dtinicio) ?-->"/>
                                        <?php if ($validation->getError('dtinicio')): ?>
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('dtinicio') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="dtfim" class="form-label">Data Final<b class="text-danger">*</b></label>
                                    <div class="input-group">
                                        <input type="text" id="dtfim" maxlength="10" placeholder="DD/MM/AAAA"
                                            class="form-control Data <?php if($validation->getError('dtfim')): ?>is-invalid<?php endif ?>"
                                            name="dtfim" value="<!--?= set_value('dtfim', $dtfim) ?-->"/>
                                        <?php if ($validation->getError('dtfim')): ?>
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('dtfim') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="prontuario" class="form-label">Prontuario</label>
                                    <div class="input-group">
                                        <input type="text" id="prontuario" maxlength="8"
                                        class="form-control <?php if($validation->getError('prontuario')): ?>is-invalid<?php endif ?>"
                                        name="prontuario" value="" />
                                        <?php if ($validation->getError('prontuario')): ?>
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('prontuario') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="prontuariomv" class="form-label">Nome</label>
                                    <div class="input-group">
                                        <input type="text" id="prontuariomv" maxlength="7"
                                        class="form-control <?php if($validation->getError('prontuariomv')): ?>is-invalid<?php endif ?>"
                                        name="prontuariomv" value="" />
                                        <?php if ($validation->getError('prontuariomv')): ?>
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('prontuariomv') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="Setor" class="form-label">Especialidade<b class="text-danger">*</b></label>
                                    <div class="input-group">
                                        <select class="form-select <?php if($validation->getError('Setor')): ?>is-invalid<?php endif ?>"
                                            id="Setor" name="Setor" onchange=""
                                            data-placeholder="Selecione uma opção" data-allow-clear="1">
                                            <?php
                                            /* foreach ($selectSetor['Setor'] as $key => $setor) {
                                                $setorenconded = $setor['idSetor'].'#'.$setor['nmSetor'].'#'.$setor['origSetor'];
                                                $selected = (set_value('Setor') == $setorenconded) ? 'selected' : '';
                                                echo '<option value="'.$setorenconded.'" '.$selected.'>'.$setor['nmSetor'].'</option>';
                                            } */
                                            ?>
                                        </select>
                                        <?php if ($validation->getError('nmSetor')): ?>
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('nmSetor'.$i) ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="idPerfil" class="form-label">Fila Cirúrgica<b class="text-danger">*</b></label>
                                    <div class="input-group">
                                        <select class="form-select <?php if($validation->getError('idPerfil')): ?>is-invalid<?php endif ?>"
                                            id="idPerfil" name="idPerfil" onchange="verificarPerfil()"
                                            data-placeholder="Selecione uma opção" data-allow-clear="1">
                                            <?php
                                            /* foreach ($selectPerfil as $key => $perfil) {
                                                $selected = (set_value('idPerfil') == $perfil['id']) ? 'selected' : '';
                                                echo '<option value="'.$perfil['id'].'" '.$selected.'>'.$perfil['nmPerfil'].'</option>';
                                            } */
                                            ?>
                                        </select>
                                        <?php if ($validation->getError('idPerfil')): ?>
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('idPerfil'.$i) ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="idPerfil" class="form-label">Risco Cirúrgico<b class="text-danger">*</b></label>
                                    <div class="input-group">
                                        <select class="form-select <?php if($validation->getError('idPerfil')): ?>is-invalid<?php endif ?>"
                                            id="idPerfil" name="idPerfil" onchange="verificarPerfil()"
                                            data-placeholder="Selecione uma opção" data-allow-clear="1">
                                            <?php
                                            /* foreach ($selectPerfil as $key => $perfil) {
                                                $selected = (set_value('idPerfil') == $perfil['id']) ? 'selected' : '';
                                                echo '<option value="'.$perfil['id'].'" '.$selected.'>'.$perfil['nmPerfil'].'</option>';
                                            } */
                                            ?>
                                        </select>
                                        <?php if ($validation->getError('idPerfil')): ?>
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('idPerfil'.$i) ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Complexidade<b class="text-danger">*</b></label>
                                    <div class="input-group bordered-container">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="indSituacao" id="indSituacaoA" value="A" checked>
                                            <label class="form-check-label" for="indSituacaoA">&nbsp;Ativo</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="indSituacao" id="indSituacaoI" value="I">
                                            <label class="form-check-label" for="indSituacaoI">&nbsp;Inativo</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <button class="btn btn-primary mt-3" id="submit" name="submit" type="submit" value="1">
                                    <i class="fa-solid fa-search"></i> Consultar
                                </button>
                                <a class="btn btn-warning mt-3" href="javascript:history.go(-1)">
                                    <i class="fa-solid fa-arrow-left"></i> Voltar
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
