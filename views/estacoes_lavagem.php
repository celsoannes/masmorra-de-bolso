<?php
session_start();
require __DIR__ . '/../config/config.php';
require __DIR__ . '/../includes/menu.php';

// Modifique a query SQL para buscar os tempos de lavagem e cura
$stmt = $pdo->query("SELECT estacoes_lavagem.*, lavagem.Produto AS nome_lavagem FROM estacoes_lavagem LEFT JOIN lavagem ON estacoes_lavagem.lavagem_id = lavagem.id");
$estacoes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-4 pt-5">
    <h2>Lista de Estações de Lavagem</h2>
    <a href="../controllers/adicionar_estacao.php" class="btn btn-success mb-3">Adicionar Estação</a>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Localização</th>
                <th>Data de Aquisição</th>
                <th>Valor do Bem (R$)</th>
                <th>Tempo de Vida Útil (h)</th>
                <th>Tempo de Lavagem</th>
                <th>Tempo de Cura</th>
                <th>Consumo (kWh)</th>
                <th>Lavagem</th> <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($estacoes as $estacao): ?>
                <tr>
                    <td><?= htmlspecialchars($estacao['Marca']) ?></td>
                    <td><?= htmlspecialchars($estacao['Modelo']) ?></td>
                    <td><?= htmlspecialchars($estacao['Localizacao']) ?></td>
                    <td><?= date('d/m/Y', strtotime($estacao['Data_Aquisicao'])) ?></td>
                    <td>R$ <?= number_format($estacao['Valor_do_Bem'], 2, ',', '.') ?></td>
                    <td><?= htmlspecialchars($estacao['Tempo_de_Vida_Util']) ?></td>
                    <td><?= htmlspecialchars($estacao['tempo_lavagem']) ?></td>
                    <td><?= htmlspecialchars($estacao['tempo_cura']) ?></td>
                    <td><?= htmlspecialchars($estacao['kWh']) ?></td>
                    <td><?= htmlspecialchars($estacao['nome_lavagem']) ?></td> <td>
                        <a href="../controllers/editar_estacao.php?id=<?= $estacao['ID'] ?>" class="btn btn-warning btn-sm">Editar</a>
                        <a href="../controllers/excluir_estacao.php?id=<?= $estacao['ID'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>