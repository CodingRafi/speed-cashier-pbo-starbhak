<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\User;
use App\Models\Pesanan;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTransaksiRequest;
use App\Http\Requests\UpdateTransaksiRequest;
use App\Http\Resources\ResponseResource;
use PDF;
use Illuminate\Support\Facades\Validator;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $token = $request->header('Authorization');
        $token = explode(' ', $token)[1];
        $user = User::where('api_token', $token)->first();
        
        if($user->hasRole('manager')){
            $tran = Transaksi::filter(request(['kasir', 'start', 'end']))->get();

            $transaksis = [];
            $cashiers = [];

            foreach ($tran as $key => $transaksi) {
                $transaksis[] = [
                    'transaksi' => $transaksi,
                    'pesanans' => $transaksi->pesanan
                ];
            }

            foreach (User::all() as $key => $user) {
                if($user->hasRole('kasir')){
                    $cashiers[] = User::select('users.name')->where('id', $user->id)->first();
                }
            }

            $data = [
                'transaksis' => $transaksis,
                'cashiers' => $cashiers
            ];

            return new ResponseResource(true, 'List Data Transaksi dan Cashiers', $data);

        }else{
            $tran = Transaksi::where('user_id', $user->id)->get();
            $transaksis = [];

            foreach ($tran as $key => $transaksi) {
                $transaksis[] = [
                    'transaksi' => $transaksi,
                    'pesanans' => $transaksi->pesanan
                ];
            }
            return new ResponseResource(true, 'List Data Transaksi', $transaksis);
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $menus = Menu::all();
        // return view('transaksi.create', [
        //     'menus' => $menus
        // ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTransaksiRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'menu_id' => 'required',
            'jml' => 'required',
            'meja_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $token = $request->header('Authorization');
        $token = explode(' ', $token)[1];
        $user = User::where('api_token', $token)->first();

        $transaksi = Transaksi::create([
            'user_id' => $user->id,
            'total_harga' => 0,
            'meja_id' => $request->meja_id,
            'status' => 'belum'
        ]);

        $totalHargaPesanan = 0;
        $pesanans = [];

        foreach ($request->menu_id as $key => $menu) {
            $menuQuery = Menu::findOrFail($menu);

            $pesanan = Pesanan::create([
                'transaksi_id' => $transaksi->id,
                'menu_id' => $menu,
                'jml' => $request->jml[$key],
                'total_harga' => $menuQuery->harga * $request->jml[$key]
            ]);

            $pesanans[] = $pesanan;

            $totalHargaPesanan += $menuQuery->harga * $request->jml[$key];
        }

        $transaksi->update([
            'total_harga' => $totalHargaPesanan
        ]);

        return new ResponseResource(true, 'Berhasil Menambahkan Transaksi', [
            'transaksi' => $transaksi,
            'pesanans' => $pesanans
        ]);
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
        // $menus = Menu::all();
        // return view('transaksi.edit', [
        //     'menus' => $menus,
        //     'transaksi' => $transaksi
        // ]);
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

        return new ResponseResource(true, 'Berhasil Menghapus Transaksi', null);
    }

    public function pdf(){
        $transaksis = Transaksi::filter(request(['kasir', 'start', 'end']))->get();
        $pdf = PDF::loadView('transaksi.export', compact('transaksis'));
        
        return $pdf->download('Laporan Penjualan.pdf');
    }
}
