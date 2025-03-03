<?php
session_start();
require __DIR__ . '/../config/config.php';
require __DIR__ . '/../includes/menu.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$stmt = $pdo->query("SELECT p.*, e.nome AS estudio_nome, i.modelo AS impressora_nome 
                     FROM pecas p 
                     INNER JOIN estudios e ON p.estudio_id = e.id
                     INNER JOIN impressoras i ON p.impressora = i.id
                     ORDER BY p.nome");

$pecas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-4">
    <h2>Lista de Peças 3D</h2>
    <a href="../controllers/adicionar_peca.php" class="btn btn-success mb-3">Adicionar Peça</a>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Imagem</th>
                <th>Nome</th>
                <th>Estúdio</th>
                <th>Nome Original</th>
                <th>Nome do Arquivo</th>
                <th>Impressora</th>
                <th>Material</th>
                <th>Qtd. Material (g)</th>
                <th>Tempo Impressão</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pecas as $peca): ?>
                <tr>
                    <td>
                        <?php if (!empty($peca['imagem'])): ?>
                            <img src="/<?= htmlspecialchars($peca['imagem']) ?>" alt="Imagem da peça" class="img-thumbnail" width="80">
                        <?php else: ?>
                            <span>Sem imagem</span>
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($peca['nome']) ?></td>
                    <td><?= htmlspecialchars($peca['estudio_nome']) ?></td>
                    <td><?= htmlspecialchars($peca['nome_original']) ?></td>
                    <td><?= htmlspecialchars($peca['nome_arquivo']) ?></td>
                    <td><?= htmlspecialchars($peca['impressora_nome']) ?></td>
                    <td><?= htmlspecialchars($peca['material']) ?></td>
                    <td><?= htmlspecialchars($peca['quantidade_material']) ?></td>
                    <td><?= htmlspecialchars($peca['tempo_impressao']) ?></td>
                    <td>
                        <a href="/controllers/editar_peca.php?id=<?= $peca['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                        <a href="/controllers/excluir_peca.php?id=<?= $peca['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir esta peça?');">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="index.php" class="btn btn-secondary">Voltar ao Menu</a>
</div>
