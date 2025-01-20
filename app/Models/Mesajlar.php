<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mesajlar extends Model
{
    use HasFactory;

    protected $table = 'mesajlar';

    protected $fillable = [
        'gonderici_id',
        'alici_id',
        'mesaj_metni',
        'gonderim_zamani',
        'etkinlikid'
    ];
}
