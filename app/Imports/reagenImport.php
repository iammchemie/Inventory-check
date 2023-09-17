<?php

namespace App\Imports;

use App\Models\Reagensia;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class reagenImport implements ToModel, WithStartRow
{
    /**
     * @param Collection $collection
     */
    public function model(array $row)
    {
        return new Reagensia([
            'nama_reagensia' => $row[1],
            'satuan' => $row[2],
            'stok' => $row[3],
            'tanggal_kadaluarsa' => $row[4],
            'tanggal_masuk' => null,
            'tanggal_keluar' => null,
            'jumlah_masuk' => null,
            'jumlah_keluar' => null,
            'keterangan' => '-',
        ]);
    }
    public function startRow(): int
    {
        return 3;
    }
}