<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pesanan;
use App\Models\User;

class Transaksi extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function pesanan(){
        return $this->hasMany(Pesanan::class);
    }

    public function meja(){
        return $this->hasOne(Meja::class);
    }

    static public function updateTotalHarga($transaksi_id){
        $allPesanan = Pesanan::where('transaksi_id', $transaksi_id)->get();
        
        $total_harga = 0;
        foreach ($allPesanan as $key => $siglePesanan) {
            $total_harga += $siglePesanan->total_harga;
        }

        Transaksi::where('id', $transaksi_id)->first()->update([
            'total_harga' => $total_harga
        ]);
    }

    public function scopeFilter($query, array $search)
    {
        $query->when($search['kasir'] ?? false, function($query, $name){
            $user = User::where('name', $name)->first();

            return $query->where('user_id', $user->id);
        });

        $query->when($search['start'] ?? false, function($query, $start){
            return $query->whereDate('created_at', '>=', $start);
        });

        $query->when($search['end'] ?? false, function($query, $end){
            return $query->whereDate('created_at', '<=', $end);
        });
    }
}
