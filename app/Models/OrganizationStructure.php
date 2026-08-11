<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class OrganizationStructure extends Model
{
    use HasFactory;

    protected $appends = [
        'photo_url',
    ];

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
        if ($this->photo && Storage::disk('public')->exists($this->photo)) {
            return Storage::disk('public')->url($this->photo);
        }

        return defaultImage('default-user');
    }
}
