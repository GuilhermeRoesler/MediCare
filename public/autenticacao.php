<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>MediCare System - Autenticação</title>
    <link rel="stylesheet" href="css/autenticacao.css" />
</head>
<body>
    <div class="auth-container">
        <div class="auth-box">
            <div class="auth-header">
                <div class="logo-circle">
                    <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                </div>
                <h1>MediCare System</h1>
                <p>Sistema de Gerenciamento de Consultas Médicas</p>
            </div>

            <?php
                if (isset($_GET['erro'])) {
                    $mensagem = '';
                    if ($_GET['erro'] == 1) {
                        $mensagem = 'E-mail ou senha inválidos. Tente novamente.';
                    } elseif ($_GET['erro'] == 2) {
                        $mensagem = 'Erro ao cadastrar. Tente novamente.';
                    }
                    echo '<p style="color: red; margin-bottom: 1rem;">' . $mensagem . '</p>';
                }
            ?>

            <div class="tab-container">
                <button id="loginTab" class="tab active" onclick="toggleMode('login')">Entrar</button>
                <button id="registerTab" class="tab" onclick="toggleMode('register')">Cadastrar</button>
            </div>

            <!-- Login Form -->
            <form id="loginForm" class="form active" action="../app/Http/Controllers/authController.php?action=login" method="POST">
                <label>Email</label>
                <input type="email" name="email" placeholder="Digite seu email" required />

                <label>Senha</label>
                <input type="password" name="senha" placeholder="Digite sua senha" required />

                <button type="submit" class="submit-btn">Entrar</button>
                <a href="#" class="forgot">Esqueceu sua senha?</a>
            </form>

            <!-- Register Form -->
            <form id="registerForm" class="form" action="../app/Http/Controllers/authController.php?action=register" method="POST">
                <label>Nome Completo</label>
                <input type="text" name="nome" placeholder="Digite seu nome completo" required />

                <label>Email</label>
                <input type="email" name="email" placeholder="Digite seu email" required />

                <label>Senha</label>
                <input type="password" name="senha" placeholder="Mínimo 6 caracteres" required />

                <label>Confirmar Senha</label>
                <input type="password" name="confirmar_senha" placeholder="Digite a senha novamente" required />

                <button type="submit" class="submit-btn">Cadastrar</button>
            </form>

            <footer>
                <p><strong>MediCare System v1.0.0</strong><br>Sistema seguro para gestão médica</p>
            </footer>
        </div>
    </div>

    <script>
        const loginTab = document.getElementById('loginTab');
        const registerTab = document.getElementById('registerTab');
        const loginForm = document.getElementById('loginForm');
        const registerForm = document.getElementById('registerForm');

        function toggleMode(mode) {
            if (mode === 'login') {
                loginTab.classList.add('active');
                registerTab.classList.remove('active');
                loginForm.classList.add('active');
                registerForm.classList.remove('active');
            } else {
                registerTab.classList.add('active');
                loginTab.classList.remove('active');
                registerForm.classList.add('active');
                loginForm.classList.remove('active');
            }
        }
    </script>
</body>
</html>