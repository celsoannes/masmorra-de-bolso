<?php
session_start();
require __DIR__ . '/../config/config.php';
require __DIR__ . '/../includes/menu.php';

$stmt = $pdo->query("SELECT * FROM impressoras");
$impressoras = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-4 pt-5">
    <h2>Lista de Impressoras</h2>
    <a href="../controllers/adicionar_impressora.php" class="btn btn-success mb-3">Adicionar Impressora</a>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Tipo</th>
                <th>Localização</th>
                <th>Data de Aquisição</th>
                <th>Valor do Bem (R$)</th>
                <th>Tempo de Vida Útil (horas)</th>
                <th>Consumo de Energia (kWh)</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($impressoras as $impressora): ?>
                <tr>
                    <td><?= htmlspecialchars($impressora['Marca']) ?></td>
                    <td><?= htmlspecialchars($impressora['Modelo']) ?></td>
                    <td><?= htmlspecialchars($impressora['Tipo']) ?></td>
                    <td><?= htmlspecialchars($impressora['Localizacao']) ?></td>
                    <td><?= date("d/m/Y", strtotime($impressora['Data_Aquisicao'])) ?></td>
                    <td>R$ <?= number_format($impressora['Valor_do_Bem'], 2, ',', '.') ?></td>
                    <td><?= htmlspecialchars($impressora['Tempo_de_Vida_Util']) ?> horas</td>
                    <td><?= number_format($impressora['kWh'], 3, ',', '.') ?> kWh</td>
                    <td>
                        <a href="../controllers/editar_impressora.php?id=<?= $impressora['ID'] ?>" class="btn btn-warning btn-sm">Editar</a>
                        <a href="../controllers/excluir_impressora.php?id=<?= $impressora['ID'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>