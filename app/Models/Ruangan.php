<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ruangan extends Model
{
    use HasFactory;

    protected $table = 'ruangan';

    // Tambahkan baris ini agar Laravel tidak mencari kolom created_at & updated_at
    public $timestamps = false; 

    protected $fillable = [
        'gedung', 
        'nomor_ruang', 
        'kapasitas', 
        'proyektor', 
        'pc', 
        'status'
    ];
}