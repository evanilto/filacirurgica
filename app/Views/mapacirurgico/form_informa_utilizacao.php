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
        <div class="col-md-10">
            <div class="card form-container">
                <div class="card-header text-center text-black">
                    <b><?= 'Informar Quantidade Utilizada' ?></b>
                </div>
                <div class="card-body has-validation">
                    <form id="formUtilizacao" method="post" action="<?= base_url('mapacirurgico/registrarutilizacao') ?>">
                        <div class="bordered-container p-3">
                            <div style="max-height: 300px; overflow-y: auto;">
                                <?php 
                                $hemocomponentes_json = $data['hemocomponentes_cirurgia_info'] ?? '[]'; 
                                $hemocomponentes = json_decode($hemocomponentes_json, true) ?? []; 

                                usort($hemocomponentes, fn($a, $b) => $a['id'] <=> $b['id']);

                                //dd($hemocomponentes);
                                ?>
                                <?php if (!empty($hemocomponentes)): ?>
                                    <!-- Cabeçalhos -->
                                    <div class="d-flex align-items-center mb-2 fw-bold">
                                        <div style="width: 35%;" class="text-center">Hemocomponente</div>
                                        <div style="width: 20%;" class="text-center">Código</div>
                                        <div style="width: 20%;" class="text-center">Qtd. Liberada</div>
                                        <div style="width: 20%;" class="text-center">Qtd. Utilizada</div>
                                    </div>

                                    <?php foreach ($hemocomponentes as $item): ?>
                                        <div class="form-check mb-2 d-flex align-items-center">
                                            <div style="width: 35%;">
                                                <?= htmlspecialchars($item['descricao']) ?>
                                                <input type="hidden" name="id[<?= $item['id'] ?>]" value="<?= $item['id'] ?>">
                                            </div>

                                            <div style="width: 20%;" class="text-center">
                                                <input type="number" class="form-control" disabled
                                                    value="<?= isset($item['codigo']) ? htmlspecialchars($item['codigo']) : '' ?>">
                                            </div>

                                            <div style="width: 20%;" class="text-center">
                                                <input type="number" class="form-control" disabled
                                                    value="<?= isset($item['quantidade']) ? htmlspecialchars($item['quantidade']) : '' ?>">
                                            </div>

                                            <div style="width: 20%;" class="text-center">
                                                <?php if (!empty($item['inddisponibilidade'])): ?>
                                                    <input type="number"
                                                        step="0.01"
                                                        name="quantidade_utilizada[<?= $item['id'] ?>]"
                                                        class="form-control"
                                                        placeholder=""
                                                        value="<?= isset($item['quantidade_utilizada']) ? htmlspecialchars($item['quantidade_utilizada']) : '' ?>"
                                                        min="0" required>
                                                <?php else: ?>
                                                    <input type="number" class="form-control" placeholder="" disabled>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <p>Nenhum hemocomponente disponível.</p>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button class="btn btn-primary">
                                <i class="fa-solid fa-save"></i> Salvar
                            </button>
                            <a class="btn btn-warning" href="<?= base_url('mapacirurgico/exibircirurgiacomhemocomps') ?>">
                                <i class="fa-solid fa-arrow-left"></i> Voltar
                            </a>
                        </div>
                        <!-- <div class="row g-3">
                            <div class="col-md-8">
                                <button class="btn btn-primary mt-3" onclick="return confirma(this);">
                                <i class="fa-solid fa-floppy-disk"></i> Salvar
                                </button>
                                <a class="btn btn-warning mt-3" id="btnVoltar" data-link="<-?= base_url('mapacirurgico/exibircirurgiacomhemocomps'); ?>">
                                    <i class="fa-solid fa-arrow-left"></i> Voltar
                                </a>
                            </div>
                            </div>
                        </div> -->
                        <input type="hidden" name="idmapa" value="<?= $data['idmapa'] ?>" />
                        <input type="hidden" name="idlista" value="<?= $data['idlista'] ?>" />
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

