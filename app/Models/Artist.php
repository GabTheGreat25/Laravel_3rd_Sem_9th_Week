<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;
// use App\DataTables\ArtistsDataTable;
class Artist extends Model implements Searchable
{
    use HasFactory;
    protected $guarded = ['id'];
    public $searchableType = 'Artist Searched';
    public static $rules = [  
            'artist_name' =>'required|min:3',
             'image' => 'required|image'
            ];


     public function albums() {
        return $this->hasMany('App\Models\Album','artist_id');
    }




    public function getSearchResult(): SearchResult
     {
        $url = url('show-artist/'.$this->id);
     
         return new \Spatie\Searchable\SearchResult(
            $this,
            $this->artist_name,
            $url
            );
     }

    
}
