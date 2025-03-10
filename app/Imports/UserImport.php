<?php

namespace App\Imports;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Validators\Failure;

class UserImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use SkipsFailures;

    public function model(array $row)
    {
        Log::info('Processing row:', $row);

        $role = Role::where('id', $row['role_id'])
            ->orWhere('name', $row['role_name'])
            ->first();

        if (!$role) {
            Log::warning('Role not found for:', $row);
            return null;
        }

        $user = User::where('email', $row['email'])->first();

        if ($user) {
            Log::info('User already exists, updating role:', ['email' => $row['email']]);
            $user->syncRoles([$role->name]);
            return null;
        }

        Log::info('Creating new user:', ['email' => $row['email']]);

        $newUser = new User([
            'name'     => $row['nama'],
            'email'    => $row['email'],
            'password' => Hash::make($row['password']),
        ]);

        $newUser->save();
        $newUser->assignRole($role->name);

        return $newUser;
    }

    public function onFailure(Failure ...$failures)
    {
        foreach ($failures as $failure) {
            Log::error('Import Validation Failed:', [
                'row' => $failure->row(),
                'errors' => $failure->errors(),
            ]);
        }
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
