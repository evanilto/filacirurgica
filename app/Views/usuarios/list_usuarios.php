<table class="table table-hover table-bordered table-smaller-font table-striped" id="table">
    <thead>
        <tr>
            <th scope="col" colspan="7" class="bg-light text-center"><h5><strong>Usuarios</strong></h5></th>
        </tr>
        <tr>
            <th scope="col" class="col-1" data-field="Id" >Id</th>
            <th scope="col" data-field="Login">Login</th>
            <th scope="col" data-field="Nome" >Nome</th>
            <th scope="col" data-field="Setor" >Setor</th>
            <th scope="col" data-field="Perfil" >Perfil</th>
            <th scope="col" data-field="Situacao" >Situação</th>
            <th scope="col" class="col-1">Ação</th>
            <!-- <th scope="col" class="col-1"></th> -->
        </tr>
    </thead>
    <tbody>
        <?php foreach($usuarios as $usuario): ?>
            <tr>
                <td><?php echo $usuario['id'] ?></td>
                <td><?php echo $usuario['login'] ?></td>
                <td><?php echo $usuario['nmUsuario'] ?></td>
                <td><?php echo $usuario['nmSetor'] ?></td>
                <td><?php echo $usuario['nmPerfil'] ?></td>
                <td><?php echo $usuario['indSituacao'] ?></td>
                <td class="text-center align-middle">
                    <?php echo anchor('usuarios/editar/'.$usuario['id'], '<i class="fas fa-pencil-alt editar-icon"></i>', array('title' => 'Editar')) ?>
                </td>
            </tr>
        <?php endforeach; ?>
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
