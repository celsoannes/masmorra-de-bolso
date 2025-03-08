<?php
require __DIR__ . '/../config/config.php';

$term = isset($_GET['term']) ? $_GET['term'] : '';

$stmt = $pdo->prepare("SELECT nome FROM tags WHERE nome LIKE :term");
$stmt->execute(['term' => "%$term%"]);
$tags = $stmt->fetchAll(PDO::FETCH_ASSOC);

$response = [];
foreach ($tags as $tag) {
    $response[] = [
        'value' => $tag['nome']
    ];
}

echo json_encode($response);