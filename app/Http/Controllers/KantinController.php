<?php

namespace App\Http\Controllers;

use App\Models\Kantin;
use App\Models\User;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator as FacadesValidator;

class KantinController extends Controller
{
    //

    public function index()
    {
        $kantins = Kantin::all();
        return view("dashboard.kantin.index", ['kantin' => $kantins]);
    }


    public function edit($id)
    {

        return view('dashboard.kantin.edit', ['kantin' => Kantin::find($id)]);
    }
    public function destroy(Request $request)
    {
        Kantin::find($request->input('id'))->delete();
        return back();
    }

    public function create()
    {
        return view("dashboard.kantin.create");
    }

    public function store(Request $request)
    {
        $this->validate($request, ['nama' => 'required']);
        $kantin = Kantin::orderBy('created_at', 'asc')->get();
        Kantin::create([
            'nama' => $request->input('nama'),
            'id_kantin' => $kantin->last()->id_kantin + 1
        ]);

        return redirect('/kantin');
    }

    public function update(Request $request)
    {
        $this->validate($request, ['id' => 'required', 'nama' => 'required']);

        $kantin = Kantin::find($request->input('id'));
        $kantin->nama = $request->input('nama');
        $kantin->save();
        return redirect('/kantin');
    }


    public function login(Request $request)
    {
        $validator = FacadesValidator::make($request->all(), [
            'email' => 'required',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->badRequest($validator->errors()->first());
        }
        $user = User::where('email', $request->input('email'))->first();

        if (isset($user)) {
            if ($user->id_role != 3) {
                return $this->badRequest("Ops akun yang kamu gunakan bukanlah kantin");
            }
            return Hash::check($request->input('password'), $user->password) == true ? $user : $this->unauthorized("Harap check username atau password anda");
        }
        return $this->unauthorized("Ops, Username atau password anda salah");
    }

    public function updateFcmToken(Request $request)
    {
        $validator = FacadesValidator::make($request->all(), [
            'id_kantin' => 'required',
            'fcmToken' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->badRequest($validator->errors()->first());
        }
        $user = User::find($request->input('id_kantin'));
        if (isset($user)) {
            $user->update([
                'fcm_token' => $request->input('fcmToken')
            ]);
            return $this->success('Sukses memperbarui fcm token');
        }
        return response()->json([
            'data' => null,
            'message' => 'kantin tidak ditemukan',
            'code' => 4 - 4
        ], 404);
    }


    private function success($message)
    {
        return response()->json([
            'data' => true,
            'message' => $message,
            'code' => 200
        ], 200);
    }



    private function badRequest($message)
    {
        return response()->json([
            'data' => null,
            'message' => $message,
            'code' => 400
        ], 400);
    }

    private function unauthorized($message)
    {
        return response()->json([
            'data' => null,
            'message' => $message,
            'code' => 401
        ], 401);
    }



}
