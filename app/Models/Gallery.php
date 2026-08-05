<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\GalleryMedia;
use Illuminate\Support\Str;

class Gallery extends Model
{
    protected $table = 'galleries';

    protected $fillable = [
        'title',
        'slug',
        'description',
        'activity_date',
        'author_id',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function media()
    {
        return $this->hasMany(GalleryMedia::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($gallery) {
            $gallery->slug = Str::slug($gallery->title);
        });

        static::updating(function ($gallery) {
            $gallery->slug = Str::slug($gallery->title);
        });
    }
}
