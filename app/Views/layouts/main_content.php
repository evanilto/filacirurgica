<?= $this->extend('layouts/main_default') ?>

<?= $this->section('content') ?>

        <style>
            .content {
                background: url('<?= base_url('assets/img/cirurgia-950.png') ?>') no-repeat center center fixed;
                background-size: cover;
            }
        </style>

        <div class="content" id="content">
            <div class="content-container">
                <?= $this->renderSection('subcontent') ?>
            </div>

            <?php use App\Libraries\HUAP_Functions; HUAP_Functions::limpa_msgs_flash(); ?>
            <?php include 'modal_aguarde.php'; ?>
        </div>

        <script>
            $(document).ready(function() {
                $('#idForm').submit(function() {
                    $('#janelaAguarde').show();
                });
            });
        </script>

<?= $this->endSection() ?>
