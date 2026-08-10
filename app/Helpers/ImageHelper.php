<?php

if (!function_exists('defaultImage')) {

    function defaultImage($type = 'photo')
    {
        return match ($type) {

            'video' => asset('assets/images/video-default.jpg'),

            'logo' => asset('assets/images/logo-default.png'),

            'hero' => asset('assets/images/hero-default.jpg'),

            default => asset('assets/images/foto-default.jpg'),

        };
    }

}
