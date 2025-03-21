<?= csrf_field() ?>
<?php $validation = \Config\Services::validation(); ?>

<?php
    // Inicializando valores padrão
    $data['eqpts'] = isset($data['eqpts']) ? (array)$data['eqpts'] : [];
    $data['usarEquipamentos'] = $data['usarEquipamentos'] ?? ['N']; 
    $data['hemocomps'] = isset($data['hemocomps']) ? (array)$data['hemocomps'] : [];
    $data['usarHemocomponentes'] = $data['usarHemocomponentes'] ?? ['N']; ?>

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card form-container">
                <div class="card-header text-center text-black">
                    <b><?= 'Trocar Paciente' ?></b>
                </div>
                <div class="card-body has-validation">
                    <form id="idForm" method="post" action="<?= base_url('mapacirurgico/trocar') ?>">
                        <div class="row g-3">
                            <div class="col-md-2">
                                <div class="mb-2">
                                    <label for="dtcirurgia" class="form-label">Data Cirurgia<b class="text-danger">*</b></label>
                                    <div class="input-group">
                                        <input type="text" id="dtcirurgia" maxlength="10" placeholder="DD/MM/AAAA" readonly
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
                                        <input type="time" id="hrcirurgia" maxlength="5" placeholder="HH:MM" readonly
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
                        </div>
                        <div class="row g-3">
                            <div class="col-md-10">
                                <div class="mb-2">
                                    <label for="candidato" class="form-label">Paciente de Troca<b class="text-danger">*</b></label>
                                    <div class="input-group">
                                        <select class="form-select select2-dropdown <?php if($validation->getError('candidato')): ?>is-invalid<?php endif ?>"
                                            id="candidato" name="candidato"
                                            data-placeholder="Selecione uma opção" data-allow-clear="1">
                                            <option value="" <?php echo set_select('candidato', '', TRUE); ?> ></option>
                                            <?php
                                            foreach ($data['candidatos'] as $key => $candidato) {
                                                $selected = ($data['candidato'] == $candidato['idlistaespera']) ? 'selected' : '';
                                                echo '<option value="'.$candidato['idlistaespera'].'" data-prontuario="'.$candidato['prontuario'].'" data-idfila="'.$candidato['idfila'].'" data-fila="'.$candidato['fila'].'" data-ordem="'.$candidato['ordem_fila'].'" data-id="'.$candidato['idlistaespera'].
                                                '" data-procedimento="'.$candidato['idprocedimento'].'" data-risco="'.$candidato['riscocirurgico'].'" data-dtrisco="'.$candidato['datariscocirurgico'].
                                                '" data-complexidade="'.$candidato['complexidade'].'" data-congelacao="'.$candidato['congelacao'].'" data-cid="'.$candidato['cid'].
                                                '" data-lateralidade="'.$candidato['lateralidade'].'" data-infoadicionais="'.$candidato['infoadicionais'].'" data-opme="'.$candidato['opme'].
                                                '" '.$selected.'>Fila: '.$candidato['fila'].' '.'No. Fila: '.$candidato['ordem_fila'].' - Paciente: '.$candidato['prontuario'].' - '.$candidato['nome'].'</option>';
                                            }
                                            ?>
                                        </select>
                                        <?php if ($validation->getError('candidato')): ?>
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('candidato') ?>
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
                                            $enabled = ($procedimento->ind_situacao == 'I') ? 'disabled' : ''; 
                                            echo '<option value="'.$procedimento->cod_tabela.'" '.$selected.' '.$enabled.'>'.$procedimento->cod_tabela.' - '.$procedimento->descricao.'</option>';
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
                            <div class="col-md-4">
                                <div class="mb-2">
                                    <label for="risco" class="form-label">Risco Cirúrgico<b class="text-danger">*</b></label>
                                    <div class="input-group">
                                        <select class="form-select select2-dropdown <?php if($validation->getError('risco')): ?>is-invalid<?php endif ?>"
                                            id="risco" name="risco" 
                                            data-placeholder="Selecione uma opção" data-allow-clear="1" disabled>
                                            <option value="" <?php echo set_select('risco', '', TRUE); ?> ></option>
                                            <?php
                                            foreach ($data['riscos'] as $key => $risco) {
                                                $selected = ($data['risco'] == $risco['id']) ? 'selected' : '';
                                                $enabled = ($risco['indsituacao'] == 'I') ? 'disabled' : ''; 
                                                echo '<option value="'.$risco['id'].'" '.$selected.' '.$enabled.'>'.$risco['nmrisco'].'</option>';                                              }
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
                        </div>
                        <div class="row g-3">
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
                            <div class="col-md-3">
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
                                    <label for="lateralidade" class="form-label">Lateralidade<b class="text-danger">*</b></label>
                                    <div class="input-group">
                                        <select class="form-select select2-dropdown <?php if ($validation->getError('lateralidade')): ?>is-invalid<?php endif ?>"
                                            id="lateralidade" name="lateralidade"
                                            data-placeholder="Selecione uma opção" data-allow-clear="1">
                                            <option value="" <?php echo set_select('lateralidade', '', TRUE); ?>></option>
                                            <?php foreach ($data['lateralidades'] as $lateralidade): ?>
                                                <?php
                                                $selected = set_select('lateralidade', $lateralidade['id'], ($data['lateralidade'] == $lateralidade['id']));
                                                $enabled = ($lateralidade['indsituacao'] == 'I') ? 'disabled' : ''; 
                                                ?>
                                                <option value="<?php echo $lateralidade['id']; ?>" <?php echo $selected; ?> <?php echo $enabled; ?>>
                                                    <?php echo $lateralidade['descricao']; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <?php if ($validation->getError('lateralidade')): ?>
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('lateralidade') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-2">
                                    <label class="form-label">Congelação<b class="text-danger">*</b></label>
                                    <div class="input-group mb-2 bordered-container">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="congelacao" id="congelacaoN" value="N"
                                                <?= (isset($data['congelacao']) && $data['congelacao'] == 'N') ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="congelacaoN" style="margin-right: 10px;">&nbsp;Não</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="congelacao" id="congelacaoS" value="S"
                                                <?= (isset($data['congelacao']) && $data['congelacao'] == 'S') ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="congelacaoS" style="margin-right: 10px;">&nbsp;Sim</label>
                                        </div>
                                    </div>
                                    <?php if ($validation->getError('congelacao')): ?>
                                        <div class="invalid-feedback d-block">
                                            <?= $validation->getError('congelacao') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-2">
                                    <label class="form-label">Hemoderivados<b class="text-danger">*</b></label>
                                    <div class="input-group mb-2 bordered-container">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="hemoderivados" id="hemoderivadosN" value="N"
                                                <?= (isset($data['hemoderivados']) && $data['hemoderivados'] == 'N') ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="hemoderivadosN" style="margin-right: 10px;">&nbsp;Não</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="hemoderivados" id="hemoderivadosS" value="S"
                                                <?= (isset($data['hemoderivados']) && $data['hemoderivados'] == 'S') ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="hemoderivadosS" style="margin-right: 10px;">&nbsp;Sim</label>
                                        </div>
                                    </div>
                                    <?php if ($validation->getError('hemoderivados')): ?>
                                    <div class="invalid-feedback d-block">
                                        <?= $validation->getError('hemoderivados') ?>
                                    </div>
                                <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-2">
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
                            <div class="col-md-8">
                                <div class="mb-2">
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
                        <div class="row g-3">
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
                            <div class="col-md-10">
                                <div class="mb-4">
                                <label for="hemocomps" class="form-label">Hemocomponentes Necessários</label>
                                <div class="input-group">
                                    <select class="form-select select2-dropdown <?= $validation->hasError('hemocomps') ? 'is-invalid' : '' ?>"
                                            id="hemocomps" name="hemocomps[]" multiple="multiple"
                                            data-placeholder="" data-allow-clear="1" <?= $validation->hasError('hemocomps') ? 'disabled' : '' ?>>
                                        <?php
                                        
                                        foreach ($data['hemocomponentes'] as $hemocomponente) {
                                            $selected = in_array($hemocomponente->id, $data['hemocomps']) ? 'selected' : '';
                                            echo '<option value="' . $hemocomponente->id . '" ' . $selected . '>' . $hemocomponente->descricao . '</option>';
                                        }
                                        ?>
                                    </select>
                                    <?php if ($validation->hasError('hemocomps')): ?>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('hemocomps') ?>
                                        </div>
                                    <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="row g-2">
                                <div class="container bordered-container mb-2">
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
                                            <div class="mb-2">
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
                                    <label class="form-label" for="nec_proced">Necessidades do Procedimento<b class="text-danger">*</b></label>
                                    <textarea id="nec_proced" maxlength="255" rows="3"
                                            class="form-control <?= isset($validation) && $validation->getError('nec_proced') ? 'is-invalid' : '' ?>"
                                            name="nec_proced"><?= isset($data['nec_proced']) ? $data['nec_proced'] : '' ?></textarea>
                                    <?php if (isset($validation) && $validation->getError('nec_proced')): ?>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('nec_proced') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-12">
                                <div class="mb-2">
                                    <label class="form-label" for="justtroca">Justificativa para troca<b class="text-danger">*</b></label>
                                    <textarea id="justtroca" maxlength="255" rows="3"
                                            class="form-control <?= isset($validation) && $validation->getError('justtroca') ? 'is-invalid' : '' ?>"
                                            name="justtroca"><?= isset($data['justtroca']) ? $data['justtroca'] : '' ?></textarea>
                                    <?php if (isset($validation) && $validation->getError('justtroca')): ?>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('justtroca') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-12">
                            <button class="btn btn-primary mt-3" type="button"
                                    onclick="verPacienteNaLista(event, this);">
                                <i class="fa-solid fa-people-arrows"></i> Trocar
                            </button>
                               <!--  <button class="btn btn-primary mt-3" id="submit" name="submit" type="submit" value="1">
                                    <i class="fa-solid fa-people-arrows"></i> Trocar
                                </button> -->
                                <!-- <button class="btn btn-primary mt-3" id="submit" name="submit" type="button" onclick="trocarpaciente()">
                                    <i class="fa-solid fa-people-arrows"></i> Trocar
                                </button> -->
                                <a class="btn btn-warning mt-3" href="<?= base_url('mapacirurgico/exibir') ?>">
                                    <i class="fa-solid fa-arrow-left"></i> Voltar
                                </a>
                            </div>
                        </div>

                        <!-- <input type="hidden" name="idmapapacatrocar" value="<--?= $data['idmapapacatrocar'] ?>" />
                        <input type="hidden" name="idlistapacatrocar" value="<--?= $data['idlistapacatrocar'] ?>" /> -->
                        <input type="hidden" name="idlistapacatrocar" id="idlistapacatrocar" value="<?= $data['idlistapacatrocar'] ?>" />
                        <input type="hidden" name="idmapapacatrocar" id="idmapapacatrocar" value="<?= $data['idmapapacatrocar'] ?>" />
                        <input type="hidden" name="prontuario_pacatrocar" id="prontuario_pacatrocar" value="<?= $pacatrocar['prontuario'] ?>" />
                        <input type="hidden" name="ordemfila_pacatrocar" id="ordemfila_pacatrocar" value="<?= $pacatrocar['ordemfila'] ?>" />
                        <input type="hidden" name="fila_pacatrocar" id="fila_pacatrocar" value="<?= $pacatrocar['fila'] ?>" />
                        <input type="hidden" name="dtcirurgia" value="<?= $data['dtcirurgia'] ?>" />
                        <input type="hidden" name="especialidade" value="<?= $data['especialidade'] ?>" />
                        <input type="hidden" name="fila" value="<?= $data['fila'] ?>" />
                        <input type="hidden" name="fila_hidden" id="fila_hidden" value="<?= $data['fila'] ?>"/>
                        <input type="hidden" name="procedimento" value="<?= $data['procedimento'] ?>" />
                        <input type="hidden" name="procedimento_hidden" id="procedimento_hidden" value="<?= $data['procedimento'] ?>"/>
                        <input type="hidden" name="lateralidade" value="<?= $data['lateralidade'] ?>">
                        <input type="hidden" name="risco" value="<?= $data['risco'] ?>" />
                        <input type="hidden" name="proced_adic_hidden" id="proced_adic_hidden" />
                        <input type="hidden" name="profissional_hidden" id="profissional_adic_hidden" />
                        <input type="hidden" name="idlistapac2" id="idlistapac2" value="<?= $data['idlistapac2'] ?? null ?>"/>
                        <input type="hidden" name="ordem_hidden" id="ordem_hidden"/>
                        <input type="hidden" name="action" id="formAction" value="">
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

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

    function verPacienteNaLista(event, button) {
        event.preventDefault(); // Previne o comportamento padrão do botão

        $('#janelaAguarde').show(); // Exibe a janela de carregamento

        // Obtenha os valores diretamente dos campos do formulário
        const idfila = $('#fila').val(); // Pega o valor de idFila usando jQuery
        const ordem = $('#ordem_hidden').val(); // Pega o valor de ordem usando jQuery

        if (idfila && ordem) {
            var formData = new FormData();
            const arrayId = {
                idFila: idfila,
                nuOrdem: ordem
            };
            formData.append('arrayid', JSON.stringify(arrayId));

            const xhr = new XMLHttpRequest();
            xhr.open('POST', '<?= base_url('listaespera/verpacientenafrente') ?>', true);
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

            xhr.onload = function() {
                $('#janelaAguarde').hide(); // Esconde a janela de carregamento

                if (xhr.status >= 200 && xhr.status < 400) {
                    try {
                        var response = JSON.parse(xhr.responseText);
                        console.log(response);

                        if (response.success) {
                            if (response.message == 'Tem paciente') {
                                Swal.fire({
                                    title: 'Existe paciente na frente desse paciente na Fila Cirúrgica. Confirma a troca por esse paciente?',
                                    icon: 'question',
                                    showCancelButton: true,
                                    confirmButtonText: 'Ok',
                                    cancelButtonText: 'Cancelar'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        $('#janelaAguarde').show();
                                        //$('#idForm').off('submit'); // Remover qualquer manipulador de eventos existente
                                        //$('#idForm').submit(); // Submete
                                        confirma(button);
                                    } else {
                                        $('#janelaAguarde').hide(); // Esconde a janela de carregamento
                                    }
                                });
                            } else {
                                // Se não há pacientes, simplesmente submeta
                                $('#janelaAguarde').show();
                                $('#idForm').off('submit'); // Remover qualquer manipulador de eventos existente
                                $('#idForm').submit(); // Submete
                            }
                        } else {
                            alert('Erro: ' + response.message);
                        }
                    } catch (error) {
                        console.error('Erro ao analisar a resposta: ', error);
                        alert('Erro ao processar a resposta do servidor.');
                    }
                } else {
                    console.error('Erro ao enviar os dados: ' + xhr.status);
                    alert('Erro ao enviar os dados. Status: ' + xhr.status);
                }
            };

            xhr.onerror = function() {
                $('#janelaAguarde').hide(); // Esconde a janela de carregamento
                console.error('Erro na requisição AJAX.');
                alert('Erro na requisição AJAX.');
            };

            xhr.send(formData); // Envia os dados
        } else {
            // Se não houver idfila ou ordem, apenas submeta o formulário normalmente
            $('#idForm').submit();
        }
    };

    $(document).ready(function() {
        $('.select2-dropdown').select2({
            placeholder: "",
            allowClear: true,
            width: 'resolve' // Corrigir a largura
        });

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

        $('#candidato').select2({
            placeholder: "Selecione uma ou mais opções",
            allowClear: true,
            closeOnSelect: true // Fecha o dropdown automaticamente
        });

        var lateralidadeValue = $('input[name="lateralidade"]').val(); // O valor deve ser definido aqui para o hidden
        $('select[name="lateralidade"]').val(lateralidadeValue).change(); // 

        // Atualiza a lista de profissionais baseado no filtro selecionado
        $('#filtro_especialidades').change(function() {
            var selectedFilter = $(this).val();
            updateProfEspecialidades(selectedFilter);
        });

        $('#profissional').on('change', function() {
            $('#profissional_hidden').val($(this).val());
        });

        // Inicializa o valor do campo hidden, caso existam valores pré-selecionados
        $('#profissional_hidden').val($('#profissional').val());

        $('#proced_adic').on('change', function() {
            $('#proced_adic_hidden').val($(this).val());
        });

        // Inicializa o valor do campo hidden, caso existam valores pré-selecionados
        $('#proced_adic_hidden').val($('#proced_adic').val());
        
        $('#candidato').on('change', function() {
            var prontuarioValue = $(this).val();
            var ordemValue = $(this).find('option:selected').data('ordem');
            var idlistaValue = $(this).find('option:selected').data('id');
            var idFilaValue = $(this).find('option:selected').data('idfila');
            var procedimentoValue = $(this).find('option:selected').data('procedimento');
            var infoValue = $(this).find('option:selected').data('infoadicionais');
            var cidValue = $(this).find('option:selected').data('cid');
            var riscoValue = $(this).find('option:selected').data('risco');
            var complexidadeValue = $(this).find('option:selected').data('complexidade');
            var lateralidadeValue = $(this).find('option:selected').data('lateralidade');
            var origemValue = $(this).find('option:selected').data('origem');
            var congelacaoValue = $(this).find('option:selected').data('congelacao');
            var opmeValue = $(this).find('option:selected').data('opme');

            var dtriscoValue = $(this).find('option:selected').data('dtrisco');
            if (dtriscoValue) {
                const [year, month, day] = dtriscoValue.split("-");
                dtriscoValue = `${day}/${month}/${year}`; // Formato dd/mm/yyyy
            }

            $('select[name="cid"]').val(cidValue).change(); // Define o valor do hidden
            $('textarea[name="info"]').val(infoValue); // Define o valor do hidden
            $('select[name="risco"]').val(riscoValue).change(); // Define o valor do hidden
            $('select[name="lateralidade"]').val(lateralidadeValue).change(); // Define o valor do hidden
            $('input[name="dtrisco"]').val(dtriscoValue); // Define o valor do hidden
            $('input[name="risco"]').val(riscoValue); // Define o valor do hidden
            $('input[name="origem"]').val(origemValue); // Define o valor do hidden
            $('input[name="lateralidade"]').val(lateralidadeValue); // Define o valor do hidden
            $('input[name="idlistapac2"]').val(idlistaValue); // Define o valor do hidden
            $('input[name="ordem_hidden"]').val(ordemValue); // Define o valor do hidden
            $('input[name="fila_hidden"]').val(idFilaValue); // Define o valor do hidden
            $('input[name="procedimento_hidden"]').val(procedimentoValue); // Define o valor do hidden
            //$('input[name="complexidade"]').val(complexidadeValue).prop('checked', true);; // Define o valor do hidden
            $('input[name="complexidade"][value="' + complexidadeValue + '"]').prop('checked', true).trigger('change');
            $('input[name="congelacao"][value="' + congelacaoValue + '"]').prop('checked', true).trigger('change');
            $('input[name="opme"][value="' + opmeValue + '"]').prop('checked', true).trigger('change');

            $('#fila').val(idFilaValue).change(); // Atualiza o valor e dispara evento change se necessário
            $('#procedimento').val(procedimentoValue).change(); // Atualiza o valor e dispara evento change se necessário

            $('#proced_adic option[value="' + procedimentoValue + '"]').remove();
        });

        $('#risco').change(function() {
            var selectedFilter = $(this).val();
            $('input[name="risco"]').val(selectedFilter);
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

         // Inicializa os profissionais adicionais já selecionados
         updateProfEspecialidades($('#filtro_especialidades').val());

        /* <--?php if (isset($data['idlistapac2']) && !empty($data['idlistapac2'])) { ?>
            $('#candidato').val(<--?= $data['idlistapac2']?>).change(); 
        <--?php } ?>  */

    });
</script>
