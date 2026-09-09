<?php
require_once '../app/Core/bootstrap.php';

if (Auth::check()) {
    header('Location: dashboard.php');
    exit();
}

$erro = $_GET['erro'] ?? null;
$mensagens = [
    '1' => 'E-mail ou senha inválidos. Tente novamente.',
];
$mensagemErro = $mensagens[$erro] ?? null;
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>MediCare System - Autenticação</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,600;700&family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/autenticacao.css" />
</head>
<body>
    <div class="auth-container">
        <div class="auth-box">
            <div class="auth-header">
                <div class="logo-circle">
                    <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                </div>
                <h1 class="brand-name">MediCare</h1>
                <p>Gestão de consultas, pacientes e equipe clínica</p>
            </div>

            <?php if ($mensagemErro): ?>
                <p class="auth-error" role="alert"><?php echo htmlspecialchars($mensagemErro); ?></p>
            <?php endif; ?>

            <form id="loginForm" class="form active" action="actions/auth.php?action=login" method="POST">
                <?php echo Csrf::field(); ?>
                <label for="login-email">Email</label>
                <input id="login-email" type="email" name="email" placeholder="Digite seu email" required autocomplete="email" />

                <label for="login-senha">Senha</label>
                <input id="login-senha" type="password" name="senha" placeholder="Digite sua senha" required autocomplete="current-password" />

                <button type="submit" class="submit-btn">Entrar</button>
                <p class="demo-hint">Demo: <strong>admin@medicare.com</strong> / <strong>123456</strong></p>
                <p class="demo-hint">Novos usuários só podem ser criados por um administrador no banco de dados.</p>
            </form>

            <footer>
                <p><strong>MediCare System v1.2.0</strong><br>Sistema seguro para gestão médica</p>
            </footer>
        </div>
    </div>
</body>
</html>
