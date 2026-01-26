<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnalyticsAlumni extends Model
{
    // Mengarahkan model ini untuk menggunakan koneksi 'mysql_analytics'
    protected $connection = 'mysql_analytics';

    protected $table = 'alumnis'; 
}
