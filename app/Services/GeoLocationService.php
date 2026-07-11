<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeoLocationService
{
    private const API_URL = 'http://ip-api.com/json/{ip}?fields=status,message,country,countryCode,region,regionName,city,zip,lat,lon,timezone,isp,org,as,mobile,proxy,hosting';

    private const INDIA_STATES = [
        'Andhra Pradesh' => 'AP', 'Arunachal Pradesh' => 'AR', 'Assam' => 'AS',
        'Bihar' => 'BR', 'Chhattisgarh' => 'CG', 'Goa' => 'GA', 'Gujarat' => 'GJ',
        'Haryana' => 'HR', 'Himachal Pradesh' => 'HP', 'Jharkhand' => 'JH',
        'Karnataka' => 'KA', 'Kerala' => 'KL', 'Madhya Pradesh' => 'MP',
        'Maharashtra' => 'MH', 'Manipur' => 'MN', 'Meghalaya' => 'ML',
        'Mizoram' => 'MZ', 'Nagaland' => 'NL', 'Odisha' => 'OD',
        'Punjab' => 'PB', 'Rajasthan' => 'RJ', 'Sikkim' => 'SK',
        'Tamil Nadu' => 'TN', 'Telangana' => 'TS', 'Tripura' => 'TR',
        'Uttar Pradesh' => 'UP', 'Uttarakhand' => 'UK', 'West Bengal' => 'WB',
        'Delhi' => 'DL', 'Jammu and Kashmir' => 'JK', 'Ladakh' => 'LA',
        'Puducherry' => 'PY', 'Chandigarh' => 'CH', 'Dadra and Nagar Haveli' => 'DH',
        'Daman and Diu' => 'DD', 'Lakshadweep' => 'LD', 'Andaman and Nicobar Islands' => 'AN',
    ];

    public function getLocation(string $ip): ?array
    {
        if (in_array($ip, ['127.0.0.1', '::1', 'localhost', ''])) {
            return $this->getDefaultLocation();
        }

        $cacheKey = "geo_{$ip}";

        return Cache::remember($cacheKey, 86400 * 30, function () use ($ip) {
            try {
                $response = Http::timeout(5)->get(str_replace('{ip}', $ip, self::API_URL));

                if ($response->successful() && $response->json('status') === 'success') {
                    $data = $response->json();

                    return [
                        'country' => $data['country'] ?? 'Unknown',
                        'country_code' => $data['countryCode'] ?? '',
                        'state' => $data['regionName'] ?? '',
                        'state_code' => $data['region'] ?? '',
                        'city' => $data['city'] ?? '',
                        'zipcode' => $data['zip'] ?? '',
                        'latitude' => $data['lat'] ?? null,
                        'longitude' => $data['lon'] ?? null,
                        'timezone' => $data['timezone'] ?? '',
                        'isp' => $data['isp'] ?? '',
                        'org' => $data['org'] ?? '',
                        'is_mobile' => $data['mobile'] ?? false,
                        'is_proxy' => $data['proxy'] ?? false,
                        'is_hosting' => $data['hosting'] ?? false,
                    ];
                }
            } catch (\Exception $e) {
                Log::warning("Geo lookup failed for IP {$ip}: " . $e->getMessage());
            }

            return null;
        });
    }

    public function getDefaultLocation(): array
    {
        return [
            'country' => 'India',
            'country_code' => 'IN',
            'state' => 'Maharashtra',
            'state_code' => 'MH',
            'city' => 'Mumbai',
            'zipcode' => '400001',
            'latitude' => 19.0760,
            'longitude' => 72.8777,
            'timezone' => 'Asia/Kolkata',
            'isp' => 'Local',
            'org' => 'Local',
            'is_mobile' => false,
            'is_proxy' => false,
            'is_hosting' => false,
        ];
    }

    public function getIndiaStates(): array
    {
        return self::INDIA_STATES;
    }

    public function getVisitorGeoStats(): array
    {
        $sessions = DB::table('sessions')
            ->whereNotNull('ip_address')
            ->where('ip_address', '!=', '')
            ->get();

        $stats = [
            'total_visitors' => $sessions->count(),
            'countries' => [],
            'states' => [],
            'cities' => [],
            'zipcodes' => [],
            'mobile_vs_desktop' => ['mobile' => 0, 'desktop' => 0, 'tablet' => 0],
            'isps' => [],
        ];

        foreach ($sessions as $session) {
            $geo = $this->getLocation($session->ip_address);

            if (! $geo) {
                continue;
            }

            // Country
            $country = $geo['country'] ?? 'Unknown';
            $stats['countries'][$country] = ($stats['countries'][$country] ?? 0) + 1;

            // State (India focus)
            if (strtoupper($geo['country_code'] ?? '') === 'IN') {
                $state = $geo['state'] ?? 'Unknown';
                $stats['states'][$state] = ($stats['states'][$state] ?? 0) + 1;

                $city = $geo['city'] ?? 'Unknown';
                $stats['cities'][$city] = ($stats['cities'][$city] ?? 0) + 1;

                $zipcode = $geo['zipcode'] ?? '';
                if ($zipcode) {
                    $stats['zipcodes'][$zipcode] = ($stats['zipcodes'][$zipcode] ?? 0) + 1;
                }
            }

            // Device type
            $ua = strtolower($session->user_agent ?? '');
            if (str_contains($ua, 'mobile') || str_contains($ua, 'android') || str_contains($ua, 'iphone')) {
                $stats['mobile_vs_desktop']['mobile']++;
            } elseif (str_contains($ua, 'tablet') || str_contains($ua, 'ipad')) {
                $stats['mobile_vs_desktop']['tablet']++;
            } else {
                $stats['mobile_vs_desktop']['desktop']++;
            }

            // ISP
            $isp = $geo['isp'] ?? 'Unknown';
            $stats['isps'][$isp] = ($stats['isps'][$isp] ?? 0) + 1;
        }

        // Sort by count
        arsort($stats['countries']);
        arsort($stats['states']);
        arsort($stats['cities']);
        arsort($stats['zipcodes']);
        arsort($stats['isps']);

        return $stats;
    }
}
