<?= csrf_field() ?>
<?php $validation = \Config\Services::validation(); ?>

<?php
    // Inicializando valores padrão
    $data['eqpts'] = isset($data['eqpts']) ? (array)$data['eqpts'] : [];
    $data['usarEquipamentos'] = $data['usarEquipamentos'] ?? 'N'; 
    $data['hemocomps'] = isset($data['hemocomps']) ? (array)$data['hemocomps'] : [];
    $data['usarHemocomponentes'] = $data['usarHemocomponentes'] ?? 'N'; 
    //dd($data);
?>

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card form-container">
                <div class="card-header text-center text-black">
                    <b><?= 'Enviar para o Mapa Cirúrgico/PDT' ?></b>
                </div>
                <div class="card-body has-validation">
                    <form id="idForm" method="post" action="<?= base_url('listaespera/enviar') ?>">
                        <div class="row g-3">
                            <div class="col-md-2">
                                <div class="mb-2">
                                    <label for="dtcirurgia" class="form-label">Data Cirurgia<b class="text-danger">*</b></label>
                                    <div class="input-group">
                                        <input type="text" id="dtcirurgia" maxlength="10" placeholder="DD/MM/AAAA"
                                            class="form-control input-data <?php if($validation->getError('dtcirurgia')): ?>is-invalid<?php endif ?>"
                                            name="dtcirurgia" value="<?= set_value('dtcirurgia', $data['dtcirurgia']) ?>" />
                                        <?php if ($validation->getError('dtcirurgia')): ?>
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('dtcirurgia') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-2">
                                    <label for="hrcirurgia" class="form-label">Hora Cirurgia<b class="text-danger">*</b></label>
                                    <div class="input-group">
                                        <input type="time" id="hrcirurgia" maxlength="5" placeholder="HH:MM"
                                            class="form-control input-hora <?php if($validation->getError('hrcirurgia')): ?>is-invalid<?php endif ?>"
                                            name="hrcirurgia" value="<?= set_value('hrcirurgia', $data['hrcirurgia']) ?>" />
                                        <?php if ($validation->getError('hrcirurgia')): ?>
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('hrcirurgia') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-2">
                                    <label for="tempoprevisto" class="form-label">Tempo Previsto Cirurgia<b class="text-danger">*</b></label>
                                    <div class="input-group">
                                        <input type="time" id="tempoprevisto" maxlength="5" placeholder="HH:MM"
                                            class="form-control input-hora <?php if($validation->getError('tempoprevisto')): ?>is-invalid<?php endif ?>"
                                            name="tempoprevisto" value="<?= set_value('tempoprevisto', $data['tempoprevisto']) ?>" />
                                        <?php if ($validation->getError('tempoprevisto')): ?>
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('tempoprevisto') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="mb-2">
                                    <label for="prontuario" class="form-label">Prontuario</label>
                                    <div class="input-group">
                                        <input type="number" id="prontuario" maxlength="8" disabled
                                        class="form-control <?php if($validation->getError('prontuario')): ?>is-invalid<?php endif ?>"
                                        name="prontuario" value="<?= set_value('prontuario', $data['prontuario']) ?>" disabled/>
                                        <?php if ($validation->getError('prontuario')): ?>
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('prontuario') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="mb-2">
                                    <label for="nome" class="form-label">Nome</label>
                                    <div class="input-group">
                                        <input type="text" id="nome" minlength="3" disabled
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
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label for="especialidade" class="form-label">Especialidade</label>
                                    <div class="input-group">
                                        <select class="form-select select2-dropdown <?php if($validation->getError('especialidade')): ?>is-invalid<?php endif ?>"
                                            id="especialidade" name="especialidade"
                                            data-placeholder="Selecione uma opção" data-allow-clear="1" disabled>
                                        <option value="" <?php echo set_select('especialidade', '', TRUE); ?>></option>
                                        <?php
                                        foreach ($data['especialidades'] as $especialidade) {
                                            $selected = ($data['especialidade'] == $especialidade->seq) ? 'selected' : '';
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
                                <div class="mb-2">
                                    <label for="fila" class="form-label">Fila Cirúrgica</label>
                                    <div class="input-group">
                                        <select class="form-select select2-dropdown <?php if($validation->getError('fila')): ?>is-invalid<?php endif ?>"
                                            id="fila" name="fila"
                                            data-placeholder="Selecione uma opção" data-allow-clear="1" disabled>
                                            <option value="" <?php echo set_select('fila', '', TRUE); ?> ></option>
                                            <?php
                                            foreach ($data['filas'] as $key => $fila) {
                                                $selected = ($data['fila'] == $fila['id']) ? 'selected' : '';
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
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label for="procedimento" class="form-label">Procedimento Principal</label>
                                    <div class="input-group">
                                        <select class="form-select select2-dropdown <?php if($validation->getError('procedimento')): ?>is-invalid<?php endif ?>"
                                            id="procedimento" name="procedimento"
                                            data-placeholder="Selecione uma opção" data-allow-clear="1" disabled>
                                            <option value="" <?php echo set_select('procedimento', '', TRUE); ?> ></option>
                                            <?php
                                            foreach ($data['procedimentos'] as $key => $procedimento) {
                                                $selected = ($data['procedimento'] == $procedimento->cod_tabela) ? 'selected' : '';
                                                echo '<option value="'.$procedimento->cod_tabela.'" '.$selected.'>'.$procedimento->cod_tabela.' - '.$procedimento->descricao.'</option>';
                                            }
                                            ?>
                                        </select>
                                        <?php if ($validation->getError('procedimento')): ?>
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('procedimento') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label for="proced_adic" class="form-label">Procedimentos Adicionais</label>
                                    <div class="input-group">
                                        <select class="form-select select2-dropdown <?= $validation->hasError('proced_adic') ? 'is-invalid' : '' ?>"
                                                id="proced_adic" name="proced_adic[]" multiple="multiple"
                                                data-placeholder="" data-allow-clear="1">
                                            <?php
                                            // Certifique-se de que $data['proced_adic'] está definido como um array
                                            $data['proced_adic'] = isset($data['proced_adic']) ? (array)$data['proced_adic'] : [];
                                            $data['proced_adic'] = array_filter($data['proced_adic']);
                                            
                                            foreach ($data['procedimentos_adicionais'] as $procedimento) {
                                                $selected = in_array($procedimento->cod_tabela, $data['proced_adic']) ? 'selected' : '';
                                                echo '<option value="' . $procedimento->cod_tabela . '" ' . $selected . '>' . $procedimento->cod_tabela . ' - ' . $procedimento->descricao . '</option>';
                                            }
                                            ?>
                                        </select>
                                        <?php if ($validation->hasError('proced_adic')): ?>
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('proced_adic') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label for="cid" class="form-label">CID</label>
                                    <div class="input-group">
                                        <select class="form-select select2-dropdown <?php if($validation->getError('cid')): ?>is-invalid<?php endif ?>"
                                            id="cid" name="cid"
                                            data-placeholder="" data-allow-clear="1">
                                            <option value="" <?php echo set_select('cid', '', TRUE); ?> ></option>
                                            <?php
                                            foreach ($data['cids'] as $key => $cid) {
                                                $selected = ($data['cid'] == $cid->seq) ? 'selected' : '';
                                                echo '<option value="'.$cid->seq.'" '.$selected.'>'.$cid->codigo.' - '.$cid->descricao.'</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <?php if ($validation->getError('cid')): ?>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('cid') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-2">
                                    <label for="risco" class="form-label">Risco Cirúrgico<b class="text-danger">*</b></label>
                                    <div class="input-group">
                                        <select class="form-select select2-dropdown <?php if($validation->getError('risco')): ?>is-invalid<?php endif ?>"
                                            id="risco" name="risco" disabled
                                            data-placeholder="Selecione uma opção" data-allow-clear="1">
                                            <option value="" <?php echo set_select('risco', '', TRUE); ?> ></option>
                                            <?php
                                            foreach ($data['riscos'] as $key => $risco) {
                                                $selected = ($data['risco'] == $risco['id']) ? 'selected' : '';
                                                $enabled = ($risco['indsituacao'] == 'I') ? 'disabled' : ''; 
                                                echo '<option value="'.$risco['id'].'" '.$selected.' '.$enabled.'>'.$risco['nmrisco'].'</option>';
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
                            <div class="col-md-2">
                                <div class="mb-2">
                                    <label for="dtrisco" class="form-label">Data Risco<b class="text-danger">*</b></label>
                                    <div class="input-group">
                                        <input type="text" id="dtrisco" maxlength="10" placeholder="DD/MM/AAAA" readonly
                                            class="form-control Data <?php if($validation->getError('dtrisco')): ?>is-invalid<?php endif ?>"
                                            name="dtrisco" value="<?= set_value('dtrisco', $data['dtrisco']) ?>"/>
                                        <?php if ($validation->getError('dtrisco')): ?>
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('dtrisco') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-2">
                                    <label for="lateralidade" class="form-label">Lateralidade<b class="text-danger">*</b></label>
                                    <div class="input-group">
                                        <select class="form-select select2-dropdown <?php if($validation->getError('lateralidade')): ?>is-invalid<?php endif ?>"
                                            id="lateralidade" name="lateralidade"
                                            data-placeholder="Selecione uma opção" data-allow-clear="1">
                                            <option value="" <?php echo set_select('lateralidade', '', TRUE); ?> ></option>
                                            <?php
                                            foreach ($data['lateralidades'] as $key => $lateralidade) {
                                                $selected = ($data['lateralidade'] == $lateralidade['id']) ? 'selected' : '';
                                                $enabled = ($lateralidade['indsituacao'] == 'I') ? 'disabled' : ''; 
                                                echo '<option value="'.$lateralidade['id'].'" '.$selected.' '.$enabled.'>'.$lateralidade['descricao'].'</option>';
                                            }
                                            ?>
                                        </select>
                                        <?php if ($validation->getError('lateralidade')): ?>
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('lateralidade') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-2">
                                <div class="mb-2">
                                    <label for="origem" class="form-label">Origem Paciente</label>
                                    <div class="input-group">
                                        <select class="form-select select2-dropdown <?php if($validation->getError('origem')): ?>is-invalid<?php endif ?>"
                                            id="origem" name="origem"
                                            data-placeholder="N/D" data-allow-clear="1" disabled>
                                            <option value="" <?php echo set_select('origem', '', TRUE); ?> ></option>
                                            <?php
                                            foreach ($data['origens'] as $key => $origem) {
                                                $selected = ($data['origem'] == $origem['id']) ? 'selected' : '';
                                                $enabled = ($origem['indsituacao'] == 'I') ? 'disabled' : ''; 
                                                echo '<option value="'.$origem['id'].'" '.$selected.' '.$enabled.'>'.$origem['nmorigem'].'</option>';
                                            }
                                            ?>
                                        </select>
                                        <?php if ($validation->getError('origem')): ?>
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('origem') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-2">
                                    <label for="unidadeorigem" class="form-label">Unidade de Origem</label>
                                    <select class="form-select select2-dropdown <?php if($validation->getError('cid')): ?>is-invalid<?php endif ?>" 
                                            id="unidadeorigem" name="unidadeorigem"
                                            data-placeholder="N/D" data-allow-clear="1" disabled> 
                                            <option value="" <?php echo set_select('unidadeorigem', '', TRUE); ?> ></option>
                                            <?php
                                            foreach ($data['unidades'] as $key => $unidade) {
                                                $selected = ($data['unidadeorigem'] == $unidade->seq) ? 'selected' : '';
                                                echo '<option value="'.$unidade->seq.'" '.$selected.'>'.$unidade->nome.'</option>';
                                            }
                                            ?>
                                        </select>
                                        <?php if ($validation->getError('unidadeorigem')): ?>
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('unidadeorigem') ?>
                                            </div>
                                        <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-2">
                                    <label for="posoperatorio" class="form-label">Pós-Operatório<b class="text-danger">*</b></label>
                                    <div class="input-group">
                                        <select class="form-select select2-dropdown <?php if($validation->getError('posoperatorio')): ?>is-invalid<?php endif ?>"
                                            id="posoperatorio" name="posoperatorio"
                                            data-placeholder="Selecione uma opção" data-allow-clear="1">
                                            <option value="" <?php echo set_select('posoperatorio', '', TRUE); ?> ></option>
                                            <?php
                                            foreach ($data['posoperatorios'] as $key => $posoperatorio) {
                                                $selected = ($data['posoperatorio'] == $posoperatorio['id']) ? 'selected' : '';
                                                echo '<option value="'.$posoperatorio['id'].'" '.$selected.'>'.$posoperatorio['descricao'].'</option>';
                                            }
                                            ?>
                                        </select>
                                        <?php if ($validation->getError('posoperatorio')): ?>
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('posoperatorio') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-2">
                                    <label class="form-label">Congelação<b class="text-danger">*</b></label>
                                    <div class="input-group mb-2 bordered-container">
                                        <div class="form-check form-check-inline <?php if($validation->getError('congelacao')): ?>is-invalid<?php endif ?>">
                                            <input class="form-check-input" type="radio" name="congelacao" id="congelacaoN" value="N"
                                                <?= (isset($data['congelacao']) && $data['congelacao'] == 'N') ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="congelacaoN" style="margin-right: 10px;">&nbsp;Não</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="congelacao" id="congelacaoS" value="S"
                                                <?= (isset($data['congelacao']) && $data['congelacao'] == 'S') ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="congelacaoS" style="margin-right: 10px;">&nbsp;Sim</label>
                                        </div>
                                        <?php if ($validation->getError('congelacao')): ?>
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('congelacao') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-2">
                                    <label class="form-label">Complexidade<b class="text-danger">*</b></label>
                                    <div class="input-group mb-2 bordered-container">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="complexidade" id="complexidadeA" value="A"
                                                <?= (isset($data['complexidade']) && $data['complexidade'] == 'A') ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="complexidadeA" style="margin-right: 10px;">&nbsp;Alta</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="complexidade" id="complexidadeM" value="M"
                                                <?= (isset($data['complexidade']) && $data['complexidade'] == 'M') ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="complexidadeM" style="margin-right: 10px;">&nbsp;Média</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="complexidade" id="complexidadeB" value="B"
                                                <?= (isset($data['complexidade']) && $data['complexidade'] == 'B') ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="complexidadeB" style="margin-right: 10px;">&nbsp;Baixa</label>
                                        </div>
                                    </div>
                                    <?php if ($validation->getError('complexidade')): ?>
                                        <div class="invalid-feedback d-block">
                                            <?= $validation->getError('complexidade') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <!-- <div class="col-md-2">
                                <div class="mb-2">
                                    <label class="form-label">Hemoderivados<b class="text-danger">*</b></label>
                                    <div class="input-group mb-2 bordered-container">
                                        <div class="form-check form-check-inline <-?php if($validation->getError('hemoderivados')): ?>is-invalid<-?php endif ?>">
                                            <input class="form-check-input" 
                                                type="radio" name="hemoderivados" id="hemoderivadosN" value="N"
                                                <-?= (isset($data['hemoderivados']) && $data['hemoderivados'] == 'N') ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="hemoderivadosN" style="margin-right: 10px;">&nbsp;Não</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" 
                                                type="radio" name="hemoderivados" id="hemoderivadosS" value="S"
                                                <-?= (isset($data['hemoderivados']) && $data['hemoderivados'] == 'S') ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="hemoderivadosS" style="margin-right: 10px;">&nbsp;Sim</label>
                                        </div>
                                        <-?php if ($validation->getError('hemoderivados')): ?>
                                            <div class="invalid-feedback">
                                                <-?= $validation->getError('hemoderivados') ?>
                                            </div>
                                        <-?php endif; ?>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                        <div class="row g-2">
                            <div class="col-md-2">
                                <div class="mb-2">
                                    <label for="tipo_sanguineo" class="form-label">Tipo Sanguíneo</label>
                                    <select class="form-select select2-dropdown <?= ($validation->getError('tipo_sanguineo')) ? 'is-invalid' : '' ?>" disabled
                                        name="tipo_sanguineo" id="tipo_sanguineo"
                                        data-placeholder="N/D"
                                        data-allow-clear="<?php echo empty($data['tipo_sanguineo']) ? '1' : '0'; ?>">
                                        <?php if (empty($data['tipo_sanguineo'])): ?>
                                            <option value="" <?php echo set_select('tipo_sanguineo', '', TRUE); ?> ></option>
                                        <?php endif; ?>
                                        <?php
                                            $tipos = ['A (+)', 'A (-)', 'B (+)', 'B (-)', 'AB (+)', 'AB (-)', 'O (+)', 'O (-)'];
                                            foreach ($tipos as $tipo):
                                                $selected = ($data['tipo_sanguineo'] == $tipo) ? 'selected' : '';
                                                echo '<option value="'.$tipo.'" '.$selected.'>&nbsp;'.$tipo.'</option>';
                                            endforeach;
                                        ?>
                                    </select>
                                    <?php if ($validation->getError('tipo_sanguineo')): ?>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('tipo_sanguineo') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-2">
                                    <label class="form-label">OPME<b class="text-danger">*</b></label>
                                    <div class="input-group mb-2 bordered-container">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="opme" id="opmeN" value="N"
                                                <?= (isset($data['opme']) && $data['opme'] == 'N') ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="opmeN" style="margin-right: 10px;">&nbsp;Não</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="opme" id="opmeS" value="S"
                                                <?= (isset($data['opme']) && $data['opme'] == 'S') ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="opmeS" style="margin-right: 10px;">&nbsp;Sim</label>
                                        </div>
                                    </div>
                                </div>
                                <?php if ($validation->getError('opme')): ?>
                                    <div class="invalid-feedback d-block">
                                        <?= $validation->getError('opme') ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <!-- Usar Hemocomponentes (já presente) -->
                            <div class="col-md-2">
                                <div class="mb-2">
                                    <label class="form-label">Hemocomponentes<b class="text-danger">*</b></label>
                                    <div class="input-group mb-2 bordered-container">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="usarHemocomponentes" id="usarHemocomponentesN" value="N"
                                                <?= (isset($data['usarHemocomponentes']) && $data['usarHemocomponentes'] == 'N') ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="usarHemocomponentesN" style="margin-right: 10px;">&nbsp;Não</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="usarHemocomponentes" id="usarHemocomponentesS" value="S"
                                                <?= (isset($data['usarHemocomponentes']) && $data['usarHemocomponentes'] == 'S') ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="usarHemocomponentesS" style="margin-right: 10px;">&nbsp;Sim</label>
                                        </div>
                                    </div>
                                </div>
                                <?php if ($validation->getError('usarHemocomponentes')): ?>
                                    <div class="invalid-feedback d-block">
                                        <?= $validation->getError('usarHemocomponentes') ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="row g-3 mb-2">
                            <!-- Lista de hemocomponentes com campo de quantidade -->
                            <div class="col-md-12" id="hemocomp-section">
                                <div class="mb-4">
                                    <label class="form-label">Selecionar Hemocomponentes e Quantidade</label>
                                    <div class="bordered-container py-3"> <!-- Apenas padding vertical -->
                                        <div class="row gx-3 px-3"> <!-- gx-3 = espaçamento horizontal entre colunas -->
                                            <?php foreach ($data['hemocomponentes'] as $hemocomp): 
                                                $checked = isset($data['hemocomps'][$hemocomp->id]);
                                                $quant = isset($data['hemocomp_qty'][$hemocomp->id]) ? htmlspecialchars($data['hemocomp_qty'][$hemocomp->id]) : '';
                                            ?>
                                                <div class="col-md-6 mb-3">
                                                    <div class="row align-items-center">
                                                        <div class="col-9">
                                                            <div class="form-check">
                                                                <input class="form-check-input hemocomp-checkbox" type="checkbox" 
                                                                    id="hemocomp_<?= $hemocomp->id ?>" 
                                                                    name="hemocomps[<?= $hemocomp->id ?>]" 
                                                                    value="<?= $quant ?>"
                                                                    <?= $checked ? 'checked' : '' ?>>
                                                                <label class="form-check-label" for="hemocomp_<?= $hemocomp->id ?>">
                                                                    <?= $hemocomp->descricao ?>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-3">
                                                            <input type="number" class="form-control hemocomp-qty" 
                                                                name="hemocomp_qty[<?= $hemocomp->id ?>]" 
                                                                placeholder="" min="1"
                                                                value="<?= $quant ?>"
                                                                <?= $checked ? '' : 'disabled' ?>>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row g-3 mb-2">
                            <div class="g-2">
                                <div class="bordered-container mb-4" style="margin-left: 5px; margin-right: 3px;">
                                    <div class="row g-3">
                                        <div class="col-md-2">
                                            <div class="mb-2">
                                                <label class="form-label">Utilizará Equipamentos?<b class="text-danger">*</b></label>
                                                <div class="input-group mb-2 bordered-container">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="usarEquipamentos" id="eqptoN" value="N" 
                                                        <?= (isset($data['usarEquipamentos']) && $data['usarEquipamentos'] === 'N') ? 'checked' : '' ?>>                                          <label class="form-check-label" for="eqptoN">Não</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="usarEquipamentos" id="eqptoS" value="S"
                                                        <?= (isset($data['usarEquipamentos']) && $data['usarEquipamentos'] === 'S') ? 'checked' : '' ?>>
                                                        <label class="form-check-label" for="eqptoS" style="margin-right: 10px;">&nbsp;Sim</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-10">
                                            <div class="mb-4">
                                                <label for="eqpts" class="form-label">Equipamentos Necessários</label>
                                                <div class="input-group">
                                                    <select class="form-select select2-dropdown <?= $validation->hasError('eqpts') ? 'is-invalid' : '' ?>"
                                                            id="eqpts" name="eqpts[]" multiple="multiple"
                                                            data-placeholder="" data-allow-clear="1" <?= $validation->hasError('eqpts') ? 'disabled' : '' ?>>
                                                        <?php
                                                        foreach ($data['equipamentos'] as $equipamento) {
                                                            $selected = in_array($equipamento->id, $data['eqpts']) ? 'selected' : '';
                                                            echo '<option value="' . $equipamento->id . '" data-qtd="' . $equipamento->qtd . '" ' . $selected . '>' . $equipamento->descricao . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                    <?php if ($validation->hasError('eqpts')): ?>
                                                        <div class="invalid-feedback">
                                                            <?= $validation->getError('eqpts') ?>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row g-3 mb-2">
                            <div class="g-2">
                                <div class="bordered-container mb-2" style="margin-left: 5px; margin-right: 3px;">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="filtro_especialidades" class="form-label">Especialidade</label>
                                                <select class="form-select select2-dropdown" id="filtro_especialidades" name="filtro_especialidades">
                                                    <option value="">Todas</option>
                                                    <?php foreach ($data['especialidades_med'] as $filtro): ?>
                                                        <option value="<?= $filtro->seq ?>"><?= $filtro->nome_especialidade ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="profissional" class="form-label">Equipe Cirúrgica<b class="text-danger">*</b></label>
                                                <select class="form-select select2-dropdown <?= $validation->hasError('profissional') ? 'is-invalid' : '' ?>" 
                                                        id="profissional" name="profissional[]" multiple="multiple" data-placeholder="" data-allow-clear="1">
                                                    <?php
                                                    // Certifique-se de que $data['profissional'] está definido como um array
                                                    $data['profissional'] = isset($data['profissional']) ? (array)$data['profissional'] : [];

                                                    // Certifique-se de que o array não tenha valores vazios
                                                    $data['profissional'] = array_filter($data['profissional']);

                                                    $array_selected = [];
                                                    foreach ($data['prof_especialidades'] as $prof_espec) {
                                                        if (in_array($prof_espec->pes_codigo, $data['profissional'], true) && !in_array($prof_espec->pes_codigo, $array_selected, true)) {
                                                            $selected = 'selected';
                                                            $array_selected[] = $prof_espec->pes_codigo; // Adicione ao array de selecionados
                                                        } else {
                                                            $selected = '';
                                                        }
                                                        echo '<option value="'.$prof_espec->pes_codigo.'" data-especie="'.$prof_espec->esp_seq.'" '.$selected.'>'.$prof_espec->nome.' - '.$prof_espec->conselho.'</option>';
                                                    }
                                                    ?>
                                                </select>
                                                <?php if ($validation->hasError('profissional')): ?>
                                                    <div class="invalid-feedback">
                                                        <?= $validation->getError('profissional') ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label class="form-label" for="info">Necessidades do Procedimento<b class="text-danger">*</b></label>
                                    <textarea id="nec_proced" maxlength="2048" rows="3" 
                                            class="form-control <?= isset($validation) && $validation->getError('nec_proced') ? 'is-invalid' : '' ?>"
                                            name="nec_proced"><?= isset($data['nec_proced']) ? $data['nec_proced'] : '' ?></textarea>
                                    <?php if (isset($validation) && $validation->getError('nec_proced')): ?>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('nec_proced') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label class="form-label" for="info">Justificativas de Envio ao Mapa Cirúrgico</label>
                                    <textarea id="justenvio" maxlength="255" rows="3"  
                                            class="form-control <?= isset($validation) && $validation->getError('justenvio') ? 'is-invalid' : '' ?>"
                                            name="justenvio"><?= isset($data['justenvio']) ? $data['justenvio'] : '' ?></textarea>
                                    <?php if (isset($validation) && $validation->getError('justenvio')): ?>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('justenvio') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="row g-3" style="margin-top: -13px;">
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label class="form-label" for="info">Informações adicionais</label>
                                    <textarea id="info" maxlength="255" rows="3" readonly 
                                            class="form-control <?= isset($validation) && $validation->getError('info') ? 'is-invalid' : '' ?>"
                                            name="info"><?= isset($data['info']) ? $data['info'] : '' ?></textarea>
                                    <?php if (isset($validation) && $validation->getError('info')): ?>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('info') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label class="form-label" for="justorig">Justificativa p/ Origem Paciente</label>
                                    <textarea id="justorig" maxlength="255" rows="3" readonly
                                            class="form-control <?= isset($validation) && $validation->getError('justorig') ? 'is-invalid' : '' ?>"
                                            name="justorig"><?= isset($data['justorig']) ? $data['justorig'] : '' ?></textarea>
                                    <?php if (isset($validation) && $validation->getError('justorig')): ?>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('justorig') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-12">
                                <!--button class="btn btn-primary mt-3" id="submit" name="submit" type="submit" value="1"-->
                                <button class="btn btn-primary mt-3" onclick="return confirma(this);">
                                    <i class="fa-solid fa-paper-plane"></i> Enviar
                                </button>
                                <a class="btn btn-warning mt-3" href="<?= base_url('listaespera/exibir') ?>">
                                    <i class="fa-solid fa-arrow-left"></i> Voltar
                                </a>
                            </div>
                        </div>

                        <input type="hidden" name="id" value="<?= $data['id'] ?>" />
                        <input type="hidden" name="ordemfila" id='ordemfila' value="<?= $data['ordemfila'] ?>" />
                        <input type="hidden" name="prontuario" value="<?= $data['prontuario'] ?>" />
                        <input type="hidden" name="especialidade" id="especialidade-hidden" value="<?= $data['especialidade'] ?>" />
                        <input type="hidden" name="fila" id="fila-hidden" value="<?= $data['fila'] ?>" />
                        <input type="hidden" name="procedimento" value="<?= $data['procedimento'] ?>" />
                        <!-- <input type="hidden" name="origem-hidden" id="origem-hidden" value="<--?= $data['origem'] ?>" /> -->
                        <input type="hidden" name="origem" value="<?= $data['origem'] ?>" />
                        <input type="hidden" name="unidadeorigem" value="<?= $data['unidadeorigem'] ?>" />
                        <input type="hidden" name="tipo_sanguineo" value="<?= $data['tipo_sanguineo'] ?>" />
                        <input type="hidden" name="lateralidade" value="<?= $data['lateralidade'] ?>">
                        <input type="hidden" name="risco" value="<?= $data['risco'] ?>" />
                        <!--input type="hidden" name="tipo_sanguineo" value="<-?= $data['tipo_sanguineo'] ?>" /-->
                        <input type="hidden" name="proced_adic_hidden" id="proced_adic_hidden" />
                        <input type="hidden" name="eqpts_hidden" id="eqpts_hidden" />
                        <input type="hidden" name="idsituacao_cirurgia_hidden" id="idsituacao_cirurgia_hidden" value='P' /> <!-- Programada por default --> 
                        <input type="hidden" name="profissional_hidden" id="profissional_adic_hidden" />
                        <input type="hidden" name="hemocomps_hidden" id="hemocomps_hidden" />
                        <input type="hidden" name="lista_updated_at_original" value="<?= $data['lista_updated_at_original'] ?? NULL ?>">
                        <input type="hidden" name="alteracao_tipo_sanguineo" id="alteracao_tipo_sanguineo" value="<?= $data['alteracao_tipo_sanguineo'] ?? "0" ?>">
                        <input type="hidden" name="tipo_sanguineo_confirmado" id="tipo_sanguineo_confirmado" value="<?= $data['tipo_sanguineo_confirmado'] ?? "0" ?>">
                        <input type="hidden" name="motivo_alteracao_hidden" id="motivo_alteracao_hidden"  value="<?= $data['motivo_alteracao_hidden'] ?? NULL ?>">
                        <input type="hidden" name="justificativa_alteracao_hidden" id="justificativa_alteracao_hidden" value="<?= $data['justificativa_alteracao_hidden'] ?? NULL ?>">
                        <input type="hidden" name="lista_updated_at_original" value="<?= $data['lista_updated_at_original'] ?? NULL ?>">
                        <input type="hidden" name="paciente_updated_at_original" id="paciente_updated_at_original" value="<?= $data['paciente_updated_at_original'] ?? NULL ?>">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!--  Modal ---->
<div id="modalJustificarAlteracao" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="tituloModal" aria-hidden="true" role="dialog">
    <div class="modal-dialog  modal-dialog-custom" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><strong>Justificar Alteração do Tipo Sanguíneo</strong></h5>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="mb-3">
                            <label for="motivo_alteracao" class="form-label">Motivo da alteração</label>
                            <select id="motivo_alteracao" class="form-select select2-dropdown" name="motivo_alteracao"
                                data-placeholder="Selecione uma opção" data-allow-clear="1">
                                <option value="">Selecione um motivo</option>
                                <option value="1">Erro no cadastro</option>
                                <option value="2">Atualização com novo exame</option>
                            </select>
                        </div>
                        <hr>
                    <div class="row">
                        <div class="mb-3">
                            <label for="justificativa" class="form-label">Justificativa</label>
                            <textarea id="justificativa" class="form-control" rows="3" placeholder="Descreva a justificativa..."></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" id="linha">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="btnCancelarJustificativa" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnSalvarJustificativa">Salvar Justificativa</button>
            </div>
        </div>
    </div>
</div>
<!------->
<script>
    function formatarHora(input) {
        let valor = input.value.replace(/\D/g, ""); // Remove não numéricos
        if (valor.length >= 2) {
            input.value = valor.substring(0, 2) + (valor.length > 2 ? ":" : "") + valor.substring(2, 4);
        }
    }

    function formatarData(input) {
        let valor = input.value.replace(/\D/g, ""); // Remove tudo que não for número

        if (valor.length >= 2) {
            valor = valor.substring(0, 2) + (valor.length > 2 ? "/" : "") + valor.substring(2, 4) + (valor.length > 4 ? "/" : "") + valor.substring(4, 8);
        }

        input.value = valor;
    }

    window.onload = function() {
        const inputs = document.querySelectorAll('input, select, .form-check-input');
        inputs.forEach(input => {
            input.addEventListener('keydown', disableEnter);
        });
    };

    let tipoSanguineoOriginal = $('#tipo_sanguineo').val();
    let alteracaoConfirmada =  $('#tipo_sanguineo_confirmado').val() == '1';
    let carregandoInicial = false;

    function confirma(button) {
        event.preventDefault(); // Previne a submissão padrão do formulário

        const equipamentos = $('#eqpts').val();

        if (equipamentos && equipamentos.length > 0) {

            const form = button.form;

            const dtcirurgia = form.querySelector('input[name="dtcirurgia"]').value;

            let equipamentosSelecionados = [];
            $('#eqpts option:selected').each(function() {
                let id = $(this).val();
                let qtd = $(this).data('qtd');
                equipamentosSelecionados.push({ id: id, qtd: qtd });
            });

            // Objeto de dados para enviar ao servidor
            const data = {
                dtcirurgia: dtcirurgia,
                equipamentos: equipamentosSelecionados // Adiciona os equipamentos ao JSON
            };

            if (!dtcirurgia || dtcirurgia.trim() === "") {
                return true;
            } else {
                const xhr = new XMLHttpRequest();
                xhr.open('POST', '<?= base_url('listaespera/verificaequipamentos') ?>', true); 
                xhr.setRequestHeader('Content-Type', 'application/json');
                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                
                xhr.onload = function() {
                    if (xhr.status >= 200 && xhr.status < 400) {
                        const response = JSON.parse(xhr.responseText);

                        if (response.success) {
                            Swal.fire({
                                title: 'Limite excedido para reserva de equipamento. Deseja prosseguir mesmo assim?',
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonText: 'Ok',
                                cancelButtonText: 'Cancelar'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    //$('#idsituacao_cirurgia_hidden').val('EA'); // Em Aprovação
                                    $('#janelaAguarde').show();
                                    $('#idForm').off('submit'); 
                                    $('#idForm').submit(); 
                                } else {
                                    $('#janelaAguarde').hide();
                                }
                            });
                        } else {
                            $('#janelaAguarde').show();
                            $('#idForm').off('submit'); 
                            $('#idForm').submit();        
                        }
                    } else {
                        console.error('Erro ao enviar os dados:', xhr.statusText);
                        alert('Erro na comunicação com o servidor.');
                        $('#janelaAguarde').hide();
                        return false;  
                    }
                };

                xhr.onerror = function() {
                    console.error('Erro ao enviar os dados:', xhr.statusText);
                    alert('Erro na comunicação com o servidor.');
                    $('#janelaAguarde').hide();
                    return false;
                };

                // Envia os dados como JSON, incluindo equipamentos
                xhr.send(JSON.stringify(data));
            }
        } else {
            $('#janelaAguarde').show();
            $('#idForm').off('submit'); 
            $('#idForm').submit(); 
        }
    }

    function fetchPacienteNome(prontuarioValue, ordemValue) {
      if (prontuarioValue) {
        fetch('<?= base_url('listaespera/getnomepac/') ?>' + prontuarioValue, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          }
        })
        .then(response => {
          if (!response.ok) {
            throw new Error('Network response was not ok');
          }
          return response.json();
        })
        .then(data => {
          if (data.nome) {
            document.getElementById('nome').value = data.nome;
            const ordemfila = document.getElementById('ordemfila').value;
            var selectElement = document.getElementById('fila');
            var filaText = selectElement.options[selectElement.selectedIndex].text;
            
            //loadAsideContent(prontuarioValue, ordemfila, filaText);
          } else {
            document.getElementById('nome').value = data.error;
            console.error(data.error || 'Nome não encontrado');
            $('#sidebar').html('<p>'+data.error+'</p>'); 
          }
        })
        .catch(error => {
          console.error('Erro:', error);
          document.getElementById('nome').value = '';
        });
      } else {
        document.getElementById('nome').value = '';
      }
    }
    
    function loadAsideContent(recordId, ordemFila, fila) {
        $.ajax({
            url: '<?= base_url('listaespera/carregaaside/') ?>' + recordId + '/' + ordemFila + '/' + fila,
            method: 'GET',
            beforeSend: function() {
                $('#sidebar').html('<p>Carregando...</p>'); // Mostrar mensagem de carregando
            },
            success: function(response) {
                $('#sidebar').html(response); // Atualizar o conteúdo do sidebar
            },
            error: function(xhr, status, error) {
                var errorMessage = 'Erro ao carregar os detalhes: ' + status + ' - ' + error;
                console.error(errorMessage);
                console.error(xhr.responseText);
                $('#sidebar').html('<p>' + errorMessage + '</p><p>' + xhr.responseText + '</p>');
            }
        });
    }

    function fetchPacienteNomeOnLoad() {
        const prontuarioInput = document.getElementById('prontuario');
        fetchPacienteNome(prontuarioInput.value);
    }

    fetchPacienteNomeOnLoad();

    $(document).ready(function() {
        $('.select2-dropdown').select2({
            //dropdownCssClass: 'custom-dropdown',
            allowClear: true,
        });

        $('#motivo_alteracao').select2({
            dropdownParent: $('#modalJustificarAlteracao'), // ESSENCIAL para funcionar dentro do modal
            width: '100%',
            placeholder: 'Selecione uma opção'
        });

        // ------------ equipamentos -----------------------------------

        $('#eqpts').select2();

        if ($('input[name="usarEquipamentos"]:checked').val() === 'S') {
            $('#eqpts').prop('disabled', false);
        } else {
            $('#eqpts').prop('disabled', true);
        }

        // Atribui um evento de mudança aos radio buttons
        $('input[name="usarEquipamentos"]').change(function() {
            if ($(this).val() === 'S') {
                $('#eqpts').prop('disabled', false); // Habilita o campo eqpts
                $('#eqpts').select2(); // Inicializa o Select2
            } else {
                $('#eqpts').prop('disabled', true); // Desabilita o campo eqpts
                $('#eqpts').val([]).trigger('change'); // Limpa a seleção
            }
        });

        // Se a validação falhar, recarrega os valores
        if ($('#eqpts').prop('disabled')) {
            $('#eqpts').val([]).trigger('change'); // Limpa a seleção se estiver desabilitado
        }

        //--------------Hemocomponentes------------------------------

        /* $('#hemocomps').select2();

        if ($('input[name="usarHemocomponentes"]:checked').val() === 'S') {
            $('#hemocomps').prop('disabled', false);
        } else {
            $('#hemocomps').prop('disabled', true);
        } */

        // Atribui um evento de mudança aos radio buttons
        /* $('input[name="usarHemocomponentes"]').change(function() {
            if ($(this).val() === 'S') {
                $('#hemocomps').prop('disabled', false); // Habilita o campo hemocomponentes
                $('#hemocomps').select2(); // Inicializa o Select2
            } else {
                $('#hemocomps').prop('disabled', true); // Desabilita o campo hemocomponentes
                $('#hemocomps').val([]).trigger('change'); // Limpa a seleção
            }
        }); */

        // Se a validação falhar, recarrega os valores
        /* if ($('#hemocomps').prop('disabled')) {
            $('#hemocomps').val([]).trigger('change'); // Limpa a seleção se estiver desabilitado
        } */

        //--------------------------------------------------------

        let lastFocusedInput = null;
        // Captura o último campo de entrada (input ou textarea) focado
        $(document).on('focus', 'input[type="text"], textarea', function() {
            lastFocusedInput = this;
        });
        $(document).on('blur', 'input[type="text"], textarea', function() {
            setTimeout(() => {
                let activeElement = document.activeElement;

                // Se o foco foi para o campo de busca do Select2, retorna o foco ao último campo
                if (activeElement.classList.contains('select2-search__field') && lastFocusedInput) {
                    lastFocusedInput.focus();
                }
            }, 10);
        });

        $('#risco').change(function() {
            var selectedFilter = $(this).val();
            $('input[name="risco"]').val(selectedFilter);
        })
        $('#origem').change(function() {
            var selectedFilter = $(this).val();
            $('input[name="origem"]').val(selectedFilter);
        })
        $('#lateralidade').change(function() {
            var selectedFilter = $(this).val();
            $('input[name="lateralidade"]').val(selectedFilter);
        })

        // Filtro de prof_especs adicionais baseado no filtro selecionado ----------------
        function updateProfEspecialidades(selectedFilter) {
            // Mantenha as opções selecionadas
            var selectedValues = $('#profissional').val() || [];
            
            // Esvaziar o select
            $("#profissional").empty();
            
            // Adicione as opções que já estão selecionadas primeiro para garantir que sejam visíveis
            var addedOptions = [];
            <?php foreach ($data['prof_especialidades'] as $prof_espec): ?>
            var value = '<?= $prof_espec->pes_codigo ?>';
            var text = '<?= $prof_espec->nome . ' - ' . $prof_espec->conselho ?>';
            var especie = '<?= $prof_espec->esp_seq ?>';
            if (selectedValues.includes(value) && !addedOptions.includes(value)) {
                var option = new Option(text, value, true, true);
                $("#profissional").append(option);
                addedOptions.push(value);
            }
            <?php endforeach; ?>

            // Adicione as opções que correspondem ao filtro (mas não estão selecionadas)
            <?php foreach ($data['prof_especialidades'] as $prof_espec): ?>
            var value = '<?= $prof_espec->pes_codigo ?>';
            var text = '<?= $prof_espec->nome . ' - ' . $prof_espec->conselho ?>';
            var especie = '<?= $prof_espec->esp_seq ?>';
            if ((!selectedValues.includes(value)) && (!addedOptions.includes(value)) && (!selectedFilter || selectedFilter === especie)) {
                var option = new Option(text, value, false, false);
                $("#profissional").append(option);
                addedOptions.push(value);
            }
            <?php endforeach; ?>
            
            // Atualize a seleção do Select2 para as opções visíveis
            $('#profissional').val(selectedValues).trigger('change');
        }

        // Atualiza a lista de profissionais baseado no filtro selecionado
        $('#filtro_especialidades').change(function() {
            var selectedFilter = $(this).val();
            updateProfEspecialidades(selectedFilter);
        });

        // Inicializa os profissionais adicionais já selecionados
        updateProfEspecialidades($('#filtro_especialidades').val());

        $('#profissional').on('change', function() {
            $('#profissional_hidden').val($(this).val());
        });

        // Inicializa o valor do campo hidden, caso existam valores pré-selecionados
        $('#profissional_hidden').val($('#profissional').val());

        // Fim do filtro de profissionais -----------------------------------------------------------------------

        // Procedimentos Adicionais  ----------------------------------------------------------------------------

        $('#proced_adic').on('change', function() {
            $('#proced_adic_hidden').val($(this).val());
        });

       /*  $('#eqpts').on('change', function() {
            $('#eqpts_hidden').val($(this).val());
        }); */

        $('#eqpts').change(function() {
            let equipamentosSelecionados = [];

            $('#eqpts option:selected').each(function() {
                let id = $(this).val(); // ID do equipamento
                let qtd = $(this).data('qtd'); // Pega o valor do atributo data-qtd
                equipamentosSelecionados.push({ id: id, qtd: qtd });
            });

            //console.log(equipamentosSelecionados); // Apenas para debug
        });

        $('#eqpts').change(function() {
            if ($(this).val().includes("0")) {
                $(this).val(["0"]).trigger("change"); // Mantém apenas a opção "Não utilizará equipamentos cirúrgicos"
            }
        });


        // Inicializa o valor do campo hidden, caso existam valores pré-selecionados
        /* $('#proced_adic_hidden').val($('#proced_adic').val());

        $('#eqpts_hidden').val($('#eqpts').val());

        $('#hemocomps_hidden').val($('#hemocomps').val());

        $('#hemocomps').on('change', function() {
            $('#hemocomps_hidden').val($(this).val());
        }); */
        
        // Procedimentos Adicionais  ----------------------------------------------------------------------------

        /* $('#idForm').submit(function() {
            $('#janelaAguarde').show();
            setTimeout(function() {
                window.location.href = href;
            }, 1000);
        }); */

        const prontuarioInput = document.getElementById('prontuario');
        const ordemInput = document.getElementById('ordem');
        prontuarioInput.addEventListener('change', function() {
            fetchPacienteNome(prontuarioInput.value, ordemInput.value);
        });

        //------------- hemocomponentes --------------------------------

        const hemocompSection = document.getElementById('hemocomp-section');
        const radios = document.querySelectorAll('input[name="usarHemocomponentes"]');

        function toggleHemocompSection() {
            const selected = document.querySelector('input[name="usarHemocomponentes"]:checked');
            if (selected && selected.value === 'S') {
                document.querySelectorAll('.hemocomp-checkbox').forEach(cb => {
                    cb.disabled = false;
                    // Sobe até o .row.align-items-center (2 níveis acima do input)
                    const parentRow = cb.closest('.row.align-items-center');
                    const qtyInput = parentRow.querySelector('.hemocomp-qty');
                    qtyInput.disabled = !cb.checked;
                });
            } else {
                document.querySelectorAll('.hemocomp-checkbox').forEach(cb => {
                    cb.checked = false;
                    cb.disabled = true;
                    const parentRow = cb.closest('.row.align-items-center');
                    const qtyInput = parentRow.querySelector('.hemocomp-qty');
                    qtyInput.value = '';
                    qtyInput.disabled = true;
                });
            }
        }

        // Checkbox: ativa/desativa campo de quantidade
        document.querySelectorAll('.hemocomp-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function () {
                const parentRow = this.closest('.row.align-items-center');
                const qtyInput = parentRow.querySelector('.hemocomp-qty');
                if (this.checked && !this.disabled) {
                    qtyInput.disabled = false;
                } else {
                    qtyInput.value = '';
                    qtyInput.disabled = true;
                }
            });
        });

        radios.forEach(radio => {
            radio.addEventListener('change', toggleHemocompSection);
        });

        // Aplica na primeira carga
        toggleHemocompSection();

        /* function toggleHemocompInputs() {
            document.querySelectorAll('.hemocomp-checkbox').forEach(function (checkbox) {
                const qtyInput = checkbox.closest('.form-check').parentElement.nextElementSibling.querySelector('.hemocomp-qty');
                if (qtyInput) {
                    qtyInput.disabled = !checkbox.checked;
                }
            });
        }

        // Aplica a função no carregamento da página
        toggleHemocompInputs(); */

        // Adiciona evento a todos os checkboxes
        /* document.querySelectorAll('.hemocomp-checkbox').forEach(function (checkbox) {
            checkbox.addEventListener('change', toggleHemocompInputs);
        }); */
        
        //-------------------------------------------------------------------------

        $('#tipo_sanguineo').on('change', function () {
            const valorAtual = $(this).val();

            if (carregandoInicial || alteracaoConfirmada || !tipoSanguineoOriginal) return;

            if (valorAtual !== tipoSanguineoOriginal) {
                Swal.fire({
                    title: 'Alterar tipo sanguíneo?',
                    //text: `O tipo original era ${tipoSanguineoOriginal}. Deseja realmente alterar para ${valorAtual}?`,
                    text: `O tipo anterior era ${tipoSanguineoOriginal}. Deseja realmente alterar para outro tipo sanguíneo?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sim',
                    cancelButtonText: 'Não'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#modalJustificarAlteracao').modal('show');
                        //$('#modalDetalhes').modal('show');

                    } else {
                        $('#tipo_sanguineo').val(tipoSanguineoOriginal).trigger('change');
                        $('#tipo_sanguineo_confirmado').val('0');
                    }
                });
            }
        });

        $('#btnSalvarJustificativa').on('click', function () {
            const motivo = $('#motivo_alteracao').val();
            const justificativa = $('#justificativa').val().trim();

            //if (!motivo || justificativa === '') {
            if (!motivo) {
                Swal.fire('Campos obrigatórios', 'Por favor, informe o motivo para alteração.', 'warning');
                return;
            }

            $('#modalJustificarAlteracao').modal('hide');
            alteracaoConfirmada = true;

            $('#tipo_sanguineo_confirmado').val('1');
            $('#motivo_alteracao_hidden').val(motivo);
            $('#justificativa_alteracao_hidden').val(justificativa);
        });

        $('#btnCancelarJustificativa').on('click', function () {
            if (tipoSanguineoOriginal !== null) {
                $('#tipo_sanguineo').val(tipoSanguineoOriginal).trigger('change');
            }
        });

    });
</script>
