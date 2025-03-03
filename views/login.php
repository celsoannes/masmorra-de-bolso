<?php
session_start();
require __DIR__ . '/../config/config.php';

// Verifica se o usuário já está logado
if (isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit;
}

$erro = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    
    // Verifica reCAPTCHA Invisível v2
    $recaptcha_secret = '6Le2ueYqAAAAAA47DNHhMixFJVpFcTMNAo8JerJp';
    $recaptcha_response = $_POST['g-recaptcha-response'];
    $recaptcha_url = "https://www.google.com/recaptcha/api/siteverify?secret=$recaptcha_secret&response=$recaptcha_response";
    $recaptcha = json_decode(file_get_contents($recaptcha_url));
    
    if (!$recaptcha->success) {
        $erro = "🧙‍♂️ A magia do reCAPTCHA falhou! Tente novamente, aventureiro.";
    } else {
        $stmt = $pdo->prepare("SELECT id, nome, senha_hash FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario && password_verify($senha, $usuario['senha_hash'])) {
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nome'] = $usuario['nome'];
            
            // Atualiza o último acesso
            $stmt = $pdo->prepare("UPDATE usuarios SET ultimo_acesso = NOW() WHERE id = ?");
            $stmt->execute([$usuario['id']]);
            
            header("Location: index.php");
            exit;
        } else {
            $erro = "🔮 As chaves do conhecimento não coincidem! Verifique seu e-mail e senha.";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body class="d-flex justify-content-center align-items-center vh-100">
    <div class="container text-center">
        <h2 class="mb-4">Entre no Reino</h2>
        <?php if ($erro) echo "<div class='alert alert-danger'>$erro</div>"; ?>
        <form method="POST" class="w-50 mx-auto p-4 border rounded">
            <div class="mb-3">
                <label class="form-label">Email:</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Senha:</label>
                <input type="password" name="senha" class="form-control" required>
            </div>
            <button class="btn btn-primary g-recaptcha" data-sitekey="6Le2ueYqAAAAAK6blZSmXot6VOHqYU689flSfR5w" data-callback="onSubmit">Entrar</button>
        </form>
    </div>
    <script>
        function onSubmit(token) {
            document.forms[0].submit();
        }
    </script>
</body>
</html>