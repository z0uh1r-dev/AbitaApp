<?php

namespace App\Services;

/**
 * Lightweight, dependency-free User-Agent parser.
 *
 * Covers the handful of browsers/platforms realistically used by a ~5-person
 * internal team. Not a general-purpose UA database — good enough for a
 * best-effort audit-log field, not worth pulling in an external package for.
 */
class UserAgentParser
{
    /**
     * @return array{browser: string, platform: string}
     */
    public static function parse(?string $userAgent): array
    {
        $ua = $userAgent ?? '';

        return [
            'browser' => self::detectBrowser($ua),
            'platform' => self::detectPlatform($ua),
        ];
    }

    private static function detectBrowser(string $ua): string
    {
        if ($ua === '') {
            return 'Unknown';
        }

        return match (true) {
            (bool) preg_match('/Edg\//i', $ua) => 'Edge',
            (bool) preg_match('/OPR\/|Opera/i', $ua) => 'Opera',
            (bool) preg_match('/Firefox\//i', $ua) => 'Firefox',
            (bool) preg_match('/Chrome\//i', $ua) && ! str_contains($ua, 'Chromium') => 'Chrome',
            (bool) preg_match('/CriOS\//i', $ua) => 'Chrome (iOS)',
            (bool) preg_match('/Safari\//i', $ua) && str_contains($ua, 'Version/') => 'Safari',
            default => 'Unknown',
        };
    }

    private static function detectPlatform(string $ua): string
    {
        if ($ua === '') {
            return 'Unknown';
        }

        return match (true) {
            (bool) preg_match('/iPhone|iPad|iPod/i', $ua) => 'iOS',
            (bool) preg_match('/Android/i', $ua) => 'Android',
            (bool) preg_match('/Mac OS X/i', $ua) => 'macOS',
            (bool) preg_match('/Windows/i', $ua) => 'Windows',
            (bool) preg_match('/Linux/i', $ua) => 'Linux',
            default => 'Unknown',
        };
    }
}
