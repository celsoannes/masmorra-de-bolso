<?php
require __DIR__ . '/../config/config.php';

$pesquisa = isset($_GET['pesquisa']) ? $_GET['pesquisa'] : '';

if ($pesquisa) {
    // Buscar produtos com base na pesquisa
    $stmt = $pdo->prepare("SELECT nome FROM produtos WHERE nome LIKE :pesquisa LIMIT 5");
    $stmt->bindValue(':pesquisa', '%' . $pesquisa . '%');
    $stmt->execute();
    $produtos = $stmt->fetchAll();

    // Exibir as sugestões
    if ($produtos) {
        foreach ($produtos as $produto) {
            echo '<div>' . htmlspecialchars($produto['nome']) . '</div>';
        }
    } else {
        echo '';  // Caso não haja resultados
    }
}
?>