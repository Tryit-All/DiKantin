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
        $builder = Menu::orderBy('id_kantin', 'asc')
            ->where('status_stok', 'ada');
        if ($req->q) {
            $builder = $builder->where('nama_menu', 'like', "%$req->q%");
        }
        $menu = $builder->get();

        return response()->json(['message' => 'success', 'data' => $menu]);
    }

}
