<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\ContactMessage;
use Illuminate\Contracts\Auth\MustVerifyEmail;

#[Fillable([
    'name',
    'email',
    'password',
    'role',
    'status'
])]

#[Hidden([
    'password',
    'remember_token'
])]

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Relasi
    |--------------------------------------------------------------------------
    */

    public function news()
    {
        return $this->hasMany(News::class, 'author_id');
    }
    public function contactMessages()
    {
        return $this->hasMany(ContactMessage::class);
    }
}
