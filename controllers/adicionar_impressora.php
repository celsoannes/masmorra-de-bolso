<?php
session_start();
require __DIR__ . '/../config/config.php';
require __DIR__ . '/../includes/menu.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $marca = $_POST["marca"];
    $modelo = $_POST["modelo"];
    $tipo = $_POST["tipo"];
    $localizacao = $_POST["localizacao"];
    $data_aquisicao = $_POST["data_aquisicao"];
    $valor_bem = $_POST["valor_bem"];
    $vida_util = $_POST["vida_util"];
    $kwh = $_POST["kwh"];

    $stmt = $pdo->prepare("INSERT INTO impressoras (Marca, Modelo, Tipo, Localizacao, Data_Aquisicao, Valor_do_Bem, Tempo_de_Vida_Util, kWh) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$marca, $modelo, $tipo, $localizacao, $data_aquisicao, $valor_bem, $vida_util, $kwh]);

    header("Location: ../views/impressoras.php");
    exit;
}
?>

<div class="container mt-4">
    <h2>Adicionar Impressora</h2>
    <form method="POST">
        <div class="mb-3">
            <label>Marca</label>
            <input type="text" name="marca" class="form-control" required>
        </div>
        
        <div class="mb-3">
            <label>Modelo</label>
            <input type="text" name="modelo" class="form-control" required>
        </div>
        
        <div class="mb-3">
            <label>Tipo</label>
            <select name="tipo" class="form-control" required>
                <option value="Filamento">Filamento</option>
                <option value="Resina">Resina</option>
            </select>
        </div>
        
        <div class="mb-3">
            <label>Localização</label>
            <input type="text" name="localizacao" class="form-control" required>
        </div>
        
        <div class="mb-3">
            <label>Data de Aquisição</label>
            <input type="date" name="data_aquisicao" class="form-control" required>
        </div>
        
        <div class="mb-3">
            <label>Valor do Bem (R$)</label>
            <input type="number" step="0.01" name="valor_bem" class="form-control" required>
        </div>
        
        <div class="mb-3">
            <label>Tempo de Vida Útil (horas)</label>
            <input type="number" name="vida_util" class="form-control" required>
        </div>
        
        <div class="mb-3">
            <label>Consumo de Energia (kWh)</label>
            <input type="number" step="0.001" name="kwh" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Adicionar</button>
        <a href="../views/impressoras.php" class="btn btn-secondary mt-3">Voltar</a>
    </form>
</div>