<?php

namespace App\Imports;

// use Illuminate\Support\Collection;
// use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class AlbumArtistListenerImport implements WithMultipleSheets
{
    // /**
    // * @param Collection $collection
    // */
    // public function collection(Collection $collection)
    // {
    //     //
    // }

    public function sheets(): array
        {
            return [ //MULTIPLE SHEET IMPORT
                // 'Sheet2' => new FirstSheetImport(),
                'albums' => new FirstSheetImport(),
                'Sheet1' => new AlbumImport(),
            ];
        }
}
