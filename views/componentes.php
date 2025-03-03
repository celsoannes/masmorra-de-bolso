<?php
session_start();
require __DIR__ . '/../config/config.php';
require __DIR__ . '/../includes/menu.php';

// Buscar todos os componentes
$componentes = $pdo->query("SELECT * FROM componentes ORDER BY nome_material")->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-4">
    <h2>Lista de Componentes</h2>
    <a href="../controllers/adicionar_componente.php" class="btn btn-success mb-3">Adicionar Componente</a>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Imagem</th>
                <th>Nome</th>
                <th>Tipo</th>
                <th>Unidade</th>
                <th>Preço Unitário</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($componentes as $componente): ?>
                <tr>
                    <td><img src="<?= htmlspecialchars($componente['caminho_imagem']) ?>" alt="Imagem da peça" class="img-thumbnail" width="80"></td>
                    <td><?= htmlspecialchars($componente['nome_material']) ?></td>
                    <td><?= htmlspecialchars($componente['tipo_material']) ?></td>
                    <td><?= htmlspecialchars($componente['unidade_medida']) ?></td>
                    <td>R$ <?= number_format($componente['preco_unitario'], 2, ',', '.') ?></td>
                    <td>
                        <a href="../controllers/editar_componente.php?id=<?= $componente['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                        <a href="../controllers/excluir_componente.php?id=<?= $componente['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir?');">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>