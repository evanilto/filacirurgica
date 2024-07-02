<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="<?= base_url() ?>/css/custom.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>    
    <title>Usuários</title>
</head>
<script>
    function confirma ()
    {
        if (!confirm('Deseja excluir o registro?')) {
            return false;
        };
        
        return true;
    }
</script>
<body>
    <div class="container mt-5">
        <table class="table">
            <tr>
                <th>Id</th>
                <th>Login</th>
                <th>Nome</th>
                <th>IdSetor</th>
            </tr>
            <?php foreach($usuarios as $user): ?>
                <tr>
                    <td><?php echo $user['id'] ?></td>
                    <td><?php echo $user['login'] ?></td>
                    <td><?php echo $user['nmUsuario'] ?></td>
                    <td><?php echo $user['idSetor'] ?></td>
                    <td><?php echo anchor('usuarios/edit/'.$user['id'], 'Editar') ?></td>
                    -
                    <td><?php echo anchor('usuarios/delete/'.$user['id'], 'Excluir', ['onclick' => 'return confirma()']) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <!--?php echo $pager->links() ?-->
        <?= $pager_links ?>
        <div class="pagination">
            <span class="label-pagination">Showing 1 to10 of 1147 entries    </span>
            <span class="pagination-btns">
            <b>1</b>
            <a href="javascript:void(0);" onclick="getContactSearchData(1)">2</a>
            <a href="javascript:void(0);" onclick="getContactSearchData(2)">3</a>
            <a href="javascript:void(0);" onclick="getContactSearchData(4)">›</a>
            <a href="javascript:void(0);" onclick="getContactSearchData(4)">»</a>
            </span>
        </div>
    </div>
</body>
</html>