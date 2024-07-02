<?= $this->extend('layouts/main_content') ?>

<?= $this->section('subcontent') ?>
    
    <main>

            <div class="row">
                <div class="col">
                    <?= $this->include('layouts/div_flashdata') ?>
                </div>
            </div>

            <div class="row w-100 justify-content-center align-items-center" style="margin-top: 200px;">
                
                    <?= $this->include('prontuarios/form_movimentacoes_setor');?>
            </div>

    </main>

<?= $this->endSection() ?>
