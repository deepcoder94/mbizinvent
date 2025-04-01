<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Customer extends Model
{
    public $timestamps = false;
    protected $fillable = ['customer_name','address','state','state_code','city','phone','gstin_number','pan_number'];
}