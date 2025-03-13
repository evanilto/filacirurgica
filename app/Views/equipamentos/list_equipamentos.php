<?php use App\Libraries\HUAP_Functions; ?>

<div class="table-container tabela-60 mt-5 mb-5">
    <table class="table table-hover table-bordered table-smaller-font table-striped" id="table">
        <thead>
            <tr>
                <th scope="col" colspan="4" class="bg-light text-start"><h5><strong>Equipamentos Cirúrgicos</strong></h5></th>
            </tr>
            <tr>
                <th scope="col" class="col-1" data-field="Descricao" >Descrição do Equipamento</th>
                <th scope="col" class="col-1" data-field="Qtd" >Qtd. Disponível</th>
                <th scope="col" data-field="Situacao" >Situação</th>
                <th scope="col" class="col-1">Ação</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($equipamentos as $eqpto): ?>
                <tr>
                    <td><?php echo $eqpto->descricao ?></td>
                    <td><?php echo $eqpto->qtd ?></td>
                    <td><?php echo $eqpto->indsituacao ?></td>
                    <td class="text-center align-middle">
                        <?php
                            if(HUAP_Functions::tem_permissao('cadastros-incluir')) {
                                echo anchor('equipamentos/editar/'.$eqpto->id, '<i class="fas fa-pencil-alt editar-icon"></i>', array('title' => 'Editar'));
                            } else {
                                echo '<span style="color: gray; cursor: not-allowed;" title="Você não tem permissão para editar."><i class="fas fa-pencil-alt"></i></span>';
                            } 
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="col-md-8">
        <a class="btn btn-warning mt-3" href="<?= base_url('home_index') ?>">
            <i class="fa-solid fa-arrow-left"></i> Voltar
        </a>
    </div>
</div>
<script>
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
            "columns": [
                { "width": "200px" },  // Primeira coluna
                { "width": "70px" }, 
                { "width": "40px" }, 
                { "width": "20px" }, 
            ],
            "columnDefs": [
             { "orderable": false, "targets": [2] }, 
           /*  { "visible": false, "targets": [0] }  */
            ],
           /*  layout: { topStart: { buttons: [
                'copy',
                'csv',
                'excel',
                'pdf',
                'print' 
            ] } } */
        });
    });
</script>
