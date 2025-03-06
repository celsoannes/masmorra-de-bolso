<?php
session_start();
require __DIR__ . '/../config/config.php';

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM lavagem WHERE id = ?");
$stmt->execute([$id]);
$lavagem = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $produto = $_POST["produto"];
    $valor_litro = $_POST["valor_litro"];
    $data_atualizacao = date('Y-m-d');

    // Cálculo automático do Fator de Consumo
    $fator_consumo = $valor_litro / 1000;

    $stmt = $pdo->prepare("UPDATE lavagem SET Produto=?, Valor_Litro=?, Fator_Consumo=?, Ultima_Atualizacao=? WHERE id=?");
    $stmt->execute([$produto, $valor_litro, $fator_consumo, $data_atualizacao, $id]);

    header("Location: ../views/lavagem.php");
    exit;
}

// Inclui o menu apenas após garantir que não há redirecionamento
require __DIR__ . '/../includes/menu.php';
?>

<div class="container mt-4 pt-5">
    <h2>Editar Produto de Lavagem</h2>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Produto</label>
            <input type="text" name="produto" class="form-control" value="<?= htmlspecialchars($lavagem['Produto']) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Valor por Litro (R$)</label>
            <input type="number" step="0.01" name="valor_litro" class="form-control" value="<?= htmlspecialchars($lavagem['Valor_Litro']) ?>" required oninput="atualizarFatorConsumo()">
        </div>

        <div class="mb-3">
            <label class="form-label">Fator de Consumo</label>
            <input type="text" id="fator_consumo" class="form-control" value="<?= number_format($lavagem['Valor_Litro'] / 1000, 3, ',', '.') ?>" disabled>
        </div>

        <p class="text-muted">
            <small>O Fator de Consumo será calculado automaticamente como Valor_Litro / 1000.</small><br>
            <small>Isso se baseia no fato de que, para cada 1g de resina lavada por uma impressora 3D, é utilizado 1ml de álcool.</small>
        </p>
        
        <button type="submit" class="btn btn-primary mt-3">Salvar Alterações</button>
        <a href="../views/lavagem.php" class="btn btn-secondary mt-3">Cancelar</a>
    </form>
</div>

<script>
    function atualizarFatorConsumo() {
        let valorLitro = document.querySelector('input[name="valor_litro"]').value;
        let fatorConsumo = (valorLitro / 1000).toFixed(3).replace('.', ',');
        document.getElementById('fator_consumo').value = fatorConsumo;
    }
</script>