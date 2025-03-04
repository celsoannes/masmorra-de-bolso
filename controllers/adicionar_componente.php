<?php
require __DIR__ . '/../config/config.php';
require __DIR__ . '/../includes/menu.php';

// Verifica a conexão com o banco de dados
if (!$pdo) {
    die("Erro na conexão com o banco de dados.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome_material = trim($_POST['nome_material']);
    $tipo_material = trim($_POST['tipo_material']);
    $descricao = trim($_POST['descricao']);
    $unidade_medida = trim($_POST['unidade_medida']);
    $preco_unitario = $_POST['preco_unitario'];
    $fornecedor = trim($_POST['fornecedor']);
    $observacoes = trim($_POST['observacoes']);

    // Upload da imagem
    require 'upload.php';

    try {
        $stmt = $pdo->prepare("INSERT INTO componentes 
            (nome_material, tipo_material, descricao, unidade_medida, preco_unitario, fornecedor, observacoes, caminho_imagem) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    
        $sucesso = $stmt->execute([
            $nome_material, 
            $tipo_material, 
            $descricao, 
            $unidade_medida, 
            $preco_unitario, 
            $fornecedor, 
            $observacoes, 
            $caminho_imagem
        ]);

        // **REDIRECIONAMENTO APÓS O SUCESSO**
        if ($sucesso) {
            header("Location: ../views/componentes.php");
            exit; // **IMPORTANTE: Impede que o script continue executando**
        }

    } catch (PDOException $e) {
        echo "<script>alert('Erro no banco de dados: " . $e->getMessage() . "');</script>";
    }
}
?>

<div class="container mt-5 pt-5">
    <h2>Adicionar Componente</h2>
    <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Nome do Material:</label>
            <input type="text" name="nome_material" required class="form-control">
        </div>

        <div class="mb-3">
            <label>Tipo do Material:</label>
            <input type="text" name="tipo_material" required class="form-control">
        </div>

        <div class="mb-3">
            <label>Descrição:</label>
            <textarea name="descricao" required class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label>Unidade de Medida:</label>
            <select name="unidade_medida" required class="form-control">
                <option value="pc">Peça</option>
                <option value="m">Metro</option>
                <option value="cm">Centímetro</option>
                <option value="mm">Milímetro</option>
                <option value="kg">Quilograma</option>
                <option value="g">Grama</option>
                <option value="L">Litro</option>
                <option value="mL">Mililitro </option>
            </select>
        </div>

        <div class="mb-3">
            <label>Preço Unitário:</label>
            <input type="number" step="0.01" name="preco_unitario" required class="form-control">
        </div>

        <div class="mb-3">
            <label>Fornecedor:</label>
            <input type="text" name="fornecedor" required class="form-control">
        </div>

        <div class="mb-3">
            <label>Observações:</label>
            <textarea name="observacoes" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label>Imagem do Produto (PNG 512x512):</label>
            <input type="file" name="imagem" required class="form-control">
        </div>

        <button type="submit" class="btn btn-primary mt-3">Adicionar</button>
        <a href="../views/componentes.php" class="btn btn-secondary mt-3">Voltar</a>
    </form>
</div>