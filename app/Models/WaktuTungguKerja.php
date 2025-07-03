<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WaktuTungguKerja extends Model
{
    use HasFactory;

    protected $table = 'waktu_tunggu_kerjas';
    protected $fillable = [
        'alumni_id',
        'waktu_tunggu_bulan',
    ];

    // Relasi: WaktuTungguKerja milik satu Alumni
    public function alumni()
    {
        return $this->belongsTo(Alumni::class);
    }
}
