<?php
session_start();
session_destroy(); // Destroi a sessão

header("Location: login.php?msg=Você saiu do sistema."); // Redireciona para a tela de login com uma mensagem
exit;
?>