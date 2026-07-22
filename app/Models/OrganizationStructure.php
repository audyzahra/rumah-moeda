<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationStructure extends Model
{
    use HasFactory;

    protected $table = 'organization_structures';

    protected $fillable = [
        'parent_id',
        'full_name',
        'position',
        'photo',
        'description',
    ];

    /**
     * Relasi ke atasan (parent)
     */
    public function parent()
    {
        return $this->belongsTo(
            OrganizationStructure::class,
            'parent_id'
        );
    }

    /**
     * Relasi ke bawahan (children)
     */
    public function children()
    {
        return $this->hasMany(
            OrganizationStructure::class,
            'parent_id'
        );
    }

    public function childrenRecursive()
    {
        return $this->children()->with('childrenRecursive');
    }

    public function getDescendantIds()
    {
        $ids = [];

        foreach ($this->children as $child) {
            $ids[] = $child->id;
            $ids = array_merge($ids, $child->getDescendantIds());
        }

        return $ids;
    }

    public function descendants()
{
    return $this->children()->with('descendants');
}

    public function getPhotoUrlAttribute()
    {
        return $this->photo
            ? asset('storage/' . $this->photo)
            : asset('images/default-user.png');
    }
}
