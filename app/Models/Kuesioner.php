<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kuesioner extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama'
    ];

    public function halamanKuesioners()
    {
        return $this->hasMany(HalamanKuesioner::class);
    }

    public function pengisians()
    {
        return $this->hasMany(Pengisian::class);
    }
}
