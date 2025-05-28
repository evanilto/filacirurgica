<?= $this->extend('layouts/main_default') ?>

<?= $this->section('content') ?>

        <div class="content" id="content">
                <?php include 'modal_aguarde.php'; ?>
                <?php include 'modal_detalhes.php'; ?>
                <?php include 'modal_confirmaBootstrap.php'; ?>

                <?= $this->include('layouts/div_flashdata') ?>
                <?= $this->renderSection('subcontent') ?>

            <?php use App\Libraries\HUAP_Functions; HUAP_Functions::limpa_msgs_flash(); ?>
        </div>

        

<?= $this->endSection() ?>
