<?php
require __DIR__ . '/../config/config.php';
require __DIR__ . '/../includes/menu.php';

$stmt = $pdo->query("SELECT * FROM produtos");
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-5">
    <h2>Lista de Produtos</h2>
    <a href="../controllers/adicionar_produto.php" class="btn btn-success mb-3">Adicionar Produto</a>
    <table class="table">
        <tr>
            <th>Nome</th>
            <th>Imagem</th>
            <th>Ações</th>
        </tr>
        <?php foreach ($produtos as $produto): ?>
        <tr>
            <td><?= htmlspecialchars($produto['nome']) ?></td>
            <td><img src="<?= htmlspecialchars($produto['caminho_imagem']) ?>" width="50"></td>
            <td>
                <a href="../controllers/editar_produto.php?id=<?= $produto['id'] ?>" class="btn btn-primary">Editar</a>
                <a href="../controllers/excluir_produto.php?id=<?= $produto['id'] ?>" class="btn btn-danger">Excluir</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>