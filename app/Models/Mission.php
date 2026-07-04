<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mission extends Model
{
    use HasFactory;

    protected $table = 'missions';

    protected $fillable = [
        'vision_mission_id',
        'mission',
        'display_order'
    ];

    public function visionMission()
    {
        return $this->belongsTo(VisionMission::class, 'vision_mission_id', 'id');
    }
}
