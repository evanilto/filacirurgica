<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Painel Cirúrgico</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/4.0.1/css/fixedHeader.dataTables.min.css">

    <style>
        body {
            margin: 0;
            padding: 20px;
            font-family: 'Montserrat', sans-serif;
            background-color: #f8f9fa;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        h5 {
            font-size: 1rem;
            margin-bottom: 10px;
        }

        .table-responsive-custom {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        /* Tabela compacta */
        #table {
            width: 100%;
            table-layout: fixed;  /* força colunas a respeitar width */
            font-size: 11px;
            line-height: 1.1;
            border-collapse: collapse;
        }

        #table th, #table td {
            padding: 2px 4px;       /* espaço mínimo */
            text-align: center;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        #table thead th {
            font-size: 11px;
        }

        .break-line {
            white-space: normal;
            word-wrap: break-word;
            word-break: break-word;
        }

        @media (max-width: 768px) {
            #table {
                font-size: 10px;
            }
            #table th, #table td {
                padding: 1px 3px;
            }
        }
    </style>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/fixedheader/4.0.1/js/dataTables.fixedHeader.min.js"></script>
</head>
<body>
    <h5><strong>Painel Cirúrgico - <?= date('d/m/Y', strtotime($data)) ?></strong></h5>

 <div class="table-responsive-custom">
    <table id="table" class="display" style="width:100%;">
        <thead>
            <tr>
                <th>Sala</th>
                <th>Hora Estimada</th>
                <th>No Centro Cirúrgico</th>
                <th>Em Cirurgia</th>
                <th>Saída Sala Cirúrgica</th>
                <th>Centro Cirúrgico</th>
                <th>Especialidade</th>
                <th>Nome do Paciente</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($mapacirurgico as $item): ?>
            <tr>
                <td><?= htmlspecialchars($item->sala) ?></td>
                <td><?= DateTime::createFromFormat('Y-m-d H:i:s', $item->dthrcirurgia)->format('H:i') ?></td>
                <td><?= $item->dthrnocentrocirurgico ? DateTime::createFromFormat('Y-m-d H:i:s', $item->dthrnocentrocirurgico)->format('H:i') : ' ' ?></td>
                <td><?= $item->dthremcirurgia ? DateTime::createFromFormat('Y-m-d H:i:s', $item->dthremcirurgia)->format('H:i') : ' ' ?></td>
                <td><?= $item->dthrsaidasala ? DateTime::createFromFormat('Y-m-d H:i:s', $item->dthrsaidasala)->format('H:i') : ' ' ?></td>
                <td><?= htmlspecialchars($item->centrocirurgico) ?></td>
                <td><?= htmlspecialchars($item->especialidade_descr_reduz) ?></td>
                <td><?= htmlspecialchars($item->nome_paciente) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<style>
    /* Alinha o corpo da tabela à esquerda */
    #table tbody td {
        text-align: left;
        padding: 2px 4px;
        font-size: 12px;
        line-height: 1.1;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* Cabeçalho opcionalmente centralizado */
    #table thead th {
        text-align: left; /* ou 'center' se quiser manter centralizado */
        padding: 2px 4px;
        font-size: 12px;
        white-space: nowrap;
    }
</style>

<script>
    $(document).ready(function() {
        $('#table').DataTable({
            autoWidth: false,
            paging: false,
            ordering: true,
            info: false,
            searching: false,
            order: [[2, 'desc'], [0, 'asc']],
            columnDefs: [
                { width: "50px", targets: 0 },
                { width: "80px", targets: 1 },
                { width: "100px", targets: 2 },
                { width: "100px", targets: 3 },
                { width: "120px", targets: 4 },
                { width: "150px", targets: 5 },
                { width: "150px", targets: 6 },
                { width: "200px", targets: 7 }
            ],
            createdRow: function(row, data) {
                if (!data[2] || data[2].trim() === '') {
                    $(row).css('background-color', '#fff3cd'); 
                } else {
                    $(row).css('background-color', '#c1e9ecff'); 
                }
            }
        });

        setInterval(function() {
            window.location.reload();
        }, 30000);
    });
</script>


</body>
</html>
