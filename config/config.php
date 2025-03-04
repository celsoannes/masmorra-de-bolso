<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = '127.0.0.1'; // Ou 'localhost'
$db   = 'gestao3d';
$user = 'root'; // Usuário padrão do XAMPP
$pass = 'minhasenha'; // Senha padrão no XAMPP é vazia
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    die("Erro na conexão com o banco de dados: " . $e->getMessage());
}
?>