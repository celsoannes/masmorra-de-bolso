<?php
session_start();
require __DIR__ . '/../config/config.php';
require __DIR__ . '/../includes/menu.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

// Obter o ID do produto
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Buscar os detalhes do produto
$stmt = $pdo->prepare("SELECT * FROM produtos WHERE id = ?");
$stmt->execute([$id]);
$produto = $stmt->fetch();

// Se o produto não for encontrado, redireciona de volta
if (!$produto) {
    header("Location: index.php");
    exit;
}

// Buscar as peças associadas ao produto
$stmt_pecas = $pdo->prepare("SELECT p.id AS peca_id, p.nome AS nome_peca, p.imagem AS imagem_peca, p.material AS material_peca, 
                                   p.quantidade_material, p.tempo_impressao, i.Marca AS marca_impressora, i.Modelo AS modelo_impressora, 
                                   i.Tipo AS tipo_impressora, i.Localizacao AS localizacao_impressora, i.kWh AS consumo_impressora
                            FROM pecas p
                            JOIN impressoras i ON p.impressora = i.ID
                            JOIN produtos_pecas pp ON p.id = pp.peca_id
                            WHERE pp.produto_id = ?");
$stmt_pecas->execute([$id]);
$pecas = $stmt_pecas->fetchAll();

// Buscar os componentes associados ao produto
$stmt_componentes = $pdo->prepare("SELECT c.nome_material, c.tipo_material, c.descricao, c.unidade_medida, 
                                          c.preco_unitario, c.fornecedor, c.caminho_imagem, pc.quantidade
                                   FROM produtos_componentes pc
                                   JOIN componentes c ON pc.componente_id = c.id
                                   WHERE pc.produto_id = ?");
$stmt_componentes->execute([$id]);
$componentes = $stmt_componentes->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Produto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2><?= htmlspecialchars($produto['nome']) ?></h2>
        <img src="<?= htmlspecialchars($produto['caminho_imagem']) ?>" alt="Imagem do Produto" class="img-fluid mb-3" style="max-width: 300px;">
        
        <ul class="list-group">
            <li class="list-group-item"><strong>Vídeo:</strong> <a href="<?= htmlspecialchars($produto['video']) ?>" target="_blank">Assistir</a></li>
            <li class="list-group-item"><strong>Download:</strong> <a href="<?= htmlspecialchars($produto['baixar']) ?>" target="_blank">Baixar</a></li>
            <li class="list-group-item"><strong>Observações:</strong> <?= nl2br(htmlspecialchars($produto['observacoes'])) ?></li>
            <li class="list-group-item"><strong>Lucro Estimado:</strong> R$ <?= number_format($produto['lucro'], 2, ',', '.') ?></li>
        </ul>

        <h3 class="mt-4">Detalhes da Peça Associada</h3>
        <ul class="list-group">
            <?php foreach ($pecas as $peca): ?>
                <li class="list-group-item">
                    <img src="<?= htmlspecialchars($peca['imagem_peca']) ?>" alt="Imagem da Peça" class="img-fluid mb-2" style="max-width: 100px;">
                    <strong><?= htmlspecialchars($peca['nome_peca']) ?></strong> - 
                    <?= htmlspecialchars($peca['material_peca']) ?>
                    <br>
                    <small>Quantidade de Material: <?= number_format($peca['quantidade_material'], 2, ',', '.') ?> g</small>
                    <br>
                    <small>Tempo de Impressão: <?= htmlspecialchars($peca['tempo_impressao']) ?></small>
                    <br>
                    <small>Impressora: <?= htmlspecialchars($peca['marca_impressora']) ?> - <?= htmlspecialchars($peca['modelo_impressora']) ?></small>
                    <br>
                    <small>Tipo da Impressora: <?= htmlspecialchars($peca['tipo_impressora']) ?></small>
                    <br>
                    <small>Localização: <?= htmlspecialchars($peca['localizacao_impressora']) ?></small>
                    <br>
                    <small>Consumo de Energia: <?= number_format($peca['consumo_impressora'], 3, ',', '.') ?> kWh</small>
                </li>
            <?php endforeach; ?>
        </ul>

        <h3 class="mt-4">Componentes do Produto</h3>
        <ul class="list-group">
            <?php foreach ($componentes as $componente): ?>
                <li class="list-group-item">
                    <img src="<?= htmlspecialchars($componente['caminho_imagem']) ?>" alt="Imagem do Componente" class="img-fluid mb-2" style="max-width: 100px;">
                    <strong><?= htmlspecialchars($componente['nome_material']) ?></strong> - 
                    <?= htmlspecialchars($componente['tipo_material']) ?>
                    <br>
                    <small>Quantidade: <?= htmlspecialchars($componente['quantidade']) ?> <?= htmlspecialchars($componente['unidade_medida']) ?></small>
                    <br>
                    <small>Fornecedor: <?= htmlspecialchars($componente['fornecedor']) ?></small>
                </li>
            <?php endforeach; ?>
        </ul>
        
        <a href="index.php" class="btn btn-primary mt-3">Voltar</a>
    </div>
</body>
</html>