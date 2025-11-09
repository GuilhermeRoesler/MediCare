<?php
session_start();
require_once 'Usuario.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    // Adicionar validação de confirmação de senha se necessário
    
    $novoUsuario = new Usuario($nome, $email, $senha);

    if ($novoUsuario->cadastrar()) {
        // Tenta fazer login automaticamente após o cadastro
        $usuarioLogado = Usuario::login($email, $senha);
        if ($usuarioLogado) {
            $_SESSION['usuario_id'] = $usuarioLogado['id'];
            $_SESSION['usuario_nome'] = $usuarioLogado['nome'];
            header('Location: ../html/dashboard.php');
            exit();
        }
    }
    
    // Se o cadastro ou login automático falhar, redireciona com erro
    header('Location: ../html/autenticacao.php?erro=2');
    exit();
}
?>