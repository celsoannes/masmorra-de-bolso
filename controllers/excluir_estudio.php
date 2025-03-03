<?php
session_start();
require __DIR__ . '/../config/config.php';

if (!isset($_SESSION['usuario_id']) || !isset($_GET['id'])) {
    header("Location: ../views/estudios.php");
    exit;
}

$id = intval($_GET['id']); // Converte para inteiro para evitar SQL Injection

try {
    $stmt = $pdo->prepare("DELETE FROM estudios WHERE id = ?");
    $stmt->execute([$id]);

    header("Location: ../views/estudios.php");
    exit;
} catch (PDOException $e) {
    echo "Erro ao excluir: " . $e->getMessage();
}
?>