<?php

namespace App\Exports;
use App\ListItem;
use Maatwebsite\Excel\Concerns\FromCollection;

class ListExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return ListItem::all();
    }
}
