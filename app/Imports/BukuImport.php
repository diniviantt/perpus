<?php

namespace App\Imports;

use App\Models\Buku;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Http\UploadedFile;

class BukuImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $gambarPath = null;

        if (isset($row['gambar']) && $row['gambar'] instanceof UploadedFile) {
            $gambarPath = $row['gambar']->store('buku', 'public');
        }

        return new Buku([
            'kode_buku'   => $row['kode_buku'],
            'judul'       => $row['judul'],
            'pengarang'   => $row['pengarang'],
            'penerbit'    => $row['penerbit'],
            'tahun_terbit' => $row['tahun_terbit'],
            'deskripsi'   => $row['deskripsi'],
            'gambar'      => $gambarPath,
            'stock'       => $row['stock'],
        ]);
    }
}
