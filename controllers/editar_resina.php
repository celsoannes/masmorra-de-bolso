<?php
session_start();
require __DIR__ . '/../config/config.php';
require __DIR__ . '/../includes/menu.php';

if (!isset($_GET['id'])) {
    header("Location: ../views/resinas.php");
    exit;
}

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM resinas WHERE id = ?");
$stmt->execute([$id]);
$resina = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$resina) {
    header("Location: ../views/resinas.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tipo = $_POST['tipo'];
    $fabricante = $_POST['fabricante'];
    $valor_kg = $_POST['valor_kg'];
    $data_atual = date('Y-m-d');

    $stmt = $pdo->prepare("UPDATE resinas SET Tipo = ?, Fabricante = ?, Valor_Kg = ?, Ultima_Atualizacao = ? WHERE id = ?");
    $stmt->execute([$tipo, $fabricante, $valor_kg, $data_atual, $id]);

    header("Location: ../views/resinas.php");
    exit;
}
?>

<div class="container mt-4">
    <h2>Editar Resina</h2>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Tipo</label>
            <input type="text" name="tipo" class="form-control" value="<?= htmlspecialchars($resina['Tipo']) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Fabricante</label>
            <input type="text" name="fabricante" class="form-control" value="<?= htmlspecialchars($resina['Fabricante']) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Valor por Kg (R$)</label>
            <input type="number" name="valor_kg" class="form-control" step="0.01" value="<?= $resina['Valor_Kg'] ?>" required>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Salvar Alterações</button>
        <a href="../views/resinas.php" class="btn btn-secondary mt-3">Voltar</a>
    </form>
</div>