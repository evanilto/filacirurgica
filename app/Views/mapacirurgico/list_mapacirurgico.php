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
            <th scope="col" colspan="19" class="bg-light text-start"><h5><strong>Mapa Cirúrgico</strong></h5></th>
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
            <th scope="col" class="col-0" colspan="9" style="text-align: center;">Ações</th>
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
                    $title = 'Cirurgia Programada';
                    break;
                case 'NoCentroCirurgico':
                    $color =$corNoCentroCirúrgico;
                    $background_color = $color;
                    $title = 'Paciente no Centro Cirúrgico';
                    break;
                case 'EmCirurgia':
                    $color =$corEmCirurgia;
                    $background_color = $color;
                    $title = 'Paciente em Cirurgia';
                    break;
                case 'SaídaDaSala':
                    $color =$corSaídaDaSala;
                    $background_color = $color;
                    $title = 'Paciente saiu da Sala';
                    break;
                case 'SaídaCentroCirúrgico':
                    $color = $corSaídaCentroCirúrgico;
                    $background_color = $color;
                    $title = 'Cirurgia Realizada';
                    break;
                case 'TrocaPaciente':
                    $color =$corTrocaPaciente;
                    $background_color = $color;
                    $title = 'Troca de Paciente';
                    break;
                case 'Suspensa':
                    $color =$corCirurgiaSuspensa;
                    $background_color = $color;
                    $title = 'Cirurgia Suspensa';
                    break;
                case 'Cancelada':
                    $color = $corCirurgiaCancelada;
                    $background_color = $color;
                    $title = 'Cirurgia Cancelada';
                    break;
                case 'Realizada':
                    $color = $corSaídaCentroCirúrgico;
                    $background_color = $color;
                    $title = 'Cirurgia Realizada';
                    break;
                default:
                    $color = 'gray';
                    $background_color = $color;
                    $title = 'Undefined';
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
                    <i class="fa-regular fa-square-full" style="color: <?= $color ?>; background-color: <?= $background_color ?> "  title="<?= $title?>"></i>
                </td>
                <td><?php echo $itemmapa->centrocirurgico ?></td>
                <td><?php echo $itemmapa->sala ?></td>
                <td><?php echo DateTime::createFromFormat('Y-m-d H:i:s', $itemmapa->dthrcirurgia)->format('d/m/Y H:i') ?></td>
                <td><?php echo $itemmapa->dthrnocentrocirurgico ? DateTime::createFromFormat('Y-m-d H:i:s', $itemmapa->dthrnocentrocirurgico)->format('H:i') : ' ' ?></td>
                <td><?php echo $itemmapa->dthremcirurgia ? DateTime::createFromFormat('Y-m-d H:i:s', $itemmapa->dthremcirurgia)->format('H:i') : ' ' ?></td>
                <td><?php echo $itemmapa->dthrsaidasala ? DateTime::createFromFormat('Y-m-d H:i:s', $itemmapa->dthrsaidasala)->format('H:i') : ' ' ?></td>
                <td><?php echo $itemmapa->dthrsaidacentrocirurgico ? DateTime::createFromFormat('Y-m-d H:i:s', $itemmapa->dthrsaidacentrocirurgico)->format('H:i') : ' ' ?></td>
                <td><?php echo $itemmapa->nome_paciente ?></td>
                <td style="text-align: center; vertical-align: middle;">
                    <?php
                        if ($itemmapa->status_fila == "Programada") {
                            echo '<a href="#" id="programada" title="Informar entrada no centro cirúrgico" data-mapa-id="'.$itemmapa->id.'" data-time="'.date('Y-m-d H:i:s').'" onclick="return confirma(this);"><i class="fa-regular fa-square-check" style="color: '.$corNoCentroCirúrgico.'; background-color: '.$corNoCentroCirúrgico.'"></i></a>';

                        } else {
                            echo '<span style="color: gray; cursor: not-allowed;"><i class="fa-regular fa-square-check" style="color: gray;"></i></span>';
                        }
                    ?>
                </td>
                <td style="text-align: center; vertical-align: middle;">
                    <?php
                        if ($itemmapa->status_fila == "NoCentroCirurgico") {
                            echo '<a href="#" id="nocentrocirurgico" title="Informar paciente em cirurgia" data-mapa-id="'.$itemmapa->id.'" data-time="'.date('Y-m-d H:i:s').'" onclick="return confirma(this);"><i class="fa-regular fa-square-check" style="color: '.$corEmCirurgia.'; background-color: '.$corEmCirurgia.'"></i></a>';
                        } else {
                            echo '<span style="color: gray; cursor: not-allowed;"><i class="fa-regular fa-square-check" style="color: gray;"></i></span>';
                        }
                    ?>
                </td>
                <td style="text-align: center; vertical-align: middle;">
                    <?php
                        if ($itemmapa->status_fila == "EmCirurgia") {
                            echo '<a href="#" id="emcirurgia" title="Informar saída da sala cirúrgica" data-mapa-id="'.$itemmapa->id.'" data-time="'.date('Y-m-d H:i:s').'" onclick="return confirma(this);"><i class="fa-regular fa-square-check" style="color: '.$corSaídaDaSala.'; background-color: '.$corSaídaDaSala.'"></i></a>';
                        } else {
                            echo '<span style="color: gray; cursor: not-allowed;"><i class="fa-regular fa-square-check" style="color: gray;"></i></span>';
                        }
                    ?>
                </td>
                <td style="text-align: center; vertical-align: middle;">
                    <?php
                        if ($itemmapa->status_fila == "SaídaDaSala") {
                            echo '<a href="#" id="saidadasala" title="Informar saída do centro cirúrgico" data-mapa-id="'.$itemmapa->id.'" data-time="'.date('Y-m-d H:i:s').'" onclick="return confirma(this);"><i class="fa-regular fa-square-check" style="color: '.$corSaídaCentroCirúrgico.'; background-color: '.$corSaídaCentroCirúrgico.'"></i></a>';
                        } else {
                            echo '<span style="color: gray; cursor: not-allowed;"><i class="fa-regular fa-square-check" style="color: gray;"></i></span>';
                        }
                    ?>
                </td>
                <td style="text-align: center; vertical-align: middle;">
                    <?php
                        if ($itemmapa->status_fila != "Suspensa" && $itemmapa->status_fila != "Cancelada" && $itemmapa->status_fila != "Realizada") {
                            echo '<a href="#" id="suspender" title="Suspender cirurgia" data-mapa-id="'.$itemmapa->id.'" data-lista-id="'.$itemmapa->idlista.'" data-time="'.date('Y-m-d H:i:s').'" onclick="return confirma(this);"><i class="fa-solid fa-power-off" style="color: '.$corCirurgiaSuspensa.';"></i></a>';
                        } else {
                            echo '<span style="color: gray; cursor: not-allowed;"><i class="fa-solid fa-power-off" style="color: gray;"></i></span>';
                        }
                    ?>
                </td>
                <td style="text-align: center; vertical-align: middle;">
                    <?php
                        if ($itemmapa->status_fila != "Suspensa" && $itemmapa->status_fila != "Cancelada" && $itemmapa->status_fila != "Realizada") {
                            $params = array(
                                'idmapa' => $itemmapa->id,
                                'idfila' => $itemmapa->idfila,
                                'idespecialidade' => $itemmapa->idespecialidade,
                                'prontuario' => $itemmapa->prontuario,
                            );
                            $queryString = http_build_query($params);
                            
                            echo anchor('mapacirurgico/trocarpaciente?' . $queryString, '<i class="fa-solid fa-people-arrows" style="color: '.$corTrocaPaciente.';"></i>', array('title' => 'Trocar Paciente', 'onclick' => 'mostrarAguarde(event, this.href)'));
                        } else {
                            echo '<span style="color: gray; cursor: not-allowed;"><i class="fa-solid fa-people-arrows" style="color: gray;"></i></span>';
                        }
                    ?>
                </td>
                <td style="text-align: center; vertical-align: middle;">
                    <?php
                        if ($itemmapa->status_fila != "Suspensa" && $itemmapa->status_fila != "Cancelada" && $itemmapa->status_fila != "Realizada") {
                            echo anchor('mapacirurgico/atualizarhorarioscirurgia/'.$itemmapa->id, '<i class="fa-regular fa-clock"></i>', array('title' => 'Atualizar Horários', 'onclick' => 'mostrarAguarde(event, this.href)'));
                        } else {
                            echo '<span style="color: gray; cursor: not-allowed;"><i class="fa-regular fa-clock" style="color: gray;"></i></span>';
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
                   <?php echo anchor('mapacirurgico/consultarcirurgia/'.$itemmapa->id, '<i class="fa-solid fa-magnifying-glass"></i>', array('title' => 'Consultar detalhes da cirurgia','onclick' => 'mostrarAguarde(event, this.href)')); ?>
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
            <!--td class="legend-cell">Legenda:</td-->
            <td class="legend-cell" style="background-color: <?= $corProgramada ?>; color: black;">Aguardando</td>
            <td class="legend-cell" style="background-color: <?= $corNoCentroCirúrgico ?>; color: black;">No Centro Cirúrgico</td>
            <td class="legend-cell" style="background-color: <?= $corEmCirurgia ?>;">Em Cirurgia</td>
            <td class="legend-cell" style="background-color: <?= $corSaídaDaSala ?>; color: black;">Saída da Sala</td>
            <td class="legend-cell" style="background-color: <?= $corSaídaCentroCirúrgico ?>;">Saída C. Cirúrgico</td>
            <td class="legend-cell" style="background-color: <?= $corTrocaPaciente ?>; color: black;">Troca de Paciente</td>
            <td class="legend-cell" style="background-color: <?= $corCirurgiaSuspensa ?>;">Cirurgia Suspensa</td>
            <!--td class="legend-cell" style="background-color: <-?= $corCirurgiaCancelada ?>;">Cirurgia Cancelada</td-->
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

    function confirma(link) {
        let message;
        let array;

        //const arrayId = ['programada', 'nocentrocirurgico', 'emcirurgia', 'saidadasala', 'suspender', 'cancelar'];

        switch (link.id) {
            case 'programada':
                evento = 'dthrnocentrocirurgico';
                message = 'Confirma a entrada no centro cirúrgico?';
                break;
            case 'nocentrocirurgico':
                evento = 'dthremcirurgia';
                message = 'Confirma o paciente em cirurgia?';
                break;
            case 'emcirurgia':
                evento = 'dthrsaidasala';
                message = 'Confirma a saída da sala?';
                break;
            case 'saidadasala':
                evento = 'dthrsaidacentrocirurgico';
                message = 'Confirma a saída do centro cirúrgico?';
                break;
            case 'suspender':
                evento = 'dthrsuspensao';
                message = 'Confirma a suspensão da cirurgia?';
                break;
            case 'trocar':
                evento = 'dthrtroca';
                message = 'Confirma a troca do paciente?';
                break;
            default:
                message = '';
                break;
        }

        //if (arrayId.includes(link.id)) {
            if (!confirm(message)) {
                return false; 
            }
        //}

        tratarLink(link, evento);

        return false; 
    }

    function tratarLink(link, evento) {

        //$('#janelaAguarde').show();

        // Previnir o comportamento padrão do link
        event.preventDefault(); 

        const mapaId = link.dataset.mapaId;
        const listaId = link.dataset.listaId;
        const timeValue = link.dataset.time;

        var formData = new FormData();
        //formData.append('idMapa', itemId);

        const arrayId = {};
        arrayId['idMapa'] = mapaId;
        arrayId['idLista'] = listaId;
        formData.append('arrayid', JSON.stringify(arrayId));

        //const array = { evento: timeValue };
        const arrayevento = {};
        arrayevento[evento] = timeValue;
        formData.append('evento', JSON.stringify(arrayevento));

        // Configurar a requisição AJAX
        const xhr = new XMLHttpRequest();
        xhr.open('POST', '<?= base_url('mapacirurgico/tratareventocirurgico') ?>', true);
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

        // Tratar a resposta da requisição AJAX
        xhr.onload = function() {
            if (xhr.status >= 200 && xhr.status < 400) {
                var response = JSON.parse(xhr.responseText);
                console.log(response); 

                if (response.success) {
                    console.log('Evento registrado com sucesso.');
                    window.history.back();
                    window.location.reload();
                } else {
                    console.error('Erro ao redirecionar.');
                }
            } else {
                console.error('Erro ao enviar os dados.');
            }
        };

        xhr.onerror = function() {
            console.error('Erro na requisição AJAX.');
        };
        
        // Enviar o FormData com a requisição AJAX
        xhr.send(formData);

        return false;
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

