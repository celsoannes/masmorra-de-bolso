<?php
session_start();
require __DIR__ . '/../config/config.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../views/login.php");
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $pdo->prepare("DELETE FROM tags WHERE id = ?")->execute([$id]);
}

header("Location: ../views/tags.php");
exit;