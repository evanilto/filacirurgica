<!DOCTYPE html>
<html>
    <head>
        <title><?= HUAP_APPNAME ?></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Fila Cirúrgica">
        <meta name="author" content="Evanilto Barros - evanilto.barros@ebserh.gov.br" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="theme-color" content="#7952b3">
        <meta http-equiv="refresh" content="<?= env('huap.session.expires')+1 ?>">

        <!-- Styles and scripts -->
        <link href="<?= base_url('/assets/DataTables/i18n/datatables.min.css') ?>" rel="stylesheet">
        <link href="<?= base_url('/assets/css/bootswatch-flatly-bootstrap.min.css') ?>" rel="stylesheet">
        <link href="<?= base_url('/assets/select2-410-rc0/dist/css/select2.min.css') ?>"  rel="stylesheet">
        <link href="<?= base_url('/assets/bootstrap-table.1.22.5/bootstrap-table.min.css') ?>" rel="stylesheet">
        <link href="<?= base_url('/assets/fontawesome.6.5.2/css/all.min.css') ?>" rel="stylesheet">
        <link href="<?= base_url('/assets/css/custom.css') ?>" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">

        <!-- Favicons -->
        <link href="<?= ENVIRONMENT === 'production' ? base_url('/assets/imgdoctor-2025514_640.png') : base_url('/favicon.ico') ?>" rel="shortcut icon" type="image/png"/>
        <link href="<?= base_url('/assets/img/caduceus/caduceus-128.png') ?>" sizes="180x180" rel="apple-touch-icon">
        <link href="<?= base_url('/assets/img/caduceus/caduceus-32.png') ?>" sizes="32x32" type="image/png" rel="icon">
        <link href="<?= base_url('/assets/img/caduceus/caduceus-16.png') ?>" sizes="16x16" type="image/png" rel="icon">
        <link href="<?= ENVIRONMENT === 'production' ? base_url('/assets/img/doctor-2025514_640.png') : base_url('/favicon.ico') ?>" rel="icon">
        <meta name="csrf-token" content="<?= csrf_hash() ?>">

        <!-- https://datatables.net/download/index - Contém as packages DataTables 2.0.7, jquery 3.7.0 e Buttons 3.0.2 (incluindo Column visibility v3.0.2,  -->
        <!-- HTML5 export v3.0.2 e Print view v3.0.2)                                                                                                        -->
        <script src="<?= base_url('/assets/DataTables/i18n/datatables.min.js') ?>"></script>
        <!----------------------------------------------------------------------------------------------------------------------------------------------------->
        <script src="<?= base_url('/assets/bootstrap.5.3.3/js/bootstrap.bundle.min.js') ?>"></script>
        <script src="<?= base_url('/assets/select2-410-rc0/dist/js/select2.min.js') ?>" crossorigin="anonymous"></script>
        <script src="<?= base_url('/assets/bootstrap-table.1.22.5/bootstrap-table.min.js'); ?>"></script>
        <script src="<?= base_url('/assets/bootstrap-table.1.22.5/locale/bootstrap-table-pt-BR.min.js'); ?>"></script>
        <script src="<?= base_url('/assets/jquery.countdown-2.2.0/jquery.countdown.min.js') ?>" crossorigin="anonymous"></script>
        <script src="<?= base_url('/assets/js/jquery.maskedinput.min.js') ?>" crossorigin="anonymous"></script>
        <script src="<?= base_url('/assets/js/jquery.maskMoney.min.js') ?>" crossorigin="anonymous"></script>
        <script src="<?= base_url('/assets/js/HUAP_ready_jquery.js') ?>" crossorigin="anonymous"></script>
        <script src="<?= base_url('/assets/js/HUAP_jquery.js') ?>" crossorigin="anonymous"></script>
    </head>
    <body>
        <header class="header">
            <?= $this->include('layouts/uppernavbar') ?>
        </header>
        <nav class="nav">
            <?= $this->include('layouts/sidenavbar') ?>
        </nav>
        <main class="main">
            <section class="content" id="content">
                <?= $this->renderSection('content') ?>
            </section>
            <aside class="sidebar" id="sidebar">
                Aguarde...
            </aside>
        </main>
        <footer class="footer">
            <p>&copy; 2024 HUAP-UFF - SETISD/USID - v1.0</p>
        </footer>
    </body>
</html>