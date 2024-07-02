<?= $this->extend('layouts/main_content') ?>

<?= $this->section('subcontent') ?>

    <main style="flex: 1; display: flex; justify-content: center; align-items: center;">

        <div class="content" style="width: 100%; box-sizing: border-box;">
            <div class="row">
                <div class="col">
                    <?= $this->include('layouts/div_flashdata') ?>
                </div>
            </div>

            <div style="display: flex; justify-content: center; align-items: center; height: 90vh;">
                <div style="width: 45%;"> <!-- Ajuste a largura conforme necessário -->
                    <?= $this->include('prontuarios/form_prontuario');?>
                </div>
            </div>
        </div>

    </main>

<?= $this->endSection() ?>
