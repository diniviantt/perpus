<x-app-layout title="{{ __('List Buku') }}">
    <x-header value="{{ __('List Buku') }}" />
    <x-session-status />


    <div class="flex p-6 mb-6 bg-white rounded-lg shadow-lg">
        <table id="ListBuku" class="w-full">

        </table>
    </div>

    <x-slot name="scripts">
        <script>
            $(function() {
                let tableBuku = $('#ListBuku').DataTable({
                    ordering: true,
                    serverSide: true,
                    processing: true,
                    ajax: {
                        'url': '{{ route('table-buku') }}',
                    },
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            title: 'No',
                            width: '10px',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'gambar',
                            name: 'gambar',
                            title: 'Cover'
                        },
                        {
                            data: 'judul',
                            name: 'judul',
                            title: 'Judul'
                        },
                        {
                            data: 'kode_buku',
                            name: 'kode_buku',
                            title: 'Kode Buku'
                        },
                        {
                            data: 'penerbit',
                            name: 'penerbit',
                            title: 'Fase'
                        },

                        {
                            data: 'option',
                            name: 'option',
                            title: 'Option',
                            orderable: false,
                            searchable: false
                        }
                    ],
                });
            });

            $('#multiselect').select2({
                allowClear: true,
            });
        </script>
    </x-slot>
    <x-slot name="styles">
        <style>
            #ListBuku {
                width: 100% !important;
            }
        </style>
    </x-slot>
</x-app-layout>
