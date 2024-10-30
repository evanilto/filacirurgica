<?= csrf_field() ?>
<?php $validation = \Config\Services::validation(); ?>
    
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card form-container">
                <div class="card-header text-center text-black">
                    <b><?= 'Incluir Usuário' ?></b>
                </div>
                <div class="card-body has-validation d-flex flex-column align-items-center">
                    <form id="UsuarioForm" method="post" action="<?= base_url('usuarios/incluir') ?>" class="w-100">
                        <div class="row g-3">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="login" class="form-label">Login<b class="text-danger">*</b></label>
                                    <div class="input-group mb-12">
                                        <input type="text" id="login" maxlength="100"
                                            class="form-control <?php if($validation->getError('login')): ?>is-invalid<?php endif ?>"
                                            autofocus name="login" value="<?= set_value('login') ?>"/>

                                        <?php if ($validation->getError('login')): ?>
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('login') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="perfis" class="form-label" autofocus>Perfis<b class="text-danger">*</b></label>
                                    <div class="input-group mb-12 bordered-container">
                                        <div style="max-height: 200px; overflow-y: auto;">
                                            <?php
                                            foreach ($selectPerfil as $key => $perfil) {
                                                $perfilenconded = $perfil['id'].'#'.$perfil['nmperfil'];
                                                echo '<div class="form-check"><input class="form-check-input" type="checkbox" id="perfil'.$key.'" name="perfil[]" value="'.$perfilenconded.'" ><label class="form-check-label" for="perfil'.$key.'">'.$perfil['nmperfil'].'</label></div>';
                                            }
                                            ?>

                                            <?php if ($validation->getError('perfil')): ?>
                                                <div class="invalid-feedback">
                                                    <?= $validation->getError('perfil') ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label class="form-label">Situação<b class="text-danger">*</b></label>
                                    <div class="input-group mb-3 bordered-container">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="indSituacao" id="indSituacaoA" value="A" checked>
                                            <label class="form-check-label" for="indSituacaoA" style="margin-right: 10px;">&nbsp;Ativo</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="indSituacao" id="indSituacaoI" value="I">
                                            <label class="form-check-label" for="indSituacaoI" style="margin-right: 10px;">&nbsp;Inativo</label>
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
                                <a class="btn btn-warning mt-3" href="<?= base_url('home_index') ?>">
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
