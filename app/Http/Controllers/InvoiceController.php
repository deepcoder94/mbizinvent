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
        return view('pages.generate-invoice.form',compact('customers','invoiceCount'));
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
                'quantity' => $data['product_qty'][$index],
                'rate' => $data['product_rate'][$index],
                'gross_total' => $data['product_gross_total'][$index],
                'discount' => $data['product_discount'][$index],
                'taxable_value' => $data['product_taxable_value'][$index],
                'tax_rate' => $data['product_tax_rate'][$index],
                'cgst_perc' => $data['product_cgst_perc'][$index],
                'cgst' => $data['product_cgst'][$index],
                'sgst_perc' => $data['product_sgst_perc'][$index],
                'sgst' => $data['product_sgst'][$index],
                'total_amount' => $data['product_total_amt'][$index],
            ];
        })->toArray();

        // Final structured array
        $invoice = [
            'customer_id' => $data['customer_id'],
            'invoice_number' => $data['invoice_number'],
            'invoice_date' => $data['invoice_date'],
            'products' => $products,
            'total_round_off' => $data['total_round_off'],
            'total_quantity' => $data['total_quantity'],
            'total_rate' => $data['total_rate'],
            'total_gross_sum' => $data['total_gross_sum'],
            'total_discount' => $data['total_discount'],
            'total_taxable_value' => $data['total_taxable_value'],
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
            $custhtml .= '<br>GSTIN Number: '.$customer->gstin_number;
        }                
        if(!empty($customer->phone)){
            $custhtml .= '<br>Mobile: '.$customer->phone;
        }                        
        if(!empty($customer->pan_number)){
            $custhtml .= '<br>PAN Number: '.$customer->pan_number;
        }                                


        foreach($invoice['products'] as $p){
           $product = Inventory::where('product_id',$p['product_id'])->get()->first();
           $product->available_stock -= $p['quantity'];
           $product->save();

           InventoryHistory::create([
                'product_id'=>$p['product_id'],
                'stock_out_in'=>$p['quantity'],
                'buying_price'=>$p['rate'],
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
        $path = storage_path('app/' . $file);

        if (!file_exists($path)) {
            abort(404);
        }

        return response()->download($path)->deleteFileAfterSend(true);
    }    

    public function getProductInfo(Request $request){
        $id = $request->input('id');
        $product = Product::with('stock')->where('id',$id)->get()->first();
        return response()->json([
            'success'=>true,
            'data'=>$product
        ]); 
    }
}