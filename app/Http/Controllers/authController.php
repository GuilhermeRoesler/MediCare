<?php
session_start();
require_once __DIR__ . '/../../Models/Usuario.php';

$action = $_GET['action'] ?? 'login';

if ($action === 'login' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $usuario = Usuario::login($email, $senha);

    if ($usuario) {
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nome'] = $usuario['nome'];
        header('Location: ../../../public/dashboard.php');
        exit();
    } else {
        header('Location: ../../../public/autenticacao.php?erro=1');
        exit();
    }
}

if ($action === 'register' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    
    $novoUsuario = new Usuario($nome, $email, $senha);

    if ($novoUsuario->cadastrar()) {
        $usuarioLogado = Usuario::login($email, $senha);
        if ($usuarioLogado) {
            $_SESSION['usuario_id'] = $usuarioLogado['id'];
            $_SESSION['usuario_nome'] = $usuarioLogado['nome'];
            header('Location: ../../../public/dashboard.php');
            exit();
        }
    }
    
    header('Location: ../../../public/autenticacao.php?erro=2');
    exit();
}

if ($action === 'logout') {
    session_unset();
    session_destroy();
    header('Location: ../../../public/autenticacao.php');
    exit();
}
?>