<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publication extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps=false;

    public function journal()
    {
        return $this->belongsTo(Journal::class);
    }

    public function authors()
    {
        return $this->belongsToMany(Author::class, 'Authorship')
        ->withPivot('role');
    }
}
