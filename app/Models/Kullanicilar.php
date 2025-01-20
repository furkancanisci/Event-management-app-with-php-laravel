<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Kullanicilar extends Authenticatable
{
    use HasFactory;

    protected $table = 'kullanicilar';

    protected $fillable = [
        'kullanici_adi',
        'sifre',
        'email',
        'konum',
        'ilgi_alanlari',
        'ad',
        'soyad',
        'dogum_tarihi',
        'cinsiyet',
        'telefon_numarasi',
        'profil_fotografi',
        'is_admin'
    ];

    protected $hidden = [
        'sifre',
    ];
}
