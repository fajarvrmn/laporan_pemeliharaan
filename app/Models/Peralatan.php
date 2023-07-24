<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peralatan extends Model
{
    use HasFactory;

    protected $table = 'peralatan';

    protected $fillable = [
        'id_alat',
        'id_merk_peralatan',
        'id_type_peralatan',
        'serial_number',
        'nama_bay'
    ];
}
