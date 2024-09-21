@extends('layout.adminKit')

@section('sidebar')
    @include('layout.sidebar')
@endsection
@section('navbar')
    @include('layout.navbar')
@endsection

@section('content')
    <div class="ml-[60px] md:ml-64">
        <div class="">
            <div class="">
                <table id="table-balance-stock" class="">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Tipe</th>
                            <th scope="col">Warna</th>
                            <th scope="col">Stok Awal</th>
                            <th scope="col">Stok Masuk</th>
                            <th scope="col">Stok Keluar</th>
                            <th scope="col">Stok Akhir</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#table-balance-stock').DataTable({
                processing: true,
                serverSide: true,
                // paging: false,
                ajax: "/stock",
                columns: [{
                        data: null,
                        searchable: false,
                        orderable: false,
                        width: 100,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'type',
                        name: 'type'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'stock',
                        name: 'stock'
                    },
                    {
                        data: 'stock_in',
                        name: 'stock_in',
                    },
                    {
                        data: 'stock_out',
                        name: 'stock_out',
                    },
                    {
                        data: 'stock_final',
                        name: 'stock_final',
                    }
                ]
            });

        });
    </script>
@endsection
