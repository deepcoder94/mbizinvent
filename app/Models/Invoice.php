<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use PDO;

class Invoice extends Model
{
    public $timestamps = false;
    protected $table = 'invoices';
    protected $fillable = ['invoice_number','customer_id'];
}