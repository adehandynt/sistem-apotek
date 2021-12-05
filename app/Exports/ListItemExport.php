<?php

namespace App\Exports;

use App\Models\ListItem;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;

class ListItemExport implements FromQuery, WithHeadings, WithCustomStartCell
{
    /**
    * @return \Illuminate\Support\Collection
    */

    use Exportable;
    public function __construct(String $id_order)
    {
        $this->id_order = $id_order;
    }

    public function query()
    {
        return ListItem::query()->where('id_order', $this->id_order);
    }

    public function headings(): array
    {

        return [
            ['First row', 'First row'],
            ['Second row', 'Second row'],
         ];

    }

    public function startCell(): string
    {
        return 'A8';
    }
}
