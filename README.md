# 📚 Sistem Perpustakaan

Sistem Perpustakaan adalah aplikasi berbasis web yang dikembangkan menggunakan Laravel, DataTables, dan Spatie Laravel Permission untuk manajemen pengguna dan hak akses.

## ✨ Fitur Utama

-   Manajemen buku, anggota, dan peminjaman.
-   Import data user menggunakan file Excel.
-   Pengelolaan peran dan izin pengguna.
-   Tampilan data dinamis dengan DataTables server-side.

## ⚙️ Teknologi yang Digunakan

-   **Laravel** - Framework PHP untuk pengembangan backend.
-   **DataTables** - Menampilkan data secara interaktif.
-   **Spatie Laravel Permission** - Manajemen role dan permission.
-   **Tailwind CSS** - Styling modern dan responsif.
-   **Alpine.js & jQuery** - Interaksi dinamis pada frontend.

## 🚀 Cara Menggunakan

1. Clone repository ini:
    ```sh
    git clone https://github.com/diniviantt/perpus.git
    ```
2. Masuk ke folder proyek:
    ```sh
    cd repo-perpustakaan
    ```
3. Install dependency dengan Composer dan NPM:
    ```sh
    composer install
    npm install && npm run dev
    ```
4. Konfigurasi file `.env`:
    ```sh
    cp .env.example .env
    php artisan key:generate
    ```
5. Jalankan migrasi database:
    ```sh
    php artisan migrate --seed
    ```
6. Jalankan server aplikasi:
    ```sh
    php artisan serve
    ```
7. Akses aplikasi di `http://127.0.0.1:8000`

💡 _Dikembangkan oleh Dini Avianti_
