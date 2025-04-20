<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Inventory;
use App\Models\InventoryHistory;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = 10;
        $currentPageNum = 1;

        $isSingleView = false;
        $view = 'pages.products.list';

        $query = Product::query();
        $query->orderBy('id','desc');
        $totalRecords = Product::count();

        $pageNums = $totalRecords / $perPage;
        $totalpagenums = is_float($pageNums) ? (int)$pageNums + 1 : $pageNums;
        $skipCount = ($currentPageNum-1) * $perPage;

        if(!empty($request->input('perPage'))){
            $perPage = $request->input('perPage');
            $isSingleView = true;
        }
        if(!empty($request->input('currentPage'))){
            $currentPageNum = $request->input('currentPage');
            $isSingleView = true;

        }
        if(!empty($request->input('searchString')) || $request->has('searchString')){
            $searchString =$request->input('searchString');
            $isSingleView = true;
            $query->where('product_description','LIKE',"%{$searchString}%");

        }        

        if($isSingleView){
            $view = 'pages.products.single';

        }

        $query->take($perPage);

        $query->skip($skipCount);     
        
        $products = $query->get();

        // $products = Product::orderBy('id','desc')->take($perPage)->skip($skipCount)->get();

        
        return view($view,compact('products','totalpagenums','totalRecords'));        
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
            'gst_percentage' => 'required',

        ]);

        Product::create([
            'product_description'=>$validated['product_description'],
            'hsn_code'=>$validated['hsn_code'],
            'rate'=>$validated['rate'],
            'gst_percentage'=>$validated['gst_percentage'],

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
            'gst_percentage' => 'required',

        ]);

        $product = Product::findOrFail($id);
        if($product){
            $product->product_description = $validated['product_description'];
            $product->hsn_code = $validated['hsn_code'];
            $product->rate = $validated['rate'];
            $product->gst_percentage = $validated['gst_percentage'];
            

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
            Inventory::where('product_id')->delete();
            InventoryHistory::where('product_id')->delete();            
            $product->delete();
            return response()->json(['success' => true, 'message' => 'Product deleted successfully!']);
            
        }
        return response()->json(['success' => false, 'message' => 'Product not Found!']);           
    }

    public function exportProducts(){
        // Fetch products with their related measurements
        $products = Product::get();

        // Generate the filename
        $filename = 'products-' . now()->timestamp . '.csv';

        // Define the path where the file will be stored
        $filePath = storage_path('app/' . $filename);

        // Open the file for writing
        $handle = fopen($filePath, 'w');

        // Add the CSV column headings (optional)
        fputcsv($handle, ['ID','Hsn Code', 'Product Description', 'rate','GST percentage']);

        // Loop through the data and write each row to the CSV file
        foreach ($products as $p) {
            // Write the product row to the CSV
            fputcsv($handle, [
                $p->id,
                $p->hsn_code,
                $p->product_description,
                $p->rate,
                $p->gst_percentage,

            ]);
        }

        // Close the file handle
        fclose($handle);

        // Return the file path so it can be used for the download
        return response()->json(['url_path'=> route('exportDownload',['file'=>$filename])]);

    }

    public function importProducts(Request $request){
        // Validate the uploaded file
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
                    
                Product::upsert($newArray,['id'],['product_description','hsn_code','rate','gst_percentage']);
                                
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
