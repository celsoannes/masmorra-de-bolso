<?php
session_start();
require __DIR__ . '/../config/config.php';
require __DIR__ . '/../includes/menu.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../views/login.php");
    exit;
}

$stmt = $pdo->query("SELECT * FROM categorias ORDER BY nome ASC");
$categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-4 pt-5">
    <h2>Lista de Categorias</h2>
    <a href="../controllers/adicionar_categoria.php" class="btn btn-success mb-3">Adicionar Categoria</a>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categorias as $categoria): ?>
                <tr>
                    <td><?= $categoria['id'] ?></td>
                    <td><?= htmlspecialchars($categoria['nome']) ?></td>
                    <td>
                        <a href="../controllers/editar_categoria.php?id=<?= $categoria['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                        <a href="../controllers/excluir_categoria.php?id=<?= $categoria['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>