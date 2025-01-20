<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Katilimcilar extends Model
{
    use HasFactory;

    protected $table = 'katilimcilar';

    protected $fillable = [
        'kullanici_id',
        'etkinlik_id',
        'created_at'
    ];
}
