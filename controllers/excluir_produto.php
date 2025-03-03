<?php
session_start();
require __DIR__ . '/../config/config.php';

$id = $_GET['id'] ?? null;
if ($id && is_numeric($id)) {
    $stmt = $pdo->prepare("DELETE FROM produtos WHERE id = ?");
    $stmt->execute([$id]);
}

header("Location: ../views/produtos.php");
exit;