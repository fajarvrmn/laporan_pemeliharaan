<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Namabay extends Model
{
    use HasFactory;
    protected $table = 'nama_bay';

    protected $fillable = [
        'nama',
        
    ];
}
