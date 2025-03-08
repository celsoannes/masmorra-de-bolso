<?php
session_start();
require __DIR__ . '/../config/config.php';
require __DIR__ . '/../includes/menu.php';

// Verifica se há um termo de busca
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Consulta SQL com filtro de busca
$sql = "SELECT p.*, c.nome AS categoria_nome, GROUP_CONCAT(t.nome SEPARATOR ', ') AS tags 
        FROM produtos p 
        LEFT JOIN categorias c ON p.categoria_id = c.id 
        LEFT JOIN produto_tags pt ON p.id = pt.produto_id 
        LEFT JOIN tags t ON pt.tag_id = t.id 
        WHERE p.nome LIKE :search_nome 
           OR c.nome LIKE :search_categoria 
           OR t.nome LIKE :search_tag 
        GROUP BY p.id";
$stmt = $pdo->prepare($sql);

// Passando os parâmetros corretamente
$stmt->execute([
    'search_nome' => "%$search%",
    'search_categoria' => "%$search%",
    'search_tag' => "%$search%" // Corrigi o nome do parâmetro aqui
]);
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
// var_dump($produtos); // Verifique os dados retornados
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Produtos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
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
                    <th>Tags</th> <!-- Coluna para as tags -->
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($produtos as $produto): ?>
                <tr>
                    <td><img src="<?= htmlspecialchars($produto['caminho_imagem']) ?>" class="img-thumbnail" width="80"></td>
                    <td><?= htmlspecialchars($produto['nome']) ?></td>
                    <td><?= htmlspecialchars($produto['categoria_nome']) ?></td>
                    <td><?= htmlspecialchars($produto['tags'] ?? 'Sem tags') ?></td> <!-- Exibe as tags -->
                    <td>
                        <a href="../controllers/editar_produto.php?id=<?= $produto['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#confirmarExclusaoModal" data-bs-id="<?= $produto['id'] ?>">
                            Excluir
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Modal de Confirmação de Exclusão -->
    <div class="modal fade" id="confirmarExclusaoModal" tabindex="-1" aria-labelledby="confirmarExclusaoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmarExclusaoModalLabel">Confirmar Exclusão</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    Tem certeza que deseja excluir este produto?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <a id="btnConfirmarExclusao" href="#" class="btn btn-danger">Excluir</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts do Bootstrap e JavaScript personalizado -->
    <script>
        // Configura o modal para passar o ID do produto a ser excluído
        const confirmarExclusaoModal = document.getElementById('confirmarExclusaoModal');
        confirmarExclusaoModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget; // Botão que acionou o modal
            const id = button.getAttribute('data-bs-id'); // Extrai o ID do produto
            const btnConfirmarExclusao = document.getElementById('btnConfirmarExclusao');

            // Atualiza o link de exclusão com o ID do produto
            btnConfirmarExclusao.href = `../controllers/excluir_produto.php?id=${id}`;
        });
    </script>
</body>
</html>