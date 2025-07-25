<?= csrf_field() ?>
<?php $validation = \Config\Services::validation(); ?>

    
                <div class="card-body has-validation">
                    <form id="formTransfusao" method="post" action="<?= base_url('transfusao/editar') ?>">
                        <!-- Dados do Paciente -->
                        <div class="row g-3">
                            <div class="col-md-2">
                                <div class="mb-2">
                                    <label for="prontuario" class="form-label">Prontuario<b class="text-danger">*</b></label>
                                    <div class="input-group">
                                        <input type="text" id="prontuario" maxlength="8" inputmode="numeric" pattern="\d*" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 8);"
                                        class="form-control <?php if($validation->getError('prontuario')): ?>is-invalid<?php endif ?>"
                                            name="prontuario" value="<?= set_value('prontuario', $data['prontuario'] ?? '') ?>" readonly/>
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
                                            name="nome" value="<?= set_value('nome', $data['nome'] ?? '') ?>" readonly/>
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
                                    <input type="text" name="dtnascimento" id="dtnascimento" class="form-control <?= $validation->hasError('dtnascimento') ? 'is-invalid' : '' ?>" value="<?= set_value('dtnascimento', $data['dtnascimento']) ?? ''?>" readonly/>
                                </div>
                                <div class="invalid-feedback"><?= $validation->getError('dtnascimento') ?></div>
                            </div>
                            <div class="col-md-2 mb-2">
                                <label class="form-label">Sexo<b class="text-danger">*</b></label>
                                <div class="input-group mb-12">
                                    <input type="text" name="sexo" id="sexo" class="form-control <?= $validation->hasError('sexo') ? 'is-invalid' : '' ?>" value="<?= set_value('sexo', $data['sexo']) ?? ''?>" readonly/>
                                </div>
                                <div class="invalid-feedback"><?= $validation->getError('sexo') ?></div>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-5 mb-2">
                                <label class="form-label">Unidade<b class="text-danger">*</b></label>
                                <div class="input-group mb-12">
                                    <input type="text" name="unidade" id="unidade" class="form-control <?= $validation->hasError('unidade') ? 'is-invalid' : '' ?>" value="<?= set_value('unidade', $data['unidade']) ?? ''?>" readonly/>
                                </div>
                                <div class="invalid-feedback"><?= $validation->getError('unidade') ?></div>
                            </div>
                            <div class="col-md-2 mb-2">
                                <label class="form-label">Andar<b class="text-danger">*</b></label>
                                <div class="input-group mb-12">
                                    <input type="text" name="andar" id="andar" class="form-control <?= $validation->hasError('andar') ? 'is-invalid' : '' ?>" value="<?= set_value('andar', $data['andar']) ?? ''?>" readonly/>
                                </div>
                                <div class="invalid-feedback"><?= $validation->getError('andar') ?></div>
                            </div>
                            <div class="col-md-5 mb-2">
                                <label class="form-label">Leito<b class="text-danger">*</b></label>
                                <div class="input-group mb-12">
                                    <input type="text" name="leito" id="leito" class="form-control <?= $validation->hasError('leito') ? 'is-invalid' : '' ?>" value="<?= set_value('leito', $data['leito']) ?? ''?>" readonly/>
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
                                    <input type="number" step="0.1" name="peso" class="form-control" value="<?= set_value('peso', $data['peso']) ?>" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-2">
                                    <label class="form-label">Sangramento Ativo<b class="text-danger">*</b></label>
                                    <div class="input-group mb-2 bordered-container">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="sangramento_ativo" id="sangramento_ativoN" value="N"
                                                <?= (isset($data['sangramento_ativo']) && $data['sangramento_ativo'] == 'N') ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="sangramento_ativoN" style="margin-right: 10px;">&nbsp;Não</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="sangramento_ativo" id="sangramento_ativoS" value="S"
                                                <?= (isset($data['sangramento_ativo']) && $data['sangramento_ativo'] == 'S') ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="sangramento_ativoS" style="margin-right: 10px;">&nbsp;Sim</label>
                                        </div>
                                    </div>
                                </div>
                                <?php if ($validation->getError('sangramento_ativo')): ?>
                                    <div class="invalid-feedback d-block">
                                        <?= $validation->getError('sangramento_ativo') ?>
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
                                            <div class="col-md-3"><label>CH - Concentrado de Hemácias</label><input type="number" step="1" name="hemacias" class="form-control" value="<?= set_value('hemacias', $data['hemacias']) ?>"></div>
                                            <div class="col-md-3"><label>CP - Concentrado de Plaquetas</label><input type="number" step="1" name="plaquetas" class="form-control" value="<?= set_value('plaquetas', $data['plaquetas']) ?>"></div>
                                            <div class="col-md-3"><label>PFC - Plasma Fresco Congelado</label><input type="number" step="1" name="plasma" class="form-control" value="<?= set_value('plasma', $data['plasma']) ?>"></div>
                                            <div class="col-md-3"><label>Crioprecipitado</label><input type="number" step="1" name="crio" class="form-control" value="<?= set_value('crio', $data['crio']) ?>"></div>
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
                                                            <input type="number" step="0.1" name="hematocrito" class="form-control" value="<?= set_value('hematocrito', $data['hematocrito']) ?>">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label>Data</label>
                                                            <input type="date" name="dt_hematocrito" class="form-control" value="<?= set_value('dt_hematocrito', $data['dt_hematocrito']) ?>">
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
                                                            <input type="number" step="0.1" name="hemoglobina" class="form-control" value="<?= set_value('hemoglobina', $data['hemoglobina']) ?>">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label>Data</label>
                                                            <input type="date" name="dt_hemoglobina" class="form-control" value="<?= set_value('dt_hemoglobina', $data['dt_hemoglobina']) ?>">
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
                                                            <input type="number" step="0.1" name="plq" class="form-control" value="<?= set_value('plq', $data['plq']) ?>">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label>Data</label>
                                                            <input type="date" name="dt_plq" class="form-control" value="<?= set_value('dt_plq', $data['dt_plq']) ?>">
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
                                                            <input type="number" step="0.1" name="tap" class="form-control" value="<?= set_value('tap', $data['tap']) ?>">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label>Data</label>
                                                            <input type="date" name="dt_tap" class="form-control" value="<?= set_value('dt_tap', $data['dt_tap']) ?>">
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
                                                            <input type="number" step="0.01" name="inr" class="form-control" value="<?= set_value('inr', $data['inr']) ?>">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label>Data</label>
                                                            <input type="date" name="dt_inr" class="form-control" value="<?= set_value('dt_inr', $data['dt_inr']) ?>">
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
                                                            <input type="number" step="0.1" name="ptt" class="form-control" value="<?= set_value('ptt', $data['ptt']) ?>">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label>Data</label>
                                                            <input type="date" name="dt_ptt" class="form-control" value="<?= set_value('dt_ptt', $data['dt_ptt']) ?>">
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
                                                            <input type="number" name="fibrinogenio" class="form-control" value="<?= set_value('fibrinogenio', $data['fibrinogenio']) ?>">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label>Data</label>
                                                            <input type="date" name="dt_fibrinogenio" class="form-control" value="<?= set_value('dt_fibrinogenio', $data['dt_fibrinogenio']) ?>">
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
                                            <textarea name="justificativa_proc_esp" id="justificativa_proc_esp" class="form-control" rows="2"><?= set_value('justificativa_proc_esp', $data['justificativa_proc_esp']) ?></textarea>
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
<input class="form-check-input" type="radio" name="tipo_transfusao" id="transfusao_rotina" value="R" <?= set_radio('tipo_transfusao', 'R', $data['tipo_transfusao'] === 'R') ?>>
                                            <label class="form-check-label" for="transfusao_rotina">
                                                Rotina (em até 24h)
                                            </label>
                                        </div>
                                        <!-- Urgência -->
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="radio" name="tipo_transfusao" id="transfusao_urgencia" value="U" <?= set_radio('tipo_transfusao', 'U', $data['tipo_transfusao'] === 'U') ?>>
                                            <label class="form-check-label" for="transfusao_urgencia">
                                                Urgência (em até 3h)
                                            </label>
                                        </div>
                                        <!-- Emergência -->
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="radio" name="tipo_transfusao" id="transfusao_emergencia" value="E" <?= set_radio('tipo_transfusao', 'E', $data['tipo_transfusao'] === 'E') ?>>
                                            <label class="form-check-label" for="transfusao_emergencia">
                                                Emergência
                                            </label>
                                        </div>
                                         <!-- Emergência sem compatibilidade -->
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="radio" name="tipo_transfusao" id="transfusao_emergencia_semteste" value="EST" <?= set_radio('tipo_transfusao', 'EST', $data['tipo_transfusao'] === 'EST') ?>>
                                            <label class="form-check-label" for="transfusao_emergencia_semteste">
                                                Emergência (sem teste de compatibilidade)
                                            </label>
                                        </div>
                                        <!-- Programada + Data -->
                                        <div class="form-check d-flex align-items-center mb-2">
                                            <input class="form-check-input me-2" type="radio" name="tipo_transfusao" id="transfusao_programada" value="P"
                                                <?= set_radio('tipo_transfusao', 'P', $data['tipo_transfusao'] === 'P') ?>>
                                            <label class="form-check-label me-2" for="transfusao_programada">
                                                Programada
                                            </label>
                                            <input type="date"
                                                name="reserva_data"
                                                id="reserva_data"
                                                class="form-control form-control-sm"
                                                style="width: 100%; max-width: 200px; <?= ($data['tipo_transfusao'] === 'P') ? '' : 'display: none;' ?>"
                                                value="<?= set_value('reserva_data', $data['reserva_data']) ?>">
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
                                            <input type="date" name="dthr_coleta" id="dthr_coleta" class="form-control" value="<?= set_value('dthr_coleta', $data['dthr_coleta'] ?? '') ?>">
                                        </div>
                                        <!-- Hora da Coleta -->
                                        <div class="col-md-3">
                                            <label for="hr_coleta">Hora da Coleta</label>
                                            <input type="time" name="hr_coleta" id="hr_coleta" class="form-control" value="<?= set_value('hr_coleta', $data['hr_coleta'] ?? '') ?>">
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
                                                            <?= set_select('medico_solicitante', $prof_espec->pes_codigo, $data['medico_solicitante'] == $prof_espec->pes_codigo) ?>>
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
                                                <input type="date" name="dthr_solicitacao" id="dthr_solicitacao" class="form-control" value="<?= set_value('dthr_solicitacao', $data['dthr_solicitacao'] ?? '') ?>">                                            </div>
                                        </div>
                                        <!-- Hora da Solicitação -->
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label for="hr_solicitacao" class="form-label">Hora</label>
                                                <input type="time" name="hr_solicitacao" id="hr_solicitacao" class="form-control" value="<?= set_value('hr_solicitacao', $data['hr_solicitacao'] ?? '') ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Observações -->
                        <div class="mb-3">
                            <label class="form-label">Observações</label>
                            <textarea class="form-control" rows="3" name="observacoes"><?= set_value('observacoes', $data['observacoes']) ?></textarea>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-12 d-flex gap-2 mt-4">
                                <button id="btnAcao" class="btn btn-primary mt-4">
                                    <i class="fa-solid fa-floppy-disk"></i> Salvar
                                </button>
                               <!--  <-?php if (session()->has('inclusao_sucesso')): ?>
                                    <button class="btn btn-info mt-4" id="btnNovoRequerimento">
                                        <i class="fa-solid fa-plus"></i> Novo Requerimento
                                    </button>
                                    <button id="btnImprimir" class="btn btn-success mt-4">
                                        <i class="fa-solid fa-print"></i> Imprimir
                                    </button>
                                <-?php endif; ?> -->
                                <a class="btn btn-warning mt-4" href="javascript:history.go(-1)">
                                    <i class="fa-solid fa-arrow-left"></i> Voltar
                                </a>
                            </div>
                        </div>

                        <input type="hidden" name="idreq" id="idreq" value="<?= $data['idreq'] ?>"/>
                        <input type="hidden" name="idmapa_hidden" id="idmapa_hidden" value=""/>
                        <input type="hidden" name="pac_codigo_hidden" id="pac_codigo_hidden" value="<?= $data['pac_codigo'] ?>"/>
                        <input type="hidden" name="procedimento_hidden" id="procedimento_hidden" value=""/>

                    </form>
                </div>
           
<script>
    $(document).ready(function() {

        $('.select2-dropdown').select2({
            //placeholder: "",
            allowClear: true,
            //width: 'resolve' // Corrigir a largura
        });
    });
    
    document.addEventListener('DOMContentLoaded', function () {
    const radios = document.querySelectorAll('input[name="tipo_transfusao"]');
    const reservaData = document.getElementById('reserva_data');

    function toggleReservaData() {
        const selected = document.querySelector('input[name="tipo_transfusao"]:checked');
        if (selected && selected.value === 'P') {
            reservaData.style.display = 'inline-block';
        } else {
            reservaData.style.display = 'none';
            reservaData.value = ''; // opcional: limpa o valor
        }
    }

    // Executa ao carregar
    toggleReservaData();

    // Escuta mudança nos rádios
    radios.forEach(radio => {
        radio.addEventListener('change', toggleReservaData);
    });
});

</script>

