<?php
// Ativar a exibição de erros para depuração
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Configuração do banco de dados
$servername = "localhost";
$username = "root"; // Altere conforme necessário
$password = ""; // Altere conforme necessário
$dbname = "popmarket"; // Altere conforme necessário

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Recuperar dados do formulário
$email = $_POST['email'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

// Validar dados do formulário
if ($password !== $confirm_password) {
    die("As senhas não coincidem.");
}

// Hash da senha para segurança
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Consulta SQL para inserir dados do usuário
$sql = "INSERT INTO users (email, password) VALUES (?, ?)";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Erro na preparação da consulta: " . $conn->error);
}

$stmt->bind_param("ss", $email, $hashed_password);

if ($stmt->execute()) {
    echo "Registro bem-sucedido.";
} else {
    echo "Erro: " . $stmt->error;
}

// Fechar conexão
$stmt->close();
$conn->close();
?>
