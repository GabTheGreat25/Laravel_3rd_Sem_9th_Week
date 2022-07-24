<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class ItemsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection() //php artisan make:export ItemsExport
    {
        //
    }
}
