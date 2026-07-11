<?php

declare(strict_types=1);

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * Validates a 15-character Indian GSTIN, including the mod-36 check digit.
 *
 * Format: 2-digit state code + 10-char PAN + 1 entity code + 'Z' + 1 checksum.
 * The checksum uses the GSTN algorithm over the alphanumeric set 0-9A-Z
 * (base 36) with alternating weights 1,2,1,2… and a "sum of quotient and
 * remainder" fold, mirroring the official implementation.
 */
class ValidGstin implements ValidationRule
{
    private const CHARSET = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $gstin = strtoupper(trim((string) $value));

        // Structural pattern check.
        if (! preg_match('/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[0-9A-Z]{1}Z[0-9A-Z]{1}$/', $gstin)) {
            $fail('The :attribute is not a valid GSTIN format.');

            return;
        }

        if (! $this->checksumValid($gstin)) {
            $fail('The :attribute has an invalid GSTIN checksum.');
        }
    }

    private function checksumValid(string $gstin): bool
    {
        $factor = 2;
        $sum = 0;
        $mod = strlen(self::CHARSET); // 36

        // Iterate the first 14 chars right-to-left, weights alternate 2,1,2,1…
        for ($i = 13; $i >= 0; $i--) {
            $code = strpos(self::CHARSET, $gstin[$i]);
            if ($code === false) {
                return false;
            }

            $digit = $factor * $code;
            $factor = ($factor === 2) ? 1 : 2;
            $digit = intdiv($digit, $mod) + ($digit % $mod);
            $sum += $digit;
        }

        $checkCode = ($mod - ($sum % $mod)) % $mod;
        $expected = self::CHARSET[$checkCode];

        return $gstin[14] === $expected;
    }
}
