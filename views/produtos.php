<?php
session_start();
require __DIR__ . '/../config/config.php';
require __DIR__ . '/../includes/menu.php';

$stmt = $pdo->query("SELECT * FROM produtos");
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-4 pt-5">
    <h2>Lista de Produtos</h2>
    <a href="../controllers/adicionar_produto.php" class="btn btn-success mb-3">Adicionar Produto</a>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Imagem</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($produtos as $produto): ?>
            <tr>
                <td><img src="<?= htmlspecialchars($produto['caminho_imagem']) ?>" class="img-thumbnail" width="80"></td>
                <td><?= htmlspecialchars($produto['nome']) ?></td>
                <td>
                    <a href="../controllers/editar_produto.php?id=<?= $produto['id'] ?>" class="btn btn-primary">Editar</a>
                    <a href="../controllers/excluir_produto.php?id=<?= $produto['id'] ?>" class="btn btn-danger">Excluir</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>