<?php
session_start();
require __DIR__ . '/../config/config.php';
require __DIR__ . '/../includes/menu.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../views/login.php");
    exit;
}

$stmt = $pdo->query("SELECT ca.*, c.nome AS categoria_nome FROM categoria_atributos ca JOIN categorias c ON ca.categoria_id = c.id ORDER BY ca.categoria_id ASC, ca.nome_atributo ASC");
$atributos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-4 pt-5">
    <h2>Lista de Atributos</h2>
    <a href="../controllers/adicionar_atributo.php" class="btn btn-success mb-3">Adicionar Atributo</a>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Categoria</th>
                <th>Nome do Atributo</th>
                <th>Tipo</th>
                <th>Opções</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($atributos as $atributo): ?>
                <tr>
                    <td><?= $atributo['id'] ?></td>
                    <td><?= htmlspecialchars($atributo['categoria_nome']) ?></td>
                    <td><?= htmlspecialchars($atributo['nome_atributo']) ?></td>
                    <td><?= htmlspecialchars($atributo['tipo_atributo']) ?></td>
                    <td><?= htmlspecialchars($atributo['opcoes']) ?></td>
                    <td>
                        <a href="../controllers/editar_atributo.php?id=<?= $atributo['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                        <a href="../controllers/excluir_atributo.php?id=<?= $atributo['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>