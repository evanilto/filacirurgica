<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Painel Cirúrgico Rotativo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- jQuery e DataTables -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link href="<?= base_url('/assets/fontawesome.6.5.2/css/all.min.css') ?>" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <style>
        /* reset e box-sizing para evitar cálculos estranhos de largura */
        *, *::before, *::after { box-sizing: border-box; }

        html, body {
            height: 100%;
            width: 100%;
            margin: 0;
            padding: 0;
            overflow: hidden; /* evita scroll da página principal */
            background-color: #f8f9fa;
            font-family: 'Montserrat', sans-serif;
        }

        /* container ocupa toda tela */
        #painel-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            margin: 0;
            padding: 0;
            overflow: hidden;
            background-color: #f8f9fa;
        }

        /* Força todo conteúdo carregado a ocupar 100% da largura disponível.
           Isso sobrescreve classes internas das views (ex: .table-wrapper, .titulo-tabela). */
        #painel-container,
        #painel-container .table-wrapper,
        #painel-container .titulo-tabela,
        #painel-container .painel-rotativo,
        #painel-container .dataTables_wrapper,
        #painel-container .dataTables_scroll,
        #painel-container .dataTables_scrollHead,
        #painel-container .dataTables_scrollBody,
        #painel-container table {
            width: 100% !important;
            max-width: none !important;
            margin: 0 !important;
            padding: 0 !important;
            box-sizing: border-box !important;
        }

        /* Garante que a tabela ocupe a largura do container e não crie scroll horizontal extra */
        #painel-container table {
            border-collapse: collapse;
            height: 100%;
            font-size: 7px !important;
            line-height: 1.2;
            table-layout: fixed; /* tenta respeitar col widths do colgroup quando houver */
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

        /* visual helpers */
        #painel-container tr.yellow { background-color: #fff3cd; }
        #painel-container tr.green  { background-color: #c1e9ecff; }

        .titulo-painel td { font-weight: bold; padding: 5px; border: none; }
        .titulo-painel .esquerda { text-align: left; font-size: 0.75rem; }
        .titulo-painel .centro   { text-align: center; font-size: 0.95rem; }
        .titulo-painel .direita  { text-align: right; font-size: 0.75rem; }

        /* fullscreen class visual */
        .fullscreen-active {
            width: 100vw !important;
            height: 100vh !important;
            overflow: hidden !important;
        }
    </style>
</head>
<body>
<?php setcookie("SishuapCookie", "", 0); ?>

<div id="painel-container">
    <p style="text-align:center; padding-top: 50px;">Carregando Painel...</p>
</div>

<script>
const views = [
    { url: "<?= site_url('mapacirurgico/exibirpainelpacientesnocc') ?>", tempo: 40000, tableId: 'table_nocc' },
    { url: "<?= site_url('mapacirurgico/exibirpainelpacientesaguardando') ?>", tempo: 15000, tableId: 'table_aguardando' }
];

let atual = 0;

/* Função que anula estilos "problemáticos" vindos da view carregada */
function normalizarLayoutCarregado(container) {
    // forçar largura e remover centralizações internas
    container.find('.table-wrapper').css({ width: '100%', margin: '0', padding: '0', display: 'block' });
    container.find('.titulo-tabela').css({ width: '100%', margin: '0', padding: '0' });
    container.find('.painel-rotativo').css({ width: '100%', margin: '0', padding: '0', display: 'block' });

    // caso a view adicione um wrapper com padding ou max-width
    container.find('[style]').each(function(){
        const el = $(this);
        const style = (el.attr('style') || '').toLowerCase();
        // remove larguras fixas inline que possam centralizar/encolher
        if (style.indexOf('width:') !== -1 && el.is('div, section, main')) {
            el.css('width', '100%');
            el.css('max-width', 'none');
            el.css('margin', '0');
        }
    });
}

/* Carrega a próxima view e inicializa DataTables */
function carregarProximaView() {
    const view = views[atual];

    $("#painel-container").load(view.url, function(response, status, xhr) {
        if (status === "error") {
            $("#painel-container").html("<p style='text-align:center;color:red;'>Erro ao carregar a view.</p>");
            console.error("Erro:", xhr.status, xhr.statusText);
            return;
        }

        const container = $("#painel-container");

        // Normaliza o layout (sobrescreve .table-wrapper etc)
        normalizarLayoutCarregado(container);

        // Garantir que a tabela visível ocupe 100% e não tenha margem
        container.find('table').css({ width: '100%' });

        // Inicializa DataTable na tabela carregada (se existir)
        const tabela = $('#' + view.tableId);
        if (tabela.length) {
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
                scrollX: false, // desative se quiser que ocupe toda largura
                scrollCollapse: false,
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

            // Força ajuste das colunas para ocupar toda largura disponível
            tabela.DataTable().columns.adjust().draw(false);

            // Remove wrappers do DataTables que limitam a largura (safety)
            container.find('.dataTables_wrapper').css({ width: '100%' });
            container.find('.dataTables_scrollHead, .dataTables_scrollBody').css({ width: '100%' });
        }

        // Alterna para próxima view após o tempo definido
        setTimeout(() => {
            atual = (atual + 1) % views.length;
            carregarProximaView();
        }, view.tempo);
    });
}

/* Função para tentar ativar fullscreen (kiosk preferível; senão primeiro clique) */
function ativarFullscreenAutomatico() {
    const painel = document.documentElement; // usar documento inteiro
    setTimeout(() => {
        if (!document.fullscreenElement && painel.requestFullscreen) {
            painel.requestFullscreen().catch(() => {});
            document.body.classList.add('fullscreen-active');
        }
    }, 800);

    // fallback: no primeiro clique, entra em fullscreen
    document.addEventListener('click', () => {
        if (!document.fullscreenElement && painel.requestFullscreen) {
            painel.requestFullscreen().catch(() => {});
            document.body.classList.add('fullscreen-active');
        }
    });

    document.addEventListener('fullscreenchange', () => {
        if (!document.fullscreenElement) {
            document.body.classList.remove('fullscreen-active');
        }
    });
}

/* Inicialização */
$(document).ready(function() {
    ativarFullscreenAutomatico();
    carregarProximaView();
});
</script>

</body>
</html>
