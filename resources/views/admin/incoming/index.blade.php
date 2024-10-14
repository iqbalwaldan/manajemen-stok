@extends('layout.adminKit')

@section('sidebar')
    @include('layout.sidebar')
@endsection
@section('navbar')
    @include('layout.navbar')
@endsection

@section('content')
    <div class="ml-[60px] md:ml-64">
        <div class="mb-4" style="display: flex; justify-content: end">
            <button type="button" id="button-add-product-incoming" class="btn btn-primary">
                Tambah Produk Masuk
            </button>
        </div>
        <div class="">
            <div class="">
                <table id="table-product-incoming" class="">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Tanggal</th>
                            <th scope="col">Nama Produk</th>
                            <th scope="col">Stok Masuk</th>
                            <th scope="col">Harga</th>
                            <th scope="col">Total Harga</th>
                            <th scope="col">DP</th>
                            <th scope="col">Status Pembayaran</th>
                            <th scope="col">Tipe Pembayaran</th>
                            <th scope="col">Jumlah Cicilan</th>
                            <th scope="col">Pelunasan</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <!-- Modal Add -->
    <div id="modal-add">
        <div class="modal fade" id="modalAddProductIncoming" tabindex="-1" role="dialog"
            aria-labelledby="modalAddProductIncomingTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="exampleModalLongTitle">Tambah Produk Masuk</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            id="button-x-add-product-incoming">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="/incoming" method="POST" class="was-validated">
                            @csrf
                            @method('POST')
                            <div class="form-group">
                                <label for="incoming-date">Tanggal</label>
                                <input type="date" class="form-control form-control-lg" id="incoming-date" required>
                                <div class="invalid-feedback">Isian tidak boleh kosong!</div>
                            </div>
                            <div class="form-group form-group-custom">
                                <label for="incoming-product-name">Nama Produk</label>
                                <span id="valo" class="material-symbols-rounded valid-logo">error</span>
                                <span id="invalo" class="material-symbols-rounded invalid-logo hidden">check</span>
                                <select class="custom-tom-select empty" id="incoming-product-name" required>
                                    <option value="">Pilih produk</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }} ({{ $product->id }})
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Isian tidak boleh kosong!</div>
                            </div>
                            <div class="form-group">
                                <label for="incoming-stock-in">Stok Masuk</label>
                                <div style="display: flex; gap: 10px;">
                                    <div style="width: 100%">
                                        <input type="number" class="form-control form-control-lg" id="incoming-stock-in"
                                            placeholder="Masukkan stok masuk" min="1" required>
                                        <div class="invalid-feedback">Isian tidak boleh kosong!</div>
                                    </div>
                                    <div style="width: 100%">
                                        <select class="form-control form-control-md" id="incoming-unit" required>
                                            <option value="">-- Pilih Satuan --</option>
                                            <option value="1">Pcs</option>
                                            <option value="2">Lusin</option>
                                        </select>
                                        <div class="invalid-feedback">Isian tidak boleh kosong!</div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label id="label-incoming-price" for="incoming-price">Harga</label>
                                <input type="number" class="form-control form-control-lg" id="incoming-price"
                                    placeholder="Masukkan harga" min="0" required>
                                <div class="invalid-feedback">Isian tidak boleh kosong!</div>
                            </div>
                            <div class="form-group">
                                <label for="incoming-total-price">Total Harga</label>
                                <input type="number" class="form-control form-control-lg" id="incoming-total-price"
                                    placeholder="Isi stok masuk dan harga terlebih dahulu" required disabled>
                            </div>
                            <div class="form-group">
                                <label for="incoming-payment-type">Tipe Pembayaran</label>
                                <select class="form-control form-control-md" id="incoming-payment-type" required>
                                    <option value="">-- Pilih Tipe Pembayaran --</option>
                                    <option value="1">Tunai</option>
                                    <option value="2">Cicil</option>
                                </select>
                                <div class="invalid-feedback">Isian tidak boleh kosong!</div>
                            </div>
                            <div class="form-group">
                                <label id="incoming-total-installment-label" for="incoming-total-installment"
                                    hidden>Jumlah Cicilan</label>
                                <input type="number" class="form-control form-control-lg"
                                    id="incoming-total-installment" placeholder="Masukkan jumalah cicilan" min="0"
                                    hidden>
                                <div class="invalid-feedback">Isian tidak boleh kosong!</div>
                            </div>
                            <div class="form-group">
                                <label for="incoming-dp">DP</label>
                                <input type="number" class="form-control form-control-lg" id="incoming-dp"
                                    placeholder="Masukkan dp" min="0" required>
                                <div class="invalid-feedback">Isian tidak boleh kosong!</div>
                            </div>
                            <div class="form-group">
                                <label for="incoming-payment-status">Status Pembayaran</label>
                                <select class="form-control form-control-md" id="incoming-payment-status" required
                                    disabled>
                                    <option value="">-- Pilih Status Pembayaran --</option>
                                    <option value="1" selected>Belum Lunas</option>
                                    <option value="2">Lunas</option>
                                </select>
                                <div class="invalid-feedback">Isian tidak boleh kosong!</div>
                            </div>
                            <div class="form-group">
                                <label for="incoming-paid-off">Pelunasan</label>
                                <input type="number" class="form-control form-control-lg" id="incoming-paid-off"
                                    placeholder="Isi total harga dan dp terlebih dahulu" required disabled>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                    id="button-close-add-product-incoming">Tutup</button>
                                <button type="button" class="btn btn-primary" id="add-product-incoming">Tambah</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal Add -->
    <!-- Modal Edit -->
    <div id="modal-edit">
        <div class="modal fade" id="modalEditProductIncoming" tabindex="-1" role="dialog"
            aria-labelledby="modalEditProductIncomingTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="exampleModalLongTitle">Edit Produk Masuk</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            id="button-x-edit-product-incoming">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="/incoming" method="POST" class="was-validated">
                            @csrf
                            @method('POST')
                            <div class="form-group">
                                <label for="edit-incoming-date">Tanggal</label>
                                <input type="date" class="form-control form-control-lg" id="edit-incoming-date"
                                    required>
                                <div class="invalid-feedback">Isian tidak boleh kosong!</div>
                            </div>
                            <div class="form-group form-group-custom">
                                <label for="edit-incoming-product-name">Nama Produk</label>
                                <span id="edit-valo" class="material-symbols-rounded valid-logo">
                                    error
                                </span>
                                <span id="edit-invalo" class="material-symbols-rounded invalid-logo hidden">
                                    check
                                </span>
                                <select class="custom-tom-select
                                    empty"
                                    id="edit-incoming-product-name" required>
                                    <option value="">Pilih produk</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }} ({{ $product->id }})
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Isian tidak boleh kosong!</div>
                            </div>
                            <div class="form-group">
                                <label for="edit-incoming-stock-in">Stok Masuk</label>
                                <div style="display: flex; gap: 10px;">
                                    <div style="width: 100%">
                                        <input type="number" class="form-control form-control-lg"
                                            id="edit-incoming-stock-in" placeholder="Masukkan stok masuk" min="1"
                                            required>
                                        <div class="invalid-feedback">Isian tidak boleh kosong!</div>
                                    </div>
                                    <div style="width: 100%">
                                        <select class="form-control form-control-md" id="edit-incoming-unit" required>
                                            <option value="">-- Pilih Satuan --</option>
                                            <option value="1" selected>Pcs</option>
                                            <option value="2">Lusin</option>
                                        </select>
                                        <div class="invalid-feedback">Isian tidak boleh kosong!</div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label id="edit-label-incoming-price" for="edit-incoming-price">Harga</label>
                                <input type="number" class="form-control form-control-lg" id="edit-incoming-price"
                                    placeholder="Masukkan harga" min="0" required>
                                <div class="invalid-feedback">Isian tidak boleh kosong!</div>
                            </div>
                            <div class="form-group">
                                <label for="edit-incoming-total-price">Total Harga</label>
                                <input type="number" class="form-control form-control-lg" id="edit-incoming-total-price"
                                    placeholder="Isi stok masuk dan harga terlebih dahulu" required disabled>
                            </div>
                            <div class="form-group">
                                <label for="edit-incoming-payment-type">Tipe Pembayaran</label>
                                <select class="form-control form-control-md" id="edit-incoming-payment-type" required>
                                    <option value="">-- Pilih Tipe Pembayaran --</option>
                                    <option value="1">Tunai</option>
                                    <option value="2">Cicil</option>
                                </select>
                                <div class="invalid-feedback">Isian tidak boleh kosong!</div>
                            </div>
                            <div class="form-group">
                                <label id="edit-incoming-total-installment-label" for="edit-incoming-total-installment"
                                    hidden disabled>Jumlah Cicilan</label>
                                <input type="number" class="form-control form-control-lg"
                                    id="edit-incoming-total-installment" placeholder="Masukkan jumalah cicilan"
                                    min="0" hidden disabled>
                                <div class="invalid-feedback">Isian tidak boleh kosong!</div>
                            </div>
                            <div class="form-group">
                                <label for="edit-incoming-dp">DP</label>
                                <input type="number" class="form-control form-control-lg" id="edit-incoming-dp"
                                    placeholder="Masukkan dp" min="0" required>
                                <div class="invalid-feedback">Isian tidak boleh kosong!</div>
                            </div>
                            <div class="form-group">
                                <label for="edit-incoming-payment-status">Status Pembayaran</label>
                                <select class="form-control form-control-md" id="edit-incoming-payment-status" required
                                    disabled>
                                    <option value="">-- Pilih Status Pembayaran --</option>
                                    <option value="Lunas">Lunas</option>
                                    <option value="Belum Lunas">Belum Lunas</option>
                                </select>
                                <div class="invalid-feedback">Isian tidak boleh kosong!</div>
                            </div>
                            <div class="form-group">
                                <label for="edit-incoming-paid-off">Pelunasan</label>
                                <input type="number" class="form-control form-control-lg" id="edit-incoming-paid-off"
                                    placeholder="Isi total harga dan dp terlebih dahulu" required disabled>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                    id="button-close-edit-product-incoming">Tutup</button>
                                <button type="button" class="btn btn-primary" id="edit-product-incoming">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal Edit -->
    <!-- Modal Payment -->
    <div id="modal-add">
        <div class="modal fade" id="modalAddPaymentInstallment" tabindex="-1" role="dialog"
            aria-labelledby="modalAddPaymentInstallmentTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="exampleModalLongTitle">Pembayaran Cicilan</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            id="button-x-add-payment-installment">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="/incoming" method="POST" class="was-validated">
                            @csrf
                            @method('POST')
                            <div class="form-group">
                                <label for="add-installment-date">Tanggal</label>
                                <input type="date" class="form-control form-control-lg" id="add-installment-date"
                                    required>
                                <div class="invalid-feedback">Isian tidak boleh kosong!</div>
                            </div>
                            <div class="form-group">
                                <label for="add-installment-price">Cicilan</label>
                                <input type="number" class="form-control form-control-lg" id="add-installment-price"
                                    placeholder="Masukkan cicilan" min="0" required disabled>
                                <div class="invalid-feedback">Isian tidak boleh kosong!</div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                    id="button-close-add-payment-installment">Tutup</button>
                                <button type="button" class="btn btn-primary"
                                    id="add-payment-installment">Tambah</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal Payment -->
    <!-- Modal Show -->
    <div id="modal-add">
        <div class="modal fade" id="modalShowPaymentInstallment" tabindex="-1" role="dialog"
            aria-labelledby="modalShowPaymentInstallmentTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="exampleModalLongTitle">Pembayaran Cicilan</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            id="button-x-show-payment-installment">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Tanggal Pembayaran</th>
                                    <th scope="col">Terbayar</th>
                                </tr>
                            </thead>
                            <tbody id="table-show-installments">

                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"
                            id="button-close-show-payment-installment">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal Show -->
@endsection

@section('script')
    <script>
        let selectedData = null;

        $(document).ready(function() {
            $('#table-product-incoming').DataTable({
                processing: true,
                serverSide: true,
                ajax: "/incoming",
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
                        data: 'datetime_incoming',
                        name: 'datetime_incoming',
                        searchable: true,
                        orderable: true
                    },
                    {
                        data: 'product_id',
                        name: 'product_id',
                        searchable: true,
                        orderable: true,
                        render: function(data, type, row) {
                            return '<span class="badge badge-primary p-2" style="min-width: 30px;">' +
                                row.product.id + '</span> ' + row.product.name;
                        }
                    },
                    {
                        data: 'stock_in',
                        name: 'stock_in',
                        searchable: true,
                        orderable: true
                    },
                    {
                        data: 'price',
                        name: 'price',
                        searchable: true,
                        orderable: true,
                        render: $.fn.dataTable.render.number(',', '.', 0, 'Rp ')
                    },
                    {
                        data: 'total_price',
                        name: 'total_price',
                        searchable: true,
                        orderable: true,
                        render: $.fn.dataTable.render.number(',', '.', 0, 'Rp ')
                    },
                    {
                        data: 'dp',
                        name: 'dp',
                        searchable: true,
                        orderable: true,
                        render: $.fn.dataTable.render.number(',', '.', 0, 'Rp ')
                    },
                    {
                        data: 'payment_status',
                        name: 'payment_status',
                        searchable: true,
                        orderable: true,
                        render: function(data) {
                            if (data == "Belum Lunas") {
                                return '<span class="badge badge-danger p-2" style="min-width: 30px;">' +
                                    data + '</span>';
                            } else {
                                return '<span class="badge badge-success p-2" style="min-width: 30px;">' +
                                    data + '</span>';
                            }
                        }
                    },
                    {
                        data: 'payment_type',
                        name: 'payment_type',
                        searchable: true,
                        orderable: true,
                    },
                    {
                        data: 'total_installment',
                        name: 'total_installment',
                        searchable: true,
                        orderable: true
                    },
                    {
                        data: 'paid_off',
                        name: 'paid_off',
                        searchable: true,
                        orderable: true,
                        render: $.fn.dataTable.render.number(',', '.', 0, 'Rp ')
                    },
                    {
                        width: '160px',
                        data: 'action',
                        name: 'action',
                    },
                ]
            });

            var tomSelectAddProductIncome = new TomSelect("#incoming-product-name", {
                create: false,
                sortField: {
                    field: "text",
                    direction: "asc"
                },
                placeholder: "-- Pilih Produk --",
                onChange: function(value) {
                    if (value) {
                        $(this.input).siblings('.custom-tom-select').removeClass('empty').addClass(
                            'filled');
                        $('#valo').addClass('hidden');
                        $('#invalo').removeClass('hidden');
                    } else {
                        $(this.input).siblings('.custom-tom-select').removeClass('filled').addClass(
                            'empty');
                        $('#invalo').addClass('hidden');
                        $('#valo').removeClass('hidden');
                    }
                }
            });

            function dateNow() {
                let date = new Date();
                return date.toISOString().split('T')[0];
            }

            function unit() {
                let unit = $('#incoming-unit').val();
                if (unit == 1) {
                    $('#label-incoming-price').text('Harga per Pcs');
                } else if (unit == 2) {
                    $('#label-incoming-price').text('Harga per Lusin');
                } else {
                    $('#label-incoming-price').text('Harga');
                }
            }
            $('#incoming-unit').on('change', unit);

            function calculateTotalPrice() {
                let price = $('#incoming-price').val();
                let stockIn = $('#incoming-stock-in').val();
                let totalPrice = price * stockIn;
                $('#incoming-total-price').val(totalPrice);
                if ($('#incoming-payment-type').val() == 1) {
                    $('#incoming-dp').val(totalPrice);
                }
                calculatePaidOff();
            }
            $('#incoming-price, #incoming-stock-in').on('change', calculateTotalPrice);

            function calculatePaidOff() {
                let totalPrice = $('#incoming-total-price').val();
                let dp = $('#incoming-dp').val();
                let paidOff = totalPrice - dp;
                $('#incoming-paid-off').val(paidOff);
                $('#incoming-dp').attr('max', totalPrice);
                if (paidOff == 0) {
                    $('#incoming-payment-status').val(2);
                } else {
                    $('#incoming-payment-status').val(1);
                }

            }
            $('#incoming-dp').on('change', calculatePaidOff);

            function paymentTypeCondition() {
                let paymentType = $('#incoming-payment-type').val();
                if (paymentType == 1) {
                    $('#incoming-dp').val($('#incoming-total-price').val());
                    $('#incoming-dp').attr('disabled', true);
                    $('#incoming-payment-status').val(2);
                    $('#incoming-paid-off').val(0);
                    $('#incoming-total-installment').attr('hidden', true);
                    $('#incoming-total-installment-label').attr('hidden', true);
                    $('#incoming-total-installment').removeAttr('required');
                    $('#incoming-total-installment').attr('min', 0);
                    $('#incoming-total-installment').val(0);
                } else if (paymentType == 2) {
                    $('#incoming-dp').val('');
                    $('#incoming-dp').attr('disabled', false);
                    $('#incoming-payment-status').val(1);
                    $('#incoming-paid-off').val('');
                    $('#incoming-total-installment').removeAttr('hidden');
                    $('#incoming-total-installment-label').removeAttr('hidden');
                    $('#incoming-total-installment').attr('required', true);
                    $('#incoming-total-installment').attr('min', 2);
                    $('#incoming-total-installment').val('');
                }
            }
            $('#incoming-payment-type').on('change', paymentTypeCondition);

            $('#add-product-incoming').click(function() {
                var date = $('#incoming-date').val();
                var product = $('#incoming-product-name').val();
                if ($('#incoming-unit').val() == 1) {
                    var stockIn = $('#incoming-stock-in').val();
                    var price = $('#incoming-price').val();
                } else if ($('#incoming-unit').val() == 2) {
                    var stockIn = $('#incoming-stock-in').val() * 12;
                    var price = $('#incoming-price').val() / 12;
                }
                var totalPrice = $('#incoming-total-price').val();
                var payment_type = $('#incoming-payment-type').val();
                var total_installment = $('#incoming-total-installment').val();
                var dp = $('#incoming-dp').val();
                var paymentStatus = $('#incoming-payment-status').val();
                var paidOff = $('#incoming-paid-off').val();

                $.ajax({
                    url: '/incoming',
                    type: 'POST',
                    data: {
                        datetime_incoming: date,
                        product_id: product,
                        stock_in: stockIn,
                        price: price,
                        total_price: totalPrice,
                        payment_type: payment_type,
                        total_installment: total_installment,
                        dp: dp,
                        payment_status: paymentStatus,
                        paid_off: paidOff,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        $('#incoming-date').val('');
                        tomSelectAddProductIncome.clear();
                        $('#incoming-stock-in').val('');
                        $('#incoming-unit').val('');
                        $('#incoming-price').val('');
                        $('#incoming-total-price').val('');
                        $('#incoming-payment-type').val('');
                        $('#incoming-total-installment').val('');
                        $('#incoming-dp').val('');
                        $('#incoming-payment-status').val(1);
                        $('#incoming-paid-off').val('');
                        $('#modalAddProductIncoming').modal('hide');
                        $('#incoming-total-installment').attr('hidden', true);
                        $('#incoming-total-installment-label').attr('hidden', true);
                        $('#incoming-total-installment').removeAttr('required');
                        $('#table-product-incoming').DataTable().ajax.reload();
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

            $('#button-add-product-incoming').on('click', function() {
                $('#incoming-date').val(dateNow());
                $('#modalAddProductIncoming').modal('show');
            });
            $('#button-x-add-product-incoming').on('click', function() {
                $('#modalAddProductIncoming').modal('hide');
            });
            $('#button-close-add-product-incoming').on('click', function() {
                $('#modalAddProductIncoming').modal('hide');
            });

            var tomSelectEditProductIncome = new TomSelect("#edit-incoming-product-name", {
                create: false,
                sortField: {
                    field: "text",
                    direction: "asc"
                },
                placeholder: "-- Pilih Produk --",
                onChange: function(value) {
                    if (value) {
                        $(this.input).siblings('.custom-tom-select').removeClass('empty').addClass(
                            'filled');
                        $('#edit-valo').addClass('hidden');
                        $('#edit-invalo').removeClass('hidden');
                    } else {
                        $(this.input).siblings('.custom-tom-select').removeClass('filled').addClass(
                            'empty');
                        $('#edit-invalo').addClass('hidden');
                        $('#edit-valo').removeClass('hidden');
                    }
                }
            });

            $(document).on('click', '.button-edit-product-incoming', function() {
                selectedData = $('#table-product-incoming').DataTable().row($(this).parents('tr')).data();
                let date = selectedData.datetime_incoming;
                let dateParts = date.split('-');
                let formattedDate = `${dateParts[2]}-${dateParts[1]}-${dateParts[0]}`;
                $('#edit-incoming-date').val(formattedDate);
                tomSelectEditProductIncome.setValue(selectedData.product.id);
                $('#edit-incoming-stock-in').val(selectedData.stock_in);
                $('#edit-incoming-unit').val(1);
                $('#edit-incoming-price').val(selectedData.price);
                $('#edit-incoming-total-price').val(selectedData.total_price);
                let paymentType = selectedData.payment_type == 'Tunai' ? 1 : 2;
                $('#edit-incoming-payment-type').val(paymentType);
                $('#edit-incoming-total-installment').val(selectedData.total_installment);
                $('#edit-incoming-dp').val(selectedData.dp);
                $('#edit-incoming-payment-status').val(selectedData.payment_status);
                $('#edit-incoming-paid-off').val(selectedData.paid_off);
                paymentStatus();
                if (selectedData.total_detail_installments > 0 || $('#edit-incoming-payment-status').val() == 'Lunas') {
                    $('#edit-incoming-payment-type').attr('disabled', true);
                } else {
                    $('#edit-incoming-payment-type').removeAttr('disabled', false);
                }
                $('#modalEditProductIncoming').modal('show');
            });

            function editUnit() {
                let unit = $('#edit-incoming-unit').val();
                if (unit == 1) {
                    $('#edit-label-incoming-price').text('Harga per Pcs');
                } else if (unit == 2) {
                    $('#edit-label-incoming-price').text('Harga per Lusin');
                } else {
                    $('#edit-label-incoming-price').text('Harga');
                }
            }
            $('#edit-incoming-unit').on('change', unit);

            function calculateEditTotalPrice() {
                let price = $('#edit-incoming-price').val();
                let stockIn = $('#edit-incoming-stock-in').val();
                let totalPrice = price * stockIn;
                $('#edit-incoming-total-price').val(totalPrice);
                calculateEditPaidOff();
            }
            $('#edit-incoming-price, #edit-incoming-stock-in').on('change', calculateEditTotalPrice);

            function calculateEditPaidOff() {
                let totalPrice = $('#edit-incoming-total-price').val();
                let dp = $('#edit-incoming-dp').val();
                let paidOff = totalPrice - dp;
                $('#edit-incoming-paid-off').val(paidOff);
                $('#edit-incoming-dp').attr('max', totalPrice);
                if (paidOff == 0) {
                    $('#edit-incoming-payment-status').val('Lunas');
                } else {
                    $('#edit-incoming-payment-status').val('Belum Lunas');
                }
                paymentStatus();
            }
            $('#edit-incoming-dp').on('change', calculateEditPaidOff);

            $('#edit-incoming-payment-type').on('change', function() {
                let paymentType = $('#edit-incoming-payment-type').val();
                if (paymentType == 1) {
                    paymentStatus();
                    $('#edit-incoming-dp').val($('#edit-incoming-total-price').val());
                    $('#edit-incoming-total-installment').val(0);
                    calculateEditPaidOff();
                    $('#edit-incoming-total-installment-label').attr('disabled', true);
                    $('#edit-incoming-total-installment').attr('disabled', true);
                    $('#edit-incoming-total-installment-label').attr('hidden', true);
                    $('#edit-incoming-total-installment').attr('hidden', true);
                    $('#edit-incoming-total-installment').attr('min', 0);
                    
                } else {
                    paymentStatus();
                    $('#edit-incoming-dp').val(0);
                    $('#edit-incoming-total-installment').val(0);
                    calculateEditPaidOff();
                    $('#edit-incoming-payment-type').removeAttr('disabled', false);
                    $('#edit-incoming-total-installment-label').removeAttr('disabled', false);
                    $('#edit-incoming-total-installment').removeAttr('disabled', false);
                    $('#edit-incoming-total-installment-label').removeAttr('hidden', false);
                    $('#edit-incoming-total-installment').removeAttr('hidden', false);
                    $('#edit-incoming-total-installment').attr('min', 2);
                }
            });

            function paymentStatus() {
                let status = $('#edit-incoming-payment-status').val();
                let paymentType = $('#edit-incoming-payment-type').val();
                if (status == 'Belum Lunas' && selectedData.total_detail_installments == 0 && paymentType == 2) {
                    $('#edit-incoming-dp').removeAttr('disabled', false);
                    $('#edit-incoming-price').removeAttr('disabled', false);
                    $('#edit-incoming-stock-in').removeAttr('disabled', false);
                    $('#edit-incoming-unit').removeAttr('disabled', false);
                    // $('#edit-incoming-payment-type').removeAttr('disabled', false);
                    $('#edit-incoming-total-installment-label').removeAttr('disabled', false);
                    $('#edit-incoming-total-installment').removeAttr('disabled', false);
                    $('#edit-incoming-total-installment-label').removeAttr('hidden', false);
                    $('#edit-incoming-total-installment').removeAttr('hidden', false);
                } else if (status == 'Lunas' || selectedData.total_detail_installments > 0 || paymentType == 1) {
                    $('#edit-incoming-dp').attr('disabled', true);
                    $('#edit-incoming-price').attr('disabled', true);
                    $('#edit-incoming-stock-in').attr('disabled', true);
                    $('#edit-incoming-unit').attr('disabled', true);
                    // $('#edit-incoming-payment-type').attr('disabled', true);
                    $('#edit-incoming-total-installment-label').attr('disabled', true);
                    $('#edit-incoming-total-installment').attr('disabled', true);
                    $('#edit-incoming-total-installment-label').attr('hidden', true);
                    $('#edit-incoming-total-installment').attr('hidden', true);
                }
            }

            $('#edit-product-incoming').click(function() {
                var date = $('#edit-incoming-date').val();
                var product = $('#edit-incoming-product-name').val();
                if ($('#edit-incoming-unit').val() == 1) {
                    var stockIn = $('#edit-incoming-stock-in').val();
                    var price = $('#edit-incoming-price').val();
                } else if ($('#edit-incoming-unit').val() == 2) {
                    var stockIn = $('#edit-incoming-stock-in').val() * 12;
                    var price = $('#edit-incoming-price').val() / 12;
                }
                if ($('#edit-incoming-payment-status').val() == 'Belum Lunas') {
                    var paymentStatus = 'Belum';
                } else {
                    var paymentStatus = $('#edit-incoming-payment-status').val();
                }
                var totalPrice = $('#edit-incoming-total-price').val();
                var paymentType = $('#edit-incoming-payment-type').val();
                var dp = $('#edit-incoming-dp').val();
                var totalInstallment = $('#edit-incoming-total-installment').val();
                var paidOff = $('#edit-incoming-paid-off').val();

                $.ajax({
                    url: '/incoming' + '/' + selectedData.id,
                    type: 'POST',
                    data: {
                        datetime_incoming: date,
                        product_id: product,
                        stock_in: stockIn,
                        price: price,
                        total_price: totalPrice,
                        payment_type: paymentType,
                        total_installment: totalInstallment,
                        dp: dp,
                        payment_status: paymentStatus,
                        paid_off: paidOff,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        $('#edit-incoming-date').val('');
                        $('#edit-incoming-product-name').val('');
                        $('#edit-incoming-stock-in').val('');
                        $('#edit-incoming-unit').val('');
                        $('#edit-incoming-price').val('');
                        $('#edit-incoming-total-price').val('');
                        $('#edit-incoming-dp').val('');
                        $('#edit-incoming-payment-status').val('');
                        $('#edit-incoming-paid-off').val('');
                        $('#modalEditProductIncoming').modal('hide');
                        $('#table-product-incoming').DataTable().ajax.reload();
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

            $('#button-x-edit-product-incoming').on('click', function() {
                $('#modalEditProductIncoming').modal('hide');
            });
            $('#button-close-edit-product-incoming').on('click', function() {
                $('#modalEditProductIncoming').modal('hide');
            });

            $(document).on('click', '.button-delete-product-incoming', function() {
                selectedData = $('#table-product-incoming').DataTable().row($(this).parents('tr')).data();
                Swal.fire({
                    title: "Apakah anda yakin?",
                    text: "Anda tidak akan dapat mengembalikan ini!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yaa, hapus data!",
                    cancelButtonText: "Batal"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/incoming/' + selectedData.id,
                            type: 'DELETE',
                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(data) {
                                $('#table-product-incoming').DataTable().ajax.reload();
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
                    }
                });
            });

            $(document).on('click', '.button-pay-installment', function() {
                selectedData = $('#table-product-incoming').DataTable().row($(this).parents('tr')).data();
                var price = selectedData.paid_off / selectedData.total_installment;
                $('#modalAddPaymentInstallment').modal('show');
                $('#add-installment-date').val(dateNow());
                $('#add-installment-price').val(price);
            });

            $('#add-payment-installment').on('click', function() {
                var datetime_payment = $('#add-installment-date').val();
                var installment = $('#add-installment-price').val();
                $.ajax({
                    url: '/Tunai-flow',
                    type: 'POST',
                    data: {
                        datetime_payment: datetime_payment,
                        installment: installment,
                        product_incoming_id: selectedData.id,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        $('#add-installment-date').val('');
                        $('#add-installment-price').val('');
                        $('#modalAddPaymentInstallment').modal('hide');
                        $('#table-product-incoming').DataTable().ajax.reload();
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

            $('#button-x-add-payment-installment').on('click', function() {
                $('#modalAddPaymentInstallment').modal('hide');
            });
            $('#button-close-add-payment-installment').on('click', function() {
                $('#modalAddPaymentInstallment').modal('hide');
            });

            $(document).on('click', '.button-show-installment', function() {
                selectedData = $('#table-product-incoming').DataTable().row($(this).parents('tr')).data();
                let installments = JSON.parse(selectedData.installments);
                $('#table-show-installments').empty();

                const formatCurrency = new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0,
                    currencyDisplay: 'symbol'
                });


                if (selectedData.total_detail_installments == 0) {
                    $('#table-show-installments').append(
                        '<tr><td colspan="4" class="text-center">Belum ada cicilan</td></tr>');
                } else {
                    installments.map((installment, index) => {
                        $('#table-show-installments').append(
                            `<tr>
                                <td>${index + 1}</td>
                                <td>${installment.datetime_payment}</td>
                                <td>${formatCurrency.format(installment.installment).replace(/\./g, ',')}</td>
                            </tr>`
                        );
                    });
                }

                $('#modalShowPaymentInstallment').modal('show');
            });
            $('#button-x-show-payment-installment').on('click', function() {
                $('#modalShowPaymentInstallment').modal('hide');
            });
            $('#button-close-show-payment-installment').on('click', function() {
                $('#modalShowPaymentInstallment').modal('hide');
            });
        });
    </script>
@endsection
