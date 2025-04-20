<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Settings extends Model
{
    public $timestamps = false;
    protected $table = 'settings';
    protected $fillable = ['dist_name','address','city','state','state_code','phone','gstin_number','pan_number','profit_calc'];
}