<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Product extends Model
{
    public $timestamps = false;
    protected $fillable = ['product_description','hsn_code','rate','gst_percentage'];

    public function stock(){
        return $this->hasOne(Inventory::class,'product_id');
    }
}