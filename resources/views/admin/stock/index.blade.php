@extends('layout.adminKit')

@section('sidebar')
    @include('layout.sidebar')
@endsection
@section('navbar')
    @include('layout.navbar')
@endsection

@section('content')
    <div class="ml-[60px] md:ml-64">
        <table id="table-balance-stock" class="table table-hover table-striped">
            <thead>
                <tr>
                    <th scope="col" style="min-width: 50px">No</th>
                    <th scope="col" style="min-width: 340px">Tipe</th>
                    <th scope="col" style="min-width: 350px">Warna</th>
                    <th scope="col" style="min-width: 200px">Stok Awal</th>
                    <th scope="col" style="min-width: 200px">Stok Masuk</th>
                    <th scope="col" style="min-width: 200px">Stok Keluar</th>
                    <th scope="col" style="min-width: 200px">Stok Akhir</th>
                </tr>
            </thead>
        </table>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#table-balance-stock').DataTable({
                processing: true,
                serverSide: true,
                scrollX: true,
                autoWidth: true,
                responsive: true,
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
                ],
            });

        });
    </script>
@endsection
