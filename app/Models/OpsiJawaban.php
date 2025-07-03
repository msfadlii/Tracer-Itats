<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OpsiJawaban extends Model
{
    use HasFactory;

    protected $fillable = [
        'pertanyaan_id',
        'teks',
        'urutan'
    ];

    public function pertanyaan()
    {
        return $this->belongsTo(Pertanyaan::class);
    }
}

