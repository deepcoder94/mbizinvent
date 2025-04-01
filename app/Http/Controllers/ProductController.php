<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $currentPage = 'productList';
        $products = Product::orderBy('id','desc')->get();
        return view('pages.products.list',compact('currentPage','products'));        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.products.add-or-edit');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'product_description' => 'required|string',
            'hsn_code' => 'required',
            'rate' => 'required',
        ]);

        Product::create([
            'product_description'=>$validated['product_description'],
            'hsn_code'=>$validated['hsn_code'],
            'rate'=>$validated['rate'],
        ]);

        return response()->json(['success' => true, 'message' => 'Product created successfully!']);        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::findOrFail($id);
        return view('pages.products.add-or-edit',compact('product'));        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $validated = $request->validate([
            'product_description' => 'required|string',
            'hsn_code' => 'required',
            'rate' => 'required',
        ]);

        $product = Product::findOrFail($id);
        if($product){
            $product->product_description = $validated['product_description'];
            $product->hsn_code = $validated['hsn_code'];
            $product->rate = $validated['rate'];

            $product->save();
        }

        return response()->json(['success' => true, 'message' => 'Product updated successfully!']);        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        if($product){
            $product->delete();
            return response()->json(['success' => true, 'message' => 'Product deleted successfully!']);
            
        }
        return response()->json(['success' => false, 'message' => 'Product not Found!']);           
    }
}
