<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMusic extends Model
{
    use HasFactory;
    protected $table = 'user_musics';
    protected $guarded = [];
    public $timestamps=false;
}
