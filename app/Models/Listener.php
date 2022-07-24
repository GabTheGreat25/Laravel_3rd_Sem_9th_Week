<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Listener extends Authenticatable implements Searchable
{
    use HasFactory;

    public $remember_token = false;

     protected $fillable = ['listener_name', 'email','password', 'is_admin', 'role'];


     public function albums() {
        // return $this->belongsTo('App\Models\Albums');
        return $this->belongsToMany('App\Models\Album');

    }

    public function getSearchResult(): SearchResult
     {
        $url = url('show-listener/'.$this->id);
     
         return new \Spatie\Searchable\SearchResult(
            $this,
            $this->listener_name,
            $url
            );
     }


     public static $auth_rules = [
            'username' => 'required',
            'password' => 'required'
        ];

}
