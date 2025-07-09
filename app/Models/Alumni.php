<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Alumni extends Model
{
    use HasFactory;

    protected $fillable = [
        'tahun_lulus',
        'npm',
        'nama',
        'nik',
        'tanggal_lahir',
        'email',
        'telepon',
        'npwp',
        'dosen_pembimbing',
        'pembiayaan',
        'status'
    ];

    protected $casts = [
        'tahun_lulus' => 'integer',
        'tanggal_lahir' => 'date'
    ];

    public function pengisians()
    {
        return $this->hasMany(Pengisian::class);
    }
   
}

