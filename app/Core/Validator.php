<?php

declare(strict_types=1);

class Validator
{
    public static function required(string ...$values): bool
    {
        foreach ($values as $value) {
            if (trim($value) === '') {
                return false;
            }
        }

        return true;
    }

    public static function email(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    public static function cpf(string $cpf): bool
    {
        $digits = preg_replace('/\D+/', '', $cpf) ?? '';

        if (strlen($digits) !== 11 || preg_match('/^(\d)\1{10}$/', $digits)) {
            return false;
        }

        return true;
    }

    public static function inList(string $value, array $allowed): bool
    {
        return in_array($value, $allowed, true);
    }

    public static function positiveInt(mixed $value): ?int
    {
        if (!is_numeric($value)) {
            return null;
        }

        $int = (int) $value;
        return $int > 0 ? $int : null;
    }

    public static function nonNegativeNumber(mixed $value): ?float
    {
        if (!is_numeric($value)) {
            return null;
        }

        $number = (float) $value;
        return $number >= 0 ? $number : null;
    }

    public static function datetimeRange(string $inicio, string $fim): bool
    {
        $start = strtotime($inicio);
        $end = strtotime($fim);

        return $start !== false && $end !== false && $start < $end;
    }

    public static function dateOrder(string $inicio, string $fim): bool
    {
        $start = strtotime($inicio);
        $end = strtotime($fim);

        return $start !== false && $end !== false && $start <= $end;
    }
}
