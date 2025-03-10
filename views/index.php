<?php
session_start();
require __DIR__ . '/../config/config.php';

// Habilita a exibição de erros
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$pesquisa = trim($_GET['pesquisa'] ?? '');

// Buscar produtos com base na pesquisa (caso haja)
$sql = "
    SELECT DISTINCT p.id, p.nome, p.caminho_imagem 
    FROM produtos p
    LEFT JOIN produto_tags pt ON p.id = pt.produto_id
    LEFT JOIN tags t ON pt.tag_id = t.id
    WHERE 1=1
";

if ($pesquisa) {
    $sql .= " AND (p.nome LIKE :pesquisa1 OR t.nome LIKE :pesquisa2)";
}

$stmt = $pdo->prepare($sql);

if ($pesquisa) {
    $stmt->bindValue(':pesquisa1', '%' . $pesquisa . '%', PDO::PARAM_STR);
    $stmt->bindValue(':pesquisa2', '%' . $pesquisa . '%', PDO::PARAM_STR);
}

try {
    $stmt->execute();
    $produtos = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Erro ao executar a consulta: " . $e->getMessage());
}

// Buscar todas as tags para o datalist
$stmt_tags = $pdo->query("SELECT nome FROM tags");
$tags = $stmt_tags->fetchAll(PDO::FETCH_ASSOC);

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
                <?php if (!empty($produtos)): ?>
                    <?php foreach ($produtos as $produto): ?>
                        <option value="<?= htmlspecialchars($produto['nome']) ?>"></option>
                    <?php endforeach; ?>
                <?php endif; ?>
                <?php if (!empty($tags)): ?>
                    <?php foreach ($tags as $tag): ?>
                        <option value="<?= htmlspecialchars($tag['nome']) ?>"></option>
                    <?php endforeach; ?>
                <?php endif; ?>
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