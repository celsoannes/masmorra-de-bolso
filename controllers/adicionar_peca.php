<?php
session_start();
require __DIR__ . '/../config/config.php';
require __DIR__ . '/../includes/menu.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = trim($_POST['nome']);
    $estudio_nome = trim($_POST['estudio']); // Nome do estúdio digitado pelo usuário
    $nome_original = trim($_POST['nome_original']);
    $nome_arquivo = trim($_POST['nome_arquivo']);
    $impressora = $_POST['impressora'];
    $material = $_POST['material'];
    $quantidade_material = $_POST['quantidade_material'];
    $tempo_impressao = $_POST['tempo_impressao'];
    $imagem = "";

    // Verifica se o estúdio já existe
    $stmt = $pdo->prepare("SELECT id FROM estudios WHERE nome = ?");
    $stmt->execute([$estudio_nome]);
    $estudio_id = $stmt->fetchColumn();

    if (!$estudio_id) {
        // Insere o novo estúdio e obtém o ID
        $stmt = $pdo->prepare("INSERT INTO estudios (nome) VALUES (?)");
        $stmt->execute([$estudio_nome]);
        $estudio_id = $pdo->lastInsertId();
    }

    // Verifica se já existe uma peça com esse nome, nome_original ou nome_arquivo
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM pecas WHERE nome = ? OR nome_original = ? OR nome_arquivo = ?");
    $stmt->execute([$nome, $nome_original, $nome_arquivo]);

    if ($stmt->fetchColumn() > 0) {
        echo "<script>alert('Erro: Nome, Nome Original ou Nome do Arquivo já existem!');</script>";
    } else {
        // Upload da imagem
        if (!empty($_FILES['imagem']['name'])) {
            $diretorio = '../uploads/pecas/';
            if (!is_dir($diretorio)) {
                mkdir($diretorio, 0777, true);
            }

            $extensoes_permitidas = ['jpg', 'jpeg', 'png'];
            $extensao = strtolower(pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION));

            if (in_array($extensao, $extensoes_permitidas) && $_FILES['imagem']['size'] <= 2097152) { // 2MB
                $nome_arquivo_imagem = uniqid() . '.' . $extensao;
                $caminho_imagem = $diretorio . $nome_arquivo_imagem;
                
                if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminho_imagem)) {
                    $imagem = str_replace('../', '', $caminho_imagem); // Salvando caminho relativo
                }
            } else {
                echo "<script>alert('Erro: Formato inválido ou tamanho maior que 2MB!');</script>";
            }
        }

        // Insere a peça no banco
        $stmt = $pdo->prepare("INSERT INTO pecas (nome, estudio_id, nome_original, nome_arquivo, impressora, material, quantidade_material, tempo_impressao, imagem) 
                               VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
        if ($stmt->execute([$nome, $estudio_id, $nome_original, $nome_arquivo, $impressora, $material, $quantidade_material, $tempo_impressao, $imagem])) {
            header("Location: ../views/pecas.php");
            exit;
        } else {
            echo "<script>alert('Erro ao adicionar peça!');</script>";
        }
    }
}

// Pega os estúdios para o autocomplete
$estudios = $pdo->query("SELECT id, nome FROM estudios ORDER BY nome")->fetchAll(PDO::FETCH_ASSOC);

// Pega as impressoras disponíveis
$impressoras = $pdo->query("SELECT id, modelo, tipo FROM impressoras ORDER BY modelo")->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-5">
    <h2>Adicionar Peças 3D</h2>
    <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Nome:</label>
            <input type="text" name="nome" required class="form-control">
        </div>
        
        <div class="mb-3">
            <label>Estúdio:</label>
            <input type="text" id="estudio" name="estudio" class="form-control" list="estudio-list" required>
            <datalist id="estudio-list">
                <?php foreach ($estudios as $estudio): ?>
                    <option value="<?= htmlspecialchars($estudio['nome']) ?>"></option>
                <?php endforeach; ?>
            </datalist>
        </div>

        <div class="mb-3">
            <label>Nome Original:</label>
            <input type="text" name="nome_original" required class="form-control">
        </div>

        <div class="mb-3">
            <label>Nome do Arquivo:</label>
            <input type="text" name="nome_arquivo" required class="form-control">
        </div>

        <div class="mb-3">
            <label>Impressora:</label>
            <select name="impressora" id="impressora" class="form-control" required>
                <option value="">Selecione uma impressora</option>
                <?php foreach ($impressoras as $impressora): ?>
                    <option value="<?= $impressora['id'] ?>" data-tipo="<?= $impressora['tipo'] ?>">
                        <?= htmlspecialchars($impressora['modelo']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <div id="material-container" style="display: none;">
                <label>Material:</label>
                <select name="material" id="material" class="form-control">
                    <option value="">Selecione um material</option>
                </select>
            </div>
        </div>

        <div class="mb-3">
            <label>Quantidade de Material (g):</label>
            <input type="number" name="quantidade_material" required class="form-control">
        </div>

        <div class="mb-3">
            <label>Tempo de Impressão (hh:mm):</label>
            <input type="time" name="tempo_impressao" required class="form-control">
        </div>

        <div class="mb-3">
            <label>Imagem da Peça:</label>
            <input type="file" name="imagem" accept="image/*" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary mt-3">Adicionar</button>
        <a href="../views/pecas.php" class="btn btn-secondary mt-3">Voltar</a>
    </form>
</div>

<!-- jQuery e jQuery UI para Autocomplete -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>
$(document).ready(function() {
    $("#impressora").change(function() {
        var impressoraId = $(this).val();
        var tipoImpressora = $("#impressora option:selected").data("tipo");

        if (impressoraId) {
            $("#material-container").show();
            $("#material").html('<option value="">Carregando...</option>');

            $.ajax({
                url: "../controllers/buscar_materiais.php",
                method: "POST",
                data: { tipo: tipoImpressora },
                success: function(response) {
                    $("#material").html(response);
                }
            });

        } else {
            $("#material-container").hide();
            $("#material").html('<option value="">Selecione uma impressora primeiro</option>');
        }
    });
});
</script>