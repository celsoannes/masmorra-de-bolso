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

// Buscar as peças associadas ao produto e calcular os custos
$stmt_pecas = $pdo->prepare("
    SELECT p.id AS peca_id, p.nome AS nome_peca, p.imagem AS imagem_peca, p.material AS material_peca, 
           p.quantidade_material, p.tempo_impressao, i.Marca AS marca_impressora, i.Modelo AS modelo_impressora, 
           i.Tipo AS tipo_impressora, i.Localizacao AS localizacao_impressora, i.kWh AS consumo_impressora,
           t.Prestadora, t.kWh AS kWh_energia, t.ICMS, t.PIS_PASEP, t.COFINS, t.TOTAL_horas,
           i.Valor_do_Bem, i.Tempo_de_Vida_Util
    FROM pecas p
    JOIN impressoras i ON p.impressora = i.ID
    JOIN produtos_pecas pp ON p.id = pp.peca_id
    JOIN tabela_energia t ON 1=1
    WHERE pp.produto_id = ?
");
$stmt_pecas->execute([$id]);
$pecas = $stmt_pecas->fetchAll();

// Função para calcular o custo de energia
function calcularCustoEnergia($consumo_impressora, $tempo_impressao, $kWh_energia, $ICMS, $PIS_PASEP, $COFINS, $TOTAL_horas) {
    // Converter o tempo de impressão (hh:mm:ss) para minutos
    list($horas, $minutos, $segundos) = explode(":", $tempo_impressao);
    $tempo_impressao_minutos = ($horas * 60) + $minutos + ($segundos / 60);
    
    // Calcular o custo do kWh com base na prestadora
    $custo_kWh = $TOTAL_horas + ($TOTAL_horas * ($ICMS / 100)) + ($TOTAL_horas * ($PIS_PASEP / 100)) + ($TOTAL_horas * ($COFINS / 100));
    
    // Cálculo do custo de energia
    $custo_energia = ($consumo_impressora * $tempo_impressao_minutos / 60) * $custo_kWh;
    return $custo_energia;
}

// Função para calcular o custo por quilo do material
function calcularCustoMaterial($tipo_impressora, $material_peca, $quantidade_material) {
    global $pdo;
    
    if ($tipo_impressora == 'Filamento') {
        $stmt_filamento = $pdo->prepare("SELECT Valor_Kg FROM filamentos WHERE Tipo = ?");
        $stmt_filamento->execute([$material_peca]);
        $filamento = $stmt_filamento->fetch();
        $valor_kg = $filamento['Valor_Kg'];
    } else {
        $stmt_resina = $pdo->prepare("SELECT Valor_Kg FROM resinas WHERE Tipo = ?");
        $stmt_resina->execute([$material_peca]);
        $resina = $stmt_resina->fetch();
        $valor_kg = $resina['Valor_Kg'];
    }
    
    // Calcular o custo por grama e converter para o custo total
    $custo_material = ($valor_kg / 1000) * $quantidade_material;
    return $custo_material;
}

// Função para calcular a depreciação/manutenção
function calcularDepreciacao($tempo_impressao, $Valor_do_Bem, $Tempo_de_Vida_Util) {
    // Converter o tempo de impressão (hh:mm:ss) para minutos
    list($horas, $minutos, $segundos) = explode(":", $tempo_impressao);
    $tempo_impressao_minutos = ($horas * 60) + $minutos + ($segundos / 60);
    
    // Calcular a depreciação
    $depreciacao = ($Valor_do_Bem / ($Tempo_de_Vida_Util * 60)) * $tempo_impressao_minutos;
    return $depreciacao;
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
        <ul class="list-group">
            <?php foreach ($pecas as $peca): 
                // Cálculos de custo
                $custo_energia = calcularCustoEnergia($peca['consumo_impressora'], $peca['tempo_impressao'], $peca['kWh_energia'], 
                                                      $peca['ICMS'], $peca['PIS_PASEP'], $peca['COFINS'], $peca['TOTAL_horas']);
                $custo_material = calcularCustoMaterial($peca['tipo_impressora'], $peca['material_peca'], $peca['quantidade_material']);
                $depreciacao = calcularDepreciacao($peca['tempo_impressao'], $peca['Valor_do_Bem'], $peca['Tempo_de_Vida_Util']);
            ?>
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

        <h3 class="mt-4">Cálculo do Custo de Produção</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Peça</th>
                    <th>Custo de Energia (R$)</th>
                    <th>Custo de Material (R$)</th>
                    <th>Depreciação/Manutenção (R$)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pecas as $peca): 
                    // Recalcular os custos para exibição
                    $custo_energia = calcularCustoEnergia($peca['consumo_impressora'], $peca['tempo_impressao'], $peca['kWh_energia'], 
                                                          $peca['ICMS'], $peca['PIS_PASEP'], $peca['COFINS'], $peca['TOTAL_horas']);
                    $custo_material = calcularCustoMaterial($peca['tipo_impressora'], $peca['material_peca'], $peca['quantidade_material']);
                    $depreciacao = calcularDepreciacao($peca['tempo_impressao'], $peca['Valor_do_Bem'], $peca['Tempo_de_Vida_Util']);
                ?>
                <tr>
                    <td><?= htmlspecialchars($peca['nome_peca']) ?></td>
                    <td>R$ <?= number_format($custo_energia, 2, ',', '.') ?></td>
                    <td>R$ <?= number_format($custo_material, 2, ',', '.') ?></td>
                    <td>R$ <?= number_format($depreciacao, 2, ',', '.') ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>
</body>
</html>