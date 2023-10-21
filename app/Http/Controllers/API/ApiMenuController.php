<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Middleware\ApiKeyMiddleware;
use App\Models\Menu;
use Illuminate\Http\Request;

class ApiMenuController extends Controller
{
    public function __construct()
    {
        $this->middleware(ApiKeyMiddleware::class);
    }

    // Controller Product
    public function product(Request $request)
    {
        if ($request->segment(4)) {
            return $this->sendMassage(Menu::select('id_menu', 'nama', 'harga', 'foto', 'status_stok', 'kategori', 'id_kantin', 'diskon', 'created_at', 'updated_at')
                ->where('nama', 'LIKE', $request->segment(4) . '%')
                ->where('status_stok', 'ada')
                ->get(), 200, true);
        } else {
            return $this->sendMassage(Menu::where('status_stok', 'ada')->get(), 200, true);
        }
    }

    public function product_food(Request $request)
    {
        // dd($request->segment(3));
        if ($request->segment(4)) {
            return $this->sendMassage(Menu::select('id_menu', 'nama', 'harga', 'foto', 'status_stok', 'kategori', 'id_kantin', 'diskon', 'created_at', 'updated_at')
                ->where('nama', 'LIKE', '%' . $request->segment(4) . '%')
                ->where('kategori', 'makanan')
                ->where('status_stok', 'ada')
                ->get(), 200, true);
        } else {
            return $this->sendMassage(Menu::where('status_stok', 'ada')->where('kategori', 'makanan')->get(), 200, true);
        }
    }

    public function product_drink(Request $request)
    {
        // dd($request->segment(4));
        if ($request->segment(4)) {
            return $this->sendMassage(Menu::select('id_menu', 'nama', 'harga', 'foto', 'status_stok', 'kategori', 'id_kantin', 'diskon', 'created_at', 'updated_at')
                ->where('nama', 'LIKE', $request->segment(4) . '%')
                ->where('kategori', 'minuman')
                ->where('status_stok', 'ada')
                ->get(), 200, true);
        } else {
            return $this->sendMassage(Menu::where('status_stok', 'ada')->where('kategori', 'minuman')->get(), 200, true);
        }

    }

    // Function Massage
    public function sendMassage($text, $kode, $status)
    {
        return response()->json([
            'data' => $text,
            'code' => $kode,
            'status' => $status
        ], $kode);
    }
}