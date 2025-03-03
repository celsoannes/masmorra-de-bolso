<?php
session_start();
require __DIR__ . '/../config/config.php';

if (!isset($_SESSION['usuario_id']) || !isset($_GET['id'])) {
    header("Location: ../views/filamentos.php");
    exit;
}

$id = $_GET['id'];
$stmt = $pdo->prepare("DELETE FROM filamentos WHERE id = ?");
$stmt->execute([$id]);

header("Location: ../views/filamentos.php");
exit;
?>