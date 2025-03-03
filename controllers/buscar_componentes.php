<?php
require __DIR__ . '/../config/config.php';

$termo = $_GET['term'] ?? '';

$stmt = $pdo->prepare("SELECT id, nome_material FROM componentes WHERE nome_material LIKE ? LIMIT 10");
$stmt->execute(["%$termo%"]);
$componentes = $stmt->fetchAll(PDO::FETCH_ASSOC);

$resultado = [];

foreach ($componentes as $componente) {
    $resultado[] = [
        "id" => $componente['id'],
        "value" => $componente['nome_material'] // O campo "value" é necessário para o autocomplete do jQuery UI
    ];
}

echo json_encode($resultado);
?>