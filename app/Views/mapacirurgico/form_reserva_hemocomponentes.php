<?= csrf_field() ?>
<?php

use App\Models\HemocomponentesModel;

 $validation = \Config\Services::validation(); ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card form-container">
                <div class="card-header text-center text-black">
                    <b><?= 'Reservar Hemocomponente' ?></b>
                </div>
                <div class="card-body has-validation">
                    <form id="idForm" method="post" action="<?= base_url('mapacirurgico/atualizarhorarios') ?>">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <div class="mb-2">
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
                            <div class="col-md-7">
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
                        <?php 
                        $hemocomponentes_json = $data['hemocomponentes_cirurgia_info'] ?? '[]'; 
                        $hemocomponentes = json_decode($hemocomponentes_json, true) ?? []; 
                        ?>
                        <div class="row g-3">
                            <div class="col-md-12">
                                <div class="mb-2">
                                    <label for="perfis" class="form-label" autofocus>Hemocomponentes</label>
                                    <div class="bordered-container p-3"> <!-- Container começa aqui -->
                                        <div style="max-height: 300px; overflow-y: auto;"> 
                                        <!-- <pre><-?php print_r($hemocomponentes); ?></pre> -->
                                            <?php if (!empty($hemocomponentes)): ?>
                                                <?php foreach ($hemocomponentes as $item): ?>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" 
                                                            name="inddisponibilidade[<?= $item['idhemocomponente'] ?>]" 
                                                            value="1" 
                                                            id="item_<?= $item['idhemocomponente'] ?>" 
                                                            <?= !empty($item['inddisponibilidade']) ? 'checked' : '' ?>>
                                                        <label class="form-check-label" for="item_<?= $item['idhemocomponente'] ?>">
                                                            <?= htmlspecialchars($item['descricao']) ?>
                                                        </label>
                                                    </div>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <p>Nenhum hemocomponente disponível.</p>
                                            <?php endif; ?>
                                        </div>
                                    </div> <!-- Container termina aqui -->
                                </div>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-8">
                                <button class="btn btn-primary mt-3" id="submit" name="submit" type="submit" value="1">
                                <i class="fa-solid fa-floppy-disk"></i> Salvar
                                </button>
                                <a class="btn btn-warning mt-3" id="btnVoltar" data-link="<?= base_url('mapacirurgico/exibircirurgiacomhemocomps'); ?>">
                                    <i class="fa-solid fa-arrow-left"></i> Voltar
                                </a>
                            </div>
                            </div>
                        </div>
                        <input type="hidden" name="idmapa" value="<?= $data['idmapa'] ?>" />
                        <input type="hidden" name="idlista" value="<?= $data['idlista'] ?>" />
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
        
        $('.select2-dropdown').select2({
            allowClear: true
        });

        const prontuarioInput = document.getElementById('prontuario');
        prontuarioInput.addEventListener('change', function() {
            fetchPacienteNome(prontuarioInput.value);
        });

    });
</script>

