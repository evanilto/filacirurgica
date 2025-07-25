<?= csrf_field() ?>
<?php $validation = \Config\Services::validation(); ?>
<?php 
    //dd($data['linkorigem']);
    switch ($data['linkorigem']) {
        case 'situacao_cirurgica':
            $link = base_url('listaespera/exibirsituacao');
            break;
        case 'cirurgiascomhemocomps':
            $link = base_url('mapacirurgico/exibircirurgiacomhemocomps');
            break;
        default:
            $link = base_url('mapacirurgico/exibir');
            break;
    }

    $usarHemocomponentes_disabled = true;
?>

<div class="container mt-5 mb-5">
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
                                <div class="mb-2">
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
                            <div class="col-md-2">
                                <div class="mb-2">
                                    <label for="tempoprevisto" class="form-label">Tempo Previsto Cirurgia<b class="text-danger">*</b></label>
                                    <div class="input-group">
                                        <input type="time" id="tempoprevisto" maxlength="5" placeholder="HH:MM" disabled
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
                            <div class="col-md-2">
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
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label for="cid" class="form-label">CID</label>
                                    <div class="input-group">
                                        <select class="form-select select2-dropdown <?php if($validation->getError('cid')): ?>is-invalid<?php endif ?>"
                                            id="cid" name="cid"
                                            data-placeholder="" data-allow-clear="1" disabled> 
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
                                <div class="mb-2">
                                    <label for="dtrisco" class="form-label">Data Risco</label>
                                    <div class="input-group">
                                        <input type="text" id="dtrisco" maxlength="10" placeholder="DD/MM/AAAA" disabled
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
                        </div>
                        <div class="row g-3">
                            <div class="col-md-2">
                                <div class="mb-2">
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
                            <div class="col-md-2">
                                <div class="mb-2">
                                    <label class="form-label">Congelação</label>
                                    <div class="input-group mb-2 bordered-container">
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
                            <!-- <div class="col-md-3">
                                <div class="mb-2">
                                    <label class="form-label">Hemoderivados</label>
                                    <div class="input-group mb-2 bordered-container">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="hemoderivados" id="hemoderivadosN" value="N" disabled
                                                <-?= (isset($data['hemoderivados']) && $data['hemoderivados'] == 'N') ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="hemoderivadosN" style="margin-right: 10px;">&nbsp;Não</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="hemoderivados" id="hemoderivadosS" value="S" disabled
                                                <-?= (isset($data['hemoderivados']) && $data['hemoderivados'] == 'S') ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="hemoderivadosS" style="margin-right: 10px;">&nbsp;Sim</label>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                            <div class="col-md-3">
                                <div class="mb-2">
                                    <label class="form-label">Complexidade</label>
                                    <div class="input-group mb-2 bordered-container">
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
                            <div class="col-md-2">
                                <div class="mb-2">
                                    <label for="tipo_sanguineo" class="form-label">Tipo Sanguíneo</label>
                                    <select class="form-select select2-dropdown"
                                        name="tipo_sanguineo" id="tipo_sanguineo"
                                        data-placeholder="" data-allow-clear="1" disabled>
                                        <option value="" <?php echo set_select('tipo_sanguineo', '', TRUE); ?> ></option>
                                        <?php
                                            $tipos = ['A (+)', 'A (-)', 'B (+)', 'B (-)', 'AB (+)', 'AB (-)', 'O (+)', 'O (-)'];
                                            foreach ($tipos as $tipo):
                                                $selected = ($data['tipo_sanguineo'] == $tipo) ? 'selected' : '';
                                                echo '<option value="'.$tipo.'" '.$selected.'>&nbsp'.$tipo.'</option>';
                                            endforeach;
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-2">
                                    <label class="form-label">OPME<b class="text-danger">*</b></label>
                                    <div class="input-group mb-2 bordered-container">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="opme" id="opmeN" value="N" disabled
                                                <?= (isset($data['opme']) && $data['opme'] == 'N') ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="opmeN" style="margin-right: 10px;">&nbsp;Não</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="opme" id="opmeS" value="S" disabled
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
                                                <?= (isset($data['usarHemocomponentes']) && $data['usarHemocomponentes'] == 'N') ? 'checked' : '' ?> 
                                                <?= $usarHemocomponentes_disabled ? 'disabled' : '' ?>>
                                            <label class="form-check-label" for="usarHemocomponentesN" style="margin-right: 10px;">&nbsp;Não</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="usarHemocomponentes" id="usarHemocomponentesS" value="S"
                                                <?= (isset($data['usarHemocomponentes']) && $data['usarHemocomponentes'] == 'S') ? 'checked' : '' ?>
                                                <?= $usarHemocomponentes_disabled ? 'disabled' : '' ?>>
                                            <label class="form-check-label" for="usarHemocomponentesS" style="margin-right: 10px;">&nbsp;Sim</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row g-3 mb-2">
                            <!-- Lista de hemocomponentes com campo de quantidade -->
                            <div class="col-md-12" id="hemocomp-section">
                                <div class="mb-4">
                                    <label class="form-label">Selecionar Hemocomponentes e Quantidade</label>
                                    <div class="bordered-container py-3">
                                        <div class="row gx-3 px-3 mb-4">
                                            <?php foreach ($data['hemocomponentes'] as $hemocomp): 

                                                $hemocomp_id = $hemocomp->id;
                                                $checked = isset($data['hemocomp_qty_solicitada'][$hemocomp_id]);

                                                $raw_qty_solicitada = $checked && isset($data['hemocomp_qty_solicitada'][$hemocomp_id])
                                                    ? $data['hemocomp_qty_solicitada'][$hemocomp_id]
                                                    : null;

                                                $raw_qty_liberada = $checked && isset($data['hemocomp_qty_liberada'][$hemocomp_id])
                                                    ? $data['hemocomp_qty_liberada'][$hemocomp_id]
                                                    : null;

                                                $qty_solicitada = htmlspecialchars((string)$raw_qty_solicitada ?? '');
                                                $qty_liberada   = htmlspecialchars((string)$raw_qty_liberada ?? '');

                                                //dd($qty_solicitada, $qty_liberada);

                                                // Habilita o campo SOMENTE se qty_liberada NÃO estiver definido ou NÃO for numérico
                                                $enabled = false;
                                            ?>
                                                <div class="col-md-6 mb-3">
                                                    <div class="row align-items-end">
                                                        <div class="col-8 pt-4"> <!-- pt-4 alinha verticalmente com os inputs -->
                                                            <div>
                                                                <input class="form-check-input me-2 hemocomp-checkbox" type="checkbox" 
                                                                    id="hemocomp_<?= $hemocomp->id ?>" 
                                                                    name="hemocomps[<?= $hemocomp->id ?>]" 
                                                                    value=""
                                                                    <?= $checked ? 'checked' : '' ?>
                                                                    <?= $enabled ? '' : 'disabled data-disabled-perm' ?>>
                                                                <label class="form-check-label" for="hemocomp_<?= $hemocomp->id ?>">
                                                                    <?= $hemocomp->descricao ?>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-2">
                                                            <div class="form-group">
                                                                <label for="qty_solicitada_<?= $hemocomp->id ?>" class="form-label small">Solicitado</label>
                                                                <input type="number" class="form-control hemocomp-qty" 
                                                                    id="qty_solicitada_<?= $hemocomp->id ?>"
                                                                    name="hemocomp_qty_solicitada[<?= $hemocomp->id ?>]" 
                                                                    placeholder="" min="1"
                                                                    value="<?= $qty_solicitada ?>"
                                                                    <?= ($checked && $enabled) ? '' : 'disabled' ?>>
                                                            </div>
                                                        </div>
                                                        <div class="col-2">
                                                            <div class="form-group">
                                                                <label for="qty_liberada_<?= $hemocomp->id ?>" class="form-label small">Liberado</label>
                                                                <input type="number" class="form-control hemocomp-qty" 
                                                                    id="qty_liberada_<?= $hemocomp->id ?>"
                                                                    name="hemocomp_qty_liberada[<?= $hemocomp->id ?>]" 
                                                                    placeholder="" min="0"
                                                                    value="<?= $qty_liberada ?>" disabled>
                                                                    <!-- Campo hidden que será submetido -->
                                                                    <input type="hidden" name="hemocomp_qty_liberada[<?= $hemocomp->id ?>]" value="<?= $qty_liberada ?>">
                                                            </div>
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
                                                <!-- ✅ Manter o bordered-container original aqui -->
                                                <div class="input-group mb-2 bordered-container">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="usarEquipamentos" id="eqptoN" value="N" disabled
                                                            <?= (isset($data['usarEquipamentos']) && $data['usarEquipamentos'] === 'N') ? 'checked' : '' ?>>
                                                        <label class="form-check-label" for="eqptoN">Não</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="usarEquipamentos" id="eqptoS" value="S" disabled
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
                                                    <select class="form-select select2-dropdown <?= $validation->hasError('eqpts') ? 'is-invalid' : '' ?>" disabled
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
                                <div class="bordered-container mb-4" style="margin-left: 5px; margin-right: 3px;">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="filtro_especialidades" class="form-label">Especialidade</label>
                                                <select class="form-select select2-dropdown" id="filtro_especialidades" name="filtro_especialidades" <?= $data['status_fila'] ?> disabled>
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
                                                <select class="form-select select2-dropdown <?= $validation->hasError('profissional') ? 'is-invalid' : '' ?>" disabled
                                                        id="profissional" name="profissional[]" multiple="multiple" data-placeholder="" data-allow-clear="1" <?= $data['status_fila'] ?>>
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
                        <div class="row g-3 mb-2">
                            <div class="g-2">
                                <div class="bordered-container" style="margin-left: 5px; margin-right: 3px;">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="centrocirurgico" class="form-label">Centro Cirúrgico<b class="text-danger">*</b></label>
                                                <select class="form-select select2-dropdown  <?= $validation->hasError('centrocirurgico') ? 'is-invalid' : '' ?>" <?= $data['status_fila'] ?>
                                                    id="centrocirurgico" name="centrocirurgico" disabled>
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
                                            <label for="sala" class="form-label">Salas<b class="text-danger">*</b></label>
                                                <select class="form-select select2-dropdown <?= $validation->hasError('sala') ? 'is-invalid' : '' ?>" <?= $data['status_fila'] ?>
                                                        id="sala" name="sala" data-placeholder="" data-allow-clear="1" disabled>
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
                        </div>
                        <div class="row g-3">
                            <div class="col-md-12">
                                <div class="mb-2">
                                    <label class="form-label" for="nec_proced">Necessidades do Procedimento</label>
                                    <textarea id="nec_proced" maxlength="255" rows="3" disabled
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
                                <div class="mb-2">
                                    <label class="form-label" for="info">Informações adicionais</label>
                                    <textarea id="info" maxlength="255" rows="3" disabled
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
                                    <label class="form-label" for="justenvio">Justificativas Envio ao Mapa</label>
                                    <textarea id="justenvio" maxlength="255" rows="3" disabled
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
                        <!-- <div class="row g-3">
                            <--?php if ($data['indurgencia'] == 'S') { ?>
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <label class="form-label" for="justurgencia">Justificativas da Urgência</label>
                                        <textarea id="justurgencia" maxlength="255" rows="3" disabled
                                                class="form-control <--?= isset($validation) && $validation->getError('justurgencia') ? 'is-invalid' : '' ?>"
                                                name="justurgencia"><--?= isset($data['justurgencia']) ? $data['justurgencia'] : '' ?></textarea>
                                        <--?php if (isset($validation) && $validation->getError('justurgencia')): ?>
                                            <div class="invalid-feedback">
                                                <--?= $validation->getError('justurgencia') ?>
                                            </div>
                                        <--?php endif; ?>
                                    </div>
                                </div>
                            <--?php } ?>
                        </div> -->
                        <?php if ($data['dtsuspensao']) { ?>
                            <div class="row g-3">
                                <div class="col-md-2">
                                    <div class="mb-2">
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
                                    <div class="mb-2">
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
                                    <div class="mb-2">
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
                        <?php if ($data['dttroca']) { ?>
                            <div class="row g-3">
                                <div class="col-md-2">
                                    <div class="mb-2">
                                        <label for="dttroca" class="form-label">Data/Hora Troca</label>
                                        <div class="input-group">
                                            <input type="text" id="dttroca" placeholder="DD/MM/AAAA HH:MM:SS" disabled
                                                class="form-control<?php if($validation->getError('dttroca')): ?>is-invalid<?php endif ?>"
                                                name="dttroca" value="<?= set_value('dttroca', $data['dttroca']) ?>" disabled/>
                                            <?php if ($validation->getError('dttroca')): ?>
                                                <div class="invalid-feedback">
                                                    <?= $validation->getError('dttroca') ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <div class="mb-2">
                                        <label class="form-label" for="justtroca">Observações sobre a troca</label>
                                        <textarea id="justtroca" maxlength="255" rows="3" disabled
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
                        <?php } ?>
                        <div class="row g-3">
                            <div class="col-md-12">
                                <a class="btn btn-warning mt-3" id="btnVoltar" data-link="<?= $link; ?>">
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
            
            //loadAsideContent(prontuarioValue, ordemValue, filaText);
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

        $("#btnVoltar").on("click", function(event) {
            event.preventDefault(); // Impede a navegação imediata

            var linkDestino = $(this).data("link"); // Obtém o link do botão

            // Exibe a janela de aguarde
            $("#janelaAguarde").show();

            // Aguarda um curto período e redireciona
            setTimeout(function() {
                window.location.href = linkDestino;
            }, 1000); // Tempo para exibir o "Aguarde"
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
            allowClear: true
        });

        const prontuarioInput = document.getElementById('prontuario');
        prontuarioInput.addEventListener('change', function() {
            fetchPacienteNome(prontuarioInput.value);
        });

    });
</script>
