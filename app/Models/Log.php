<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;
    protected $guarded = [];

    public static function log_status()
    {
        return SiteSetting::first()->log_status;
    }

    public function types()
    {
        $lang_code = auth()->user()->lang_code;
        return [
            [
                'id' => 1,
                'name' => $lang_code == 'kz' ? 'Жүйеге кірді' : 'Giriş yaptı'
            ],
            [
                'id' => 2,
                'name' => $lang_code == 'kz' ? 'Жазба қосты' : 'Kaydı ekledi'
            ],
            [
                'id' => 3,
                'name' => $lang_code == 'kz' ? 'Жазбаны өзгертті' : 'Kaydı düzenledi'
            ],
            [
                'id' => 4,
                'name' => $lang_code == 'kz' ? 'Жазбаны жойды' : 'Kaydı sildi'
            ],
            [
                'id' => 5,
                'name' => $lang_code == 'kz' ? 'Жүйеден шықты' : 'Çıkış yaptı'
            ],
        ];
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
