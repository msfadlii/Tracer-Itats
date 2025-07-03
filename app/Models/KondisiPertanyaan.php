<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KondisiPertanyaan extends Model
{
    use HasFactory;

    protected $table = 'kondisi_pertanyaans';

    protected $fillable = [
        'pertanyaan_id',
        'field',
        'nilai_status_kerja'
    ];

    public function pertanyaan()
    {
        return $this->belongsTo(Pertanyaan::class);
    }
}

