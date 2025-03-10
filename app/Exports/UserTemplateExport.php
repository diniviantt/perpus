<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Spatie\Permission\Models\Role;

class UserTemplateExport implements FromArray, WithHeadings, WithColumnWidths, WithStyles
{
    public function headings(): array
    {
        return [
            ['nama', 'email', 'password', 'role_id', 'role_name'], // Header sesuai database
        ];
    }

    public function array(): array
    {
        // Ambil daftar role dari database
        $roles = Role::all()->map(function ($role) {
            return [$role->id, $role->name];
        })->toArray();



        // Tambahkan 10 baris kosong untuk input user
        for ($i = 0; $i < 10; $i++) {
            $data[] = ['', '', '', '', ''];
        }

        // Tambahkan informasi role ID di bawahnya
        $data[] = ['', '', '', '', '']; // Spasi antar bagian
        $data[] = ['Keterangan Role ID:', '', '', '', ''];
        $data = array_merge($data, $roles);

        return $data;
    }

    public function columnWidths(): array
    {
        return [
            'A' => 20, // Nama
            'B' => 30, // Email
            'C' => 20, // Password
            'D' => 10, // Role ID
            'E' => 15, // Role Name
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 11]], // Judul Template ditebalkan & diperbesar

        ];
    }
}
