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
                                <input type="number" class="form-control form-control-lg" id="incoming-stock-in"
                                    placeholder="Masukkan stok masuk" min="1" required>
                                <div class="invalid-feedback">Isian tidak boleh kosong!</div>
                            </div>
                            <div class="form-group">
                                <label for="incoming-price">Harga</label>
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
                                <label for="incoming-dp">DP</label>
                                <input type="number" class="form-control form-control-lg" id="incoming-dp"
                                    placeholder="Masukkan dp" min="0" required>
                                <div class="invalid-feedback">Isian tidak boleh kosong!</div>
                            </div>
                            <div class="form-group">
                                <label for="incoming-payment-status">Status Pembayaran</label>
                                <select class="form-control form-control-md" id="incoming-payment-status" required>
                                    <option value="">-- Pilih Status Pembayaran --</option>
                                    <option value="2">Lunas</option>
                                    <option value="1">Belum Lunas</option>
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
                                <input type="number" class="form-control form-control-lg" id="edit-incoming-stock-in"
                                    placeholder="Masukkan stok masuk" min="1" required>
                                <div class="invalid-feedback">Isian tidak boleh kosong!</div>
                            </div>
                            <div class="form-group">
                                <label for="edit-incoming-price">Harga</label>
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
                                <label for="edit-incoming-dp">DP</label>
                                <input type="number" class="form-control form-control-lg" id="edit-incoming-dp"
                                    placeholder="Masukkan dp" min="0" required>
                                <div class="invalid-feedback">Isian tidak boleh kosong!</div>
                            </div>
                            <div class="form-group">
                                <label for="edit-incoming-payment-status">Status Pembayaran</label>
                                <select class="form-control form-control-md" id="edit-incoming-payment-status" required>
                                    <option value="">-- Pilih Status Pembayaran --</option>
                                    <option value="2">Lunas</option>
                                    <option value="1">Belum Lunas</option>
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

            function calculateTotalPrice() {
                let price = $('#incoming-price').val();
                let stockIn = $('#incoming-stock-in').val();
                let totalPrice = price * stockIn;
                $('#incoming-total-price').val(totalPrice);
                calculatePaidOff();
            }
            $('#incoming-price, #incoming-stock-in').on('input', calculateTotalPrice);

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
            $('#incoming-dp').on('input', calculatePaidOff);

            $('#add-product-incoming').click(function() {
                var date = $('#incoming-date').val();
                var product = $('#incoming-product-name').val();
                var stockIn = $('#incoming-stock-in').val();
                var price = $('#incoming-price').val();
                var totalPrice = $('#incoming-total-price').val();
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
                        dp: dp,
                        payment_status: paymentStatus,
                        paid_off: paidOff,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        $('#incoming-date').val('');
                        tomSelectAddProductIncome.clear();
                        $('#incoming-stock-in').val('');
                        $('#incoming-price').val('');
                        $('#incoming-total-price').val('');
                        $('#incoming-dp').val('');
                        $('#incoming-payment-status').val('');
                        $('#incoming-paid-off').val('');
                        $('#modalAddProductIncoming').modal('hide');
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
                let formattedDate =
                    `${dateParts[2]}-${dateParts[1]}-${dateParts[0]}`;

                $('#edit-incoming-date').val(formattedDate);
                tomSelectEditProductIncome.setValue(selectedData.product.id);
                $('#edit-incoming-stock-in').val(selectedData.stock_in);
                $('#edit-incoming-price').val(selectedData.price);
                $('#edit-incoming-total-price').val(selectedData.total_price);
                $('#edit-incoming-dp').val(selectedData.dp);
                if (selectedData.payment_status == 'Belum Lunas') {
                    selectedData.payment_status = 1;
                } else {
                    selectedData.payment_status = 2;
                }
                $('#edit-incoming-payment-status').val(selectedData.payment_status);
                $('#edit-incoming-paid-off').val(selectedData.paid_off);
                $('#modalEditProductIncoming').modal('show');
            });

            function calculateEditTotalPrice() {
                let price = $('#edit-incoming-price').val();
                let stockIn = $('#edit-incoming-stock-in').val();
                let totalPrice = price * stockIn;
                $('#edit-incoming-total-price').val(totalPrice);
                calculateEditPaidOff();
            }
            $('#edit-incoming-price, #edit-incoming-stock-in').on('input', calculateEditTotalPrice);

            function calculateEditPaidOff() {
                let totalPrice = $('#edit-incoming-total-price').val();
                let dp = $('#edit-incoming-dp').val();
                let paidOff = totalPrice - dp;
                $('#edit-incoming-paid-off').val(paidOff);
                $('#edit-incoming-dp').attr('max', totalPrice);
                if (paidOff == 0) {
                    $('#edit-incoming-payment-status').val(2);
                } else {
                    $('#edit-incoming-payment-status').val(1);
                }
            }
            $('#edit-incoming-dp').on('input', calculateEditPaidOff);

            $('#edit-product-incoming').click(function() {
                var date = $('#edit-incoming-date').val();
                var product = $('#edit-incoming-product-name').val();
                var stockIn = $('#edit-incoming-stock-in').val();
                var price = $('#edit-incoming-price').val();
                var totalPrice = $('#edit-incoming-total-price').val();
                var dp = $('#edit-incoming-dp').val();
                var paymentStatus = $('#edit-incoming-payment-status').val();
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
                        dp: dp,
                        payment_status: paymentStatus,
                        paid_off: paidOff,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        $('#edit-incoming-date').val('');
                        $('#edit-incoming-product-name').val('');
                        $('#edit-incoming-stock-in').val('');
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
        });
    </script>
@endsection
