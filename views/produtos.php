<?php
session_start();
require __DIR__ . '/../config/config.php';
require __DIR__ . '/../includes/menu.php';

// Verifica se há um termo de busca
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Consulta SQL com filtro de busca
$sql = "SELECT p.*, c.nome AS categoria_nome 
        FROM produtos p 
        LEFT JOIN categorias c ON p.categoria_id = c.id 
        LEFT JOIN produto_atributos pa ON p.id = pa.produto_id 
        WHERE p.nome LIKE :search_nome 
           OR c.nome LIKE :search_categoria 
           OR pa.valor LIKE :search_atributo 
        GROUP BY p.id"; // Agrupa para evitar duplicatas
$stmt = $pdo->prepare($sql);

// Passando os parâmetros corretamente
$stmt->execute([
    'search_nome' => "%$search%",
    'search_categoria' => "%$search%",
    'search_atributo' => "%$search%"
]);

$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-4 pt-5">
    <h2>Lista de Produtos</h2>

    <!-- Formulário de busca -->
    <form method="GET" action="" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Buscar por nome, categoria ou atributo" value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
            <button type="submit" class="btn btn-outline-secondary">Buscar</button>
            <!-- Botão para limpar a busca -->
            <?php if (!empty($search)): ?>
                <a href="produtos.php" class="btn btn-outline-danger">Limpar</a>
            <?php endif; ?>
        </div>
    </form>

    <a href="../controllers/adicionar_produto.php" class="btn btn-success mb-3">Adicionar Produto</a>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Imagem</th>
                <th>Nome</th>
                <th>Categoria</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($produtos as $produto): ?>
            <tr>
                <td><img src="<?= htmlspecialchars($produto['caminho_imagem']) ?>" class="img-thumbnail" width="80"></td>
                <td><?= htmlspecialchars($produto['nome']) ?></td>
                <td><?= htmlspecialchars($produto['categoria_nome']) ?></td>
                <td>
                    <a href="../controllers/editar_produto.php?id=<?= $produto['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                    <a href="../controllers/excluir_produto.php?id=<?= $produto['id'] ?>" class="btn btn-danger btn-sm">Excluir</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>