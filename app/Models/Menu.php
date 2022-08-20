<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function kategori(){
        return $this->belongsTo(Kategori::class);
    }

    public function pesanan(){
        return $this->hasMany(Pesanan::class);
    }

    public function koleksi(){
        return $this->hasMany(Koleksi::class);
    }
}
