<?php
session_start();
require __DIR__ . '/../config/config.php';
require __DIR__ . '/../includes/menu.php';

// Ativar erros para depuração
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['usuario_id']) || !isset($_GET['id'])) {
    header("Location: ../views/estudios.php");
    exit;
}

$id = intval($_GET['id']);
$stmt = $pdo->prepare("SELECT * FROM estudios WHERE id = ?");
$stmt->execute([$id]);
$estudio = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$estudio) {
    header("Location: ../views/estudios.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["nome"];
    $site = $_POST["site"];

    $stmt = $pdo->prepare("UPDATE estudios SET nome = ?, site = ? WHERE id = ?");
    $stmt->execute([$nome, $site, $id]);

    header("Location: ../views/estudios.php");
    exit;
}
?>

<div class="container mt-5">
    <h2>Editar Estúdio</h2>
    <form method="POST">
        <div class="mb-3">
            <label for="nome" class="form-label">Nome</label>
            <input type="text" name="nome" id="nome" class="form-control" value="<?= htmlspecialchars($estudio['nome']) ?>" required>
        </div>

        <div class="mb-3">
            <label for="site" class="form-label">Site</label>
            <input type="url" name="site" id="site" class="form-control" value="<?= htmlspecialchars($estudio['site']) ?>">
        </div>

        <button type="submit" class="btn btn-primary mt-3">Salvar Alterações</button>
        <a href="../views/estudios.php" class="btn btn-secondary mt-3">Voltar</a>
    </form>
</div>