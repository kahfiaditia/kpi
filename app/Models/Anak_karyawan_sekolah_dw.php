<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Anak_karyawan_sekolah_dw extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'anak_kar_sklh_dw';

    public function anak_karyawans()
    {
        return $this->belongsTo(Anak_karyawan::class, 'anak_id');
    }
}
