<?= $this->extend('layouts/main_content') ?>

<?= $this->section('subcontent') ?>

    <main style="flex: 1; display: flex; justify-content: center; align-items: center;">

        <div class="content" style="width: 80%; padding: 80px; box-sizing: border-box;">
            <div class="row">
                <div class="col">
                    <?= $this->include('layouts/div_flashdata') ?>
                </div>
            </div>

            <?= $this->include('prontuarios/list_solicitacoes_externas');?>

            <div class="card col-md-12">
                <div class="card-body text-center">
                    <div class="row">
                        <div class="col-md-12 d-flex justify-content-center">
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
        function confirma ()
        {
            if (!confirm('Confirma a exclusão da solicitação?')) {
                return false;
            };
            
            return true;
        }
    </script>
    

<?= $this->endSection() ?>
