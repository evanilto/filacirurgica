<table class="table table-hover table-bordered table-smaller-font table-striped" id="table">
    <thead>
        <tr>
            <th scope="col" colspan="9" class="bg-light text-center"><h5><strong>Solicitações Externas</strong></h5></th>
        </tr>
        <tr>
            <th scope="col" class="col-1" data-field="Id" >Prontuário</th>
            <th scope="col" data-field="numvolume" >Vol.</th>
            <th scope="col" data-field="paciente" >Paciente</th>
            <th scope="col" data-field="setoratual" >Setor Solicitante</th>
            <th scope="col" data-field="dtsolicitacao" >Dt/Hr Solicitação</th>
            <th scope="col" data-field="solicitante" >Solicitante</th>
            <th scope="col" data-field="receptor" >Receptor</th>
            <th scope="col" data-field="justificativa" >Justificativa</th>
            <th scope="col" data-field="situacao" >Situação</th>
            <!-- <th scope="col" class="col-1">Ação</th> -->
        </tr>
    </thead>
    <tbody>
        <?php if(isset($solicitacoes)) { ?>
        <?php foreach($solicitacoes as $solicitacao): ?>
            <tr>
                <td><?php echo anchor(base_url('prontuarios/historico/'.$solicitacao['numprontuario'].'/'.$solicitacao['numvolume']), $solicitacao['numprontuario']); ?></td>
                <td><?php echo $solicitacao['numvolume'] ?></td>
                <td><?php echo $solicitacao['paciente'] ?></td>
                <td><?php echo $solicitacao['setorsolicitante'] ?></td>
                <td><?php echo $solicitacao['dtsolicitacao'] ?></td>
                <td><?php echo $solicitacao['solicitante'] ?></td>
                <td><?php echo $solicitacao['receptor'] ?></td>
                <td><?php echo $solicitacao['justificativa'] ?></td>
                <td><?php echo $solicitacao['situacao'] ?></td>
                <!-- <td><?php echo anchor('prontuarios/solicitacoes/excluir/'.$solicitacao['id'], 'Excluir', ['onclick' => 'return confirma()']) ?></td> -->
            </tr>
        <?php endforeach; ?>
        <?php } ?>
    </tbody>
</table>
<script>
    $(document).ready(function() {
        $('#table').DataTable({
            "order": [[0, 'asc']],
            "lengthChange": true,
            "pageLength": 10,
            "lengthMenu": [[10, 20, 50, 75, -1], [10, 20, 50, 75, "Tudo"]],
            "language": {
                "url": "<?= base_url('assets/DataTables/i18n/pt-BR.json') ?>"
            },
            "columnDefs": [
            /* { "orderable": false, "targets": [1] }, */
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
