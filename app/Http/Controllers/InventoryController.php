<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\InventoryHistory;
use App\Models\Product;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $inventory = Inventory::with('product')->orderBy('id','desc')->get();
        return view('pages.inventory.list',compact('inventory'));        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::get();
        return view('pages.inventory.add',compact('products'));        

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'product_id' => 'required',
            'stock_count' => 'required',
            'buying_price' => 'required',
        ]);

        $inventory = Inventory::where('product_id',$validated['product_id'])->first();
        if($inventory){
            InventoryHistory::create([
                'product_id'=>$validated['product_id'],
                'stock_out_in'=>$validated['stock_count'],
                'buying_price'=>$validated['buying_price']
            ]);

            $total_stock = $inventory->available_stock + $validated['stock_count'];
            $inventory->available_stock = $total_stock;
            $inventory->save();
            return response()->json(['success' => true, 'message' => 'Inventory updated successfully!']);            

        }
        Inventory::create([
            'product_id'=>$validated['product_id'],
            'available_stock'=>$validated['stock_count'],
            'buying_price'=>$validated['buying_price'],
        ]);

        return response()->json(['success' => true, 'message' => 'Inventory created successfully!']);            
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function inventoryHistory(){
        $history = InventoryHistory::with('product')->orderBy('id','desc')->get();
        return view('pages.inventory-history.list',compact('history'));        

    }
}
