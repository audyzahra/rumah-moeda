<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $primaryKey = 'setting_id';

    protected $fillable = [
        'website_name',
        'website_logo',
        'website_description',
        'hero_image',
        'phone_number',
        'email',
        'fax_number',
        'address',
        'instagram_url',
        'facebook_url',
        'tiktok_url',
    ];
}
