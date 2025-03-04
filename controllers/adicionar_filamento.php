<?php
session_start();
require __DIR__ . '/../config/config.php';
require __DIR__ . '/../includes/menu.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../views/login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tipo = $_POST["tipo"];
    $fabricante = $_POST["fabricante"];
    $valor_kg = $_POST["valor_kg"];
    $ultima_atualizacao = date("Y-m-d");

    $stmt = $pdo->prepare("INSERT INTO filamentos (Tipo, Fabricante, Valor_Kg, Ultima_Atualizacao) VALUES (?, ?, ?, ?)");
    $stmt->execute([$tipo, $fabricante, $valor_kg, $ultima_atualizacao]);

    header("Location: ../views/filamentos.php");
    exit;
}
?>

<div class="container mt-4 pt-5">
    <h2>Adicionar Filamento</h2>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Tipo</label>
            <input type="text" name="tipo" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Fabricante</label>
            <input type="text" name="fabricante" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Valor por Kg (R$)</label>
            <input type="number" name="valor_kg" step="0.01" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success mt-3">Salvar</button>
        <a href="../views/filamentos.php" class="btn btn-secondary mt-3">Voltar</a>
    </form>
</div>