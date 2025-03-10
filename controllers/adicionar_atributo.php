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
            <input type="text" id="campoOpcoes" class="form-control" placeholder="Digite uma opção e pressione Enter">
            <div id="opcoesSelecionadas" class="mt-2"></div>
            <input type="hidden" name="opcoes" id="opcoesHidden">
        </div>
        <button type="submit" class="btn btn-success mt-3">Salvar</button>
        <a href="../views/atributos.php" class="btn btn-secondary mt-3">Voltar</a>
    </form>
</div>

<!-- jQuery (necessário para o autocomplete e manipulação do DOM) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    const campoOpcoes = $("#campoOpcoes");
    const opcoesSelecionadas = $("#opcoesSelecionadas");
    const opcoesHidden = $("#opcoesHidden");

    // Função para atualizar o campo hidden com as opções selecionadas
    function atualizarOpcoesHidden() {
        const opcoes = [];
        opcoesSelecionadas.find(".badge").each(function() {
            opcoes.push($(this).text().trim());
        });
        opcoesHidden.val(opcoes.join(","));
    }

    // Adicionar opção ao pressionar Enter
    campoOpcoes.on("keydown", function(event) {
        if (event.key === "Enter") {
            event.preventDefault(); // Impede o envio do formulário

            const opcao = campoOpcoes.val().trim();

            if (opcao) {
                // Verifica se a opção já foi adicionada
                if ($("#opcao_" + opcao).length === 0) {
                    opcoesSelecionadas.append(`
                        <span id="opcao_${opcao}" class="badge bg-primary me-2 mb-2">
                            ${opcao}
                            <button type="button" class="btn-close btn-close-white ms-2 removerOpcao" data-opcao="${opcao}"></button>
                        </span>
                    `);
                    campoOpcoes.val(""); // Limpa o campo
                    atualizarOpcoesHidden(); // Atualiza o campo hidden
                }
            }
        }
    });

    // Remover opção ao clicar no "X"
    opcoesSelecionadas.on("click", ".removerOpcao", function() {
        const opcao = $(this).data("opcao");
        $("#opcao_" + opcao).remove();
        atualizarOpcoesHidden(); // Atualiza o campo hidden
    });
});
</script>