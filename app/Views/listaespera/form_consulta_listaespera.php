<?= csrf_field() ?>
<?php $validation = \Config\Services::validation(); ?>

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card form-container">
                <div class="card-header text-center text-black">
                    <b><?= 'Consultar Fila Cirúrgica' ?></b>
                </div>
                <div class="card-body has-validation">
                    <form id="idForm" method="post" action="<?= base_url('listaespera/exibir') ?>">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="dtinicio" class="form-label">Data Início</label>
                                    <div class="input-group">
                                        <input type="text" id="dtinicio" maxlength="10" placeholder="DD/MM/AAAA"
                                            class="form-control Data <?php if($validation->getError('dtinicio')): ?>is-invalid<?php endif ?>"
                                            name="dtinicio" value="<?= set_value('dtinicio', $data['dtinicio']) ?>"/>
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
                                    <label for="dtfim" class="form-label">Data Final</label>
                                    <div class="input-group">
                                        <input type="text" id="dtfim" maxlength="10" placeholder="DD/MM/AAAA"
                                            class="form-control Data <?php if($validation->getError('dtfim')): ?>is-invalid<?php endif ?>"
                                            name="dtfim" value="<?= set_value('dtfim', $data['dtfim']) ?>"/>
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
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="especialidade" class="form-label">Especialidade</b></label>
                                    <div class="input-group">
                                        <select class="form-select select2-dropdown <?php if($validation->getError('esp')): ?>is-invalid<?php endif ?>"
                                            id="especialidade" name="especialidade" onchange=""
                                            data-placeholder="Selecione uma opção" data-allow-clear="1">
                                            <option value="" <?php echo set_select('especialidade', '', TRUE); ?> ></option>
                                            <?php
                                            foreach ($data['especialidades'] as $key => $especialidade) {
                                                $selected = (set_value('especialidade') == $especialidade->seq) ? 'selected' : '';
                                                echo '<option value="'.$especialidade->seq.'" '.$selected.'>'.$especialidade->nome_especialidade.'</option>';
                                            }
                                            ?>
                                        </select>
                                        <?php if ($validation->getError('especialidade')): ?>
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('especialidade') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
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
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="risco" class="form-label">Risco Cirúrgico</b></label>
                                    <div class="input-group">
                                        <select class="form-select select2-dropdown <?php if($validation->getError('risco')): ?>is-invalid<?php endif ?>"
                                            id="risco" name="risco" onchange="verificarPerfil()"
                                            data-placeholder="Selecione uma opção" data-allow-clear="1">
                                            <option value="" <?php echo set_select('risco', '', TRUE); ?> ></option>
                                            <?php
                                            foreach ($data['riscos'] as $key => $risco) {
                                                $selected = (set_value('risco') == $fila['id']) ? 'selected' : '';
                                                echo '<option value="'.$risco['id'].'" '.$selected.'>'.$risco['nmrisco'].'</option>';
                                            }
                                            ?>
                                        </select>
                                        <?php if ($validation->getError('risco')): ?>
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('risco') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Complexidade<b class="text-danger"></b></label>
                                    <div class="input-group bordered-container">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="complexidades[]" id="complexidadeA" value="A">
                                            <label class="form-check-label" for="complexidadeA">&nbsp;Alta</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="complexidades[]" id="complexidadeM" value="M">
                                            <label class="form-check-label" for="complexidadeM">&nbsp;Média</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="complexidades[]" id="complexidadeB" value="B">
                                            <label class="form-check-label" for="complexidadeB">&nbsp;Baixa</label>
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
            loadAsideContent(prontuarioInput.value);
        });

        $('#especialidade').change(function() {
            var selectedEspecialidade = $(this).val();
            
            // Limpar opções anteriores
            $('#fila').empty().append('<option value="">Selecione uma opção</option>');
            
            <?php foreach ($data['filas'] as $fila): ?>
            var value = '<?= $fila['id'] ?>';
            var text = '<?= $fila['nmtipoprocedimento']?>';
            var especie = '<?= $fila['idespecialidade'] ?>';
            if (!selectedEspecialidade || selectedEspecialidade === especie) {
                var option = new Option(text, value, false, false);
                $("#fila").append(option);
            }
            <?php endforeach; ?>

            // Reset e atualiza o componente Select2
            $('#fila').val('').trigger('change');
        });
    });
</script>
