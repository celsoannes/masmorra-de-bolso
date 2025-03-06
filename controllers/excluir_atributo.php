<?php
session_start();
require __DIR__ . '/../config/config.php';

if (!isset($_SESSION['usuario_id']) || !isset($_GET['id'])) {
    header("Location: ../views/atributos.php");
    exit;
}

$id = $_GET['id'];
$stmt = $pdo->prepare("DELETE FROM categoria_atributos WHERE id = ?");
$stmt->execute([$id]);

// Redireciona para a página de atributos após excluir
header("Location: ../views/atributos.php");
exit; // Certifique-se de que o script para aqui após o redirecionamento
?>