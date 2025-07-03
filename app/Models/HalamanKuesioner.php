<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class HalamanKuesioner extends Model
{
    use HasFactory;

    protected $fillable = [
        'kuesioner_id',
        'judul',
        'deskripsi',
        'urutan'
    ];


    public function pertanyaans()
    {
        return $this->hasMany(Pertanyaan::class);
    }
}
