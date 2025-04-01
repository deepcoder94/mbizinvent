<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use PDO;

class InvoiceProduct extends Model
{
    public $timestamps = false;
    protected $table = 'invoice_products';
    protected $fillable = ['invoice_id','product_id','quantity','rate','discount','tax_rate'];
}