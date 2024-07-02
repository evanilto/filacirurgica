<table class="table table-hover table-bordered table-smaller-font table-striped" id="table">
    <thead>
        <tr>
            <th scope="col" colspan="6" class="bg-light text-center"><h5><strong>Prontuários no Setor</strong></h5></th>
        </tr>
        <tr>
            <th scope="col" class="col-0" data-field="prontuarioaghu" >Prontuário AGHU</th>
            <th scope="col" class="col-0" data-field="volume" >Volume</th>
            <th scope="col" class="col-0" data-field="prontuariomv" >Prontuário MV</th>
            <th scope="col" data-field="paciente" >Paciente</th>
            <th scope="col" data-field="dt_nascimento" >Data Nascimento</th>
            <th scope="col" data-field="obs" >Obs</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($prontuarios as $prontuario): ?>
            <tr>
                <td>
                    <?php $link = base_url('prontuarios/historico/'.$prontuario['prontuarioaghu'].'/'.$prontuario['volume']); ?>
                    <a href="<?php echo $link; ?>" onclick="mostrarAguarde(event, '<?php echo $link; ?>');"><?php echo $prontuario['prontuarioaghu']; ?></a>
                </td>
                <td><?php echo $prontuario['volume'] ?></td>
                <td><?php echo $prontuario['prontuariomv'] ?></td>
                <td><?php echo $prontuario['paciente'] ?></td>
                <td><?php echo date_format(date_create($prontuario['dt_nascimento']), 'd/m/Y') ?></td>
                <td><?php echo $prontuario['obs'] ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
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

