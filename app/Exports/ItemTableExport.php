<?php

namespace App\Exports;

use App\Invoice;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles; 
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ItemTableExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View //be aware dapat view ren toh pag return view parang compact toh
    {
        return view('exports.items',[
            'items' => \App\Models\Item::all()
        ]);
    }
}
