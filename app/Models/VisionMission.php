<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VisionMission extends Model
{
    use HasFactory;

    protected $table = 'vision_missions';

    protected $fillable = [
        'vision'
    ];

    public function missions()
    {
        return $this->hasMany(Mission::class, 'vision_mission_id', 'id')
                    ->orderBy('display_order');
    }
}
