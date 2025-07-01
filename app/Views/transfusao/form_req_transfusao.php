<?= csrf_field() ?>
<?php $validation = \Config\Services::validation(); ?>

<div class="container mt-4 mb-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card form-container">
                <div class="card-header text-center text-black">
                    <b>Requisição Transfusional</b>
                </div>
                <div class="card-body has-validation">
                    <form id="formTransfusao" method="post" action="<?= base_url('transfusao/incluir') ?>">
                        <!-- Dados do Paciente -->
                        <div class="row g-3">
                            <div class="col-md-2">
                                <div class="mb-2">
                                    <label for="prontuario" class="form-label">Prontuario<b class="text-danger">*</b></label>
                                    <div class="input-group">
                                        <input type="text" id="prontuario" maxlength="8" inputmode="numeric" pattern="\d*" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 8);"
                                        class="form-control <?php if($validation->getError('prontuario')): ?>is-invalid<?php endif ?>"
                                        name="prontuario" value="<?= set_value('prontuario', isset($idprontuario) ? $idprontuario : '') ?>" <?= isset($idprontuario) ? 'readonly' : '' ?> />
                                        <?php if ($validation->getError('prontuario')): ?>
                                                <div class="invalid-feedback">
                                                    <?= $validation->getError('prontuario') ?>
                                                </div>
                                            <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label for="nome" class="form-label">Nome do Paciente</b></label>
                                    <div class="input-group mb-12">
                                        <input type="text" id="nome" maxlength="100" 
                                        class="form-control <?php if($validation->getError('nome')): ?>is-invalid<?php endif ?>"
                                        name="nome" value="<?= set_value('nome') ?>" readonly/>
                                        <?php if ($validation->getError('nome')): ?>
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('nome') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 mb-2">
                                <label class="form-label">Data Nascimento<b class="text-danger">*</b></label>
                                <div class="input-group mb-12">
                                    <input type="text" name="dtnascimento" id="dtnascimento" class="form-control <?= $validation->hasError('dtnascimento') ? 'is-invalid' : '' ?>" value="<?= set_value('dtnascimento') ?>" disabled/>
                                </div>
                                <div class="invalid-feedback"><?= $validation->getError('dtnascimento') ?></div>
                            </div>
                            <div class="col-md-2 mb-2">
                                <label class="form-label">Sexo<b class="text-danger">*</b></label>
                                <div class="input-group mb-12">
                                    <input type="text" name="sexo" id="sexo" class="form-control <?= $validation->hasError('sexo') ? 'is-invalid' : '' ?>" value="<?= set_value('sexo') ?>" disabled/>
                                </div>
                                <div class="invalid-feedback"><?= $validation->getError('sexo') ?></div>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-5 mb-2">
                                <label class="form-label">Enfermaria<b class="text-danger">*</b></label>
                                <div class="input-group mb-12">
                                    <input type="text" name="enfermaria" class="form-control <?= $validation->hasError('enfermaria') ? 'is-invalid' : '' ?>" value="<?= set_value('enfermaria') ?>" disabled/>
                                </div>
                                <div class="invalid-feedback"><?= $validation->getError('enfermaria') ?></div>
                            </div>
                            <div class="col-md-2 mb-2">
                                <label class="form-label">Andar<b class="text-danger">*</b></label>
                                <div class="input-group mb-12">
                                    <input type="text" name="andar" class="form-control <?= $validation->hasError('andar') ? 'is-invalid' : '' ?>" value="<?= set_value('andar') ?>" disabled/>
                                </div>
                                <div class="invalid-feedback"><?= $validation->getError('andar') ?></div>
                            </div>
                            <div class="col-md-5 mb-2">
                                <label class="form-label">Leito<b class="text-danger">*</b></label>
                                <div class="input-group mb-12">
                                    <input type="text" name="leito" class="form-control <?= $validation->hasError('leito') ? 'is-invalid' : '' ?>" value="<?= set_value('leito') ?>" disabled/>
                                </div>
                                <div class="invalid-feedback"><?= $validation->getError('leito') ?></div>
                            </div>
                        </div>
                        <!-- Diagnóstico e Indicação -->
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label class="form-label" for="diagnostico">Diagnóstico</label>
                                    <div class="input-group mb-12">
                                        <textarea id="diagnostico" maxlength="250" rows="3"
                                                class="form-control <?= isset($validation) && $validation->getError('diagnostico') ? 'is-invalid' : '' ?>"
                                                name="diagnostico"><?= isset($data['diagnostico']) ? $data['diagnostico'] : '' ?></textarea>
                                        <?php if (isset($validation) && $validation->getError('diagnostico')): ?>
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('diagnostico') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label class="form-label" for="indicacao">Indicação</label>
                                    <div class="input-group mb-12">
                                        <textarea id="indicacao" maxlength="250" rows="3"
                                                class="form-control <?= isset($validation) && $validation->getError('indicacao') ? 'is-invalid' : '' ?>"
                                                name="indicacao"><?= isset($data['indicacao']) ? $data['indicacao'] : '' ?></textarea>
                                        <?php if (isset($validation) && $validation->getError('indicacao')): ?>
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('indicacao') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-12">
                                <div class="mb-2">
                                    <label for="cirurgia" class="form-label">Cirurgia</label>
                                    <select class="form-select select2-dropdown <?php if($validation->getError('cirurgia')): ?>is-invalid<?php endif ?>" 
                                    id="cirurgia" name="cirurgia">
                                        <option value=""></option>
                                        <!-- As opções serão preenchidas dinamicamente -->
                                    </select>
                                    <?php if ($validation->getError('cirurgia')): ?>
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('cirurgia') ?>
                                            </div>
                                        <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-3 mb-2">
                                <label class="form-label">Peso (Kg)</label>
                                <div class="input-group mb-12">
                                    <input type="number" step="0.1" name="peso" class="form-control" value="<?= set_value('peso') ?>" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-2">
                                    <label class="form-label">Sangramento Ativo<b class="text-danger">*</b></label>
                                    <div class="input-group mb-2 bordered-container">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="sangramento" id="sangramentoN" value="N"
                                                <?= (isset($data['sangramento']) && $data['sangramento'] == 'N') ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="sangramentoN" style="margin-right: 10px;">&nbsp;Não</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="sangramento" id="sangramentoS" value="S"
                                                <?= (isset($data['sangramento']) && $data['sangramento'] == 'S') ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="sangramentoS" style="margin-right: 10px;">&nbsp;Sim</label>
                                        </div>
                                    </div>
                                </div>
                                <?php if ($validation->getError('sangramento')): ?>
                                    <div class="invalid-feedback d-block">
                                        <?= $validation->getError('sangramento') ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-2">
                                    <label class="form-label">Transfusão Anterior<b class="text-danger">*</b></label>
                                    <div class="input-group mb-2 bordered-container">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="transfusao_anterior" id="transfusao_anteriorN" value="N"
                                                <?= (isset($data['transfusao_anterior']) && $data['transfusao_anterior'] == 'N') ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="transfusao_anteriorN" style="margin-right: 10px;">&nbsp;Não</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="transfusao_anterior" id="transfusao_anteriorS" value="S"
                                                <?= (isset($data['transfusao_anterior']) && $data['transfusao_anterior'] == 'S') ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="transfusao_anteriorS" style="margin-right: 10px;">&nbsp;Sim</label>
                                        </div>
                                    </div>
                                </div>
                                <?php if ($validation->getError('transfusao_anterior')): ?>
                                    <div class="invalid-feedback d-block">
                                        <?= $validation->getError('transfusao_anterior') ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-2">
                                    <label class="form-label">Reação Transf<b class="text-danger">*</b></label>
                                    <div class="input-group mb-2 bordered-container">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="reacao_transf" id="reacao_transfN" value="N"
                                                <?= (isset($data['reacao_transf']) && $data['reacao_transf'] == 'N') ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="reacao_transfN" style="margin-right: 10px;">&nbsp;Não</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="reacao_transf" id="reacao_transfS" value="S"
                                                <?= (isset($data['reacao_transf']) && $data['reacao_transf'] == 'S') ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="reacao_transfS" style="margin-right: 10px;">&nbsp;Sim</label>
                                        </div>
                                    </div>
                                </div>
                                <?php if ($validation->getError('reacao_transf')): ?>
                                    <div class="invalid-feedback d-block">
                                        <?= $validation->getError('reacao_transf') ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <!-- Hemocomponentes -->
                        <div class="row g-3">
                            <div class="col-md-12" id="hemocomp-section">
                                <div class="mb-2">
                                    <label class="form-label">Hemocomponentes (unid/ml)</label>
                                    <div class="bordered-container p-3">
                                        <div class="row g-2">
                                            <div class="col-md-3"><label>CH - Concentrado de Hemácias</label><input type="number" step="1" name="ch" class="form-control" value="<?= set_value('ch') ?>"></div>
                                            <div class="col-md-3"><label>CP - Concentrado de Plaquetas</label><input type="number" step="1" name="cp" class="form-control" value="<?= set_value('cp') ?>"></div>
                                            <div class="col-md-3"><label>PFC - Plasma Fresco Congelado</label><input type="number" step="1" name="pfc" class="form-control" value="<?= set_value('pfc') ?>"></div>
                                            <div class="col-md-3"><label>Crioprecipitado</label><input type="number" step="1" name="crio" class="form-control" value="<?= set_value('crio') ?>"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Dados laboratoriais -->
                        <div class="row g-3">
                            <div class="col-md-12" id="hemocomp-section">
                                <div class="mb-2">
                                    <label class="form-label">Dados Laboratoriais</label>
                                    <div class="bordered-container p-3">
                                        <div class="row g-3">
                                            <!-- Hematócrito -->
                                            <div class="col-md-6">
                                                <div class="border rounded p-2">
                                                    <div class="row g-2 align-items-end">
                                                        <div class="col-md-6">
                                                            <label>Hematócrito (%)</label>
                                                            <input type="number" step="0.1" name="hematocrito" class="form-control" value="<?= set_value('hematocrito') ?>">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label>Data</label>
                                                            <input type="date" name="dt_hematocrito" class="form-control" value="<?= set_value('dt_hematocrito') ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Hemoglobina -->
                                            <div class="col-md-6">
                                                <div class="border rounded p-2">
                                                    <div class="row g-2 align-items-end">
                                                        <div class="col-md-6">
                                                            <label>Hemoglobina (g/dL)</label>
                                                            <input type="number" step="0.1" name="hemoglobina" class="form-control" value="<?= set_value('hemoglobina') ?>">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label>Data</label>
                                                            <input type="date" name="dt_hemoglobina" class="form-control" value="<?= set_value('dt_hemoglobina') ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                             <!-- Plaqutas -->
                                            <div class="col-md-6">
                                                <div class="border rounded p-2">
                                                    <div class="row g-2 align-items-end">
                                                        <div class="col-md-6">
                                                            <label>Plaquetas (g/dl)</label>
                                                            <input type="number" step="0.1" name="plaquetas" class="form-control" value="<?= set_value('plaquetas') ?>">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label>Data</label>
                                                            <input type="date" name="dt_plaquetas" class="form-control" value="<?= set_value('dt_plaquetas') ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- TAP -->
                                            <div class="col-md-6">
                                                <div class="border rounded p-2">
                                                    <div class="row g-2 align-items-end">
                                                        <div class="col-md-6">
                                                            <label>TAP (seg)</label>
                                                            <input type="number" step="0.1" name="tap" class="form-control" value="<?= set_value('tap') ?>">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label>Data</label>
                                                            <input type="date" name="dt_tap" class="form-control" value="<?= set_value('dt_tap') ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- INR -->
                                            <div class="col-md-6">
                                                <div class="border rounded p-2">
                                                    <div class="row g-2 align-items-end">
                                                        <div class="col-md-6">
                                                            <label>INR</label>
                                                            <input type="number" step="0.01" name="inr" class="form-control" value="<?= set_value('inr') ?>">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label>Data</label>
                                                            <input type="date" name="dt_inr" class="form-control" value="<?= set_value('dt_inr') ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- PTT -->
                                            <div class="col-md-6">
                                                <div class="border rounded p-2">
                                                    <div class="row g-2 align-items-end">
                                                        <div class="col-md-6">
                                                            <label>PTT (seg)</label>
                                                            <input type="number" step="0.1" name="ptt" class="form-control" value="<?= set_value('ptt') ?>">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label>Data</label>
                                                            <input type="date" name="dt_ptt" class="form-control" value="<?= set_value('dt_ptt') ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Fibrinogênio -->
                                            <div class="col-md-6">
                                                <div class="border rounded p-2">
                                                    <div class="row g-2 align-items-end">
                                                        <div class="col-md-6">
                                                            <label>Fibrinogênio (mg/dL)</label>
                                                            <input type="number" name="fibrinogenio" class="form-control" value="<?= set_value('fibrinogenio') ?>">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label>Data</label>
                                                            <input type="date" name="dt_fibrinogenio" class="form-control" value="<?= set_value('dt_fibrinogenio') ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> <!-- /.row -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Procedimentos Especiais -->
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label class="form-label">Procedimentos Especiais</label>
                                    <div class="bordered-container p-3">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="procedimento_especial" id="procedimento_especialF" value="F"
                                                <?= (isset($data['procedimento_especial']) && $data['procedimento_especial'] == 'F') ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="procedimento_especialF" style="margin-right: 10px;">&nbsp;Filtrado</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="procedimento_especial" id="procedimento_especialI" value="I"
                                                <?= (isset($data['procedimento_especial']) && $data['procedimento_especial'] == 'I') ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="procedimento_especialI" style="margin-right: 10px;">&nbsp;Irradiado</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="congelacao" id="procedimento_especialL" value="L"
                                                <?= (isset($data['procedimento_especial']) && $data['procedimento_especial'] == 'L') ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="procedimento_especiaL" style="margin-right: 10px;">&nbsp;Lavado</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="procedimento_especial" id="procedimento_especialO" value="O"
                                                <?= (isset($data['procedimento_especial']) && $data['procedimento_especial'] == 'O') ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="procedimento_especialO" style="margin-right: 10px;">&nbsp;Outros</label>
                                        </div>
                                        <?php if ($validation->getError('procedimento_especial')): ?>
                                            <div class="invalid-feedback d-block">
                                                <?= $validation->getError('procedimento_especial') ?>
                                            </div>
                                        <?php endif; ?>
                                        <!-- Justificativa abaixo de "Outros" -->
                                        <div class="mt-1">
                                            <label for="justificativa_proc_esp" class="form-label">Justificativa</label>
                                            <textarea name="justificativa_proc_esp" id="justificativa_proc_esp" class="form-control" rows="2"><?= set_value('justificativa_proc_esp') ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Tipo de Transfusão -->
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label class="form-label">Tipo de Transfusão</label>
                                    <div class="bordered-container p-3">
                                        <!-- Rotina -->
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="radio" name="tipo_transfusao" id="transfusao_rotina" value="R" <?= set_radio('tipo_transfusao', 'rotina') ?>>
                                            <label class="form-check-label" for="transfusao_rotina">
                                                Rotina (em até 24h)
                                            </label>
                                        </div>
                                        <!-- Urgência -->
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="radio" name="tipo_transfusao" id="transfusao_urgencia" value="U" <?= set_radio('tipo_transfusao', 'urgencia') ?>>
                                            <label class="form-check-label" for="transfusao_urgencia">
                                                Urgência (em até 3h)
                                            </label>
                                        </div>
                                        <!-- Emergência -->
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="radio" name="tipo_transfusao" id="transfusao_emergencia" value="E" <?= set_radio('tipo_transfusao', 'emergencia') ?>>
                                            <label class="form-check-label" for="transfusao_emergencia">
                                                Emergência
                                            </label>
                                        </div>
                                         <!-- Emergência sem compatibilidade -->
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="radio" name="tipo_transfusao" id="transfusao_emergencia_semteste" value="EST" <?= set_radio('tipo_transfusao', 'emergencia_semteste') ?>>
                                            <label class="form-check-label" for="transfusao_emergencia_semteste">
                                                Emergência (sem teste de compatibilidade)
                                            </label>
                                        </div>
                                        <!-- Programada + Data -->
                                        <div class="form-check d-flex align-items-center" style="margin-bottom: 32px;">
                                            <input class="form-check-input me-2" type="radio" name="tipo_transfusao" id="transfusao_programada" value="P" <?= set_radio('tipo_transfusao', 'programada') ?>>
                                            <label class="form-check-label me-2" for="transfusao_programada">
                                                Programada
                                            </label>
                                            <input type="date"
                                                name="dt_programada"
                                                id="dt_programada"
                                                class="form-control form-control-sm"
                                                style="width: 100%; max-width: 200px; display: <?= set_radio('tipo_transfusao', 'programada') ? 'inline-block' : 'none' ?>;"
                                                value="<?= set_value('dt_programada') ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Amostra -->
                        <div class="row g-3">
                            <div class="col-md-12 mb-2">
                                <label class="form-label">Amostra</label>
                                <div class="bordered-container p-3">
                                    <div class="row g-2 align-items-end">
                                        <!-- Nome do Coletor -->
                                        <div class="col-md-6">
                                            <label for="coletor">Nome do Coletor</label>
                                            <select class="form-select select2-dropdown <?php if($validation->getError('coletor')): ?>is-invalid<?php endif ?>"
                                                id="coletor" name="coletor"
                                                data-placeholder="Selecione uma opção" data-allow-clear="1">
                                                <option value="" <?php echo set_select('coletor', '', TRUE); ?>></option>
                                                <?php
                                                foreach ($data['servidores'] as $servidor) {
                                                    $selected = ($data['coletor'] == $servidor->pes_codigo) ? 'selected' : '';
                                                    echo '<option value="'.$servidor->pes_codigo.'" '.$selected.'>'.$servidor->nome.'</option>';
                                                }
                                                ?>
                                            </select>
                                            <?php if ($validation->getError('coletor')): ?>
                                                <div class="invalid-feedback">
                                                    <?= $validation->getError('coletor') ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <!-- Data da Coleta -->
                                        <div class="col-md-3">
                                            <label for="dt_coleta">Data da Coleta</label>
                                            <input type="date" name="dt_coleta" id="dt_coleta" class="form-control" value="<?= set_value('dt_coleta') ?>">
                                        </div>
                                        <!-- Hora da Coleta -->
                                        <div class="col-md-3">
                                            <label for="hr_coleta">Hora da Coleta</label>
                                            <input type="time" name="hr_coleta" id="hr_coleta" class="form-control" value="<?= set_value('hr_coleta') ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Solicitação -->
                        <div class="row g-3">
                            <div class="col-md-12 mb-2">
                                <label class="form-label">Solicitação</label>
                                <div class="bordered-container p-3">
                                    <div class="row g-2 align-items-end">
                                        <!-- Médico Solicitante -->
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="medico_solicitante" class="form-label">Médico Solicitante <b class="text-danger">*</b></label>
                                                <select class="form-select select2-dropdown <?= $validation->hasError('medico_solicitante') ? 'is-invalid' : '' ?>"
                                                        id="medico_solicitante" name="medico_solicitante" data-placeholder="" data-allow-clear="1">
                                                    <option value=""></option> <!-- valor vazio para placeholder -->
                                                    <?php foreach ($data['prof_especialidades'] as $prof_espec): ?>
                                                        <option value="<?= $prof_espec->pes_codigo ?>"
                                                            <?= set_select('medico_solicitante', $prof_espec->pes_codigo) ?>>
                                                            <?= $prof_espec->nome . ' - ' . $prof_espec->conselho ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <?php if ($validation->hasError('medico_solicitante')): ?>
                                                    <div class="invalid-feedback">
                                                        <?= $validation->getError('medico_solicitante') ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <!-- Data da Solicitação -->
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label for="dt_solicitacao" class="form-label">Data</label>
                                                <input type="date" name="dt_solicitacao" id="dt_solicitacao" class="form-control" value="<?= set_value('dt_solicitacao') ?>">
                                            </div>
                                        </div>

                                        <!-- Hora da Solicitação -->
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label for="hr_solicitacao" class="form-label">Hora</label>
                                                <input type="time" name="hr_solicitacao" id="hr_solicitacao" class="form-control" value="<?= set_value('hr_solicitacao') ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Observações -->
                        <div class="mb-3">
                            <label class="form-label">Observações</label>
                            <textarea class="form-control" rows="3" name="observacoes"><?= set_value('observacoes') ?></textarea>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-12 d-flex gap-2 mt-4">
                                <button id="btnAcao" class="btn btn-primary mt-4">
                                    <i class="fa-solid fa-floppy-disk"></i> Salvar
                                </button>
                                <?php if (session()->has('inclusao_sucesso')): ?>
                                    <a class="btn btn-info mt-4" href="<?= base_url('transfusao/requisitar') ?>">
                                        <i class="fa-solid fa-plus"></i> Novo Requerimento
                                    </a>
                                <?php endif; ?>
                                <a class="btn btn-warning mt-4" href="javascript:history.go(-1)">
                                    <i class="fa-solid fa-arrow-left"></i> Voltar
                                </a>
                                <?php if (session()->has('inclusao_sucesso')): ?>
                                    <script>
                                        document.addEventListener('DOMContentLoaded', function () {
                                            const btn = document.getElementById('btnAcao');
                                            if (btn) {
                                                btn.className = 'btn btn-success mt-4';
                                                btn.innerHTML = '<i class="fa-solid fa-print"></i> Imprimir';
                                                btn.onclick = function () {
                                                    window.print();
                                                };
                                            }
                                        });
                                    </script>
                                <?php endif; ?>
                            </div>
                        </div>

                        <input type="hidden" name="idmapa_hidden" id="idmapa_hidden" value=""/>
                        <input type="hidden" name="pac_codigo_hidden" id="pac_codigo_hidden" value="<?= $data['pac_codigo'] ?>"/>
                        <input type="hidden" name="procedimento_hidden" id="procedimento_hidden" value=""/>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    window.onload = function() {
        const inputs = document.querySelectorAll('input, select, .form-check-input');
        inputs.forEach(input => {
            input.addEventListener('keydown', disableEnter);
        });
    };

       function fetchPacienteNome(prontuarioValue) {
        if (!prontuarioValue) {
            document.getElementById('nome').value = '';
            return;
        }

        // Controle para evitar múltiplas requisições
        let isSyncInProgress = false;

        fetch('<?= base_url('listaespera/getnomepac/') ?>' + prontuarioValue, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Erro ao buscar nome do paciente');
            }
            return response.json();
        })
        .then(data => {
            if (data.nome) {
                // Paciente encontrado, atualiza o campo
                document.getElementById('nome').value = data.nome;
                document.getElementById('sexo').value = data.sexo;
                document.getElementById('dtnascimento').value = data.dtnascimento;
                document.getElementById('pac_codigo_hidden').value = data.pac_codigo;
               
            } else {
                // Paciente não encontrado, exibe modal para sincronizar
                document.getElementById('nome').value = data.error || 'Nome não encontrado';

                Swal.fire({
                    title: 'Paciente não localizado na base local! <br>Deseja sincronizar com a base do AGHUX?',
                    text: 'Obs: isso pode levar alguns minutos',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ok',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed && !isSyncInProgress) {
                        // Prevenir chamadas duplicadas
                        isSyncInProgress = true;

                        $('#janelaAguarde').show();

                        fetch('<?= base_url('listaespera/sincronizaraghux/') ?>' + prontuarioValue, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            }
                        })
                        .then(syncResponse => {
                            if (!syncResponse.ok) {
                                throw new Error('Erro na sincronização');
                            }
                            return syncResponse.json();
                        })
                        .then(syncData => {
                            Swal.fire({
                                title: 'Sincronização concluída!',
                                text: 'Os dados foram atualizados com sucesso.',
                                icon: 'success'
                            });
                            if (syncData.nome) {
                                document.getElementById('nome').value = syncData.nome;
                            } else {
                                document.getElementById('nome').value = 'Não encontrado após sincronização';
                            }
                        })
                        .catch(syncError => {
                            console.error('Erro na sincronização:', syncError);
                            Swal.fire({
                                title: 'Erro',
                                text: 'Não foi possível sincronizar os dados.',
                                icon: 'error'
                            });
                        })
                        .finally(() => {
                            isSyncInProgress = false; // Sincronização concluída ou falhou
                            $('#janelaAguarde').hide(); // Ocultar indicador de carregamento
                        });
                    }
                });
            }
        })
        .catch(error => {
            console.error('Erro ao buscar nome do paciente:', error);
            document.getElementById('nome').value = '';
            Swal.fire({
                title: 'Erro',
                text: 'Houve um problema ao buscar os dados do paciente. Tente novamente.',
                icon: 'error'
            });
        });
    }
    
    function updatecirurgia(prontuario, valorSelecionado = null) {

        const cirurgiaSelect = document.getElementById('cirurgia');

        cirurgiaSelect.innerHTML = '<option value=""></option>'; 

        //alert(valorSelecionado);

        if (prontuario) {

            $('#janelaAguarde').show();

            $.ajax({
                url: '<?= base_url('mapacirurgico/getcirurgias') ?>',
                type: 'POST',
                data: {prontuario: prontuario},
                dataType: 'json',
                success: function(data) {

                    if (data.length === 0) {
                        const option = document.createElement("option");
                        option.value = "0"; 
                        option.text = 'Paciente não está no Mapa Cirúrgico';
                        cirurgiaSelect.add(option);
                    } else {
                        data.forEach(item => {
                            cirurgiaSelect.innerHTML = '<option value="">Selecione uma opção</option>';

                            const option = document.createElement("option");
                            option.value = item.id;

                            const [data, hora] = item.dthrcirurgia.split(' ');
                            const [ano, mes, dia] = data.split('-');
                            const [horas, minutos] = hora.split(':');
                            const dthrcirurgia = `${dia}/${mes}/${ano} ${horas}:${minutos}`;

                            option.text = `Data/Hora: ${dthrcirurgia} - Espec: ${item.especialidade_descricao} - Fila: ${item.fila} - Proced: ${item.procedimento_principal}`;

                            option.setAttribute('data-idmapa-id', item.id);
                            option.setAttribute('data-pac_codigo-id', item.codigo);
                            option.setAttribute('data-especialidade-id', item.idespecialidade);
                            option.setAttribute('data-procedimento-id', item.idprocedimento);

                            if (valorSelecionado == item.id) {
                                option.selected = true;
                            }

                            cirurgiaSelect.add(option);
                        });
                    }

                    $('#janelaAguarde').hide();

                },
                error: function(xhr, status, error) {
                    console.error('Erro ao buscar Mapa Cirúrgico:', error);
                }
            });

        } else {
            // Se o prontuário estiver vazio, limpe o select ou mantenha o estado atual
            cirurgiaSelect.innerHTML = '<option value="">Selecione uma opção</option>';
        }

    }

    function preencherSelectcirurgia(dadosServidor) {
        const lista = document.getElementById('cirurgia');

        // Limpar o select antes de adicionar novas opções
        lista.innerHTML = '<option value="">Selecione uma opção</option>'; // Adiciona o placeholder

        //alert(dadosServidor);
        // Preencher o select com os dados recebidos do servidor

        if (Array.isArray(dadosServidor) && dadosServidor.length > 0) {
            dadosServidor.forEach(item => {
                // Dividir a string 'valor:texto'
                const [valor, texto] = item.split(':');
                
                if (valor && texto) { // Verificar se ambos valor e texto estão definidos
                    // Criar e adicionar nova opção
                    const option = document.createElement('option');
                    option.value = valor.trim(); // Atribuir o valor ao option e remover espaços em branco
                    option.text = texto.trim(); // Atribuir o texto ao option e remover espaços em branco

                    lista.add(option); // Adicionar a nova opção ao select
                }
            });
        } else {
            console.warn("Nenhum dado disponível para preencher o select.");
        }
    }

    function fetchPacienteNomeOnLoad() {
        const prontuarioInput = document.getElementById('prontuario');

        fetchPacienteNome(prontuarioInput.value);
    }

    document.addEventListener('DOMContentLoaded', function () {
        const radios = document.querySelectorAll('input[name="tipo_transfusao"]');
        const dataField = document.getElementById('dt_programada');

        radios.forEach(radio => {
            radio.addEventListener('change', function () {
                if (this.value === 'P') {
                    dataField.style.display = 'inline-block';
                } else {
                    dataField.style.display = 'none';
                    dataField.value = '';
                }
            });
        });

    });
  
    $(document).ready(function() {
        
        $('.select2-dropdown').select2({
            //placeholder: "",
            allowClear: true,
            //width: 'resolve' // Corrigir a largura
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

        //-------------------------------------------------------------------------

        const prontuarioInput = document.getElementById('prontuario');

        prontuarioInput.addEventListener('change', function() {
            //alert(prontuarioInput.value);
            fetchPacienteNome(prontuarioInput.value);
            updatecirurgia(prontuarioInput.value);
        });

        $('#cirurgia').on('change', function() {
            const selectedValue = this.value;

            //alert(this.value);

            //if (selectedValue !== "0" && selectedValue) { // Verifica se o valor selecionado não é zero
                // Encontrar a opção correspondente que foi selecionada
                const selectedOption = this.options[this.selectedIndex];

                // Obter os IDs armazenados nos atributos data
                const updated_at = selectedOption.getAttribute('data-updated_at');
                const especialidadeId = selectedOption.getAttribute('data-especialidade-id');
                const filaId = selectedOption.getAttribute('data-fila-id');
                const procedimentoId = selectedOption.getAttribute('data-procedimento-id');
                const paccodigoId = selectedOption.getAttribute('data-pac_codigo-id');
                const mapaId = selectedOption.getAttribute('data-idmapa-id');

                $('#pac_codigo_hidden').val(paccodigoId);
                $('#idmapa_hidden').val(mapaId);
                $('#procedimento_hidden').val(procedimentoId);
                
            //}
        });

        document.getElementById('idForm').addEventListener('submit', function(event) {
            $('#janelaAguarde').show();

            const listaEsperaSelect = document.getElementById('cirurgia');
            const valoresTextos = Array.from(listaEsperaSelect.options)
                .filter(option => option.value)  // Ignora opções sem valor
                .map(option => {
                    // Retorna uma string para cada opção no formato: valor:texto
                    return `${option.value}:${option.text}`;
                });

            // Atribuir valores ao campo oculto
            document.getElementById('cirurgiaSelect').value = JSON.stringify(valoresTextos);

            // Opcionalmente envie o formulário agora
            // event.currentTarget.submit(); // Descomente para executar envio padrão após processamento
        });

       

    });
</script>