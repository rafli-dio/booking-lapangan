<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lapangan extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama',
        'deskripsi',
        'harga_per_jam',
        'kapasitas',
        'gambar'
    ];

    public function lapangan()
    {
        return $this->hasMany(Lapangan::class, 'lapangan_id', 'id');
    }
}
