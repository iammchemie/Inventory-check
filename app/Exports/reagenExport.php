<?php

namespace App\Exports;

use App\Models\Reagensia;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeSheet;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Style\Border;

class reagenExport implements FromCollection, WithEvents
{
    /**
     * @return \Illuminate\Support\Collection
     */

    public function collection()
    {
        $data = Reagensia::all();

        $transformedData = collect([
            $this->headings() // Judul kolom pada baris pertama
        ])->merge($data->map(function ($item, $key) {
            // Konversi tanggal kadaluarsa ke format Carbon
            $tanggalKadaluarsa = Carbon::createFromFormat('Y-m-d', $item->tanggal_kadaluarsa);

            $sisaHari = now()->diffInDays($tanggalKadaluarsa, false);

            $status = $sisaHari >= 0 ? $sisaHari . ' Hari' : 'Expired';

            return [
                $key + 1, // Nomor urutan
                $item->nama_reagensia,
                $item->satuan,
                $item->stok,
                $item->tanggal_kadaluarsa,
                $status,
            ];
        }));


        return $transformedData;
    }
    public function headings(): array
    {
        return [
            'No',
            'Nama Barang',
            'Satuan',
            'Jumlah',
            'ED',
            'Sisa Hari',
        ];
    }
    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function (BeforeSheet $event) {
                $tanggalEksport = Carbon::now()->format('Y-m-d');
                $event->sheet->setCellValue('A1', 'Daftar Stok Reagen Per ' . $tanggalEksport);
                $event->sheet->mergeCells('A1:F1'); // Menggabungkan sel untuk judul
                $event->sheet->getStyle('A1:F1')->getAlignment()->setHorizontal('center'); // Menengahkan judul
                $event->sheet->getStyle('A1:F1')->getFont()->setBold(true); // Menggunakan huruf tebal untuk judul

            },
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $lastRow = $sheet->getHighestRow();

                for ($row = 2; $row <= $lastRow; $row++) {
                    $rawTanggalKadaluarsa = $sheet->getCell('E' . $row)->getValue();

                    if (Carbon::hasFormat($rawTanggalKadaluarsa, 'Y-m-d')) {
                        $tanggalKadaluarsa = Carbon::createFromFormat('Y-m-d', $rawTanggalKadaluarsa);

                        $selisihHari = $tanggalKadaluarsa->diffInDays(now());

                        $tanggalKadaluarsaCell = $sheet->getCell('E' . $row);
                        if ($selisihHari < 121) {
                            $tanggalKadaluarsaCell->getStyle()->getFill()
                                ->setFillType(Fill::FILL_SOLID)
                                ->getStartColor()->setARGB('FF0000');
                        } elseif ($selisihHari <= 210) {
                            $tanggalKadaluarsaCell->getStyle()->getFill()
                                ->setFillType(Fill::FILL_SOLID)
                                ->getStartColor()->setARGB('FFFF00');
                        }

                        $selisihHariCell = $sheet->getCell('F' . $row);
                        if ($selisihHari < 121) {
                            $selisihHariCell->getStyle()->getFill()
                                ->setFillType(Fill::FILL_SOLID)
                                ->getStartColor()->setARGB('FF0000');
                        } elseif ($selisihHari <= 210) {
                            $selisihHariCell->getStyle()->getFill()
                                ->setFillType(Fill::FILL_SOLID)
                                ->getStartColor()->setARGB('FFFF00');
                        }
                    }
                }

                $event->sheet->getDelegate()->getColumnDimension('A')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('B')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('C')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('D')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('E')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('F')->setAutoSize(true);

                $borderStyle = [
                    'borders' => [
                        'outline' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'],
                        ],
                        'inside' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'],
                        ],
                    ],
                ];

                $event->sheet->getStyle('A2:F2')->applyFromArray($borderStyle); // Border untuk judul
                $event->sheet->getStyle('A3:F' . $lastRow)->applyFromArray($borderStyle); // Border untuk data

                // Menambah warna latar belakang hanya pada baris judul (A2:G2)
                $event->sheet->getStyle('A2:F2')->getFill()->setFillType(Fill::FILL_SOLID);
                $event->sheet->getStyle('A2:F2')->getFill()->getStartColor()->setARGB('00FFFF'); // Warna latar belakang kuning
            },
        ];
    }
}