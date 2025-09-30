<?= $this->extend('layouts/main_default_painel') ?>

<?= $this->section('content') ?>

        <div class="content" id="content">
                <?php include 'modal_confirmaBootstrap.php'; ?>

                <?= $this->include('layouts/div_flashdata') ?>
                <?= $this->renderSection('subcontent') ?>

            <?php use App\Libraries\HUAP_Functions; HUAP_Functions::limpa_msgs_flash(); ?>
        </div>

        

<?= $this->endSection() ?>
