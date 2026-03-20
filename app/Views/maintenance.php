<!-- app/Views/maintenance.php -->
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Sistema em Manutenção</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        .box {
            background: #fff;
            padding: 40px;
            text-align: center;
            border-radius: 8px;
            max-width: 500px;
        }
    </style>
</head>
<body>
    <div class="box">
        <h1>🚧 Manutenção Emergencial</h1>
        <p>O sistema FilaWeb está temporariamente indisponível</p>
        <!-- <p>Estamos trabalhando para normalizar o serviço o mais breve possível.</p> -->
        <p>Previsão de retorno em 30 minutos</p>
        <small><?= date('d/m/Y H:i') ?></small>
    </div>
</body>
</html>
