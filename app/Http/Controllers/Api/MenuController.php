<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Kategori;
use App\Models\Log;
use App\Models\Koleksi;
use App\Models\Foto;
use Illuminate\Http\Request;
use App\Http\Requests\StoreMenuRequest;
use App\Http\Requests\UpdateMenuRequest;
use App\Http\Resources\ResponseResource;
use Illuminate\Support\Facades\Validator;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menus = [];

        foreach (Menu::all() as $key => $menu) {
            $menus[] = [
                'data' => $menu,
                'fotos' => $menu->koleksi[0]->foto
            ];
        }
        return new ResponseResource(true, 'List Data Menu', $menus);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $categories = Kategori::all();
        // return view('menus.create', [
        //     'categories' => $categories
        // ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMenuRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'harga' => 'required|numeric',
            'kategori_id' => 'required',
            'satuan' => 'required',
            'fotos' => 'required',
            'fotos.*' => 'mimes:jpg,jpeg,png|max:5024',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        
        $menu = Menu::create([
            'nama' => $request->nama,
            'harga' => $request->harga,
            'kategori_id' => $request->kategori_id,
            'satuan' => $request->satuan
        ]);
        
        
        $koleksi = Koleksi::create([
            'menu_id' => $menu->id
        ]);
        Foto::uploadFoto($request->fotos, $koleksi);
        
        Log::logCreateApi('Menambahkan Menu ' . $request->nama, $request);

        $data = [
            'menu' => $menu,
            'fotos' => $menu->koleksi[0]->foto
        ];

        return new ResponseResource(true, 'Menu Berhasil Ditambahkan', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function show(Menu $menu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function edit(Menu $menu)
    {
        // $categories = Kategori::all();
        // return view('menus.edit', [
        //     'menu' => $menu,
        //     'categories' => $categories
        // ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMenuRequest  $request
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Menu $menu)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'harga' => 'required|numeric',
            'kategori_id' => 'required',
            'satuan' => 'required'
        ]);
        
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        
        if($request->file('fotos')){
            Foto::uploadFoto($request->fotos, $menu->koleksi[0]);
        }  

        $oldMenu = Menu::findOrFail($menu->id);
        
        $menu->update([
            'nama' => $request->nama,
            'harga' => $request->harga,
            'kategori_id' => $request->kategori_id,
        ]);

        $data = [
            'menu' => $menu,
            'kategori' => $menu->kategori,
            'fotos' => $menu->koleksi[0]->foto
        ];

        Log::logCreateApi('Mengubah Menu ' . $request->nama, $request);

        return new ResponseResource(true, 'Menu Berhasil Diubah', $menu);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);
        
        foreach ($menu->koleksi as $koleksi) {
            foreach ($koleksi->foto as $key => $foto) {
                $foto->delete();
            }
            $koleksi->delete();
        }

        $menu->delete();

        Log::logCreateApi('Menghapus menu ' . $request->nama, $request);

        return new ResponseResource(true, 'Menu Berhasil Dihapus', null);
    }
}
