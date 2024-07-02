<?= $this->extend('layouts/main_content') ?>

<?= $this->section('subcontent') ?>

    <main style="flex: 1; display: flex; justify-content: center; align-items: center;">

        <div class="content" style="width: 70%; padding: 80px; box-sizing: border-box;">

            <div class="row">
                <div class="col">
                    <?= $this->include('layouts/div_flashdata') ?>
                </div>
            </div>

            <?= $this->include('prontuarios/form_recupera_prontuario');?>

        </div>

    </main>

<?= $this->endSection() ?>
