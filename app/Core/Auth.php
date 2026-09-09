<?php

declare(strict_types=1);

class Auth
{
    private const PERFIS_VALIDOS = ['admin', 'recepcao'];

    public static function startSession(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            $secure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
                || (isset($_SERVER['SERVER_PORT']) && (int) $_SERVER['SERVER_PORT'] === 443);

            session_set_cookie_params([
                'lifetime' => 0,
                'path' => '/',
                'secure' => $secure,
                'httponly' => true,
                'samesite' => 'Lax',
            ]);
            session_start();
        }
    }

    public static function check(): bool
    {
        self::startSession();
        return isset($_SESSION['usuario_id']);
    }

    public static function requireLogin(): void
    {
        if (!self::check()) {
            header('Location: autenticacao.php');
            exit();
        }
    }

    /**
     * Exige login a partir de scripts em public/actions/
     */
    public static function requireLoginFromActions(): void
    {
        self::startSession();
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: ../autenticacao.php');
            exit();
        }
    }

    public static function requireAdmin(): void
    {
        self::requireLogin();
        if (!self::isAdmin()) {
            Flash::error('Acesso restrito a administradores.');
            header('Location: dashboard.php');
            exit();
        }
    }

    public static function requireAdminFromActions(): void
    {
        self::requireLoginFromActions();
        if (!self::isAdmin()) {
            Flash::error('Acesso restrito a administradores.');
            header('Location: ../dashboard.php');
            exit();
        }
    }

    public static function login(array $usuario): void
    {
        self::startSession();

        $perfil = $usuario['perfil'] ?? '';
        if (!in_array($perfil, self::PERFIS_VALIDOS, true)) {
            throw new InvalidArgumentException('Perfil de usuário inválido.');
        }

        session_regenerate_id(true);

        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nome'] = $usuario['nome'];
        $_SESSION['usuario_perfil'] = $perfil;
    }

    public static function logout(): void
    {
        self::startSession();
        $_SESSION = [];

        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'] ?? '', (bool) $params['secure'], (bool) $params['httponly']);
        }

        session_destroy();
    }

    public static function id(): ?int
    {
        return self::check() ? (int) $_SESSION['usuario_id'] : null;
    }

    public static function nome(): string
    {
        return $_SESSION['usuario_nome'] ?? 'Usuário';
    }

    public static function perfil(): string
    {
        if (!self::check()) {
            return '';
        }

        $perfil = $_SESSION['usuario_perfil'] ?? '';
        return in_array($perfil, self::PERFIS_VALIDOS, true) ? $perfil : '';
    }

    public static function perfilLabel(): string
    {
        return match (self::perfil()) {
            'recepcao' => 'Recepção',
            'admin' => 'Admin',
            default => 'Usuário',
        };
    }

    public static function isAdmin(): bool
    {
        return self::perfil() === 'admin';
    }

    /**
     * Variáveis comuns para partials de layout
     */
    public static function viewLocals(): array
    {
        $nome = self::nome();
        return [
            'nomeUsuario' => $nome,
            'primeiraLetra' => strtoupper(substr($nome, 0, 1)),
            'perfilUsuario' => self::perfilLabel(),
            'isAdmin' => self::isAdmin(),
        ];
    }
}
