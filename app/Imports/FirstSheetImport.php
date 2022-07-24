<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

use App\Models\Album;
use App\Models\Artist;
use App\Models\Listener;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class FirstSheetImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        //
        foreach ($rows as $row) 
        {
            // dump($row);

            try {
                // $artist = Artist::where('artist_name',$row['artist'])->first();
                $artist = Artist::where('artist_name',$row['artist'])->firstOrFail();
                }
catch (ModelNotFoundException $ex) {
                $artist = new Artist();
                $artist->artist_name = $row['artist'];
                $artist->img_path = 'artist.png';
                $artist->save();
                
            }
try {
                // $artist = Artist::where('artist_name',$row['artist'])->first();
                $album = Album::where('album_name',$row['album'])->firstOrFail();
               }
catch (ModelNotFoundException $ex) {
                // dd($ex);
                $album = new Album();
                $album->album_name = $row['album'];
                $album->genre = $row['genre'];
                $album->year = 2022;

            }
             $album->artist()->associate($artist);
             $album->save();
    }
    try {
                // $artist = Artist::where('artist_name',$row['artist'])->first();
                $listener = Listener::where('listener_name',$row['listener'])->firstOrFail();
               }
               catch (ModelNotFoundException $ex) {
                // dd($ex);
                $listener = new Listener();
                $listener->listener_name = $row['listener'];
                $listener->email = 'test@yahoo.com';
                $listener->password = '12345678';
                $listener->is_admin = '0';
                $listener->role = '';
                $listener->save();
            }
            
            $listener->albums()->attach($album->id);
            // ! synch para di maulit
        }

}
