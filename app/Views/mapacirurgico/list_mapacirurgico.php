<?php
    session()->set('parametros_consulta_mapa', $data); 

    $corProgramada = 'yellow';
    $corNoCentroCirúrgico = '#97DA4B';
    $corEmCirurgia = '#804616';
    $corSaídaDaSala = '#87CEFA';
    $corSaídaCentroCirúrgico = '#277534';
    $corTrocaPaciente = '#E9967A';
    $corCirurgiaSuspensa = '#B54398';
    $corCirurgiaCancelada = 'red';
?>

<table class="table table-hover table-bordered table-smaller-font table-striped" id="table">
    <thead>
        <tr>
            <th scope="col" colspan="18" class="bg-light text-start"><h5><strong>Mapa Cirúrgico</strong></h5></th>
        </tr>
        <tr>
            <th scope="col" class="col-0" >idMapa</th>
            <th scope="col" class="col-0" >Sit.</th>
            <th scope="col" class="col-0" >Centro Cirúrgico</th>
            <th scope="col" class="col-0" >Sala</th>
            <th scope="col" data-field="fila" >Dt/Hr Estimada</th>
            <th scope="col" class="col-0" style="text-align: center; vertical-align: middle;">
                    <i class="fa-solid fa-circle" style="color: <?= $corNoCentroCirúrgico ?>; "></i>
            </th>
            <th scope="col" class="col-0" style="text-align: center; vertical-align: middle;">
                    <i class="fa-solid fa-circle" style="color: <?= $corEmCirurgia ?>; "></i>
            </th>
            <th scope="col" class="col-0" style="text-align: center; vertical-align: middle;">
                    <i class="fa-solid fa-circle" style="color: <?= $corSaídaDaSala ?>; "></i>
            </th>
            <th scope="col" class="col-0" style="text-align: center; vertical-align: middle;">
                    <i class="fa-solid fa-circle" style="color: <?= $corSaídaCentroCirúrgico ?>; "></i>
            </th>
            <th scope="col" data-field="nome" >Nome do Paciente</th>
            <th scope="col" class="col-0" colspan="8" style="text-align: center;">Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach($mapacirurgico as $itemmapa): 
                $itemmapa->created_at = \DateTime::createFromFormat('Y-m-d H:i:s', $itemmapa->created_at)->format('d/m/Y H:i');
                $itemmapa->data_risco = $itemmapa->dtrisco ? \DateTime::createFromFormat('Y-m-d', $itemmapa->dtrisco)->format('d/m/Y') : '';

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
            <tr
                data-prontuario="<?= $itemmapa->prontuario ?>" 
                data-nome_paciente="<?= $itemmapa->nome_paciente ?>" 
                data-fila="<?= $itemmapa->fila ?>"
                data-especialidade="<?= $itemmapa->especialidade_descricao ?>"
                data-cid="<?= $itemmapa->cid_descricao ?>"
                data-procedimento="<?= $itemmapa->procedimento_principal ?>"
                data-ordem="<?= $itemmapa->ordem_fila ?>"
                data-complexidade="<?= $itemmapa->complexidade ?>">

                <td><?php echo $itemmapa->id ?></td>
                <td style="text-align: center; vertical-align: middle;">
                    <i class="fa-regular fa-square-full" style="color: <?= $color ?>; background-color: <?= $background_color ?>"></i>
                </td>
                <td><?php echo $itemmapa->centrocirurgico ?></td>
                <td><?php echo $itemmapa->sala ?></td>
                <td><?php echo DateTime::createFromFormat('Y-m-d H:i:s', $itemmapa->dthrcirurgiaestimada)->format('d/m/Y H:i') ?></td>
                <td><?php echo $itemmapa->dthrnocentrocirurgico ? DateTime::createFromFormat('Y-m-d H:i:s', $itemmapa->dthrnocentrocirurgico)->format('H:i') : ' ' ?></td>
                <td><?php echo $itemmapa->dthrcirurgia ? DateTime::createFromFormat('Y-m-d H:i:s', $itemmapa->dthrcirurgia)->format('H:i') : ' ' ?></td>
                <td><?php echo $itemmapa->dthrsaidasala ? DateTime::createFromFormat('Y-m-d H:i:s', $itemmapa->dthrsaidasala)->format('H:i') : ' ' ?></td>
                <td><?php echo $itemmapa->dthrsaidacentrocirurgico ? DateTime::createFromFormat('Y-m-d H:i:s', $itemmapa->dthrsaidacentrocirurgico)->format('H:i') : ' ' ?></td>
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
                            echo anchor('mapacirurgico/atualizarcirurgia/'.$itemmapa->id, '<i class="fas fa-pencil-alt"></i>', array('title' => 'Atualizar Cirurgia', 'onclick' => 'mostrarAguarde(event, this.href)'));
                        } else {
                            echo '<span style="color: gray; cursor: not-allowed;"><i class="fas fa-pencil-alt" style="color: gray;"></i></span>';
                        }
                    ?>
                </td>                
                <td style="text-align: center; vertical-align: middle;">
                   <?php echo anchor('mapacirurgico/consultarcirurgia/'.$itemmapa->id, '<i class="fa-solid fa-magnifying-glass"></i>', array('title' => 'Consultar Cirurgia', 'onclick' => 'mostrarAguarde(event, this.href)')); ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<div class="container-legend mt-3">
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
        "autoWidth": false,
        "scrollX": true,
        "columnDefs": [
            { "orderable": false, "targets": [1, 2, 3, 4, 5, 6, 7, 8, 10,  11, 12, 13, 14, 15, 16, 17] },
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

    // Função para exibir os dados na seção aside
    function displayAsideContent(paciente) {
        var htmlContent = `
            <h6><strong>Paciente</strong></h6>
            <table class="table table-left-aligned table-smaller-font">
                <tbody>
                    <tr>
                        <td width="40%"><i class="fa-solid fa-hashtag"></i> Ordem Fila:</td>
                        <td><b>${paciente.ordem}</b></td>
                    </tr>
                    <tr>
                        <td width="40%"><i class="fa-solid fa-user"></i> Prontuário:</td>
                        <td><b>${paciente.prontuario}</b></td>
                    </tr>
                    <tr>
                        <td width="40%"><i class="fa-solid fa-user"></i> Nome:</td>
                        <td><b>${paciente.nome}</b></td>
                    </tr>
                    <tr>
                        <td width="40%"><i class="fa-solid fa-list"></i> Fila:</td>
                        <td><b>${paciente.fila}</b></td>
                    </tr>
                    <tr>
                        <td width="40%"><i class="fa-solid fa-list"></i> Especialidade:</td>
                        <td><b>${paciente.especialidade}</b></td>
                    </tr>
                    <tr>
                        <td width="40%"><i class="fa-solid fa-list"></i> Procedimento Principal:</td>
                        <td><b>${paciente.procedimento}</b></td>
                    </tr>
                    <tr>
                        <td width="40%"><i class="fa-solid fa-list"></i> CID:</td>
                        <td><b>${paciente.cid}</b></td>
                    </tr>
                    <tr>
                        <td width="40%"><i class="fa-solid fa-list"></i> Complexidade:</td>
                        <td><b>${paciente.complexidade}</b></td>
                    </tr>
                </tbody>
            </table>
        `;

        // Atualizar o conteúdo do aside
        $('#sidebar').html(htmlContent);
    }

    $('#table tbody').on('click', 'tr', function() {
        $(this).toggleClass('lineselected').siblings().removeClass('lineselected');

        // Cria um objeto de paciente com os dados
        var paciente = {
            prontuario: $(this).data('prontuario'),
            nome: $(this).data('nome_paciente'),
            especialidade: $(this).data('especialidade'),
            cid: $(this).data('cid'),
            procedimento: $(this).data('procedimento'),
            ordem: $(this).data('ordem'),
            complexidade: $(this).data('complexidade'),
            fila:  $(this).data('fila')
        };

        // Exibe as informações do paciente na seção aside
        displayAsideContent(paciente);
    });

    function markFirstRecordSelected() {
        // Obter o índice do primeiro registro na página
        var firstRecordIndex = table.page.info().start;

        // Selecionar a linha correspondente ao índice
        var $firstRecordRow = $(table.row(firstRecordIndex).node());

        // Remover a classe 'lineselected' de todas as linhas e adicionar ao primeiro registro da página
        $('#table tbody tr').removeClass('lineselected');
        $firstRecordRow.addClass('lineselected');

        // Cria um objeto de paciente
        var paciente = {
            prontuario: $firstRecordRow.data('prontuario'),
            nome: $firstRecordRow.data('nome_paciente'),
            especialidade: $firstRecordRow.data('especialidade'),
            cid: $firstRecordRow.data('cid'),
            procedimento: $firstRecordRow.data('procedimento'),
            ordem: $firstRecordRow.data('ordem'),
            complexidade: $firstRecordRow.data('complexidade'),
            fila: $firstRecordRow.data('fila')
        };

        // Exibe os detalhes do primeiro registro
        displayAsideContent(paciente);
    }
    

    // Marcar o primeiro registro como selecionado ao inicializar a DataTable
    markFirstRecordSelected();

    table.on('draw.dt', function() {
        markFirstRecordSelected();
    });

});

</script>

