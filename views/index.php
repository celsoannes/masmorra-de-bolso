<?php
session_start();
require __DIR__ . '/../config/config.php';
require __DIR__ . '/../includes/menu.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

// Buscar produtos
$stmt = $pdo->query("SELECT id, nome, caminho_imagem FROM produtos");
$produtos = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Principal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .produto-lista {
            cursor: pointer;
            transition: background 0.3s;
        }
        .produto-lista:hover {
            background: #f8f9fa;
        }
        .produto-img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2>Bem-vindo ao Sistema de Gestão 3D</h2>
        <p>Escolha uma opção no menu acima para gerenciar estúdios ou peças.</p>

        <h3 class="mt-4">Lista de Produtos</h3>
        <table class="table table-hover mt-3">
            <thead class="table-dark">
                <tr>
                    <th>Imagem</th>
                    <th>Nome do Produto</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($produtos as $produto): ?>
                    <tr class="produto-lista" onclick="window.location.href='detalhes_produto.php?id=<?= $produto['id'] ?>'">
                        <td><img src="<?= htmlspecialchars($produto['caminho_imagem']) ?>" alt="Imagem do Produto" class="produto-img"></td>
                        <td><?= htmlspecialchars($produto['nome']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>