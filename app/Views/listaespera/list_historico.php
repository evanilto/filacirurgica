<div class="table-container-top">
        
    <?= $this->include('prontuarios/exibe_prontuario');?>

    <table class="table table-hover table-bordered table-smaller-font table-striped" id="table">
        <thead>
            <tr>
                <th scope="col" colspan="12" class="bg-light text-center"><h6><strong>Histórico de Movimentações</strong></h5></th>
            </tr>
            <tr>
                <th scope="col" class="col-1" data-field="Chave">Chave</th>
                <th scope="col" class="col-1" data-field="origem" >Setor Origem</th>
                <th scope="col" data-field="resgatador" >Resgatado Por</th>
                <th scope="col" data-field="portadorOrigem" >Enviado Por</th>
                <th scope="col" data-field="saida" >Dt/Hr Envio</th>
                <th scope="col" data-field="dtretorno" >Dt Retorno</th>
                <th scope="col" data-field="destino" >Setor Destino</th>
                <th scope="col" data-field="profissional" >Profissional</th>
                <th scope="col" data-field="recebedor" >Recebido Por</th>
                <th scope="col" data-field="dtRecebimento" >Dt/Hr Recebido</th>
                <th scope="col" data-field="obs" >Observação</th>
                <th scope="col" data-field="mov_origem" >Origem Mov.</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($historico as $hist):
                if (empty($hist['saida'])) {
                $saida = '';
                $saida_sort = date('Y/m/d H:i:s');
                } else {
                $saida = date_format(date_create($hist['saida']), 'd/m/Y H:i');
                $saida_sort = date_format(date_create($hist['saida']), 'Y/m/d H:i:s');
                }
                if (empty($hist['dtRecebimento'])) {
                $recebimento = '';
                } else {
                $recebimento = date_format(date_create($hist['dtRecebimento']), 'd/m/Y H:i');
                }

            ?>
                <tr>
                    <td><?php echo $saida_sort ?></td>
                    <td class="upperCaseText"><?php echo $hist['origem'] ?></td>
                    <td class="camelCaseText"><?php echo $hist['resgatador'] ?></td>
                    <td class="camelCaseText"><?php echo $hist['portadorOrigem'] ?></td>
                    <td><?php echo $saida ?></td>
                    <td><?php echo !empty($hist['prevretorno']) ? date_format(date_create($hist['prevretorno']), 'd/m/Y') : null; ?></td>
                    <td class="upperCaseText"><?php echo $hist['destino'] ?></td>
                    <td class="upperCaseText"><?php echo $hist['profissional'] ?></td>
                    <td class="camelCaseText"><?php echo $hist['recebedor'] ?></td>
                    <td><?php echo $recebimento ?></td>
                    <td><?php echo $hist['obs'] ?></td>
                    <td class="upperCaseText"><?php echo $hist['mov_origem'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>

    </table>

    <div class="button-container text-center">  <!-- Um único container para todos os botões -->
        <div class="card">
            <div class="card-body text-center">
                <div class="row">
                    <?php if ($permiteEnviar): ?>
                        <div class="col-md-2 d-flex justify-content-center offset-md-4">
                            <a class="btn btn-info m-2" id="btntramitar" name="btntramitar" href="<?= base_url('prontuarios/tramitar')."/$paciente->prontuario"."/$paciente->volume" ?>" style="height: 40px; width: 113px; text-align: center; margin-right: 10px;">
                                <i class="fa fa-send-o"></i> Tramitar
                            </a>
                        </div>
                    <?php endif; ?>
                    <?php if ($permiteReceber): ?>
                        <div class="col-md-2 d-flex justify-content-center offset-md-4">
                            <a class="btn btn-info m-2" id="btnreceber" name="btnreceber" href="<?= base_url('prontuarios/receber')."/$paciente->prontuario"."/$paciente->volume" ?>" style="height: 40px; width: 113px; text-align: center; margin-right: 10px;">
                                <i class="fas fa-arrow-down"></i> Receber
                            </a>
                        </div>
                    <?php endif; ?>
                    <div class="col-md-2 d-flex justify-content-center">
                        <a class="btn btn-warning m-2" href="javascript:history.go(-2)" style="height: 40px; width: 113px; text-align: center; margin-right: 10px;">
                            <i class="fa-solid fa-arrow-left"></i> Voltar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<script>
   $(document).ready(function() {
        $('#table').DataTable({
            "order": [[0, 'desc']],
            "lengthChange": true,
            "pageLength": 10,
            "lengthMenu": [[10, 20, 50, 75, -1], [10, 20, 50, 75, "Tudo"]],
            "language": {
                "url": "<?= base_url('assets/DataTables/i18n/pt-BR.json') ?>"
            },
            "columnDefs": [
            { "orderable": false, "targets": [1] },
            { "visible": false, "targets": [0] } 
            ],
        });
    });
</script>

