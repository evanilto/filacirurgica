<?= $this->extend('layouts/main_default') ?>

<?= $this->section('content') ?>

        <div class="content" id="content">
            <div class="content-container">
                <?php include 'modal_aguarde.php'; ?>
                <?php include 'modal_detalhes.php'; ?>

                <?= $this->include('layouts/div_flashdata') ?>
                <?= $this->renderSection('subcontent') ?>
            </div>

            <?php use App\Libraries\HUAP_Functions; HUAP_Functions::limpa_msgs_flash(); ?>
        </div>

        <script>
            // Limpar o conteúdo do sidebar
            document.addEventListener('DOMContentLoaded', function() {
                document.querySelector('#sidebar').innerHTML = '';
             });
        </script>

<?= $this->endSection() ?>
