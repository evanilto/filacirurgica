<?= $this->extend('layouts/main_content') ?>

<?= $this->section('subcontent') ?>

    <main style="flex: 1; display: flex; justify-content: center; align-items: center; height: 100vh;">

        <div class="content" style="width: 70%; padding: 180px; box-sizing: border-box;">

            <?= $this->include('prontuarios/form_editar_prontuario');?>

        </div>

    </main>

<?= $this->endSection() ?>
