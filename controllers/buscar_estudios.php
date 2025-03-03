<?php
require __DIR__ . '/../config/config.php';  // Inclua seu arquivo de configuração do banco de dados

if (isset($_GET['termo'])) {
    $termo = "%" . $_GET['termo'] . "%";
    // Consulta para buscar os estúdios com o termo fornecido
    $stmt = $pdo->prepare("SELECT id, nome FROM estudios WHERE nome LIKE ? LIMIT 10");
    $stmt->execute([$termo]);

    // Busca os resultados e os prepara para enviar no formato JSON
    $estudios = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $result = [];
    foreach ($estudios as $estudio) {
        $result[] = ['label' => $estudio['nome'], 'value' => $estudio['id']];
    }

    // Envia o resultado no formato JSON
    echo json_encode($result);
}
?>