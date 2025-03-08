<?php
session_start();
require __DIR__ . '/../config/config.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

// Não precisamos de pesquisa no carregamento da página, apenas no AJAX
$pesquisa = trim($_GET['pesquisa'] ?? '');

// Buscar produtos com base na pesquisa (caso haja)
$sql = "SELECT id, nome, caminho_imagem FROM produtos";
if ($pesquisa) {
    $sql .= " WHERE nome LIKE :pesquisa";
}

$stmt = $pdo->prepare($sql);

if ($pesquisa) {
    $stmt->bindValue(':pesquisa', '%' . $pesquisa . '%');
}

$stmt->execute();
$produtos = $stmt->fetchAll();

// Inclui o menu apenas após garantir que não há redirecionamento
require __DIR__ . '/../includes/menu.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Principal</title>
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
    <div class="container mt-4 pt-5">
        <h2>Bem-vindo ao Sistema de Gestão 3D</h2>
        <p>Escolha uma opção no menu acima para gerenciar estúdios ou peças.</p>

        <h3 class="mt-4">Lista de Produtos</h3>

        <!-- Campo de Pesquisa -->
        <form class="mb-4" action="index.php" method="get">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Buscar produto" name="pesquisa" id="campo_pesquisa" value="<?= htmlspecialchars($pesquisa) ?>" autocomplete="off" list="sugestoes-list">
                <button class="btn btn-outline-secondary" type="submit">Buscar</button>
                <!-- Botão para limpar a busca -->
                <?php if (!empty($pesquisa)): ?>
                    <a href="index.php" class="btn btn-outline-danger">Limpar</a>
                <?php endif; ?>
            </div>
            <datalist id="sugestoes-list">
                <?php foreach ($produtos as $produto): ?>
                    <option value="<?= htmlspecialchars($produto['nome']) ?>"></option>
                <?php endforeach; ?>
            </datalist>
        </form>

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
                        <td><img src="<?= htmlspecialchars($produto['caminho_imagem']) ?>" alt="Imagem do Produto" class="img-thumbnail" width="80"></td>
                        <td><?= htmlspecialchars($produto['nome']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>