<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Guia de Requisição Transfusional</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10.5px;
            margin: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }
        td, th {
            border: 1px solid #333;
            padding: 4px;
            vertical-align: top;
        }
        .section-title {
            background: #eee;
            font-weight: bold;
            text-align: center;
        }
        .small {
            font-size: 9px;
        }
        .page-break {
            page-break-after: always;
        }

    </style>
</head>
<body>

    <?php include(APPPATH . 'Views/transfusao/pdf_template_frente.php'); ?>

    <div class="page-break"></div>

    <?php include(APPPATH . 'Views/transfusao/pdf_template_verso.php'); ?>

</body>
</html>
