<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Authorship extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'Authorship';
    public $timestamps=false;
}
