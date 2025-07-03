<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JenisPertanyaan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama'
    ];

    public function pertanyaans()
    {
        return $this->hasMany(Pertanyaan::class);
    }
}

