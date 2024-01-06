<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $guarded = [];
    public function perpustakaan()
    {
        return $this->hasMany(Perpustakaan::class);
    }

    public function buku()
    {
        return $this->hasMany(Buku::class);
    }
}
