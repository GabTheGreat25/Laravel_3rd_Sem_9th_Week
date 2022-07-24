<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\Item;
use App\Models\Customer;
class ItemsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection() //php artisan make:export ItemsExport
    {
        return Customer::all();
    }
}
