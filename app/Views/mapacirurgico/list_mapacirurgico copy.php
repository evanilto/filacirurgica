<?php
    use App\Libraries\HUAP_Functions;

    //session()->set('parametros_consulta_mapa', $data); 
    $corProgramada = 'yellow';
    $corNoCentroCirúrgico = '#97DA4B';
    $corEmCirurgia = '#277534';//'#804616';
    $corSaídaDaSala = '#87CEFA';
    $corSaídaCentroCirúrgico = '#00008B'; //'#277534';
    $corTrocaPaciente = '#FF7F7F';//'#E9967A';
    $corCirurgiaSuspensa = 'red';//'#B54398';
    $corCirurgiaCancelada = 'red';
?>

<script>$('#janelaAguarde').show();</script>

<div class="table-container">
    <table class="table table-hover table-bordered table-smaller-font table-striped" id="table">
        <thead>
            <tr>
                <th scope="row" colspan="3" class="bg-light text-start" style="border-right: none;">
                    <h5><strong>Mapa Cirúrgico</strong></h5>
                </th>
                <th scope="row" colspan="24" class="bg-light text-center" style="border-left: none; border-right: none; vertical-align: middle;">
                    <table class="legend-table" style="margin: 0 auto;">
                        <tr>
                            <td class="legend-cell" style="background-color: <?= $corProgramada ?>; color: black;">Aguardando</td>
                            <td class="legend-cell" style="background-color: <?= $corNoCentroCirúrgico ?>; color: black;">No Centro Cirúrgico</td>
                            <td class="legend-cell" style="background-color: <?= $corEmCirurgia ?>;">Em Cirurgia</td>
                            <td class="legend-cell" style="background-color: <?= $corSaídaDaSala ?>; color: black;">Saída da Sala</td>
                            <td class="legend-cell" style="background-color: <?= $corSaídaCentroCirúrgico ?>;">Saída C. Cirúrgico</td>
                            <td class="legend-cell" style="background-color: <?= $corTrocaPaciente ?>; color: black;">Troca de Paciente</td>
                            <td class="legend-cell" style="background-color: <?= $corCirurgiaSuspensa ?>;">Cirurgia Suspensa</td>
                            <!--td class="legend-cell" style="background-color: <?= $corCirurgiaCancelada ?>;">Cirurgia Cancelada</td-->
                        </tr>
                    </table>
                </th>
                <th scope="row" colspan="9" class="bg-light text-center" style="border-left: none; vertical-align: middle;">
                </th>
            </tr>
            <tr>
                <th scope="col" class="col-0" >idMapa</th>
                <th scope="col" class="col-0" title='Situação do Paciente'>Sit.</th>
                <th scope="col" data-field="fila" >Dt/Hr Cirurgia</th>
                <th scope="col" class="col-0" >Centro Cirúrgico</th>
                <th scope="col" class="col-0" >Sala</th>
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
                <th scope="col" class="col-0" >Especialidade</th>
                <th scope="col" class="col-0" >Fila</th>
                <th scope="col" data-field="prontuario" >Prontuario</th>
                <th scope="col" data-field="nome" >Nome do Paciente</th>
                
                <th scope="col" data-field="nome" >Risco</th>
                <th scope="col" data-field="nome" >Data Risco</th>
                <th scope="col" data-field="nome" >CID</th>
                <th scope="col" data-field="nome" >CID Descrição<output></output></th>
                <th scope="col" data-field="nome" >Origem</th>
                <th scope="col" data-field="nome" >Complexidade</th>
                <th scope="col" data-field="nome" >Lateralidade</th>
                <th scope="col" data-field="nome" >Congelação</th>
                <th scope="col" data-field="nome" >Hemoderivados</th>
                <th scope="col" data-field="nome" >OPME</th>
                <th scope="col" data-field="nome" >Pós-Operatório</th>
                <th scope="col" data-field="nome" >Info Adicionais</th>
                <th scope="col" data-field="nome" >Necessidades do Procedimento</th>
                <th scope="col" data-field="nome" >Procedimento Principal</th>
                <th scope="col" class="col-0" colspan="9" style="text-align: center;">Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php

                foreach($mapacirurgico as $itemmapa): 
                    $itemmapa->created_at = \DateTime::createFromFormat('Y-m-d H:i:s', $itemmapa->created_at)->format('d/m/Y H:i');
                    $itemmapa->data_risco = $itemmapa->dtrisco ? \DateTime::createFromFormat('Y-m-d', $itemmapa->dtrisco)->format('d/m/Y') : '';

                    //die(var_dump($itemmapa));
                    //if (DateTime::createFromFormat('Y-m-d H:i:s', $itemmapa->dthrcirurgia)->format('Y-m-d') != date('Y-m-d')) {
                        //$permiteatualizar = false;
                    //} else {
                        $permiteatualizar = true;
                    //}

                    if ($itemmapa->dthrsuspensao) {
                        $color =$corCirurgiaSuspensa;
                        $background_color = $color;
                        $status_cirurgia = 'Suspensa';
                        $title = 'Cirurgia Suspensa';

                    } elseif ($itemmapa->dthrtroca) {
                        $color =$corTrocaPaciente;
                        $background_color = $color;
                        $status_cirurgia = 'TrocaPaciente';
                        $title = 'Troca de Paciente';

                    } elseif ($itemmapa->dthrsaidacentrocirurgico) {
                        $color = $corSaídaCentroCirúrgico;
                        $background_color = $color;
                        $status_cirurgia = 'Realizada';
                        $title = 'Cirurgia Realizada';
                    } else {

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
                            /* case 'TrocaPaciente':
                                $color =$corTrocaPaciente;
                                $background_color = $color;
                                $title = 'Troca de Paciente';
                                break;
                            case 'Suspensa':
                                $color =$corCirurgiaSuspensa;
                                $background_color = $color;
                                $title = 'Cirurgia Suspensa';
                                break; */
                            case 'Cancelada':
                                $color = $corCirurgiaCancelada;
                                $background_color = $color;
                                $title = 'Cirurgia Cancelada';
                                break;
                        /*  case 'Realizada':
                                $color = $corSaídaCentroCirúrgico;
                                $background_color = $color;
                                $title = 'Cirurgia Realizada';
                                break; */
                            default:
                                $color = 'gray';
                                $background_color = $color;
                                $title = 'Undefined';
                        }

                        $status_cirurgia = $itemmapa->status_fila;

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
                    data-complexidade="<?= $itemmapa->nmcomplexidade ?>"
                    data-lateralidade="<?= $itemmapa->nmlateralidade ?>"
                    data-congelacao="<?= $itemmapa->congelacao ?>"
                    data-risco="<?= $itemmapa->risco_descricao ?>"
                    data-dtrisco="<?= $itemmapa->dtrisco ? \DateTime::createFromFormat('Y-m-d', $itemmapa->dtrisco)->format('d/m/Y') : 'N/D' ?>"
                    data-infoadic="<?= htmlspecialchars($itemmapa->infoadicionais, ENT_QUOTES, 'UTF-8') ?>"
                    data-posoperatorio="<?= $itemmapa->posoperatorio ?>"
                    data-necesspro="<?= htmlspecialchars($itemmapa->necessidadesproced, ENT_QUOTES, 'UTF-8') ?>"
                    data-hemo="<?= $itemmapa->hemoderivados ?>"
                    data-orig="<?= htmlspecialchars($itemmapa->origemjustificativa, ENT_QUOTES, 'UTF-8') ?>"
                    >

                    <td><?php echo $itemmapa->dthrcirurgia ?></td>
                    <td style="text-align: center; vertical-align: middle;">
                        <i class="fa-regular fa-square-full" style="color: <?= $color ?>; background-color: <?= $background_color ?> "  title="<?= $title?>"></i>
                    </td>
                    <td><?php echo DateTime::createFromFormat('Y-m-d H:i:s', $itemmapa->dthrcirurgia)->format('d/m/Y H:i') ?></td>
                    <td class="break-line" title="<?php echo htmlspecialchars($itemmapa->centrocirurgico); ?>">
                        <?php echo htmlspecialchars($itemmapa->centrocirurgico); ?>
                    </td>
                    <td class="break-line" title="<?php echo htmlspecialchars($itemmapa->sala); ?>">
                        <?php echo htmlspecialchars($itemmapa->sala); ?>
                    </td>
                    <td><?php echo $itemmapa->dthrnocentrocirurgico ? DateTime::createFromFormat('Y-m-d H:i:s', $itemmapa->dthrnocentrocirurgico)->format('H:i') : ' ' ?></td>
                    <td><?php echo $itemmapa->dthremcirurgia ? DateTime::createFromFormat('Y-m-d H:i:s', $itemmapa->dthremcirurgia)->format('H:i') : ' ' ?></td>
                    <td><?php echo $itemmapa->dthrsaidasala ? DateTime::createFromFormat('Y-m-d H:i:s', $itemmapa->dthrsaidasala)->format('H:i') : ' ' ?></td>
                    <td><?php echo $itemmapa->dthrsaidacentrocirurgico ? DateTime::createFromFormat('Y-m-d H:i:s', $itemmapa->dthrsaidacentrocirurgico)->format('H:i') : ' ' ?></td>
                    <td class="break-line" title="<?php echo htmlspecialchars($itemmapa->especialidade_descr_reduz); ?>">
                        <?php echo htmlspecialchars($itemmapa->especialidade_descr_reduz); ?>
                    </td><td class="break-line" title="<?php echo htmlspecialchars($itemmapa->fila); ?>">
                        <?php echo htmlspecialchars($itemmapa->fila); ?>
                    </td>
                    <td><?php echo $itemmapa->prontuario ?></td>
                    <td class="break-line" title="<?php echo htmlspecialchars($itemmapa->nome_paciente); ?>">
                        <?php echo htmlspecialchars($itemmapa->nome_paciente); ?>
                    </td>
                    <td><?php echo $itemmapa->risco_descricao ?></td>
                    <td><?php echo $itemmapa->dtrisco ?></td>
                    <td><?php echo $itemmapa->cid ?></td>
                    </td><td class="break-line" title="<?php echo htmlspecialchars($itemmapa->cid_descricao); ?>">
                        <?php echo htmlspecialchars($itemmapa->cid_descricao); ?>
                    </td>
                    <td><?php echo $itemmapa->origem_descricao ?></td>
                    <td><?php echo $itemmapa->nmcomplexidade ?></td>
                    <td><?php echo $itemmapa->nmlateralidade ?></td>
                    <td><?php echo $itemmapa->congelacao ?></td>
                    <td><?php echo $itemmapa->hemoderivados ?></td>
                    <td><?php echo $itemmapa->opme ?></td>
                    <td><?php echo $itemmapa->posoperatorio ?></td>
                    </td><td class="break-line" title="<?php echo htmlspecialchars($itemmapa->infoadicionais); ?>">
                        <?php echo htmlspecialchars($itemmapa->infoadicionais); ?>
                    </td>
                    </td><td class="break-line" title="<?php echo htmlspecialchars($itemmapa->necessidadesproced); ?>">
                        <?php echo htmlspecialchars($itemmapa->necessidadesproced); ?>
                    <td>
                    </td></td><td class="break-line" title="<?php echo $itemmapa->procedimento_principal.'-'.htmlspecialchars($itemmapa->procedimento_principal); ?>">
                        <?php echo htmlspecialchars($itemmapa->procedimento_principal); ?>

                    <td style="text-align: center; vertical-align: middle;">
                        <?php
                            if ($status_cirurgia == "Programada" && $permiteatualizar && HUAP_Functions::tem_permissao('mapacirurgico-alterar')) {
                                echo '<a href="#" id="programada" title="Informar entrada no centro cirúrgico" data-mapa-dthrcirurgia="'.$itemmapa->dthrcirurgia.'" data-mapa-id="'.$itemmapa->id.'" data-lista-id="'.$itemmapa->idlista.'" data-time="'.date('Y-m-d H:i:s').'" onclick="return confirma(this);"><i class="fa-solid fa-circle" style="color: '.$corNoCentroCirúrgico.';"></i></a>';
                            } else {
                                echo '<span style="color: gray; cursor: not-allowed;"><i class="fa-solid fa-circle" style="color: gray;"></i></span>';
                            }
                        ?>
                    </td>
                    <td style="text-align: center; vertical-align: middle;">
                        <?php
                            if ($status_cirurgia == "NoCentroCirurgico" && $permiteatualizar && HUAP_Functions::tem_permissao('mapacirurgico-alterar')) {
                                echo '<a href="#" id="nocentrocirurgico" title="Informar paciente em cirurgia" data-mapa-dthrcirurgia="'.$itemmapa->dthrcirurgia.'" data-mapa-id="'.$itemmapa->id.'" data-lista-id="'.$itemmapa->idlista.'" data-time="'.date('Y-m-d H:i:s').'" onclick="return confirma(this);"><i class="fa-solid fa-circle" style="color: '.$corEmCirurgia.';"></i></a>';
                            } else {
                                echo '<span style="color: gray; cursor: not-allowed;"><i class="fa-solid fa-circle" style="color: gray;"></i></span>';
                            }
                        ?>
                    </td>
                    <td style="text-align: center; vertical-align: middle;">
                        <?php
                            if ($status_cirurgia == "EmCirurgia" && $permiteatualizar && HUAP_Functions::tem_permissao('mapacirurgico-alterar')) {
                                echo '<a href="#" id="emcirurgia" title="Informar saída da sala cirúrgica" data-mapa-dthrcirurgia="'.$itemmapa->dthrcirurgia.'" data-mapa-id="'.$itemmapa->id.'" data-lista-id="'.$itemmapa->idlista.'" data-time="'.date('Y-m-d H:i:s').'" onclick="return confirma(this);"><i class="fa-solid fa-circle" style="color: '.$corSaídaDaSala.';"></i></a>';
                            } else {
                                echo '<span style="color: gray; cursor: not-allowed;"><i class="fa-solid fa-circle" style="color: gray;"></i></span>';
                            }
                        ?>
                    </td>
                    <td style="text-align: center; vertical-align: middle;">
                        <?php
                            if ($status_cirurgia == "SaídaDaSala" && $permiteatualizar && HUAP_Functions::tem_permissao('mapacirurgico-alterar')) {
                                echo '<a href="#" id="saidadasala" title="Informar saída do centro cirúrgico" data-mapa-dthrcirurgia="'.$itemmapa->dthrcirurgia.'" data-mapa-id="'.$itemmapa->id.'" data-lista-id="'.$itemmapa->idlista.'" data-time="'.date('Y-m-d H:i:s').'" onclick="return confirma(this);"><i class="fa-solid fa-circle" style="color: '.$corSaídaCentroCirúrgico.';"></i></a>';
                            } else {
                                echo '<span style="color: gray; cursor: not-allowed;"><i class="fa-solid fa-circle" style="color: gray;"></i></span>';
                            }
                        ?>
                    </td>
                    <td style="text-align: center; vertical-align: middle;">
                        <?php
                            //if ($status_cirurgia != "Suspensa" && $status_cirurgia != "Cancelada" && $status_cirurgia != "TrocaPaciente" && $status_cirurgia != "Realizada" && HUAP_Functions::tem_permissao('mapacirurgico-alterar')) {
                            if (in_array($status_cirurgia, ["Programada", "NoCentroCirurgico"]) && HUAP_Functions::tem_permissao('mapacirurgico-alterar')) {
                                //echo '<a href="#" id="suspender" title="Suspender cirurgia" data-mapa-dthrcirurgia="'.$itemmapa->dthrcirurgia.'" data-mapa-id="'.$itemmapa->id.'" data-lista-id="'.$itemmapa->idlista.'" data-lista-id="'.$itemmapa->idlista.'" data-time="'.date('Y-m-d H:i:s').'" onclick="return confirma(this);"><i class="fa-solid fa-power-off" style="color: '.$corCirurgiaSuspensa.';"></i></a>';
                                echo anchor('mapacirurgico/suspendercirurgia/'.$itemmapa->id, '<i class="fa-solid fa-power-off" style="color: '.$corCirurgiaSuspensa.';"></i>', array('title' => 'Suspender Cirurgia', 'onclick' => 'mostrarAguarde(event, this.href)'));
                            } else {
                                echo '<span style="color: gray; cursor: not-allowed;"><i class="fa-solid fa-power-off" style="color: gray;"></i></span>';
                            }
                        ?>
                    </td>
                    <td style="text-align: center; vertical-align: middle;">
                        <?php
                            //if ($status_cirurgia != "Suspensa" && $status_cirurgia != "Cancelada" && $status_cirurgia != "TrocaPaciente" && $status_cirurgia != "Realizada" && HUAP_Functions::tem_permissao('mapacirurgico-alterar')) {
                            if (in_array($status_cirurgia, ["Programada", "NoCentroCirurgico"]) && HUAP_Functions::tem_permissao('mapacirurgico-alterar')) {

                                $params = array(
                                    'idlista' => $itemmapa->idlista,
                                    'idmapa' => $itemmapa->id,
                                    'idfila' => $itemmapa->idfila,
                                    'fila' => $itemmapa->fila,
                                    'ordemfila' =>$itemmapa->ordem_fila,
                                    'idespecialidade' => $itemmapa->idespecialidade,
                                    'prontuario' => $itemmapa->prontuario,
                                    'dthrcirurgia' => $itemmapa->dthrcirurgia
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
                            //if ($status_cirurgia != "Suspensa"  && $status_cirurgia != "Cancelada" && $status_cirurgia != "TrocaPaciente" && $status_cirurgia != "Realizada" && HUAP_Functions::tem_permissao('mapacirurgico-alterar')) {
                            if (!in_array($status_cirurgia, ["Suspensa", "Cancelada", "TrocaPaciente", "Realizada"]) && $permiteatualizar && HUAP_Functions::tem_permissao('mapacirurgico-alterar')) {

                                echo anchor('mapacirurgico/atualizarhorarioscirurgia/'.$itemmapa->id, '<i class="fa-regular fa-clock"></i>', array('title' => 'Atualizar Horários', 'onclick' => 'mostrarAguarde(event, this.href)'));
                            } else {
                                echo '<span style="color: gray; cursor: not-allowed;"><i class="fa-regular fa-clock" style="color: gray;"></i></span>';
                            }
                        ?>
                    </td>         
                    <td style="text-align: center; vertical-align: middle;">
                        <?php
                            //if ($status_cirurgia != "Suspensa" && $status_cirurgia != "Cancelada" && $status_cirurgia != "TrocaPaciente" && $status_cirurgia != "Realizada" && HUAP_Functions::tem_permissao('mapacirurgico-alterar')) {
                            if (!in_array($status_cirurgia, ["Suspensa", "Cancelada", "TrocaPaciente", "Realizada"]) && HUAP_Functions::tem_permissao('mapacirurgico-alterar')) {

                                echo anchor('mapacirurgico/atualizarcirurgia/'.$itemmapa->id, '<i class="fas fa-pencil-alt"></i>', array('title' => 'Atualizar Cirurgia', 'onclick' => 'mostrarAguarde(event, this.href)'));
                            } else {
                                echo '<span style="color: gray; cursor: not-allowed;"><i class="fas fa-pencil-alt" style="color: gray;"></i></span>';
                            }
                        ?>
                    </td>    
                    <td style="text-align: center; vertical-align: middle;">
                        <?php
                            if(HUAP_Functions::tem_permissao('mapacirurgico-consultar')) { 
                               /*  echo '<a href="#" title="Detalhes do Paciente"
                                 data-prontuario="' . $itemmapa->prontuario . '"
                                 data-nome_paciente="' . $itemmapa->nome_paciente . '"
                                 data-ordem="' . $itemmapa->ordem_fila . '"
                                 data-fila="' . $itemmapa->fila . '"
                                 data-especialidade="' . $itemmapa->especialidade_descricao . '"
                                 data-procedimento="' . $itemmapa->procedimento_principal . '"
                                 onclick="consultaDetalhes(this);"><i class="fa-solid fa-magnifying-glass"></i></a>'; */
                                 echo anchor('mapacirurgico/consultarcirurgia/'.$itemmapa->id, '<i class="fa-solid fa-magnifying-glass"></i>', array('title' => 'Consultar Cirurgia', 'onclick' => 'mostrarAguarde(event, this.href)'));
                            } else {
                                echo '<span style="color: gray; cursor: not-allowed;" title="Você não tem permissão para consultar."><i class="fa-solid fa-magnifying-glass"></i></span>';
                            } 
                        ?>
                    </td>       
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="container-legend mt-3">
        <a class="btn btn-warning" href="<?= base_url('mapacirurgico/consultar') ?>">
            <i class="fa-solid fa-arrow-left"></i> Voltar
        </a>
    </div>
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
    let evento;

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

    // Exibe a SweetAlert para confirmar a ação
    Swal.fire({
        title: message,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ok',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $('#janelaAguarde').show(); // Mostra a janela de aguardo

            // Chama a função para tratar o link somente após confirmação
            tratarLink(link, evento);
        } else {
            // Ação ao cancelar, se necessário
            $('#janelaAguarde').hide(); // Esconde a janela de aguardo se necessário
        }
    });

    return false; // Queremos prevenir o comportamento padrão do link
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
                    //window.history.back();
                    //window.location.reload();
                    window.location.href = "<?= base_url('mapacirurgico/exibir') ?>";
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

    function carregarDadosModal(dados) {

        $.ajax({
            url: '/listaespera/carregadadosmodal', // Rota do seu método PHP
            //url: '<--?= base_url('listaespera/carregadadosmodal/') ?>' + prontuario,
            type: 'GET',
            data: { prontuario: dados.prontuario }, // Envia o ID como parâmetro
            dataType: 'json',
            success: function(paciente) {
                // Função para verificar se o valor é nulo ou vazio
                function verificarValor(valor) {
                    
                    return (valor === null || valor === '') ? 'N/D' : valor;
                }

                function verificarOutroValor(valor) {
                    
                    return (valor === null || valor === '') ? '' : ' - ' + valor;
                }

                
                let telefonesHtml = '';
                if (paciente.contatos && paciente.contatos.length > 0) {
                    // Verifica se há mais de um telefone
                    paciente.contatos.forEach((contato, index) => {
                        const dddFormatado = contato.ddd ? `(${verificarValor(contato.ddd)})` : '';
                        const nroFoneFormatado = verificarValor(contato.nro_fone).replace(/(\d{5})(\d+)/, '$1-$2'); // Adiciona o hífen após o 5º dígito
                        const observacaoFormatada = contato.observacao ? `(${verificarValor(contato.observacao)})` : '';

                        if (paciente.contatos.length > 1) {
                            // Se houver mais de um telefone, exibe o índice
                            telefonesHtml += `<strong>Tel ${index + 1}:</strong> ${dddFormatado} ${nroFoneFormatado} ${observacaoFormatada}<br>`;
                        } else {
                            // Se houver apenas um telefone, não exibe o índice
                            telefonesHtml += `<strong>Tel:</strong> ${dddFormatado} ${nroFoneFormatado} ${observacaoFormatada}<br>`;
                        }
                    });
                } else {
                    // Se não houver nenhum telefone, exibe "Tel: N/D"
                    telefonesHtml = '<strong>Tel:</strong> N/D<br>';
                }

                // Atualiza o conteúdo do modal para a coluna esquerda
                $('#colunaEsquerda1').html(`
                    <strong>Prontuario:</strong> ${verificarValor(paciente.prontuario)}<br>
                    <strong>Nome:</strong> ${verificarValor(paciente.nome)}<br>
                    <strong>Nome da Mãe:</strong> ${verificarValor(paciente.nm_mae)}<br>
                    <strong>Sexo:</strong> ${verificarValor(paciente.sexo)}<br>
                    <strong>Data Nascimento:</strong> ${verificarValor(paciente.dt_nascimento)}<br>
                    <strong>Idade:</strong> ${verificarValor(paciente.idade)}<br>
                    <strong>CPF:</strong> ${verificarValor(paciente.cpf)}<br>
                    <strong>CNS:</strong> ${verificarValor(paciente.cns)}<br>
                `);

                // Atualiza o conteúdo do modal para a coluna direita
                $('#colunaDireita1').html(`
                    <strong>Endereço:</strong> ${verificarValor(paciente.logradouro)}, ${verificarValor(paciente.num_logr)} ${verificarOutroValor(paciente.compl_logr)}<br>
                    <strong>Cidade:</strong> ${verificarValor(paciente.cidade)}<br>
                    <strong>Bairro:</strong> ${verificarValor(paciente.bairro)}<br>
                    <strong>CEP:</strong> ${verificarValor(paciente.cep)}<br>
                    <strong>Email:</strong> ${verificarValor(paciente.email)}<br>
                    ${telefonesHtml}
                `);
                $('#colunaEsquerda2').html(`
                    <strong>Centro Cirúrgico:</strong> ${verificarValor(dados.centrocir)} ${verificarOutroValor(dados.sala)}<br>
                    <strong>Especialidade:</strong> ${dados.especialidade}<br>
                    <strong>Fila:</strong> ${dados.fila}<br>
                    <strong>Procedimento:</strong> ${dados.procedimento}<br>
                    <strong>Risco:</strong> ${dados.risco}<br>
                    <strong>Data Risco:</strong> ${dados.dtrisco}<br>
                    <strong>CID:</strong> ${dados.cid}<br>
                    <strong>Complexidade:</strong> ${dados.complexidade}<br>
                `);

                // Atualiza o conteúdo do modal para a coluna direita
                $('#colunaDireita2').html(`
                    <strong>Lateralidade:</strong> ${dados.lateralidade}<br>
                    <strong>Congelação:</strong> ${dados.congelacao}<br>
                    <strong>Hemoderivados:</strong> ${dados.hemo}<br>
                    <strong>Pós-Operatório:</strong> ${dados.posoperatorio}<br>
                    <strong>Informações Adicionais:</strong> ${dados.infoadic}<br>
                    <strong>Necessidades do Procedimento:</strong> ${dados.necesspro}<br>
                `);
/* 

                    <strong>Entrada no Centro Cirúrgico:</strong> ${verificarValor(dados.hrnocentro)}<br>
                    <strong>Início da Cirurgia:</strong> ${verificarValor(dados.hremcirurgia)}<br>
                    <strong>Saída da Sala:</strong> ${verificarValor(dados.hrsaidasl)}<br>
                    <strong>Saída do Centro Cirúrgico:</strong> ${verificarValor(dados.hrsaidacc)}<br>
                $('#linha').html(`
                    <strong>Informações Adicionais:</strong> ${verificarValor(infoadic)}<br>
                `); */

                // Mostra o modal
                $('#modalDetalhes').modal('show');
            },
            error: function(xhr, status, error) {
                console.error('Erro ao carregar os dados:', error);
            }
        });
    }

    function consultaDetalhes(element) {

        // Obtenha os dados da linha clicada
        const row = element.closest('tr');
        const columns = row.querySelectorAll('td');

        //alert(columns[2]?.innerText);

        var dadosAdicionais = {
            prontuario: element.getAttribute('data-prontuario'),
            nome_paciente: element.getAttribute('data-nome_paciente'),
            fila:  element.getAttribute('data-fila'),
            especialidade: element.getAttribute('data-especialidade'),
            procedimento: element.getAttribute('data-procedimento'),
            ordem: element.getAttribute('data-ordem'),
        };

        if (dadosAdicionais.ordem == 0) {
            dadosAdicionais.ordem = '-';
        }

        var dadosCompletos = {  
                centrocir: columns[1]?.innerText, 
                sala: columns[2]?.innerText, 
                dthrcir: columns[3]?.innerText, 
                hrnocentro: columns[4]?.innerText, 
                hremcirurgia: columns[5]?.innerText, 
                hrsaidasl: columns[6]?.innerText, 
                hrsaidacc: columns[7]?.innerText,
                ...dadosAdicionais
        };

        carregarDadosModal(dadosCompletos);
    }


  $(document).ready(function() {

    var primeiraVez = true;
    var voltarPaginaAnterior = <?= json_encode($data['pagina_anterior']) ?>;

    $('#janelaAguarde').show();

    $('[data-toggle="tooltip"]').tooltip();
    
    $('#table').DataTable({
        "order": [[0, 'asc']],
        "lengthChange": true,
        "pageLength": 17,
        "lengthMenu": [[10, 20, 50, 75, -1], [10, 20, 50, 75, "Tudo"]],
        "language": {
            "url": "<?= base_url('assets/DataTables/i18n/pt-BR.json') ?>"
        },
        "autoWidth": false,
        "scrollX": true,
        "columns": [
                { "width": "0px" },  // Primeira coluna
                { "width": "40px" },       
                { "width": "160px" },  // dthr
                { "width": "250px" },  // centro cir
                { "width": "150px" }, 
                { "width": "55px" }, 
                { "width": "55px" }, 
                { "width": "55px" }, 
                { "width": "55px" }, 
                { "width": "200px" },  // especial
                { "width": "250px" },  // fila
                { "width": "100px" },  // 
                { "width": "250px" },  // Nome
                { "width": "35px" },  // 
                { "width": "35px" },  // 
                { "width": "35px" },  // 
                { "width": "35px" },  // 
                { "width": "35px" },  // 
                { "width": "35px" },  // 
                { "width": "35px" },  // 
                { "width": "35px" },  // 
                { "width": "35px" },  // 
                { "width": "100px" },  // 
                { "width": "100px" },  // 
                { "width": "100px" },  // 
                { "width": "100px" },  // 
                { "width": "100px" },  // 
                { "width": "100px" },  // 
                { "width": "100px" },  // 
                { "width": "100px" },  // 
                { "width": "100px" },  // 
                { "width": "100px" },  // 
                { "width": "100px" },  // 
                { "width": "100px" },  // 
                { "width": "100px" },  // 
                { "width": "100px" },  // 

            ],
        "columnDefs": [
/*             { "orderable": false, "targets": [0, 1, 5, 6, 7, 8, 13, 14, 15, 16, 17, 18, 19, 20, 21] },
 */            { "orderable": true, "targets": [2, 3, 4, 9, 10, 11, 12] },
            { "visible": false, "targets": [0] }
        ],
        layout: { topStart: {
             buttons: [
            {
                extend: 'colvis', // Botão para exibir/inibir colunas
                text: 'Colunas', // Texto do botão
                columns: [2, 3, 4, 9, 10, 11, 12] // Especifica quais colunas são visíveis
            },
            'copy',
            'csv',
            'excel',
            'pdf',
            'print' 
        ] } },
        "deferRender": true,
            initComplete: function() {
                $('#janelaAguarde').hide();
                $('#table tbody tr td').addClass('break-line');
            }
    });

    var table = $('#table').DataTable();

    table.on('processing.dt', function(e, settings, processing) {
            if (processing) {
                $('#janelaAguarde').show(); // Exibir o modal
            } else {
                $('#janelaAguarde').hide(); // Esconder o modal
            }
        });

    $('#table tbody').on('dblclick', 'tr', function(event) {
        event.preventDefault();

        var dadosAdicionais = {
            prontuario: $(this).data('prontuario'),
            nome_paciente: $(this).data('nome_paciente'),
            fila: $(this).data('fila'),
            especialidade: $(this).data('especialidade'),
            cid: $(this).data('cid'),
            procedimento: $(this).data('procedimento'),
            ordem: $(this).data('ordem'),
            complexidade: $(this).data('complexidade'),
            risco: $(this).data('risco'),
            dtrisco: $(this).data('dtrisco'),
            lateralidade: $(this).data('lateralidade'),
            congelacao: $(this).data('congelacao'),
            hemo: $(this).data('hemo'),
            posoperatorio: $(this).data('posoperatorio'),
            infoadic: $(this).data('infoadic'),
            necesspro: $(this).data('necesspro'),

        };

        if (dadosAdicionais.ordem == 0) {
            dadosAdicionais.ordem = '-';
        }

        if (dadosAdicionais.complexidade === 'A') {
            dadosAdicionais.complexidade = 'Alta';
        } else if (dadosAdicionais.complexidade === 'M') {
            dadosAdicionais.complexidade = 'Média';
        } else if (dadosAdicionais.complexidade === 'B') {
            dadosAdicionais.complexidade = 'Baixa';
        }

        //alert(dadosAdicionais.complexidade);
        
        // Obtenha os dados da linha clicada
        var data = table.row(this).data();

        var dadosCompletos = {
                dthrcir: data[2], 
                centrocir: data[3], 
                sala: data[4], 
                hrnocentro: data[5], 
                hremcirurgia: data[6], 
                hrsaidasl: data[7], 
                hrsaidacc: data[8],
                ...dadosAdicionais
        };

        //alert(prontuario);
        carregarDadosModal(dadosCompletos);

        //$('#modalDetalhes').modal('show');
    });

    // Função para exibir os dados na seção aside
    function displayAsideContent(paciente) {
        let complexidadeDescricao;

        switch (paciente.complexidade) {
            case 'A':
                complexidadeDescricao = 'ALTA';
                break;
            case 'B':
                complexidadeDescricao = 'BAIXA';
                break;
            case 'M':
                complexidadeDescricao = 'MÉDIA';
                break;
            default:
                complexidadeDescricao = 'Indefinida'; // Valor padrão para casos inesperados
                break;
        }

        if (paciente.ordem === 0) {
            paciente.ordem = '-';
        }

        var htmlContent = `
            <h6><strong>Paciente</strong></h6>
            <table class="table table-left-aligned table-smaller-font">
                <tbody>
                    <tr>
                        <td title="Ordem na Fila antes de ser enviado ao Mapa" width="40%"><i class="fa-solid fa-hashtag"></i> Ordem Fila:</td>
                        <td title="Ordem na Fila antes de ser enviado ao Mapa"><b>${paciente.ordem}</b></td>
                    </tr>
                    <tr>
                        <td width="40%"><i class="fa-solid fa-users-line"></i> Fila:</td>
                        <td><b>${paciente.fila}</b></td>
                    </tr>
                    <tr>
                        <td width="40%"><i class="fa-solid fa-folder"></i> Prontuário:</td>
                        <td><b>${paciente.prontuario}</b></td>
                    </tr>
                    <tr>
                        <td width="40%"><i class="fa-solid fa-user"></i> Nome:</td>
                        <td><b>${paciente.nome}</b></td>
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
                        <td><b>${complexidadeDescricao}</b></td>
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
        /* var paciente = {
            prontuario: $(this).data('prontuario'),
            nome: $(this).data('nome_paciente'),
            especialidade: $(this).data('especialidade'),
            cid: $(this).data('cid'),
            procedimento: $(this).data('procedimento'),
            ordem: $(this).data('ordem'),
            complexidade: $(this).data('complexidade'),
            fila:  $(this).data('fila')
        }; */

        // Exibe as informações do paciente na seção aside
        //displayAsideContent(paciente);
    });

    function markFirstRecordSelected() {
        // Obter o índice do primeiro registro na página
        var firstRecordIndex = table.page.info().start;
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

        if (voltarPaginaAnterior === 'S' && primeiraVez) {
            var paginaAnterior = sessionStorage.getItem('paginaSelecionada');

            if (paginaAnterior !== null) {
                primeiraVez = false;
                table.page(parseInt(paginaAnterior)).draw(false);
            }
        } 

        var paginaAtual = table.page();
        sessionStorage.setItem('paginaSelecionada', paginaAtual);

        // Chama markFirstRecordSelected, que não deve causar recursão
        markFirstRecordSelected();

    });

});

</script>

