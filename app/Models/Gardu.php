<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gardu extends Model
{
    use HasFactory;
    protected $table = 'gardu_induk';

    protected $fillable = [
        'nama_gardu',
    ];
}
