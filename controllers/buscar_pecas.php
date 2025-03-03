<?php
require __DIR__ . '/../config/config.php';

$termo = $_GET['term'] ?? '';

$stmt = $pdo->prepare("SELECT id, nome FROM pecas WHERE nome LIKE ? LIMIT 10");
$stmt->execute(["%$termo%"]);
$pecas = $stmt->fetchAll(PDO::FETCH_ASSOC);

$resultado = [];

foreach ($pecas as $peca) {
    $resultado[] = [
        "id" => $peca['id'],
        "value" => $peca['nome'] // O campo "value" é necessário para o autocomplete do jQuery UI
    ];
}

echo json_encode($resultado);
?>