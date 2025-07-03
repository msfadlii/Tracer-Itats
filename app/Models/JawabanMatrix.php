<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JawabanMatrix extends Model
{
    use HasFactory;

    protected $table = 'jawaban_matrixs';
    protected $fillable = [
        'pengisian_id',
        'pertanyaan_id',
        'baris_matrix_id',
        'jawaban'
    ];

    public function pengisian()
    {
        return $this->belongsTo(Pengisian::class);
    }

    public function pertanyaan()
    {
        return $this->belongsTo(Pertanyaan::class);
    }

    public function barisMatrix()
    {
        return $this->belongsTo(BarisMatrix::class);
    }
}

