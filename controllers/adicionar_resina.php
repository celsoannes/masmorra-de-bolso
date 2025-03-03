<?php
session_start();
require __DIR__ . '/../config/config.php';
require __DIR__ . '/../includes/menu.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tipo = $_POST["tipo"];
    $fabricante = $_POST["fabricante"];
    $valor_kg = $_POST["valor_kg"];
    $data_atualizacao = date("Y-m-d");

    $stmt = $pdo->prepare("INSERT INTO resinas (Tipo, Fabricante, Valor_Kg, Ultima_Atualizacao) VALUES (?, ?, ?, ?)");
    $stmt->execute([$tipo, $fabricante, $valor_kg, $data_atualizacao]);

    header("Location: ../views/resinas.php");
    exit;
}
?>

<div class="container mt-4">
    <h2>Adicionar Resina</h2>
    <form method="post">
        <div class="mb-3">
            <label class="form-label">Tipo</label>
            <input type="text" name="tipo" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Fabricante</label>
            <input type="text" name="fabricante" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Valor por Kg</label>
            <input type="number" name="valor_kg" class="form-control" step="0.01" required>
        </div>

        <button type="submit" class="btn btn-success mt-3">Salvar</button>
        <a href="../views/resinas.php" class="btn btn-secondary mt-3">Voltar</a>
    </form>
</div>