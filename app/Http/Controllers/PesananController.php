<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\Menu;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use App\Http\Requests\StorePesananRequest;
use App\Http\Requests\UpdatePesananRequest;

class PesananController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePesananRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'menu_id' => 'required',
            'jml' => 'required',
            'transaksi_id' => 'required'
        ]);

        
        foreach ($request->menu_id as $key => $menu) {
            $menuQuery = Menu::findOrFail($menu);
            // dd($menuQuery->harga * $request->jml[$key]);

            Pesanan::create([
                'transaksi_id' => $request->transaksi_id,
                'menu_id' => $menu,
                'jml' => $request->jml[$key],
                'total_harga' => $menuQuery->harga * $request->jml[$key]
            ]);
        }

        // $allPesanan = Pesanan::where('transaksi_id', $request->transaksi_id)->get();
        // $total_harga = 0;

        // foreach ($allPesanan as $key => $siglePesanan) {
        //     $total_harga += $siglePesanan->total_harga;
        // }

        // Transaksi::where('id', $request->transaksi_id)->first()->update([
        //     'total_harga' => $total_harga
        // ]);

        Transaksi::updateTotalHarga($request->transaksi_id);

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pesanan  $pesanan
     * @return \Illuminate\Http\Response
     */
    public function show(Pesanan $pesanan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pesanan  $pesanan
     * @return \Illuminate\Http\Response
     */
    public function edit(Pesanan $pesanan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePesananRequest  $request
     * @param  \App\Models\Pesanan  $pesanan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pesanan $pesanan)
    {
        $validatedData = $request->validate([
            'menu_id' => 'required',
            'jml' => 'required'
        ]);

        $menuQuery = Menu::findOrFail($request->menu_id);

        $pesanan->update([
            'menu_id' => $request->menu_id,
            'jml' => $request->jml,
            'total_harga' => $menuQuery->harga * $request->jml
        ]);

        Transaksi::updateTotalHarga($pesanan->transaksi_id);

        return redirect()->back();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pesanan  $pesanan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pesanan $pesanan)
    {
        $pesanan->delete();
        
        Transaksi::updateTotalHarga($pesanan->transaksi_id);

        return response()->json([
            'message' => 'Berhasil Menghapus Pesanan'
        ], 200);
    }
}
