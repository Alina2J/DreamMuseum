<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'login',
        'email',
        'password',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function post() {
        return $this->hasMany(Post::class);
    }

    public function role() {
        return $this->belongsTo(Role::class);
    }

    public function like() {
        return $this->belongsToMany(Post::class, 'likes', 'user_id', 'post_id');
    }

    public function comment() {
        return $this->hasMany(Comment::class);
    }

    public function messages() {
        return $this->hasMany(Message::class);
    }

    public function isAdmin() {
        return $this->role()->where('role', 'admin')->exists();
    }

    public function chat() {
        return $this->hasMany(Chat::class);
    }

}
