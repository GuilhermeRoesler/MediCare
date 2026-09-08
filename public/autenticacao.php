<?php
require_once '../app/Core/bootstrap.php';

if (Auth::check()) {
    header('Location: dashboard.php');
    exit();
}

$erro = $_GET['erro'] ?? null;
$mensagens = [
    '1' => 'E-mail ou senha inválidos. Tente novamente.',
    '2' => 'Erro ao cadastrar. Verifique os dados e tente novamente.',
    '3' => 'As senhas não coincidem. Confirme a senha corretamente.',
];
$mensagemErro = $mensagens[$erro] ?? null;
$modo = ($erro === '2' || $erro === '3') ? 'register' : 'login';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>MediCare System - Autenticação</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
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
                <h1>MediCare System</h1>
                <p>Sistema de Gerenciamento de Consultas Médicas</p>
            </div>

            <?php if ($mensagemErro): ?>
                <p class="auth-error" role="alert"><?php echo htmlspecialchars($mensagemErro); ?></p>
            <?php endif; ?>

            <div class="tab-container" role="tablist">
                <button type="button" id="loginTab" class="tab <?php echo $modo === 'login' ? 'active' : ''; ?>" onclick="toggleMode('login')" role="tab" aria-selected="<?php echo $modo === 'login' ? 'true' : 'false'; ?>">Entrar</button>
                <button type="button" id="registerTab" class="tab <?php echo $modo === 'register' ? 'active' : ''; ?>" onclick="toggleMode('register')" role="tab" aria-selected="<?php echo $modo === 'register' ? 'true' : 'false'; ?>">Cadastrar</button>
            </div>

            <form id="loginForm" class="form <?php echo $modo === 'login' ? 'active' : ''; ?>" action="actions/auth.php?action=login" method="POST">
                <?php echo Csrf::field(); ?>
                <label for="login-email">Email</label>
                <input id="login-email" type="email" name="email" placeholder="Digite seu email" required autocomplete="email" />

                <label for="login-senha">Senha</label>
                <input id="login-senha" type="password" name="senha" placeholder="Digite sua senha" required autocomplete="current-password" />

                <button type="submit" class="submit-btn">Entrar</button>
                <p class="demo-hint">Demo: <strong>admin@medicare.com</strong> / <strong>123456</strong></p>
            </form>

            <form id="registerForm" class="form <?php echo $modo === 'register' ? 'active' : ''; ?>" action="actions/auth.php?action=register" method="POST">
                <?php echo Csrf::field(); ?>
                <label for="reg-nome">Nome Completo</label>
                <input id="reg-nome" type="text" name="nome" placeholder="Digite seu nome completo" required autocomplete="name" />

                <label for="reg-email">Email</label>
                <input id="reg-email" type="email" name="email" placeholder="Digite seu email" required autocomplete="email" />

                <label for="reg-senha">Senha</label>
                <input id="reg-senha" type="password" name="senha" placeholder="Mínimo 6 caracteres" required minlength="6" autocomplete="new-password" />

                <label for="reg-confirmar">Confirmar Senha</label>
                <input id="reg-confirmar" type="password" name="confirmar_senha" placeholder="Digite a senha novamente" required minlength="6" autocomplete="new-password" />

                <button type="submit" class="submit-btn">Cadastrar</button>
            </form>

            <footer>
                <p><strong>MediCare System v1.1.0</strong><br>Sistema seguro para gestão médica</p>
            </footer>
        </div>
    </div>

    <script>
        const loginTab = document.getElementById('loginTab');
        const registerTab = document.getElementById('registerTab');
        const loginForm = document.getElementById('loginForm');
        const registerForm = document.getElementById('registerForm');

        function toggleMode(mode) {
            const isLogin = mode === 'login';
            loginTab.classList.toggle('active', isLogin);
            registerTab.classList.toggle('active', !isLogin);
            loginForm.classList.toggle('active', isLogin);
            registerForm.classList.toggle('active', !isLogin);
            loginTab.setAttribute('aria-selected', isLogin ? 'true' : 'false');
            registerTab.setAttribute('aria-selected', isLogin ? 'false' : 'true');
        }

        registerForm.addEventListener('submit', function (e) {
            const senha = document.getElementById('reg-senha').value;
            const confirmar = document.getElementById('reg-confirmar').value;
            if (senha !== confirmar) {
                e.preventDefault();
                alert('As senhas não coincidem.');
            }
        });
    </script>
</body>
</html>
