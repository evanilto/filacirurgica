<table class="table table-hover table-bordered table-smaller-font table-striped" id="table">
    <thead>
        <tr>
            <th scope="col" colspan="6" class="bg-light text-center"><h5><strong>Prontuários A Recuperar</strong></h5></th>
        </tr>
        <tr>
            <th scope="col" class="col-2" data-field="Id" >No. Prontuário</th>
            <th scope="col" data-field="numvolume" >Vol.</th>
            <th scope="col" data-field="Login" >Setor Origem</th>
            <th scope="col" data-field="Nome" >Setor Destino</th>
            <th scope="col" data-field="Situacao" >Paciente</th>
            <th scope="col" class="col">Ação</th>
        </tr>
    </thead>
    <tbody>
        <?php if(isset($prontuarios)) { ?>
        <?php foreach($prontuarios as $prontuario): ?>
            <tr>
                <td><?php echo anchor(base_url('prontuarios/historico/'.$prontuario['numprontuario'].'/'.$prontuario['numvolume']), $prontuario['numprontuario']); ?></td>
                <td><?php echo $prontuario['numvolume'] ?></td>
                <td><?php echo $prontuario['setororigem'] ?></td>
                <td><?php echo $prontuario['setordestino'] ?></td>
                <td><?php echo $prontuario['paciente'] ?></td>
                <td style="text-align: center; vertical-align: middle;">
                    <?php echo anchor(
                        'prontuarios/recuperar/' . $prontuario['id_mov'] . '/' . $prontuario['numprontuario']. '/' . $prontuario['numvolume'],
                        '<i class="fas fa-undo-alt"></i>',
                        array('title' => 'Recuperar', 'onclick' => 'return confirma()')
                    ) ?>
                </td>


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
