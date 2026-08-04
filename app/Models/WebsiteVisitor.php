<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebsiteVisitor extends Model
{
    protected $fillable = [

        'ip_address',
        'user_agent',
        'visit_date'

    ];
}
