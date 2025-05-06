<?= csrf_field() ?>
<?php $validation = \Config\Services::validation(); ?>

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card form-container">
                <div class="card-header text-center text-black">
                    <b><?= 'Incluir Paciente na Fila Cirúrgica' ?></b>
                </div>
                <div class="card-body has-validation">
                    <form id="idForm" method="post" action="<?= base_url('listaespera/incluir') ?>">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <div class="mb-2">
                                    <label for="dtinclusao" class="form-label">Data/Hora de Inclusão</label>
                                    <div class="input-group">
                                        <input type="text" id="dtinclusao" placeholder="DD/MM/AAAA HH:MM:SS" readonly
                                            class="form-control <?php if($validation->getError('dtinclusao')): ?>is-invalid<?php endif ?>"
                                            name="dtinclusao" value="<?= set_value('dtinclusao', $data['dtinclusao']) ?>"/>
                                        <?php if ($validation->getError('dtinclusao')): ?>
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('dtinclusao') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-2">
                                    <label for="prontuario" class="form-label">Prontuario<b class="text-danger">*</b></label>
                                    <div class="input-group">
                                        <input type="number" id="prontuario" maxlength="8"
                                        class="form-control <?php if($validation->getError('prontuario')): ?>is-invalid<?php endif ?>"
                                        name="prontuario" value="<?= set_value('prontuario') ?>"/>

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
                                    <label for="nome" class="form-label">Nome</label>
                                    <div class="input-group">
                                        <input type="text" id="nome" minlength="3" readonly
                                        class="form-control <?php if($validation->getError('nome')): ?>is-invalid<?php endif ?>"
                                        name="nome" value="<?= set_value('nome') ?>" />
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
                                    <label for="especialidade" class="form-label">Especialidade<b class="text-danger">*</b></label>
                                    <div class="input-group">
                                        <select class="form-select select2-dropdown <?php if($validation->getError('especialidade')): ?>is-invalid<?php endif ?>"
                                            id="especialidade" name="especialidade"
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
                                <div class="mb-2">
                                    <label for="fila" class="form-label">Fila Cirúrgica<b class="text-danger">*</b></label>
                                    <div class="input-group">
                                        <select class="form-select select2-dropdown <?php if($validation->getError('fila')): ?>is-invalid<?php endif ?>"
                                            id="fila" name="fila"
                                            data-placeholder="Selecione uma opção" data-allow-clear="1">
                                            <option value="" <?php echo set_select('fila', '', TRUE); ?> ></option>
                                            <?php
                                            foreach ($data['filas'] as $key => $fila) {
                                                $selected = (set_value('fila') == $fila['id']) ? 'selected' : '';
                                                echo '<option value="'.$fila['id'].'" data-especialidade="'.$fila['idespecialidade'].'" '.$selected.'>'.$fila['nmtipoprocedimento'].'</option>';
                                               /*  echo "<!-- id: {$fila['id']}, idespecialidade: {$fila['idespecialidade']}, nmtipoprocedimento: {$fila['nmtipoprocedimento']} -->"; */

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
                                    <label for="procedimento" class="form-label">Procedimento<b class="text-danger">*</b></label>
                                    <div class="input-group">
                                        <select class="form-select select2-dropdown <?php if($validation->getError('procedimento')): ?>is-invalid<?php endif ?>"
                                            id="procedimento" name="procedimento"
                                            data-placeholder="Selecione uma opção" data-allow-clear="1">
                                            <option value="" <?php echo set_select('procedimento', '', TRUE); ?> ></option>
                                            <?php
                                            foreach ($data['procedimentos'] as $key => $procedimento) {
                                                $selected = (set_value('procedimento') == $procedimento->cod_tabela) ? 'selected' : '';
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
                                    <label for="cid" class="form-label">CID<b class="text-danger">*</b></label>
                                    <div class="input-group">
                                        <select class="form-select select2-dropdown <?php if($validation->getError('cid')): ?>is-invalid<?php endif ?>"
                                            id="cid" name="cid"
                                            data-placeholder="Selecione uma opção" data-allow-clear="1">
                                            <option value="" <?php echo set_select('cid', '', TRUE); ?> ></option>
                                            <?php
                                            foreach ($data['cids'] as $key => $cid) {
                                                $selected = (set_value('cid') == $cid->seq) ? 'selected' : '';
                                                echo '<option value="'.$cid->seq.'" '.$selected.'>'.$cid->codigo.' - '.$cid->descricao.'</option>';
                                            }
                                            ?>
                                        </select>
                                        <?php if ($validation->getError('cid')): ?>
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('cid') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-3">
                                <div class="mb-2">
                                    <label for="risco" class="form-label">Risco<b class="text-danger">*</b></label>
                                    <div class="input-group">
                                        <select class="form-select select2-dropdown <?php if($validation->getError('risco')): ?>is-invalid<?php endif ?>"
                                            id="risco" name="risco"
                                            data-placeholder="Selecione uma opção" data-allow-clear="1">
                                            <option value="" <?php echo set_select('risco', '', TRUE); ?> ></option>
                                            <?php
                                            foreach ($data['riscos'] as $key => $risco) {
                                                $selected = (set_value('risco') == $risco['id']) ? 'selected' : '';
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
                            <div class="col-md-3">
                                <div class="mb-2">
                                    <label for="dtrisco" class="form-label">Data Risco</label>
                                    <div class="input-group">
                                        <input type="text" id="dtrisco" maxlength="10" value="" placeholder="DD/MM/AAAA"
                                            class="form-control Data <?php if($validation->getError('dtrisco')): ?>is-invalid<?php endif ?>"
                                            name="dtrisco" value="<?= set_value('dtrisco') ?>"/>
                                        <?php if ($validation->getError('dtrisco')): ?>
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('dtrisco') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-2">
                                    <label for="origem" class="form-label">Origem Paciente<b class="text-danger">*</b></label>
                                    <div class="input-group">
                                        <select class="form-select select2-dropdown <?php if($validation->getError('origem')): ?>is-invalid<?php endif ?>"
                                            id="origem" name="origem"
                                            data-placeholder="Selecione uma opção" data-allow-clear="1">
                                            <option value="" <?php echo set_select('origem', '', TRUE); ?> ></option>
                                            <?php
                                            foreach ($data['origens'] as $key => $origem) {
                                                $selected = (set_value('origem') == $origem['id']) ? 'selected' : '';
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
                            <div class="col-md-2">
                                <div class="mb-2">
                                    <label for="tipo_sanguineo" class="form-label">Tipo Sanguíneo</label>
                                    <select class="form-select select2-dropdown"
                                        name="tipo_sanguineo" id="tipo_sanguineo"
                                        data-placeholder="Selecione uma opção" data-allow-clear="1">
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
                        </div>
                        <div class="row g-3">
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
                                                $selected = (set_value('lateralidade') == $lateralidade['id']) ? 'selected' : '';
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
                            <div class="col-md-2">
                                <div class="mb-2">
                                    <label class="form-label">Congelação <b class="text-danger">*</b></label>
                                    <div class="input-group mb-2 bordered-container">
                                        <?php
                                        $congelacoes = [
                                            'N' => 'Não',
                                            'S' => 'Sim',
                                        ];
                                        foreach ($congelacoes as $value => $label) :
                                            $isChecked = (isset($data['congelacao']) && $data['congelacao'] == $value) ? 'checked' : '';
                                        ?>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="congelacao" id="congelacao<?= $value ?>" value="<?= $value ?>" <?= $isChecked ?>>
                                                <label class="form-check-label" for="congelacao<?= $value ?>"><?= $label ?></label>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                <?php if ($validation->getError('congelacao')): ?>
                                    <div class="invalid-feedback d-block">
                                        <?= $validation->getError('congelacao') ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="col-md-2">
                                <div class="mb-2">
                                    <label class="form-label">OPME <b class="text-danger">*</b></label>
                                    <div class="input-group mb-2 bordered-container">
                                        <?php
                                        $opmes = [
                                            'N' => 'Não',
                                            'S' => 'Sim',
                                        ];
                                        foreach ($opmes as $value => $label) :
                                            $isChecked = (isset($data['opme']) && $data['opme'] == $value) ? 'checked' : '';
                                        ?>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="opme" id="opme<?= $value ?>" value="<?= $value ?>" <?= $isChecked ?>>
                                                <label class="form-check-label" for="opme<?= $value ?>"><?= $label ?></label>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                <?php if ($validation->getError('opme')): ?>
                                    <div class="invalid-feedback d-block">
                                        <?= $validation->getError('opme') ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label class="form-label">Complexidade <b class="text-danger">*</b></label>
                                    <div class="input-group mb-2 bordered-container">
                                        <?php
                                        $complexidades = [
                                            'A' => 'Alta',
                                            'M' => 'Média',
                                            'B' => 'Baixa',
                                        ];
                                        foreach ($complexidades as $value => $label) : 
                                            $isChecked = (isset($data['complexidade']) && $data['complexidade'] == $value) ? 'checked' : '';
                                        ?>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="complexidade" id="complexidade<?= $value ?>" value="<?= $value ?>" <?= $isChecked ?>>
                                                <label class="form-check-label" for="complexidade<?= $value ?>"> <?= $label ?></label>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <?php if ($validation->getError('complexidade')): ?>
                                        <div class="invalid-feedback d-block">
                                            <?= $validation->getError('complexidade') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="mb-2">
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
                                <div class="mb-2">
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
                            <div class="col-md-12">
                                <?php if ($data['habilitasalvar'] ) { ?>
                                    <button class="btn btn-primary mt-4" onclick="return confirma(this);">
                                        <i class="fa-solid fa-save"></i> Salvar
                                    </button>
                                <?php } ?>
                                <a class="btn btn-warning mt-4" href="<?= base_url('home_index') ?>">
                                    <i class="fa-solid fa-arrow-left"></i> Voltar
                                </a>
                            </div>
                        </div>

                        <input type="hidden" name="ordem_hidden" id="ordem_hidden" value="<?= $data['ordem'] ?>" />
                        <input type="hidden" name="alteracao_tipo_sanguineo" id="alteracao_tipo_sanguineo" value="<?= $data['alteracao_tipo_sanguineo'] ?? "0" ?>">
                        <input type="hidden" name="tipo_sanguineo_original" id="tipo_sanguineo_original" value="<?= $data['tipo_sanguineo_original'] ?? "" ?>">
                        <input type="hidden" name="tipo_sanguineo_confirmado" id="tipo_sanguineo_confirmado" value="<?= $data['tipo_sanguineo_confirmado'] ?? "0" ?>">
                        <input type="hidden" name="motivo_alteracao_hidden" id="motivo_alteracao_hidden"  value="<?= $data['motivo_alteracao_hidden'] ?? NULL ?>">
                        <input type="hidden" name="justificativa_alteracao_hidden" id="justificativa_alteracao_hidden" value="<?= $data['justificativa_alteracao_hidden'] ?? NULL ?>">
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
    window.onload = function() {
        const inputs = document.querySelectorAll('input, select, .form-check-input');
        inputs.forEach(input => {
            input.addEventListener('keydown', disableEnter);
        });
    };

    function confirma(button) {
        event.preventDefault();

        const form = button.form;
        const prontuario = form.querySelector('input[name="prontuario"]').value;
        const data = { prontuario: prontuario };

        if (!prontuario || prontuario.trim() === "") {
            return true;
        } else {
            // Use uma requisição assíncrona
            const xhr = new XMLHttpRequest();
            xhr.open('POST', '<?= base_url('listaespera/verificapacientenalista') ?>', true); // 'true' faz a requisição ser assíncrona
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            
            xhr.onload = function() {
                if (xhr.status >= 200 && xhr.status < 400) {
                    const response = JSON.parse(xhr.responseText);

                    if (response.success) {
                        // Exibe a SweetAlert2
                        Swal.fire({
                            title: 'Esse paciente já está na Fila Cirúrgica. Deseja incluí-lo mesmo assim?',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Ok',
                            cancelButtonText: 'Cancelar'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Se o usuário confirmar, submete o formulário
                                $('#janelaAguarde').show();
                                $('#idForm').off('submit'); 
                                $('#idForm').submit(); 
                            } else {
                                // Se o usuário cancelar, não faz nada
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
                    return false;  // Impede a submissão em caso de erro
                }
            };

            xhr.onerror = function() {
                console.error('Erro ao enviar os dados:', xhr.statusText);
                alert('Erro na comunicação com o servidor.');
                $('#janelaAguarde').hide();
                return false;  // Impede a submissão em caso de erro
            };

            // Envia os dados como JSON
            xhr.send(JSON.stringify(data));
        }
    }

    function carregarDadosModal(dados) {

        $.ajax({
            url: '/listaespera/carregadadosmodal', // Rota do seu método PHP
            //url: '<--?= base_url('listaespera/carregadadosmodal/') ?>' + prontuario,
            type: 'GET',
            data: { prontuario: dados.prontuario }, // Envia o ID como parâmetro
            dataType: 'json',
            success: function(paciente) {
                // Função para verificar se o valor é nulo ou vazio
                function verificarValor(valor) {
                    
                    return (valor === null || valor === '') ? 'N/D' : valor;
                }

                function verificarOutroValor(valor) {
                    
                    return (valor === null || valor === '') ? '' : ' - ' + valor;
                }

                // Atualiza o conteúdo do modal para a coluna esquerda
                $('#colunaEsquerda1').html(`
                    <strong>Prontuario:</strong> ${verificarValor(paciente.prontuario)}<br>
                    <strong>Nome:</strong> ${verificarValor(paciente.nome)}<br>
                    <strong>Nome da Mãe:</strong> ${verificarValor(paciente.nm_mae)}<br>
                    <strong>Sexo:</strong> ${verificarValor(paciente.sexo)}<br>
                    <strong>Data Nascimento:</strong> ${verificarValor(paciente.dt_nascimento)}<br>
                    <strong>Idade:</strong> ${verificarValor(paciente.idade)}<br>
                    <strong>CPF:</strong> ${verificarValor(paciente.cpf)}<br>
                    <strong>CNS:</strong> ${verificarValor(paciente.cns)}<br>
                `);

                // Atualiza o conteúdo do modal para a coluna direita
                $('#colunaDireita1').html(`
                    <strong>Tel. Residencial:</strong> ${verificarValor(paciente.tel_1)}<br>
                    <strong>Tel. Recados:</strong> ${verificarValor(paciente.tel_2)}<br>
                    <strong>Email:</strong> ${verificarValor(paciente.email)}<br>
                    <strong>Endereço:</strong> ${verificarValor(paciente.logradouro)}, ${verificarValor(paciente.num_logr)} ${verificarOutroValor(paciente.compl_logr)}<br>
                    <strong>Cidade:</strong> ${verificarValor(paciente.cidade)}<br>
                    <strong>Bairro:</strong> ${verificarValor(paciente.bairro)}<br>
                    <strong>CEP:</strong> ${verificarValor(paciente.cep)}<br>
                `);
                $('#colunaEsquerda2').html(`
                    <strong>Fila:</strong> ${dados.fila}<br>
                    <strong>Especialidade:</strong> ${dados.especialidade}<br>
                    <strong>Procedimento:</strong> ${dados.procedimento}<br>
                `);

                // Atualiza o conteúdo do modal para a coluna direita
                $('#colunaDireita2').html(`
                    <strong>Centro Cirúrgico:</strong> ${verificarValor(dados.centrocir)} ${verificarOutroValor(dados.sala)}<br>
                    <strong>Entrada no Centro Cirúrgico:</strong> ${verificarValor(dados.hrnocentro)}<br>
                    <strong>Início da Cirurgia:</strong> ${verificarValor(dados.hremcirurgia)}<br>
                    <strong>Saída da Sala:</strong> ${verificarValor(dados.hrsaidasl)}<br>
                    <strong>Saída do Centro Cirúrgico:</strong> ${verificarValor(dados.hrsaidacc)}<br>
                `);
/* 
                $('#linha').html(`
                    <strong>Informações Adicionais:</strong> ${verificarValor(infoadic)}<br>
                `); */

                // Mostra o modal
                $('#modalDetalhes').modal('show');
            },
            error: function(xhr, status, error) {
                console.error('Erro ao carregar os dados:', error);
            }
        });
    }

    /* function loadAsideContent(prontuario, ordem, fila) {
        $.ajax({
            url: '<--?= base_url('listaespera/carregaaside/') ?>' + prontuario + '/' + ordem + '/' + fila,
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
    } */

    //let tipoSanguineoOriginal = '';
    //let alteracaoConfirmada = false;
    let tipoSanguineoOriginal = $('#tipo_sanguineo_original').val();
    let alteracaoConfirmada =  $('#tipo_sanguineo_confirmado').val() == '1';
    let carregandoInicial = false;

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
                
                tipoSanguineoOriginal = data.tiposanguineo;
                updated_at = data.updated_at;
                alteracaoConfirmada = false;

                $('#tipo_sanguineo').val(tipoSanguineoOriginal).trigger('change');
                $('#tipo_sanguineo_original').val(tipoSanguineoOriginal);
                $('#alteracao_tipo_sanguineo').val('0');

                $('#paciente_updated_at_original').val(updated_at);

                carregandoInicial = false; // <- libera para disparar alerta depois

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
    
   /*  function fetchPacienteNomeOnLoad() {
        const prontuarioInput = document.getElementById('prontuario');
        fetchPacienteNome(prontuarioInput.value);
    } */

    //fetchPacienteNomeOnLoad();

    $(document).ready(function() {
        /* $('#idForm').submit(function() {
            $('#janelaAguarde').show();
            setTimeout(function() {
                window.location.href = href;
            }, 1000);
        }); */
        
        $('.select2-dropdown').select2({
                allowClear: true
        });

        $('#motivo_alteracao').select2({
/*             theme: 'bootstrap-5', */
            dropdownParent: $('#modalJustificarAlteracao'), // ESSENCIAL para funcionar dentro do modal
            width: '100%',
            placeholder: 'Selecione uma opção'
        });

        const prontuarioInput = document.getElementById('prontuario');
       /*  prontuarioInput.addEventListener('change', function() {
            fetchPacienteNome(prontuarioInput.value);
        }); */
        let isFetching = false;
        function handleProntuarioInput(event) {
            if (isFetching) return; // Bloqueia se já houver uma requisição em andamento
            if (event.type === 'keydown' && !(event.key === 'Enter' || event.key === 'Tab')) {
                return; // Só processa Enter ou Tab no keydown
            }

            // Marca que a requisição está em andamento
            isFetching = true;

            fetchPacienteNome(prontuarioInput.value);

            // Libera o controle após a execução
            setTimeout(() => {
                isFetching = false;
            }, 300); // Tempo estimado para prevenir disparos rápidos consecutivos
        }

        // Adicionar eventos
        prontuarioInput.addEventListener('change', handleProntuarioInput);
        prontuarioInput.addEventListener('blur', handleProntuarioInput);
        prontuarioInput.addEventListener('keydown', function (event) {
            if (event.key === 'Enter' || event.key === 'Tab') {
                handleProntuarioInput(event);
            }
        });

        // Event listener for when an especialidade is selected
        $('#especialidade').change(function() {
            var selectedEspecialidade = $(this).val();
            
            // Clear previous options
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

            // Reset and update the Select2 component
            $('#fila').val('').trigger('change.select2');
        });

        // Event listener for when a fila is selected
        $('#fila').change(function() {
            var selectedFila = $(this).val();
            var selectedEspecialidade = '';
            
            <?php foreach ($data['filas'] as $fila): ?>
            if (selectedFila === '<?= $fila['id'] ?>') {
                selectedEspecialidade = '<?= $fila['idespecialidade'] ?>';
            }
            <?php endforeach; ?>
            
            // Set the especialidade value and update the Select2 component
            $('#especialidade').val(selectedEspecialidade).trigger('change.select2');
        });

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
