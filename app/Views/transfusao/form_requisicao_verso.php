<?= csrf_field() ?>
<?php $validation = \Config\Services::validation(); ?>

                <div class="card-body has-validation">
                    <form id="formTransfusao" method="post" action="<?= base_url('transfusao/incluirtestes') ?>">
                        <div class="row g-3">
                            <div class="col-md-2">
                                <div class="mb-2">
                                    <label for="dthrequisicao" class="form-label">Dt/Hr Requisição<b class="text-danger">*</b></label>
                                    <div class="input-group">
                                        <input type="text" id="dthrequisicao" maxlength="8" inputmode="numeric" pattern="\d*" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 8);"
                                        class="form-control <?php if($validation->getError('dthrequisicao')): ?>is-invalid<?php endif ?>"
                                        name="dthrequisicao" value="<?= set_value('dthrequisicao', $data['dthrequisicao'] ?? '') ?>" readonly/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-2">
                                    <label for="prontuario" class="form-label">Prontuario<b class="text-danger">*</b></label>
                                    <div class="input-group">
                                        <input type="text" id="prontuario" maxlength="8" inputmode="numeric" pattern="\d*" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 8);"
                                        class="form-control <?php if($validation->getError('prontuario')): ?>is-invalid<?php endif ?>"
                                            name="prontuario" value="<?= set_value('prontuario', $data['prontuario'] ?? '') ?>" readonly/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="mb-2">
                                    <label for="nome" class="form-label">Nome do Paciente</b></label>
                                    <div class="input-group mb-12">
                                        <input type="text" id="nome" maxlength="100" 
                                            class="form-control <?php if($validation->getError('nome')): ?>is-invalid<?php endif ?>"
                                            name="nome" value="<?= set_value('nome', $data['nome'] ?? '') ?>" readonly/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Amostra Recebida -->
                        <div class="row g-3">
                            <div class="col-md-12 mb-4">
                                <label class="form-label">Amostra Recebida Por</label>
                                <div class="bordered-container p-3">
                                    <div class="row g-2 align-items-end">
                                        <!-- Nome do recebedor -->
                                         <div class="col-md-6">
                                            <label for="recebedor">Nome</label>
                                            <select class="form-select select2-dropdown <?php if($validation->getError('recebedor')): ?>is-invalid<?php endif ?>"
                                                id="recebedor" name="recebedor"
                                                data-placeholder="Selecione uma opção" data-allow-clear="1">
                                                <option value="" <?php echo set_select('recebedor', '', TRUE); ?>></option>
                                                <?php
                                                    $recebedorSelecionado = old('recebedor') ?? $data['recebedor'] ?? '';
                                                    foreach ($data['servidores'] as $servidor) {
                                                        $selected = ($recebedorSelecionado == $servidor->pes_codigo) ? 'selected' : '';
                                                        echo '<option value="'.$servidor->pes_codigo.'" '.$selected.'>'.$servidor->nome.'</option>';
                                                    }
                                                    ?>
                                            </select>
                                            <?php if ($validation->getError('recebedor')): ?>
                                                <div class="invalid-feedback">
                                                    <?= $validation->getError('recebedor') ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <!-- Data da recebimento -->
                                        <div class="col-md-3">
                                            <label for="data_recebimento">Data</label>
                                            <input type="date" name="data_recebimento" id="data_recebimento" class="form-control"
                                                value="<?= set_value('data_recebimento', $data['data_recebimento'] ?? '') ?>">
                                        </div>

                                        <!-- Hora da recebimento -->
                                        <div class="col-md-3">
                                            <label for="hora_recebimento">Hora</label>
                                            <input type="time" name="hora_recebimento" id="hora_recebimento" class="form-control"
                                                value="<?= set_value('hora_recebimento', $data['hora_recebimento'] ?? '') ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!----------->
                        <div class="row g-3">
                            <div class="col-md-12 mb-2">
                                <div class="bordered-container p-3 mb-3">
                                    <div class="row g-2">
                                        <?php foreach (['ABO/RH', 'A', 'B', 'AB', 'D', 'C', 'RA1', 'RB'] as $tipo): ?>
                                            <div class="col-md-1">
                                                <label for="tipo1_<?= $tipo ?>" class="form-label"><?= $tipo ?></label>
                                                <input type="text" id="tipo1_<?= $tipo ?>" class="form-control"
                                                    name="tipo1_[<?= $tipo ?>]"
                                                    value="<?= set_value("tipo1_[$tipo]", $data['tipo1_'][$tipo] ?? '') ?>">
                                            </div>
                                        <?php endforeach; ?>
                                        <div class="col-md-4">
                                            <label for="responsavel_tipo1" class="form-label">Responsável</label>
                                            <select class="form-select select2-dropdown <?php if($validation->getError('responsavel_tipo1')): ?>is-invalid<?php endif ?>"
                                                id="responsavel_tipo1" name="responsavel_tipo1"
                                                data-placeholder="Selecione uma opção" data-allow-clear="1">
                                                <option value="" <?php echo set_select('responsavel_tipo1', '', TRUE); ?>></option>
                                                <?php
                                                    $responsavel_tipo1Selecionado = old('responsavel_tipo1') ?? $data['responsavel_tipo1'] ?? '';
                                                    foreach ($data['servidores'] as $servidor) {
                                                        $selected = ($responsavel_tipo1Selecionado == $servidor->pes_codigo) ? 'selected' : '';
                                                        echo '<option value="'.$servidor->pes_codigo.'" '.$selected.'>'.$servidor->nome.'</option>';
                                                    }
                                                ?>
                                            </select> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                       <div class="bordered-container p-3 mb-2">
                            <div class="row g-2 mb-3">
                               <?php foreach (['PAI I', 'PAI II', 'CD', 'AC'] as $tipo): 
                                    $chaveSanitizada = strtolower(trim(preg_replace('/[^a-zA-Z0-9]+/', '_', $tipo)));
                                    $campo = "tipo2_" . $chaveSanitizada;
                                ?>
                                    <div class="col-md-1">
                                        <label for="<?= $campo ?>" class="form-label"><?= $tipo ?></label>
                                        <input type="text" id="<?= $campo ?>" class="form-control" 
                                            name="tipo2[<?= $tipo ?>]" 
                                            value="<?= set_value("tipo2[$tipo]", $data[$campo] ?? '') ?>">
                                    </div>
                                <?php endforeach; ?>
                                <div class="col-md"></div>
                                    <div class="col-md-4">
                                        <label for="responsavel_tipo2" class="form-label">Responsável</label>
                                        <select class="form-select select2-dropdown <?php if($validation->getError('responsavel_tipo2')): ?>is-invalid<?php endif ?>"
                                            id="responsavel_tipo2" name="responsavel_tipo2"
                                            data-placeholder="Selecione uma opção" data-allow-clear="1">
                                            <option value="" <?php echo set_select('responsavel_tipo2', '', TRUE); ?>></option>
                                            <?php
                                                $responsavel_tipo2Selecionado = old('responsavel_tipo2') ?? $data['responsavel_tipo2'] ?? '';
                                                foreach ($data['servidores'] as $servidor) {
                                                    $selected = ($responsavel_tipo2Selecionado == $servidor->pes_codigo) ? 'selected' : '';
                                                    echo '<option value="'.$servidor->pes_codigo.'" '.$selected.'>'.$servidor->nome.'</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- Fenótipo -->
                            <div class="bordered-container p-3">
                                <label class="form-label fw-bold">Fenótipo</label>
                                <div class="row g-2">
                                    <?php
                                        $fenotipos = [
                                            'C'     => 'fenotipo_c',
                                            'Cw'    => 'fenotipo_cw',
                                            'c'     => 'fenotipo_c',
                                            'E'     => 'fenotipo_e',
                                            'e'     => 'fenotipo_e_min',
                                            'K'     => 'fenotipo_k',
                                        ];

                                        foreach ($fenotipos as $label => $campo):
                                        ?>
                                            <div class="col-md-1">
                                                <label for="<?= $campo ?>" class="form-label"><?= $label ?></label>
                                                <input type="text" id="<?= $campo ?>" class="form-control"
                                                    name="fenotipo[<?= $label ?>]"
                                                    value="<?= set_value("fenotipo[$label]", $data[$campo] ?? '') ?>">
                                            </div>
                                        <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                        <div class="row g-3">
                            <!-- Anticorpos -->
                            <div class="mb-2">
                                <label class="form-label">Painel/Anticorpos Identificados:</label>
                                    <textarea class="form-control" name="anticorpos" rows="2"><?= set_value('anticorpos', $data['anticorpos'] ?? '') ?></textarea>
                            </div>
                        </div>
                        <div class="row g-3">
                            <!-- Expedição de Hemocomponentes -->
                            <div class="mb-1">
                                <label class="form-label">Expedição de Hemocomponentes</label>
                                <div class="table-responsive">
                                    <table class="table table-bordered text-center align-middle" style="min-width: 1180px;">
                                        <thead class="table-light">
                                            <tr>
                                                <th style="width:115px;">Data</th>
                                                <th style="width:65px;">Tipo</th>
                                                <th style="width:70px;">Número</th>
                                                <th style="width:70px;">ABO/Rh</th>
                                                <th style="width:65px;">VOL.</th>
                                                <th style="width:65px;">Origem</th>
                                                <th style="width:80px;">PC</th>
                                                <th style="width:65px;">TH</th>
                                                <th style="width:65px;">IV</th>
                                                <th style="width:90px;">Resp</th>
                                                <th style="width:80px;">Exped</th>
                                                <th style="width:80px;">Início</th>
                                                <th style="width:80px;">Térm</th>
                                                <th style="width:90px;">Resp</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php for ($i = 0; $i < 7; $i++): ?>
                                                <tr>
                                                    <td>
                                                        <input type="date" name="data_expedicao[]" class="form-control form-control-sm"
                                                            value="<?= set_value("data_expedicao[$i]", $data['expedicoes'][$i]['data_expedicao'] ?? '') ?>">
                                                    </td>
                                                    <td>
                                                        <input type="text" name="tipo[]" class="form-control form-control-sm"
                                                            value="<?= set_value("tipo[$i]", $data['expedicoes'][$i]['tipo'] ?? '') ?>">
                                                    </td>
                                                    <td>
                                                        <input type="text" name="numero[]" class="form-control form-control-sm"
                                                            value="<?= set_value("numero[$i]", $data['expedicoes'][$i]['numero'] ?? '') ?>">
                                                    </td>
                                                    <td>
                                                        <input type="text" name="abo_rh_expedicao[]" class="form-control form-control-sm"
                                                            value="<?= set_value("abo_rh_expedicao[$i]", $data['expedicoes'][$i]['abo_rh_expedicao'] ?? '') ?>">
                                                    </td>
                                                    <td>
                                                        <input type="text" name="volume[]" class="form-control form-control-sm"
                                                            value="<?= set_value("volume[$i]", $data['expedicoes'][$i]['volume'] ?? '') ?>">
                                                    </td>
                                                    <td>
                                                        <input type="text" name="origem[]" class="form-control form-control-sm"
                                                            value="<?= set_value("origem[$i]", $data['expedicoes'][$i]['origem'] ?? '') ?>">
                                                    </td>
                                                    <td>
                                                        <div class="d-flex justify-content-center align-items-center" style="gap: 0.1rem;">
                                                            <div class="form-check">
                                                                <input type="radio" name="pc_<?= $i ?>" id="pc_c_<?= $i ?>" value="C" class="form-check-input"
                                                                    <?= set_radio("pc_$i", 'C', ($data['expedicoes'][$i]['pc'] ?? '') === 'C') ?>>
                                                                <label for="pc_c_<?= $i ?>" class="form-check-label">C</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input type="radio" name="pc_<?= $i ?>" id="pc_i_<?= $i ?>" value="I" class="form-check-input"
                                                                    <?= set_radio("pc_$i", 'I', ($data['expedicoes'][$i]['pc'] ?? '') === 'I') ?>>
                                                                <label for="pc_i_<?= $i ?>" class="form-check-label">I</label>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="th_<?= $i ?>" class="form-control form-control-sm"
                                                            value="<?= set_value("th_$i", $data['expedicoes'][$i]['th'] ?? '') ?>">
                                                    </td>
                                                    <td>
                                                        <input type="text" name="iv_<?= $i ?>" class="form-control form-control-sm"
                                                            value="<?= set_value("iv_$i", $data['expedicoes'][$i]['iv'] ?? '') ?>">
                                                    </td>
                                                    <td>
                                                        <input type="text" name="responsavel_expedicao[]" class="form-control form-control-sm"
                                                            value="<?= set_value("responsavel_expedicao[$i]", $data['expedicoes'][$i]['responsavel_expedicao'] ?? '') ?>">
                                                    </td>
                                                    <td>
                                                        <input type="time" name="hora_expedicao[]" class="form-control form-control-sm"
                                                            value="<?= set_value("hora_expedicao[$i]", $data['expedicoes'][$i]['hora_expedicao'] ?? '') ?>">
                                                    </td>
                                                    <td>
                                                        <input type="time" name="hora_inicio[]" class="form-control form-control-sm"
                                                            value="<?= set_value("hora_inicio[$i]", $data['expedicoes'][$i]['hora_inicio'] ?? '') ?>">
                                                    </td>
                                                    <td>
                                                        <input type="time" name="hora_termino[]" class="form-control form-control-sm"
                                                            value="<?= set_value("hora_termino[$i]", $data['expedicoes'][$i]['hora_termino'] ?? '') ?>">
                                                    </td>
                                                    <td>
                                                        <input type="text" name="responsavel_administracao[]" class="form-control form-control-sm"
                                                            value="<?= set_value("responsavel_administracao[$i]", $data['expedicoes'][$i]['responsavel_administracao'] ?? '') ?>">
                                                    </td>
                                                </tr>
                                            <?php endfor; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row g-3">
                            <!-- Observações -->
                            <div class="mb-3 mt-1">
                                <label class="form-label">Observações:</label>
                               <textarea class="form-control" name="observacoes_hemoterapia" rows="3"><?= set_value('observacoes_hemoterapia', $data['observacoes_hemoterapia'] ?? '') ?></textarea>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="small text-muted">
                                <strong>LEGENDAS:</strong> ORIGEM 1 = HUAP, 2 = IEHE ou SIGLA correspondente / PC = prova cruzada, C = compatível, I = Incompatível / TH = Teste de Hemólise / IV = Inspeção visual
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-12 d-flex gap-2 mt-4">
                                <button id="btnAcao" class="btn btn-primary mt-4">
                                    <i class="fa-solid fa-floppy-disk"></i> Salvar
                                </button>
                                <a class="btn btn-warning mt-4" href="<?= base_url('transfusao/exibir') ?>">
                                    <i class="fa-solid fa-arrow-left"></i> Voltar
                                </a>
                            </div>
                        </div>

                        <input type="hidden" name="idreq" id="idreq" value="<?= $data['idreq'] ?>"/>

                    </form>
                </div>


