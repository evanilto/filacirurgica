<?= csrf_field() ?>
<?php $validation = \Config\Services::validation(); ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card form-container">
                <div class="card-header text-center text-black">
                    <b><?= 'Consultar Situação Cirúrgica/PDT' ?></b>
                </div>
                <div class="card-body has-validation">
                    <form id="idForm" method="post" action="<?= base_url('listaespera/exibirsituacao') ?>">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="mb-2">
                                    <label for="prontuario" class="form-label">Prontuario</label>
                                    <div class="input-group">
                                        <input type="number" id="prontuario" maxlength="8"
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
                                <div class="mb-2">
                                    <label for="nome" class="form-label">Nome</label>
                                    <div class="input-group">
                                        <input type="text" id="nome" minlength="3"
                                        class="form-control <?php if($validation->getError('nome')): ?>is-invalid<?php endif ?>"
                                        name="nome" value="" />
                                        <?php if ($validation->getError('nome')): ?>
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('nome') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-12">
                                <div class="mb-2">
                                    <label for="fila" class="form-label">Fila Cirúrgica</b></label>
                                    <div class="input-group">
                                        <select class="form-select select2-dropdown <?php if($validation->getError('fila')): ?>is-invalid<?php endif ?>"
                                            id="fila" name="fila"
                                            data-placeholder="Selecione uma opção" data-allow-clear="1">
                                            <option value="" <?php echo set_select('fila', '', TRUE); ?> ></option>
                                            <?php
                                            foreach ($data['filas'] as $key => $fila) {
                                                $selected = (set_value('fila') == $fila['id']) ? 'selected' : '';
                                                echo '<option value="'.$fila['id'].'" '.$selected.'>'.$fila['nmtipoprocedimento'].'</option>';
                                            }
                                            ?>
                                        </select>
                                        <?php if ($validation->getError('fila')): ?>
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('fila') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row g-3">
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
<script>
    $(document).ready(function() {
        $('#idForm').submit(function(event) {
            $('#janelaAguarde').show();
            setTimeout(function() {
            window.location.href = href;
            }, 1000);
        });

        $('.select2-dropdown').select2({
            //dropdownCssClass: 'custom-dropdown',
        });

        const prontuarioInput = document.getElementById('prontuario');

        prontuarioInput.addEventListener('change', function() {
            fetchPacienteNome(prontuarioInput.value);
            //loadAsideContent(prontuarioInput.value);
        });
    });
</script>
