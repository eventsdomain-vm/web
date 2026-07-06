<?php

declare(strict_types=1);

namespace App\Services\Gst;

use App\Rules\ValidGstin;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

/* *
 * Verifies a GSTIN in two stages: (1) local mod-36 checksum via ValidGstin,
 * then (2) a live lookup against a configurable provider (default:
 * gstincheck.co.in). Network failures never throw to the caller — they return
 * a structured result with `verified => false` and a reason, so the UI can
 * fall back to "format valid, not yet confirmed".
 */
class GstVerifier
{
    /**
     * @return array{
     *   format_valid: bool,
     *   verified: bool,
     *   legal_name: ?string,
     *   status: ?string,
     *   reason: ?string,
     *   raw: array
     * }
     */
    public function verify(string $gstin): array
    {
        $gstin = strtoupper(trim($gstin));

        $formatValid = $this->formatValid($gstin);

        $result = [
            'format_valid' => $formatValid,
            'verified' => false,
            'legal_name' => null,
            'status' => null,
            'reason' => null,
            'raw' => [],
        ];

        if (! $formatValid) {
            $result['reason'] = 'Invalid GSTIN format or checksum.';

            return $result;
        }

        $provider = (string) config('services.gst.provider', 'gstincheck');
        $key = config('services.gst.key');

        if (empty($key)) {
            $result['reason'] = 'GST API not configured — format valid but not confirmed.';

            return $result;
        }

        try {
            return match ($provider) {
                'gstincheck' => $this->viaGstinCheck($gstin, $result),
                default => array_merge($result, ['reason' => "Unknown GST provider [{$provider}]."]),
            };
        } catch (\Throwable $e) {
            Log::warning('GST verification failed', ['gstin' => $gstin, 'error' => $e->getMessage()]);
            $result['reason'] = 'GST verification service unavailable.';

            return $result;
        }
    }

    private function formatValid(string $gstin): bool
    {
        return Validator::make(
            ['gstin' => $gstin],
            ['gstin' => [new ValidGstin]],
        )->passes();
    }

    /**
     * GSTINCheck: GET {base}/check/{key}/{gstin}
     * On success returns { flag: true, data: { lgnm, sts, tradeNam, ... } }.
     */
    private function viaGstinCheck(string $gstin, array $result): array
    {
        $base = rtrim((string) config('services.gst.base_url', 'https://sheet.gstincheck.co.in'), '/');
        $key = config('services.gst.key');

        $response = Http::timeout(10)->get("{$base}/check/{$key}/{$gstin}");

        $data = $response->json() ?? [];
        $result['raw'] = $data;

        if (! ($data['flag'] ?? false) || ! $response->successful()) {
            $result['reason'] = $data['message'] ?? 'GSTIN not found or inactive.';

            return $result;
        }

        $info = $data['data'] ?? [];
        $status = $info['sts'] ?? null;

        $result['legal_name'] = $info['lgnm'] ?? ($info['tradeNam'] ?? null);
        $result['status'] = $status;
        $result['verified'] = is_string($status)
            ? strtolower($status) === 'active'
            : ! empty($result['legal_name']);

        if (! $result['verified'] && ! $result['reason']) {
            $result['reason'] = 'GSTIN found but not active.';
        }

        return $result;
    }
}
