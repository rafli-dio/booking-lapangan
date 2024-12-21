<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    protected $fillable = ['nama', 'acara', 'mulai', 'akhir', 'lapangan_id', 'total_harga'];

    public function lapangan()
    {
        return $this->belongsTo(Lapangan::class, 'lapangan_id', 'id');
    }
}
