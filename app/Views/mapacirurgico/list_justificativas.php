<?php use App\Libraries\HUAP_Functions; ?>

<script>$('#janelaAguarde').show();</script>

<div class="table-container mt-3">

<?php
    $mapJustificativas = [
        'ENV'  => 'Envio ao Mapa',
        'U'    => 'Envio com Urgência',
        'T'    => 'Troca de Paciente',
        'S'    => 'Suspensão de Cirurgia',
        'O'    => 'Origem do Paciente',
        'E'    => 'Exclusão da Fila',
        'R'    => 'Recuperação para Fila',
        'SADM' => 'Suspensão ADM'
    ];

    $codigoJustificativa = $data['tipojustificativa'] ?? null;

    $justificativaTitulo = $codigoJustificativa && isset($mapJustificativas[$codigoJustificativa])
        ? $mapJustificativas[$codigoJustificativa]
        : 'Justificativas';
?>
<table class="table">
    <thead style="border:1px solid black;">
        <tr>
        <th colspan="10" class="bg-light text-start">
        <h5><strong> Justificativas para <?= esc($justificativaTitulo) ?></strong></h5>
        </th>
        </tr>
    </thead>
</table>
<table class="table table-hover table-bordered table-smaller-font table-striped" id="table">
    <thead>
        <tr>
            <th>Dt/Hr Evento</th>
            <th>Evento/Motivo</th>
            <th>Prontuário</th>
            <th>Nome</th>
            <th>Especialidade</th>
            <th>Fila</th>
            <th>Procedimento</th>
            <th>Justificativa</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($justificativas as $justificativa):
                /* $justificativa->dthr_evento = $justificativa->dthr_evento
                    ? \DateTime::createFromFormat('Y-m-d H:i:s', $justificativa->dthr_evento)->format('d/m/Y H:i')
                    : 'N/D';  */ 
        ?>
            <tr
                data-dthrevento="<?= $justificativa->dthr_evento ?>"
                data-evento="<?= $justificativa->evento ?>"
                data-prontuario="<?= $justificativa->prontuario ?>"
                data-especialidade="<?= $justificativa->especialidade_descricao ?>"
                data-procedimento="<?= $justificativa->procedimento_descricao ?>"
                data-justificativa="<?= esc($justificativa->justificativa) ?>"
                data-fila="<?= esc($justificativa->fila) ?>"
                >

                <td><?= $justificativa->dthr_evento ?></td>
                <td class="break-line" title="<?= esc($justificativa->evento) ?>">
                    <?= esc($justificativa->evento) ?>
                </td>
                <td><?= $justificativa->prontuario ?></td>
                <td class="break-line" title="<?= esc($justificativa->nome_paciente) ?>">
                    <?= esc($justificativa->nome_paciente) ?>
                </td>
                <td class="break-line" title="<?= esc($justificativa->especialidade_descricao) ?>">
                <?= esc($justificativa->especialidade_descricao) ?>
                </td>
                <td class="break-line" title="<?= esc($justificativa->fila) ?>">
                <?= esc($justificativa->fila) ?>
                </td>
                <td class="break-line" title="<?= esc($justificativa->procedimento_descricao) ?>">
                <?= esc($justificativa->procedimento_descricao) ?>
                </td>
                <td class="break-line" title="<?= esc($justificativa->justificativa) ?>">
                <?= esc($justificativa->justificativa) ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div class="col-md-12 table-actions">
    <a class="btn btn-warning" href="<?= base_url('relatorios/justificativas') ?>"><i class="fa-solid fa-arrow-left"></i>Voltar</a>
    <button class="btn btn-primary" id="consultar" disabled>Consultar</button>
</div>

<script>
$('#table tbody').on('mouseenter','td.break-line',function(){

    var $this=$(this);

    if($this[0].scrollWidth > $this.innerWidth()){

    var tooltip=$('<div class="tooltip"></div>')
    .text($this.attr('title'))
    .appendTo('body');

    tooltip.css({
    top:$this.offset().top + $this.outerHeight() + 10,
    left:$this.offset().left
    }).fadeIn('slow');

    $this.data('tooltip',tooltip);

    }else{
    $(this).data('tooltip',null);
    }

    }).on('mouseleave','td.break-line',function(){

    var tooltip=$(this).data('tooltip');

    if(tooltip){
    tooltip.remove();
    }

    }).on('mousemove','td.break-line',function(e){

    var tooltip=$(this).data('tooltip');

    if(tooltip){
    tooltip.css({
    top:e.pageY + 10,
    left:e.pageX + 10
    });
    }

});

document.addEventListener("DOMContentLoaded",function(){

const table=document.getElementById("table");
const consultar=document.getElementById("consultar");

let selectedRow=null;

table.querySelectorAll("tbody tr").forEach(row=>{

row.addEventListener("click",function(){

if(selectedRow) selectedRow.classList.remove("lineselected");

selectedRow=this;
selectedRow.classList.add("lineselected");

<?php if(HUAP_Functions::tem_permissao('listaespera-consultar')) { ?>
consultar.disabled=false;
<?php } ?>

});

});

consultar.addEventListener("click",function(){

if(selectedRow){
    carregarDadosModal(selectedRow);
}

});

});

function carregarDadosModal(element) {

    let tituloJustificativa = <?= json_encode($justificativaTitulo) ?>;

    let dthrevento = element.getAttribute('data-dthrevento');
    let evento = element.getAttribute('data-evento');
    let prontuario = element.getAttribute('data-prontuario');
    let especialidade = element.getAttribute('data-especialidade');
    let procedimento = element.getAttribute('data-procedimento');
    let justificativa = element.getAttribute('data-justificativa');
    let fila = element.getAttribute('data-fila');

    $.ajax({
        url: '/listaespera/carregadadosmodal',
        type: 'GET',
        data: { prontuario: prontuario },
        dataType: 'json',

        success: function(paciente) {

            function verificarValor(valor){
                return (valor === null || valor === '') ? 'N/D' : valor;
            }

            function verificarOutroValor(valor){
                return (valor === null || valor === '') ? '' : ', ' + valor;
            }

            let telefonesHtml = '';

            if (paciente.contatos && paciente.contatos.length > 0) {

                paciente.contatos.forEach((contato, index) => {

                    const ddd = contato.ddd ? `(${verificarValor(contato.ddd)})` : '';
                    const fone = verificarValor(contato.nro_fone).replace(/(\d{5})(\d+)/,'$1-$2');
                    const obs = contato.observacao ? `(${verificarValor(contato.observacao)})` : '';

                    if (paciente.contatos.length > 1) {
                        telefonesHtml += `<strong>Tel ${index+1}:</strong> ${ddd} ${fone} ${obs}<br>`;
                    } else {
                        telefonesHtml += `<strong>Tel:</strong> ${ddd} ${fone} ${obs}<br>`;
                    }

                });

            } else {

                telefonesHtml = '<strong>Tel:</strong> N/D<br>';

            }

            /* COLUNA ESQUERDA */

            $('#colunaEsquerda1').html(`
                <strong>Prontuário:</strong> ${verificarValor(paciente.prontuario)}<br>
                <strong>Nome:</strong> ${verificarValor(paciente.nome)}<br>
                <strong>Nome da Mãe:</strong> ${verificarValor(paciente.nm_mae)}<br>
                <strong>Sexo:</strong> ${verificarValor(paciente.sexo)}<br>
                <strong>Data Nascimento:</strong> ${verificarValor(paciente.dt_nascimento)}<br>
                <strong>Idade:</strong> ${verificarValor(paciente.idade)}<br>
                <strong>CPF:</strong> ${verificarValor(paciente.cpf)}<br>
                <strong>CNS:</strong> ${verificarValor(paciente.cns)}<br>
            `);

            /* COLUNA DIREITA */

            $('#colunaDireita1').html(`
                <strong>Endereço:</strong> ${verificarValor(paciente.logradouro)}, ${verificarValor(paciente.num_logr)}${verificarOutroValor(paciente.compl_logr)}<br>
                <strong>Cidade:</strong> ${verificarValor(paciente.cidade)}<br>
                <strong>Bairro:</strong> ${verificarValor(paciente.bairro)}<br>
                <strong>CEP:</strong> ${verificarValor(paciente.cep)}<br>
                <strong>Email:</strong> ${verificarValor(paciente.email)}<br>
                ${telefonesHtml}
            `);

            /* DADOS DA FILA */

            $('#colunaEsquerda2').html(`
                <strong>Dt/Hr Evento:</strong> ${dthrevento}<br>
                <strong>Motivo:</strong> ${verificarValor(evento)}<br>
                <strong>Especialidade:</strong> ${verificarValor(especialidade)}<br>
                <strong>Fila:</strong> ${verificarValor(fila)}<br>
                <strong>Procedimento:</strong> ${verificarValor(procedimento)}<br>
                <strong>Justificativa para ${tituloJustificativa}:</strong> ${verificarValor(justificativa)}<br>
            `);

            $('#colunaDireita2').html(`
            `);

            $('#modalDetalhes').modal('show');

        },

        error:function(xhr,status,error){

            console.error('Erro ao carregar dados do paciente:',error);

        }

    });

}

$(document).ready(function(){

    $('#janelaAguarde').show();

    let justificativaTitulo = <?= json_encode($justificativaTitulo) ?>;

    $('#table').DataTable({
        order:[[0,'asc']],
        language:{
            url:"<?= base_url('assets/DataTables/i18n/pt-BR.json') ?>"
        },
        paging:false,
        ordering:true,
        autoWidth:false,

        columns:[
            { width:"120px" },
            { width:"180px" },
            { width:"90px" },
            { width:"200px" },
            { width:"170px" },
            { width:"240px" },
            { width:"260px" },
            { width:"290px" }
        ],

        columnDefs:[
        {
            targets:0,
            render:function(data,type,row){

                if(!data){
                    return type === 'display' ? 'N/D' : '';
                }

                const evento = row[1]; // coluna Evento/Motivo
                const dataStr = data.substring(0,10); // YYYY-MM-DD
                const limite = '2024-12-07';

                if(evento === 'ENVIO PARA O MAPA' && dataStr < limite){
                    return type === 'display' ? 'N/D' : '';
                }

                if(type === 'display' || type === 'filter'){

                    const d = dataStr.substring(8,10);
                    const m = dataStr.substring(5,7);
                    const y = dataStr.substring(0,4);
                    const hora = data.substring(11,16);

                    return `${d}/${m}/${y} ${hora}`;
                }

                return data;
            }
        }
        ],

        scrollY:'525px',
        scrollCollapse:true,
        stateSave:true,

        layout:{
            topStart:{
                buttons:[
                    {
                        extend:'colvis',
                        text:'Colunas'
                    },
                    {
                        extend:'copy',
                        title: justificativaTitulo
                    },
                    {
                        extend:'csv',
                        title: justificativaTitulo
                    },
                    {
                        extend:'excel',
                        title: justificativaTitulo
                    },
                    /* {
                    extend:'pdf',
                    title: justificativaTitulo
                    }, */
                    {
                        extend:'print',
                        title: justificativaTitulo
                    }
                ]
            }
        },

        processing:true,
        deferRender:true,

        initComplete:function(){
            $('#janelaAguarde').hide();
            $('#table tbody tr td').addClass('break-line');
        }
    });

    var table = $('#table').DataTable();

    $('#table tbody').on('dblclick', 'tr', function (event) {
        event.preventDefault();

        var row = table.row(this).node();

        carregarDadosModal(row);
    });

});

</script>