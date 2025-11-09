<?php
session_start();
require_once 'Usuario.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $usuario = Usuario::login($email, $senha);

    if ($usuario) {
        // Login bem-sucedido, armazena dados na sessão
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nome'] = $usuario['nome'];
        header('Location: ../html/dashboard.php');
        exit();
    } else {
        // Falha no login, redireciona de volta com erro
        header('Location: ../html/autenticacao.php?erro=1');
        exit();
    }
}
?>