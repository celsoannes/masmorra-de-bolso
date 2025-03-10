<?php
$upload_dir = '../uploads/imagens/';

// Certifica-se de que o diretório existe
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

if (!empty($_FILES['imagem']['name'])) {
    $arquivo_temp = $_FILES['imagem']['tmp_name'];
    $extensao = strtolower(pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION));

    // Verifica se o arquivo é um PNG
    if ($extensao !== 'png') {
        die("Erro: Apenas imagens PNG são permitidas.");
    }

    // Verifica se o arquivo é uma imagem válida
    if (!getimagesize($arquivo_temp)) {
        die("Erro: O arquivo não é uma imagem válida.");
    }

    // Verifica o tamanho máximo do arquivo (2MB)
    $max_size = 2 * 1024 * 1024; // 2MB em bytes
    if ($_FILES['imagem']['size'] > $max_size) {
        die("Erro: O arquivo deve ter no máximo 2MB.");
    }

    // Gera um nome de arquivo único usando hash
    $hash = md5(uniqid(rand(), true));
    $novo_nome = $hash . ".png";
    $caminho_imagem = $upload_dir . $novo_nome;

    // Move o arquivo para o diretório de uploads
    if (!move_uploaded_file($arquivo_temp, $caminho_imagem)) {
        die("Erro ao mover o arquivo para o diretório de destino.");
    }

    // Verifica se o arquivo realmente foi salvo
    if (!file_exists($caminho_imagem)) {
        die("Erro: O arquivo não foi salvo corretamente.");
    }
} else {
    $caminho_imagem = $componente['caminho_imagem'] ?? '';
}
?>