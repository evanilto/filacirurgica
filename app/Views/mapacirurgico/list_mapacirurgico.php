<?php
    use App\Libraries\HUAP_Functions;

use function PHPUnit\Framework\isEmpty;

    //session()->set('parametros_consulta_mapa', $data); 
    $corProgramada = 'yellow';
    $corPacienteSolicitado = 'gold';
    $corNoCentroCirúrgico = '#97DA4B';
    $corEmCirurgia = '#277534';//'#804616';
    $corSaídaDaSala = '#87CEFA';
    $corSaídaCentroCirúrgico = '#00008B'; //'#277534';
    $corTrocaPaciente = 'DarkOrange'; //'#FF7F7F';//'#E9967A';
    $corCirurgiaSuspensa = 'Red';
    $corCirurgiaCancelada = $corCirurgiaSuspensa;
?>
 
<link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/4.0.1/css/fixedHeader.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/5.0.4/css/fixedColumns.dataTables.min.css">

<script>$('#janelaAguarde').show();</script>

<div class="table-container mt-3">
    <table class="table">
        <thead style="border: 1px solid black;">
            <tr>
                <th scope="row" colspan="7" class="bg-light text-start" >
                    <h5><strong>Mapa Cirúrgico</strong></h5>
                </th>
            </tr>
        </thead>
    </table>
    <table class="table table-hover table-bordered table-smaller-font table-striped" id="table">
        <thead>
            <tr>
                <th scope="col" class="col-0" >idMapa</th>
                <th scope="col" class="col-0" title='Situação do Paciente'>Sit.</th>
                <th scope="col" data-field="col-0" >Data Cirurgia</th>
                <th scope="col" data-field="col-0" >Hora</th>
                <th scope="col" data-field="col-0" >Tempo Previsto</th>
                <th scope="col" class="col-0" >Centro Cirúrgico</th>
                <th scope="col" class="col-0" >Sala</th>
                <th scope="col" class="col-0" style="text-align: center; vertical-align: middle;" title="Paciente Solicitado">
                        <i class="fa-solid fa-circle" style="color: <?= $corPacienteSolicitado ?>; "></i>
                </th>
                <th scope="col" class="col-0" style="text-align: center; vertical-align: middle;" title="Paciente no Centro Cirúrgico">
                        <i class="fa-solid fa-circle" style="color: <?= $corNoCentroCirúrgico ?>; "></i>
                </th>
                <th scope="col" class="col-0" style="text-align: center; vertical-align: middle;" title="Paciente em Cirurgia">
                        <i class="fa-solid fa-circle" style="color: <?= $corEmCirurgia ?>; "></i>
                </th>
                <th scope="col" class="col-0" style="text-align: center; vertical-align: middle;" title="Paciente saiu da Sala">
                        <i class="fa-solid fa-circle" style="color: <?= $corSaídaDaSala ?>; "></i>
                </th>
                <th scope="col" class="col-0" style="text-align: center; vertical-align: middle;" title="Paciente saiu do Centro Cirúrgico (cirurgia realizada)">
                        <i class="fa-solid fa-circle" style="color: <?= $corSaídaCentroCirúrgico ?>; "></i>
                </th>
                <th scope="col" class="col-0" >Especialidade</th>
                <th scope="col" data-field="prontuario" >Prontuario</th>
                <th scope="col" data-field="nome" >Nome do Paciente</th>
                <th scope="col" data-field="nome" >Idade</th>
                <th scope="col" data-field="nome" >Sexo</th>
                <th scope="col" data-field="nome" >Procedimento Principal</th>
                <th scope="col" data-field="nome" >Procedimentos Adicionais</th>
                <th scope="col" data-field="nome" >Lateralidade</th>
                <th scope="col" data-field="nome" >CID</th>
                <th scope="col" data-field="nome" >CID Descrição<output></output></th>
                <th scope="col" data-field="nome" >Necessidades Procedimento</th>
                <th scope="col" data-field="nome" >Info Adicionais</th>
                <th scope="col" data-field="nome" >Equipe</th>
                <th scope="col" class="col-0" >Fila</th>
                <th scope="col" data-field="nome" >Pós-Operatório</th>
                <th scope="col" data-field="nome" >Congel.</th>
                <th scope="col" data-field="nome" >Hemod.</th>
                <th scope="col" data-field="nome" >OPME</th>
                <th scope="col" data-field="eqpts" >Equipamentos Necessários</th>
                <th scope="col" data-field="nome" >Risco</th>
                <th scope="col" data-field="nome" >Data Risco</th>
                <th scope="col" data-field="nome" >Origem</th>
                <th scope="col" data-field="nome" >Complex.</th>
            </tr>
        </thead>
        <tbody>
            <?php

                foreach($mapacirurgico as $itemmapa): 
                    $itemmapa->created_at = \DateTime::createFromFormat('Y-m-d H:i:s', $itemmapa->created_at)->format('d/m/Y H:i');
                    $itemmapa->data_risco = $itemmapa->dtrisco ? \DateTime::createFromFormat('Y-m-d', $itemmapa->dtrisco)->format('d/m/Y') : '';

                    $permiteatualizar = true;
                    
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
                            case 'PacienteSolicitado':
                                $color =$corPacienteSolicitado;
                                $background_color = $color;
                                $title = 'Paciente Solicitado';
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

                    if ($itemmapa->indurgencia == 'S') {
                        $border = '2px solid white; box-shadow: 0 0 0 3px red;';
                        //$title = $title.' Urgente';
                    } else {
                        $border = 'none;';
                    }
            ?>
                <tr
                    data-idmapa="<?= $itemmapa->id ?>" 
                    data-idlista="<?= $itemmapa->idlista ?>" 
                    data-dthrcirurgia="<?= $itemmapa->dthrcirurgia ?>" 
                    data-prontuario="<?= $itemmapa->prontuario ?>" 
                    data-nome_paciente="<?= $itemmapa->nome_paciente ?>" 
                    data-idfila="<?= $itemmapa->idfila ?>"
                    data-fila="<?= $itemmapa->fila ?>"
                    data-idespecialidade="<?= $itemmapa->idespecialidade ?>"
                    data-especialidade="<?= $itemmapa->especialidade_descricao ?>"
                    data-cid_codigo="<?= $itemmapa->cid_codigo ?>"
                    data-cid="<?= $itemmapa->cid_descricao ?>"
                    data-idprocedimento="<?= $itemmapa->idprocedimento ?>"
                    data-procedimento="<?= $itemmapa->procedimento_principal ?>"
                    data-procedimentosadicionais="<?= $itemmapa->procedimentos_adicionais ?>"
                    data-equipe="<?= $itemmapa->equipe_cirurgica ?>"
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
                    data-opme="<?= $itemmapa->opme ?>"
                    data-equipamentos="<?= $itemmapa->equipamentos_cirurgia ?>"
                    data-origem="<?= htmlspecialchars($itemmapa->origem_descricao, ENT_QUOTES, 'UTF-8') ?>"
                    data-indurgencia="<?= $itemmapa->indurgencia ?>"
                    data-statuscirurgia="<?= $status_cirurgia ?>"
                    data-permiteatualizar="<?= $permiteatualizar ?>"
                    data-tempermissaoconsultar="<?= HUAP_Functions::tem_permissao('mapacirurgico-consultar') ?>"
                    data-tempermissaoalterar="<?= HUAP_Functions::tem_permissao('mapacirurgico-alterar') ?>"
                    >
                    
                    <td><?php echo $itemmapa->dthrcirurgia ?></td>
                    <td style="text-align: center; vertical-align: middle;">
                        <i 
                            class="fa-solid fa-circle" 
                            style="color: <?= $color ?>; background-color: <?= $background_color ?>; border: <?= $border ?>; border-radius: 50%;" 
                            title="<?= $title ?>"
                        ></i>
                    </td>
                    <td><?php echo DateTime::createFromFormat('Y-m-d H:i:s', $itemmapa->dthrcirurgia)->format('d/m/Y') ?></td>
                    <td><?php echo DateTime::createFromFormat('Y-m-d H:i:s', $itemmapa->dthrcirurgia)->format('H:i') ?></td>
                    <td><?php echo !is_null($itemmapa->tempoprevisto) ? DateTime::createFromFormat('H:i:s', $itemmapa->tempoprevisto)->format('H:i') : ''; ?></td>
                    <td class="break-line" title="<?php echo htmlspecialchars($itemmapa->centrocirurgico); ?>">
                        <?php echo htmlspecialchars($itemmapa->centrocirurgico); ?>
                    </td>
                    <td class="break-line" title="<?php echo htmlspecialchars($itemmapa->sala); ?>">
                        <?php echo htmlspecialchars($itemmapa->sala); ?>
                    </td>
                    <td><?php echo $itemmapa->dthrpacientesolicitado ? DateTime::createFromFormat('Y-m-d H:i:s', $itemmapa->dthrpacientesolicitado)->format('H:i') : ' ' ?></td>
                    <td><?php echo $itemmapa->dthrnocentrocirurgico ? DateTime::createFromFormat('Y-m-d H:i:s', $itemmapa->dthrnocentrocirurgico)->format('H:i') : ' ' ?></td>
                    <td><?php echo $itemmapa->dthremcirurgia ? DateTime::createFromFormat('Y-m-d H:i:s', $itemmapa->dthremcirurgia)->format('H:i') : ' ' ?></td>
                    <td><?php echo $itemmapa->dthrsaidasala ? DateTime::createFromFormat('Y-m-d H:i:s', $itemmapa->dthrsaidasala)->format('H:i') : ' ' ?></td>
                    <td><?php echo $itemmapa->dthrsaidacentrocirurgico ? DateTime::createFromFormat('Y-m-d H:i:s', $itemmapa->dthrsaidacentrocirurgico)->format('H:i') : ' ' ?></td>
                    <td class="break-line" title="<?php echo htmlspecialchars($itemmapa->especialidade_descr_reduz); ?>">
                        <?php echo htmlspecialchars($itemmapa->especialidade_descr_reduz); ?>
                    </td>
                    <td><?php echo $itemmapa->prontuario ?></td>
                    <td class="break-line" title="<?php echo htmlspecialchars($itemmapa->nome_paciente); ?>">
                        <?php echo htmlspecialchars($itemmapa->nome_paciente); ?>
                    </td>
                    <td><?php echo $itemmapa->idade ?></td>
                    <td><?php echo $itemmapa->sexo ?></td>
                    <td class="break-line" title="<?php echo htmlspecialchars($itemmapa->procedimento_principal); ?>">
                        <?php echo htmlspecialchars($itemmapa->procedimento_principal); ?>
                    </td>
                    <td class="break-line" title="<?php echo htmlspecialchars($itemmapa->procedimentos_adicionais); ?>">
                        <?php echo htmlspecialchars($itemmapa->procedimentos_adicionais); ?>
                    </td>
                    <td><?php echo $itemmapa->nmlateralidade ?></td>
                    <td><?php echo $itemmapa->cid_codigo ?></td>
                    <td class="break-line" title="<?php echo htmlspecialchars($itemmapa->cid_descricao); ?>">
                        <?php echo htmlspecialchars($itemmapa->cid_descricao); ?>
                    </td>
                    <td class="break-line" title="<?php echo htmlspecialchars($itemmapa->necessidadesproced); ?>">
                        <?php echo htmlspecialchars($itemmapa->necessidadesproced); ?>
                    </td>
                    <td class="break-line" title="<?php echo htmlspecialchars($itemmapa->infoadicionais); ?>">
                        <?php echo htmlspecialchars($itemmapa->infoadicionais); ?>
                    </td>
                    <td class="break-line" title="<?php echo htmlspecialchars($itemmapa->equipe_cirurgica); ?>">
                        <?php echo htmlspecialchars($itemmapa->equipe_cirurgica); ?>
                    </td>
                    <td class="break-line" title="<?php echo htmlspecialchars($itemmapa->fila); ?>">
                        <?php echo htmlspecialchars($itemmapa->fila); ?>
                    </td>
                    <td><?php echo $itemmapa->posoperatorio ?></td>
                    <td><?php echo $itemmapa->congelacao ?></td>
                    <td><?php echo $itemmapa->hemoderivados ?></td>
                    <td><?php echo $itemmapa->opme ?></td>
                    <td class="break-line" title="<?php echo htmlspecialchars($itemmapa->equipamentos_cirurgia); ?>">
                        <?php echo htmlspecialchars($itemmapa->equipamentos_cirurgia); ?>
                    </td>
                    <td><?php echo $itemmapa->risco_descricao ?></td>
                    <td><?php echo $itemmapa->dtrisco ? DateTime::createFromFormat('Y-m-d', $itemmapa->dtrisco)->format('d/m/Y') : NULL ?></td>
                    <td class="break-line" title="<?php echo htmlspecialchars($itemmapa->origem_descricao); ?>">
                        <?php echo htmlspecialchars($itemmapa->origem_descricao); ?>
                    </td>
                    <td><?php echo $itemmapa->nmcomplexidade ?></td>
                    
                    
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="container-legend mt-2">
        <a class="btn btn-warning" href="<?= base_url('mapacirurgico/consultar') ?>">
            <i class="fa-solid fa-arrow-left"></i> Voltar
        </a>
        <button class="btn btn-primary" id="pacientesolicitado" disabled> Paciente Solicitado</button>
        <button class="btn btn-primary" id="nocentrocirurgico" disabled> No Centro Cirúrgico </button>
        <button class="btn btn-primary" id="emcirurgia" disabled> Em Cirurgia </button>
        <button class="btn btn-primary" id="saidadasala" disabled> Saída da Sala </button>
        <button class="btn btn-primary" id="saidadoccirurgico" disabled> Saída C. Cirúrgico </button>
        <button class="btn btn-primary" id="trocar" disabled> Trocar </button>
        <button class="btn btn-primary" id="suspender" disabled> Suspender </button>
        <button class="btn btn-primary" id="atualizarhorarios" disabled> Horários </button>
        <button class="btn btn-primary" id="editar" disabled> Editar </button>
        <button class="btn btn-primary" id="consultar" disabled> Consultar </button>
    </div>
</div>

<script src="https://cdn.datatables.net/fixedheader/4.0.1/js/dataTables.fixedHeader.min.js"></script>
<script src="https://cdn.datatables.net/fixedcolumns/5.0.4/js/dataTables.fixedColumns.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const table = document.getElementById("table");
        const pacientesolicitado = document.getElementById("pacientesolicitado");
        const nocentrocirurgico = document.getElementById("nocentrocirurgico");
        const emcirurgia = document.getElementById("emcirurgia");
        const saidadasala = document.getElementById("saidadasala");
        const saidadoccirurgico = document.getElementById("saidadoccirurgico");

        let selectedRow = null;

        table.querySelectorAll("tbody tr").forEach(row => {
            row.addEventListener("click", function () {
                // Remove a classe "lineselected" de todas as linhas, incluindo colunas fixadas
                document.querySelectorAll(".lineselected").forEach(selected => {
                    selected.classList.remove("lineselected");
                });

                // Atualiza a linha selecionada
                selectedRow = this;
                selectedRow.classList.add("lineselected");

                // Atualiza as colunas fixadas com a classe "lineselected"
                const tableId = "#table"; // Substitua pelo ID real da tabela
                const rowIndex = $(this).index();
                $(`${tableId} .DTFC_LeftWrapper tbody tr`).eq(rowIndex).addClass("lineselected");
                $(`${tableId} .DTFC_RightWrapper tbody tr`).eq(rowIndex).addClass("lineselected");

                // Atualize os botões e permissões
                const statuscirurgia = selectedRow.dataset.statuscirurgia;
                const permiteatualizar = Number(selectedRow.dataset.permiteatualizar);
                const tempermissaoalterar = Number(selectedRow.dataset.tempermissaoalterar);
                const tempermissaoconsultar = Number(selectedRow.dataset.tempermissaoconsultar);

                const cirurgiaurgente = selectedRow.dataset.indurgencia;

                console.log(statuscirurgia, permiteatualizar, tempermissaoalterar);

                // Desabilite todos os botões inicialmente
                [
                    pacientesolicitado,
                    nocentrocirurgico,
                    emcirurgia,
                    saidadasala,
                    saidadoccirurgico,
                    suspender,
                    trocar,
                    atualizarhorarios,
                    editar,
                    consultar
                ].forEach(button => {
                    button.disabled = true;
                    button.setAttribute("disabled", true);
                    button.style.backgroundColor = '';
                });

                // Atualize os botões com base nas permissões e status
                if (statuscirurgia === "Programada" && permiteatualizar && tempermissaoalterar) {
                    pacientesolicitado.disabled = false;
                    pacientesolicitado.removeAttribute("disabled");
                    pacientesolicitado.style.backgroundColor = "<?= $corPacienteSolicitado ?>";
                } else if (statuscirurgia === "PacienteSolicitado" && permiteatualizar && tempermissaoalterar) {
                    nocentrocirurgico.disabled = false;
                    nocentrocirurgico.removeAttribute("disabled");
                    nocentrocirurgico.style.backgroundColor = "<?= $corNoCentroCirúrgico ?>";
                } else if (statuscirurgia === "NoCentroCirurgico" && permiteatualizar && tempermissaoalterar) {
                    emcirurgia.disabled = false;
                    emcirurgia.removeAttribute("disabled");
                    emcirurgia.style.backgroundColor = "<?= $corEmCirurgia ?>";
                } else if (statuscirurgia === "EmCirurgia" && permiteatualizar && tempermissaoalterar) {
                    saidadasala.disabled = false;
                    saidadasala.removeAttribute("disabled");
                    saidadasala.style.backgroundColor = "<?= $corSaídaDaSala ?>";
                } else if (statuscirurgia === "SaídaDaSala" && permiteatualizar && tempermissaoalterar) {
                    saidadoccirurgico.disabled = false;
                    saidadoccirurgico.removeAttribute("disabled");
                    saidadoccirurgico.style.backgroundColor = "<?= $corSaídaCentroCirúrgico ?>";
                }

                if (["Programada", "PacienteSolicitado", "NoCentroCirurgico"].includes(statuscirurgia)) {
                    suspender.disabled = false;
                    suspender.removeAttribute("disabled");
                    suspender.style.backgroundColor = "<?= $corCirurgiaSuspensa ?>";

                    if (cirurgiaurgente == 'N') {
                        trocar.disabled = false;
                        trocar.removeAttribute("disabled");
                        trocar.style.backgroundColor = "<?= $corTrocaPaciente ?>";
                    }

                }

                /* if (!["Suspensa", "Cancelada", "TrocaPaciente", "Realizada", "SaídaCentroCirurgico"].includes(statuscirurgia)) { */
                if (!["Suspensa", "Cancelada", "TrocaPaciente"].includes(statuscirurgia)) {
                    atualizarhorarios.disabled = false;
                    atualizarhorarios.removeAttribute("disabled");

                    /* editar.disabled = false;
                    editar.removeAttribute("disabled"); */

                }

                if (!["Suspensa", "Cancelada", "TrocaPaciente", "Realizada"].includes(statuscirurgia)) {
                    editar.disabled = false;
                    editar.removeAttribute("disabled");
                }

                if (tempermissaoconsultar) {
                    consultar.disabled = false;
                    consultar.removeAttribute("disabled");

                }
            });
        });

        function handleButtonHorarios(buttonId) {
            const button = document.getElementById(buttonId);

            button.addEventListener("click", function () {
                if (selectedRow) {
                    const cirurgia = {
                        status: selectedRow.dataset.statuscirurgia,
                        dthrcirurgia: selectedRow.dataset.dthrcirurgia,
                        mapaId: selectedRow.dataset.idmapa,
                        listaId: selectedRow.dataset.idlista,
                        time: getFormattedTimestamp()
                    };

                    console.log(`Botão ${buttonId} clicado com dados:`, cirurgia);

                    confirma(cirurgia);
                }
            });
        }

        function handleButtonOthers(botao, rotaBase) {
            botao.addEventListener("click", function () {
                if (selectedRow) {
                    const mapaId = selectedRow.dataset.idmapa;

                    if (mapaId) {
                        const url = '<?= base_url('mapacirurgico/') ?>' + rotaBase + '/' + mapaId;
                        window.location.href = url;
                    } else {
                        console.error('ID do mapa não encontrado na linha selecionada.');
                        alert('Erro: Não foi possível encontrar o ID do mapa.');
                    }
                } else {
                    console.error('Nenhuma linha foi selecionada.');
                    alert('Por favor, selecione uma linha antes de continuar.');
                }
            });
        }

        trocar.addEventListener("click", function () {
            if (selectedRow) {
                const statusCirurgia = selectedRow.dataset.statuscirurgia;
                const temPermissao = selectedRow.dataset.tempermissaoalterar;

                if (["Programada", "PacienteSolicitado", "NoCentroCirurgico"].includes(statusCirurgia) && temPermissao) {
                    const params = {
                        idlista: selectedRow.dataset.idlista,
                        idmapa: selectedRow.dataset.idmapa,
                        idfila: selectedRow.dataset.idfila,
                        fila: selectedRow.dataset.fila,
                        idprocedimento: selectedRow.dataset.idprocedimento,
                        ordemfila: selectedRow.dataset.ordem,
                        idespecialidade: selectedRow.dataset.idespecialidade,
                        prontuario: selectedRow.dataset.prontuario,
                        dthrcirurgia: selectedRow.dataset.dthrcirurgia,
                    };

                    const queryString = new URLSearchParams(params).toString();

                    const url = '<?= base_url('mapacirurgico/trocarpaciente') ?>?' + queryString;

                    window.location.href = url;

                } else {
                    console.error('Condições não atendidas para trocar paciente.');
                    alert('Não é possível trocar o paciente. Verifique as permissões e o status da cirurgia.');
                }
            } else {
                console.error('Nenhuma linha foi selecionada.');
                alert('Por favor, selecione uma linha antes de continuar.');
            }
        });

        handleButtonHorarios("pacientesolicitado");
        handleButtonHorarios("nocentrocirurgico");
        handleButtonHorarios("emcirurgia");
        handleButtonHorarios("saidadasala");
        handleButtonHorarios("saidadoccirurgico");
        handleButtonOthers(suspender, 'suspendercirurgia');
        handleButtonOthers(atualizarhorarios, 'atualizarhorarioscirurgia');
        handleButtonOthers(editar, 'atualizarcirurgia');
        handleButtonOthers(consultar, 'consultarcirurgia');
        handleButtonOthers(atualizarhorarios, 'atualizarhorarioscirurgia');

    });

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

    function mostrarAguarde(event, href) {
        event.preventDefault(); // Prevenir o comportamento padrão do link
        $('#janelaAguarde').show();

        // Redirecionar para o link após um pequeno atraso (1 segundo)
        setTimeout(function() {
        window.location.href = href;
        }, 1000);
    }

    function confirma(cirurgia) {
        let message;
        let evento;

        switch (cirurgia.status) {
            case 'Programada':
                evento = 'dthrpacientesolicitado';
                message = 'Confirma a solicitação do paciente para a cirurgia?';
                break;
            case 'PacienteSolicitado':
                evento = 'dthrnocentrocirurgico';
                message = 'Confirma a entrada do paciente no centro cirúrgico?';
                break;
            case 'NoCentroCirurgico':
                evento = 'dthremcirurgia';
                message = 'Confirma o paciente em cirurgia?';
                break;
            case 'EmCirurgia':
                evento = 'dthrsaidasala';
                message = 'Confirma a saída da sala?';
                break;
            case 'SaídaDaSala':
                evento = 'dthrsaidacentrocirurgico';
                message = 'Confirma a saída do centro cirúrgico?';
                break;
            case 'Suspensa':
                evento = 'dthrsuspensao';
                message = 'Confirma a suspensão da cirurgia?';
                break;
            case 'TrocaPaciente':
                evento = 'dthrtroca';
                message = 'Confirma a troca do paciente?';
                break;
            default:
                message = '';
                break;
        }

        Swal.fire({
            title: message,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ok',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#janelaAguarde').show(); // Mostra a janela de aguardo
                
                tratarEventos(cirurgia, evento);
            } else {
                $('#janelaAguarde').hide(); // Esconde a janela de aguardo se necessário
            }
        });

        return false; // Queremos prevenir o comportamento padrão do link
    }

    function tratarEventos(link, evento) {

        $('#janelaAguarde').show();

        // Previnir o comportamento padrão do link
        event.preventDefault(); 

        const mapaId = link.mapaId;
        const listaId = link.listaId;
        const timeValue = link.time;

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

    function tratarCirurgia(cirurgia, url) {
        // Mostra a janela de espera
        $('#janelaAguarde').show();

        // Previne o comportamento padrão do evento
        event.preventDefault();

        const mapaId = cirurgia.mapaId;

        // Prepara os dados para envio
        var formData = new FormData();
        const arrayId = { idMapa: mapaId };
        formData.append('arrayid', JSON.stringify(arrayId));

        // Configura a requisição AJAX
        const xhr = new XMLHttpRequest();
        xhr.open('POST', '<?= base_url('mapacirurgico/') ?>' + url, true);
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

        // Evento para tratar a resposta
        xhr.onload = function() {
            if (xhr.status >= 200 && xhr.status < 400) {
                try {
                    var response = JSON.parse(xhr.responseText);
                    
                    if (response.success) {
                        console.log('Requisição AJAX bem-sucedida.');

                        // Insere o HTML retornado no DOM (substitua "#container" pelo ID correto)
                        $('#container').html(response.html);

                        // Opcional: Fechar a janela de espera após o carregamento
                        $('#janelaAguarde').hide();
                    } else {
                        console.error('Erro no processamento do servidor:', response.message);
                        alert('Erro: ' + response.message);
                    }
                } catch (e) {
                    console.error('Erro ao processar a resposta JSON:', e);
                    alert('Erro no processamento da resposta do servidor.');
                }
            } else {
                console.error('Erro no envio dos dados. Código HTTP:', xhr.status);
                alert('Erro ao realizar a operação. Por favor, tente novamente.');
            }
        };

        // Evento para tratar erros na requisição
        xhr.onerror = function() {
            console.error('Erro na requisição AJAX.');
            alert('Erro na comunicação com o servidor. Por favor, tente novamente.');
        };

        // Envia os dados
        xhr.send(formData);

        return false; // Evita o comportamento padrão
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
                    <strong>Procedimento:</strong> ${dados.idprocedimento} - ${dados.procedimento}<br>
                    <strong>Procedimentos Adicionais:</strong> ${verificarValor(dados.procedimentosadicionais)}<br>
                    <strong>Equipe:</strong> ${verificarValor(dados.equipe)}<br>
                    <strong>Risco:</strong> ${dados.risco}<br>
                    <strong>Data Risco:</strong> ${dados.dtrisco}<br>
                    <strong>CID:</strong> ${dados.cid_codigo} - ${dados.cid}<br>
                    <strong>Complexidade:</strong> ${dados.complexidade}<br>
                    <strong>Origem:</strong> ${dados.origem}<br>
                `);

                // Atualiza o conteúdo do modal para a coluna direita
                $('#colunaDireita2').html(`
                    <strong>Lateralidade:</strong> ${dados.lateralidade}<br>
                    <strong>Congelação:</strong> ${dados.congelacao}<br>
                    <strong>Hemoderivados:</strong> ${dados.hemo}<br>
                    <strong>OPME:</strong> ${verificarValor(dados.opme)}<br>
                    <strong>Equipamentos Necessários:</strong> ${verificarValor(dados.equipamentos)}<br>
                    <strong>Pós-Operatório:</strong> ${dados.posoperatorio}<br>
                    <strong>Necessidades do Procedimento:</strong> ${verificarValor(dados.necesspro)}<br>
                    <strong>Informações Adicionais:</strong> ${verificarValor(dados.infoadic)}<br>
                `);

                $('#modalDetalhes').modal('show');
            },
            error: function(xhr, status, error) {
                console.error('Erro ao carregar os dados:', error);
            }
        });
    }

    $(document).ready(function() {

        var primeiraVez = true;
        var voltarPaginaAnterior = <?= json_encode($data['pagina_anterior']) ?>;

        $('#janelaAguarde').show();

        $('[data-toggle="tooltip"]').tooltip();
        
        $('#table').DataTable({
            "order": [[0, 'asc']],
            "language": {
                "url": "<?= base_url('assets/DataTables/i18n/pt-BR.json') ?>"
            },
            fixedColumns: {
            leftColumns: 11 // Número de colunas a serem fixadas
            },
            fixedHeader: true,
            scrollY: '500px',
            scrollX: true,
            scrollCollapse: true,
            paging: false,
            ordering: true,
            autoWidth: false,
                "columns": [
                    { "width": "0px" },  // Primeira coluna
                    { "width": "40px" },       
                    { "width": "95px" },  // dt
                    { "width": "62px" },  // hr
                    { "width": "75px" },  // tp
                    { "width": "220px" },  // centro cir
                    { "width": "85px" }, 
                    { "width": "55px" }, 
                    { "width": "55px" }, 
                    { "width": "55px" }, 
                    { "width": "55px" }, 
                    { "width": "55px" }, 
                    { "width": "180px" },  // especial
                    { "width": "95px" },  // pront
                    { "width": "250px" },  // nome 
                    { "width": "55px" },  // idade
                    { "width": "100px" },  // sexo
                    { "width": "250px" },  // proc prin
                    { "width": "250px" },  //  proc adic
                    { "width": "140px" },  // lat
                    { "width": "60px" },  // cid
                    { "width": "250px" },  // cid desc
                    { "width": "250px" },  // necess
                    { "width": "250px" },  //  info adic
                    { "width": "250px" },  // equipe
                    { "width": "250px" },  // fila
                    { "width": "120px" },  // posoer
                    { "width": "70px" },  // cong
                    { "width": "70px" },  // hemod
                    { "width": "70px" },  // opme
                    { "width": "350px" },  // equipamentos
                    { "width": "150px" },  // risco
                    { "width": "90px" },  // dt risco
                    { "width": "130px" },  // origem
                    { "width": "100px" },  // complex
                    
                ],
            "columnDefs": [
                { "orderable": false, "targets": [0, 1, 6, 7, 8, 9, 10, 21, 22] },
                { "visible": false, "targets": [0] }
            ],
            layout: { topStart: {
                buttons: [
                {
                    extend: 'colvis', // Botão para exibir/inibir colunas
                    text: 'Colunas', // Texto do botão
                    columns: [2, 3, 4, 5, 6, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30] // Especifica quais colunas são visíveis
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
            'background-color': '#ffffff', /* Altere para a cor desejada */
            'color': '#000',
            'border-color': '#dee2e6'
        });

        $('#table tbody').on('dblclick', 'tr', function(event) {
            event.preventDefault();

            var dadosAdicionais = {
                prontuario: $(this).data('prontuario'),
                nome_paciente: $(this).data('nome_paciente'),
                fila: $(this).data('fila'),
                especialidade: $(this).data('especialidade'),
                cid: $(this).data('cid'),
                cid_codigo: $(this).data('cid_codigo'),
                idprocedimento: $(this).data('idprocedimento'),
                procedimento: $(this).data('procedimento'),
                procedimentosadicionais: $(this).data('procedimentosadicionais'),
                equipe: $(this).data('equipe'),
                ordem: $(this).data('ordem'),
                origem: $(this).data('origem'),
                complexidade: $(this).data('complexidade'),
                risco: $(this).data('risco'),
                dtrisco: $(this).data('dtrisco'),
                lateralidade: $(this).data('lateralidade'),
                congelacao: $(this).data('congelacao'),
                hemo: $(this).data('hemo'),
                opme: $(this).data('opme'),
                equipamentos: $(this).data('equipamentos'),
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

            var data = table.row(this).data();

            var dadosCompletos = {
                    dthrcir: data[2], 
                    centrocir: data[5], 
                    sala: data[6], 
                    hrpacientesolicitado: data[7], 
                    hrnocentro: data[8], 
                    hremcirurgia: data[9], 
                    hrsaidasl: data[10], 
                    hrsaidacc: data[11],
                    ...dadosAdicionais
            };

            carregarDadosModal(dadosCompletos);

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