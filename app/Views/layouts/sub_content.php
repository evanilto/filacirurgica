<?= $this->extend('layouts/main_content') ?>

<?= $this->section('subcontent') ?>

    <style>
        .content {
            background: none;
            background-size: cover;
        }
    </style>

    <?= $this->include($view);?>

    <script>
        $(document).ready(function() {
            $('#sidebar').text('');
        });
    </script>

<?= $this->endSection() ?>