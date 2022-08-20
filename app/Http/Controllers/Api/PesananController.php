<?php

namespace App\Http\Controllers\Api;

use App\Models\Pesanan;
use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use App\Http\Requests\StorePesananRequest;
use App\Http\Requests\UpdatePesananRequest;
use App\Http\Resources\ResponseResource;
use Illuminate\Support\Facades\Validator;

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
        $validator = Validator::make($request->all(), [
            'menu_id' => 'required',
            'jml' => 'required',
            'transaksi_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        foreach ($request->menu_id as $key => $menu) {
            $menuQuery = Menu::findOrFail($menu);
            
            Pesanan::create([
                'transaksi_id' => $request->transaksi_id,
                'menu_id' => $menu,
                'jml' => $request->jml[$key],
                'total_harga' => $menuQuery->harga * $request->jml[$key]
            ]);
        }

        Transaksi::updateTotalHarga($request->transaksi_id);
        $transaksi = Transaksi::findOrFail($request->transaksi_id);

        return new ResponseResource(true, 'Berhasil Menambahkan Pesanan', [
            'transaksi' => $transaksi,
            'pesanans' => $transaksi->pesanan
        ]);
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
        $validator = Validator::make($request->all(), [
            'menu_id' => 'required',
            'jml' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $menuQuery = Menu::findOrFail($request->menu_id);

        $pesanan->update([
            'menu_id' => $request->menu_id,
            'jml' => $request->jml,
            'total_harga' => $menuQuery->harga * $request->jml
        ]);
        
        Transaksi::updateTotalHarga($pesanan->transaksi_id);
        
        $transaksi = Transaksi::findOrFail($pesanan->transaksi_id);

        return new ResponseResource(true, 'Berhasil Mengubah Pesanan', [
            'transaksi' => $transaksi,
            'pesanans' => $transaksi->pesanan
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pesanan  $pesanan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $pesanan = Pesanan::findOrFail($id);
        $pesanan->delete();
        
        Transaksi::updateTotalHarga($pesanan->transaksi_id);

        return new ResponseResource(true, 'Berhasil Menghapus Pesanan', null);
    }
}
