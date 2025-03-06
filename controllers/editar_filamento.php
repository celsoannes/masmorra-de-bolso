<?php
session_start();
require __DIR__ . '/../config/config.php';

if (!isset($_SESSION['usuario_id']) || !isset($_GET['id'])) {
    header("Location: ../views/filamentos.php");
    exit;
}

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM filamentos WHERE id = ?");
$stmt->execute([$id]);
$filamento = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$filamento) {
    header("Location: ../views/filamentos.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tipo = $_POST["tipo"];
    $fabricante = $_POST["fabricante"];
    $valor_kg = $_POST["valor_kg"];
    $ultima_atualizacao = $_POST["ultima_atualizacao"];

    $stmt = $pdo->prepare("UPDATE filamentos SET Tipo = ?, Fabricante = ?, Valor_Kg = ?, Ultima_Atualizacao = ? WHERE id = ?");
    $stmt->execute([$tipo, $fabricante, $valor_kg, $ultima_atualizacao, $id]);

    header("Location: ../views/filamentos.php");
    exit;
}

// Inclui o menu apenas após garantir que não há redirecionamento
require __DIR__ . '/../includes/menu.php';
?>

<div class="container mt-4 pt-5">
    <h2>Editar Filamento</h2>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Tipo</label>
            <input type="text" name="tipo" class="form-control" value="<?= htmlspecialchars($filamento['Tipo']) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Fabricante</label>
            <input type="text" name="fabricante" class="form-control" value="<?= htmlspecialchars($filamento['Fabricante']) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Valor por Kg (R$)</label>
            <input type="number" step="0.01" name="valor_kg" class="form-control" value="<?= htmlspecialchars($filamento['Valor_Kg']) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Última Atualização</label>
            <input type="date" name="ultima_atualizacao" class="form-control" value="<?= htmlspecialchars($filamento['Ultima_Atualizacao']) ?>" required>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Salvar Alterações</button>
        <a href="../views/filamentos.php" class="btn btn-secondary mt-3">Voltar</a>
    </form>
</div>