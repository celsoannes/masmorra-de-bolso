<?php
session_start();
require __DIR__ . '/../config/config.php';
require __DIR__ . '/../includes/menu.php';

$stmt = $pdo->query("SELECT * FROM lavagem");
$lavagens = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-4">
    <h2>Lista de Produtos de Lavagem</h2>
    <a href="../controllers/adicionar_lavagem.php" class="btn btn-success mb-3">Adicionar Produto</a>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Produto</th>
                <th>Valor por Litro (R$)</th>
                <th>Fator de Consumo</th>
                <th>Última Atualização</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($lavagens as $lavagem): ?>
                <tr>
                    <td><?= htmlspecialchars($lavagem['Produto']) ?></td>
                    <td>R$ <?= number_format($lavagem['Valor_Litro'], 2, ',', '.') ?></td>
                    <td><?= htmlspecialchars($lavagem['Fator_Consumo']) ?></td>
                    <td><?= date('d/m/Y', strtotime($lavagem['Ultima_Atualizacao'])) ?></td>
                    <td>
                        <a href="../controllers/editar_lavagem.php?id=<?= $lavagem['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                        <a href="../controllers/excluir_lavagem.php?id=<?= $lavagem['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>