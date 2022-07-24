<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Customer extends Model
{
    use HasFactory;

   
    protected $guarded = ['id'];

    public static $rules = ['title' =>'required|alpha|max:3',
                    'lname'=>'required',
                    'fname'=>'required',
                    'addressline'=>'required',
                    'phone'=>'numeric|min:3',
                    'town'=>'required',
                    'zipcode'=>'required'];

    public static $messages = [
            'required' => 'Ang :attribute field na ito ay kailangan',
            'min' => 'masyadong maigsi ang :attribute',
             'alpha' => 'pawang mga letra lamang',
            'fname.required' => 'pakibigay lang ang inyong pangalan'
        ];
}
