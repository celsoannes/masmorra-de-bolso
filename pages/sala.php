<?php
session_start();
include '../includes/database.php';
include '../includes/gerar_sala.php';

$sala_id = isset($_GET['sala']) ? (int)$_GET['sala'] : 1;

if ($sala_id < 1 || $sala_id > 8) {
    $sala_id = 1;
}

$sala = gerarSala($sala_id, $pdo);
include '../includes/header.php';
?>

<h1>Sala <?php echo $sala_id; ?></h1>
<div class="sala-descricao">
    <?php echo $sala['descricao']; ?>
</div>

<img src="/assets/images/<?php echo $sala['imagem']; ?>" alt="Sala <?php echo $sala_id; ?>" class="sala-imagem">

<div class="sala-elementos">
    <?php
    // Exibir os elementos da sala
    foreach ($sala['elementos'] as $chave => $valor) {
        echo "<p><span class='destaque-chave'>{$chave}</span>: {$valor}</p>";
    }
    ?>
</div>

<!-- Botões para rolar dados -->
<div class="rolar-dados">
    <h3>Rolar Dados</h3>
    <div class="dados-container">
        <div class="dado">
            <button onclick="rolarDado('moeda')">Moeda</button>
            <span id="resultado-moeda"></span>
        </div>
        <div class="dado">
            <button onclick="rolarDado(4)">d4</button>
            <span id="resultado-4"></span>
        </div>
        <div class="dado">
            <button onclick="rolarDado(6)">d6</button>
            <span id="resultado-6"></span>
        </div>
        <div class="dado">
            <button onclick="rolarDado(8)">d8</button>
            <span id="resultado-8"></span>
        </div>
        <div class="dado">
            <button onclick="rolarDado(10)">d10</button>
            <span id="resultado-10"></span>
        </div>
        <div class="dado">
            <button onclick="rolarDado(12)">d12</button>
            <span id="resultado-12"></span>
        </div>
        <div class="dado">
            <button onclick="rolarDado(20)">d20</button>
            <span id="resultado-20"></span>
        </div>
        <div class="dado">
            <button onclick="rolarDado(100)">d100</button>
            <span id="resultado-100"></span>
        </div>
    </div>
</div>

<!-- Link para abrir o modal -->
<div class="mapa-link centralizado">
    <a href="#" onclick="openModal()">Ver Mapa Completo da Masmorra</a>
</div>

<!-- Modal -->
<div id="myModal" class="modal">
    <span class="close" onclick="closeModal()">&times;</span>
    <img class="modal-content" id="imgModal" src="/assets/images/masmorraGM.png" alt="Mapa Completo da Masmorra">
</div>

<div class="navegacao">
    <?php if ($sala_id > 1): ?>
        <a href="sala.php?sala=<?php echo $sala_id - 1; ?>" class="btn">Sala Anterior</a>
    <?php endif; ?>
    <a href="sala.php?sala=<?php echo $sala_id; ?>" class="btn">Regenerar Sala</a>
    <?php if ($sala_id < 8): ?>
        <a href="sala.php?sala=<?php echo $sala_id + 1; ?>" class="btn">Próxima Sala</a>
    <?php endif; ?>
</div>

<script>
function openModal() {
    var modal = document.getElementById("myModal");
    modal.style.display = "block";
}

function closeModal() {
    var modal = document.getElementById("myModal");
    modal.style.display = "none";
}

function rolarDado(tipo) {
    let resultado;
    if (tipo === 'moeda') {
        resultado = Math.random() < 0.5 ? 'Cara' : 'Coroa';
        document.getElementById('resultado-moeda').innerText = resultado;
    } else {
        resultado = Math.floor(Math.random() * tipo) + 1;
        document.getElementById('resultado-' + tipo).innerText = resultado;
    }
}
</script>

<?php
include '../templates/footer.php';
?>