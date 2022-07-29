<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Menu;
use App\Models\Log;
use Illuminate\Http\Request;
use App\Http\Requests\StoreKategoriRequest;
use App\Http\Requests\UpdateKategoriRequest;

class KategoriController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:index_kategori|create_kategori|update_kategori|delete_kategori', ['only' => ['index','show']]);
         $this->middleware('permission:create_kategori', ['only' => ['create','store']]);
         $this->middleware('permission:update_kategori', ['only' => ['edit','update']]);
         $this->middleware('permission:delete_kategori', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Kategori::all();
        return view('kategori.index', [
            'categories' => $categories
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
     * @param  \App\Http\Requests\StoreKategoriRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required'
        ]);

        Kategori::Create($validatedData);

        Log::logCreate('Menambahkan Category ' . $request->nama);

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kategori  $kategori
     * @return \Illuminate\Http\Response
     */
    public function show(Kategori $kategori)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kategori  $kategori
     * @return \Illuminate\Http\Response
     */
    public function edit(Kategori $kategori)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateKategoriRequest  $request
     * @param  \App\Models\Kategori  $kategori
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kategori $kategori)
    {
        $validatedData = $request->validate([
            'nama' => 'required'
        ]);

        $oldKategori = Kategori::findOrFail($kategori->id);
        $kategori->update($validatedData);

        Log::logCreate('Mengubah Category ' . $oldKategori->nama);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kategori  $kategori
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kategori $kategori)
    {
        $menus = $kategori->menu;

        foreach ($menus as $key => $menu) {
            $menu->delete();
        }

        $kategori->delete();

        Log::logCreate('Menghapus Category ' . $kategori->nama);

        return redirect()->back();
    }
}
