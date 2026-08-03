<?php

namespace App\Services;

use App\Services\Security\DangerousInputException;
use App\Services\Security\PatternList;
use Mews\Purifier\Facades\Purifier;
use voku\helper\AntiXSS;

class SecurityInputService
{
    protected AntiXSS $antiXss;

    public function __construct()
    {
        $this->antiXss = new AntiXSS();
    }

    /**
     * Mengecek pola berbahaya.
     */
    public function containsDangerousPattern(string $input): bool
    {
        foreach (PatternList::dangerousPatterns() as $pattern) {
            if (preg_match($pattern, $input)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Text biasa.
     */
    public function cleanText(?string $input): string
    {
        if ($input === null) {
            return '';
        }

        $input = trim($input);

        if ($this->containsDangerousPattern($input)) {
            throw new DangerousInputException(
                'Input mengandung karakter atau kode yang tidak diperbolehkan.'
            );
        }

        $input = strip_tags($input);

        return $this->antiXss->xss_clean($input);
    }

    /**
     * Rich Text (Tiptap)
     */
    public function cleanHtml(?string $html): string
{
    if ($html === null) {
        return '';
    }

    $html = trim($html);

    // Tolak apabila ditemukan pola berbahaya
    if ($this->containsDangerousPattern($html)) {
        throw new DangerousInputException(
            'Input mengandung kode atau karakter yang tidak diperbolehkan.'
        );
    }

    return trim(Purifier::clean($html, 'default'));
}

    /**
     * URL.
     */
    public function cleanUrl(?string $url): ?string
    {
        if (empty($url)) {
            return null;
        }

        $url = trim($url);

        if ($this->containsDangerousPattern($url)) {
            throw new DangerousInputException(
                'URL mengandung karakter yang tidak diperbolehkan.'
            );
        }

        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new DangerousInputException(
                'URL tidak valid.'
            );
        }

        return $url;
    }

    /**
     * Integer.
     */
    public function cleanInteger($number): int
    {
        if (!is_numeric($number)) {
            throw new DangerousInputException(
                'Input harus berupa angka.'
            );
        }

        return (int) $number;
    }
}
