<?php

class Csrf
{
    private const SESSION_KEY = '_csrf_token';

    public static function token(): string
    {
        Auth::startSession();
        if (empty($_SESSION[self::SESSION_KEY])) {
            $_SESSION[self::SESSION_KEY] = bin2hex(random_bytes(32));
        }
        return $_SESSION[self::SESSION_KEY];
    }

    public static function field(): string
    {
        $token = htmlspecialchars(self::token(), ENT_QUOTES, 'UTF-8');
        return '<input type="hidden" name="_csrf" value="' . $token . '">';
    }

    public static function validate(): void
    {
        Auth::startSession();
        $sessionToken = $_SESSION[self::SESSION_KEY] ?? '';
        $requestToken = $_POST['_csrf'] ?? '';

        if ($sessionToken === '' || $requestToken === '' || !hash_equals($sessionToken, $requestToken)) {
            http_response_code(403);
            die('Token CSRF inválido ou ausente. Recarregue a página e tente novamente.');
        }
    }
}
