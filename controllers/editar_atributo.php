<?php
session_start();
require __DIR__ . '/../config/config.php';

if (!isset($_SESSION['usuario_id']) || !isset($_GET['id'])) {
    header("Location: ../views/atributos.php");
    exit;
}

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM categoria_atributos WHERE id = ?");
$stmt->execute([$id]);
$atributo = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$atributo) {
    header("Location: ../views/atributos.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $categoria_id = $_POST["categoria_id"];
    $nome_atributo = $_POST["nome_atributo"];
    $tipo_atributo = $_POST["tipo_atributo"];
    $opcoes = $_POST["opcoes"];

    $stmt = $pdo->prepare("UPDATE categoria_atributos SET categoria_id = ?, nome_atributo = ?, tipo_atributo = ?, opcoes = ? WHERE id = ?");
    $stmt->execute([$categoria_id, $nome_atributo, $tipo_atributo, $opcoes, $id]);

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

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Atributo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- jQuery e jQuery UI -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
</head>
<body>
    <div class="container mt-4 pt-5">
        <h2>Editar Atributo</h2>
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Categoria</label>
                <select name="categoria_id" class="form-control" required>
                    <?php foreach ($categorias as $categoria): ?>
                        <option value="<?= $categoria['id'] ?>" <?= $categoria['id'] == $atributo['categoria_id'] ? 'selected' : '' ?>><?= htmlspecialchars($categoria['nome']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Nome do Atributo</label>
                <input type="text" name="nome_atributo" class="form-control" value="<?= htmlspecialchars($atributo['nome_atributo']) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Tipo do Atributo</label>
                <select name="tipo_atributo" class="form-control" required>
                    <option value="text" <?= $atributo['tipo_atributo'] == 'text' ? 'selected' : '' ?>>Texto</option>
                    <option value="number" <?= $atributo['tipo_atributo'] == 'number' ? 'selected' : '' ?>>Número</option>
                    <option value="select" <?= $atributo['tipo_atributo'] == 'select' ? 'selected' : '' ?>>Seleção</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Opções (apenas para tipo "Seleção")</label>
                <input type="text" id="campo_opcoes" class="form-control" placeholder="Digite uma opção e pressione Enter">
                <div id="opcoes_selecionadas" class="mt-2"></div>
                <input type="hidden" name="opcoes" id="opcoes_hidden" value="<?= htmlspecialchars($atributo['opcoes']) ?>">
            </div>
            <button type="submit" class="btn btn-primary mt-3">Salvar Alterações</button>
            <a href="../views/atributos.php" class="btn btn-secondary mt-3">Voltar</a>
        </form>
    </div>

    <script>
    $(document).ready(function() {
        // Inicializa as opções já existentes
        let opcoes = $("#opcoes_hidden").val().split(",").filter(Boolean);
        atualizarOpcoesSelecionadas(opcoes);

        // Adiciona uma nova opção ao pressionar Enter
        $("#campo_opcoes").on("keydown", function(event) {
            if (event.key === "Enter") {
                event.preventDefault(); // Impede o envio do formulário

                let novaOpcao = $(this).val().trim(); // Pega o valor do campo

                if (novaOpcao && !opcoes.includes(novaOpcao)) {
                    opcoes.push(novaOpcao); // Adiciona a nova opção ao array
                    atualizarOpcoesSelecionadas(opcoes); // Atualiza a exibição
                    $(this).val(""); // Limpa o campo
                }
            }
        });

        // Remove uma opção ao clicar no "X"
        $(document).on("click", ".removerOpcao", function() {
            let opcaoRemovida = $(this).data("opcao");
            opcoes = opcoes.filter(opcao => opcao !== opcaoRemovida); // Remove a opção do array
            atualizarOpcoesSelecionadas(opcoes); // Atualiza a exibição
        });

        // Função para atualizar a exibição das opções selecionadas
        function atualizarOpcoesSelecionadas(opcoes) {
            $("#opcoes_selecionadas").empty(); // Limpa o contêiner

            opcoes.forEach(opcao => {
                $("#opcoes_selecionadas").append(`
                    <span class="badge bg-primary me-2">
                        ${opcao}
                        <button type="button" class="btn-close btn-close-white ms-2 removerOpcao" data-opcao="${opcao}"></button>
                    </span>
                `);
            });

            // Atualiza o campo oculto com as opções separadas por vírgulas
            $("#opcoes_hidden").val(opcoes.join(","));
        }
    });
    </script>
</body>
</html>