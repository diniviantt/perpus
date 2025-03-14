<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BukuExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        // Menyediakan 5 baris kosong sebagai template input
        return collect(array_fill(0, 5, ['', '', '', '', '', '', '', '']));
    }

    public function headings(): array
    {
        return [
            'kode_buku',
            'judul',
            'pengarang',
            'penerbit',
            'tahun_terbit',
            'deskripsi',
            'gambar',
            'stock'
        ];
    }
}
