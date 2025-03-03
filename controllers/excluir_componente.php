<?php
require __DIR__ . '/../config/config.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID inválido.");
}

$id = $_GET['id'];

// Buscar a imagem para deletar
$stmt = $pdo->prepare("SELECT caminho_imagem FROM componentes WHERE id = ?");
$stmt->execute([$id]);
$componente = $stmt->fetch(PDO::FETCH_ASSOC);

if ($componente && file_exists($componente['caminho_imagem'])) {
    unlink($componente['caminho_imagem']); // Deleta a imagem do servidor
}

$pdo->prepare("DELETE FROM componentes WHERE id = ?")->execute([$id]);
header("Location: ../views/componentes.php");
exit;
?>