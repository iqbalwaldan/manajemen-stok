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
            <div class="col-xl-6 col-xxl-5 d-flex">
                <div class="w-100">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col mt-0">
                                            <h5 class="card-title">Total Barang Keluar</h5>
                                        </div>
                                        <div class="col-auto">
                                            <div class="stat text-primary">
                                                <i class="align-middle" data-feather="truck"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <h1 class="mt-1 mb-3">{{ $stock_out }}</h1>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col mt-0">
                                            <h5 class="card-title">Total Laba Bersih</h5>
                                        </div>
                                        <div class="col-auto">
                                            <div class="stat text-primary">
                                                <i class="align-middle" data-feather="dollar-sign"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <h1 class="mt-1 mb-3">Rp{{ number_format($total_profit, 0, ',', '.') }}</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex gap-2 justify-content-end">
            <button type="button" id="export-exel" class="btn btn-primary mb-3">Export to Excel</button>
            <button type="button" id="export-pdf" class="btn btn-primary mb-3">Export to PDF</button>
            <button type="button" id="report" class="btn btn-primary mb-3">Tambah Report</button>
        </div>

        <div class="row">
            <div class="col-12 d-flex">
                <div class="card flex-fill">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Report</h5>
                    </div>
                    <table class="table table-hover my-0">
                        <thead>
                            <tr>
                                <th style="width: 20%">Tanggal</th>
                                <th style="width: 20%">Keuntungan</th>
                                <th style="width: 20%">Iklan</th>
                                <th style="width: 20%">Jumlah Barang Keluar</th>
                                <th style="width: 20%">Laba Bersih</th>
                            </tr>
                        </thead>
                        @php
                            $previousMonth = null;
                        @endphp

                        @if ($report->isEmpty())
                            <tr>
                                <td colspan="5" class="text-center font-weight-normal">Data Kosong</td>
                            </tr>
                        @else
                            @foreach ($report as $row)
                                @php
                                    $currentMonth = date('F Y', strtotime($row->month));
                                @endphp

                                @if ($previousMonth !== $currentMonth)
                                    <tr>
                                        <td colspan="5" class="font-weight-bold bg-dark text-light text-center">
                                            {{ $currentMonth }}
                                        </td>
                                    </tr>
                                    @php
                                        $previousMonth = $currentMonth;
                                    @endphp
                                @endif

                                {{-- Row data --}}
                                <tr>
                                    <td>{{ date('d/m/Y', strtotime($row->date)) }}</td>
                                    <td>Rp{{ number_format($row->profit, 0, ',', '.') }}</td>
                                    <td>Rp{{ number_format($row->ads, 0, ',', '.') }}</td>
                                    <td>{{ $row->total_stock_out }}</td>
                                    <td>Rp{{ number_format($row->total_profit, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $('#export-exel').click(function() {
            window.location.href = '/export-excel';
        });
        $('#export-pdf').click(function() {
            window.location.href = '/export-pdf';
        });
        $('#report').click(function() {
            window.location.href = '/report';
        });
    </script>
@endsection
