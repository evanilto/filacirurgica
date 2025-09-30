<?php
    use App\Libraries\HUAP_Functions;
?>
 
<link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/4.0.1/css/fixedHeader.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/5.0.4/css/fixedColumns.dataTables.min.css">

<style>
.painel-cirurgico-wrapper table th,
.painel-cirurgico-wrapper table td {
    font-size: 12px;
    padding: 4px 6px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    vertical-align: middle;
}

.painel-cirurgico-wrapper .break-line {
    white-space: normal;
    word-break: break-word;
}

.painel-cirurgico-wrapper tbody tr.lineselected {
    background-color: #d6f0dc !important;
}

.painel-cirurgico-wrapper tbody tr.equipamento-excedente {
    background-color: hsl(60, 100%, 90%) !important;
}

.painel-cirurgico-wrapper tbody tr.hemocomponente-indisponivel {
    background-color: hsl(0, 100%, 90%) !important;
}

.painel-cirurgico-wrapper tbody tr.combinado {
    background-color: hsl(30, 100%, 80%) !important;
}

/* Cabeçalho da segunda tabela */
.painel-cirurgico-wrapper .data-table thead th {
    font-size: 1rem; /* Fonte maior para o título da tabela */
    font-weight: bold;  
    text-align: center; 
}

/* Linhas da tabela */
.painel-cirurgico-wrapper .data-table tbody td {
    font-size: 0.95rem; /* Fonte proporcional às linhas */
}
/* Cabeçalho da segunda tabela */
#table thead th {
    font-size: 1rem; /* Ajuste para o tamanho desejado */
    font-weight: bold;
    text-align: center;
}

/* Linhas da tabela */
#table tbody td {
    font-size: 0.9rem !important; /* Força a fonte das linhas */
}
</style>

<!-- Wrapper exclusivo para o painel cirúrgico -->
<div class="painel-cirurgico-wrapper" style="width:100%; text-align:center; margin-top:10px;">

    <!-- Conteúdo interno com largura máxima -->
    <div style="display:inline-block; width:100%; max-width:1200px; text-align:left;">

        <!-- Título centralizado -->
        <h5 style="text-align:left; margin-bottom:15px;">
            <strong>Painel Cirúrgico - <?= date('d/m/Y') ?></strong>
        </h5>

        <!-- Tabela -->
        <div style="overflow-x:auto;">
            <table id="table" class="table table-hover table-bordered table-striped data-table">
                <thead>
                    <tr>
                        <th style="width:40px;">Sala</th>
                        <th style="width:80px;">Hora Estimada</th>
                        <th style="width:50px;">No Centro Cirúrgico</th>
                        <th style="width:50px;">Em Cirurgia</th>
                        <th style="width:50px;">Saída Sala Cirúrgica</th>
                        <th style="width:120px;">Centro Cirúrgico</th>
                        <th style="width:120px;">Especialidade</th>
                        <th style="width:180px;">Nome do Paciente</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($mapacirurgico as $itemmapa): ?>
                        <tr>
                            <td class="break-line"><?= htmlspecialchars($itemmapa->sala) ?></td>
                            <td><?= DateTime::createFromFormat('Y-m-d H:i:s', $itemmapa->dthrcirurgia)->format('H:i') ?></td>
                            <td><?= $itemmapa->dthrnocentrocirurgico ? DateTime::createFromFormat('Y-m-d H:i:s', $itemmapa->dthrnocentrocirurgico)->format('H:i') : ' ' ?></td>
                            <td><?= $itemmapa->dthremcirurgia ? DateTime::createFromFormat('Y-m-d H:i:s', $itemmapa->dthremcirurgia)->format('H:i') : ' ' ?></td>
                            <td><?= $itemmapa->dthrsaidasala ? DateTime::createFromFormat('Y-m-d H:i:s', $itemmapa->dthrsaidasala)->format('H:i') : ' ' ?></td>
                            <td class="break-line"><?= htmlspecialchars($itemmapa->centrocirurgico) ?></td>
                            <td class="break-line"><?= htmlspecialchars($itemmapa->especialidade_descr_reduz) ?></td>
                            <td class="break-line"><?= htmlspecialchars($itemmapa->nome_paciente) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </div>
</div>



<script>
    setInterval(function() {
        location.reload();
    }, 30000); // 30000 ms = 30 segundos
</script>

<script>

    function getFormattedTimestamp() {

        const now = new Date();

        const year = now.getFullYear();
        const month = String(now.getMonth() + 1).padStart(2, '0'); // Meses começam do zero, então adiciona 1
        const day = String(now.getDate()).padStart(2, '0');
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        
        return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
    }

    $(document).ready(function() {

        $('[data-toggle="tooltip"]').tooltip();

        $('#table').DataTable({
            "order": [[0, 'asc']],
            "language": {
                "url": "<?= base_url('assets/DataTables/i18n/pt-BR.json') ?>"
            },
            fixedHeader: false,
            scrollX: true,
            scrollCollapse: true,
            paging: false,
            ordering: true,
            autoWidth: false,
            "columnDefs": [
                { "orderable": true, "targets": [0, 1, 2, 3, 4, 5, 6, 7] },
            ],
            "info": false,       // remove o texto "Mostrando x de y registros"
            "searching": false,  // remove a caixa de pesquisa
            "deferRender": true,
            initComplete: function() {
                $('#table tbody tr td').addClass('break-line');
            }
        });


        var table = $('#table').DataTable();

        table.on('processing.dt', function(e, settings, processing) {
            if (processing) {
                $('#janelaAguarde').show(); 
            } else {
                $('#janelaAguarde').hide();
            }
        }).on('draw.dt', function () {
            $('.DTFC_LeftWrapper thead th tr, .DTFC_RightWrapper thead th').css({
                'background-color': '#ffffff',
                'color': '#000',
                'border-color': '#dee2e6'
            });
        });

        $('#table thead th').css({
            'background-color': '#ffffff', 
            'color': '#000',
            'border-color': '#dee2e6'
        });

        table.on('draw.dt', function() {

            if (voltarPaginaAnterior === 'S' && primeiraVez) {
                var paginaAnterior = sessionStorage.getItem('paginaSelecionada');

                if (paginaAnterior !== null) {
                    primeiraVez = false;
                    table.page(parseInt(paginaAnterior)).draw(false);
                }
            } 

            var paginaAtual = table.page();
            sessionStorage.setItem('paginaSelecionada', paginaAtual);

        });

    });
</script>