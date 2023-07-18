<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;

    protected $table = 'laporan';

    protected $fillable = [
        'id_peralatan',
        'nip',
        'id_status_pekerjaan',
        'tgl_pelaksanaan',
        'id_gardu_induk',
        'busbar',
        'kapasitas',
        'hasil_pengujian_tahanan_kontak',
        'hasil_pengujian_tahanan_isolasi',
        'arus_motor_open',
        'arus_motor_close',
        'waktu_open',
        'waktu_close',
        'kondisi_visual',
        'dokumentasi',
        'pengawas_pekerjaan',
        'keterangan'
    ];
}
