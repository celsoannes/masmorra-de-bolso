<?php
session_start();
require __DIR__ . '/../config/config.php';
require __DIR__ . '/../includes/menu.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../views/login.php");
    exit;
}

// Obtém os filamentos do banco de dados
$stmt = $pdo->query("SELECT * FROM filamentos ORDER BY Tipo ASC");
$filamentos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-4">
    <h2>Lista de Filamentos</h2>
    <a href="../controllers/adicionar_filamento.php" class="btn btn-success mb-3">Adicionar Filamento</a>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tipo</th>
                <th>Fabricante</th>
                <th>Valor por Kg (R$)</th>
                <th>Última Atualização</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($filamentos as $filamento): ?>
                <tr>
                    <td><?= $filamento['id'] ?></td>
                    <td><?= htmlspecialchars($filamento['Tipo']) ?></td>
                    <td><?= htmlspecialchars($filamento['Fabricante']) ?></td>
                    <td>R$ <?= number_format($filamento['Valor_Kg'], 2, ',', '.') ?></td>
                    <td><?= date("d/m/Y", strtotime($filamento['Ultima_Atualizacao'])) ?></td>
                    <td>
                        <a href="../controllers/editar_filamento.php?id=<?= $filamento['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                        <a href="../controllers/excluir_filamento.php?id=<?= $filamento['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>