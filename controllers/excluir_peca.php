<?php
session_start();
require __DIR__ . '/../config/config.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID inválido.");
}

$id = $_GET['id'];

// Verifica se a peça existe antes de excluir
$stmt = $pdo->prepare("SELECT * FROM pecas WHERE id = ?");
$stmt->execute([$id]);
$peca = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$peca) {
    die("Peça não encontrada.");
}

// Excluir a peça
$stmt = $pdo->prepare("DELETE FROM pecas WHERE id = ?");
if ($stmt->execute([$id])) {
    header("Location: ../views/pecas.php?msg=Peça+3D+excluída+com+sucesso");
    exit;
} else {
    echo "<script>alert('Erro ao excluir a peça 3D.'); window.location.href='../views/pecas.php';</script>";
}
?>