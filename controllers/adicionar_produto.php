<?php
session_start();
require __DIR__ . '/../config/config.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../views/login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Dados do formulário
    $nome = trim($_POST['nome']);
    $video = trim($_POST['video']);
    $baixar = trim($_POST['baixar']);
    $observacoes = trim($_POST['observacoes']);
    $lucro = isset($_POST['lucro']) ? floatval($_POST['lucro']) : 200; // Define 200% como padrão
    $categoria_id = $_POST['categoria_id'];

    // Upload de imagem (se houver)
    require 'upload.php';

    // Inserir produto no banco de dados
    $stmt = $pdo->prepare("INSERT INTO produtos (nome, caminho_imagem, video, baixar, observacoes, lucro, categoria_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
    if ($stmt->execute([$nome, $caminho_imagem, $video, $baixar, $observacoes, $lucro, $categoria_id])) {
        $produto_id = $pdo->lastInsertId();

        // Adicionar tags ao produto
        if (isset($_POST['tags']) && is_array($_POST['tags'])) {
            foreach ($_POST['tags'] as $tag_nome) {
                // Verifica se a tag já existe
                $stmt = $pdo->prepare("SELECT id FROM tags WHERE nome = ?");
                $stmt->execute([$tag_nome]);
                $tag = $stmt->fetch(PDO::FETCH_ASSOC);
        
                // Se a tag não existir, cria uma nova
                if (!$tag) {
                    $stmt = $pdo->prepare("INSERT INTO tags (nome) VALUES (?)");
                    $stmt->execute([$tag_nome]);
                    $tag_id = $pdo->lastInsertId();
                } else {
                    $tag_id = $tag['id'];
                }
        
                // Associa a tag ao produto
                $pdo->prepare("INSERT INTO produto_tags (produto_id, tag_id) VALUES (?, ?)")
                    ->execute([$produto_id, $tag_id]);
            }
        }

        // Adicionar peças ao produto
        if (isset($_POST['pecas']) && is_array($_POST['pecas'])) {
            foreach ($_POST['pecas'] as $peca_id => $quantidade) {
                if ($quantidade > 0) {
                    $pdo->prepare("INSERT INTO produtos_pecas (produto_id, peca_id, quantidade) VALUES (?, ?, ?)")
                        ->execute([$produto_id, $peca_id, $quantidade]);
                }
            }
        }

        // Adicionar componentes ao produto
        if (isset($_POST['componentes']) && is_array($_POST['componentes'])) {
            foreach ($_POST['componentes'] as $componente_id => $quantidade) {
                if ($quantidade > 0) {
                    $pdo->prepare("INSERT INTO produtos_componentes (produto_id, componente_id, quantidade) VALUES (?, ?, ?)")
                        ->execute([$produto_id, $componente_id, $quantidade]);
                }
            }
        }

        // Adicionar atributos ao produto
        if (isset($_POST['atributos'])) {
            foreach ($_POST['atributos'] as $atributo_id => $valor) {
                if (!empty($valor)) {
                    $pdo->prepare("INSERT INTO produto_atributos (produto_id, atributo_id, valor) VALUES (?, ?, ?)")
                        ->execute([$produto_id, $atributo_id, $valor]);
                }
            }
        }

        // Redirecionamento
        header("Location: ../views/produtos.php");
        exit;
    } else {
        echo "<script>alert('Erro ao adicionar produto.');</script>";
    }
}

// Buscar categorias para o dropdown
$stmt = $pdo->query("SELECT * FROM categorias ORDER BY nome ASC");
$categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Inclui o menu apenas após garantir que não há redirecionamento
require __DIR__ . '/../includes/menu.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Produto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5 pt-5">
        <h2>Adicionar Produto</h2>
        <form method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label>Nome do Produto:</label>
                <input type="text" name="nome" required class="form-control">
            </div>

            <div class="mb-3">
                <label>Categoria:</label>
                <select name="categoria_id" id="categoria" class="form-control" required>
                    <option value="">Selecione uma categoria</option>
                    <?php foreach ($categorias as $categoria): ?>
                        <option value="<?= $categoria['id'] ?>"><?= htmlspecialchars($categoria['nome']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Campos de atributos dinâmicos -->
            <div id="atributos-container"></div>

            <!-- Adicionar Tags -->
            <div class="mb-3">
                <label>Tags:</label>
                <input type="text" id="buscarTag" class="form-control" placeholder="Digite uma tag">
                <div id="tagsSelecionadas" class="mt-2"></div>
            </div>

            <div class="mb-3">
                <label>Vídeo (YouTube):</label>
                <input type="url" name="video" class="form-control">
            </div>

            <div class="mb-3">
                <label>Link para Download:</label>
                <input type="url" name="baixar" class="form-control">
            </div>

            <div class="mb-3">
                <label>Observações:</label>
                <textarea name="observacoes" class="form-control"></textarea>
            </div>

            <!-- Adicionar Peça -->
            <div class="mb-3">
                <label>Adicionar Peça:</label>
                <input type="text" id="buscarPeca" class="form-control" placeholder="Digite o nome da peça">
                <table class="table table-striped mt-2">
                    <thead>
                        <tr>
                            <th>Imagem</th>
                            <th>Nome da Peça</th>
                            <th>Quantidade</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody id="tabelaPecas"></tbody>
                </table>
            </div>

            <!-- Adicionar Componente -->
            <div class="mb-3">
                <label>Adicionar Componente:</label>
                <input type="text" id="buscarComponente" class="form-control" placeholder="Digite o nome do componente">
                <table class="table table-striped mt-2">
                    <thead>
                        <tr>
                            <th>Imagem</th>
                            <th>Nome do Componente</th>
                            <th>Quantidade</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody id="tabelaComponentes"></tbody>
                </table>
            </div>

            <div class="mb-3">
                <label>Imagem do Produto:</label>
                <input type="file" name="imagem" class="form-control">
            </div>

            <div class="mb-3">
                <label>Lucro (%):</label>
                <input type="number" name="lucro" class="form-control" value="150" min="0" step="0.1">
            </div>

            <button type="submit" class="btn btn-primary mt-3">Adicionar</button>
            <a href="../views/produtos.php" class="btn btn-secondary mt-3">Voltar</a>
        </form>
    </div>

    <!-- jQuery para carregar atributos dinamicamente -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        // Carregar atributos ao selecionar uma categoria
        $('#categoria').change(function() {
            let categoria_id = $(this).val();
            if (categoria_id) {
                $.ajax({
                    url: '../controllers/buscar_atributos.php',
                    type: 'GET',
                    data: { categoria_id: categoria_id },
                    success: function(response) {
                        $('#atributos-container').html(response);
                    }
                });
            } else {
                $('#atributos-container').html('');
            }
        });
    });
    </script>

    <!-- jQuery e jQuery UI para Autocomplete -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script>
    $(document).ready(function() {
        // Autocomplete para Peças
        $("#buscarPeca").autocomplete({
            source: "../controllers/buscar_pecas.php",
            minLength: 2,
            select: function(event, ui) {
                let pecaId = ui.item.id;
                let pecaNome = ui.item.value;
                let pecaImagem = ui.item.imagem;

                if ($("#peca_" + pecaId).length === 0) {
                    $("#tabelaPecas").append(`
                        <tr id="peca_${pecaId}">
                            <td>
                                ${pecaImagem ? `<img src="${pecaImagem}" alt="Imagem da peça" class="img-thumbnail" style="max-width: 50px;">` : 'Sem imagem'}
                            </td>
                            <td>${pecaNome}</td>
                            <td><input type="number" name="pecas[${pecaId}]" value="1" min="1" class="form-control"></td>
                            <td><button type="button" class="btn btn-danger removerPeca" data-id="${pecaId}">Remover</button></td>
                        </tr>
                    `);
                }
                $("#buscarPeca").val('');
                return false;
            }
        });

        // Autocomplete para Componentes
        $("#buscarComponente").autocomplete({
            source: "../controllers/buscar_componentes.php",
            minLength: 2,
            select: function(event, ui) {
                let componenteId = ui.item.id;
                let componenteNome = ui.item.value;
                let componenteImagem = ui.item.imagem;

                if ($("#componente_" + componenteId).length === 0) {
                    $("#tabelaComponentes").append(`
                        <tr id="componente_${componenteId}">
                            <td>
                                ${componenteImagem ? `<img src="${componenteImagem}" alt="Imagem do componente" class="img-thumbnail" style="max-width: 50px;">` : 'Sem imagem'}
                            </td>
                            <td>${componenteNome}</td>
                            <td><input type="number" name="componentes[${componenteId}]" value="1" min="1" class="form-control"></td>
                            <td><button type="button" class="btn btn-danger removerComponente" data-id="${componenteId}">Remover</button></td>
                        </tr>
                    `);
                }
                $("#buscarComponente").val('');
                return false;
            }
        });

        // Remover peça da tabela
        $(document).on("click", ".removerPeca", function() {
            let pecaId = $(this).data("id");
            $("#peca_" + pecaId).remove();
        });

        // Remover componente da tabela
        $(document).on("click", ".removerComponente", function() {
            let componenteId = $(this).data("id");
            $("#componente_" + componenteId).remove();
        });

        // Autocomplete para Tags
        $("#buscarTag").autocomplete({
            source: "../controllers/buscar_tags.php",
            minLength: 2,
            select: function(event, ui) {
                let tagNome = ui.item.value;

                // Verifica se a tag já foi adicionada
                if ($("#tag_" + tagNome).length === 0) {
                    $("#tagsSelecionadas").append(`
                        <span id="tag_${tagNome}" class="badge bg-primary me-2">
                            ${tagNome}
                            <input type="hidden" name="tags[]" value="${tagNome}">
                            <button type="button" class="btn-close btn-close-white ms-2 removerTag" data-nome="${tagNome}"></button>
                        </span>
                    `);
                }
                $("#buscarTag").val('');
                return false;
            }
        });

        // Adicionar tag ao pressionar Enter
        $("#buscarTag").on("keydown", function(event) {
            if (event.key === "Enter") {
                event.preventDefault(); // Impede o envio do formulário

                let tagNome = $(this).val().trim(); // Pega o valor do campo

                if (tagNome) {
                    // Verifica se a tag já foi adicionada
                    if ($("#tag_" + tagNome).length === 0) {
                        $("#tagsSelecionadas").append(`
                            <span id="tag_${tagNome}" class="badge bg-primary me-2">
                                ${tagNome}
                                <input type="hidden" name="tags[]" value="${tagNome}">
                                <button type="button" class="btn-close btn-close-white ms-2 removerTag" data-nome="${tagNome}"></button>
                            </span>
                        `);
                    }
                    $(this).val(''); // Limpa o campo
                }
            }
        });

        // Remover tag
        $(document).on("click", ".removerTag", function() {
            let tagNome = $(this).data("nome");
            $("#tag_" + tagNome).remove();
        });
    });
    </script>
</body>
</html>