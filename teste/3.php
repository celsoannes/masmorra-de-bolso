<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RPGzinho - Aventura Fantástica</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background-image: url('fundo-rpg.jpg'); /* Substitua pelo caminho da sua imagem de fundo */
            background-size: cover;
            background-position: center;
            color: #333;
        }

        .container {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
            padding: 40px;
            text-align: center;
            max-width: 800px;
        }

        h1 {
            color: #007bff;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        p {
            font-size: 1.1em;
            line-height: 1.6;
            margin-bottom: 30px;
        }

        .imagem-destaque {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .btn {
            display: inline-block;
            padding: 12px 30px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Bem-vindo ao RPGzinho!</h1>
        <img src="imagem-rpg.jpg" alt="Imagem divertida de RPG" class="imagem-destaque">
        <p>Prepare-se para embarcar em uma jornada épica cheia de aventuras, mistérios e desafios. Crie seu personagem, explore mundos fantásticos e lute contra criaturas incríveis.</p>
        <a href="#" class="btn">Começar a Aventura</a>
    </div>
</body>
</html>