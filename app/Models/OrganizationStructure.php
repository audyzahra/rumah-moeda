<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationStructure extends Model
{
    use HasFactory;

    protected $table = 'organization_structures';

    protected $fillable = [
        'full_name',
        'position',
        'photo',
        'display_order',
        'description',
    ];
}
