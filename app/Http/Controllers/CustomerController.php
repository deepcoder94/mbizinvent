<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::orderBy('id','desc')->get();
        return view('pages.customers.list',compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.customers.add-or-edit');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'customer_name' => 'required|string',
            'address' => 'required|string',
            'state' => 'required|string',
            'state_code' => 'required|string',
            'city' => 'required|string',
            'phone' => 'required|string',
            'gstin_number' => 'required|string',
            'pan_number' => 'required|string',

        ]);

        Customer::create([
            'customer_name'=>$validated['customer_name'],
            'address'=>$validated['address'],
            'state'=>$validated['state'],
            'state_code'=>$validated['state_code'],
            'city'=>$validated['city'],
            'phone'=>$validated['phone'],
            'gstin_number'=>$validated['gstin_number'],
            'pan_number'=>$validated['pan_number']
        ]);

        return response()->json(['success' => true, 'message' => 'Customer created successfully!']);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $customer = Customer::findOrFail($id);
        return view('pages.customers.add-or-edit',compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        // Validate the incoming request
        $validated = $request->validate([
            'customer_name' => 'required|string',
            'address' => 'required|string',
            'state' => 'required|string',
            'state_code' => 'required|string',
            'city' => 'required|string',
            'phone' => 'required|string',
            'gstin_number' => 'required|string',
            'pan_number' => 'required|string',

        ]);

        $customer = Customer::findOrFail($id);
        if($customer){
            $customer->customer_name = $validated['customer_name'];
            $customer->address = $validated['address'];
            $customer->state = $validated['state'];
            $customer->state_code = $validated['state_code'];
            $customer->city = $validated['city'];
            $customer->phone = $validated['phone'];
            $customer->gstin_number = $validated['gstin_number'];
            $customer->pan_number = $validated['pan_number'];
            $customer->save();
        }

        return response()->json(['success' => true, 'message' => 'Customer updated successfully!']);
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $customer = Customer::findOrFail($id);
        if($customer){
            $customer->delete();
            return response()->json(['success' => true, 'message' => 'Customer deleted successfully!']);
            
        }
        return response()->json(['success' => false, 'message' => 'Customer not Found!']);        
    }
}
