<?= $this->extend('layouts/main_content') ?>

<?= $this->section('subcontent') ?>

    <style>
        .content {
            background: none;
            background-size: cover;
        }
    </style>

    <div class="row">
        <div class="col">
            <?= $this->include('layouts/div_flashdata') ?>
        </div>
    </div>

    <?= $this->include($view);?>

    <script>
        $(document).ready(function() {
            $('#sidebar').text('');
        });
    </script>

<?= $this->endSection() ?>