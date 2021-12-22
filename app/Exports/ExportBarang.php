<?php

namespace App\Exports;
use App\Models\Obat;
use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class ExportBarang implements FromCollection, WithHeadings, WithEvents, WithColumnFormatting
{
    /**
    * @return \Illuminate\Support\Collection
    */
    
    public function query()
    {
        return Obat::leftJoin(DB::raw('(SELECT
        t.* 
        FROM
        ( SELECT *, MAX( created_at ) AS MaxTime FROM stok GROUP BY kode_barang ) r
        INNER JOIN stok t ON t.kode_barang = r.kode_barang 
        AND t.created_at = r.MaxTime 
        GROUP BY
        t.kode_barang) AS stok'),
           'stok.kode_barang', '=', 'barang.kode_barang')
        ->leftJoin('set_harga', 'barang.kode_barang', '=', 'set_harga.kode_barang')
        ->leftJoin('harga', 'set_harga.id_harga', '=', 'harga.id_harga')
        ->Join('tipe', 'barang.kode_tipe', '=', 'tipe.kode_tipe')
        ->Join('satuan', 'barang.kode_satuan', '=', 'satuan.kode_satuan')
        ->select('barang.*','harga.harga_jual','harga.harga_beli','harga.margin','harga.harga_eceran','satuan.satuan','satuan.kode_satuan','tipe.nama_tipe','tipe.kode_tipe')
        ->get();
    }

    public function collection()
    {
        return Obat::leftJoin(DB::raw('(SELECT
        t.* 
        FROM
        ( SELECT *, MAX( created_at ) AS MaxTime FROM history_barang GROUP BY kode_barang ) r
        INNER JOIN history_barang t ON t.kode_barang = r.kode_barang 
        AND t.created_at = r.MaxTime 
        GROUP BY
        t.kode_barang) AS history_barang'),
           'history_barang.kode_barang', '=', 'barang.kode_barang')
        ->leftJoin('set_harga', 'barang.kode_barang', '=', 'set_harga.kode_barang')
        ->leftJoin('harga', 'set_harga.id_harga', '=', 'harga.id_harga')
        ->Join('tipe', 'barang.kode_tipe', '=', 'tipe.kode_tipe')
        ->Join('satuan', 'barang.kode_satuan', '=', 'satuan.kode_satuan')
        ->select('barang.*','harga.harga_beli','harga.margin','harga.harga_jual','harga.harga_eceran','satuan.satuan','tipe.nama_tipe',DB::raw('COALESCE(history_barang.sisa,"-") AS sisa'))
        ->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Kode Barang',
            'Nama Barang',
            'Produsen',
            'Kode Tipe',
            'Kode Satuan',
            'Jumlah @ satuan',
            '-',
            'Penyimpanan',
            'Create Date',
            'Update Date',
            'Supplier',
            'Harga Beli',
            'Margin (%)',
            'Harga Jual',
            'Harga Ecer',
            'Satuan',
            'Tipe Obat',
            'Stok Sisa'

        ];

    }

    public function startCell(): string
    {
        return 'A2';
    }

    public function registerEvents(): array
    {
        return [

            AfterSheet::class => function (AfterSheet $event) {

                $event->sheet->getDelegate()->getStyle('A1:S1')
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('FFA500');
              
                 $event->sheet->getDelegate()->freezePane('A2');  
            },

        ];
    }

    
    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_NUMBER,
            'B' => NumberFormat::FORMAT_NUMBER,
        ];
    }
}

