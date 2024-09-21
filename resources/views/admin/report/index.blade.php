@extends('layout.adminKit')

@section('sidebar')
    @include('layout.sidebar')
@endsection
@section('navbar')
    @include('layout.navbar')
@endsection

@section('content')
    <div class="ml-[60px] md:ml-64">
        <div class="mb-4">
            <div class="mb-4" style="display: flex; justify-content: end">
                <button type="button" class="btn btn-primary" id="button-add-report">
                    Tambah Report
                </button>
            </div>
            <div class="" style="display: flex; gap: 10px;">
                <select id="filter-month" class="form-control">
                    <option value="">-- Pilih Bulan --</option>
                    <option value="01">Januari</option>
                    <option value="02">Februari</option>
                    <option value="03">Maret</option>
                    <option value="04">April</option>
                    <option value="05">Mei</option>
                    <option value="06">Juni</option>
                    <option value="07">Juli</option>
                    <option value="08">Agustus</option>
                    <option value="09">September</option>
                    <option value="10">Oktober</option>
                    <option value="11">November</option>
                    <option value="12">Desember</option>
                </select>

                <select id="filter-year" class="form-control">
                    <option value="">-- Pilih Tahun --</option>
                    @for ($i = 2021; $i <= date('Y'); $i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>

                <button id="filter-button" class="btn btn-primary">Filter</button>
            </div>
        </div>
        <table id="table-report" class="">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Tanggal</th>
                    <th scope="col">Jumlah Barang Keluar</th>
                    <th scope="col">Keuntungan </th>
                    <th scope="col">Iklan</th>
                    <th scope="col">Laba Bersin</th>
                </tr>
            </thead>
        </table>
    </div>
    <!-- Modal Add -->
    <div id="modal-add">
        <div class="modal fade" id="modalAddReport" tabindex="-1" role="dialog" aria-labelledby="modalAddReportTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="exampleModalLongTitle">Tambah Produk</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            id="button-x-add-report">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="/product" method="POST" class="was-validated">
                            @csrf
                            @method('POST')
                            <div class="form-group">
                                <label for="datetime-report">Tanggal</label>
                                <input type="date" class="form-control form-control-lg" id="datetime-report"
                                    placeholder="Masukkan tanggal report" required>
                                <div class="invalid-feedback">Isian tidak boleh kosong!</div>
                            </div>
                            <div class="form-group">
                                <label for="total-stock-out">Jumlah Barang Keluar</label>
                                <input type="number" class="form-control form-control-lg" id="total-stock-out"
                                    placeholder="Masukkan jumlah barang keluar" required disabled>
                                <div class="invalid-feedback">Isian tidak boleh kosong!</div>
                            </div>
                            <div class="form-group">
                                <label for="profit">Keuntungan</label>
                                <input type="number" class="form-control form-control-lg" id="profit"
                                    placeholder="Masukkan keuntungan" required disabled>
                                <div class="invalid-feedback">Isian tidak boleh kosong!</div>
                            </div>
                            <div class="form-group">
                                <label for="ads">Iklan</label>
                                <input type="number" class="form-control form-control-lg" id="ads"
                                    placeholder="Masukkan iklan" required>
                                <div class="invalid-feedback">Isian tidak boleh kosong!</div>
                            </div>
                            <div class="form-group">
                                <label for="total_profit">Laba Bersih</label>
                                <input type="number" class="form-control form-control-lg" id="total_profit"
                                    placeholder="Masukkan laba bersih" required disabled>
                                <div class="invalid-feedback">Isian tidak boleh kosong!</div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                    id="button-close-add-report">Tutup</button>
                                <button type="button" class="btn btn-primary" id="add-report">Report</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal Add -->
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            var table = $('#table-report').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "/report",
                    data: function(d) {
                        d.month = $('#filter-month').val();
                        d.year = $('#filter-year').val();
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'datetime_report',
                        name: 'datetime_report'
                    },
                    {
                        data: 'total_stock_out',
                        name: 'total_stock_out',
                    },
                    {
                        data: 'profit',
                        name: 'profit'
                    },
                    {
                        data: 'ads',
                        name: 'ads'
                    },
                    {
                        data: 'total_profit',
                        name: 'total_profit'
                    },
                ]
            });

            $('#filter-button').on('click', function() {
                table.ajax.reload();
            });

            $('#button-add-report').on('click', function() {
                $('#modalAddReport').modal('show');
            });
            $('#button-x-add-report').on('click', function() {
                $('#modalAddReport').modal('hide');
            });
            $('#button-close-add-report').on('click', function() {
                $('#modalAddReport').modal('hide');
            });

            let today = new Date().toISOString().split('T')[0];
            $('#datetime-report').attr('max', today);

            $('#datetime-report').on('change', function() {
                let selectedDate = $(this).val();

                if (selectedDate) {
                    $.ajax({
                        url: '/report-date',
                        type: 'GET',
                        data: {
                            date: selectedDate,
                        },
                        success: function(response) {
                            $('#total-stock-out').val(response.total_stock_out);
                            $('#profit').val(response.profit);
                            calculateTotalProfit();
                        },
                        error: function(xhr) {
                            console.error(xhr.responseText);
                        }
                    });
                }
            });

            function calculateTotalProfit() {
                let profit = $('#profit').val() ? $('#profit').val() : 0;
                let ads = $('#ads').val() ? $('#ads').val() : 0;
                let totalProfit = parseInt(profit) + parseInt(ads);
                $('#total_profit').val(totalProfit);
            }
            $('#ads').on('input', calculateTotalProfit);

            $('#add-report').on('click', function() {
                let datetimeReport = $('#datetime-report').val();
                let totalStockOut = $('#total-stock-out').val();
                let profit = $('#profit').val();
                let ads = $('#ads').val();
                let totalProfit = $('#total_profit').val();

                $.ajax({
                    url: '/report',
                    type: 'POST',
                    data: {
                        datetime_report: datetimeReport,
                        total_stock_out: totalStockOut,
                        profit: profit,
                        ads: ads,
                        total_profit: totalProfit,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        $('#datetime-report').val('');
                        $('#total-stock-out').val('');
                        $('#profit').val('');
                        $('#ads').val('');
                        $('#total_profit').val('');
                        $('#modalAddReport').modal('hide');
                        $('#table-report').DataTable().ajax.reload();
                        Swal.fire({
                            icon: "success",
                            title: data.title,
                            text: data.message,
                            confirmButtonColor: "#3085d6",
                        });
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: "error",
                            title: xhr.responseJSON.title,
                            text: xhr.responseJSON.message,
                            confirmButtonColor: "#3085d6",
                        });
                    }
                });
            });
        });
    </script>
@endsection
