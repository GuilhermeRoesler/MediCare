<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../app/Core/Auth.php';
require_once __DIR__ . '/../app/Core/Csrf.php';

final class CsrfTest extends TestCase
{
    protected function setUp(): void
    {
        $_SESSION = [];
        $_POST = [];
    }

    public function testTokenIsGeneratedAndStable(): void
    {
        $tokenA = Csrf::token();
        $tokenB = Csrf::token();

        $this->assertNotSame('', $tokenA);
        $this->assertSame($tokenA, $tokenB);
        $this->assertSame(64, strlen($tokenA));
    }

    public function testFieldContainsHiddenInput(): void
    {
        $html = Csrf::field();
        $this->assertStringContainsString('type="hidden"', $html);
        $this->assertStringContainsString('name="_csrf"', $html);
        $this->assertStringContainsString(Csrf::token(), $html);
    }

    public function testValidateAcceptsMatchingToken(): void
    {
        $token = Csrf::token();
        $_POST['_csrf'] = $token;

        Csrf::validate();
        $this->assertTrue(true);
    }
}
