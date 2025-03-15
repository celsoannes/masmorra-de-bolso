<?php
$title = "Bem-vindo ao RPGzinho!";
$image = "imagens/rpg_adventure.jpg"; // Substitua pelo caminho da sua imagem
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(45deg, #1e1e2e, #3a2a5e);
            color: #fff;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }
        h1 {
            font-size: 2.5em;
            text-shadow: 2px 2px 10px rgba(0,0,0,0.5);
        }
        .container {
            background: rgba(0, 0, 0, 0.7);
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(255, 255, 255, 0.2);
        }
        img {
            width: 80%;
            max-width: 500px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.3);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1><?php echo $title; ?></h1>
        <img src="<?php echo $image; ?>" alt="Aventura RPG">
        <p>Prepare-se para explorar mundos mágicos e enfrentar desafios épicos!</p>
    </div>
</body>
</html>
