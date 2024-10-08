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
                        <div class="col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col mt-0">
                                            <h5 class="card-title">Total Keuntungan</h5>
                                        </div>
                                        <div class="col-auto">
                                            <div class="statSuccess">
                                                <i class="align-middle" data-feather="dollar-sign"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <h1 class="mt-1 mb-3">Rp{{ number_format($income, 0, ',', '.') }}</h1>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col mt-0">
                                            <h5 class="card-title">Total Pengeluaran</h5>
                                        </div>
                                        <div class="col-auto">
                                            <div class="statDanger">
                                                <i class="align-middle" data-feather="dollar-sign"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <h1 class="mt-1 mb-3">Rp{{ number_format($outcome, 0, ',', '.') }}</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
