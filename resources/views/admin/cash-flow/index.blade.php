@extends('layout.adminKit')

@section('sidebar')
    @include('layout.sidebar')
@endsection
@section('navbar')
    @include('layout.navbar')
@endsection
@section('content')
    <div class="container-fluid p-0">
        <div class="row">
            <div class="d-flex">
                <div class="w-100">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col mt-0">
                                            <h5 class="card-title">Total DP Terbayar</h5>
                                        </div>
                                        <div class="col-auto">
                                            <div class="statSuccess">
                                                <i class="align-middle" data-feather="dollar-sign"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <h1 class="mt-1 mb-3">Rp{{ number_format($totalDp, 0, ',', '.') }}</h1>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col mt-0">
                                            <h5 class="card-title">Total Sisa Pelunasan</h5>
                                        </div>
                                        <div class="col-auto">
                                            <div class="statDanger">
                                                <i class="align-middle" data-feather="dollar-sign"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <h1 class="mt-1 mb-3">Rp{{ number_format($totalPaidOff, 0, ',', '.') }}</h1>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col mt-0">
                                            <h5 class="card-title">Total Pengeluaran (Cicilan)</h5>
                                        </div>
                                        <div class="col-auto">
                                            <div class="statDanger">
                                                <i class="align-middle" data-feather="dollar-sign"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <h1 class="mt-1 mb-3">Rp{{ number_format($totalOutcomeInstallments, 0, ',', '.') }}</h1>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col mt-0">
                                            <h5 class="card-title">Total Pengeluaran (Cicilan + Cash)</h5>
                                        </div>
                                        <div class="col-auto">
                                            <div class="statDanger">
                                                <i class="align-middle" data-feather="dollar-sign"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <h1 class="mt-1 mb-3">Rp{{ number_format($totalOutcome, 0, ',', '.') }}</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 d-flex">
                <div class="card flex-fill">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Tabel Cicilan</h5>
                    </div>
                    <div class="px-3">
                        <table id="table-installments" class="table table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 4%">No</th>
                                    <th style="width: 24%">Tanggal Bayar</th>
                                    <th style="width: 24%">Produk Masuk ID</th>
                                    <th style="width: 24%">Nama Produk</th>
                                    <th style="width: 24%">Nominal Bayar</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('#table-installments').DataTable({
                processing: true,
                serverSide: true,
                ajax: "/cash-flow",
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
                        data: 'datetime_payment',
                        name: 'datetime_payment',
                        searchable: true,
                        orderable: true
                    },
                    {
                        data: 'product_incoming_id',
                        name: 'product_incoming_id',
                        searchable: true,
                        orderable: true
                    },
                    {
                        data: 'product_name',
                        name: 'product_name',
                        searchable: true,
                        orderable: true
                    },
                    {
                        data: 'installment',
                        name: 'installment',
                        searchable: true,
                        orderable: true
                    },
                ]
            });
        });
    </script>
@endsection
