<aside class="sidebar group">
    <a href="{{ route('home') }}" class="logo">
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


            @role('peminjam')
                <x-partials.sidebar-link icon="fa-solid fa-book" :to="route('buku.index')" :text="__('Buku')" :active="request()->routeIs('buku.index') ? 'active' : ''" />
                <x-partials.sidebar-link icon="fa-solid fa-bookmark" :to="route('koleksi-buku')" :text="__('Koleksi Buku')"
                    :active="request()->routeIs('koleksi-buku') ? 'active' : ''" />
                <x-partials.sidebar-link icon="fa-solid fa-book-open-reader" :to="route('peminjaman.index')" :text="__('Peminjaman')"
                    :active="request()->routeIs('peminjaman.index') ? 'active' : ''" />
            @endrole

            @role('admin')
                <x-partials.sidebar-link icon="fa-solid fa-book" :to="route('buku.index')" :text="__('Buku')" :active="request()->routeIs('buku.index') ? 'active' : ''" />
            @endrole

            @role('petugas')
                <x-partials.sidebar-link :to="route('data-peminjam')" icon="fa-solid fa-user" :text="__('Peminjam')" :active="request()->routeIs('data-peminjam') ? 'active' : ''" />
                <x-partials.sidebar-link :to="route('peminjaman.index')" icon="fa-solid fa-book-open-reader" :text="__('Peminjaman')"
                    :active="request()->routeIs('peminjaman.index') ? 'active' : ''" />
                <x-partials.sidebar-link :to="route('halaman-riwayat')" icon="fa-solid fa-clipboard" :text="__('Denda')"
                    :active="request()->routeIs('halaman-riwayat') ? 'active' : ''" />
            @endrole
            @role('admin')
                <x-partials.sidebar-link :to="route('kategori.index')" icon="fa-solid fa-layer-group" :text="__('Kategori')"
                    :active="request()->routeIs('kategori.index') ? 'active' : ''" />
                <x-partials.sidebar-link :to="route('anggota.index')" icon="fa-solid fa-list-ul" :text="__('Daftar User')"
                    :active="request()->routeIs('anggota.index') ? 'active' : ''" />
                <x-partials.sidebar-link :to="route('peminjaman.index')" icon="fa-solid fa-book-open-reader" :text="__('Peminjaman')"
                    :active="request()->routeIs('peminjaman.index') ? 'active' : ''" />
                <x-partials.sidebar-link :to="route('halaman-riwayat')" icon="fa-solid fa-clipboard" :text="__('Denda')"
                    :active="request()->routeIs('halaman-riwayat') ? 'active' : ''" />
            @endrole
        </ul>
    </div>
</aside>
