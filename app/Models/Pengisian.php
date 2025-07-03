<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pengisian extends Model
{
    use HasFactory;

    protected $fillable = [
        'alumni_id',
        'kuesioner_id'
    ];

    public function alumni()
    {
        return $this->belongsTo(Alumni::class);
    }


    public function jawabanAlumni()
    {
        return $this->hasMany(JawabanAlumni::class);
    }

    public function jawabanMatrix()
    {
        return $this->hasMany(JawabanMatrix::class);
    }
}

