<?php

namespace App\Imports;

use App\Models\Artist;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ArtistImport implements ToModel, WithHeadingRow //para mas malinaw pag tawag
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Artist([
            // Artist Import 
            //php artisan make:import ArtistImport -model=Artist
             'artist_name' => $row['name'], //ito yung heading row
             'img_path' => 'artist.png',
        ]);
    }
}
