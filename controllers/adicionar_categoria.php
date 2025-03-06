<?php
session_start();
require __DIR__ . '/../config/config.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../views/login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["nome"];

    $stmt = $pdo->prepare("INSERT INTO categorias (nome) VALUES (?)");
    $stmt->execute([$nome]);

    // Redireciona para a página de categorias após salvar
    header("Location: ../views/categorias.php");
    exit; // Certifique-se de que o script para aqui após o redirecionamento
}

// Inclui o menu apenas após garantir que não há redirecionamento
require __DIR__ . '/../includes/menu.php';
?>

<div class="container mt-4 pt-5">
    <h2>Adicionar Categoria</h2>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Nome da Categoria</label>
            <input type="text" name="nome" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success mt-3">Salvar</button>
        <a href="../views/categorias.php" class="btn btn-secondary mt-3">Voltar</a>
    </form>
</div>