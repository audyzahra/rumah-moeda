<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\GalleryMedia;

class Gallery extends Model
{
    protected $table = 'galleries';

    protected $fillable = [
        'title',
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
}
