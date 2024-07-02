<form id="idForm" method="post" action="<?= base_url('relatorios/prontuariosretidos') ?>" class="w-50" style="margin-left: -10px;">
    <?= csrf_field() ?>
    <?php $validation = \Config\Services::validation(); ?>

    <div class="card">
        <div class="card-header text-black" style="flex: 1; display: flex; justify-content: center; align-items: center;">
            <b><?= 'Consultar Prontuários Retidos' ?></b>
        </div>

        <div class="card-body has-validation">
            <!-- Setor Destino -->
            <div class="row g-3">
                <div class="col-md-12" id="campoSetorDestino">
                    <label for="SetorDestino" class="form-label" autofocus>Setores Destino</b></label>
                    <div class="input-group mb-12 bordered-container">
                        <div class="container-setor-tramite" style="max-height: 290px; overflow-y: auto;">
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
