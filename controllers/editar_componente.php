<?php
require __DIR__ . '/../config/config.php';
require __DIR__ . '/../includes/menu.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID inválido.");
}

$id = $_GET['id'];

// Busca os dados do componente no banco
$stmt = $pdo->prepare("SELECT * FROM componentes WHERE id = ?");
$stmt->execute([$id]);
$componente = $stmt->fetch(PDO::FETCH_ASSOC);

// Se não encontrar o componente, exibe erro
if (!$componente) {
    die("Componente não encontrado.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome_material = trim($_POST['nome_material']);
    $tipo_material = trim($_POST['tipo_material']);
    $descricao = trim($_POST['descricao']);
    $unidade_medida = trim($_POST['unidade_medida']);
    $preco_unitario = $_POST['preco_unitario'];
    $fornecedor = trim($_POST['fornecedor']);
    $observacoes = trim($_POST['observacoes']);

    // Upload da imagem (se houver)
    require 'upload.php';

    // Atualiza o componente no banco
    $stmt = $pdo->prepare("UPDATE componentes SET nome_material = ?, tipo_material = ?, descricao = ?, unidade_medida = ?, preco_unitario = ?, fornecedor = ?, observacoes = ?, caminho_imagem = ? WHERE id = ?");
    if ($stmt->execute([$nome_material, $tipo_material, $descricao, $unidade_medida, $preco_unitario, $fornecedor, $observacoes, $caminho_imagem, $id])) {
        header("Location: ../views/componentes.php");
        exit;
    } else {
        echo "<script>alert('Erro ao editar componente!');</script>";
    }
}
?>

<div class="container mt-5 pt-5">
    <h2>Editar Componente</h2>
    <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Nome do Material:</label>
            <input type="text" name="nome_material" value="<?= htmlspecialchars($componente['nome_material']) ?>" required class="form-control">
        </div>

        <div class="mb-3">
            <label>Tipo do Material:</label>
            <input type="text" name="tipo_material" value="<?= htmlspecialchars($componente['tipo_material']) ?>" required class="form-control">
        </div>

        <div class="mb-3">
            <label>Descrição:</label>
            <textarea name="descricao" required class="form-control"><?= htmlspecialchars($componente['descricao']) ?></textarea>
        </div>

        <div class="mb-3">
            <label>Unidade de Medida:</label>
            <select name="unidade_medida" required class="form-control">
                <option value="unidade" <?= ($componente['unidade_medida'] == 'unidade') ? 'selected' : '' ?>>Unidade</option>
                <option value="m" <?= ($componente['unidade_medida'] == 'm') ? 'selected' : '' ?>>Metro</option>
                <option value="cm" <?= ($componente['unidade_medida'] == 'cm') ? 'selected' : '' ?>>Centímetro</option>
                <option value="mm" <?= ($componente['unidade_medida'] == 'mm') ? 'selected' : '' ?>>Milímetro</option>
                <option value="kg" <?= ($componente['unidade_medida'] == 'kg') ? 'selected' : '' ?>>Quilograma</option>
                <option value="g" <?= ($componente['unidade_medida'] == 'g') ? 'selected' : '' ?>>Grama</option>
                <option value="L" <?= ($componente['unidade_medida'] == 'L') ? 'selected' : '' ?>>Litro</option>
                <option value="mL" <?= ($componente['unidade_medida'] == 'mL') ? 'selected' : '' ?>>Mililitro</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Preço Unitário:</label>
            <input type="number" step="0.01" name="preco_unitario" value="<?= htmlspecialchars($componente['preco_unitario']) ?>" required class="form-control">
        </div>

        <div class="mb-3">
            <label>Fornecedor:</label>
            <input type="text" name="fornecedor" value="<?= htmlspecialchars($componente['fornecedor']) ?>" required class="form-control">
        </div>

        <div class="mb-3">
            <label>Observações:</label>
            <textarea name="observacoes" class="form-control"><?= htmlspecialchars($componente['observacoes']) ?></textarea>
        </div>

        <div class="mb-3">
            <label>Imagem do Produto (PNG 512x512):</label>

            <!-- Pré-visualização da imagem -->
            <?php if (!empty($componente['caminho_imagem'])): ?>
                <div class="mb-3">
                    <img src="<?= htmlspecialchars($componente['caminho_imagem']) ?>" alt="Imagem do Produto" class="img-fluid" style="max-width: 200px;">
                </div>
            <?php endif; ?>
        </div>

        <div class="mb-3">
            <input type="file" name="imagem" class="form-control">
        </div>


        <button type="submit" class="btn btn-primary mt-3">Salvar Alterações</button>
        <a href="../views/componentes.php" class="btn btn-secondary mt-3">Voltar</a>
    </form>
</div>