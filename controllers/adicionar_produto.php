<?php
session_start();
require __DIR__ . '/../config/config.php';
require __DIR__ . '/../includes/menu.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = trim($_POST['nome']);
    $video = trim($_POST['video']);
    $baixar = trim($_POST['baixar']);
    $observacoes = trim($_POST['observacoes']);
    $lucro = isset($_POST['lucro']) ? floatval($_POST['lucro']) : 150; // Define 150% como padrão

    // Upload de imagem (se houver)
    require 'upload.php';

    // Inserir produto no banco de dados
    $stmt = $pdo->prepare("INSERT INTO produtos (nome, caminho_imagem, video, baixar, observacoes, lucro) VALUES (?, ?, ?, ?, ?, ?)");
    if ($stmt->execute([$nome, $caminho_imagem, $video, $baixar, $observacoes, $lucro])) {
        $produto_id = $pdo->lastInsertId();

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

        header("Location: ../views/produtos.php");
        exit;
    } else {
        echo "<script>alert('Erro ao adicionar produto.');</script>";
    }
}
?>

<div class="container mt-5 pt-5">
    <h2>Adicionar Produto</h2>
    <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Nome do Produto:</label>
            <input type="text" name="nome" required class="form-control">
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
