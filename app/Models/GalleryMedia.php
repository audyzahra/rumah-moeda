<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryMedia extends Model
{
    protected $fillable = [
        'gallery_id',
        'type',
        'file_path',
        'video_url',
    ];

    public function gallery()
    {
        return $this->belongsTo(Gallery::class);
    }

    public function getYoutubeIdAttribute()
    {
        preg_match(
            '/(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([^&\n?#]+)/',
            $this->video_url,
            $matches
        );

        return $matches[1] ?? '';
    }
}