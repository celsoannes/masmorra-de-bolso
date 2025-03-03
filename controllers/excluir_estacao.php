<?php
session_start();
require __DIR__ . '/../config/config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Deleta a estação de lavagem com base no ID
    $stmt = $pdo->prepare("DELETE FROM estacoes_lavagem WHERE ID = ?");
    $stmt->execute([$id]);

    // Redireciona para a lista após excluir
    header("Location: ../views/estacoes_lavagem.php");
    exit;
} else {
    echo "ID inválido!";
}
?>