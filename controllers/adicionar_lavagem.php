<?php
session_start();
require __DIR__ . '/../config/config.php';
require __DIR__ . '/../includes/menu.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $produto = $_POST["produto"];
    $valor_litro = $_POST["valor_litro"];
    $ultima_atualizacao = date("Y-m-d");

    // Cálculo automático do Fator de Consumo
    $fator_consumo = $valor_litro / 1000;

    $stmt = $pdo->prepare("INSERT INTO lavagem (Produto, Valor_Litro, Fator_Consumo, Ultima_Atualizacao) VALUES (?, ?, ?, ?)");
    $stmt->execute([$produto, $valor_litro, $fator_consumo, $ultima_atualizacao]);

    header("Location: ../views/lavagem.php");
    exit;
}
?>

<div class="container mt-4 pt-5">
    <h2>Adicionar Produto de Lavagem</h2>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Produto</label>
            <input type="text" name="produto" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Valor por Litro (R$)</label>
            <input type="number" name="valor_litro" class="form-control" step="0.01" required>
        </div>

        <p class="text-muted">
            <small>O Fator de Consumo será calculado automaticamente como Valor_Litro / 1000.</small><br>
            <small>Isso se baseia no fato de que, para cada 1g de resina lavada por uma impressora 3D, é utilizado 1ml de álcool.</small>
        </p>

        <button type="submit" class="btn btn-success mb-3">Adicionar</button>
        <a href="../views/lavagem.php" class="btn btn-secondary mb-3">Cancelar</a>
    </form>
</div>