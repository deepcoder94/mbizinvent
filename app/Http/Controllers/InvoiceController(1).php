<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Inventory;
use App\Models\InventoryHistory;
use App\Models\Invoice;
use App\Models\InvoiceProduct;
use App\Models\Product;
use App\Models\Settings;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use ZipArchive;
use Illuminate\Support\Facades\Storage;



class InvoiceController extends Controller
{
    public function invoiceList(Request $request){

        $perPage = 10;
        $currentPageNum = 1;

        $isSingleView = false;
        $view = 'pages.invoice.list';
        $query = Invoice::query();
        $query->orderBy('id','desc');
        $skipCount = ($currentPageNum-1) * $perPage;

        $totalRecords = Invoice::count();

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

        $query->take($perPage);

        $query->skip($skipCount);
        $query->with('customer');


        if($isSingleView){
            $view = 'pages.invoice.single';

        }
        $invoices = $query->get();


        return view($view,compact('invoices','totalpagenums','totalRecords'));
    }

    public function showGenerateForm(){
        $customers = Customer::get();
        $invoiceCount = Invoice::count() + 1;
        $settings = Settings::get()->first();
        return view('pages.generate-invoice.form',compact('customers','invoiceCount','settings'));
    }

    public function addSingleProduct(Request $request){
        $data = Product::with('stock')->get();

        // Filter out products with no stock or out of stock
        $products = $data->filter(function ($product) {
            return isset($product['stock']) && $product['stock']['available_stock'] > 0;
        });        
        
        $index = $request->input('productCount');
        return view('pages.generate-invoice.add-product',compact('products','index'));
    }

    public function generateInvoice(Request $request){

        // Data Preparation
        $data = $request->all();
        // Convert product details into an array of products
        $products = collect($data['product_id'])->map(function ($id, $index) use ($data) {
            $product = Product::where('id',$id)->get()->first();
            return [
                'product_id' => $id,
                'product_description' => $product->product_description,
                'hsn_code' => $product->hsn_code,
                'quantity' => number_format($data['product_qty'][$index],0),
                'mrp' => $data['product_mrp'][$index],
                'rate' => $data['product_rate'][$index],
                'gross_total' => $data['product_gross_total'][$index],
                'discount' => $data['product_discount'][$index],
                'discount_amt' => $data['product_discount_amt'][$index],
                'taxable_value' => $data['product_taxable_value'][$index],
                'tax_rate' => $data['product_tax_rate'][$index],
                'cgst_perc' => $data['product_cgst_perc'][$index],
                'cgst' => $data['product_cgst'][$index],
                'sgst_perc' => $data['product_sgst_perc'][$index],
                'sgst' => $data['product_sgst'][$index],
                'total_amount' => $data['product_total_amt'][$index] + $data['product_cgst'][$index] + $data['product_sgst'][$index],
            ];
        })->toArray();


        // Final structured array
        $invoice = [
            'customer_id' => $data['customer_id'],
            'invoice_number' => $data['invoice_number'],
            'invoice_date' => $data['invoice_date'],
            'products' => $products,
            'total_round_off' => $data['total_round_off'],
            'total_quantity' => number_format($data['total_quantity'],0),
            'total_mrp' => $data['total_rate'],
            'total_discount' => $data['total_discount'],
            'total_discount_amt' => $data['total_discount_amt'],
            'total_taxable_value' => $data['total_taxable_value'],
            'total_gross_sum' => $data['total_gross_sum'],
            'total_cgst' => $data['total_cgst'],
            'total_cgst_perc' => $data['total_cgst_perc'],
            'total_sgst' => $data['total_sgst'],
            'total_sgst_perc' => $data['total_sgst_perc'],
            'total_grand' => $data['total_grand']
        ];



        $insinvoice = Invoice::create([
            'invoice_number'=>$invoice['invoice_number'],
            'customer_id'=>$invoice['customer_id'],
            'round_off'=>$invoice['total_round_off'],
            'total'=>$invoice['total_grand']
        ]);
        $customer = Customer::where('id',$data['customer_id'])->first();
        $settings = Settings::get()->first();

        $custhtml='';
        if(!empty($customer->customer_name)){
            $custhtml .= 'Name: '.$customer->customer_name;
        }
        if(!empty($customer->address)){
            $custhtml .= '<br>Address: '.$customer->address;
        }        
        if(!empty($customer->state)){
            $custhtml .= '<br>State: '.$customer->state;
        }                
        if(!empty($customer->state_code)){
            $custhtml .= '<br>State Code: '.$customer->state_code;
        }                
        if(!empty($customer->gstin_number)){
            $custhtml .= '<br>GSTIN No: '.$customer->gstin_number;
        }                
        if(!empty($customer->phone)){
            $custhtml .= '<br>Mobile: '.$customer->phone;
        }                        
        if(!empty($customer->pan_number)){
            $custhtml .= '<br>PAN: '.$customer->pan_number;
        }                                


        foreach($invoice['products'] as $p){
           $product = Inventory::where('product_id',$p['product_id'])->get()->first();
           $product->available_stock -= $p['quantity'];
           $product->save();

           InventoryHistory::create([
                'product_id'=>$p['product_id'],
                'stock_out_in'=>$p['quantity'],
                // 'buying_price'=>$p['rate'],
                'action'=>'removed'
            ]);

            InvoiceProduct::create([
                'invoice_id'=>$insinvoice->id,
                'product_id'=>$p['product_id'],
                'quantity'=>$p['quantity'],
                'rate'=>$p['rate'],
                'discount'=>$p['discount'],
                'tax_rate'=>$p['tax_rate'],
                'total'=>$p['total_amount']
            ]);
        }


        // Create a new ZIP file in storage
        $time = time();
        $invno = $insinvoice->invoice_number;
        $filename = 'invoices-'.$invno."-".$time.'.pdf';
        $filePath = storage_path('app/' . $filename);

        // $zipFileName = $filename.'.zip';
        // $zipFilePath = storage_path('app/' . $zipFileName);
        // $zip = new ZipArchive();

        // Open the zip file for writing
        // if ($zip->open($zipFilePath, ZipArchive::CREATE) !== TRUE) {
        //     return response()->json(['error' => 'Failed to create zip file'], 500);
        // }        

        
            $pdf = PDF::loadView('pages.generate-invoice.invoice-format',compact('invoice','customer','settings','custhtml'));
            // $pdf->setPaper('A5','landscape');
            $pdf->setPaper('a4', 'portrait');

            // Set individual DOMPDF options correctly
            $pdf->set_option('defaultFont', 'Arial');
            $pdf->set_option('isHtml5ParserEnabled', true);
            $pdf->set_option('isRemoteEnabled', true);
            $pdf->set_option('isPhpEnabled', true);
            $pdf->set_option('margin_top', 0);
            $pdf->set_option('margin_bottom', 0);
            $pdf->set_option('margin_left', 0);
            $pdf->set_option('margin_right', 0);            
            // $pdfContent = $pdf->output();
            file_put_contents($filePath, $pdf->output());

            // Add the PDF to the zip with a unique filename (e.g., invoice number)
            // $zip->addFromString($filename.'.pdf', $pdfContent);


        // Close the zip file
        // $zip->close();

        // Prepare the zip file for download
        return response()->json([
            'zipUrl' => route('downloadZip', ['file' => $filename])
        ]);
        
    }

    public function downloadZip($file)
    {
        $path = storage_path('app/public/' . $file);

        if (!file_exists($path)) {
            abort(404);
        }

        return response()->download($path)->deleteFileAfterSend(true);
    }    
    
    public function downloadSample(){
        $path = storage_path('app/public/invoices2.csv');

        if (!file_exists($path)) {
            abort(404);
        }
        
        return response()->download($path);
    }
    
    public function getSample(){

        return response()->json([
            'zipUrl' => route('downloadSample')
        ]);        
    }

    public function getProductInfo(Request $request){
        $id = $request->input('id');
        $product = Product::with('stock')->where('id',$id)->get()->first();
        $settings = Settings::get()->first();

        return response()->json([
            'success'=>true,
            'data'=>$product,
            'profit'=>$settings->profit_calc
        ]); 
    }
    

    public function genInv(Request $request){

        $request->validate([
            'file_csv' => 'required|mimes:csv,txt|max:2048', // You can adjust file type and size
        ]);

        // Handle file upload
        if ($request->hasFile('file_csv')) {
            $file = $request->file('file_csv');
        }

        $path = $request->file('file_csv')->store('csv_files','public');

            // // Process the CSV (example)
            // $csvData = $this->parseCsv($file);

        $path = storage_path('app/public/'.$path);

        // Step 1: Read the CSV into array of rows
        $csv = array_map('str_getcsv', file($path));

        // Step 2: Extract headers
        $headers = array_shift($csv);        
        // dd($csvData,$csv,$headers);

        // Step 3: Group by Invoice No
        $invoices = [];
        $currentInvoiceNo = null;

        foreach ($csv as $row) {
            // Combine headers with values, and trim each value
            $rowData = collect($headers)->combine($row)->map(fn($val) => trim($val))->toArray();

            // If the row has a new invoice number, update tracker
            if (!empty($rowData['Invoice No'])) {
                $currentInvoiceNo = $rowData['Invoice No'];
            }

            // If an invoice number is being tracked, assign this row to it
            if ($currentInvoiceNo) {
                // Remove 'Invoice No' from row (since it's already the key)
                unset($rowData['Invoice No']);
                $invoices[$currentInvoiceNo][] = $rowData;
            }
        }

        // Step 4: Convert to collection (optional)
        $collection = collect($invoices)->toArray(); 
        $newc = [];

        foreach ($collection as $mainKey => $items) {
            $customer_id = $items[0]['Customer ID'];
            $invoice_date = $items[0]['Invoice Date'];

            $newc[$mainKey]['customer_id']=$customer_id;
            $newc[$mainKey]['invoice_date']=$invoice_date;
            $newc[$mainKey]['total_round_off']=$items[0]['Total Round Off'];
            $newc[$mainKey]['products']=$items;


            foreach ($items as $index => $item) {
                $grouped = [];

                $grouped[$index] = [
                    'profit' => [],
                    'discount_percentage' => [],
                    'discount_amount' => [],
                ];
        
                foreach ($item as $field => $value) {
                    if (stripos($field, 'Profit') === 0) {
                        $grouped[$index]['profit'][$field] = $value;
                    } elseif (preg_match('/^Discount \d+ %$/', $field)) {
                        $grouped[$index]['discount_percentage'][$field] = $value;
                    } elseif (preg_match('/^Total Discount \d+ %$/', $field)) {
                        // $grouped[$index]['total_discount_percentage'][$field] = $value;
                        $newc[$mainKey]['total_discount_percentage'][] = $value;
                    }
                    elseif (preg_match('/^Total Discount \d+ Amount$/', $field)) {
                        // $grouped[$index]['total_discount_amount'][$field] = $value;
                        $newc[$mainKey]['total_discount_amount'][] = $value;

                    }                    
                     elseif (preg_match('/^Discount \d+ Amount$/', $field)) {
                        $grouped[$index]['discount_amount'][$field] = $value;
                    }
                }
                $newc[$mainKey]['products'][$index]['results'] = $grouped;
                // $collection[$mainKey][$index]['products'] = $grouped;
            }

        }


        $finalArray=[];
        $totaldcalc = 0;
        $totaldacalc = 0;
        $totaltaxableamount = 0;
        $totalgrosssum = 0;
        $totalquantity = 0;
        $totalmrp=0;
        $total_single_gst_rate = 0;
        $total_single_gst_perc = 0;
        $total_grand = 0;


        foreach($newc as $index => $c){
            $finalArray['customer_id']=(int)$c['customer_id'];
            $finalArray['total_round_off']=!empty($c['total_round_off'])?floatval($c['total_round_off']):0;
            $finalArray['invoice_number']=$index;
            $finalArray['invoice_date']=$c['invoice_date'];

            foreach($c['products'] as $p){
                $product = Product::where('id',$p['Product ID'])->get()->first();

                $mrp = $rate = floatval($p['MRP']);
                $totalmrp+=$mrp;
                $gross_value=0;
                $taxable_value=0;
                $total_with_gst=0;

                $first_key = array_key_first($p['results']);
                $totalquantity += floatval($p['Quantity']);
                $totalpcalc = 0;
                $pcalc = $p['results'][$first_key]['profit'];
                foreach($pcalc as $d => $v){
                    if(!empty($v)){
                        $prft = floatval($v);
                        $rate /= $prft;

                        $totalpcalc += floatval($v);    
                    }
                }

                $gross_value = $rate * floatval($p['Quantity']);
                $totalgrosssum+=$gross_value;

                $dcalc = $p['results'][$first_key]['discount_percentage'];
                $tdclc = 0;
                foreach($dcalc as $d => $v){
                    if(!empty($v)){
                        $disc =  floatval($v)/100 + 1;
                        $rate /= $disc;
                        $totaldcalc += floatval($v);
                        $tdclc +=floatval($v);
                    }
                }

                $dacalc = $p['results'][$first_key]['discount_amount'];
                $tdcla = 0;
                foreach($dacalc as $d => $v){
                    $disa = !empty($v) ? floatval($v):0;
                    $rate -= $disa;
                    $totaldacalc += !empty($v) ? floatval($v):0;
                    $tdcla += floatval($v);
                }

                $taxable_value = $rate * floatval($p['Quantity']);
                $totaltaxableamount+=$taxable_value;


                if(!empty($p['GST %'])){
                    $total_single_gst_perc += floatval($p['GST %']);

                    $gst_perc =  floatval($p['GST %'])/100;
                    $gst_total = $taxable_value * $gst_perc;
                    $total_single_gst_rate += $gst_total / 2;
                    $total_with_gst = $taxable_value+$gst_total;
                    $total_grand += $total_with_gst;
                }

                
                

                $finalArray['products'][]=[
                    'product_id'=>(int)$p['Product ID'],
                    'product_description' => $product->product_description,
                    'hsn_code' => $product->hsn_code,
                    'quantity' => floatval($p['Quantity']),
                    'mrp' => floatval($this->roundOff($p['MRP'])),
                    'rate' => floatval($this->roundOff($rate)),
                    'gross_total' => floatval($this->roundOff($gross_value)),
                    'discount' => floatval($this->roundOff($tdclc)),
                    'discount_amt' => floatval($this->roundOff($tdcla)),
                    'taxable_value' => floatval($this->roundOff($taxable_value)),
                    'tax_rate' => floatval($this->roundOff($p['GST %'])),
                    'cgst_perc' => floatval($this->roundOff(($p['GST %'])/2)),
                    'cgst' => floatval($this->roundOff($gst_total/2)),
                    'sgst_perc' => floatval($this->roundOff(($p['GST %'])/2)),
                    'sgst' => floatval($this->roundOff($gst_total/2)),
                    'total_amount' => floatval($this->roundOff($total_with_gst,2)),
                    
                ];
            }

            $finalArray['total_quantity'] = $this->roundOff($totalquantity,2);
            $finalArray['total_mrp'] = $this->roundOff($totalmrp,2);
            $finalArray['total_discount'] = $this->roundOff(floatval($totaldcalc),2);
            $finalArray['total_discount_amt'] = $this->roundOff($totaldacalc,2);
            $finalArray['total_taxable_value'] = $this->roundOff(floatval($totaltaxableamount));
            $finalArray['total_gross_sum'] = $this->roundOff(floatval($totalgrosssum));
            $finalArray['total_cgst'] = $this->roundOff(floatval($total_single_gst_rate));
            $finalArray['total_cgst_perc'] = $this->roundOff(floatval($total_single_gst_perc));
            $finalArray['total_sgst'] = $this->roundOff(floatval($total_single_gst_rate));
            $finalArray['total_sgst_perc'] = $this->roundOff(floatval($total_single_gst_perc));
            $finalArray['total_grand'] = $this->roundOff(floatval($total_grand));
        }


        $insinvoice = Invoice::create([
            'invoice_number'=>$finalArray['invoice_number'],
            'customer_id'=>$finalArray['customer_id'],
            'round_off'=>$finalArray['total_round_off'],
            'total'=>$finalArray['total_grand']
        ]);
        $customer = Customer::where('id',$finalArray['customer_id'])->first();
        $settings = Settings::get()->first();

        $custhtml='';
        if(!empty($customer->customer_name)){
            $custhtml .= 'Name: '.$customer->customer_name;
        }
        if(!empty($customer->address)){
            $custhtml .= '<br>Address: '.$customer->address;
        }        
        if(!empty($customer->state)){
            $custhtml .= '<br>State: '.$customer->state;
        }                
        if(!empty($customer->state_code)){
            $custhtml .= '<br>State Code: '.$customer->state_code;
        }                
        if(!empty($customer->gstin_number)){
            $custhtml .= '<br>GSTIN No: '.$customer->gstin_number;
        }                
        if(!empty($customer->phone)){
            $custhtml .= '<br>Mobile: '.$customer->phone;
        }                        
        if(!empty($customer->pan_number)){
            $custhtml .= '<br>PAN: '.$customer->pan_number;
        }                                


        foreach($finalArray['products'] as $p){
           $product = Inventory::where('product_id',$p['product_id'])->get()->first();
           $product->available_stock -= $p['quantity'];
           $product->save();

           InventoryHistory::create([
                'product_id'=>$p['product_id'],
                'stock_out_in'=>$p['quantity'],
                // 'buying_price'=>$p['rate'],
                'action'=>'removed'
            ]);

            InvoiceProduct::create([
                'invoice_id'=>$insinvoice->id,
                'product_id'=>$p['product_id'],
                'quantity'=>$p['quantity'],
                'rate'=>$p['rate'],
                'discount'=>$p['discount'],
                'tax_rate'=>$p['tax_rate'],
                'total'=>$p['total_amount']
            ]);
        }


        // Create a new ZIP file in storage
        $time = time();
        $invno = $insinvoice->invoice_number;
        $filename = 'invoices-'.$time.'.pdf';
        $filePath = storage_path('app/' . $filename);

        // $zipFileName = $filename.'.zip';
        // $zipFilePath = storage_path('app/' . $zipFileName);
        // $zip = new ZipArchive();

        // Open the zip file for writing
        // if ($zip->open($zipFilePath, ZipArchive::CREATE) !== TRUE) {
        //     return response()->json(['error' => 'Failed to create zip file'], 500);
        // }        
            $invoice = $finalArray;
        
            $pdf = PDF::loadView('pages.generate-invoice.invoice-format',compact('invoice','customer','settings','custhtml'));
            // $pdf->setPaper('A5','landscape');
            $pdf->setPaper('a4', 'portrait');

            // Set individual DOMPDF options correctly
            $pdf->set_option('defaultFont', 'Arial');
            $pdf->set_option('isHtml5ParserEnabled', true);
            $pdf->set_option('isRemoteEnabled', true);
            $pdf->set_option('isPhpEnabled', true);
            $pdf->set_option('margin_top', 0);
            $pdf->set_option('margin_bottom', 0);
            $pdf->set_option('margin_left', 0);
            $pdf->set_option('margin_right', 0);            
            // $pdfContent = $pdf->output();
            // file_put_contents($filePath, $pdf->output());
            Storage::disk('public')->put($filename, $pdf->output());

            // Add the PDF to the zip with a unique filename (e.g., invoice number)
            // $zip->addFromString($filename.'.pdf', $pdfContent);


        // Close the zip file
        // $zip->close();
        // Convert full path to relative storage path:
        $relativePath = str_replace(storage_path('app/public') . '/', '', $path);
        
        // Now delete
        Storage::disk('public')->delete($relativePath);


        // Prepare the zip file for download
        return response()->json([
            'zipUrl' => route('downloadZip', ['file' => $filename])
        ]);
        

        // Final structured array
        // $invoice = [
        //     'customer_id' => $data['customer_id'],
        //     'invoice_number' => $data['invoice_number'],
        //     'invoice_date' => $data['invoice_date'],
        //     'products' => $products,
        //     'total_round_off' => $data['total_round_off'],
        //     'total_quantity' => $data['total_quantity'],
        //     'total_mrp' => $data['total_rate'],
        //     'total_discount' => $data['total_discount'],
        //     'total_discount_amt' => $data['total_discount_amt'],
        //     'total_taxable_value' => $data['total_taxable_value'],
        //     'total_gross_sum' => $data['total_gross_sum'],
        //     'total_cgst' => $data['total_cgst'],
        //     'total_cgst_perc' => $data['total_cgst_perc'],
        //     'total_sgst' => $data['total_sgst'],
        //     'total_sgst_perc' => $data['total_sgst_perc'],
        //     'total_grand' => $data['total_grand']
        // ];

            // return [
            //     'product_id' => $id,
            //     'product_description' => $product->product_description,
            //     'hsn_code' => $product->hsn_code,
            //     'quantity' => $data['product_qty'][$index],
            //     'mrp' => $data['product_mrp'][$index],
            //     'rate' => $data['product_rate'][$index],
            //     'gross_total' => $data['product_gross_total'][$index],
            //     'discount' => $data['product_discount'][$index],
            //     'discount_amt' => $data['product_discount_amt'][$index],
            //     'taxable_value' => $data['product_taxable_value'][$index],
            //     'tax_rate' => $data['product_tax_rate'][$index],
            //     'cgst_perc' => $data['product_cgst_perc'][$index],
            //     'cgst' => $data['product_cgst'][$index],
            //     'sgst_perc' => $data['product_sgst_perc'][$index],
            //     'sgst' => $data['product_sgst'][$index],
            //     'total_amount' => $data['product_total_amt'][$index],
            // ];

    }

    public function roundOff($value,$precision=2){

        $rounded = ceil($value * pow(10, $precision)) / pow(10, $precision);
        return $rounded;
    }    
}