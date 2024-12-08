<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles');
    }

    public function myTracks() {
        return $this->belongsToMany(Music::class, 'user_musics');
    }

    public function myAlbums() {
        return $this->belongsToMany(Album::class, 'user_albums');
    }
}
