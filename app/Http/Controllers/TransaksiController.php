<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Pesanan;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTransaksiRequest;
use App\Http\Requests\UpdateTransaksiRequest;

class TransaksiController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:index_transaksi|create_transaksi|update_transaksi|delete_transaksi', ['only' => ['index','show']]);
         $this->middleware('permission:create_transaksi', ['only' => ['create','store']]);
         $this->middleware('permission:update_transaksi', ['only' => ['edit','update']]);
         $this->middleware('permission:delete_transaksi', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transaksis = Transaksi::where('user_id', \Auth::user()->id)->get();
        return view('transaksi.index', [
            'transaksis' => $transaksis
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $menus = Menu::all();
        return view('transaksi.create', [
            'menus' => $menus
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTransaksiRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'menu_id' => 'required',
            'jml' => 'required',
        ]);

        $transaksi = Transaksi::create([
            'user_id' => \Auth::user()->id,
            'total_harga' => 0
        ]);

        $totalHargaPesanan = 0;

        foreach ($request->menu_id as $key => $menu) {
            $menuQuery = Menu::findOrFail($menu);

            Pesanan::create([
                'transaksi_id' => $transaksi->id,
                'menu_id' => $menu,
                'jml' => $request->jml[$key],
                'total_harga' => $menuQuery->harga * $request->jml[$key]
            ]);

            $totalHargaPesanan += $menuQuery->harga * $request->jml[$key];
        }

        $transaksi->update([
            'total_harga' => $totalHargaPesanan
        ]);

        return redirect('/transaksi');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function show(Transaksi $transaksi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaksi $transaksi)
    {
        $menus = Menu::all();
        return view('transaksi.edit', [
            'menus' => $menus,
            'transaksi' => $transaksi
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTransaksiRequest  $request
     * @param  \App\Models\Transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTransaksiRequest $request, Transaksi $transaksi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaksi $transaksi)
    {
        foreach ($transaksi->pesanan as $key => $pesanan) {
            $pesanan->delete();
        }

        $transaksi->delete();

        return redirect()->back();
    }
}
