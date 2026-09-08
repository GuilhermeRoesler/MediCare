<?php

require_once __DIR__ . '/../../app/Core/bootstrap.php';
require_once __DIR__ . '/../../app/Models/Usuario.php';

$action = $_GET['action'] ?? 'login';

if ($action === 'login' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    Csrf::validate();

    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';

    $usuario = Usuario::login($email, $senha);

    if ($usuario) {
        Auth::login($usuario);
        header('Location: ../dashboard.php');
        exit();
    }

    header('Location: ../autenticacao.php?erro=1');
    exit();
}

if ($action === 'register' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    Csrf::validate();

    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';
    $confirmar = $_POST['confirmar_senha'] ?? '';

    if ($nome === '' || $email === '' || strlen($senha) < 6) {
        header('Location: ../autenticacao.php?erro=2');
        exit();
    }

    if ($senha !== $confirmar) {
        header('Location: ../autenticacao.php?erro=3');
        exit();
    }

    $novoUsuario = new Usuario($nome, $email, $senha, 'recepcao');

    if ($novoUsuario->cadastrar()) {
        $usuarioLogado = Usuario::login($email, $senha);
        if ($usuarioLogado) {
            Auth::login($usuarioLogado);
            header('Location: ../dashboard.php');
            exit();
        }
    }

    header('Location: ../autenticacao.php?erro=2');
    exit();
}

if ($action === 'logout') {
    Auth::logout();
    header('Location: ../autenticacao.php');
    exit();
}

header('Location: ../autenticacao.php');
exit();
