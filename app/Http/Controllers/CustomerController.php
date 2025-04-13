<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = 10;
        $currentPageNum = 1;

        $isSingleView = false;
        $view = 'pages.customers.list';
        $query = Customer::query();
        $query->orderBy('id','desc');
        $skipCount = ($currentPageNum-1) * $perPage;

        $totalRecords = Customer::count();

        $pageNums = $totalRecords / $perPage;
        $totalpagenums = is_float($pageNums) ? (int)$pageNums + 1 : $pageNums;


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
            $query->where('customer_name','LIKE',"%{$searchString}%");

        }
        $query->take($perPage);

        $query->skip($skipCount);


        if($isSingleView){
            $view = 'pages.customers.single';

        }
        $customers = $query->get();



        return view($view,compact('customers','totalpagenums','totalRecords'));
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
            'customer_name' => '',
            'address' => '',
            'state' => '',
            'state_code' => '',
            'city' => '',
            'phone' => '',
            'gstin_number' => '',
            'pan_number' => '',

        ]);

        Customer::create([
            'customer_name'=>$validated['customer_name'],
            'address'=>$validated['address'],
            'state'=>$validated['state'],
            'state_code'=>$validated['state_code'],
            'city'=>$validated['city'],
            'phone'=>$validated['phone'],
            'gstin_number'=>$validated['gstin_number']??'',
            'pan_number'=>$validated['pan_number']??''
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
            'city' => 'string',
            'phone' => 'string',
            'gstin_number' => '',
            'pan_number' => '',

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

    public function exportCustomers(){
        // Fetch products with their related measurements
        $customers = Customer::get();

        // Generate the filename
        $filename = 'customers-' . now()->timestamp . '.csv';

        // Define the path where the file will be stored
        $filePath = storage_path('app/' . $filename);

        // Open the file for writing
        $handle = fopen($filePath, 'w');

        // Add the CSV column headings (optional)
        fputcsv($handle, ['ID','Customer Name', 'Address', 'State','State Code','City','Phone','GSTIN Number','PAN Number']);

        // Loop through the data and write each row to the CSV file
        foreach ($customers as $customer) {
            // Write the product row to the CSV
            fputcsv($handle, [
                $customer->id,
                $customer->customer_name,
                $customer->address,
                $customer->state,
                $customer->state_code,
                $customer->city,
                $customer->phone,
                $customer->gstin_number,
                $customer->pan_number,
            ]);
        }

        // Close the file handle
        fclose($handle);

        // Return the file path so it can be used for the download
        return response()->json(['url_path'=> route('exportDownload',['file'=>$filename])]);

    }

    public function exportDownload(Request $request,$file){
        $path = storage_path('app/' . $file);

        if (!file_exists($path)) {
            abort(404);
        }

        return response()->download($path)->deleteFileAfterSend(true);        
    }

    public function importCustomers(Request $request){
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
                Customer::upsert($newArray,['id'],['customer_name','address','state','state_code','city','phone','gstin_number','pan_number']);
                                
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
