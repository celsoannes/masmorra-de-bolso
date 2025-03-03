<?php
session_start();
require __DIR__ . '/../config/config.php';
require __DIR__ . '/../includes/menu.php';

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

// Buscar peças associadas ao produto
$stmt = $pdo->prepare("SELECT p.id, p.nome, pp.quantidade 
                       FROM produtos_pecas pp 
                       JOIN pecas p ON pp.peca_id = p.id 
                       WHERE pp.produto_id = ?");
$stmt->execute([$id]);
$pecas = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Buscar componentes associados ao produto
$stmt = $pdo->prepare("SELECT c.id, c.nome_material AS nome, pc.quantidade 
                       FROM produtos_componentes pc 
                       JOIN componentes c ON pc.componente_id = c.id 
                       WHERE pc.produto_id = ?");
$stmt->execute([$id]);
$componentes = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = trim($_POST['nome']);
    $lucro = $_POST['lucro'] ?? 150;
    $video = trim($_POST['video']);
    $baixar = trim($_POST['baixar']);
    $observacoes = trim($_POST['observacoes']);
    
    // Se um novo arquivo for enviado, atualiza a imagem
    if (!empty($_FILES['imagem']['name'])) {
        require 'upload.php';
        $imagem = $caminho_imagem;
    } else {
        $imagem = $produto['caminho_imagem'];
    }

    // Atualizar produto
    $stmt = $pdo->prepare("UPDATE produtos SET nome = ?, caminho_imagem = ?, lucro = ?, video = ?, baixar = ?, observacoes = ? WHERE id = ?");
    if ($stmt->execute([$nome, $imagem, $lucro, $video, $baixar, $observacoes, $id])) {
        // Remover peças/componentes antigos
        $pdo->prepare("DELETE FROM produtos_pecas WHERE produto_id = ?")->execute([$id]);
        $pdo->prepare("DELETE FROM produtos_componentes WHERE produto_id = ?")->execute([$id]);

        // Adicionar peças
        foreach ($_POST['pecas'] as $peca_id => $quantidade) {
            if ($quantidade > 0) {
                $pdo->prepare("INSERT INTO produtos_pecas (produto_id, peca_id, quantidade) VALUES (?, ?, ?)")
                    ->execute([$id, $peca_id, $quantidade]);
            }
        }

        // Adicionar componentes
        foreach ($_POST['componentes'] as $componente_id => $quantidade) {
            if ($quantidade > 0) {
                $pdo->prepare("INSERT INTO produtos_componentes (produto_id, componente_id, quantidade) VALUES (?, ?, ?)")
                    ->execute([$id, $componente_id, $quantidade]);
            }
        }

        header("Location: ../views/produtos.php");
        exit;
    } else {
        echo "<script>alert('Erro ao editar produto.');</script>";
    }
}
?>

<div class="container mt-5">
    <h2>Editar Produto</h2>
    <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Nome do Produto:</label>
            <input type="text" name="nome" value="<?= htmlspecialchars($produto['nome']) ?>" required class="form-control">
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
                        <th>Nome da Peça</th>
                        <th>Quantidade</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody id="tabelaPecas">
                    <?php foreach ($pecas as $peca): ?>
                        <tr id="peca_<?= $peca['id'] ?>">
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
                        <th>Nome do Componente</th>
                        <th>Quantidade</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody id="tabelaComponentes">
                    <?php foreach ($componentes as $componente): ?>
                        <tr id="componente_<?= $componente['id'] ?>">
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
            <input type="file" name="imagem" class="form-control">
        </div>

        <div class="mb-3">
            <label>Lucro (%):</label>
            <input type="number" name="lucro" value="<?= htmlspecialchars($produto['lucro'] ?? 150) ?>" class="form-control" min="0" step="0.1">
        </div>

        <button type="submit" class="btn btn-primary mt-3">Salvar Alterações</button>
        <a href="../views/produtos.php" class="btn btn-secondary mt-3">Voltar</a>
    </form>
</div>

<!-- jQuery e jQuery UI para Autocomplete -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

            if ($("#peca_" + pecaId).length === 0) {
                $("#tabelaPecas").append(`
                    <tr id="peca_${pecaId}">
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

            if ($("#componente_" + componenteId).length === 0) {
                $("#tabelaComponentes").append(`
                    <tr id="componente_${componenteId}">
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
});
</script>