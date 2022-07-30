<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Kategori;
use App\Models\Menu;
use App\Models\User;

class DashboardController extends Controller
{
    public function index(){
        if (\Auth::user()->hasRole('kasir')) {
            $jmlTransaksi = Transaksi::where('user_id', \Auth::user()->id)->count();
            return view('dashboard', [
                'jml_transaksi' => $jmlTransaksi
            ]);
        }else if(\Auth::user()->hasRole('manager')){
            $jmlCategories = Kategori::all()->count();
            $jmlMenus = Menu::all()->count();
            return view('dashboard', [
                'categories' => $jmlCategories,
                'menus' => $jmlMenus
            ]);
        }else if(\Auth::user()->hasRole('admin')){
            $users = User::all()->count();
            return view('dashboard', [
                'users' => $users
            ]);
        }

    }
}
