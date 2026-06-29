<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidNik implements ValidationRule
{
    /**
     * Province keys follow nusantara-valid's NIK province validation.
     *
     * @var array<int, string>
     */
    private const PROVINCE_KEYS = [
        '11', '12', '13', '14', '15', '16', '17', '18', '19', '21',
        '31', '32', '33', '34', '35', '36',
        '51', '52', '53',
        '61', '62', '63', '64', '65',
        '71', '72', '73', '74', '75', '76',
        '81', '82', '91', '92',
    ];

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! self::passes((string) $value)) {
            $fail('NIK tidak valid. Pastikan NIK terdiri dari 16 digit dan sesuai format kependudukan Indonesia.');
        }
    }

    public static function normalize(?string $nik): string
    {
        return preg_replace('/\D/', '', (string) $nik) ?? '';
    }

    public static function passes(?string $nik): bool
    {
        $nik = self::normalize($nik);

        if (! preg_match('/^(\d{2})(\d{2})(\d{2})(\d{6})(\d{4})$/', $nik, $matches)) {
            return false;
        }

        if (! in_array($matches[1], self::PROVINCE_KEYS, true)) {
            return false;
        }

        return self::hasValidBirthday($matches[4]);
    }

    private static function hasValidBirthday(string $birthday): bool
    {
        if (! preg_match('/^(\d{2})(\d{2})(\d{2})$/', $birthday, $matches)) {
            return false;
        }

        $day = (int) $matches[1];
        $month = (int) $matches[2];
        $year = (int) $matches[3];

        if ($day > 40) {
            $day -= 40;
        }

        return checkdate($month, $day, 1900 + $year);
    }
}
