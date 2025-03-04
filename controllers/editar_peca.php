<?php
session_start();
require __DIR__ . '/../config/config.php';
require __DIR__ . '/../includes/menu.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID inválido.");
}

$id = $_GET['id'];

// Buscar os dados da peça
$stmt = $pdo->prepare("SELECT * FROM pecas WHERE id = ?");
$stmt->execute([$id]);
$peca = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$peca) {
    die("Peça não encontrada.");
}

// Buscar estúdios para o select
$estudios = $pdo->query("SELECT id, nome FROM estudios ORDER BY nome")->fetchAll(PDO::FETCH_ASSOC);

// Buscar impressoras para o select (INCLUINDO ID)
$impressoras = $pdo->query("SELECT id, modelo, tipo FROM impressoras ORDER BY modelo")->fetchAll(PDO::FETCH_ASSOC);

// Atualizar os dados no banco ao salvar
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = trim($_POST['nome']);
    $estudio_id = $_POST['estudio_id'];
    $nome_original = trim($_POST['nome_original']);
    $nome_arquivo = trim($_POST['nome_arquivo']);
    $impressora = $_POST['impressora'];
    $material = $_POST['material'];
    $quantidade_material = $_POST['quantidade_material'];
    $tempo_impressao = $_POST['tempo_impressao'];

    $stmt = $pdo->prepare("UPDATE pecas SET nome = ?, estudio_id = ?, nome_original = ?, nome_arquivo = ?, impressora = ?, material = ?, quantidade_material = ?, tempo_impressao = ? WHERE id = ?");
    
    if ($stmt->execute([$nome, $estudio_id, $nome_original, $nome_arquivo, $impressora, $material, $quantidade_material, $tempo_impressao, $id])) {
        header("Location: ../views/pecas.php");
        exit;
    } else {
        echo "<script>alert('Erro ao atualizar peça!');</script>";
    }
}

// Buscar materiais filtrados pelo tipo de impressora
$materiais_filamento = $pdo->query("SELECT TIPO FROM filamentos ORDER BY TIPO")->fetchAll(PDO::FETCH_COLUMN);
$materiais_resina = $pdo->query("SELECT TIPO FROM resinas ORDER BY TIPO")->fetchAll(PDO::FETCH_COLUMN);
?>

<div class="container mt-5 pt-5">
    <h2>Editar Peças 3D</h2>
    <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Nome:</label>
            <input type="text" name="nome" value="<?= htmlspecialchars($peca['nome']) ?>" required class="form-control">
        </div>

        <div class="mb-3">        
            <label>Estúdio:</label>
            <select name="estudio_id" class="form-control">
                <?php foreach ($estudios as $estudio): ?>
                    <option value="<?= $estudio['id'] ?>" <?= ($peca['estudio_id'] == $estudio['id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($estudio['nome']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Nome Original:</label>
            <input type="text" name="nome_original" value="<?= htmlspecialchars($peca['nome_original']) ?>" required class="form-control">
        </div>

        <div class="mb-3">
            <label>Nome do Arquivo:</label>
            <input type="text" name="nome_arquivo" value="<?= htmlspecialchars($peca['nome_arquivo']) ?>" required class="form-control">
        </div>

        <div class="mb-3">
            <label>Impressora:</label>
            <select name="impressora" id="impressora" class="form-control" onchange="atualizarMateriais()">
                <option value="">Selecione uma impressora</option>
                <?php foreach ($impressoras as $imp): ?>
                    <option value="<?= htmlspecialchars($imp['id']) ?>" data-tipo="<?= $imp['tipo'] ?>"
                        <?= ($peca['impressora'] == $imp['id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($imp['modelo']) ?> (<?= htmlspecialchars($imp['tipo']) ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <div id="material-group" style="display: none;">
                <label>Material:</label>
                <select name="material" id="material" class="form-control">
                    <option value="<?= htmlspecialchars($peca['material']) ?>" selected><?= htmlspecialchars($peca['material']) ?></option>
                </select>
            </div>
        </div>

        <div class="mb-3">
            <label>Quantidade de Material (g):</label>
            <input type="number" name="quantidade_material" value="<?= $peca['quantidade_material'] ?>" required class="form-control">
        </div>

        <div class="mb-3">
            <label>Tempo de Impressão (hh:mm):</label>
            <input type="time" name="tempo_impressao" value="<?= $peca['tempo_impressao'] ?>" required class="form-control">
        </div>

        <!-- Pré-visualização da imagem atual -->
        <div class="mb-3">
            <label>Imagem Atual:</label><br>
            <?php if (!empty($peca['imagem']) && file_exists($peca['imagem'])): ?>
                <img src="<?= htmlspecialchars($peca['imagem']) ?>" alt="Imagem da Peça" style="max-width: 200px; max-height: 200px; margin-bottom: 10px;">
            <?php else: ?>
                <p>Nenhuma imagem disponível.</p>
            <?php endif; ?>
        </div>

        <!-- Upload de nova imagem -->
        <div class="mb-3">
            <label>Nova Imagem:</label>
            <input type="file" name="imagem" accept="image/*" class="form-control">
            <small class="form-text text-muted">Deixe em branco para manter a imagem atual.</small>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Atualizar</button>
        <a href="../views/pecas.php" class="btn btn-secondary mt-3">Cancelar</a>
    </form>
</div>

<script>
    function atualizarMateriais() {
        var impressoraSelect = document.getElementById("impressora");
        var tipoImpressora = impressoraSelect.selectedOptions[0].getAttribute("data-tipo");
        var materialSelect = document.getElementById("material");

        materialSelect.innerHTML = "<option value=''>Selecione o material</option>";

        if (tipoImpressora === "Filamento") {
            <?php foreach ($materiais_filamento as $material): ?>
                materialSelect.innerHTML += "<option value='<?= $material ?>' <?= ($peca['material'] == $material) ? 'selected' : '' ?>><?= $material ?></option>";
            <?php endforeach; ?>
        } else if (tipoImpressora === "Resina") {
            <?php foreach ($materiais_resina as $material): ?>
                materialSelect.innerHTML += "<option value='<?= $material ?>' <?= ($peca['material'] == $material) ? 'selected' : '' ?>><?= $material ?></option>";
            <?php endforeach; ?>
        }

        document.getElementById("material-group").style.display = tipoImpressora ? "block" : "none";
    }

    window.onload = function() {
        atualizarMateriais();
    };
</script>