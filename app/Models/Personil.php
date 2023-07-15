<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personil extends Model
{
    use HasFactory;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'nip',
        'email',
        'password',
        'role',
        'pendidikan',
        'jabatan',
        'unit_kerja'
    ];
}
