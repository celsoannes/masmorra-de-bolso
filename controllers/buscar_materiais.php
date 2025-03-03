<?php
require __DIR__ . '/../config/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['tipo'])) {
    $tipo = $_POST['tipo'];

    if ($tipo == "Filamento") {
        $query = "SELECT TIPO FROM filamentos ORDER BY TIPO";
    } elseif ($tipo == "Resina") {
        $query = "SELECT TIPO FROM resinas ORDER BY TIPO";
    } else {
        echo '<option value="">Nenhum material disponível</option>';
        exit;
    }

    $stmt = $pdo->query($query);
    $materiais = $stmt->fetchAll(PDO::FETCH_COLUMN);

    foreach ($materiais as $material) {
        echo "<option value='" . htmlspecialchars($material) . "'>" . htmlspecialchars($material) . "</option>";
    }
}
?>