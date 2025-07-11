<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema em Manutenção</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            color: #333;
        }
        .container {
            max-width: 600px;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
        }
        h1 {
            margin-top: 0;
            color: #d9534f;
        }
        p {
            font-size: 18px;
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="<?= base_url('assets/img/maintenance-256.png') ?>" alt="Sistema em Manutenção">
        <h1>Sistema em Manutenção</h1>
        <p>Nosso sistema está passando por uma manutenção programada. Voltaremos em breve!</p>
    </div>
</body>
</html>
