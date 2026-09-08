<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../app/Core/Auth.php';
require_once __DIR__ . '/../app/Core/Csrf.php';

final class AuthTest extends TestCase
{
    protected function setUp(): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_unset();
        }
        $_SESSION = [];
    }

    public function testCheckReturnsFalseWhenNotLoggedIn(): void
    {
        $this->assertFalse(Auth::check());
    }

    public function testLoginStoresSessionData(): void
    {
        Auth::login([
            'id' => 7,
            'nome' => 'Administrador',
            'perfil' => 'admin',
        ]);

        $this->assertTrue(Auth::check());
        $this->assertSame(7, Auth::id());
        $this->assertSame('Administrador', Auth::nome());
        $this->assertSame('admin', Auth::perfil());
        $this->assertTrue(Auth::isAdmin());
        $this->assertSame('Admin', Auth::perfilLabel());
    }

    public function testRecepcaoProfileLabel(): void
    {
        Auth::login([
            'id' => 2,
            'nome' => 'Ana',
            'perfil' => 'recepcao',
        ]);

        $this->assertSame('Recepção', Auth::perfilLabel());
        $this->assertFalse(Auth::isAdmin());
    }
}
