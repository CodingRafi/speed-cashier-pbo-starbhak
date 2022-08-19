<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\Log;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\KategoriResource;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Kategori::all();

        return new KategoriResource(true, 'List Data Category', $categories);
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
        
        $validator = Validator::make($request->all(), [
            'nama' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        
        $category = Kategori::Create([
            'nama' => $request->nama
        ]);
        
        $token = $request->header('Authorization');
        $token = explode(' ', $token)[1];
        $user = User::where('api_token', $token)->first();

        Log::logCreateApi('Menambahkan Category ' . $request->nama, $user);
        
        return new KategoriResource(true, 'Kategori Berhasil Ditambahkan', $category);
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
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kategori  $kategori
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kategori $kategori)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $oldKategori = Kategori::findOrFail($kategori->id);
        $kategori->update([
            'nama' => $request->nama
        ]);

        $token = $request->header('Authorization');
        $token = explode(' ', $token)[1];
        $user = User::where('api_token', $token)->first();

        Log::logCreateApi('Mengubah Category ' . $request->nama, $user);
        
        return new KategoriResource(true, 'Kategori Berhasil Diupdate', $kategori);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kategori  $kategori
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $kategori = Kategori::where('id', $id)->first();

        $menus = $kategori->menu;

        foreach ($menus as $key => $menu) {
            $menu->delete();
        }

        $kategori->delete();

        $token = $request->header('Authorization');
        $token = explode(' ', $token)[1];
        $user = User::where('api_token', $token)->first();

        Log::logCreateApi('Menambahkan Category ' . $request->nama, $user);

        return new KategoriResource(true, 'Kategori Berhasil Dihapus', null);
    }
}
