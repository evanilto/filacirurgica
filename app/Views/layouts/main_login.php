<!DOCTYPE html>
<html>
<head>
    <title><?= HUAP_APPNAME ?></title>
    <meta charset="UTF-8">
    <meta name="description" content="SAME - Sistema de Arquivamento Médico e Estatístico">
    <meta name="author" content="SETISD - evanilto.barros@ebserh.gov.br" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#7952b3">

    <link rel="shortcut icon" type="image/png" href="<?= ENVIRONMENT === 'production' ? base_url('/assets/img/doctor-32.png') : base_url('/favicon.ico') ?>"/>
    <link href="<?= base_url('/assets/bootstrap/dist/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('/assets/css/simple-datatables@latest-style.css') ?>" rel="stylesheet">
    <link href="<?= base_url('/assets/css/bootswatch-flatly-bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('/assets/fontawesome/css/all.min.css') ?>" rel="stylesheet">

    <!-- Favicons -->
    <link rel="apple-touch-icon" href="<?= base_url('/assets/img/doctor/doctor-128.png') ?>" sizes="180x180">
    <link rel="icon" href="<?= base_url('/assets/img/doctor/doctor-32.png') ?>" sizes="32x32" type="image/png">
    <link rel="icon" href="<?= base_url('/assets/img/doctor/doctor-16.png') ?>" sizes="16x16" type="image/png">
    <link rel="icon" href="<?= ENVIRONMENT === 'production' ? base_url('/assets/img/doctor-32.png') : base_url('/favicon.ico') ?>">

    <style>
    .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
    }

    @media (min-width: 768px) {
        .bd-placeholder-img-lg {
            font-size: 3.5rem;
        }
    }
    </style>

    <!-- Custom styles for this template -->
    <link href="<?= base_url('/assets/bootstrap-5.1.3-examples/sign-in/signin.css') ?>" rel="stylesheet">

</head>
<body class="text-center">

    <?= $this->renderSection('content') ?>

    <script src="<?= base_url('/assets/js/jquery.min.js') ?>" crossorigin="anonymous"></script>
    <script src="<?= base_url('/assets/bootstrap-show-password-1.2.1/dist/bootstrap-show-password.min.js') ?>" crossorigin="anonymous"></script>

</body>
</html>
