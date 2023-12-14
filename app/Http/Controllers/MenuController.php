<?php

namespace App\Http\Controllers;
use RealRashid\SweetAlert\Facades\Alert; 
use App\Models\Menu;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:menu-list|menu-create|menu-edit|menu-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:menu-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:menu-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:menu-delete', ['only' => ['destroy']]);
    }

    public function rupiah()
    {

        return view('dashboard.menu.index');
    }

    public function index()
    {
        $menu = Menu::orderBy('id_kantin', 'asc')->get();
        // return $menu;
        return view('dashboard.menu.index', [
            'menu' => $menu,
            'title' => 'Menu'
        ]);
    }

    public function create()
    {
        return view('dashboard.menu.create', [
            'title' => 'Add Menu'
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        // dd($data);
        $data['foto'] = $request->file('foto')->store('menu', 'public');
        $data['harga'] = str_replace('.', '', $data['harga']);
        $data['harga_pokok'] = str_replace('.', '', $data['harga_pokok']);
        Menu::create($data);
        Alert::success('Success', 'Berhasil Tambah Data');
        return redirect('/menuAll');
    }

    public function edit(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);

        return view('dashboard.menu.edit', [
            'title' => 'Edit Menu',
            'menu' => $menu
        ]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();

        if (!empty($data['foto'])) {
            $data['foto'] = $request->file('foto')->store('menu', 'public');
        } else {
            unset($data['foto']);
        }

        Menu::findOrFail($id)->update($data);

        return redirect('/menuAll');
    }

    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        Storage::delete($menu->foto);
        $menu->delete();

        return redirect()->back();
    }

    public function product(Request $request)
    {
        $menuada = Menu::where('status_stok', 'ada')->get();
        $databarang = $menuada->count();
        return response()->json($databarang);
        if ($databarang > $databarang)

            while ($row = mysqli_fetch_array($databarang)) {
                $orderStatus = $row['status_stok'];

                $data = array(
                    'orderStatus' => $orderStatus
                );
                // echo json_encode($data);
                return response()->json($data);
            }
    }

    public function searchProduct(Request $req)
    {

        if ($req->kantin && $req->makanan && $req->minuman) {
            $builder = Menu::orderBy('id_kantin', 'asc')
                ->where('status_stok', 'ada')
                ->where('id_kantin', 'like', "%$req->kantin%")
                ->where(function ($query) use ($req) {
                    $query->where('kategori', $req->makanan)
                        ->orWhere('kategori', $req->minuman);
                });
            $menu = $builder->get();
            // return $menu;

            return response()->json([
                'data' => $menu,
                'code' => 200,
                'status' => true
            ], 200);
        }

        if ($req->kantin == '' && $req->makanan == '' && $req->minuman == '') {
            $builder = Menu::orderBy('id_kantin', 'asc')
                ->where('status_stok', 'ada');
            $menu = $builder->get();
            // return $menu;

            return response()->json([
                'data' => $menu,
                'code' => 200,
                'status' => true
            ], 200);
        }

        if ($req->kantin && $req->makanan) {
            $builder = Menu::orderBy('id_kantin', 'asc')
                ->where('status_stok', 'ada')
                ->where('id_kantin', 'like', "%$req->kantin%")
                ->where('kategori', $req->makanan);
            $menu = $builder->get();
            // return $menu;

            return response()->json([
                'data' => $menu,
                'code' => 200,
                'status' => true
            ], 200);
        }

        if ($req->kantin && $req->minuman) {
            $builder = Menu::orderBy('id_kantin', 'asc')
                ->where('status_stok', 'ada')
                ->where('id_kantin', 'like', "%$req->kantin%")
                ->where('kategori', $req->minuman);
            $menu = $builder->get();
            // return $menu;

            return response()->json([
                'data' => $menu,
                'code' => 200,
                'status' => true
            ], 200);
        }

        if ($req->makanan && $req->minuman) {
            $builder = Menu::orderBy('id_kantin', 'asc')
                ->where('status_stok', 'ada')
                ->where('kategori', $req->makanan)
                ->where('kategori', $req->minuma);
            $menu = $builder->get();
            // return $menu;

            return response()->json([
                'data' => $menu,
                'code' => 200,
                'status' => true
            ], 200);
        }

        if ($req->kantin) {
            $builder = Menu::orderBy('id_kantin', 'asc')
                ->where('status_stok', 'ada')
                ->where('id_kantin', 'like', "%$req->kantin%");
            $menu = $builder->get();
            // return $menu;

            return response()->json([
                'data' => $menu,
                'code' => 200,
                'status' => true
            ], 200);
        }

        if ($req->makanan) {
            $builder = Menu::orderBy('id_kantin', 'asc')
                ->where('status_stok', 'ada')
                ->where('kategori', $req->makanan);
            $menu = $builder->get();
            // return $menu;

            return response()->json([
                'data' => $menu,
                'code' => 200,
                'status' => true
            ], 200);
        }

        if ($req->minuman) {
            $builder = Menu::orderBy('id_kantin', 'asc')
                ->where('status_stok', 'ada')
                ->where('kategori', $req->minuman);
            $menu = $builder->get();
            // return $menu;

            return response()->json([
                'data' => $menu,
                'code' => 200,
                'status' => true
            ], 200);
        }

        return response()->json([
            'data' => [],
            'code' => 400,
            'status' => false
        ], 400);
    }

}
