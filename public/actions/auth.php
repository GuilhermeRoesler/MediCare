<?php

require_once __DIR__ . '/../../app/Core/bootstrap.php';
require_once __DIR__ . '/../../app/Models/Usuario.php';

$action = $_GET['action'] ?? 'login';

if ($action === 'login' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    Csrf::validate();

    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';

    if (!Validator::email($email) || $senha === '') {
        header('Location: ../autenticacao.php?erro=1');
        exit();
    }

    $usuario = Usuario::login($email, $senha);

    if ($usuario) {
        try {
            Auth::login($usuario);
            header('Location: ../dashboard.php');
            exit();
        } catch (InvalidArgumentException $e) {
            header('Location: ../autenticacao.php?erro=1');
            exit();
        }
    }

    header('Location: ../autenticacao.php?erro=1');
    exit();
}

if ($action === 'logout' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    Csrf::validate();
    Auth::logout();
    header('Location: ../autenticacao.php');
    exit();
}

header('Location: ../autenticacao.php');
exit();
