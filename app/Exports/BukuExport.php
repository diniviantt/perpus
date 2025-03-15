<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BukuExport implements FromArray, WithHeadings
{
    public function array(): array
    {
        // Menyediakan beberapa baris kosong untuk diisi
        return [
            ['', '', '', '', '', '', '', ''], // Baris kosong untuk data
            ['', '', '', '', '', '', '', ''], // Baris kosong untuk data
            ['', '', '', '', '', '', '', ''], // Baris kosong untuk data
            ['', '', '', '', '', '', '', ''], // Baris kosong untuk data
            ['* Pastikan nama file gambar di kolom "Gambar" pada template Excel sesuai dengan nama file gambar yang diunggah.'], // Keterangan di bagian bawah
        ];
    }

    public function headings(): array
    {
        return [
            'kode_buku',
            'judul',
            'pengarang',
            'kategori',
            'penerbit',
            'tahun_terbit',
            'deskripsi',
            'gambar',
            'stock'
        ];
    }
}
