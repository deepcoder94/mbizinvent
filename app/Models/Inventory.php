<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use PDO;

class Inventory extends Model
{
    public $timestamps = false;
    protected $table = 'inventory';
    protected $fillable = ['product_id','available_stock','buying_price'];

    public function product(){
        return $this->belongsTo(Product::class,'product_id');
    }
}