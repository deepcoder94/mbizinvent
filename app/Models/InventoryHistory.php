<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use PDO;

class InventoryHistory extends Model
{
    public $timestamps = false;
    protected $table = 'inventory_history';
    protected $fillable = ['product_id','stock_out_in','buying_price','action'];

    public function product(){
        return $this->belongsTo(Product::class,'product_id');
    }
}