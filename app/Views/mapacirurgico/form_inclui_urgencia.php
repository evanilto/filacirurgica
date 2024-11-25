<?= csrf_field() ?>
<?php $validation = \Config\Services::validation(); ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<style>
.content {
    max-height: calc(100vh - 100px); /* Altura total da tela menos o cabeçalho e rodapé */
    overflow-y: auto; /* Rolagem apenas vertical */
    overflow-x: hidden; /* Impede a rolagem horizontal */
    height: 100%; /* Garante que use todo o espaço vertical permitido */
    box-sizing: border-box; /* Inclui padding no cálculo da largura */
}
</style>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card form-container">
                <div class="card-header text-center text-black">
                    <b><?= 'Incluir Cirurgia Urgente' ?></b>
                </div>
                <div class="card-body has-validation">
                    <form id="idForm" method="post" action="<?= base_url('mapacirurgico/incluir') ?>">
                        <div class="row g-3">
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label for="dtcirurgia" class="form-label">Data da Cirurgia</label>
                                    <div class="input-group">
                                        <input type="text" id="dtcirurgia" placeholder="DD/MM/AAAA HH:MM" readonly
                                            class="form-control <?php if($validation->getError('dtcirurgia')): ?>is-invalid<?php endif ?>"
                                            name="dtcirurgia" value="<?= set_value('dtcirurgia', $data['dtcirurgia']) ?>"/>
                                        <?php if ($validation->getError('dtcirurgia')): ?>
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('dtcirurgia') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
                                <label for="prontuario" class="form-label">Prontuario AGHU<b class="text-danger">*</b></label>
                                    <div class="input-group">
                                    <input type="text" id="prontuario" maxlength="8"
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
                            <div class="col-md-8">
                                <div class="mb-3">
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
                        </div>
                        <div class="row g-3">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="listapaciente" class="form-label">Lista de Espera do Paciente<b class="text-danger">*</b></label>
                                    <select class="form-select select2-dropdown <?php if($validation->getError('listapaciente')): ?>is-invalid<?php endif ?>" 
                                    id="listapaciente" name="listapaciente">
                                        <option value="">Selecione uma opção</option>
                                        <!-- As opções serão preenchidas dinamicamente -->
                                    </select>
                                    <?php if ($validation->getError('listapaciente')): ?>
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('listapaciente') ?>
                                            </div>
                                        <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="especialidade" class="form-label">Especialidade<b class="text-danger">*</b></label>
                                    <div class="input-group">
                                        <select class="form-select select2-dropdown <?php if($validation->getError('especialidade')): ?>is-invalid<?php endif ?>"
                                            id="especialidade" name="especialidade"
                                            data-placeholder="Selecione uma opção" data-allow-clear="1">
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
                                <div class="mb-3">
                                    <label for="fila" class="form-label">Fila Cirúrgica<b class="text-danger">*</b></label>
                                    <div class="input-group">
                                        <select class="form-select select2-dropdown <?php if($validation->getError('fila')): ?>is-invalid<?php endif ?>"
                                            id="fila" name="fila"
                                            data-placeholder="Selecione uma opção" data-allow-clear="1">
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
                                <div class="mb-3">
                                    <label for="procedimento" class="form-label">Procedimento Principal<b class="text-danger">*</b></label>
                                    <div class="input-group">
                                        <select class="form-select select2-dropdown <?php if($validation->getError('procedimento')): ?>is-invalid<?php endif ?>"
                                            id="procedimento" name="procedimento"
                                            data-placeholder="Selecione uma opção" data-allow-clear="1">
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
                                <div class="mb-3">
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
                                <div class="mb-3">
                                    <label for="cid" class="form-label">CID</label>
                                    <div class="input-group">
                                        <select class="form-select select2-dropdown <?php if($validation->getError('cid')): ?>is-invalid<?php endif ?>"
                                            id="cid" name="cid"
                                            data-placeholder="" data-allow-clear="1">
                                            <option value="" <?php echo set_select('cid', '', TRUE); ?> ></option>
                                            <?php
                                            foreach ($data['cids'] as $key => $cid) {
                                                $selected = ($data['cid'] == $cid->seq) ? 'selected' : '';
                                                echo '<option value="'.$cid->seq.'" '.$selected.'>'.$cid->descricao.'</option>';
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
                                <div class="mb-3">
                                    <label for="risco" class="form-label">Risco Cirúrgico</label>
                                    <div class="input-group">
                                        <select class="form-select select2-dropdown<?php if($validation->getError('risco')): ?>is-invalid<?php endif ?>"
                                            id="risco" name="risco" onchange="verificarPerfil()"
                                            data-placeholder="" data-allow-clear="1">
                                            <option value="" <?php echo set_select('risco', '', TRUE); ?> ></option>
                                            <?php
                                            foreach ($data['riscos'] as $key => $risco) {
                                                $selected = ($data['risco'] == $risco['id']) ? 'selected' : '';
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
                            <div class="col-md-1">
                                <div class="mb-3">
                                    <label for="dtrisco" class="form-label">Data Risco</label>
                                    <div class="input-group">
                                        <input type="text" id="dtrisco" maxlength="10" placeholder="DD/MM/AAAA"
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
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="origem" class="form-label">Origem Paciente<b class="text-danger">*</b></label>
                                    <div class="input-group">
                                        <select class="form-select select2-dropdown <?php if($validation->getError('origem')): ?>is-invalid<?php endif ?>"
                                            id="origem" name="origem" 
                                            data-placeholder="Selecione uma opção" data-allow-clear="1">
                                            <option value="" <?php echo set_select('origem', '', TRUE); ?> ></option>
                                            <?php
                                            foreach ($data['origens'] as $key => $origem) {
                                                $selected = ($data['origem'] == $origem['id']) ? 'selected' : '';
                                                echo '<option value="'.$origem['id'].'" '.$selected.'>'.$origem['nmorigem'].'</option>';
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
                        </div>
                        <div class="row g-3">
                            <div class="col-md-2">
                                <div class="mb-4">
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
                                <div class="mb-4">
                                    <label for="lateralidade" class="form-label">Lateralidade<b class="text-danger">*</b></label>
                                    <div class="input-group">
                                        <select class="form-select select2-dropdown <?php if($validation->getError('lateralidade')): ?>is-invalid<?php endif ?>"
                                            id="lateralidade" name="lateralidade"
                                            data-placeholder="Selecione uma opção" data-allow-clear="1">
                                            <option value="" <?php echo set_select('lateralidade', '', TRUE); ?> ></option>
                                            <?php
                                            foreach ($data['lateralidades'] as $key => $lateralidade) {
                                                $selected = ($data['lateralidade'] == $lateralidade['id']) ? 'selected' : '';
                                                echo '<option value="'.$lateralidade['id'].'" '.$selected.'>'.$lateralidade['descricao'].'</option>';
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
                            <div class="col-md-2">
                                <div class="mb-4">
                                    <label class="form-label">Congelação<b class="text-danger">*</b></label>
                                    <div class="input-group mb-3 bordered-container">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="congelacao" id="congelacaoN" value="NÃO" checked
                                                <?= (isset($data['congelacao']) && $data['congelacao'] == 'NÃO') ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="congelacaoN" style="margin-right: 10px;">&nbsp;Não</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="congelacao" id="congelacaoS" value="SIM"
                                                <?= (isset($data['congelacao']) && $data['congelacao'] == 'SIM') ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="congelacaoS" style="margin-right: 10px;">&nbsp;Sim</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-4">
                                    <label class="form-label">Hemoderivados<b class="text-danger">*</b></label>
                                    <div class="input-group mb-3 bordered-container">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="hemoderivados" id="hemoderivadosN" value="N"
                                                <?= (isset($data['hemoderivados']) && $data['hemoderivados'] == 'N') ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="hemoderivadosN" style="margin-right: 10px;">&nbsp;Não</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="hemoderivados" id="hemoderivadosS" value="S" checked
                                                <?= (isset($data['hemoderivados']) && $data['hemoderivados'] == 'S') ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="hemoderivadosS" style="margin-right: 10px;">&nbsp;Sim</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-4">
                                    <label class="form-label">Complexidade<b class="text-danger">*</b></label>
                                    <div class="input-group mb-3 bordered-container">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="complexidade" id="complexidadeA" value="A" checked
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
                                </div>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="container bordered-container mb-3">
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
                                            <label for="profissional" class="form-label">Profissionais Auxiliares<b class="text-danger">*</b></label>
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
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="justorig">Justificativa p/ Origem Paciente</label>
                                    <textarea id="justorig" maxlength="255" rows="3"
                                            class="form-control <?= isset($validation) && $validation->getError('justorig') ? 'is-invalid' : '' ?>"
                                            name="justorig"><?= isset($data['justorig']) ? $data['justorig'] : '' ?></textarea>
                                    <?php if (isset($validation) && $validation->getError('justorig')): ?>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('justorig') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="info">Informações adicionais</label>
                                    <textarea id="info" maxlength="255" rows="3"
                                            class="form-control <?= isset($validation) && $validation->getError('info') ? 'is-invalid' : '' ?>"
                                            name="info"><?= isset($data['info']) ? $data['info'] : '' ?></textarea>
                                    <?php if (isset($validation) && $validation->getError('info')): ?>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('info') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label class="form-label" for="info">Necessidades do Procedimento<b class="text-danger">*</b></label>
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
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label class="form-label" for="info">Justificativas da Urgência<b class="text-danger">*</b></label>
                                    <textarea id="justurgencia" maxlength="255" rows="3"
                                            class="form-control <?= isset($validation) && $validation->getError('justurgencia') ? 'is-invalid' : '' ?>"
                                            name="justurgencia"><?= isset($data['justurgencia']) ? $data['justurgencia'] : '' ?></textarea>
                                    <?php if (isset($validation) && $validation->getError('justurgencia')): ?>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('justurgencia') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-12">
                                <button class="btn btn-primary mt-3" id="submit" name="submit" type="submit" value="1">
                                    <i class="fa-solid fa-floppy-disk"></i> Incluir
                                </button>
                                <a class="btn btn-warning mt-3" href="javascript:history.go(-1)">
                                    <i class="fa-solid fa-arrow-left"></i> Voltar
                                </a>
                            </div>
                        </div>

                      <!--   <input type="hidden" name="idlista" value="<--?= $data['id'] ?>" />
                        <input type="hidden" id="hiddenDataIdField" name="hiddenDataIdField" value=""> -->
                        <input type="hidden" name="proced_adic_hidden" id="proced_adic_hidden" />
                        <input type="hidden" name="ordem" id="ordem" value="<?= $data['ordem'] ?>" />
                        <input type="hidden" name="profissional_hidden" id="profissional_adic_hidden" />
                        <input type="hidden" id="listapacienteSelect" name="listapacienteSelect">
                        <input type="hidden" name="especialidade_hidden" id="especialidade_hidden" />
                        <input type="hidden" name="fila_hidden" id="fila_hidden" />
                        <input type="hidden" name="procedimento_hidden" id="procedimento_hidden" />
                        <input type="hidden" name="infoadic_hidden" id="infoadic_hidden" />
                        <input type="hidden" name="justorigem_hidden" id="justorig_hidden" />
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    window.onload = function() {
        const inputs = document.querySelectorAll('input, textarea, select, .form-check-input');
        inputs.forEach(input => {
            input.addEventListener('keydown', disableEnter);
        });
    };

    function fetchPacienteNome(prontuarioValue, ordemValue) {
        //alert(ordemValue);
      if (prontuarioValue) {
       //alert(prontuarioValue);

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
            loadAsideContent(prontuarioValue, ordemValue);
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
    
    function loadAsideContent(recordId, ordemFila) {
        var baseUrl = '<?= base_url('listaespera/carregaaside/') ?>';
        var endUrl = ordemFila ? baseUrl + recordId + '/' + ordemFila : baseUrl + recordId;
        
        $.ajax({
            url: endUrl,
            method: 'GET',
            beforeSend: function() {
                $('#sidebar').html('<p>Carregando...</p>'); 
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

    function updatelistapaciente(prontuario) {

        const listapacienteSelect = document.getElementById('listapaciente');

        listapacienteSelect.innerHTML = '<option value="">Selecione uma opção</option>'; 

        if (prontuario) {

            $('#janelaAguarde').show();

            $.ajax({
                url: '<?= base_url('listaespera/getlista') ?>',
                type: 'POST',
                data: {prontuario: prontuario},
                dataType: 'json',
                success: function(data) {
                    //listapacienteSelect.innerHTML = '<option value="">Selecione uma opção</option>'; // Adiciona o placeholder
                    const option = document.createElement("option"); // Usando createElement para criar uma nova opção
                    option.value = 0; // ID que será usado como valor da opção
                    option.text = `Inluir uma novo item (cirurgia) na lista`;
                    listapacienteSelect.add(option); // Adiciona a nova opção ao select

                    // Preencher o select com os dados recebidos
                    data.forEach(item => {
                        const option = document.createElement("option");
                        option.value = item.id; // ID que será usado como valor da opção
                        option.text = `Espec: ${item.especialidade_descricao} - Fila: ${item.fila} - Proced: ${item.procedimento_descricao}`;
                        
                        // Adicionando atributos data para os IDs
                        //option.setAttribute('data-id', item.id);
                        option.setAttribute('data-especialidade-id', item.idespecialidade);
                        option.setAttribute('data-fila-id', item.idtipoprocedimento);
                        option.setAttribute('data-procedimento-id', item.idprocedimento);
                        option.setAttribute('data-origempaciente-id', item.idorigempaciente);
                        option.setAttribute('data-justorig', item.just_orig);
                        option.setAttribute('data-info', item.info_adicionais);

                        listapacienteSelect.add(option); // Adiciona a nova opção ao select
                    });

                    $('#janelaAguarde').hide();

                },
                error: function(xhr, status, error) {
                    console.error('Erro ao buscar lista de espera:', error);
                }
            });

        } else {
            // Se o prontuário estiver vazio, limpe o select ou mantenha o estado atual
            listapacienteSelect.innerHTML = '<option value="">Selecione uma opção</option>';
        }

    }

    function preencherSelectListaPaciente(dadosServidor) {
        const lista = document.getElementById('listapaciente');

        // Limpar o select antes de adicionar novas opções
        lista.innerHTML = '<option value="">Selecione uma opção</option>'; // Adiciona o placeholder

        alert(dadosServidor);
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
        const ordemInput = document.getElementById('ordem');

        //const listapacienteSelect = <?php echo json_encode(!empty($data['listapacienteSelect']) ? $data['listapacienteSelect'] : ''); ?>;
        //preencherSelectListaPaciente(listapacienteSelect);

        fetchPacienteNome(prontuarioInput.value, ordemInput.value);
        //updatelistapaciente(prontuarioInput.value);
    }

    fetchPacienteNomeOnLoad();

    document.addEventListener('DOMContentLoaded', function() {
        const prontuarioInput = document.getElementById('prontuario');
        const prontuario = prontuarioInput.value;

        if (prontuario) {
            updatelistapaciente(prontuario);
        }
    });

    // Função para atualizar o select da lista de espera

    $(document).ready(function() {
        $('.select2-dropdown').select2({
            placeholder: "",
            allowClear: true,
            width: 'resolve' // Corrigir a largura
        });

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

        // Inicializa o valor do campo hidden, caso existam valores pré-selecionados
        $('#proced_adic_hidden').val($('#proced_adic').val());
        
        // Procedimentos Adicionais  ----------------------------------------------------------------------------

       /*  $('#idForm').submit(function() {
            $('#janelaAguarde').show();
            setTimeout(function() {
                window.location.href = href;
            }, 1000);
        }); */
        
        const prontuarioInput = document.getElementById('prontuario');
        const ordemInput = document.getElementById('ordem');

        prontuarioInput.addEventListener('change', function() {
            //alert(prontuarioInput.value);
            fetchPacienteNome(prontuarioInput.value, ordemInput.value);
            updatelistapaciente(prontuarioInput.value);
        });

        $('#listapaciente').on('change', function() {
            const selectedValue = this.value;

            if (selectedValue !== "0" && selectedValue) { // Verifica se o valor selecionado não é zero
                // Encontrar a opção correspondente que foi selecionada
                const selectedOption = this.options[this.selectedIndex];

                // Obter os IDs armazenados nos atributos data
                const especialidadeId = selectedOption.getAttribute('data-especialidade-id');
                const filaId = selectedOption.getAttribute('data-fila-id');
                const procedimentoId = selectedOption.getAttribute('data-procedimento-id');
                const origempacienteId = selectedOption.getAttribute('data-origempaciente-id');
                const justorig = selectedOption.getAttribute('data-justorig');
                const info = selectedOption.getAttribute('data-info');

                //const dataId = selectedOption.getAttribute('data-id'); // Captura o data-id
                //alert("ID do item selecionado:", dataId);
                //document.getElementById('hiddenDataIdField').value = dataId; // Supondo que você tenha um input escondido para armazená-lo

                // Preencher os campos do formulário com os IDs
                $('#especialidade').val(especialidadeId).trigger('change'); // Define o valor do select de especialidade e atualiza
                $('#fila').val(filaId).trigger('change'); // Define o valor do select de fila e atualiza
                $('#procedimento').val(procedimentoId).trigger('change'); // Define o valor do select de procedimento e atualiza
                $('#origem').val(origempacienteId).trigger('change'); // Define o valor do select de procedimento e atualiza
                $('#justorig').val(justorig);
                $('#info').val(info);

                $('#especialidade_hidden').val(especialidadeId);
                $('#fila_hidden').val(filaId);
                $('#procedimento_hidden').val(procedimentoId);
                $('#infoadic_hidden').val(info);
                $('#justorig_hidden').val(justorig);

                // Desabilitar os campos após preencher
                $('#especialidade').prop('disabled', true);
                $('#fila').prop('disabled', true);
                $('#procedimento').prop('disabled', true);
                //$('#origem').prop('disabled', true);
                $('#justorig').prop('disabled', true);
                $('#info').prop('disabled', true);
            } else {
                // Limpar os campos se a opção selecionada não for válida
                $('#especialidade').val('').trigger('change');
                $('#fila').val('').trigger('change');
                $('#procedimento').val('').trigger('change');

                // Habilitar os campos para nova seleção
                $('#especialidade').prop('disabled', false);
                $('#fila').prop('disabled', false);
                $('#procedimento').prop('disabled', false);
                $('#origem').prop('disabled', false);
                $('#justorig').prop('disabled', false);
                $('#info').prop('disabled', false);
            }
        });

        document.getElementById('idForm').addEventListener('submit', function(event) {
            $('#janelaAguarde').show();

            // Prevenir o envio padrão para preparar os dados
            //event.preventDefault(); // Apenas para depuração; remova isso em produção para envio normal

            // Capturar os valores do select
            const listaEsperaSelect = document.getElementById('listapaciente');
            const valoresTextos = Array.from(listaEsperaSelect.options)
                .filter(option => option.value)  // Ignora opções sem valor
                .map(option => {
                    // Retorna uma string para cada opção no formato: valor:texto
                    return `${option.value}:${option.text}`;
                });

            // Atribuir valores ao campo oculto
            document.getElementById('listapacienteSelect').value = JSON.stringify(valoresTextos);

            // Opcionalmente envie o formulário agora
            // event.currentTarget.submit(); // Descomente para executar envio padrão após processamento
        });

    });
</script>
