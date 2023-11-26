<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customer = Customer::all();
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
        return view('dashboard.customer.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            "id_customer" => 'required|unique:customers,id_customer',
            "nama" => 'required',
            "alamat" => 'required',
            "no_telepon" => 'required'
        ]);
        // Customer::insert($data);
        Customer::create($request->all());
        return redirect('/customer');
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
        $data = Customer::find($id);
        $data->update($request->all());
        return redirect('/customer');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $customer = Customer::find($id);
        $customer->delete();
        return redirect('/customer');
    }
}