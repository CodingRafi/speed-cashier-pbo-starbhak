<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Foto extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function koleksi(){
        return $this->belongsTo(Koleksi::class);
    }

    public static function uploadFoto($gambar, $koleksi){
        if(count($gambar) > 0){ // mengecek lagi bener bener ada gak isinya
            foreach($gambar as $file){
                $nama = $file->store('foto-makanan');
                Foto::create([
                    'koleksi_id' => $koleksi->id,
                    'nama' => $nama
                ]);
            }
        }
    }
}
