<?php
session_start();
require __DIR__ . '/../config/config.php';
require __DIR__ . '/../includes/menu.php';

$stmt = $pdo->query("SELECT * FROM tabela_energia");
$energias = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-4">
    <h2>Lista de Tarifas de Energia</h2>
    <a href="../controllers/adicionar_energia.php" class="btn btn-success mb-3">Adicionar Tarifa</a>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Prestadora</th>
                <th>kWh (R$)</th>
                <th>ICMS (%)</th>
                <th>PIS/PASEP (%)</th>
                <th>COFINS (%)</th>
                <th>Total/hora (R$)</th>
                <th>Última Atualização</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($energias as $energia): ?>
                <tr>
                    <td><?= htmlspecialchars($energia['Prestadora']) ?></td>
                    <td><?= number_format($energia['kWh'], 2, ',', '.') ?></td>
                    <td><?= number_format($energia['ICMS'], 2, ',', '.') ?></td>
                    <td><?= number_format($energia['PIS_PASEP'], 2, ',', '.') ?></td>
                    <td><?= number_format($energia['COFINS'], 2, ',', '.') ?></td>
                    <td><?= number_format($energia['TOTAL_horas'], 2, ',', '.') ?></td>
                    <td><?= date('d/m/Y', strtotime($energia['Ultima_Atualizacao'])) ?></td>
                    <td>
                        <a href="../controllers/editar_energia.php?id=<?= $energia['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                        <a href="../controllers/excluir_energia.php?id=<?= $energia['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>