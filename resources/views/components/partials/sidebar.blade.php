<aside class="sidebar group">
    <a href="/" class="logo">
        <x-application-logo
            class="transition-all duration-300 ease-in-out w-7 h-7 md:w-8 md:h-8 group-hover:-rotate-12" />
        {{ config('app.name', 'PerpustakaanSimple') }}
    </a>
    <div class="menu-content">
        <ul class="menu-items">
            <div class="menu-title">{{ __('Home') }}</div>

            <x-partials.sidebar-link :to="route('dashboard')" icon="fa-solid fa-fire" :text="__('Dashboard')" :active="Route::is('dashboard') ? 'active' : ''" />

            @role('admin')
                <x-partials.sidebar-link :to="route('dashboard.admin')" icon="fa-solid fa-user" :text="__('User Management')" :active="Route::is('dashboard.admin') ? 'active' : ''" />
            @endrole

            {{-- @role('user')
                <x-partials.sidebar-link :to="route('dashboard.user')" icon="fa-solid fa-user" :text="__('User Page')" :active="Route::is('dashboard.user') ? 'active' : ''" />
            @endrole --}}

            <div class="menu-title">{{ __('Features') }}</div>

            {{-- <x-partials.sidebar-link icon="fa-regular fa-folder" :text="__('Single Menu')" /> --}}

            <x-partials.sidebar-dropdown icon="fa-regular fa-folder" :text="__('Buku')" :active="Route::is('buku.*') ? 'active' : ''">
                <x-partials.sidebar-dropdown-item :to="route('buku.index')" :text="__('Lihat Semua Buku')" :active="request()->routeIs('buku.index') ? 'active' : ''" />
                <x-partials.sidebar-dropdown-item :to="route('buku.create')" :text="__('Tambah Buku')" :active="request()->routeIs('buku.create') ? 'active' : ''" />
            </x-partials.sidebar-dropdown>


            <x-partials.sidebar-dropdown icon="fa-regular fa-folder" :text="__('Kategori')">
                <x-partials.sidebar-dropdown-item :to="route('kategori.index')" :text="__('Lihat Semua Kategori')" :active="request()->routeIs('kategori.index') ? 'active' : ''" />
                <x-partials.sidebar-dropdown-item :to="route('kategori.create')" :text="__('Tambah Kategori')" :active="request()->routeIs('kategori.create') ? 'active' : ''" />
            </x-partials.sidebar-dropdown>
            @role('admin')
                <x-partials.sidebar-dropdown icon="fa-regular fa-folder" :text="__('Anggota')">
                    <x-partials.sidebar-dropdown-item :to="route('anggota.index')" :text="__('Lihat Anggota')" :active="request()->routeIs('anggota.index') ? 'active' : ''" />
                    <x-partials.sidebar-dropdown-item :to="route('anggota.create')" :text="__('Tambah Anggota')" :active="request()->routeIs('anggota.create') ? 'active' : ''" />
                </x-partials.sidebar-dropdown>
            @endrole
            <x-partials.sidebar-dropdown icon="fa-regular fa-folder" :text="__('Peminjaman')">
                <x-partials.sidebar-dropdown-item :to="route('peminjaman.index')" :text="__('Riwayat Peminjaman')" :active="request()->routeIs('peminjaman.index') ? 'active' : ''" />
                <x-partials.sidebar-dropdown-item :to="route('peminjaman.create')" :text="__('Tambahkan Peminjaman')" :active="request()->routeIs('peminjaman.create') ? 'active' : ''" />
                <x-partials.sidebar-dropdown-item :to="route('pengembalian.index')" :text="__('Kembalikan Buku')" :active="request()->routeIs('pengembalian.index') ? 'active' : ''" />
            </x-partials.sidebar-dropdown>
        </ul>
    </div>
</aside>
