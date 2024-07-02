<?= $this->extend('layouts/main_content') ?>

<?= $this->section('subcontent') ?>

<hr>
<style>
    .data-hidden {
    display: none;
    }

    @media print {
        @page {
            size: A4 portrait;
            margin: 0;
            margin-top: 20px; /* Adiciona uma margem superior à tabela */
            margin-bottom: 20px; /* Adiciona uma margem superior à tabela */
        }

        .page-break {
        page-break-before: always; /* Quebra de página antes do elemento */
        }

        .no-page-break {
        page-break-before: avoid; /* sem Quebra de página antes do elemento */
        }

        .data-hidden {
        display: none !important;
        }

        table th.col-left, table td.col-left {
        text-align: left !important;
        margin-left: 0;
        }
        /* Ocultar elementos não desejados durante a impressão */
        header, footer, aside, .sidebar, .navbar, .non-printable {
            display: none;
        }

        .no-print {
        display: none; /* Ocultar elementos com a classe no-print durante a impressão */
        }

        /* Mostrar apenas a tabela */
        .printable {
            display: block;
        }

        /* Quebras de página para a tabela */
        html, body, .main-content, .tabs, .tabbed-content { 
            float: none; 
            margin: 0;
            padding: 0;
            width: 100%;
        }

        .tab {
            display: block; /* unhide all tabs */
            break-before: always;
            page-break-before: always;
        }

        tr.tab { 
        display: none; /* Oculta as linhas adicionais de quebra de página */ 
        }

        table {
            page-break-inside: auto;
            width: 100%;
            border-collapse: collapse; /* Remove gaps between table cells */
            page-break-inside: avoid;
        }

        tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }

        thead {
            display: table-header-group;
        }

        tfoot {
            display: table-footer-group;
        }

        body {
            margin: 0;
            padding: 0;
        }

       /*  tr:nth-child(18n) {
            page-break-after: always;
        } */
    }
</style>

<main style="flex: 1; display: flex; justify-content: center; align-items: center;">

    <div class="content" style="width: 100%; padding: 80px; box-sizing: border-box;">

        <?= $this->include('prontuarios/list_prontuarios_retidos_print');?>

    </div>
</main>

<?= $this->endSection() ?>
