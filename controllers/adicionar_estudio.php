<?php
session_start();
require __DIR__ . '/../config/config.php';
require __DIR__ . '/../includes/menu.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../views/login.php");
    exit;
}

$erro = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = trim($_POST["nome"]);
    $site = trim($_POST["site"]);

    if (!empty($nome)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO estudios (nome, site) VALUES (?, ?)");
            $stmt->execute([$nome, $site ?: null]);
            header("Location: ../views/estudios.php");
            exit;
        } catch (PDOException $e) {
            $erro = "Erro: Estúdio já existe.";
        }
    } else {
        $erro = "Nome do estúdio é obrigatório.";
    }
}
?>

<div class="container mt-5">
    <h2>Adicionar Estúdio</h2>
    <?php if ($erro) echo "<div class='alert alert-danger'>$erro</div>"; ?>
    <form method="POST">
        <div class="mb-3">
            <label>Nome do Estúdio</label>
            <input type="text" name="nome" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Site</label>
            <input type="url" name="site" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary mt-3">Salvar</button>
        <a href="../views/estudios.php" class="btn btn-secondary mt-3">Voltar</a>
    </form>
</div>