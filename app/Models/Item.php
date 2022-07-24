<?php
namespace App\Models;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
class Item extends Model implements Searchable
{
   public $primaryKey = 'item_id';
   public $table = 'item';
   public $timestamps = false;
   protected $fillable = ['description','sell_price','cost_price','img_path'
    ];
    public $searchableType = 'List of Items';
   public function orders() {
    return $this->belongToMany(Order::class,'orderline','orderinfo_id','item_id')->withPivot('quantity');
    // return $this->belongToMany(Order::class);
  }
    public function stock(){
      return $this->hasOne('App\Models\Stock','item_id');
    }
    public function getSearchResult(): SearchResult
     {
        $url = route('item.edit', $this->item_id);
         return new \Spatie\Searchable\SearchResult(
            $this,
            $this->description,
            $url
               );
     }
}