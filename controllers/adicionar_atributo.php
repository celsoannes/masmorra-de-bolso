<?php
session_start();
require __DIR__ . '/../config/config.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../views/login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $categoria_id = $_POST["categoria_id"];
    $nome_atributo = $_POST["nome_atributo"];
    $tipo_atributo = $_POST["tipo_atributo"];
    $opcoes = $_POST["opcoes"];

    $stmt = $pdo->prepare("INSERT INTO categoria_atributos (categoria_id, nome_atributo, tipo_atributo, opcoes) VALUES (?, ?, ?, ?)");
    $stmt->execute([$categoria_id, $nome_atributo, $tipo_atributo, $opcoes]);

    // Redireciona para a página de atributos após salvar
    header("Location: ../views/atributos.php");
    exit; // Certifique-se de que o script para aqui após o redirecionamento
}

// Busca as categorias para o dropdown
$stmt = $pdo->query("SELECT * FROM categorias ORDER BY nome ASC");
$categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Inclui o menu apenas após garantir que não há redirecionamento
require __DIR__ . '/../includes/menu.php';
?>

<div class="container mt-4 pt-5">
    <h2>Adicionar Atributo</h2>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Categoria</label>
            <select name="categoria_id" class="form-control" required>
                <?php foreach ($categorias as $categoria): ?>
                    <option value="<?= $categoria['id'] ?>"><?= htmlspecialchars($categoria['nome']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Nome do Atributo</label>
            <input type="text" name="nome_atributo" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Tipo do Atributo</label>
            <select name="tipo_atributo" class="form-control" required>
                <option value="text">Texto</option>
                <option value="number">Número</option>
                <option value="select">Seleção</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Opções (apenas para tipo "Seleção")</label>
            <textarea name="opcoes" class="form-control" rows="3"></textarea>
        </div>
        <button type="submit" class="btn btn-success mt-3">Salvar</button>
        <a href="../views/atributos.php" class="btn btn-secondary mt-3">Voltar</a>
    </form>
</div>