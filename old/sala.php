<?php
session_start();
include 'gerar_sala.php';

$sala_id = isset($_GET['sala']) ? (int)$_GET['sala'] : 1;

// Gerar ou recuperar informações da sala
if (!isset($_SESSION['salas'][$sala_id])) {
    $_SESSION['salas'][$sala_id] = gerarSala($sala_id);
}

$sala = $_SESSION['salas'][$sala_id];
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RPGzinho - Sala <?php echo $sala_id; ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Sala <?php echo $sala_id; ?></h1>
        <img src="images/<?php echo $sala['imagem']; ?>" alt="Sala <?php echo $sala_id; ?>" class="sala-imagem">
        <div class="sala-info">
            <p><strong>Descrição:</strong> <?php echo $sala['descricao']; ?></p>
            <?php if (isset($sala['paredes'])): ?>
                <p><strong>Paredes:</strong> <?php echo $sala['paredes']; ?></p>
            <?php endif; ?>
            <?php if (isset($sala['chao'])): ?>
                <p><strong>Chão:</strong> <?php echo $sala['chao']; ?></p>
            <?php endif; ?>
            <?php if (isset($sala['monstro'])): ?>
                <p><strong>Monstro:</strong> <?php echo $sala['monstro']; ?></p>
            <?php endif; ?>
            <?php if (isset($sala['sons_fracos'])): ?>
                <p><strong>Sons Fracos:</strong> <?php echo $sala['sons_fracos']; ?></p>
            <?php endif; ?>
            <?php if (isset($sala['portas'])): ?>
                <p><strong>Portas:</strong> <?php echo $sala['portas']; ?></p>
            <?php endif; ?>
            <?php if (isset($sala['decoracao'])): ?>
                <p><strong>Decoração:</strong> <?php echo $sala['decoracao']; ?></p>
            <?php endif; ?>
            <?php if (isset($sala['circulo'])): ?>
                <p><strong>Círculo:</strong> <?php echo $sala['circulo']; ?></p>
            <?php endif; ?>
            <?php if (isset($sala['magia'])): ?>
                <p><strong>Magia:</strong> <?php echo $sala['magia']; ?></p>
            <?php endif; ?>
            <?php if (isset($sala['agua'])): ?>
                <p><strong>Água:</strong> <?php echo $sala['agua']; ?></p>
            <?php endif; ?>
            <?php if (isset($sala['tesouro'])): ?>
                <p><strong>Tesouro:</strong> <?php echo $sala['tesouro']; ?></p>
            <?php endif; ?>
            <?php if (isset($sala['lado'])): ?>
                <p><strong>Lado:</strong> <?php echo $sala['lado']; ?></p>
            <?php endif; ?>
            <?php if (isset($sala['luz'])): ?>
                <p><strong>Luz:</strong> <?php echo $sala['luz']; ?></p>
            <?php endif; ?>
            <?php if (isset($sala['cobertura_porta'])): ?>
                <p><strong>Cobertura da Porta:</strong> <?php echo $sala['cobertura_porta']; ?></p>
            <?php endif; ?>
            <?php if (isset($sala['estatuas'])): ?>
                <p><strong>Estatuas:</strong> <?php echo $sala['estatuas']; ?></p>
            <?php endif; ?>
            <?php if (isset($sala['assunto_estatua'])): ?>
                <p><strong>Assunto da Estátua:</strong> <?php echo $sala['assunto_estatua']; ?></p>
            <?php endif; ?>
            <?php if (isset($sala['armadilha'])): ?>
                <p><strong>Armadilha:</strong> <?php echo $sala['armadilha']; ?></p>
            <?php endif; ?>
            <?php if (isset($sala['conteudo_buraco'])): ?>
                <p><strong>Conteúdo do Buraco:</strong> <?php echo $sala['conteudo_buraco']; ?></p>
            <?php endif; ?>
            <?php if (isset($sala['tipo_spray'])): ?>
                <p><strong>Tipo de Spray:</strong> <?php echo $sala['tipo_spray']; ?></p>
            <?php endif; ?>
            <?php if (isset($sala['numero_pessoa'])): ?>
                <p><strong>Número da Pessoa:</strong> <?php echo $sala['numero_pessoa']; ?></p>
            <?php endif; ?>
        </div>
        <div class="navegacao">
            <?php if ($sala_id > 1): ?>
                <a href="sala.php?sala=<?php echo $sala_id - 1; ?>" class="btn">Sala Anterior</a>
            <?php endif; ?>
            <?php if ($sala_id < 8): ?>
                <a href="sala.php?sala=<?php echo $sala_id + 1; ?>" class="btn">Próxima Sala</a>
            <?php endif; ?>
            <a href="sala.php?sala=<?php echo $sala_id; ?>" class="btn">Gerar Novamente</a>
        </div>
    </div>
</body>
</html>