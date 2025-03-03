<?php
session_start();
require __DIR__ . '/../config/config.php';
require __DIR__ . '/../includes/menu.php';

// Buscar opções de lavagem
$stmt_lavagem = $pdo->query("SELECT id, Produto FROM lavagem");
$opcoes_lavagem = $stmt_lavagem->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $marca = $_POST["marca"];
    $modelo = $_POST["modelo"];
    $localizacao = $_POST["localizacao"];
    $data_aquisicao = $_POST["data_aquisicao"];
    $valor_bem = $_POST["valor_bem"];
    $tempo_vida_util = $_POST["tempo_vida_util"];
    $kwh = $_POST["kwh"];
    $lavagem_id = $_POST["lavagem_id"];
    $tempo_lavagem = $_POST["tempo_lavagem"]; // Adicionado
    $tempo_cura = $_POST["tempo_cura"]; // Adicionado

    $stmt = $pdo->prepare("INSERT INTO estacoes_lavagem (Marca, Modelo, Localizacao, Data_Aquisicao, Valor_do_Bem, Tempo_de_Vida_Util, kWh, lavagem_id, tempo_lavagem, tempo_cura) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"); // Adicionado
    $stmt->execute([$marca, $modelo, $localizacao, $data_aquisicao, $valor_bem, $tempo_vida_util, $kwh, $lavagem_id, $tempo_lavagem, $tempo_cura]); // Adicionado

    header("Location: ../views/estacoes_lavagem.php");
    exit;
}
?>


<div class="container mt-4">
    <h2>Adicionar Estação de Lavagem</h2>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Marca</label>
            <input type="text" name="marca" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Modelo</label>
            <input type="text" name="modelo" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Localização</label>
            <input type="text" name="localizacao" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Data de Aquisição</label>
            <input type="date" name="data_aquisicao" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Valor do Bem (R$)</label>
            <input type="number" step="0.01" name="valor_bem" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Tempo de Vida Útil (h)</label>
            <input type="number" name="tempo_vida_util" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Tempo de Lavagem (hh:mm)</label>
            <input type="time" name="tempo_lavagem" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Tempo de Cura (hh:mm)</label>
            <input type="time" name="tempo_cura" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Consumo (kWh)</label>
            <input type="number" step="0.001" name="kwh" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Produto de Lavagem</label>
            <select name="lavagem_id" class="form-control">
                <option value="">Selecione um produto</option>
                <?php foreach ($opcoes_lavagem as $opcao): ?>
                    <option value="<?= $opcao['id'] ?>"><?= htmlspecialchars($opcao['Produto']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Adicionar</button>
        <a href="../views/estacoes_lavagem.php" class="btn btn-secondary mt-3">Voltar</a>
    </form>
</div>