<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Kategori;
use App\Models\Log;
use Illuminate\Http\Request;
use App\Http\Requests\StoreMenuRequest;
use App\Http\Requests\UpdateMenuRequest;

class MenuController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:index_menu|create_menu|update_menu|delete_menu', ['only' => ['index','show']]);
         $this->middleware('permission:create_menu', ['only' => ['create','store']]);
         $this->middleware('permission:update_menu', ['only' => ['edit','update']]);
         $this->middleware('permission:delete_menu', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menus = Menu::all();
        return view('menus.index', [
            'menus' => $menus
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Kategori::all();
        return view('menus.create', [
            'categories' => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMenuRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required',
            'harga' => 'required|numeric',
            'kategori_id' => 'required' 
        ]);

        Menu::create($validatedData);

        Log::logCreate('Menambahkan Menu ' . $request->nama);

        return redirect('/menu');
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
        $categories = Kategori::all();
        return view('menus.edit', [
            'menu' => $menu,
            'categories' => $categories
        ]);
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
        $validatedData = $request->validate([
            'nama' => 'required',
            'harga' => 'required|numeric',
            'kategori_id' => 'required' 
        ]);

        $oldMenu = Menu::findOrFail($menu->id);
        
        $menu->update($validatedData);

        Log::logCreate('Mengubah menu ' . $oldMenu->nama);

        return redirect('/menu');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $menu)
    {
        $menu->delete();
        Log::logCreate('Menghapus menu ' . $menu->nama);
        return redirect()->back();
    }
}
