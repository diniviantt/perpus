<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserImport implements ToModel
{
    public function model(array $row)
    {
        // Validasi password minimal 8 karakter
        $validator = Validator::make(['password' => $row[2]], [
            'password' => 'required|min:8',
        ]);

        if ($validator->fails()) {
            throw new \Exception("Password harus minimal 8 karakter pada email: " . $row[1]);
        }

        // Buat user baru
        $user = User::create([
            'name' => $row[0],
            'email' => $row[1],
            'password' => Hash::make($row[2]), // Hash password sebelum disimpan
        ]);

        // Set role berdasarkan ID (1=Admin, 2=Peminjam, 3=Petugas)
        $role = Role::find($row[3]);

        if ($role) {
            // Masukkan role ke dalam tabel model_has_roles secara manual
            DB::table('model_has_roles')->insert([
                'role_id' => $role->id,
                'model_type' => User::class,
                'model_id' => $user->id
            ]);
        }

        return $user;
    }
}
