<?= csrf_field() ?>
<?php $validation = \Config\Services::validation(); ?>

<div class="container" style="padding-top: 0; margin-top: -30px">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card form-container">
                <div class="card-header text-center text-black">
                    <b><?= 'Informações da Cirurgia' ?></b>
                </div>
                <div class="card-body has-validation">
                    <form id="idForm" method="post" action="<?= base_url('mapacirurgico/atualizar') ?>">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="dtcirurgia" class="form-label">Data/Hora da Cirurgia</label>
                                    <div class="input-group">
                                        <input type="text" id="dtcirurgia" placeholder="DD/MM/AAAA HH:MM:SS" disabled
                                            class="form-control <?php if($validation->getError('dtcirurgia')): ?>is-invalid<?php endif ?>"
                                            name="dtcirurgia" value="<?= set_value('dtcirurgia', $data['dtcirurgia']) ?>" />
                                        <?php if ($validation->getError('dtcirurgia')): ?>
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('dtcirurgia') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="prontuario" class="form-label">Prontuario</label>
                                    <div class="input-group">
                                        <input type="text" id="prontuario" maxlength="8" disabled
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
                            <div class="col-md-6">
                                <div class="mb-3">
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
                            <div class="col-md-3">
                                <div class="mb-3">
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
                            <div class="col-md-4">
                                <div class="mb-3">
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
                            <div class="col-md-5">
                                <div class="mb-3">
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
                        </div>
                        <div class="row g-3">
                            <div class="col-md-5">
                                <div class="mb-3">
                                    <label for="proced_adic" class="form-label">Procedimentos Adicionais</label>
                                    <div class="input-group">
                                        <select class="form-select select2-dropdown <?= $validation->hasError('proced_adic') ? 'is-invalid' : '' ?>"
                                                id="proced_adic" name="proced_adic[]" multiple="multiple" disabled
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
                            <div class="col-md-7">
                                <div class="mb-3">
                                    <label for="cid" class="form-label">CID</label>
                                    <div class="input-group">
                                        <select class="form-select select2-dropdown <?php if($validation->getError('cid')): ?>is-invalid<?php endif ?>"
                                            id="cid" name="cid"
                                            data-placeholder="" data-allow-clear="1" disabled> 
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
                        </div>
                        <div class="row g-3">
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="risco" class="form-label">Risco Cirúrgico</label>
                                    <div class="input-group">
                                        <select class="form-select select2-dropdown<?php if($validation->getError('risco')): ?>is-invalid<?php endif ?>"
                                            id="risco" name="risco" onchange="verificarPerfil()" disabled
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
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label for="dtrisco" class="form-label">Data Risco</label>
                                    <div class="input-group">
                                        <input type="text" id="dtrisco" maxlength="10" placeholder="DD/MM/AAAA" disabled
                                            class="form-control Data <?php if($validation->getError('dtrisco')): ?>is-invalid<?php endif ?>"
                                            name="dtrisco" value="<?= set_value('dtrisco'), $data['dtrisco'] ?>"/>
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
                                    <label for="origem" class="form-label">Origem Paciente</label>
                                    <div class="input-group">
                                        <select class="form-select select2-dropdown <?php if($validation->getError('origem')): ?>is-invalid<?php endif ?>"
                                            id="origem" name="origem"
                                            data-placeholder="Selecione uma opção" data-allow-clear="1" disabled>
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
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Complexidade</label>
                                    <div class="input-group mb-3 bordered-container">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="complexidade" id="complexidadeA" value="A" disabled
                                                <?= (isset($data['complexidade']) && $data['complexidade'] == 'A') ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="complexidadeA" style="margin-right: 10px;">&nbsp;Alta</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="complexidade" id="complexidadeM" value="M" disabled
                                                <?= (isset($data['complexidade']) && $data['complexidade'] == 'M') ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="complexidadeM" style="margin-right: 10px;">&nbsp;Média</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="complexidade" id="complexidadeB" value="B" disabled
                                                <?= (isset($data['complexidade']) && $data['complexidade'] == 'B') ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="complexidadeB" style="margin-right: 10px;">&nbsp;Baixa</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="posoperatorio" class="form-label">Pós-Operatório</label>
                                    <div class="input-group">
                                        <select class="form-select select2-dropdown <?php if($validation->getError('posoperatorio')): ?>is-invalid<?php endif ?>" disabled
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
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="lateralidade" class="form-label">Lateralidade</label>
                                    <div class="input-group">
                                        <select class="form-select select2-dropdown <?php if($validation->getError('lateralidade')): ?>is-invalid<?php endif ?>" disabled
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
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label">Congelação</label>
                                    <div class="input-group mb-3 bordered-container">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="congelacao" id="congelacaoN" value="N" disabled
                                                <?= (isset($data['congelacao']) && $data['congelacao'] == 'N') ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="congelacaoN" style="margin-right: 10px;">&nbsp;Não</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="congelacao" id="congelacaoS" value="S" disabled
                                                <?= (isset($data['congelacao']) && $data['congelacao'] == 'S') ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="congelacaoS" style="margin-right: 10px;">&nbsp;Sim</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label">Hemoderivados</label>
                                    <div class="input-group mb-3 bordered-container">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="hemoderivados" id="hemoderivadosN" value="N" disabled
                                                <?= (isset($data['hemoderivados']) && $data['hemoderivados'] == 'N') ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="hemoderivadosN" style="margin-right: 10px;">&nbsp;Não</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="hemoderivados" id="hemoderivadosS" value="S" disabled
                                                <?= (isset($data['hemoderivados']) && $data['hemoderivados'] == 'S') ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="hemoderivadosS" style="margin-right: 10px;">&nbsp;Sim</label>
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
                                            <select class="form-select select2-dropdown" id="filtro_especialidades" name="filtro_especialidades" disabled> 
                                                <option value="">Todas</option> 
                                                <?php foreach ($data['especialidades_med'] as $filtro): ?>
                                                    <option value="<?= $filtro->seq ?>"><?= $filtro->nome_especialidade ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="profissional" class="form-label">Profissionais Auxiliares</label>
                                            <select class="form-select select2-dropdown <?= $validation->hasError('profissional') ? 'is-invalid' : '' ?>" disabled
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
                            <div class="container bordered-container mb-3">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="centrocirurgico" class="form-label">Centro Cirúrgico</label>
                                            <select class="form-select select2-dropdown  <?= $validation->hasError('centrocirurgico') ? 'is-invalid' : '' ?>" disabled
                                                 id="centrocirurgico" name="centrocirurgico">
                                                <option value="" <?php echo set_select('centrocirurgico', '', TRUE); ?> ></option>
                                                <?php 
                                                    foreach ($data['centros_cirurgicos'] as $filtro):
                                                        $selected = ($data['centrocirurgico'] == $filtro->seq) ? 'selected' : '';
                                                        echo '<option value="'.$filtro->seq.'" '.$selected.'>'.$filtro->descricao.'</option>';
                                                    endforeach 
                                                 ?>
                                            </select>
                                            <?php if ($validation->hasError('centrocirurgico')): ?>
                                                <div class="invalid-feedback">
                                                    <?= $validation->getError('centrocirurgico') ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                        <label for="sala" class="form-label">Salas</label>
                                            <select class="form-select select2-dropdown <?= $validation->hasError('sala') ? 'is-invalid' : '' ?>" disabled
                                                    id="sala" name="sala" data-placeholder="" data-allow-clear="1">
                                                <!-- As salas irão aparecer aqui dinamicamente -->
                                            </select>
                                            <?php if ($validation->hasError('sala')): ?>
                                                <div class="invalid-feedback">
                                                    <?= $validation->getError('sala') ?>
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
                                    <label class="form-label" for="info">Informações adicionais</label>
                                    <textarea id="info" maxlength="255" rows="2" disabled
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
                                <div class="mb-3">
                                    <label class="form-label" for="nec_proced">Necessidades do Procedimento</label>
                                    <textarea id="nec_proced" maxlength="255" rows="2" disabled
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
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="justenvio">Justificativas Envio ao Mapa</label>
                                    <textarea id="justenvio" maxlength="255" rows="2" disabled
                                            class="form-control <?= isset($validation) && $validation->getError('justenvio') ? 'is-invalid' : '' ?>"
                                            name="justenvio"><?= isset($data['justenvio']) ? $data['justenvio'] : '' ?></textarea>
                                    <?php if (isset($validation) && $validation->getError('justenvio')): ?>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('justenvio') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php if ($data['indurgencia'] == 'S') { ?>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="justurgencia">Justificativas da Urgência</label>
                                        <textarea id="justurgencia" maxlength="255" rows="2" disabled
                                                class="form-control <?= isset($validation) && $validation->getError('justurgencia') ? 'is-invalid' : '' ?>"
                                                name="justurgencia"><?= isset($data['justurgencia']) ? $data['justurgencia'] : '' ?></textarea>
                                        <?php if (isset($validation) && $validation->getError('justurgencia')): ?>
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('justurgencia') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <?php if ($data['status_fila'] == 'Suspensa') { ?>
                            <div class="row g-3">
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label for="dtsuspensao" class="form-label">Data/Hora Suspensão</label>
                                        <div class="input-group">
                                            <input type="text" id="dtsuspensao" placeholder="DD/MM/AAAA HH:MM:SS" disabled
                                                class="form-control<?php if($validation->getError('dtsuspensao')): ?>is-invalid<?php endif ?>"
                                                name="dtsuspensao" value="<?= set_value('dtsuspensao', $data['dtsuspensao']) ?>" disabled/>
                                            <?php if ($validation->getError('dtsuspensao')): ?>
                                                <div class="invalid-feedback">
                                                    <?= $validation->getError('dtsuspensao') ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="idsuspensao" class="form-label">Justificativa para suspensão</label>
                                        <div class="input-group">
                                            <select class="form-select select2-dropdown <?php if($validation->getError('idsuspensao')): ?>is-invalid<?php endif ?>"
                                                id="idsuspensao" name="idsuspensao" disabled
                                                data-placeholder="Selecione uma opção" data-allow-clear="1">
                                                <option value="" <?php echo set_select('idsuspensao', '', TRUE); ?> ></option>
                                                <?php
                                                foreach ($data['justificativassuspensao'] as $key => $idsuspensao) {
                                                    $selected = ($data['idsuspensao'] == $idsuspensao['id']) ? 'selected' : '';
                                                    echo '<option value="'.$idsuspensao['id'].'" '.$selected.'>'.$idsuspensao['descricao'].'</option>';
                                                }
                                                ?>
                                            </select>
                                            <?php if ($validation->getError('idsuspensao')): ?>
                                                <div class="invalid-feedback">
                                                    <?= $validation->getError('idsuspensao') ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="justsuspensao">Observações sobre a suspenssão</label>
                                        <textarea id="justsuspensao" maxlength="255" rows="3" disabled
                                                class="form-control <?= isset($validation) && $validation->getError('justsuspensao') ? 'is-invalid' : '' ?>"
                                                name="justsuspensao"><?= isset($data['justsuspensao']) ? $data['justsuspensao'] : '' ?></textarea>
                                        <?php if (isset($validation) && $validation->getError('justsuspensao')): ?>
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('justsuspensao') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="row g-3">
                            <div class="col-md-12">
                            <a class="btn btn-warning mt-3" href="<?= base_url('mapacirurgico/exibir') ?>">
                                <i class="fa-solid fa-arrow-left"></i> Voltar
                            </a>
                            </div>
                        </div>

                        <input type="hidden" name="idmapa" value="<?= $data['idmapa'] ?>" />
                        <input type="hidden" name="idlistaespera" value="<?= $data['idlistaespera'] ?>" />
                        <input type="hidden" name="ordemfila" id='ordemfila' value="<?= $data['ordemfila'] ?>" />
                        <input type="hidden" name="prontuario" value="<?= $data['prontuario'] ?>" />
                        <input type="hidden" name="especialidade" value="<?= $data['especialidade'] ?>" />
                        <input type="hidden" name="fila" id="fila-hidden" value="<?= $data['fila'] ?>" />
                        <input type="hidden" name="procedimento" value="<?= $data['procedimento'] ?>" />
                        <input type="hidden" name="origem" value="<?= $data['origem'] ?>" />
                        <input type="hidden" name="proced_adic_hidden" id="proced_adic_hidden" />
                        <input type="hidden" name="profissional_hidden" id="profissional_adic_hidden" />
                        <input type="hidden" name="sala_hidden" id="sala_adic_hidden" />
                        <input type="hidden" name="enable_fila" value="<?= $data['enable_fila'] ?>" />

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
     function fetchPacienteNome(prontuarioValue) {
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
            const ordemValue = document.getElementById('ordemfila').value;
            var selectElement = document.getElementById('fila');
            var filaText = selectElement.options[selectElement.selectedIndex].text;
            
            loadAsideContent(prontuarioValue, ordemValue, filaText);
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
            placeholder: "",
            allowClear: true,
            width: 'resolve' // Corrigir a largura
        });

        //------------------------ Filtro de salas cirurgicas baseado no filtro selecionado ----------------
        
        function updateSalasCirurgicas(selectedFilter) {
            // Mantenha as opções selecionadas
            var selectedValues = $('#sala').val() || [];

            // Esvaziar o select
            $("#sala").empty();

            // Adicione as opções que já estão selecionadas primeiro para garantir que sejam visíveis
            var addedOptions = [];
            
            <?php foreach ($data['salas_cirurgicas'] as $sala): ?>
                var value = '<?= $sala->seqp ?>';
                var text = '<?= $sala->nome  ?>';
                var centrocirurgico = '<?= $sala->unf_seq ?>';
                
                /* // Se a sala já está selecionada, adicione-a ao dropdown
                if (selectedValues.includes(value) && !addedOptions.includes(value)) {
                    var option = new Option(text, value, true, true);
                    $("#sala").append(option);
                    addedOptions.push(value);
                } */
            <?php endforeach; ?>

            // Adicione as opções que correspondem ao filtro (mas não estão selecionadas)
            <?php foreach ($data['salas_cirurgicas'] as $sala): ?>
                var value = '<?= $sala->seqp ?>';
                var text = '<?= $sala->nome ?>';
                var centrocirurgico = '<?= $sala->unf_seq ?>';
                
                // Filtra as salas que pertencem ao centro cirúrgico selecionado
                if ((!selectedValues.includes(value)) && (!addedOptions.includes(value)) && (!selectedFilter || selectedFilter === centrocirurgico)) {
                    var option = new Option(text, value, false, false);
                    $("#sala").append(option);
                    addedOptions.push(value);
                }
            <?php endforeach; ?>

            // Atualize a seleção do Select2 para as opções visíveis
            $('#sala').val(selectedValues).trigger('change');
        }

        // Atualiza a lista de salas baseado no filtro selecionado
        $('#centrocirurgico').change(function() {
            var selectedFilter = $(this).val();
            updateSalasCirurgicas(selectedFilter);
        });

        // Inicializa as salas adicionais já selecionadas
        updateSalasCirurgicas($('#centrocirurgico').val());
        //$('#sala').val('<--?= $data['sala'] ?>').trigger('change'); // Adiciona esta linha para garantir que o valor inicial é definido
        <?php if (isset($data['sala']) && $data['sala'] !== ''): ?>
            $('#sala').val('<?= $data['sala'] ?>').trigger('change');
        <?php endif; ?>


        $('#sala').on('change', function() {
            $('#sala_hidden').val($(this).val());
        });

        // Inicializa o valor do campo hidden, caso existam valores pré-selecionados
        $('#sala_hidden').val($('#sala').val());

        // --------------------- Fim do filtro de Salas Cirúrgicas -----------------------------------------------------------------------

        //------------------------ Filtro de prof_especs adicionais baseado no filtro selecionado ----------------
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

        // --------------------- Fim do filtro de profissionais -----------------------------------------------------------------------

        // Procedimentos Adicionais  ----------------------------------------------------------------------------

        $('#proced_adic').on('change', function() {
            $('#proced_adic_hidden').val($(this).val());
        });

        // Inicializa o valor do campo hidden, caso existam valores pré-selecionados
        $('#proced_adic_hidden').val($('#proced_adic').val());
        
        // Procedimentos Adicionais  ----------------------------------------------------------------------------

        $('#idForm').submit(function() {
            $('#janelaAguarde').show();
            setTimeout(function() {
                window.location.href = href;
            }, 1000);
        });
        
        $('.select2-dropdown').select2({
            dropdownCssClass: 'custom-dropdown',
            allowClear: true
        });

        const prontuarioInput = document.getElementById('prontuario');
        prontuarioInput.addEventListener('change', function() {
            fetchPacienteNome(prontuarioInput.value);
        });

    });
</script>
