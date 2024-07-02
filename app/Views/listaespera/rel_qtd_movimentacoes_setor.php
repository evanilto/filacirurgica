<?= $this->extend('layouts/main_content') ?>

<?= $this->section('subcontent') ?>

<main style="flex: 1; display: flex; justify-content: center; align-items: center;">

    <div class="content" style="width: 100%; padding: 70px; box-sizing: border-box;">

        <div class="row">
            <div class="col">
                <?= $this->include('prontuarios/list_qtd_movimentacoes_setor
                ');?>
            </div>
        </div>

        <div class="card col-md-12">
            <div class="card-body text-center">
                <div class="row">
                    <div class="col-md-2 d-flex justify-content-center <?= $col?>">
                        <a class="btn btn-warning m-2" href="javascript:history.go(-2)" style="height: 40px; width: 113px; text-align: center; margin-right: 10px;">
                            <i class="fa-solid fa-arrow-left"></i> Voltar
                        </a>
                    </div>
                </div>
            </div>
        </div>


    </div>

</main>

<?= $this->endSection() ?>
