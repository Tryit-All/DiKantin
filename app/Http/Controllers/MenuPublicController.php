<?php

namespace App\Http\Controllers;

use App\Models\Kantin;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuPublicController extends Controller
{
    //
    public function findAll()
    {

        $kantins = Kantin::where('status', 1)->get();
        $menus = Menu::with([
            'kantin' => function ($query) {
                $query->where('status', true);
            }
        ])->where('status_stok', 'ada')->get();
        return view("menu-list", ['kantins' => $kantins, 'menus' => $menus]);
    }
}
