<?php
session_start();
require __DIR__ . '/../config/config.php';
require __DIR__ . '/../includes/menu.php';

$stmt = $pdo->query("SELECT * FROM resinas ORDER BY Tipo ASC");
$resinas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-4 pt-5">
    <h2>Lista de Resinas</h2>
    <a href="../controllers/adicionar_resina.php" class="btn btn-success mb-3">Adicionar Nova Resina</a>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tipo</th>
                <th>Fabricante</th>
                <th>Valor (R$/Kg)</th>
                <th>Última Atualização</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($resinas as $resina): ?>
                <tr>
                    <td><?= $resina['id'] ?></td>
                    <td><?= htmlspecialchars($resina['Tipo']) ?></td>
                    <td><?= htmlspecialchars($resina['Fabricante']) ?></td>
                    <td>R$ <?= number_format($resina['Valor_Kg'], 2, ',', '.') ?></td>
                    <td><?= date('d/m/Y', strtotime($resina['Ultima_Atualizacao'])) ?></td>
                    <td>
                        <a href="../controllers/editar_resina.php?id=<?= $resina['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                        <a href="../controllers/excluir_resina.php?id=<?= $resina['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir esta resina?')">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>