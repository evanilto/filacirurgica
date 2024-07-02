<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js">
    <title>Mensagens</title>
</head>
<body>
    <div class="container">
        <div class="alert alert-info">
            <?php echo $msg; ?>
            <p><?php echo anchor(base_url(), 'Página Inicial')?>
        </div>
    </div>
</body>
</html>