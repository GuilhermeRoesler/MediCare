<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../app/Core/Auth.php';
require_once __DIR__ . '/../app/Core/Flash.php';

final class FlashTest extends TestCase
{
    protected function setUp(): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_unset();
        }
        $_SESSION = [];
    }

    public function testFlashIsConsumedOnce(): void
    {
        Flash::success('Salvo');
        $first = Flash::get();
        $second = Flash::get();

        $this->assertSame('success', $first['type']);
        $this->assertSame('Salvo', $first['message']);
        $this->assertNull($second);
    }
}
