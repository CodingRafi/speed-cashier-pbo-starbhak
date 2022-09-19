<?php

namespace App\Http\Controllers;

use App\Models\Meja;
use Illuminate\Http\Request;

class MejaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mejas = Meja::all();
        return view('meja.index', [
            'mejas' => $mejas
        ]);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'no_meja' => 'required'
        ]);

        Meja::create([
            'no_meja' => $request->no_meja,
        ]);

        return redirect()->back()->with('message', 'Berhasil Membuat Meja');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Meja  $meja
     * @return \Illuminate\Http\Response
     */
    public function show(Meja $meja)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Meja  $meja
     * @return \Illuminate\Http\Response
     */
    public function edit(Meja $meja)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Meja  $meja
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Meja $meja)
    {
        $request->validate([
            'no_meja' => 'required' 
        ]);

        $meja->update([
            'no_meja' => $request->no_meja
        ]);

        return redirect()->back()->with('message', 'Berhasil update meja');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Meja  $meja
     * @return \Illuminate\Http\Response
     */
    public function destroy(Meja $meja)
    {
        foreach ($meja->transaksi as $key => $transaksi) {
            $transaksi->update([
                'meja_id' => null
            ]);
        }

        $meja->delete();

        return redirect()->back()->with('message', 'Berhasil Menghapus Meja');
    }
}
