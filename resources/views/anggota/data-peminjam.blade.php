<x-app-layout title="{{ __('Daftar User') }}">
    {{-- <x-header value="{{ __('Daftar User') }}" /> --}}
    <x-session-status />

    <div class="w-full mt-2">
        <div class="mb-4 bg-white rounded-lg shadow-md">
            <div class="px-4 py-3 border-b">
                <h2 class="text-lg font-semibold">{{ __('Daftar Peminjam') }}</h2>
            </div>


            <div class="p-3 overflow-x-auto">
                <table id="TabelPeminjam"></table>
            </div>
        </div>
    </div>

    <x-slot name="scripts">
        <script>
            $(function() {
                let tabelPeminjam = $('#TabelPeminjam').DataTable({
                    ordering: true,
                    serverSide: true,
                    processing: true,
                    ajax: {
                        'url': '{{ route('tabel-peminjam') }}',
                    },
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            title: 'No',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'name',
                            name: 'name',
                            title: 'Nama Peminjam'
                        },
                        {
                            data: 'email',
                            name: 'email',
                            title: 'Email'
                        },
                    ],
                });
            });
        </script>
    </x-slot>



</x-app-layout>
