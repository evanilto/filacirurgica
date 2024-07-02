<table class="table table-hover table-bordered table-smaller-font table-striped" id="table">
    <thead>
        <tr>
            <th scope="col" colspan="4" class="bg-light text-center"><h5><strong>Lista de Espera</strong></h5></th>
        </tr>
        <tr>
            <th scope="col" class="col-0" data-field="id" >Id</th>
            <th scope="col" data-field="prontuarioaghu" >Prontuário</th>
            <th scope="col" data-field="acao" colspan="2" style="text-align: center;">Ação</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($listaespera as $itemlista): ?>
            <tr>
                <td><?php echo $itemlista['id'] ?></td>
                <td><?php echo $itemlista['numProntuario'] ?></td>
                <td style="text-align: center; vertical-align: middle;">
                    <?php echo anchor('prontuarios/editar/'.$itemlista['id'], '<i class="fas fa-pencil-alt"></i>', array('title' => 'Editar')) ?>
                </td>
                <td style="text-align: center; vertical-align: middle;">
                    <?php echo anchor('prontuarios/excluirvolume/'.$itemlista['id'], '<i class="fas fa-trash-alt"></i>', array('title' => 'Excluir Volume', 'onclick' => 'return confirma_excluir()')) ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<div class="col-md-12">
    <a class="btn btn-warning mt-3" href="javascript:history.go(-1)">
        <i class="fa-solid fa-arrow-left"></i> Voltar
    </a>
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
            "pageLength": 10,
            "lengthMenu": [[10, 20, 50, 75, -1], [10, 20, 50, 75, "Tudo"]],
            "language": {
                "url": "<?= base_url('assets/DataTables/i18n/pt-BR.json') ?>"
            },
           /*  "columnDefs": [
            { "orderable": false, "targets": [1] },
            { "visible": false, "targets": [0] } 
            ], */
            layout: { topStart: { buttons: [
                'copy',
                'csv',
                'excel',
                'pdf',
                'print' 
            ] } }
        });
    });
</script>

