<?php
session_start();
require __DIR__ . '/../config/config.php';
require __DIR__ . '/../includes/menu.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../views/login.php");
    exit;
}

$stmt = $pdo->query("SELECT * FROM estudios ORDER BY nome");
$estudios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-4 pt-5">
    <h2>Lista de Estúdios</h2>
    <a href="../controllers/adicionar_estudio.php" class="btn btn-success mb-3">Adicionar Estúdio</a>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Site</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($estudios as $estudio): ?>
                <tr>
                    <td><?= htmlspecialchars($estudio['nome']) ?></td>
                    <td>
                        <?php if (!empty($estudio['site'])): ?>
                            <a href="<?= htmlspecialchars($estudio['site']) ?>" target="_blank"><?= htmlspecialchars($estudio['site']) ?></a>
                        <?php else: ?>
                            N/A
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="../controllers/editar_estudio.php?id=<?= $estudio['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                        <a href="../controllers/excluir_estudio.php?id=<?= $estudio['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir este estúdio?');">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="index.php" class="btn btn-secondary">Voltar ao Menu</a>
</div>