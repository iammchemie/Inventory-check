<?php

namespace App\Exports;

use App\Models\Reagensia;
use Maatwebsite\Excel\Concerns\FromCollection;

class reagenExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $data =  Reagensia::all();

        $transformedData = collect([
            $this->headings() // Judul kolom pada baris pertama
        ])->merge($data->map(function ($item, $key) {
            return [
                $key + 1, // Nomor urutan
                $item->nama_reagensia,
                $item->satuan,
                $item->tanggal_keluar,
                $item->tanggal_masuk,
                $item->jumlah_masuk,
                $item->jumlah_keluar,
                $item->stok,
                $item->tanggal_kadaluarsa,
                $item->keterangan,
            ];
        }));

        return $transformedData;
    }
    public function headings(): array
    {
        return [
            'No',
            'Nama Reagensia',
            'Satuan',
            'Tanggal Masuk',
            'Tanggal Keluar',
            'Jumlah Masuk',
            'Jumlah Keluar',
            'Stok',
            'Tanggal Kadaluarsa',
            'Keterangan',
        ];
    }
}
