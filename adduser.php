<?php
require 'db.php'; // Conexão com o banco de dados

$nome = "Celso Annes";
$email = "celsoannes@gmail.com";
$senha = "mellon";
$senha_hash = password_hash($senha, PASSWORD_DEFAULT); // Criptografa a senha

try {
    // Verifica se o usuário já existe
    $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    
    if ($stmt->fetch()) {
        echo "⚠️ O usuário '$email' já existe no banco de dados.";
    } else {
        // Insere o novo usuário
        $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha_hash, ultimo_acesso) VALUES (?, ?, ?, NOW())");
        $stmt->execute([$nome, $email, $senha_hash]);
        
        echo "✅ Usuário '$nome' adicionado com sucesso!";
    }
} catch (PDOException $e) {
    echo "Erro ao adicionar usuário: " . $e->getMessage();
}
?>