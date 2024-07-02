<?= $this->extend('layouts/main_content') ?>

<?= $this->section('subcontent') ?>

    <main style="flex: 1; display: flex; justify-content: center; align-items: center;">

        <div class="content-wrapper" style="width: 100%; padding: 80px; box-sizing: border-box; overflow-x: auto;">
            <div class="row">
                <div class="col">
                    <?= $this->include('layouts/div_flashdata') ?>
                </div>
            </div>

            <?php
                use App\Libraries\HUAP_Functions;
                HUAP_Functions::limpa_msgs_flash();
            ?>

            <div class="row" style="margin-top: 100px;">
                <div class="col">
                    <?= $this->include('prontuarios/list_movimentacoes_setor');?>
                </div>
            </div>

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
        function confirma_criar ()
        {
            if (!confirm('Confirma a criação do Volume?')) {
                return false;
            };
            
            return true;
        }
        function confirma_excluir ()
        {
            if (!confirm('Confirma a exclusão do Volume?')) {
                return false;
            };
            
            return true;
        }
    </script>
    
<?= $this->endSection() ?>
