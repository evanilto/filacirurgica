<?= csrf_field() ?>
<?php $validation = \Config\Services::validation(); ?>

<div class="container" style="padding-top: 0; margin-top: -30px">
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
                                <div class="mb-3">
                                    <label for="dtcirurgia" class="form-label">Data/hora da Cirurgia</label>
                                    <div class="input-group">
                                        <input type="text" id="dtcirurgia" placeholder="DD/MM/AAAA HH:MM" disabled
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
                            <div class="col-md-10">
                                <div class="mb-3">
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
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
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
                            <div class="col-md-6">
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
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
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
                                <div class="mb-3">
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
                                <div class="mb-3">
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
                                <div class="mb-3">
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
                            <div class="col-md-3">
                                <div class="mb-3">
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
                                <div class="mb-3">
                                    <label class="form-label">Congelação<b class="text-danger">*</b></label>
                                    <div class="input-group mb-3 bordered-container">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="congelacao" id="congelacaoN" value="N" checked
                                                <?= (isset($data['congelacao']) && $data['congelacao'] == 'N') ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="congelacaoN" style="margin-right: 10px;">&nbsp;Não</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="congelacao" id="congelacaoS" value="S"
                                                <?= (isset($data['congelacao']) && $data['congelacao'] == 'S') ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="congelacaoS" style="margin-right: 10px;">&nbsp;Sim</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
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
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label class="form-label">OPME<b class="text-danger">*</b></label>
                                    <div class="input-group mb-3 bordered-container">
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
                        </div>
                        <div class="row g-3">
                            <div class="col-md-3">
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
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="mb-3">
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
                                <div class="mb-3">
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
                                <div class="mb-3">
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
                                    onclick="verPacienteNaLista(event);">
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
                        <input type="hidden" name="especialidade" value="<?= $data['especialidade'] ?>" />
                        <input type="hidden" name="dtcirurgia" value="<?= $data['dtcirurgia'] ?>" />
                        <input type="hidden" name="fila" value="<?= $data['fila'] ?>" />
                        <input type="hidden" name="fila_hidden" id="fila_hidden" />
                        <input type="hidden" name="procedimento" value="<?= $data['procedimento'] ?>" />
                        <input type="hidden" name="procedimento_hidden" id="procedimento_hidden" />
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

function verPacienteNaLista(event) {
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
                                    $('#idForm').off('submit'); // Remover qualquer manipulador de eventos existente
                                    $('#idForm').submit(); // Submete
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

    /* function fetchPacienteNome(prontuarioValue) {
      if (prontuarioValue) {
        fetch('<--?= base_url('listaespera/getnomepac/') ?>' + prontuarioValue, {
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
    } */

    
    function trocarpaciente() {
        const formulario = document.getElementById('idForm');

        const formData = new FormData(formulario);
        
        // Para converter FormData em um objeto simples (opcional)
       /*  const dados = {};
        formData.forEach((value, key) => {
            dados[key] = value;
        }); */

        //console.log(dados); // Para verificar os dados no console (opcional)
        fetch('<?=base_url('mapacirurgico/trocar')?>', {
            method: 'POST',
            body: formData // ou pode usar JSON.stringify(dados) se necessário
        })
        .then(response => {

            if (!response.ok) {
                    throw new Error('Erro na resposta da rede');
            }

            return response.text(); // ou response.text() dependendo do que o servidor retorna
        })
        .then(data => {
            console.log('Success:', data); 
            alert('okk');

           /*  setTimeout(() => {
                //window.history.back(3);
              //  window.location.href = '<--?=base_url('mapacirurgico/resultado')?>'; // Mude para a URL que deseja acessar
                //window.location.reload(); // Recarregar a página após 1 segundo
            }, 1000); */
            window.location.href = '<?=base_url('mapacirurgico/exibir')?>'; 
        })
        .catch((error) => {
            console.error('Error:', error); 
        });
    }
    
    function loadAsideContent(recordId, ordemFila, fila) {
        $.ajax({
            url: '<?= base_url('listaespera/carregaaside/') ?>' + recordId + '/' + ordemFila + '/' + fila,
            method: 'GET',
            beforeSend: function() {
                $('#sidebar').html('<p>Carregando...</p>'); 
            },
            success: function(response) {
                $('#sidebar').html(response);
            },
            error: function(xhr, status, error) {
                var errorMessage = 'Erro ao carregar os detalhes: ' + status + ' - ' + error;
                console.error(errorMessage);
                console.error(xhr.responseText);
                $('#sidebar').html('<p>' + errorMessage + '</p><p>' + xhr.responseText + '</p>');
            }
        });
    }

    /* function fetchPacienteNomeOnLoad() {
        const prontuarioInput = document.getElementById('prontuario');
        fetchPacienteNome(prontuarioInput.value);
    }

    fetchPacienteNomeOnLoad(); */

    /* const prontuarioValue = document.getElementById('prontuario_pacatrocar').value;
    const ordemValue = document.getElementById('ordemfila_pacatrocar').value;
    const filaText = document.getElementById('fila_pacatrocar').value;
    loadAsideContent(prontuarioValue, ordemValue, filaText); */

    $(document).ready(function() {
        $('.select2-dropdown').select2({
            placeholder: "",
            allowClear: true,
            width: 'resolve' // Corrigir a largura
        });

        $('#candidato').select2({
            placeholder: "Selecione uma ou mais opções",
            allowClear: true,
            closeOnSelect: true // Fecha o dropdown automaticamente
        });

        var lateralidadeValue = $('input[name="lateralidade"]').val(); // O valor deve ser definido aqui para o hidden
        $('select[name="lateralidade"]').val(lateralidadeValue).change(); // 

        $('#seu-select2').on('select2:select', function (e) {
            $(this).select2('close'); // Fecha o dropdown manualmente
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
            //$('#idForm').off('submit').submit(); // Remove qualquer manipulador anterior e submete o formulário
        });
    */
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

            //alert(lateralidadeValue);
            //if (prontuarioValue) { // Verifica se prontuarioValue não está vazio

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
                //$('input[name="complexidade"][value="' + complexidadeValue + '"]').prop('checked', true);
                //$('input[name="congelacao"][value="' + congelacaoValue + '"]').prop('checked', true);

                /* var elemento = $('input[name="complexidade"][value="' + complexidadeValue + '"]');

                console.log("Elemento encontrado:", elemento);

                if (elemento.length) {
                    // Marca o botão de rádio
                    elemento.prop('checked', true).trigger('change');
                    console.log("Complexidade definida para:", complexidadeValue);
                } else {
                    console.warn("Botão de rádio correspondente não encontrado.");
                } */
/* 
                if ($('#candidato').val()) {
                    $('#candidato').trigger('change');
                } */

                //$('#candidato').trigger('change');

                //loadAsideContent(prontuarioValue, ordemValue, filaText);

                //document.getElementById('procedimento').value = procedimentoValue;

                $('#fila').val(idFilaValue).change(); // Atualiza o valor e dispara evento change se necessário
                $('#procedimento').val(procedimentoValue).change(); // Atualiza o valor e dispara evento change se necessário

                $('#proced_adic option[value="' + procedimentoValue + '"]').remove();
            /* } else {
                // Limpa os valores dos campos ocultos se não houver candidato selecionado
                $('input[name="prontuario"]').val('');
                $('input[name="idlistapac2"]').val('');
                $('input[name="procedimento"]').val('');
                $('#aside').html(''); // Limpa o conteúdo do aside
            } */
        });

      /*   if ($('#candidato').val()) {
            $('#candidato').trigger('change');
        } */

        /* $('select[name="lateralidade"]').on('change', function() {
            var selectedValue = $(this).val();
             $('input[name="lateralidade"]').val(selectedValue);
        }); */
        $('#risco').change(function() {
            var selectedFilter = $(this).val();
            $('input[name="risco"]').val(selectedFilter);
        })
        $('#lateralidade').change(function() {
            var selectedFilter = $(this).val();
            $('input[name="lateralidade"]').val(selectedFilter);
        })

        <?php if (isset($data['idlistapac2']) && !empty($data['idlistapac2'])) { ?>
            $('#candidato').val(<?= $data['idlistapac2']?>).change(); 
        <?php } ?> 


    });
</script>
