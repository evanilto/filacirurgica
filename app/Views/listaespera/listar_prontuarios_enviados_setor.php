<?= $this->extend('layouts/main_content') ?>

<?= $this->section('subcontent') ?>

    <main style="flex: 1; display: flex; justify-content: center; align-items: center;">

        <div class="content" style="width: 80%; padding: 80px; box-sizing: border-box;">

            <div class="row">
                <div class="col">
                    <?= $this->include('layouts/div_flashdata') ?>
                </div>
            </div>

            <?= $this->include('prontuarios/list_prontuarios_enviados_setor');?>

            <div class="card col-md-12">
                <div class="card-body text-center">
                    <div class="row">
                        <div class="col-md-2 d-flex justify-content-center offset-md-4">
                            <button class="btn btn-info m-2" id="btnreceber" name="btnreceber" type="submit" style="height: 40px; width: 113px; text-align: center; margin-right: 10px;">
                                <i class="fas fa-arrow-down"></i> Receber
                            </button>
                        </div>
                        <div class="col-md-2 d-flex justify-content-center">
                            <a class="btn btn-warning m-2" href="javascript:history.go(-1)" style="height: 40px; width: 100px; text-align: center; margin-right: 10px;">
                                <i class="fa-solid fa-arrow-left"></i> Voltar
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </main>

    <script>
        function marcarDesmarcarCheckboxes() {
            var checkboxes = document.querySelectorAll('#table input[type="checkbox"]');
            var botao = document.querySelector('button');

            for (var i = 0; i < checkboxes.length; i++) {
                checkboxes[i].checked = !checkboxes[i].checked;
            }
        }
        document.getElementById("btnreceber").addEventListener("click", function () {
            if (!confirm('Tem certeza que deseja receber esse(s) documento(s)?')) {
                return false;
            }

            $('#janelaAguarde').show();

            var checkboxes = document.querySelectorAll('#table input[type="checkbox"]:checked');
            var prontuarios = [];
            checkboxes.forEach(function (checkbox) {
                var prontuarioObj = JSON.parse(checkbox.value);
                prontuarios.push(prontuarioObj);
            });

            window.location.href = "<?= base_url('prontuarios/receberemlote') ?>" + "?prontuarios=" + encodeURIComponent(JSON.stringify(prontuarios));
            
        });
    </script>
    

<?= $this->endSection() ?>
