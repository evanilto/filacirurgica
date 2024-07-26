<?=  session()->set('parametros_consulta_mapa', $data); ?>

<table class="table table-hover table-bordered table-smaller-font table-striped" id="table">
    <thead>
        <tr>
            <th scope="col" colspan="13" class="bg-light text-start"><h5><strong>Mapa Cirúrgico</strong></h5></th>
        </tr>
        <tr>
            <th scope="col" class="col-0" >idMapa</th>
            <th scope="col" class="col-0" >Situação</th>
            <th scope="col" data-field="prontuarioaghu" >Fila</th>
            <th scope="col" data-field="prontuarioaghu" >Prontuário</th>
            <th scope="col" data-field="prontuarioaghu" >Nome do Paciente</th>
            <th scope="col" class="col-0" colspan="8" style="text-align: center;">Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($mapacirurgico as $itemmapa): 
            $itemmapa->created_at = \DateTime::createFromFormat('Y-m-d H:i:s', $itemmapa->created_at)->format('d/m/Y H:i');
            $itemmapa->data_risco = $itemmapa->data_risco ? \DateTime::createFromFormat('Y-m-d', $itemmapa->data_risco)->format('d/m/Y') : '';

           $corProgramada = 'yellow';
           $corNoCentroCirúrgico = '#97DA4B';
           $corEmCirurgia = '#804616';
           $corSaídaDaSala = '#87CEFA';
           $corSaídaCentroCirúrgico = '#277534';
           $corTrocaPaciente = '#E9967A';
           $corCirurgiaSuspensa = '#B54398';
           $corCirurgiaCancelada = 'red';

            switch ($itemmapa->status_fila) {
                case 'Programada':
                    $color =$corProgramada;
                    $background_color = $color;
                    break;
                case 'NoCentroCirúrgico':
                    $color =$corNoCentroCirúrgico;
                    $background_color = $color;
                    break;
                case 'EmCirurgia':
                    $color =$corEmCirurgia;
                    $background_color = $color;
                    break;
                case 'SaídaDaSala':
                    $color =$corSaídaDaSala;
                    $background_color = $color;
                    break;
                case 'SaídaCentroCirúrgico':
                    $color = $corSaídaCentroCirúrgico;
                    $background_color = $color;
                    break;
                case 'TrocaPaciente':
                    $color =$corTrocaPaciente;
                    $background_color = $color;
                    break;
                case 'Suspensa':
                    $color =$corCirurgiaSuspensa;
                    $background_color = $color;
                    break;
                case 'Cancelada':
                    $color = $corCirurgiaCancelada;
                    $background_color = $color;
                    break;
                case 'Realizada':
                    $color = $corSaídaCentroCirúrgico;
                    $background_color = $color;
                    break;
                default:
                    $color = 'gray';
                    $background_color = $color;
            }
            
        ?>
            <tr>
                <td><?php echo $itemmapa->id ?></td>
                <td style="text-align: center; vertical-align: middle;">
                    <i class="fa-regular fa-square-full" style="color: <?= $color ?>; background-color: <?= $background_color ?>"></i>
                </td>
                <td><?php echo $itemmapa->fila ?></td>
                <td><?php echo $itemmapa->prontuario ?></td>
                <td><?php echo $itemmapa->nome_paciente ?></td>
                <td style="text-align: center; vertical-align: middle;">
                    <?php
                        if ($itemmapa->status_fila == "Programada") {
                            echo anchor('mapacirurgico/nocentrocirurgico/'.$itemmapa->id, '<i class="fa-regular fa-square-check" style="color: '.$corNoCentroCirúrgico.'; background-color: '.$corNoCentroCirúrgico.'"></i>', array('title' => 'Entrada no Centro Cirúrgico'));
                        } else {
                            echo '<span style="color: gray; cursor: not-allowed;"><i class="fa-regular fa-square-check" style="color: gray;"></i></span>';
                        }
                    ?>
                </td>
                <td style="text-align: center; vertical-align: middle;">
                    <?php
                        if ($itemmapa->status_fila == "NoCentroCirúrgico") {
                            echo anchor('mapacirurgico/emcirurgia/'.$itemmapa->id, '<i class="fa-regular fa-square-check" style="color: '.$corEmCirurgia.'; background-color: '.$corEmCirurgia.'"></i>', array('title' => 'Em Cirurgia'));
                        } else {
                            echo '<span style="color: gray; cursor: not-allowed;"><i class="fa-regular fa-square-check" style="color: gray;"></i></span>';
                        }
                    ?>
                </td>
                <td style="text-align: center; vertical-align: middle;">
                    <?php
                        if ($itemmapa->status_fila == "EmCirurgia") {
                            echo anchor('mapacirurgico/saidadasala/'.$itemmapa->id, '<i class="fa-regular fa-square-check" style="color: '.$corSaídaDaSala.'; background-color: '.$corSaídaDaSala.'"></i>', array('title' => 'Saída da Sala'));
                        } else {
                            echo '<span style="color: gray; cursor: not-allowed;"><i class="fa-regular fa-square-check" style="color: gray;"></i></span>';
                        }
                    ?>
                </td>
                <td style="text-align: center; vertical-align: middle;">
                    <?php
                        if ($itemmapa->status_fila == "SaídaDaSala") {
                            echo anchor('mapacirurgico/saidacentrocirurgico/'.$itemmapa->id, '<i class="fa-regular fa-square-check" style="color: '.$corSaídaCentroCirúrgico.'; background-color: '.$corSaídaCentroCirúrgico.'"></i>', array('title' => 'Saída do Centro Cirúrgico'));
                        } else {
                            echo '<span style="color: gray; cursor: not-allowed;"><i class="fa-regular fa-square-check" style="color: gray;"></i></span>';
                        }
                    ?>
                </td>
                <td style="text-align: center; vertical-align: middle;">
                    <?php
                        if ($itemmapa->status_fila != "Suspensa" && $itemmapa->status_fila != "Cancelada" && $itemmapa->status_fila != "Realizada") {
                            echo anchor('mapacirurgico/suspendercirurgia/'.$itemmapa->id, '<i class="fa-regular fa-square-check" style="color: '.$corCirurgiaSuspensa.';"></i>', array('title' => 'Suspender Cirurgia'));
                        } else {
                            echo '<span style="color: gray; cursor: not-allowed;"><i class="fa-regular fa-square-check" style="color: gray;"></i></span>';
                        }
                    ?>
                </td>
                <td style="text-align: center; vertical-align: middle;">
                    <?php
                        if ($itemmapa->status_fila != "Suspensa" && $itemmapa->status_fila != "Cancelada" && $itemmapa->status_fila != "Realizada") {
                            echo anchor('mapacirurgico/cancelarcirurgia/'.$itemmapa->id, '<i class="fa-regular fa-square-check" style="color: '.$corCirurgiaCancelada.';"></i>', array('title' => 'Cancelar Cirurgia'));
                        } else {
                            echo '<span style="color: gray; cursor: not-allowed;"><i class="fa-regular fa-square-check" style="color: gray;"></i></span>';
                        }
                    ?>
                </td>
                <td style="text-align: center; vertical-align: middle;">
                    <?php
                        if ($itemmapa->status_fila != "Suspensa" && $itemmapa->status_fila != "Cancelada" && $itemmapa->status_fila != "Realizada") {
                            echo anchor('mapacirurgico/atualizarcirurgia/'.$itemmapa->id, '<i class="fas fa-pencil-alt"></i>', array('title' => 'Atualizar Cirurgia'));
                        } else {
                            echo '<span style="color: gray; cursor: not-allowed;"><i class="fas fa-pencil-alt" style="color: gray;"></i></span>';
                        }
                    ?>
                </td>                
                <td style="text-align: center; vertical-align: middle;">
                   <?php echo anchor('mapacirurgico/consultarcirurgia/'.$itemmapa->id, '<i class="fa-solid fa-magnifying-glass"></i>', array('title' => 'Consultar Cirurgia')); ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<div class="container mt-3">
    <a class="btn btn-warning" href="<?= base_url('mapacirurgico/consultar') ?>">
        <i class="fa-solid fa-arrow-left"></i> Voltar
    </a>
    <table class="legend-table">
        <tr>
            <td class="legend-cell" style="background-color: <?= $corProgramada ?>; color: black;">Aguardando</td>
            <td class="legend-cell" style="background-color: <?= $corNoCentroCirúrgico ?>; color: black;">No Centro Cirúrgico</td>
            <td class="legend-cell" style="background-color: <?= $corEmCirurgia ?>;">Em Cirurgia</td>
            <td class="legend-cell" style="background-color: <?= $corSaídaDaSala ?>; color: black;">Saída da Sala</td>
            <td class="legend-cell" style="background-color: <?= $corSaídaCentroCirúrgico ?>;">Saída C. Cirúrgico</td>
            <td class="legend-cell" style="background-color: <?= $corTrocaPaciente ?>; color: black;">Troca de Paciente</td>
            <td class="legend-cell" style="background-color: <?= $corCirurgiaSuspensa ?>;">Cirurgia Suspensa</td>
            <td class="legend-cell" style="background-color: <?= $corCirurgiaCancelada ?>;">Cirurgia Cancelada</td>
        </tr>
    </table>
</div>
<script>
  function mostrarAguarde(event, href) {
    event.preventDefault(); // Prevenir o comportamento padrão do link
    $('#janelaAguarde').show();

    // Redirecionar para o link após um pequeno atraso (1 segundo)
    setTimeout(function() {
      window.location.href = href;
    }, 1000);
  }
  $(document).ready(function() {
        $('#table').DataTable({
            "order": [[0, 'asc']],
            "lengthChange": true,
            "pageLength": 15,
            "lengthMenu": [[10, 20, 50, 75, -1], [10, 20, 50, 75, "Tudo"]],
            "language": {
                "url": "<?= base_url('assets/DataTables/i18n/pt-BR.json') ?>"
            },
            "autoWidth": false,  /* Desative a largura automática */
            "scrollX": true,  /* Ative a rolagem horizontal */
            "columnDefs": [
            { "orderable": false, "targets": [0, 5] },
            { "visible": false, "targets": [0] }
            ],
            layout: { topStart: { buttons: [
                'copy',
                'csv',
                'excel',
                'pdf',
                'print' 
            ] } }
        });

        var table = $('#table').DataTable();
        var firstRecordId;

        function loadAsideContent(recordId) {
            $.ajax({
                url: '<?= base_url('mapacirurgico/carregaaside/') ?>' + recordId,
                method: 'GET',
                beforeSend: function() {
                    $('#sidebar').html('<p>Carregando...</p>'); // Mostrar mensagem de carregando
                },
                success: function(response) {
                    $('#sidebar').html(response); // Atualizar o conteúdo do sidebar
                },
                error: function(xhr, status, error) {
                    var errorMessage = 'Erro ao carregar os detalhes: ' + status + ' - ' + error;
                    console.error(errorMessage);
                    console.error(xhr.responseText);
                    $('#sidebar').html('<p>' + errorMessage + '</p><p>' + xhr.responseText + '</p>');
                }
            });
        }

        $('#table tbody').on('click', 'tr', function() {

            $(this).toggleClass('lineselected').siblings().removeClass('lineselected');
            /* $('#table tbody tr').removeClass('lineselected');
            $(this).addClass('lineselected'); */

            var data = table.row(this).data(); // Obtenha os dados da linha clicada
            var recordId = data[0]; // posição do idmapa na tabela

            loadAsideContent(recordId); 

        });

        function markFirstRecordSelected() {
            // Obter o índice do primeiro registro na página
            var firstRecordIndex = table.page.info().start;

            // Selecionar a linha correspondente ao índice
            var $firstRecordRow = $(table.row(firstRecordIndex).node());

            // Remover a classe 'selected' de todas as linhas e adicionar ao primeiro registro da página
            $('#table tbody tr').removeClass('lineselected');
            $firstRecordRow.addClass('lineselected');

            // Obter os dados do registro selecionado e carregar os detalhes no aside
            var data = table.row(firstRecordIndex).data();
            var recordId = data[0]; // posição do idmapa na tabela
            loadAsideContent(recordId);
        }

        // Marcar o primeiro registro como selecionado ao redesenhar a tabela
        table.on('draw.dt', function() {
            markFirstRecordSelected();
        });
    });
</script>

