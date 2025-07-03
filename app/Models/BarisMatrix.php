<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BarisMatrix extends Model
{
    protected $table = 'baris_matrixs';
    use HasFactory;

    protected $fillable = [
        'pertanyaan_id',
        'label'
    ];

    public function pertanyaan()
    {
        return $this->belongsTo(Pertanyaan::class);
    }

    public function jawabanMatrixs()
    {
        return $this->hasMany(JawabanMatrix::class);
    }
}
