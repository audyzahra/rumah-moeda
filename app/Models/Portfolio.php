<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

class Portfolio extends Model
{
    use HasFactory;

    protected $fillable = [
        'partner_id',
        'category_id',
        'author_id',
        'title',
        'slug',
        'description',
        'activity_date',
        'location',
        'participants',
        'views',
        'location',
        'latitude',
        'longitude',
    ];

    protected $casts = [
        'activity_date' => 'date',
    ];

    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    public function category()
    {
        return $this->belongsTo(PortfolioCategory::class, 'category_id');
    }

    public function media()
    {
        return $this->hasMany(PortfolioMedia::class);
    }
    public function thumbnail()
    {
        return $this->hasOne(PortfolioMedia::class)
            ->where('type', 'image')
            ->orderBy('display_order');
    }
    public function author()
    {
        return $this->belongsTo(User::class);
    }
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
