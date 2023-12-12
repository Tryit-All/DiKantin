<?php

namespace App\Http\Controllers;
use RealRashid\SweetAlert\Facades\Alert; 
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:customer-list|customer-create|customer-edit|customer-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:customer-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:customer-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:customer-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $customer = Customer::all();
        // return $customer;
        return view('dashboard.customer.index', [
            'title' => 'customer',
            'customer' => $customer
        ]);
    }

    public function search(Request $request)
    {
        $data = Customer::select("id_customer")->where("id_customer", "LIKE", "{$request->query}%")->get();
        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Add Customer';
        $lastCustomer = Customer::latest()->first();

        $newId = 'CUST00001'; // ID default jika tabel kosong

        if ($lastCustomer) {
            // Jika ada data sebelumnya, ambil ID terakhir
            $lastId = $lastCustomer->id_customer;

            // Ambil angka dari ID terakhir, tambahkan 1, dan format ulang
            $number = intval(substr($lastId, 4)) + 1;
            $newId = 'CUST' . str_pad($number, 5, '0', STR_PAD_LEFT);
        }

        return view('dashboard.customer.create', compact('title','newId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // return "anu";
        $this->validate($request, [
            "id_customer" => 'required|unique:customer,id_customer',
            "nama" => 'required',
            "alamat" => 'required',
            "no_telepon" => 'required'
        ]);
        // Customer::insert($data);
        Customer::create($request->all());
        Alert::success('Success', 'Berhasil Tambah Data');

        return redirect('/pelanggan');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {

        $data = Customer::findOrFail($id);
        return view('dashboard.customer.edit')->with([
            'data' => $data,
            'title' => 'Edit Data'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = Customer::find($id);
        $title = "Edit Customer";
        return view('dashboard.customer.edit', compact(['data', 'title']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $data = Customer::where('id_customer', $id)
            ->first();

        if (!$data) {
            return abort(404); // Or handle the case where the record is not found.
        }

        Customer::where('id_customer', $id)->update([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'no_telepon' => $request->no_telepon,
        ]);

        return redirect('/pelanggan');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $customer = Customer::find($id);
        $customer->delete();
        return redirect('/pelanggan');
    }
}
