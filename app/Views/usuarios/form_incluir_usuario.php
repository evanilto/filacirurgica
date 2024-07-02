    <form id="UsuarioForm" method="post" action="<?= base_url('usuarios/incluir') ?>">
        <?= csrf_field() ?>
        <?php $validation = \Config\Services::validation(); ?>

        <div class="card">
            
            <div class="card-header text-black"  style="flex: 1; display: flex; justify-content: center; align-items: center;">
                <b><?= 'Incluir Usuario' ?></b>
            </div>
            <div class="card-body has-validation row g-3">
                <div class="col-md-12">
                    <label for="login" class="form-label">Login<b class="text-danger">*</b></label>
                    <div class="input-group mb-12">
                        <input type="text" id="login" maxlength="100"
                            class="form-control <?php if($validation->getError('login')): ?>is-invalid<?php endif ?>"
                            autofocus name="login" value="<?= set_value('login') ?>"/>

                        <?php if ($validation->getError('login')): ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('login') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
           
                <div class="col-md-12" style="margin-top: 3px;">
                    <label for="Setor" class="form-label" autofocus>Setor<b class="text-danger">*</b></label>
                    <div class="input-group mb-12">
                        <select
                            class="form-select <?php if($validation->getError('Setor')): ?>is-invalid<?php endif ?>"
                            id="Setor" name="Setor" onchange=""
                            data-placeholder="Selecione uma opção" data-allow-clear="1">
                            <?php
                            foreach ($selectSetor['Setor'] as $key => $setor) {
                                $setorenconded = $setor['idSetor'].'#'.$setor['nmSetor'].'#'.$setor['origSetor'];
                                $selected = (set_value('Setor') == $setorenconded) ? 'selected' : '';
                                echo '<option value="'.$setorenconded.'" '.$selected.'>'.$setor['nmSetor'].'</option>';
                            }
                            ?>
                        </select>

                        <?php if ($validation->getError('nmSetor')): ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('nmSetor'.$i) ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            
                <div class="col-md-12">
                    <label for="idPerfil" class="form-label">Perfil<b class="text-danger">*</b></label>
                    <div class="input-group mb-12">
                        <select class="form-select <?php if($validation->getError('idPerfil')): ?>is-invalid<?php endif ?>"
                            id="idPerfil" name="idPerfil" onchange="verificarPerfil()"
                            data-placeholder="Selecione uma opção" data-allow-clear="1">
                            <?php
                            foreach ($selectPerfil as $key => $perfil) {
                                $selected = (set_value('idPerfil') == $perfil['id']) ? 'selected' : '';
                                echo '<option value="'.$perfil['id'].'" '.$selected.'>'.$perfil['nmPerfil'].'</option>';
                            }
                            ?>
                        </select>

                        <?php if ($validation->getError('idPerfil')): ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('idPerfil'.$i) ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            
                <div class="col-md-12" id="campoSetorTramite">
                    <label for="SetorTramite" class="form-label" autofocus>Setores Adicionais Permitidos Tramitar<b class="text-danger">*</b></label>
                    <div class="input-group mb-12 bordered-container">
                        <div class="container-setor-tramite" style="max-height: 200px; overflow-y: auto;">
                            <?php
                            foreach ($selectSetorTramite['Setor'] as $key => $setor) {
                                $setorenconded = $setor['idSetor'].'#'.$setor['nmSetor'].'#'.$setor['origSetor'];
                                echo '<div class="form-check"><input class="form-check-input" type="checkbox" id="setorTramite'.$key.'" name="setorTramite[]" value="'.$setorenconded.'" ><label class="form-check-label" for="setorTramite'.$key.'">'.$setor['nmSetor'].'</label></div>';
                            }
                            ?>
                        </div>
                    </div>
                    <?php if ($validation->getError('nmSetor')): ?>
                        <div class="invalid-feedback">
                            <?= $validation->getError('nmSetor'.$i) ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="col-md-12">
                    <label class="form-label">Situação<b class="text-danger">*</b></label>
                    <div class="input-group mb-3 bordered-container">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="indSituacao" id="indSituacaoA" value="A" checked>
                            <label class="form-check-label" for="indSituacaoA" style="margin-right: 10px;">&nbsp;Ativo</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="indSituacao" id="indSituacaoI" value="I">
                            <label class="form-check-label" for="indSituacaoI" style="margin-right: 10px;">&nbsp;Inativo</label>
                        </div>
                    </div>
                </div>
                <hr  />

                <div class="col-md-12" style="margin-top: 2px" >
                    <div class="card-body text-center" style="padding: 10px;">
                        <div class="row">
                            <div class="col-md-6">
                                <button class="btn btn-info mt-0" id="submit" name="submit"  type="submit" value="1"><i class="fa-solid fa-save"></i> Salvar</button>
                            </div>
                            <div class="col-md-6">
                                <a class="btn btn-warning mt-0" href="javascript:history.go(-1)"><i class="fa-solid fa-arrow-left"></i> Voltar</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </form>
    <style>
        .bordered-container {
        border: 1px solid #ccc; /* Cor e espessura da borda */
        border-radius: 5px; /* Opcional: define cantos arredondados */
        padding: 10px; /* Espaçamento interno dentro do contêiner */
        margin-top: 10px; /* Margem superior para empurrar o conteúdo para baixo */
        margin-bottom: 10px; /* Margem inferior para espaço adicional abaixo do campo */
    }
    </style>  
    <script>
        function verificarPerfil() {
            var idPerfil = document.getElementById("idPerfil").value;
            var campoSetorTramite = document.getElementById("campoSetorTramite");
            if (idPerfil == 2) {
                campoSetorTramite.style.display = "block";
            } else {
                campoSetorTramite.style.display = "none";
            }
        } verificarPerfil();

        function atualizarSetoresTramite() {
            var setorSelecionado = document.getElementById("Setor").value.split('#')[0]; // Pega o idSetor do setor selecionado
            var checkboxes = document.querySelectorAll('.container-setor-tramite input[type="checkbox"]');

            checkboxes.forEach(function(checkbox) {
                var checkboxValue = checkbox.value.split('#')[0]; // Pega o idSetor de cada checkbox
                if (checkboxValue === setorSelecionado) {
                    checkbox.parentElement.style.display = 'none'; // Esconde o checkbox do setor selecionado
                } else {
                    checkbox.parentElement.style.display = 'block'; // Mostra os outros checkboxes
                }
            });
        }

        // Adiciona o evento listener para mudanças no campo "Setor"
        document.getElementById("Setor").addEventListener('change', atualizarSetoresTramite);

        // Chama a função imediatamente para aplicar a lógica ao carregar a página
        document.addEventListener('DOMContentLoaded', atualizarSetoresTramite);

    </script>
