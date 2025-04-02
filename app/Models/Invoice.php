<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use PDO;

class Invoice extends Model
{
    public $timestamps = false;
    protected $table = 'invoices';
    protected $fillable = ['invoice_number','customer_id','round_off','total'];

    public function customer(){
        return $this->belongsTo(Customer::class,'customer_id');
    }
}