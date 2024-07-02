<?= $this->extend('layouts/main_content') ?>

<?= $this->section('subcontent') ?>

    <main style="flex: 1; display: flex; justify-content: center; align-items: center; height: 106vh;">

        <div class="content" style="width: 100%; padding: 0px; box-sizing: border-box;">

            <?= $this->include('usuarios/form_editar_usuario');?>

        </div>

    </main>

<?= $this->endSection() ?>
