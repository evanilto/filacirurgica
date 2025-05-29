<?= csrf_field() ?>
<?php $validation = \Config\Services::validation(); ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card form-container">
                <div class="card-header text-center text-black">
                    <b><?= 'Informações do Paciente na Fila Cirúrgica' ?></b>
                </div>
                <div class="card-body has-validation">
                    <form id="idForm" method="post" action="">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <div class="mb-2">
                                    <label for="dtinclusao" class="form-label">Data/Hora de Inclusão</label>
                                    <div class="input-group">
                                        <input type="text" id="dtinclusao" placeholder="DD/MM/AAAA HH:MM:SS" disabled
                                            class="form-control<?php if($validation->getError('dtinclusao')): ?>is-invalid<?php endif ?>"
                                            name="dtinclusao" value="<?= set_value('dtinclusao', $data['dtinclusao']) ?>" disabled/>
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
                            <div class="col-md-6">
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
                            <div class="col-md-3">
                                <div class="mb-2">
                                    <label for="especialidade" class="form-label">Especialidade</label>
                                    <div class="input-group">
                                        <select class="form-select select2-dropdown <?php if($validation->getError('especialidade')): ?>is-invalid<?php endif ?>"
                                            id="especialidade" name="especialidade"
                                            data-placeholder="" data-allow-clear="1" disabled>
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
                            <div class="col-md-3">
                                <div class="mb-2">
                                    <label for="fila" class="form-label">Fila Cirúrgica</label>
                                    <div class="input-group">
                                        <select class="form-select select2-dropdown select2-disabled <?php if($validation->getError('fila')): ?>is-invalid<?php endif ?>"
                                            id="fila" name="fila"
                                            data-placeholder="" data-allow-clear="1" disabled>
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
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label for="procedimento" class="form-label">Procedimento</label>
                                    <div class="input-group">
                                        <select class="form-select select2-dropdown <?php if($validation->getError('procedimento')): ?>is-invalid<?php endif ?>"
                                            id="procedimento" name="procedimento" disabled
                                            data-placeholder="" data-allow-clear="1">
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
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label for="cid" class="form-label">CID</label>
                                    <div class="input-group">
                                        <select class="form-select select2-dropdown <?php if($validation->getError('cid')): ?>is-invalid<?php endif ?>"
                                            id="cid" name="cid" disabled
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
                                        <select class="form-select select2-dropdown <?php if($validation->getError('lateralidade')): ?>is-invalid<?php endif ?>"
                                            id="lateralidade" name="lateralidade" disabled
                                            data-placeholder="" data-allow-clear="1">
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
                                            id="origem" name="origem" disabled
                                            data-placeholder="" data-allow-clear="1">
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
                                <div class="mb-2">
                                    <label for="unidadeorigem" class="form-label">Unidade de Origem</label>
                                    <select class="form-select select2-dropdown <?php if($validation->getError('cid')): ?>is-invalid<?php endif ?>" disabled
                                            id="unidadeorigem" name="unidadeorigem"
                                            data-placeholder="N/D" data-allow-clear="1">
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
                            <div class="col-md-3">
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
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label class="form-label" for="justorig">Justificativa p/ Origem Paciente</label>
                                    <textarea id="justorig" maxlength="255" rows="3" disabled
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
                        </div>
                        <?php if ($data['idexclusao']) { ?>
                            <div class="row g-3">
                                <div class="col-md-2">
                                    <div class="mb-2">
                                        <label for="dtexclusao" class="form-label">Data/Hora da Exclusão</label>
                                        <div class="input-group">
                                            <input type="text" id="dtexclusao" placeholder="DD/MM/AAAA HH:MM:SS" disabled
                                                class="form-control<?php if($validation->getError('dtexclusao')): ?>is-invalid<?php endif ?>"
                                                name="dtexclusao" value="<?= set_value('dtexclusao', $data['dtexclusao']) ?>" disabled/>
                                            <?php if ($validation->getError('dtexclusao')): ?>
                                                <div class="invalid-feedback">
                                                    <?= $validation->getError('dtexclusao') ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-2">
                                        <label for="idexclusao" class="form-label">Justificativa para exclusão</label>
                                        <div class="input-group">
                                            <select class="form-select select2-dropdown <?php if($validation->getError('idexclusao')): ?>is-invalid<?php endif ?>"
                                                id="idexclusao" name="idexclusao" disabled
                                                data-placeholder="" data-allow-clear="1">
                                                <option value="" <?php echo set_select('idexclusao', '', TRUE); ?> ></option>
                                                <?php
                                                foreach ($data['justificativasexclusao'] as $key => $idexclusao) {
                                                    $selected = ($data['idexclusao'] == $idexclusao['id']) ? 'selected' : '';
                                                    echo '<option value="'.$idexclusao['id'].'" '.$selected.'>'.$idexclusao['descricao'].'</option>';
                                                }
                                                ?>
                                            </select>
                                            <?php if ($validation->getError('idexclusao')): ?>
                                                <div class="invalid-feedback">
                                                    <?= $validation->getError('idexclusao') ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <label class="form-label" for="justexclusao">Observações sobre a exclusão</label>
                                        <textarea id="justexclusao" maxlength="255" rows="3" disabled
                                                class="form-control <?= isset($validation) && $validation->getError('justexclusao') ? 'is-invalid' : '' ?>"
                                                name="justexclusao"><?= isset($data['justexclusao']) ? $data['justexclusao'] : '' ?></textarea>
                                        <?php if (isset($validation) && $validation->getError('justexclusao')): ?>
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('justexclusao') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($data['justrecuperacao']) { ?>
                            <div class="row g-3">
                                <div class="col-md-2">
                                    <div class="mb-2">
                                        <label for="dtrecuperacao" class="form-label">Data/Hora da Recuperação</label>
                                        <div class="input-group">
                                            <input type="text" id="dtrecuperacao" placeholder="DD/MM/AAAA HH:MM:SS" disabled
                                                class="form-control<?php if($validation->getError('dtrecuperacao')): ?>is-invalid<?php endif ?>"
                                                name="dtrecuperacao" value="<?= set_value('dtrecuperacao', $data['dtrecuperacao']) ?>" disabled/>
                                            <?php if ($validation->getError('dtrecuperacao')): ?>
                                                <div class="invalid-feedback">
                                                    <?= $validation->getError('dtrecuperacao') ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <div class="mb-2">
                                        <label class="form-label" for="justrecuperacao">Justificativa para recuperação</label>
                                        <textarea id="justrecuperacao" maxlength="255" rows="3" disabled
                                                class="form-control <?= isset($validation) && $validation->getError('justrecuperacao') ? 'is-invalid' : '' ?>"
                                                name="justrecuperacao"><?= isset($data['justrecuperacao']) ? $data['justrecuperacao'] : '' ?></textarea>
                                        <?php if (isset($validation) && $validation->getError('justrecuperacao')): ?>
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('justrecuperacao') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="row g-3">
                            <div class="col-md-12">
                                <a class="btn btn-warning mt-3" href="<?= base_url('listaespera/exibirsituacao') ?>">
                                    <i class="fa-solid fa-arrow-left"></i> Voltar
                                </a>
                            </div>
                        </div>

                        <input type="hidden" name="id" value="<?= $data['id'] ?>" />
                        <input type="hidden" name="ordemfila" id="ordemfila" value="<?= $data['ordemfila'] ?>" />
                        <input type="hidden" name="dtinclusao" value="<?= $data['dtinclusao'] ?>" />
                        <input type="hidden" name="prontuario" value="<?= $data['prontuario'] ?>" />
                        <input type="hidden" name="especialidade" id="especialidade-hidden" value="<?php echo $data['especialidade']; ?>">
                        <input type="hidden" name="fila" id="fila-hidden" value="<?php echo $data['fila']; ?>">
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    window.onload = function() {
        // Adiciona o listener de "keydown" a todos os elementos de entrada
        const inputs = document.querySelectorAll('input, textarea, select, .form-check-input');
        inputs.forEach(input => {
            input.addEventListener('keydown', disableEnter);
        });
    };

    function voltarERecarregar() {
        const previousPage = sessionStorage.getItem('previousPage');
        if (previousPage) {
            window.location.href = previousPage; // Redireciona para a página anterior
        } else {
            window.history.back(); // Usa o histórico se não houver página armazenada
        }
    }
    /* $('#especialidade').on('select2:opening', function(e) {
        e.preventDefault();  // Impede a abertura do dropdown
    }); */
    /* $('#fila').on('select2:opening', function(e) {
        e.preventDefault();  // Impede a abertura do dropdown
    }); */

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
    
    function loadAsideContent(prontuario, ordem, fila) {
        $.ajax({
            url: '<?= base_url('listaespera/carregaaside/') ?>' + prontuario + '/' + ordem + '/' + fila,
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

        document.getElementById('idForm').addEventListener('submit', function(event) {
            $('#janelaAguarde').show();
        });
    });
</script>
