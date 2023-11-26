<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{

    public function rupiah()
    {

        return view('dashboard.menu.index');
    }

    public function index()
    {
        $menu = DB::table('menus')->orderBy('id_kantin', 'asc')->get();

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
        $data['foto'] = $request->file('foto')->store('menu', 'public');
        Menu::create($data);

        return redirect('/menu');
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

        return redirect('/menu');
    }

    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        Storage::delete($menu->foto);
        $menu->delete();

        return redirect()->back();
    }
}
