<?php

class Auth
{
    public static function startSession(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
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

    public static function login(array $usuario): void
    {
        self::startSession();
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nome'] = $usuario['nome'];
        $_SESSION['usuario_perfil'] = $usuario['perfil'] ?? 'admin';
    }

    public static function logout(): void
    {
        self::startSession();
        session_unset();
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
        return $_SESSION['usuario_perfil'] ?? 'admin';
    }

    public static function perfilLabel(): string
    {
        return self::perfil() === 'recepcao' ? 'Recepção' : 'Admin';
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
        ];
    }
}
