<?php

namespace App\Imports;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Illuminate\Validation\Rule;

class UserImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use SkipsFailures;

    public function model(array $row)
    {
        // Cari role berdasarkan ID atau nama
        $role = Role::where('id', $row['role_id'])
            ->orWhere('name', $row['role_name'])
            ->first();

        if (!$role) {
            return null; // Skip jika role tidak ditemukan
        }

        // Cek apakah user sudah ada
        $user = User::where('email', $row['email'])->first();

        if ($user) {
            // Jika user sudah ada, hanya update role tanpa mengubah password
            $user->syncRoles([$role->name]);
            return null;
        }

        // Jika user belum ada, buat baru
        $newUser = new User([
            'name'     => $row['nama'],
            'email'    => $row['email'],
            'password' => Hash::make($row['password']),
        ]);

        $newUser->save();
        $newUser->assignRole($role->name);

        return $newUser;
    }

    public function rules(): array
    {
        return [
            'nama' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email'), // Cegah email duplikat
            ],
            'password' => 'required|string|min:6',
            'role_id' => 'required_without:role_name|exists:roles,id', // Bisa pakai role_id atau role_name
            'role_name' => 'required_without:role_id|exists:roles,name', // Bisa pakai role_name atau role_id
        ];
    }
}
