<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bildirimler extends Model
{
    use HasFactory;

    protected $table = 'bildirimler';

    protected $fillable = [ 'user_id', 'content', 'okundu', ];
}
