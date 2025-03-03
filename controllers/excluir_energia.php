<?php
session_start();
require __DIR__ . '/../config/config.php';

$id = $_GET['id'];
$stmt = $pdo->prepare("DELETE FROM tabela_energia WHERE id = ?");
$stmt->execute([$id]);

header("Location: ../views/energia.php");
exit;