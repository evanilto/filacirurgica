<?php use App\Libraries\HUAP_Functions; ?>

<div class="table-container tabela-60 mt-5 mb-5">
    <table class="table table-hover table-bordered table-smaller-font table-striped" id="table">
        <caption class="text-start"><h5><strong>Filas Cirúrgicas</strong></h5></caption>
        <thead>
            <tr>
                <th scope="col" data-field="Especialidade">Especialidade</th>
                <th scope="col" data-field="Nome">Nome</th>
                <th scope="col" data-field="Tipo">Tipo</th>
                <th scope="col" data-field="Situacao">Situação</th>
                <th scope="col">Ação</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($filas as $fila): ?>
                <tr>
                    <td><?php echo $fila->nome_especialidade ?></td>
                    <td><?php echo $fila->nome ?></td>
                    <td>
                        <?php
                            switch ($fila->tipo) {
                                case 'C':
                                    echo "Cirurgia";
                                    break;
                                case 'E':
                                    echo "PDT"; //Exame
                                    break;
                                default:
                                    echo "N/D";
                                    break;
                            }
                        ?>
                    </td>
                    <td><?php echo $fila->indsituacao ?></td>
                    <td class="text-center align-middle">
                        <?php
                            if (HUAP_Functions::tem_permissao('cadastros-incluir')) {
                                echo anchor('filas/editar/' . $fila->id, '<i class="fas fa-pencil-alt editar-icon"></i>', ['title' => 'Editar']);
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
                { "width": "300px" }, // Especialidade
                { "width": "300px" }, // Nome
                { "width": "70px" },  // Tipo
                { "width": "70px" },  // Situação
                { "width": "40px" }   // Ação
            ]
        });
    });
</script>