<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Profile;
use App\Models\Kategori;
use App\Models\Buku;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RolePermissionSeeder::class);

        // Seeder peminjam
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
        ]);
        $admin->assignRole('admin');

        $peminjam = [
            [
                'name' => 'Aditio',
                'email' => 'aditio@gmail.com',
                'password' => '12345678',
                'data' => json_encode([
                    'nama_lengkap' => 'Aditio Ramadhan',
                    'alamat' => 'Jl. Kenangan No. 123',
                    'no_telp' => '081234567890',
                    'kecamatan' => 'Jetis',
                    'provinsi' => 'Yogyakarta'
                ])
            ],
        ];

        $petugas = [
            [
                'name' => 'Dini',
                'email' => 'Dini@gmail.com',
                'password' => '12345678',
                'data' => json_encode([
                    'nama_lengkap' => 'Dini Ramadhan',
                    'alamat' => 'Jl. Kenangan No. 123',
                    'no_telp' => '081299567890',
                    'kecamatan' => 'Jetis',
                    'provinsi' => 'Yogyakarta'
                ])
            ],
        ];

        // Insert User
        foreach ($peminjam as $userData) {
            $newUser = User::firstOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'password' => Hash::make($userData['password']),
                    'data' => $userData['data'] ?? null
                ]
            );
            $newUser->assignRole('peminjam');
        }

        // Insert Petugas
        foreach ($petugas as $petugasData) {
            $newPetugas = User::firstOrCreate(
                ['email' => $petugasData['email']],
                [
                    'name' => $petugasData['name'],
                    'password' => Hash::make($petugasData['password']),
                    'data' => $petugasData['data'] ?? null
                ]
            );
            $newPetugas->assignRole('petugas');
        }


        $categories = [
            ['nama' => 'Novel', 'deskripsi' => 'Kumpulan Novel'],
            ['nama' => 'Pelajaran', 'deskripsi' => 'Kumpulan Buku materi pelajaran'],
            ['nama' => 'Romance'],
            ['nama' => 'Drama'],
            ['nama' => 'Fiksi'],
            ['nama' => 'Pemrograman'],
            ['nama' => 'Science'],
            ['nama' => 'Horror']
        ];

        foreach ($categories as $categoryData) {
            Kategori::firstOrCreate($categoryData);
        }

        // Seeder Buku
        $books = [
            [
                'kode_buku' => 'LSK-01',
                'Judul' => 'Laskar Pelangi',
                'Pengarang' => 'Andrea Hirata',
                'Penerbit' => 'Bentang Pustaka',
                'tahun_terbit' => '2005',
                'deskripsi' => 'Laskar Pelangi adalah novel pertama karya Andrea Hirata yang diterbitkan oleh Bentang Pustaka pada tahun 2005...',
                'gambar' => 'Laskar_Pelangi_film.jpg'
            ],
            [
                'kode_buku' => 'HJN-01',
                'Judul' => 'Hujan',
                'Pengarang' => 'Tere Liye',
                'Penerbit' => 'Gramedia Pustaka',
                'tahun_terbit' => '2016',
                'deskripsi' => 'Pada 2042, dunia telah memasuki era di mana peran manusia telah digantikan oleh ilmu pengetahuan dan teknologi canggih...'
            ],
            [
                'kode_buku' => 'JNJ-01',
                'Judul' => 'Janji',
                'Pengarang' => 'Tere Liye',
                'Penerbit' => 'Tere Liye',
                'tahun_terbit' => '2021',
                'deskripsi' => 'Kisah ini tentang janji, tentang seseorang yang tetap berusaha menunaikan janjinya meski menghadapi banyak tantangan...'
            ],
            [
                'kode_buku' => 'AP-01',
                'Judul' => 'Algoritma dan Pemrograman',
                'Pengarang' => 'Lamhot Sitorus',
                'Penerbit' => 'Andi',
                'tahun_terbit' => '2015',
                'deskripsi' => 'Buku ini dirancang untuk digunakan oleh mahasiswa Program Studi Ilmu Komputer, Teknik Informatika...'
            ],
            [
                'kode_buku' => 'PBO-01',
                'Judul' => 'Pemrograman Berorientasi Objek',
                'Pengarang' => 'Syafei Karim',
                'Penerbit' => 'Tanesa',
                'tahun_terbit' => '2021',
                'deskripsi' => 'PBO adalah konsep pemrograman yang harus dipahami oleh seorang programmer, membahas dasar-dasar Java dan konsep PBO...'
            ],
            [
                'kode_buku' => 'WPHP-01',
                'Judul' => 'Buku Sakti Pemrograman Web Seri PHP',
                'Pengarang' => 'Mundzir MF',
                'Penerbit' => 'Anak Hebat Indonesia',
                'tahun_terbit' => '2018',
                'deskripsi' => 'PHP adalah bahasa yang banyak dipakai untuk membuat program situs web dinamis, termasuk CMS seperti Joomla! dan Mambo...'
            ]
        ];

        foreach ($books as $bookData) {
            Buku::firstOrCreate(
                ['kode_buku' => $bookData['kode_buku']],
                $bookData
            );
        }
    }
}
