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
        $invntryCount = Inventory::count();
        $productCount = Product::count();

        $exproducts = Product::whereNotIn('id', function($query) {
            $query->select('product_id')->from('inventory');
        })->get();        

        if(!empty($exproducts)){
            foreach($exproducts as $ex){
                Inventory::create([
                    'product_id'=>$ex->id,
                    'available_stock'=>0,
                    // 'buying_price'=>$ex->rate
                ]);
            }
        }

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
            // 'buying_price' => 'required',
        ]);

        $inventory = Inventory::where('product_id',$validated['product_id'])->first();
        if($inventory){
            InventoryHistory::create([
                'product_id'=>$validated['product_id'],
                'stock_out_in'=>$validated['stock_count'],
                // 'buying_price'=>$validated['buying_price'],
                'action'=>'added'
            ]);

            $total_stock = $inventory->available_stock + $validated['stock_count'];
            $inventory->available_stock = $total_stock;
            $inventory->save();
            return response()->json(['success' => true, 'message' => 'Inventory updated successfully!']);            

        }
        Inventory::create([
            'product_id'=>$validated['product_id'],
            'available_stock'=>$validated['stock_count'],
            // 'buying_price'=>$validated['buying_price'],
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

    public function inventoryHistory(Request $request){

        $perPage = 10;
        $currentPageNum = 1;

        $isSingleView = false;
        $view = 'pages.inventory-history.list';
        if(!empty($request->input('perPage'))){
            $perPage = $request->input('perPage');
            $isSingleView = true;
        }
        if(!empty($request->input('currentPage'))){
            $currentPageNum = $request->input('currentPage');
            $isSingleView = true;

        }

        $skipCount = ($currentPageNum-1) * $perPage;

        if($isSingleView){
            $view = 'pages.inventory-history.single';

        }
        $history = InventoryHistory::with('product')->orderBy('id','desc')->take($perPage)->skip($skipCount)->get();


        $totalRecords = InventoryHistory::count();

        $pageNums = $totalRecords / $perPage;
        $totalpagenums = is_float($pageNums) ? (int)$pageNums + 1 : $pageNums;


        // $history = InventoryHistory::with('product')->orderBy('id','desc')->get();
        return view($view,compact('history','totalpagenums','totalRecords'));        

    }

    public function exportInventory(){
        $inventory = Inventory::with('product')->orderBy('id','desc')->get();
        
        // Generate the filename
        $filename = 'inventory-' . now()->timestamp . '.csv';

        // Define the path where the file will be stored
        $filePath = storage_path('app/' . $filename);

        // Open the file for writing
        $handle = fopen($filePath, 'w');

        // Add the CSV column headings (optional)
        // fputcsv($handle, ['Product ID','Product Description', 'Stock', 'Buying Price']);
        fputcsv($handle, ['Product ID','Product Description', 'Stock']);


        // Loop through the data and write each row to the CSV file
        foreach ($inventory as $i) {
            // Write the product row to the CSV
            fputcsv($handle, [
                $i->product->id,
                $i->product->product_description,
                $i->available_stock,
                // $i->buying_price,
            ]);
        }

        // Close the file handle
        fclose($handle);

        // Return the file path so it can be used for the download
        return response()->json(['url_path'=> route('exportDownload',['file'=>$filename])]);
        
    }

    public function importInventory(Request $request){
        $request->validate([
            'file_csv' => 'required|mimes:csv,txt|max:2048', // You can adjust file type and size
        ]);

        // Handle file upload
        if ($request->hasFile('file_csv')) {
            $file = $request->file('file_csv');

            // Process the CSV (example)
            $csvData = $this->parseCsv($file);
            foreach ($csvData as $csv) {
                // Use Laravel's Collection to transform the keys
                $newArray = collect($csv)
                    ->mapWithKeys(function ($value, $key) {
                        // Convert the key to lowercase and replace spaces with underscores
                        $newKey = strtolower(str_replace(' ', '_', $key));
                        return [$newKey => $value];
                    })
                    ->toArray();

                $inv = Inventory::where('product_id',$newArray['product_id'])->get()->first();
                if($inv->available_stock < $newArray['stock']){
                    InventoryHistory::create([
                        'product_id'=>$newArray['product_id'],
                        'stock_out_in'=>$newArray['stock']-$inv->available_stock,
                        // 'buying_price'=>$newArray['buying_price'],
                        'action'=>'added'
                    ]);
                }

                $inv->available_stock = $newArray['stock'];
                // $inv->buying_price = $newArray['buying_price'];

                $inv->save();
            }

            return response()->json(['success' => 'File uploaded successfully!']);
        }

        return response()->json(['error' => 'No file uploaded.'], 400);          
    }

    private function parseCsv($file)
    {
        $csvData  = [];
        $filePath = $file->getRealPath();
        $file     = fopen($filePath, 'r');

        // Assuming the first row contains headers
        $header = fgetcsv($file);

        while (($row = fgetcsv($file)) !== false) {
            $csvData[] = array_combine($header, $row); // Combine headers with data
        }

        fclose($file);

        return $csvData;
    }        
}
