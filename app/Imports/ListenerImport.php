<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Listener;
use App\Models\Album;

class ListenerImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        //
        foreach ($rows as $row) 
        {
            
            $listener = new Listener();
            $listener->listener_name = $row['listener'];
            $album = new Album();

            $album->album_name = $row['album'];
            $album->artist_id = 20;
            $album->year = 2022;
            $album->genre = 'n/a';
            $listener->save();
            $album->save();
            $album->listeners()->attach($listener->id);
            // } //end foreach
        

        }
    }
}
