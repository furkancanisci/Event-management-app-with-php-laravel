<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Puan extends Model
{
    use HasFactory;

    protected $table = 'puanlar';

    protected $fillable = [
        'kullanici_id',
        'puanlar',
        'kazanilan_tarih'
    ];
}
