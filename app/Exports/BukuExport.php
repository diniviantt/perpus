<?php

namespace App\Exports;

use App\Models\Buku;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class BukuExport implements FromCollection, WithHeadings, WithDrawings
{
    public function collection()
    {
        return Buku::select('kode_buku', 'judul', 'pengarang', 'penerbit', 'tahun_terbit', 'deskripsi', 'gambar', 'stock')->get();
    }

    public function headings(): array
    {
        return ['Kode Buku', 'Judul', 'Pengarang', 'Penerbit', 'Tahun Terbit', 'Deskripsi', 'Gambar', 'Stock'];
    }

    public function drawings()
    {
        $drawings = [];
        $bukus = Buku::all();

        foreach ($bukus as $index => $buku) {
            if ($buku->gambar) {
                $drawing = new Drawing();
                $drawing->setName('Sampul Buku');
                $drawing->setDescription('Sampul Buku');
                $drawing->setPath(public_path("images/" . $buku->gambar));
                $drawing->setHeight(100);
                $drawing->setResizeProportional(false);
                $drawing->setWidth(70); // Sesuaikan dengan kebutuhan

                $drawing->setCoordinates('G' . ($index + 2)); // Kolom G untuk gambar
                $drawings[] = $drawing;
            }
        }

        return $drawings;
    }
}
