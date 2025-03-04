<?php
session_start();
require __DIR__ . '/../config/config.php';
require __DIR__ . '/../includes/menu.php';

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM impressoras WHERE ID = ?");
$stmt->execute([$id]);
$impressora = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $marca = $_POST["marca"];
    $modelo = $_POST["modelo"];
    $tipo = $_POST["tipo"];
    $localizacao = $_POST["localizacao"];
    $data_aquisicao = $_POST["data_aquisicao"];
    $valor_bem = $_POST["valor_bem"];
    $vida_util = $_POST["vida_util"];
    $kwh = $_POST["kwh"];

    $stmt = $pdo->prepare("UPDATE impressoras SET Marca=?, Modelo=?, Tipo=?, Localizacao=?, Data_Aquisicao=?, Valor_do_Bem=?, Tempo_de_Vida_Util=?, kWh=? WHERE ID=?");
    $stmt->execute([$marca, $modelo, $tipo, $localizacao, $data_aquisicao, $valor_bem, $vida_util, $kwh, $id]);

    header("Location: ../views/impressoras.php");
    exit;
}
?>

<div class="container mt-4 pt-5">
    <h2>Editar Impressora</h2>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Marca</label>
            <input type="text" name="marca" class="form-control" value="<?= htmlspecialchars($impressora['Marca']) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Modelo</label>
            <input type="text" name="modelo" class="form-control" value="<?= htmlspecialchars($impressora['Modelo']) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Tipo</label>
            <select name="tipo" class="form-control">
                <option value="Filamento" <?= ($impressora['Tipo'] == 'Filamento') ? 'selected' : '' ?>>Filamento</option>
                <option value="Resina" <?= ($impressora['Tipo'] == 'Resina') ? 'selected' : '' ?>>Resina</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Localização</label>
            <input type="text" name="localizacao" class="form-control" value="<?= htmlspecialchars($impressora['Localizacao']) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Data de Aquisição</label>
            <input type="date" name="data_aquisicao" class="form-control" value="<?= $impressora['Data_Aquisicao'] ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Valor do Bem (R$)</label>
            <input type="number" name="valor_bem" step="0.01" class="form-control" value="<?= $impressora['Valor_do_Bem'] ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Tempo de Vida Útil (horas)</label>
            <input type="number" name="vida_util" class="form-control" value="<?= $impressora['Tempo_de_Vida_Util'] ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Consumo de Energia (kWh)</label>
            <input type="number" name="kwh" step="0.001" class="form-control" value="<?= $impressora['kWh'] ?>" required>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Salvar Alterações</button>
        <a href="../views/impressoras.php" class="btn btn-secondary mt-3">Voltar</a>

    </form>
</div>