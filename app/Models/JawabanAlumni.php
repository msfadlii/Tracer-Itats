<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JawabanAlumni extends Model
{
    use HasFactory;

    protected $fillable = [
        'pengisian_id',
        'pertanyaan_id',
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
}

