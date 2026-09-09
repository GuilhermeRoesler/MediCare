<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../app/Core/Validator.php';

final class ValidatorTest extends TestCase
{
    public function testEmailValidation(): void
    {
        $this->assertTrue(Validator::email('admin@medicare.com'));
        $this->assertFalse(Validator::email('invalido'));
    }

    public function testCpfRequiresElevenDigits(): void
    {
        $this->assertTrue(Validator::cpf('529.982.247-25'));
        $this->assertFalse(Validator::cpf('111.111.111-11'));
        $this->assertFalse(Validator::cpf('123'));
    }

    public function testDatetimeRange(): void
    {
        $this->assertTrue(Validator::datetimeRange('2026-01-01 10:00', '2026-01-01 11:00'));
        $this->assertFalse(Validator::datetimeRange('2026-01-01 11:00', '2026-01-01 10:00'));
    }

    public function testInListAndPositiveInt(): void
    {
        $this->assertTrue(Validator::inList('pago', ['pago', 'pendente']));
        $this->assertSame(3, Validator::positiveInt('3'));
        $this->assertNull(Validator::positiveInt('0'));
    }
}
