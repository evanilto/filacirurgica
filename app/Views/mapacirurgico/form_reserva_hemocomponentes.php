<?= csrf_field() ?>
<?php

use App\Models\HemocomponentesModel;

 $validation = \Config\Services::validation(); ?>

<style>
    .form-check.with-fields {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: nowrap; /* Impede quebra de linha */
        gap: 10px; /* Dá um pequeno espaçamento entre os elementos */
    }

    .form-check.with-fields .input-group-fields {
        display: flex;
        gap: 10px;
    }

    .form-check.with-fields input[type="number"] {
        width: 100px; /* Ajusta o tamanho dos inputs */
    }

    .d-flex {
        display: flex;
        gap: 10px; /* Ajusta o espaçamento entre os campos */
        align-items: center;
        flex-wrap: nowrap;
    }

    .input-group {
        width: 100%;
    }

    .form-label {
        font-weight: bold;
    }

    .bordered-container {
        border: 1px solid #ddd;
        padding: 10px;
        margin-top: 10px;
        border-radius: 4px;
    }
</style>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card form-container">
                <div class="card-header text-center text-black">
                    <b><?= 'Reservar Hemocomponente' ?></b>
                </div>
                <div class="card-body has-validation">
                    <form id="idForm" method="post" action="<?= base_url('mapacirurgico/confirmarreserva') ?>">
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
                        <div class="row g-3">
                            <div class="col-md-12">
                                <div class="mb-2">
                                    <label class="form-label">Hemocomponentes</label>
                                    <div class="bordered-container p-3">
                                        <div style="max-height: 300px; overflow-y: auto;">
                                            <?php 
                                            $hemocomponentes_json = $data['hemocomponentes_cirurgia_info'] ?? '[]'; 
                                            $hemocomponentes = json_decode($hemocomponentes_json, true) ?? []; 
                                            
                                            usort($hemocomponentes, function ($a, $b) {
                                                return $a['id'] <=> $b['id'];
                                            });
                                            //dd($hemocomponentes);
                                            ?>
                                            <?php if (!empty($hemocomponentes)): ?>
                                                <?php
                                                    $mostrarSelecionarTodos = count($hemocomponentes) > 1;
                                                ?>
                                                <div class="form-check mb-0" <?= !$mostrarSelecionarTodos ? 'style="display: none;"' : '' ?>>
                                                    <input class="form-check-input" type="checkbox" id="selecionarTodos" />
                                                    <label class="form-check-label" for="selecionarTodos">Selecionar Todos</label>
                                                </div>
                                                <!-- Cabeçalhos -->
                                                <div class="d-flex align-items-center mb-2">
                                                    <div style="width: 50%;"></div> <!-- Espaço do checkbox e nome -->
                                                    <div style="width: 25%;" class="text-center">Qtd. Liberada (Bolsa/ml)</div>
                                                    <div style="width: 25%;" class="text-left">Código</div>
                                                </div>

                                                <?php foreach ($hemocomponentes as $item): ?>
                                                    <div class="form-check mb-2 d-flex align-items-center">
                                                        <!-- Checkbox + descrição -->
                                                        <div style="width: 50%;" class="d-flex align-items-center gap-2">
                                                            <!-- Hidden para garantir que mesmo se desmarcado o checkbox, o campo exista -->
                                                            <input type="hidden" name="inddisponibilidade[<?= $item['id'] ?>]" value="0">

                                                            <!-- Checkbox -->
                                                            <input type="checkbox" class="form-check-input toggle-fields mt-0"
                                                                data-id="<?= $item['id'] ?>"
                                                                name="inddisponibilidade[<?= $item['id'] ?>]"
                                                                value="1"
                                                                id="item_<?= $item['id'] ?>"
                                                                <?= !empty($item['inddisponibilidade']) ? 'checked' : '' ?>>

                                                            <!-- Hidden com a descrição do hemocomponente -->
                                                            <input type="hidden" name="descricao[<?= $item['id'] ?>]" value="<?= htmlspecialchars($item['descricao']) ?>">

                                                            <!-- Label visual -->
                                                            <label class="form-check-label mb-0" for="item_<?= $item['id'] ?>">
                                                                <?= htmlspecialchars($item['descricao']) ?>
                                                            </label>
                                                        </div>

                                                        <!-- Quantidade -->
                                                        <div style="width: 25%;" class="text-center">
                                                            <input type="number"
                                                                name="quantidade[<?= $item['id'] ?>]"
                                                                class="form-control"
                                                                id="quantidade_<?= $item['id'] ?>"
                                                                placeholder=""  
                                                                min="0" required
                                                                value="<?= isset($item['quantidade']) ? htmlspecialchars($item['quantidade']) : '' ?>"
                                                                <?= empty($item['inddisponibilidade']) ? 'disabled' : '' ?>>
                                                        </div>

                                                        <!-- Código -->
                                                        <div style="width: 25%;" class="text-center">
                                                            <input type="number"
                                                                name="codigo[<?= $item['id'] ?>]"
                                                                class="form-control"
                                                                id="codigo_<?= $item['id'] ?>"
                                                                placeholder=""
                                                                value="<?= isset($item['codigo']) ? htmlspecialchars($item['codigo']) : '' ?>"
                                                                <?= empty($item['inddisponibilidade']) ? 'disabled' : '' ?>>
                                                        </div>

                                                    </div>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <p>Nenhum hemocomponente disponível.</p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-8">
                                <button class="btn btn-primary mt-3" onclick="return confirma(this);">
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

    function confirma(button) {

        event.preventDefault(); // Previne a submissão padrão do formulário

        Swal.fire({
            title: 'Confirma a reserva do(s) hemocomponente(s) assinalado(s)?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ok',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#janelaAguarde').show();
                $('#idForm').off('submit'); 
                $('#idForm').submit(); 
            } else {
                $('#janelaAguarde').hide(); // Esconde a janela de aguardo se necessário
            }
        });

        return false; // Queremos prevenir o comportamento padrão do link
    }

    document.addEventListener('DOMContentLoaded', function () {
        const checkboxes = document.querySelectorAll('.toggle-fields');

        checkboxes.forEach(function (checkbox) {
            const id = checkbox.dataset.id;
            const quantidade = document.getElementById('quantidade_' + id);
            const codigo = document.getElementById('codigo_' + id);

            // Inicializa corretamente ao carregar
            quantidade.disabled = !checkbox.checked;
            codigo.disabled = !checkbox.checked;

            checkbox.addEventListener('change', function () {
                quantidade.disabled = !this.checked;
                codigo.disabled = !this.checked;
            });
        });
    });

    document.getElementById('selecionarTodos').addEventListener('change', function () {
        const isChecked = this.checked;
        const checkboxes = document.querySelectorAll('.form-check-input.toggle-fields');
        
        checkboxes.forEach(cb => {
            cb.checked = isChecked;
            const id = cb.dataset.id;
            const quantidadeInput = document.getElementById('quantidade_' + id);
            const codigoInput = document.getElementById('codigo_' + id);

            if (quantidadeInput) quantidadeInput.disabled = !isChecked;
            if (codigoInput) codigoInput.disabled = !isChecked;
        });
    });

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

