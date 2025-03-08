<?php
session_start();
require __DIR__ . '/../config/config.php';
require __DIR__ . '/../includes/menu.php';

// Adicionar nova tag
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nome'])) {
    $nome = trim($_POST['nome']);
    $stmt = $pdo->prepare("INSERT INTO tags (nome) VALUES (?)");
    $stmt->execute([$nome]);
}

// Buscar todas as tags
$stmt = $pdo->query("SELECT * FROM tags ORDER BY nome ASC");
$tags = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-5 pt-5">
    <h2>Gerenciar Tags</h2>
    <form method="post" class="mb-4">
        <div class="input-group">
            <input type="text" name="nome" class="form-control" placeholder="Nova tag" required>
            <button type="submit" class="btn btn-primary">Adicionar</button>
        </div>
    </form>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tags as $tag): ?>
            <tr>
                <td><?= htmlspecialchars($tag['nome']) ?></td>
                <td>
                    <a href="../controllers/excluir_tag.php?id=<?= $tag['id'] ?>" class="btn btn-danger btn-sm">Excluir</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>