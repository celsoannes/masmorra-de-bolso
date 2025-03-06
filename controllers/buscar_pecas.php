<?php
session_start();
require __DIR__ . '/../config/config.php';

$term = $_GET['term'] ?? '';

$stmt = $pdo->prepare("SELECT id, nome, imagem FROM pecas WHERE nome LIKE :term");
$stmt->execute(['term' => '%' . $term . '%']);
$pecas = $stmt->fetchAll(PDO::FETCH_ASSOC);

$response = [];
foreach ($pecas as $peca) {
    $response[] = [
        'id' => $peca['id'],
        'value' => $peca['nome'],
        'imagem' => $peca['imagem'] // Adiciona o caminho da imagem
    ];
}

echo json_encode($response);
?>