<?php

namespace App\Http\Controllers;

use App\Http\Middleware\KasirMiddleware;
use App\Models\Kantin;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Menu;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    function __construct()
    {
        $this->middleware([KasirMiddleware::class]);
    }

    public function rupiah()
    {

        return view('dashboard.menu.index');
    }

    public function index()
    {
        $menu = Menu::orderBy('id_kantin', 'asc')->get();
        $kantin = Kantin::all();
        // return $menu;
        return view('dashboard.menu.index', [
            'menu' => $menu,
            'title' => 'Menu',
            'kantin' => $kantin
        ]);
    }

    public function create()
    {
        $kantin = Kantin::all();
        return view('dashboard.menu.create', [
            'title' => 'Add Menu',
            'kantin' => $kantin
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        // dd($data);
        $data['foto'] = $request->file('foto')->move('menu', $request->file('foto')->getClientOriginalName() . "." . $request->file("foto")->getClientOriginalExtension());
        $data['harga'] = str_replace('.', '', $data['harga']);
        $data['harga_pokok'] = str_replace('.', '', $data['harga_pokok']);
        Menu::create($data);
        Alert::success('Success', 'Berhasil Tambah Data');
        return redirect('/menuAll');
    }

    public function edit(Request $request, $id)
    {
        $menu = Menu::with(['Kantin'])->findOrFail($id);
        $kantin = Kantin::all();
        return view('dashboard.menu.edit', [
            'title' => 'Edit Menu',
            'menu' => $menu,
            'kantin' => $kantin
        ]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();

        if (!empty($data['foto'])) {
            $data['foto'] = $request->file('foto')->move('menu', $request->file('foto')->getClientOriginalName() . "." . $request->file("foto")->getClientOriginalExtension());
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
        $menuada = Menu::join('kantin', 'menu.id_kantin', '=', 'kantin.id_kantin')
            ->where('menu.status_stok', 'ada')
            ->where('kantin.status', 1)
            ->get();
        dd($menuada);

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
            $builder = Menu::where('status_stok', 'ada')
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
            $builder = Menu::join('kantin', 'menu.id_kantin', '=', 'kantin.id_kantin')->where('kantin.status', 1)
                ->where('status_stok', 'ada');
            $menu = $builder->get()->toArray();

            shuffle($menu);
            // return $menu;

            return response()->json([
                'data' => $menu,
                'code' => 200,
                'status' => true
            ], 200);
        }

        if ($req->kantin && $req->makanan) {
            $builder = Menu::join('kantin', 'menu.id_kantin', '=', 'kantin.id_kantin')->where('kantin.status', 1)->where('status_stok', 'ada')
                ->where('id_kantin', 'like', "%$req->kantin%")
                ->where('kategori', $req->makanan);
            $menu = $builder->get()->toArray();
            shuffle($menu);


            return response()->json([
                'data' => $menu,
                'code' => 200,
                'status' => true
            ], 200);
        }

        if ($req->kantin && $req->minuman) {
            $builder = Menu::join('kantin', 'menu.id_kantin', '=', 'kantin.id_kantin')->where('kantin.status', 1)->where('status_stok', 'ada')
                ->where('id_kantin', 'like', "%$req->kantin%")
                ->where('kategori', $req->minuman);
            $menu = $builder->get()->toArray();
            shuffle($menu);

            return response()->json([
                'data' => $menu,
                'code' => 200,
                'status' => true
            ], 200);
        }

        if ($req->makanan && $req->minuman) {
            $builder = Menu::join('kantin', 'menu.id_kantin', '=', 'kantin.id_kantin')->where('kantin.status', 1)
                ->where('status_stok', 'ada');
            $menu = $builder->get()->toArray();

            shuffle($menu);

            return response()->json([
                'data' => $menu,
                'code' => 200,
                'status' => true
            ], 200);
        }

        if ($req->kantin) {
            $builder = Menu::with(['Kantin'])->whereHas('Kantin', function ($query) {
                $query->where('status', 1);
            })->where('status_stok', 'ada')
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
            $builder = Menu::join('kantin', 'menu.id_kantin', '=', 'kantin.id_kantin')->where('kantin.status', 1)
                ->where('status_stok', 'ada')
                ->where('kategori', $req->makanan);
            $menu = $builder->get()->toArray();
            shuffle($menu);

            return response()->json([
                'data' => $menu,
                'code' => 200,
                'status' => true
            ], 200);
        }

        if ($req->minuman) {
            $builder = Menu::join('kantin', 'menu.id_kantin', '=', 'kantin.id_kantin')->where('kantin.status', 1)->where('status_stok', 'ada')
                ->where('kategori', $req->minuman);
            $menu = $builder->get()->toArray();
            shuffle($menu);

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
