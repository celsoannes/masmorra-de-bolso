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

// Buscar a peça associada ao produto
$stmt_peca = $pdo->prepare("SELECT p.id AS peca_id, p.nome AS nome_peca, p.imagem AS imagem_peca, p.material AS material_peca, 
                                   p.quantidade_material, p.tempo_impressao, i.Marca AS marca_impressora, i.Modelo AS modelo_impressora, 
                                   i.Tipo AS tipo_impressora, i.Localizacao AS localizacao_impressora, i.kWh AS consumo_impressora
                            FROM pecas p
                            JOIN impressoras i ON p.impressora = i.ID
                            WHERE p.id = (SELECT peca_id FROM produtos_pecas WHERE produto_id = ? LIMIT 1)");
$stmt_peca->execute([$id]);
$peca = $stmt_peca->fetch();

// Se a peça não for encontrada, redireciona de volta
if (!$peca) {
    header("Location: index.php");
    exit;
}
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
        <img src="<?= htmlspecialchars($peca['imagem_peca']) ?>" alt="Imagem da Peça" class="img-fluid mb-3" style="max-width: 300px;">
        <ul class="list-group">
            <li class="list-group-item"><strong>Nome da Peça:</strong> <?= htmlspecialchars($peca['nome_peca']) ?></li>
            <li class="list-group-item"><strong>Material da Peça:</strong> <?= htmlspecialchars($peca['material_peca']) ?></li>
            <li class="list-group-item"><strong>Quantidade de Material:</strong> <?= number_format($peca['quantidade_material'], 2, ',', '.') ?> g</li>
            <li class="list-group-item"><strong>Tempo de Impressão:</strong> <?= htmlspecialchars($peca['tempo_impressao']) ?></li>
            <li class="list-group-item"><strong>Impressora Associada:</strong> <?= htmlspecialchars($peca['marca_impressora']) ?> - <?= htmlspecialchars($peca['modelo_impressora']) ?></li>
            <li class="list-group-item"><strong>Tipo da Impressora:</strong> <?= htmlspecialchars($peca['tipo_impressora']) ?></li>
            <li class="list-group-item"><strong>Localização da Impressora:</strong> <?= htmlspecialchars($peca['localizacao_impressora']) ?></li>
            <li class="list-group-item"><strong>Consumo de Energia (kWh):</strong> <?= number_format($peca['consumo_impressora'], 3, ',', '.') ?></li>
        </ul>

        <a href="index.php" class="btn btn-primary mt-3">Voltar</a>
    </div>
</body>
</html>
