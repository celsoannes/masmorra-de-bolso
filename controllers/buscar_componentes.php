<?php
session_start();
require __DIR__ . '/../config/config.php';

$term = $_GET['term'] ?? '';

$stmt = $pdo->prepare("SELECT id, nome_material AS nome, caminho_imagem FROM componentes WHERE nome_material LIKE :term");
$stmt->execute(['term' => '%' . $term . '%']);
$componentes = $stmt->fetchAll(PDO::FETCH_ASSOC);

$response = [];
foreach ($componentes as $componente) {
    $response[] = [
        'id' => $componente['id'],
        'value' => $componente['nome'],
        'imagem' => $componente['caminho_imagem'] // Adiciona o caminho da imagem
    ];
}

echo json_encode($response);
?>