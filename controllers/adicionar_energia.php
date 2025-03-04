<?php
session_start();
require __DIR__ . '/../config/config.php';
require __DIR__ . '/../includes/menu.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $prestadora = $_POST["prestadora"];
    $kWh = $_POST["kwh"];
    $icms = $_POST["icms"];
    $pis = $_POST["pis"];
    $cofins = $_POST["cofins"];
    $ultima_atualizacao = date('Y-m-d');

    // Cálculo do Total/hora (R$)
    $total_horas = $kWh + ($kWh * $icms / 100) + ($kWh * $pis / 100) + ($kWh * $cofins / 100);

    $stmt = $pdo->prepare("INSERT INTO tabela_energia (Prestadora, kWh, ICMS, PIS_PASEP, COFINS, TOTAL_horas, Ultima_Atualizacao) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$prestadora, $kWh, $icms, $pis, $cofins, $total_horas, $ultima_atualizacao]);

    header("Location: ../views/energia.php");
    exit;
}
?>

<div class="container mt-4 pt-5">
    <h2>Adicionar Tarifa de Energia</h2>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Prestadora</label>
            <input type="text" name="prestadora" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">kWh (R$)</label>
            <input type="number" step="0.01" name="kwh" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">ICMS (%)</label>
            <input type="number" step="0.01" name="icms" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">PIS/PASEP (%)</label>
            <input type="number" step="0.01" name="pis" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">COFINS (%)</label>
            <input type="number" step="0.01" name="cofins" class="form-control" required>
        </div>
        
        <button type="submit" class="btn btn-primary mt-3">Salvar</button>
        <a href="../views/energia.php" class="btn btn-secondary mt-3">Voltar</a>
    </form>
</div>