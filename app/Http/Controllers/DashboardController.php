<?php

namespace App\Http\Controllers;

use App\Exports\UserTemplateExport;
use App\Imports\UserImport;
use App\Models\Buku;
use App\Models\Kategori;
use App\Models\ModelHasRole;
use App\Models\Peminjaman;
use App\Models\Profile;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Auth\User as AuthUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class DashboardController extends Controller
{
    public function index()
    {
        $iduser = Auth::id();
        $kategori = Kategori::count();
        $buku = Buku::count();
        $user = User::role('peminjam')->count();
        $riwayat_pinjam = Peminjaman::with(['user', 'buku'])->orderBy('updated_at', 'desc')->get();
        $jumlah_riwayat = Peminjaman::count();
        $pinjamanUser = Peminjaman::where('users_id', $iduser)->where('tanggal_pengembalian', null)->count();
        return view('dashboard.index', compact('kategori', 'buku', 'user', 'riwayat_pinjam', 'jumlah_riwayat'));
    }

    public function admin()
    {
        $roles = Role::all();
        $user = ModelHasRole::with(['user', 'role'])->where('role_id',  '2,3')->get();
        return view('dashboard.admin', [
            'user' => $user,
            'roles' => $roles
        ]);
    }

    public function TableUserManage()
    {
        $users = ModelHasRole::with(['user', 'role'])
            ->whereNotIn('role_id', [0])
            ->where('model_id', '!=', Auth::id())
            ->get();

        return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('name', function ($user) {
                // return $user->user ? $user->user->name : 'N/A'; // Pengecekan null
                if (isset($user->user->avatar)) {
                    $img = '<div class="flex flex-row items-center gap-x-3">
                    <img src="' . $user->user->avatar . '" alt="" class="object-cover rounded-full size-10">
                    <span>' . $user->user->name . '</span>
                    </div>';
                } else {
                    $img = '<div class="flex flex-row items-center gap-x-3">
                    <img src="' . asset('assets/img/profile.webp') . '" alt="" class="object-cover rounded-full size-10">
                    <span>' . $user->user->name . '</span>
                    </div>';
                }

                return $img;
            })
            ->addColumn('email', function ($user) {
                return $user->user ? $user->user->email : 'N/A'; // Pengecekan null
            })
            ->addColumn('role', function ($user) {
                $roleColors = [
                    'admin' => 'bg-red-100 text-red-700 ring-red-700/20',
                    'peminjam' => 'bg-blue-100 text-blue-700 ring-blue-700/20',
                    'petugas' => 'bg-green-100 text-green-700 ring-green-700/20',
                ];

                $colorClass = $roleColors[$user->role->name] ?? 'bg-gray-50 text-gray-700 ring-gray-700/20';

                return '<span class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-full ring-1 ring-inset ' . $colorClass . '">' .
                    $user->role->name .
                    '</span>';
            })

            ->addColumn('option', 'dashboard.dropdown-admin') // Pastikan view ini ada
            ->rawColumns(['name', 'email', 'role', 'option']) // Mengizinkan HTML di kolom ini
            ->make(true);
    }

    public function destroy($id)
    {
        DB::beginTransaction(); // Mulai transaksi database

        try {
            DB::table('model_has_roles')->where('model_id', $id)->delete();
            User::findOrFail($id)->delete();

            DB::commit(); // Simpan perubahan jika tidak ada error
            return response("success", 200);
        } catch (\Exception $e) {
            DB::rollBack(); // Batalkan perubahan jika ada error
            return response($e->getMessage(), 500);
        }
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
        ]);

        // Update role for the given user
        DB::table('model_has_roles')
            ->where('model_id', $id) // Corrected to use user id from route
            ->update(['role_id' => $request->role_id]);

        return response()->json(['status' => true]);
    }

    public function getUser(Request $request, $id)
    {
        // Get user with their roles
        $user = User::with('roles')->find($id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        return response()->json(['data' => $user]);
    }


    public function user()
    {
        return view('dashboard.user');
    }
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role_id' => 'required|exists:roles,id',
        ]);

        DB::beginTransaction();
        try {
            // Simpan User
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // Simpan Role di model_has_roles
            DB::table('model_has_roles')->insert([
                'role_id' => $request->role_id,
                'model_type' => User::class,
                'model_id' => $user->id,
            ]);

            DB::commit();
            return response()->json(['success' => 'User berhasil ditambahkan!']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Terjadi kesalahan!'], 500);
        }
    }

    public function getRoles()
    {
        $roles = Role::all();
        return response()->json($roles);
    }

    public function import(Request $request)
    {
        $request->validate([
            'import' => 'required|mimes:xls,xlsx'
        ]);

        try {
            $file = $request->file('import');

            if (!$file) {
                return response()->json(['message' => 'File tidak ditemukan!'], 400);
            }

            Excel::import(new UserImport, $request->file('import'));

            return response()->json(['message' => 'Data user berhasil diimport!'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal mengimport data: ' . $e->getMessage()], 500);
        }
    }

    public function export()
    {
        return Excel::download(new UserTemplateExport, 'user_template.xlsx');
    }
}
