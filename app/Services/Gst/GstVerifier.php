<?php

declare(strict_types=1);

namespace App\Services\Gst;

use App\Rules\ValidGstin;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

/* *
 * Verifies a GSTIN in two stages: (1) local mod-36 checksum via ValidGstin,
 * then (2) a live lookup against a configurable provider (default:
 * gstincheck.co.in). Network failures never throw to the caller — they return
 * a structured result with `verified => false` and a reason, so the UI can
 * fall back to "format valid, not yet confirmed".
 *
 * Provider `gstverify` uses a captcha-based flow proxied from the GST portal
 * (services.gst.gov.in). Call fetchCaptchaData() first, show the image to the
 * user, then call verifyWithCaptcha() with the user-supplied captcha text.
 */
class GstVerifier
{
    private const GST_PORTAL = 'https://services.gst.gov.in';

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

        if (empty($key) && $provider !== 'gstverify') {
            $result['reason'] = 'GST API not configured — format valid but not confirmed.';

            return $result;
        }

        try {
            return match ($provider) {
                'gstincheck' => $this->viaGstinCheck($gstin, $result),
                'gstverify' => array_merge($result, [
                    'reason' => 'Captcha verification required — use the Verify Now button.',
                ]),
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

    /**
     * Fetch a captcha image from the GST portal.
     *
     * @return array{ session_id: string, image: string }
     */
    public function fetchCaptchaData(): array
    {
        $client = new Client(['cookies' => new CookieJar, 'timeout' => 15]);

        $client->get(self::GST_PORTAL . '/services/searchtp');

        $captchaResponse = $client->get(self::GST_PORTAL . '/services/captcha');
        $imageBase64 = base64_encode((string) $captchaResponse->getBody());

        $cookieJar = $client->getConfig('cookies');
        $sessionId = (string) Str::uuid();
        Cache::put('gst_session_' . $sessionId, $cookieJar, now()->addMinutes(5));

        return [
            'session_id' => $sessionId,
            'image' => 'data:image/png;base64,' . $imageBase64,
        ];
    }

    /**
     * Submit GSTIN + captcha to the GST portal for verification.
     *
     * @return array{
     *   verified: bool,
     *   legal_name: ?string,
     *   status: ?string,
     *   reason: ?string,
     *   raw: array
     * }
     */
    public function verifyWithCaptcha(string $gstin, string $sessionId, string $captcha): array
    {
        $cacheKey = 'gst_session_' . $sessionId;
        $cookieJar = Cache::get($cacheKey);

        if (! $cookieJar instanceof CookieJar) {
            return [
                'verified' => false,
                'legal_name' => null,
                'status' => null,
                'reason' => 'Session expired or invalid. Please refresh the captcha and try again.',
                'raw' => [],
            ];
        }

        Cache::forget($cacheKey);

        try {
            $client = new Client(['cookies' => $cookieJar, 'timeout' => 15]);

            $response = $client->post(self::GST_PORTAL . '/services/api/search/taxpayerDetails', [
                'json' => [
                    'gstin' => $gstin,
                    'captcha' => $captcha,
                ],
            ]);

            $data = json_decode((string) $response->getBody(), true) ?? [];

            $status = $data['sts'] ?? null;
            $legalName = $data['lgnm'] ?? null;

            return [
                'verified' => $status !== null && strtolower($status) === 'active',
                'legal_name' => $legalName,
                'status' => $status,
                'reason' => $status === null ? 'Could not retrieve GST details. Check captcha and try again.' : null,
                'raw' => $data,
            ];
        } catch (\Throwable $e) {
            Log::warning('GST captcha verification failed', [
                'gstin' => $gstin,
                'error' => $e->getMessage(),
            ]);

            return [
                'verified' => false,
                'legal_name' => null,
                'status' => null,
                'reason' => 'GST verification service unavailable.',
                'raw' => [],
            ];
        }
    }
}
