<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PortfolioMedia extends Model
{
    use HasFactory;

    protected $fillable = [
        'portfolio_id',
        'type',
        'file_path',
        'video_url',
        'display_order',
    ];

    public function portfolio()
    {
        return $this->belongsTo(Portfolio::class);
    }
}
