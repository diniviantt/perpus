<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Spatie\Permission\Models\Role;

class UserTemplateExport implements FromArray, WithHeadings
{
    public function array(): array
    {
        $roles = Role::select('id', 'name')->get()->toArray();

        // Tambahkan 10 baris kosong untuk user mengisi data
        $userTemplate = array_fill(0, 10, ['', '', '', '']);

        // Tambahkan pemisah dan daftar role di bagian bawah tabel
        $separator = [['---', '---', '---', '---']];
        $roleHeader = [['ID Role', 'Nama Role']];
        $roleData = array_map(fn($role) => [$role['id'], $role['name']], $roles);

        // Gabungkan semua data
        return array_merge($userTemplate, $separator, $roleHeader, $roleData);
    }

    public function headings(): array
    {
        return [
            'name',
            'email',
            'password',
            'role_id',
        ];
    }
}
