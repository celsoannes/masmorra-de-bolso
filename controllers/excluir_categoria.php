<?php
session_start();
require __DIR__ . '/../config/config.php';

if (!isset($_SESSION['usuario_id']) || !isset($_GET['id'])) {
    header("Location: ../views/categorias.php");
    exit;
}

$id = $_GET['id'];
$stmt = $pdo->prepare("DELETE FROM categorias WHERE id = ?");
$stmt->execute([$id]);

// Redireciona para a página de categorias após excluir
header("Location: ../views/categorias.php");
exit; // Certifique-se de que o script para aqui após o redirecionamento
?>