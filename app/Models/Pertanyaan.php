<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pertanyaan extends Model
{
    use HasFactory;

    protected $fillable = [
        'halaman_kuesioner_id',
        'teks',
        'jenis_pertanyaan_id',
        'wajib',
        'punya_opsi_lain',
        'urutan',
        'atribut_ekstra',
        'visualisasi',
    ];

    protected $casts = [
        'visualisasi' => 'boolean',
        'wajib' => 'boolean',
        'punya_opsi_lain' => 'boolean',
        'atribut_ekstra' => 'array'
    ];

    public function halamanKuesioner()
    {
        return $this->belongsTo(HalamanKuesioner::class);
    }

    public function jenisPertanyaan()
    {
        return $this->belongsTo(JenisPertanyaan::class);
    }

    public function opsiJawabans()
    {
        return $this->hasMany(OpsiJawaban::class);
    }

    public function kondisiPertanyaan()
    {
        return $this->hasMany(KondisiPertanyaan::class);
    }

    public function barisMatrixs()
    {
        return $this->hasMany(BarisMatrix::class);
    }

    public function jawabanAlumnis()
    {
        return $this->hasMany(JawabanAlumni::class);
    }

    public function jawabanMatrixs()
    {
        return $this->hasMany(JawabanMatrix::class);
    }
}

