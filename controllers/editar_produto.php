<?php
session_start();
require __DIR__ . '/../config/config.php';

$id = $_GET['id'] ?? null;
if (!$id || !is_numeric($id)) {
    die("ID inválido.");
}

// Buscar produto
$stmt = $pdo->prepare("SELECT * FROM produtos WHERE id = ?");
$stmt->execute([$id]);
$produto = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$produto) {
    die("Produto não encontrado.");
}

// Buscar tags associadas ao produto
$stmt = $pdo->prepare("SELECT t.id, t.nome 
                       FROM produto_tags pt 
                       JOIN tags t ON pt.tag_id = t.id 
                       WHERE pt.produto_id = ?");
$stmt->execute([$id]);
$tags = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Buscar categorias para o dropdown
$stmt = $pdo->query("SELECT * FROM categorias ORDER BY nome ASC");
$categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Buscar atributos do produto
$stmt = $pdo->prepare("SELECT * FROM produto_atributos WHERE produto_id = ?");
$stmt->execute([$id]);
$atributos_produto = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Buscar peças associadas ao produto
$stmt = $pdo->prepare("SELECT p.id, p.nome, pp.quantidade, p.imagem 
                       FROM produtos_pecas pp 
                       JOIN pecas p ON pp.peca_id = p.id 
                       WHERE pp.produto_id = ?");
$stmt->execute([$id]);
$pecas = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Buscar componentes associados ao produto
$stmt = $pdo->prepare("SELECT c.id, c.nome_material AS nome, pc.quantidade, c.caminho_imagem 
                       FROM produtos_componentes pc 
                       JOIN componentes c ON pc.componente_id = c.id 
                       WHERE pc.produto_id = ?");
$stmt->execute([$id]);
$componentes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Buscar imagens adicionais associadas ao produto
$stmt = $pdo->prepare("SELECT * FROM produto_imagens WHERE produto_id = ?");
$stmt->execute([$id]);
$imagens_adicionais = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Coletar dados do formulário
    $nome = trim($_POST['nome']);
    $video = trim($_POST['video']);
    $baixar = trim($_POST['baixar']);
    $observacoes = trim($_POST['observacoes']);
    $lucro = isset($_POST['lucro']) ? floatval($_POST['lucro']) : 200; // Define 200% como padrão
    $categoria_id = $_POST['categoria_id'];

    // Upload de imagem (se houver)
    $caminho_imagem = $produto['caminho_imagem']; // Mantém a imagem atual por padrão
    if (!empty($_FILES['imagem']['name'])) {
        require __DIR__ . '/upload.php'; // Inclui o script de upload
        // $caminho_imagem será atualizado pelo script de upload
    }

    // Atualizar tags associadas ao produto
    $pdo->prepare("DELETE FROM produto_tags WHERE produto_id = ?")->execute([$id]);
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
                ->execute([$id, $tag_id]);
        }
    }

    // Atualizar produto no banco de dados
    $stmt = $pdo->prepare("UPDATE produtos 
                           SET nome = ?, caminho_imagem = ?, video = ?, baixar = ?, observacoes = ?, lucro = ?, categoria_id = ? 
                           WHERE id = ?");
    $stmt->execute([$nome, $caminho_imagem, $video, $baixar, $observacoes, $lucro, $categoria_id, $id]);

    // Atualizar peças associadas ao produto
    $pdo->prepare("DELETE FROM produtos_pecas WHERE produto_id = ?")->execute([$id]);
    if (isset($_POST['pecas']) && is_array($_POST['pecas'])) {
        foreach ($_POST['pecas'] as $peca_id => $quantidade) {
            if ($quantidade > 0) {
                $pdo->prepare("INSERT INTO produtos_pecas (produto_id, peca_id, quantidade) VALUES (?, ?, ?)")
                    ->execute([$id, $peca_id, $quantidade]);
            }
        }
    }

    // Atualizar componentes associados ao produto
    $pdo->prepare("DELETE FROM produtos_componentes WHERE produto_id = ?")->execute([$id]);
    if (isset($_POST['componentes']) && is_array($_POST['componentes'])) {
        foreach ($_POST['componentes'] as $componente_id => $quantidade) {
            if ($quantidade > 0) {
                $pdo->prepare("INSERT INTO produtos_componentes (produto_id, componente_id, quantidade) VALUES (?, ?, ?)")
                    ->execute([$id, $componente_id, $quantidade]);
            }
        }
    }

    // Atualizar atributos do produto
    $pdo->prepare("DELETE FROM produto_atributos WHERE produto_id = ?")->execute([$id]);
    if (isset($_POST['atributos'])) {
        foreach ($_POST['atributos'] as $atributo_id => $valor) {
            if (!empty($valor)) {
                $pdo->prepare("INSERT INTO produto_atributos (produto_id, atributo_id, valor) VALUES (?, ?, ?)")
                    ->execute([$id, $atributo_id, $valor]);
            }
        }
    }

    // Atualizar imagens adicionais associadas ao produto
    if (!empty($_FILES['imagens_adicionais']['name'][0])) {
        // Remova esta linha
    }

    // Atualizar imagens adicionais
    if (!empty($_FILES['imagens_adicionais']['name'][0])) {
        foreach ($_FILES['imagens_adicionais']['tmp_name'] as $key => $tmp_name) {
            $file_name = $_FILES['imagens_adicionais']['name'][$key];
            $file_tmp = $_FILES['imagens_adicionais']['tmp_name'][$key];
            $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
            $file_new_name = uniqid() . '.' . $file_ext;
            $file_path = __DIR__ . '/../uploads/' . $file_new_name;

            if (move_uploaded_file($file_tmp, $file_path)) {
                // Inserir nova imagem no banco de dados
                $stmt = $pdo->prepare("INSERT INTO produto_imagens (produto_id, caminho_imagem) VALUES (?, ?)");
                $stmt->execute([$id, $file_new_name]);
            }
        }
    }

    // Excluir imagens adicionais
    if (isset($_POST['imagens_excluir']) && is_array($_POST['imagens_excluir'])) {
        foreach ($_POST['imagens_excluir'] as $imagem_id) {
            // Buscar caminho da imagem para excluir o arquivo
            $stmt = $pdo->prepare("SELECT caminho_imagem FROM produto_imagens WHERE id = ?");
            $stmt->execute([$imagem_id]);
            $imagem = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($imagem) {
                // Excluir arquivo de imagem
                $file_path = __DIR__ . '/../uploads/' . $imagem['caminho_imagem'];
                if (file_exists($file_path)) {
                    unlink($file_path);
                }

                // Excluir registro do banco de dados
                $stmt = $pdo->prepare("DELETE FROM produto_imagens WHERE id = ?");
                $stmt->execute([$imagem_id]);
            }
        }
    }

    // Redirecionar para a lista de produtos
    header("Location: ../views/produtos.php");
    exit;
}

// Inclui o menu apenas após garantir que não há redirecionamento
require __DIR__ . '/../includes/menu.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Produto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet"> <!-- Inclui o CSS do jQuery UI -->
    <link href="/css/styles.css" rel="stylesheet"> <!-- Inclui o arquivo CSS dedicado -->
</head>
<body>
    <div class="container mt-5 pt-5">
        <h2>Editar Produto</h2>
        <form method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label>Nome do Produto:</label>
                <input type="text" name="nome" value="<?= htmlspecialchars($produto['nome']) ?>" required class="form-control">
            </div>

            <div class="mb-3">
                <label>Categoria:</label>
                <select name="categoria_id" id="categoria" class="form-control" required>
                    <option value="">Selecione uma categoria</option>
                    <?php foreach ($categorias as $categoria): ?>
                        <option value="<?= $categoria['id'] ?>" <?= $categoria['id'] == $produto['categoria_id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($categoria['nome']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Campos de atributos dinâmicos -->
            <div id="atributos-container">
                <?php
                if ($produto['categoria_id']) {
                    // Buscar atributos da categoria selecionada
                    $stmt = $pdo->prepare("SELECT * FROM categoria_atributos WHERE categoria_id = ?");
                    $stmt->execute([$produto['categoria_id']]);
                    $atributos = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($atributos as $atributo) {
                        $valor = '';
                        foreach ($atributos_produto as $atributo_produto) {
                            if ($atributo_produto['atributo_id'] == $atributo['id']) {
                                $valor = $atributo_produto['valor'];
                                break;
                            }
                        }

                        echo '<div class="mb-3">';
                        echo '<label>' . htmlspecialchars($atributo['nome_atributo']) . ':</label>';
                        if ($atributo['tipo_atributo'] === 'select') {
                            echo '<select name="atributos[' . $atributo['id'] . ']" class="form-control">';
                            $opcoes = explode(',', $atributo['opcoes']);
                            foreach ($opcoes as $opcao) {
                                $opcao = trim($opcao);
                                echo '<option value="' . htmlspecialchars($opcao) . '" ' . ($valor == $opcao ? 'selected' : '') . '>' . htmlspecialchars($opcao) . '</option>';
                            }
                            echo '</select>';
                        } else {
                            echo '<input type="' . $atributo['tipo_atributo'] . '" name="atributos[' . $atributo['id'] . ']" value="' . htmlspecialchars($valor) . '" class="form-control">';
                        }
                        echo '</div>';
                    }
                }
                ?>
            </div>

            <!-- Adicionar Tags -->
            <div class="mb-3">
                <label>Tags:</label>
                <input type="text" id="buscarTag" class="form-control" placeholder="Digite uma tag">
                <div id="tagsSelecionadas" class="mt-2">
                    <?php foreach ($tags as $tag): ?>
                        <span id="tag_<?= htmlspecialchars($tag['nome']) ?>" class="badge bg-primary me-2">
                            <?= htmlspecialchars($tag['nome']) ?>
                            <input type="hidden" name="tags[]" value="<?= htmlspecialchars($tag['nome']) ?>">
                            <button type="button" class="btn-close btn-close-white ms-2 removerTag" data-nome="<?= htmlspecialchars($tag['nome']) ?>"></button>
                        </span>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="mb-3">
                <label>Vídeo (YouTube):</label>
                <input type="url" name="video" value="<?= htmlspecialchars($produto['video']) ?>" class="form-control">
            </div>

            <div class="mb-3">
                <label>Link para Download:</label>
                <input type="url" name="baixar" value="<?= htmlspecialchars($produto['baixar']) ?>" class="form-control">
            </div>

            <div class="mb-3">
                <label>Observações:</label>
                <textarea name="observacoes" class="form-control"><?= htmlspecialchars($produto['observacoes']) ?></textarea>
            </div>

            <!-- Adicionar Peça -->
            <div class="mb-3">
                <label>Adicionar Peça:</label>
                <input type="text" id="buscarPeca" class="form-control" placeholder="Digite o nome da peça">
                <table class="table table-striped mt-2">
                    <thead>
                        <tr>
                            <th>Imagem</th> <!-- Nova coluna para a imagem -->
                            <th>Nome da Peça</th>
                            <th>Quantidade</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody id="tabelaPecas">
                        <?php foreach ($pecas as $peca): ?>
                            <tr id="peca_<?= $peca['id'] ?>">
                                <td>
                                    <?php if (!empty($peca['imagem'])): ?>
                                        <img src="<?= htmlspecialchars($peca['imagem']) ?>" alt="Imagem da peça" class="img-thumbnail" style="max-width: 50px;">
                                    <?php else: ?>
                                        <span>Sem imagem</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($peca['nome']) ?></td>
                                <td><input type="number" name="pecas[<?= $peca['id'] ?>]" value="<?= $peca['quantidade'] ?>" min="1" class="form-control"></td>
                                <td><button type="button" class="btn btn-danger removerPeca" data-id="<?= $peca['id'] ?>">Remover</button></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Adicionar Componente -->
            <div class="mb-3">
                <label>Adicionar Componente:</label>
                <input type="text" id="buscarComponente" class="form-control" placeholder="Digite o nome do componente">
                <table class="table table-striped mt-2">
                    <thead>
                        <tr>
                            <th>Imagem</th> <!-- Nova coluna para a imagem -->
                            <th>Nome do Componente</th>
                            <th>Quantidade</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody id="tabelaComponentes">
                        <?php foreach ($componentes as $componente): ?>
                            <tr id="componente_<?= $componente['id'] ?>">
                                <td>
                                    <?php if (!empty($componente['caminho_imagem'])): ?>
                                        <img src="<?= htmlspecialchars($componente['caminho_imagem']) ?>" alt="Imagem do componente" class="img-thumbnail" style="max-width: 50px;">
                                    <?php else: ?>
                                        <span>Sem imagem</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($componente['nome']) ?></td>
                                <td><input type="number" name="componentes[<?= $componente['id'] ?>]" value="<?= $componente['quantidade'] ?>" min="1" class="form-control"></td>
                                <td><button type="button" class="btn btn-danger removerComponente" data-id="<?= $componente['id'] ?>">Remover</button></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="mb-3">
                <label>Imagem do Produto:</label>
                <?php if ($produto['caminho_imagem']): ?>
                    <div class="mb-3">
                        <img src="<?= $produto['caminho_imagem'] ?>" alt="Imagem do produto" class="img-thumbnail" style="max-width: 200px;">
                    </div>
                <?php endif; ?>
                <input type="file" name="imagem" class="form-control" id="imagemProduto">
                <div class="mt-3">
                    <img id="previewImagemProduto" class="img-thumbnail" style="max-width: 200px; display: none;">
                </div>
            </div>

            <!-- Adicionar Imagens Adicionais -->
            <div class="mb-3">
                <label>Imagens Adicionais (até 4):</label>
                <input type="file" name="imagens_adicionais[]" class="form-control" multiple accept="image/*">
            </div>

            <!-- Listar Imagens Adicionais Existentes -->
            <div class="mb-3">
                <label>Imagens Adicionais Existentes:</label>
                <div class="d-flex flex-wrap">
                    <?php foreach ($imagens_adicionais as $imagem): ?>
                        <div class="position-relative m-2">
                            <img src="/uploads/<?= htmlspecialchars($imagem['caminho_imagem']) ?>" class="img-thumbnail" alt="Imagem adicional" style="width: 100px; height: 100px;">
                            <button type="button" class="btn-close removerImagem" data-id="<?= $imagem['id'] ?>" aria-label="Close"></button>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="mb-3">
                <label>Lucro (%):</label>
                <input type="number" name="lucro" value="<?= htmlspecialchars($produto['lucro'] ?? 200) ?>" class="form-control" min="0" step="0.1">
            </div>

            <button type="submit" class="btn btn-primary mt-3">Salvar Alterações</button>
            <a href="../views/produtos.php" class="btn btn-secondary mt-3">Voltar</a>
        </form>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="/js/scripts.js"></script> <!-- Inclui o arquivo JavaScript dedicado -->
</body>
</html>