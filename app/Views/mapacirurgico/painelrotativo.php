<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Painel Cirúrgico Rotativo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- jQuery e DataTables -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            font-family: 'Montserrat', sans-serif;
        }

        #painel-container {
            width: 100%;
            height: 100vh;
            overflow-x: auto;
            overflow-y: hidden;
            display: flex;
            justify-content: center;
            align-items: flex-start;
        }

        /* CSS para todas as tabelas carregadas */
        #painel-container table {
            border-collapse: collapse;
            width: auto;
            max-width: 100%;
            font-size: 12px;
            line-height: 1.2;
        }

        #painel-container th, 
        #painel-container td {
            padding: 3px 5px;
            border: 1px solid #999;
            text-align: left;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        #painel-container th {
            background-color: #e9ecef;
            color: black;
        }

        #painel-container tr.yellow { background-color: #fff3cd; }
        #painel-container tr.green  { background-color: #c1e9ecff; }

        /* Linha de título superior */
        .titulo-painel {
            width: 100%;
            margin-bottom: 5px;
            border-collapse: collapse;
            background-color: #1b7a81ff;
            color: white;
        }
        .titulo-painel td {
            font-weight: bold;
            padding: 5px;
            border: none;
        }
        .titulo-painel .esquerda { text-align: left; font-size: 0.75rem; }
        .titulo-painel .centro   { text-align: center; font-size: 0.95rem; }
        .titulo-painel .direita  { text-align: right; font-size: 0.75rem; }
    </style>
</head>
<body>

<div id="painel-container">
    <p style="text-align:center; padding-top: 50px;">Carregando Painel...</p>
</div>

<script>
const views = [
    { url: "<?= site_url('mapacirurgico/exibirpainelpacientesnocc') ?>", tempo: 8000, tableId: 'table_nocc' },
    { url: "<?= site_url('mapacirurgico/exibirpainelpacientesaguardando') ?>", tempo: 8000, tableId: 'table_aguardando' }
];

let atual = 0;

function carregarProximaView() {
    const view = views[atual];

    $("#painel-container").load(view.url, function(response, status, xhr) {
        if (status === "error") {
            $("#painel-container").html("<p style='text-align:center;color:red;'>Erro ao carregar a view.</p>");
            console.error("Erro:", xhr.status, xhr.statusText);
            return;
        }

        // Inicializar DataTable na tabela carregada
        const tabela = $('#' + view.tableId);

        if ($.fn.DataTable.isDataTable(tabela)) {
            tabela.DataTable().destroy();
        }

        tabela.DataTable({
            autoWidth: false,
            paging: false,
            ordering: false,
            info: false,
            searching: false,
            fixedHeader: true,
            scrollX: true,
            scrollCollapse: true,
            createdRow: function(row, data) {
                if (!data[2] || data[2].trim() === '') {
                    $(row).css('background-color', '#fff3cd');
                } else {
                    $(row).css('background-color', '#c1e9ecff');
                }
            },
            language: {
                emptyTable: "⚠️ Nenhum registro encontrado ⚠️"
            },
            drawCallback: function(settings) {
                const api = this.api();
                if (!api.data().any()) {
                    tabela.find('thead').hide();
                    tabela.find('.dataTables_empty').css({
                        'background-color': 'transparent',
                        'border': 'none',
                        'text-align': 'center',
                        'font-size': '1rem',
                        'font-weight': 'bold',
                        'padding': '20px 0'
                    });
                } else {
                    tabela.find('thead').show();
                }
            }
        });

        // Alterna para próxima view após o tempo definido
        setTimeout(() => {
            atual = (atual + 1) % views.length;
            carregarProximaView();
        }, view.tempo);
    });
}

$(document).ready(carregarProximaView);
</script>

</body>
</html>
