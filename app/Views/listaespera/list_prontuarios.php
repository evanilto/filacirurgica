<div class="table-container">

        <table class="table table-hover table-bordered table-smaller-font table-striped" id="table"
        data-toggle="table"
        data-locale="pt-BR"
        data-id-field="Id"
        data-sortable="true"
        data-search="true"
        data-show-fullscreen="false"
        data-search-highlight="true"
        data-show-pagination-switch="false"
        data-pagination="true"
        data-page-size="5"
        data-page-list="[5, 10, all]"
        >
        <thead>
            <tr>
                <th scope="col" colspan="15" class="bg-light text-center" style="height: 40px;"><h6><strong>Prontuários</strong></h6></th>
            </tr>
            <tr>
                <th scope="col" class="col-1" data-field="Id" data-sortable="true">No. AGHU</th>
                <th scope="col" data-field="numvolume" data-sortable="true">Vol.</th>
                <th scope="col" data-field="prontuariomv" data-sortable="true">No. MV</th>
                <th scope="col" data-field="nmpaciente" data-sortable="true">Paciente</th>
                <th scope="col" data-field="dtnascimento" data-sortable="true">Dt Nasc.</th>
                <th scope="col" data-field="nmmae" data-sortable="true">Mãe</th>
                <th scope="col" data-field="numsala" data-sortable="true">Sala</th>
                <th scope="col" data-field="numarmario" data-sortable="true">Armário</th>
                <th scope="col" data-field="obs" data-sortable="true">Linha</th>
                <th scope="col" data-field="numcoluna" data-sortable="true">Coluna</th>
                <th scope="col" data-field="txtobs" data-sortable="true">Obs.</th>   
                <th scope="col" data-field="setoratual" data-sortable="true">Setor de Localização</th>
                <th scope="col" data-field="acao2" colspan="3" style="text-align: center;">Ação</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($prontuarios as $prontuario):
            
                if (empty($prontuario->dtNascimento)) {
                $dtnascimento = '';
                } else {
                $dtnascimento = date_format(date_create($prontuario->dtNascimento), 'd/m/Y');
                };
            ?>
            <tr>
            <td><?php echo anchor(base_url('prontuarios/historico/'.$prontuario['numProntuarioAGHU'].'/'.$prontuario['numVolume']), $prontuario['numProntuarioAGHU']); ?></td>
            <td><?php echo $prontuario['numVolume'] ?></td>
            <td><?php echo $prontuario['numProntuarioMV'] ?></td>
            <td class="camelCaseText"><?php echo $prontuario['nmPaciente'] ?></td>
            <td class="upperCaseText"><?php echo date_format(date_create($prontuario['dtNascimento']), 'd/m/Y'); ?></td>
            <td class="camelCaseText"><?php echo $prontuario['nmMae'] ?></td>
            <td><?php echo $prontuario['numSala'] ?></td>
            <td><?php echo $prontuario['numArmario'] ?></td>
            <td><?php echo $prontuario['numLinha'] ?></td>
            <td><?php echo $prontuario['numColuna'] ?></td>
            <td><?php echo $prontuario['txtObs'] ?></td>
            <td class="upperCaseText"><?php echo $prontuario['nmSetorAtual'] ?></td>
            <td style="text-align: center; vertical-align: middle;">
                <?php echo anchor('prontuarios/editar/'.$prontuario['id'], '<i class="fas fa-pencil-alt"></i>', array('title' => 'Editar')) ?>
            </td>
            <td style="text-align: center; vertical-align: middle;">
                <?php echo $prontuario['ultimoVolume'] ? anchor('prontuarios/criarvolume/'.$prontuario['id'], '<i class="fas fa-plus"></i>', array('title' => 'Criar Volume', 'onclick' => 'return confirma_criar()')) : ''?>
            </td>
            <td style="text-align: center; vertical-align: middle;">
                <?php echo ($prontuario['ultimoVolume'] && (int)$prontuario['numVolume'] > 2) ? anchor('prontuarios/excluirvolume/'.$prontuario['id'], '<i class="fas fa-trash-alt"></i>', array('title' => 'Excluir Volume', 'onclick' => 'return confirma_excluir()')) : '<span>&nbsp;&nbsp;</span>' ?>
            </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="card col-md-12">
        <div class="card-body text-center">
            <div class="row">
                <div class="col-md-12 d-flex justify-content-center">
                    <a class="btn btn-warning m-2" href="<?= base_url('prontuarios/consultar')?>" style="height: 40px; width: 100px; text-align: center; margin-right: 10px;">
                        <i class="fa-solid fa-arrow-left"></i> Voltar
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>
<script>
    function confirma_criar ()
    {
        if (!confirm('Confirma a criação do Volume?')) {
            return false;
        };
        
        return true;
    }
    function confirma_excluir ()
    {
        if (!confirm('Confirma a exclusão do Volume?')) {
            return false;
        };
        
        return true;
    }
</script>