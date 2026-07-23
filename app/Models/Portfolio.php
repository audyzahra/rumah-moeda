<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Portfolio extends Model
{
    use HasFactory;

    protected $fillable = [
        'partner_id',
        'category_id',
        'title',
        'description',
        'activity_date',
        'location',
        'participants',
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
}
