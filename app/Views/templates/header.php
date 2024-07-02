<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>SAME</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.2/css/bulma.min.css">
        <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <meta name="csrf-token" content="<?= csrf_hash() ?>">
        <!-- Styles and scripts -->
        <link href="<?= base_url('/assets/select2/dist/css/select2.min.css') ?>" rel="stylesheet">
        <link href="<?= base_url('/assets/select2-bootstrap-5-theme-master/dist/select2-bootstrap-5-theme.min.css') ?>" rel="stylesheet">
        <link href="<?= base_url('/assets/css/simple-datatables@latest-style.css') ?>" rel="stylesheet">
        <link href="<?= base_url('/assets/css/bootswatch-flatly-bootstrap.min.css') ?>" rel="stylesheet">
        <link href="<?= base_url('/assets/bootstrap-table-1.19.1/dist/bootstrap-table.min.css') ?>" rel="stylesheet">
        <link href="<?= base_url('/assets/fontawesome/css/all.min.css') ?>" rel="stylesheet">
        <link href="<?= base_url() ?>/css/custom.css" rel="stylesheet">

    </head>
<body>