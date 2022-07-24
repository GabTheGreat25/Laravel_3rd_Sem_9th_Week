<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;
class Customer extends Model  implements Searchable
{
    public $table = 'customers';
    public $primaryKey = 'customer_id';
    public $timestamps = false;
    protected $fillable = ['fname','lname',
        'title','addressline','town','zipcode',
        'phone','email','id'
    ];
     public function orders(){
        return $this->hasMany('App\Models\Order','customer_id');
    }
    public function getSearchResult(): SearchResult
     {
        $url = route('customer.show', $this->customer_id);
         return new \Spatie\Searchable\SearchResult(
            $this,
            // concat($this->lname + $this->fname),
            $this->lname,
            $url
            );
     }
}