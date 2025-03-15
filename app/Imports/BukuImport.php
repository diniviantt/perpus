<?php

namespace App\Imports;

use App\Models\Buku; // Pastikan Anda mengimpor model Buku
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\IOFactory;

class BukuImport implements ToModel, WithHeadingRow
{
    protected $filePath; // Menyimpan path file Excel

    public function __construct($filePath)
    {
        $this->filePath = $filePath; // Menyimpan path file yang diunggah
    }

    public function model(array $row)
    {
        $buku = new Buku([
            'judul' => $row['judul'],
            'kode_buku' => $row['kode_buku'],
            'pengarang' => $row['pengarang'],
            'penerbit' => $row['penerbit'],
            'tahun_terbit' => $row['tahun_terbit'],
            'deskripsi' => $row['deskripsi'],
            'stock' => $row['stock'],
            // Jika ada gambar, Anda perlu menanganinya di sini
        ]);

        // Simpan buku terlebih dahulu untuk mendapatkan ID
        $buku->save();

        // Cek apakah kategori ada di dalam row dan hubungkan dengan buku
        if (isset($row['kategori_buku'])) {
            $kategoriIds = explode(',', $row['kategori_buku']); // Misalnya kategori dipisahkan dengan koma
            $buku->kategori_buku()->sync($kategoriIds);
        }

        return $buku;
    }
    private function getImageFromExcel($cellCoordinate)
    {
        // Load file Excel
        $spreadsheet = IOFactory::load($this->filePath); // Menggunakan path file yang diunggah
        $drawingCollection = $spreadsheet->getActiveSheet()->getDrawingCollection();

        foreach ($drawingCollection as $drawing) {
            if ($drawing instanceof \PhpOffice\PhpSpreadsheet\Worksheet\Drawing) {
                // Cek apakah gambar berada di sel yang sesuai
                if ($drawing->getCoordinates() === $cellCoordinate) {
                    // Simpan gambar ke folder dan kembalikan path
                    $imagePath = 'images/' . $drawing->getName(); // Atur nama file sesuai kebutuhan
                    $drawing->getImageResource()->save($imagePath); // Simpan gambar
                    return $imagePath;
                }
            }
        }

        return null; // Jika tidak ada gambar ditemukan
    }
}
