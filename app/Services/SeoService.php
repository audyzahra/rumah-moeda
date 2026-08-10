<?php

namespace App\Services;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class SeoService
{
    /**
     * Generate SEO berdasarkan route, setting,
     * dan data dari database.
     */
    public function generate($setting, $data = null): array
    {
        $routeName = Route::currentRouteName();

        $websiteName = $setting?->website_name ?? 'Rumah Moeda';

        $defaultDescription = Str::limit(
            strip_tags(
                $setting?->website_description
                    ?? 'Website resmi Rumah Moeda yang menyediakan informasi mengenai kegiatan, berita, galeri, dan portfolio.'
            ),
            160
        );

        $defaultKeywords =
            'Rumah Moeda, kegiatan sosial, berita, portfolio, galeri, purwakarta, indonesia, organisasi, yayasan, program sosial, kolaborasi, kemitraan';


        /*
        |--------------------------------------------------------------------------
        | SEO berdasarkan route
        |--------------------------------------------------------------------------
        */

        return match ($routeName) {

            /*
            |--------------------------------------------------------------------------
            | Home
            |--------------------------------------------------------------------------
            */

            'home' => [
                'title' => $websiteName,

                'description' => $defaultDescription,

                'keywords' => $defaultKeywords,
            ],


            /*
            |--------------------------------------------------------------------------
            | About
            |--------------------------------------------------------------------------
            */

            'about' => [
                'title' => 'Tentang Kami | ' . $websiteName,

                'description' =>
                    'Kenali ' . $websiteName .
                    ', organisasi yang bergerak dalam bidang multimedia, perfilman, pendidikan, dan pemberdayaan generasi muda.',

                'keywords' =>
                    'Tentang Rumah Moeda, profil Rumah Moeda, multimedia, perfilman, pendidikan, pemberdayaan generasi muda',
            ],


            /*
            |--------------------------------------------------------------------------
            | Contact
            |--------------------------------------------------------------------------
            */

            'contact' => [
                'title' => 'Hubungi Kami | ' . $websiteName,

                'description' =>
                    'Hubungi ' . $websiteName .
                    ' untuk informasi mengenai program, kerja sama, kemitraan, layanan multimedia, maupun pertanyaan lainnya. Kami siap membantu dan menjalin kolaborasi dengan berbagai pihak.',

                'keywords' =>
                    'Hubungi Rumah Moeda, kontak Rumah Moeda, kerja sama, kemitraan, multimedia, perfilman, pendidikan, kolaborasi',
            ],


            /*
            |--------------------------------------------------------------------------
            | News Index
            |--------------------------------------------------------------------------
            */

            'news.index' => [
                'title' => 'Berita | ' . $websiteName,

                'description' =>
                    'Baca berita dan informasi terbaru mengenai kegiatan, program, dan berbagai aktivitas ' .
                    $websiteName . '.',

                'keywords' =>
                    'berita Rumah Moeda, kegiatan Rumah Moeda, informasi Rumah Moeda, berita kegiatan',
            ],


            /*
            |--------------------------------------------------------------------------
            | News Detail
            |--------------------------------------------------------------------------
            */

            'news.show' => $this->newsSeo($data, $websiteName),


            /*
            |--------------------------------------------------------------------------
            | Portfolio Index
            |--------------------------------------------------------------------------
            */

            'portfolio.index' => [
                'title' => 'Portfolio | ' . $websiteName,

                'description' =>
                    'Lihat berbagai portfolio, kegiatan, kolaborasi, dan karya yang telah dilakukan bersama ' .
                    $websiteName . '.',

                'keywords' =>
                    'portfolio Rumah Moeda, karya Rumah Moeda, kolaborasi, kegiatan Rumah Moeda',
            ],


            /*
            |--------------------------------------------------------------------------
            | Portfolio Detail
            |--------------------------------------------------------------------------
            */

            'portfolio.show' => $this->portfolioSeo($data, $websiteName),


            /*
            |--------------------------------------------------------------------------
            | Gallery Photos
            |--------------------------------------------------------------------------
            */

            'gallery.photos' => [
                'title' => 'Galeri Foto | ' . $websiteName,

                'description' =>
                    'Lihat dokumentasi foto kegiatan dan berbagai aktivitas ' .
                    $websiteName . '.',

                'keywords' =>
                    'galeri foto Rumah Moeda, dokumentasi Rumah Moeda, foto kegiatan, kegiatan sosial',
            ],


            /*
            |--------------------------------------------------------------------------
            | Gallery Videos
            |--------------------------------------------------------------------------
            */

            'gallery.videos' => [
                'title' => 'Galeri Video | ' . $websiteName,

                'description' =>
                    'Tonton berbagai dokumentasi video kegiatan, program, dan aktivitas ' .
                    $websiteName . '.',

                'keywords' =>
                    'galeri video Rumah Moeda, video Rumah Moeda, dokumentasi video, kegiatan Rumah Moeda',
            ],


            /*
            |--------------------------------------------------------------------------
            | Gallery Photo Detail
            |--------------------------------------------------------------------------
            */

            'gallery.photos.detail' => $this->gallerySeo(
                $data,
                $websiteName,
                'Foto'
            ),


            /*
            |--------------------------------------------------------------------------
            | Gallery Video Detail
            |--------------------------------------------------------------------------
            */

            'gallery.videos.detail' => $this->gallerySeo(
                $data,
                $websiteName,
                'Video'
            ),


            /*
            |--------------------------------------------------------------------------
            | FAQ
            |--------------------------------------------------------------------------
            */

            'faq.index' => [
                'title' => 'FAQ | ' . $websiteName,

                'description' =>
                    'Temukan jawaban atas pertanyaan yang sering diajukan mengenai ' .
                    $websiteName . ', program, layanan, dan kegiatan yang tersedia.',

                'keywords' =>
                    'FAQ Rumah Moeda, pertanyaan Rumah Moeda, informasi Rumah Moeda',
            ],


            /*
            |--------------------------------------------------------------------------
            | Default
            |--------------------------------------------------------------------------
            */

            default => [
                'title' => $websiteName,

                'description' => $defaultDescription,

                'keywords' => $defaultKeywords,
            ],
        };
    }


    /**
     * SEO untuk detail berita.
     */
    private function newsSeo($news, string $websiteName): array
    {
        if (!$news) {
            return [
                'title' => 'Berita | ' . $websiteName,

                'description' =>
                    'Berita dan informasi terbaru dari ' .
                    $websiteName . '.',

                'keywords' =>
                    'berita Rumah Moeda, kegiatan Rumah Moeda',
            ];
        }

        $title = $news->title ?? 'Berita';

        $description = Str::limit(
            strip_tags(
                $news->excerpt
                    ?? $news->content
                    ?? $news->description
                    ?? ''
            ),
            160
        );

        $keywords = 'Rumah Moeda, berita, ' . $title;

        if (!empty($news->category?->name)) {
            $keywords .= ', ' . $news->category->name;
        }

        return [
            'title' => $title . ' | ' . $websiteName,

            'description' => $description,

            'keywords' => $keywords,
        ];
    }


    /**
     * SEO untuk detail portfolio.
     */
    private function portfolioSeo($portfolio, string $websiteName): array
    {
        if (!$portfolio) {
            return [
                'title' => 'Portfolio | ' . $websiteName,

                'description' =>
                    'Portfolio dan karya ' . $websiteName . '.',

                'keywords' =>
                    'portfolio Rumah Moeda, karya Rumah Moeda',
            ];
        }

        $title = $portfolio->title ?? 'Portfolio';

        $description = Str::limit(
            strip_tags(
                $portfolio->excerpt
                    ?? $portfolio->description
                    ?? ''
            ),
            160
        );

        $keywords = 'Rumah Moeda, portfolio, ' . $title;

        if (!empty($portfolio->category?->name)) {
            $keywords .= ', ' . $portfolio->category->name;
        }

        return [
            'title' => $title . ' | ' . $websiteName,

            'description' => $description,

            'keywords' => $keywords,
        ];
    }


    /**
     * SEO untuk detail gallery.
     */
    private function gallerySeo(
        $gallery,
        string $websiteName,
        string $type
    ): array {
        if (!$gallery) {
            return [
                'title' => 'Galeri ' . $type . ' | ' . $websiteName,

                'description' =>
                    'Dokumentasi ' . strtolower($type) .
                    ' kegiatan ' . $websiteName . '.',

                'keywords' =>
                    'galeri ' . strtolower($type) .
                    ' Rumah Moeda, dokumentasi, kegiatan Rumah Moeda',
            ];
        }

        $title = $gallery->title ?? 'Galeri ' . $type;

        $description = Str::limit(
            strip_tags(
                $gallery->description ?? ''
            ),
            160
        );

        if (empty($description)) {
            $description =
                'Dokumentasi ' . strtolower($type) .
                ' kegiatan ' . $websiteName . '.';
        }

        return [
            'title' => $title . ' | ' . $websiteName,

            'description' => $description,

            'keywords' =>
                'galeri ' . strtolower($type) .
                ', Rumah Moeda, dokumentasi, kegiatan',
        ];
    }
}
