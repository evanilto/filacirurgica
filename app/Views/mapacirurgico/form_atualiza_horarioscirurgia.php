<?= csrf_field() ?>
<?php $validation = \Config\Services::validation(); ?>

<div class="container" style="padding-top: 0; margin-top: -30px">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card form-container">
                <div class="card-header text-center text-black">
                    <b><?= 'Atualizar Horários da Cirurgia' ?></b>
                </div>
                <div class="card-body has-validation">
                    <form id="idForm" method="post" action="<?= base_url('mapacirurgico/atualizarhorarios') ?>">
                        <div class="row g-3">
                            <div class="col-md-2">
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
                            <div class="col-md-10">
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
                            <div class="col-md-4">
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
                            <div class="col-md-8">
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
                            <div class="col-md-12">
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
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="dthrcirurgia" class="form-label">Data/Hora da Cirurgia</label>
                                    <div class="input-group">
                                        <input type="text" id="dthrcirurgia" placeholder="DD/MM/YYYY HH:MM"
                                            class="form-control <?php if($validation->getError('dthrcirurgia')): ?>is-invalid<?php endif ?>"
                                            name="dthrcirurgia" value="<?= set_value('dthrcirurgia', $data['dthrcirurgia']) ?>" disabled />
                                        <?php if ($validation->getError('dthrcirurgia')): ?>
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('dthrcirurgia') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label for="hrnocentrocirurgico" class="form-label">Entrada C. Cirúrgico</label>
                                    <div class="input-group">
                                        <input type="text" id="hrnocentrocirurgico" placeholder="HH:MM"
                                            class="form-control <?php if($validation->getError('hrnocentrocirurgico')): ?>is-invalid<?php endif ?>"
                                            name="hrnocentrocirurgico" value="<?= set_value('hrnocentrocirurgico', $data['hrnocentrocirurgico']) ?>" />
                                        <?php if ($validation->getError('hrnocentrocirurgico')): ?>
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('hrnocentrocirurgico') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label for="hremcirurgia" class="form-label">Em Cirurgia</label>
                                    <div class="input-group">
                                        <input type="text" id="hremcirurgia" placeholder="HH:MM"
                                            class="form-control <?php if($validation->getError('hremcirurgia')): ?>is-invalid<?php endif ?>"
                                            name="hremcirurgia" value="<?= set_value('hremcirurgia', $data['hremcirurgia']) ?>" />
                                        <?php if ($validation->getError('hremcirurgia')): ?>
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('hremcirurgia') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label for="hrsaidasala" class="form-label">Saída da Sala</label>
                                    <div class="input-group">
                                        <input type="text" id="hrsaidasala" placeholder="HH:MM"
                                            class="form-control <?php if($validation->getError('hrsaidasala')): ?>is-invalid<?php endif ?>"
                                            name="hrsaidasala" value="<?= set_value('hrsaidasala', $data['hrsaidasala']) ?>" />
                                        <?php if ($validation->getError('hrsaidasala')): ?>
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('hrsaidasala') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label for="hrsaidacentrocirurgico" class="form-label">Saída do C. Cirúrgico</label>
                                    <div class="input-group">
                                        <input type="text" id="hrsaidacentrocirurgico" placeholder="HH:MM"
                                            class="form-control <?php if($validation->getError('hrsaidacentrocirurgico')): ?>is-invalid<?php endif ?>"
                                            name="hrsaidacentrocirurgico" value="<?= set_value('hrsaidacentrocirurgico', $data['hrsaidacentrocirurgico']) ?>" />
                                        <?php if ($validation->getError('hrsaidacentrocirurgico')): ?>
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('hrsaidacentrocirurgico') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-12">
                                <button class="btn btn-primary mt-3" id="submit" name="submit" type="submit" value="1">
                                <i class="fa-solid fa-floppy-disk"></i> Salvar
                                </button>
                                <a class="btn btn-warning mt-3" href="<?= base_url('mapacirurgico/mostrarmapa') ?>">
                                    <i class="fa-solid fa-arrow-left"></i> Voltar
                                </a>
                            </div>
                        </div>

                        <input type="hidden" name="idmapa" value="<?= $data['idmapa'] ?>" />
                        <input type="hidden" name="dthrcirurgia" id='dthrcirurgia' value="<?= $data['dthrcirurgia'] ?>" />
                        <input type="hidden" name="ordemfila" id='ordemfila'  value="<?= $data['ordemfila'] ?>" />
                        <input type="hidden" name="prontuario" value="<?= $data['prontuario'] ?>" />
                        <input type="hidden" name="especialidade" value="<?= $data['especialidade'] ?>" />
                        <input type="hidden" name="fila" id="fila-hidden" value="<?= $data['fila'] ?>" />
                        <input type="hidden" name="procedimento" value="<?= $data['procedimento'] ?>" />
                       
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

