<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Roles;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:user-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }


    public function index(Request $request)
    {
        $data = User::orderBy('id_user', 'DESC')->paginate(100);
        return view('user.index', compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Roles::pluck('name', 'name')->all();
        return view('user.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $this->validate($request, [
        //     'name' => 'required',
        //     'email' => 'required|email|unique:users,email',
        //     'password' => 'required|same:confirm-password',
        //     'roles' => 'required',
        //     'foto' => 'image|nullable|max:1999',
        //     'id_kantin' => 'nullable|integer',

        // ]);
        if ($request->hasFile('foto')) {
            $input = $request->all();
            $input['foto'] = $request->file('foto')->store('profile', 'public');
            $input['password'] = Hash::make($input['password']);
            User::create([
                'username' => $input['username'],
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
                'id_kantin' => $input['id_kantin'],
                'id_role' => $input['roles'][0]
            ]);
            // $user = User::create($input);
            // $user->assignRole($request->input('roles'));
            return redirect()->route('users.index');
        } else {
            $input = $request->all();
            // dd($input['roles'][0]);
            $input['password'] = Hash::make($input['password']);
            // $user = User::create($input);
            User::create([
                'username' => $input['username'],
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
                'id_kantin' => $input['id_kantin'],
                'id_role' => $input['roles'][0]
            ]);
            // $user->assignRole($request->input('roles'));
            return redirect()->route('users.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Roles::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();

        return view('user.edit', compact('user', 'roles', 'userRole'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        // dd($request->all());
        // $this->validate($request, [
        //     'name' => 'required',
        //     'email' => 'required|email|unique:users,email,' . $id,
        //     'password' => 'same:confirm-password',
        //     'roles' => 'required',
        //     'foto' => 'image|nullable|max:1999',
        //     'id_kantin' => 'nullable|integer',
        // ]);

        $input = $request->all();
        if (!empty($input['password']) || !empty($input['foto'])) {
            if ($request->hasFile('foto')) {
                $input['password'] = Hash::make($input['password']);
                $input['foto'] = $request->file('foto')->store('profile', 'public');
            } else {
                $input['password'] = Hash::make($input['password']);
                unset($input['foto']);
            }
        } else {
            // $input = Arr::except($input, array('password')); 
            $input['password'] = Hash::make($input['password']);
            unset($input['foto']);
        }

        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id', $id)->delete();

        $user->assignRole($request->input('roles'));
        // return redirect()->route('users.index');
        return redirect('/users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully');
    }
}
