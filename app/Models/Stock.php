<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;
       protected $primaryKey = 'item_id';
    protected $table = 'stock';
    public $timestamps = false;
    protected $fillable = ['item_id','quantity'];
}
