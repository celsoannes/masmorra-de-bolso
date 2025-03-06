<?php
session_start();
require __DIR__ . '/../config/config.php';

if (!isset($_GET['categoria_id'])) {
    die("Categoria inválida.");
}

$categoria_id = $_GET['categoria_id'];

// Buscar atributos da categoria
$stmt = $pdo->prepare("SELECT * FROM categoria_atributos WHERE categoria_id = ?");
$stmt->execute([$categoria_id]);
$atributos = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($atributos as $atributo) {
    echo '<div class="mb-3">';
    echo '<label>' . htmlspecialchars($atributo['nome_atributo']) . ':</label>';
    if ($atributo['tipo_atributo'] === 'select') {
        echo '<select name="atributos[' . $atributo['id'] . ']" class="form-control">';
        $opcoes = explode(',', $atributo['opcoes']);
        foreach ($opcoes as $opcao) {
            echo '<option value="' . htmlspecialchars(trim($opcao)) . '">' . htmlspecialchars(trim($opcao)) . '</option>';
        }
        echo '</select>';
    } else {
        echo '<input type="' . $atributo['tipo_atributo'] . '" name="atributos[' . $atributo['id'] . ']" class="form-control">';
    }
    echo '</div>';
}
?>