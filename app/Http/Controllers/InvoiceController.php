<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Product;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use ZipArchive;
use Carbon\Carbon;

class InvoiceController extends Controller
{
    public function invoiceList(Request $request){

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
        // Create a new ZIP file in storage
        $zipFileName = 'invoices.zip';
        $zipFilePath = storage_path('app/' . $zipFileName);
        $zip = new ZipArchive();

        // Open the zip file for writing
        if ($zip->open($zipFilePath, ZipArchive::CREATE) !== TRUE) {
            return response()->json(['error' => 'Failed to create zip file'], 500);
        }        

            $pdf = PDF::loadView('pages.generate-invoice.invoice-format');
            $pdf->setPaper('A6');
            $pdfContent = $pdf->output();

            // Add the PDF to the zip with a unique filename (e.g., invoice number)
            $zip->addFromString('invoices.pdf', $pdfContent);


        // Close the zip file
        $zip->close();

        // Prepare the zip file for download
        return response()->json([
            'zipUrl' => route('downloadZip', ['file' => $zipFileName])
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