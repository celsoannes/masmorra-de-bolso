<?php
session_start();
require __DIR__ . '/../config/config.php';

if (!isset($_SESSION['usuario_id']) || !isset($_GET['id'])) {
    header("Location: ../views/impressoras.php");
    exit;
}

$id = $_GET['id'];
$pdo->prepare("DELETE FROM impressoras WHERE ID = ?")->execute([$id]);

header("Location: ../views/impressoras.php");
exit;
?>