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
            <button type="button" id="button-add-product-outgoing" class="btn btn-primary">
                Tambah Produk Keluar
            </button>
        </div>
        <div class="">
            <div class="">
                <table id="table-product-outgoing" class="">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Tanggal</th>
                            <th scope="col">Nama Pembeli</th>
                            <th scope="col">Marketplace</th>
                            <th scope="col">Nama Produk</th>
                            <th scope="col">Stok Keluar</th>
                            <th scope="col">Harga Beli</th>
                            <th scope="col">Harga Jual</th>
                            <th scope="col">Total Harga</th>
                            <th scope="col">Keuntungan</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <!-- Modal Add -->
    <div id="modal-add">
        <div class="modal fade" id="modalAddProductOutgoing" tabindex="-1" role="dialog"
            aria-labelledby="modalAddProductOutgoingTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="exampleModalLongTitle">Tambah Produk Keluar</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            id="button-x-add-product-outgoing">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="/outgoing" method="POST" class="was-validated">
                            @csrf
                            @method('POST')
                            <div class="form-group">
                                <label for="outgoing-date">Tanggal</label>
                                <input type="date" class="form-control form-control-lg" id="outgoing-date" required>
                                <div class="invalid-feedback">Isian tidak boleh kosong!</div>
                            </div>
                            <div class="form-group">
                                <label for="outgoing-buyer-name">Nama Pembeli</label>
                                <input type="text" class="form-control form-control-lg" id="outgoing-buyer-name"
                                    placeholder="Masukkan nama pembeli" required>
                                <div class="invalid-feedback">Isian tidak boleh kosong!</div>
                            </div>
                            <div class="form-group">
                                <label for="outgoing-marketplace">Marketplace</label>
                                <select class="form-control form-control-md" id="outgoing-marketplace" required>
                                    <option value="">-- Pilih Marketplace --</option>
                                    <option value="shopee">Shopee</option>
                                    <option value="tokopedia">Tokopedia</option>
                                    <option value="tiktok">Tiktok</option>
                                    <option value="lainnya">Lainnya</option>
                                </select>
                                <div class="invalid-feedback">Isian tidak boleh kosong!</div>
                            </div>
                            <!-- Input text untuk pilihan 'Lainnya' -->
                            <div class="form-group" id="marketplace-form" style="display: none;">
                                <label for="marketplace-other">Masukkan Nama Marketplace</label>
                                <input type="text" class="form-control" id="marketplace-other"
                                    placeholder="Masukkan nama marketplace" required>
                                <div class="invalid-feedback">Isian tidak boleh kosong!</div>
                            </div>
                            <div class="form-group form-group-custom">
                                <label for="outgoing-product-name">Nama Produk</label>
                                <span id="valo" class="material-symbols-rounded valid-logo">
                                    error
                                </span>
                                <span id="invalo" class="material-symbols-rounded invalid-logo hidden">
                                    check
                                </span>
                                <select class="custom-tom-select
                                    empty"
                                    id="outgoing-product-name" required>
                                    <option value="">Pilih produk</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }} ({{ $product->id }})
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Isian tidak boleh kosong!</div>
                            </div>
                            <div class="form-group">
                                <label for="outgoing-stock-out">Stok Keluar</label>
                                <div style="display: flex; gap: 10px;">
                                    <div style="width: 100%">
                                        <input type="number" class="form-control form-control-lg" id="outgoing-stock-out"
                                            placeholder="Masukkan stok keluar" min="1" required>
                                        <div class="invalid-feedback">Isian tidak boleh kosong!</div>
                                    </div>
                                    <div style="width: 100%">
                                        <select class="form-control form-control-md" id="outgoing-unit" required>
                                            <option value="">-- Pilih Satuan --</option>
                                            <option value="1">Pcs</option>
                                            <option value="2">Lusin</option>
                                        </select>
                                        <div class="invalid-feedback">Isian tidak boleh kosong!</div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="outgoing-purchase-price">Harga Beli</label>
                                <input type="number" class="form-control form-control-lg" id="outgoing-purchase-price"
                                    placeholder="Masukkan harga beli" min="0" required>
                                <div class="invalid-feedback">Isian tidak boleh kosong!</div>
                            </div>
                            <div class="form-group">
                                <label for="outgoing-selling-price">Harga Jual</label>
                                <input type="number" class="form-control form-control-lg" id="outgoing-selling-price"
                                    placeholder="Masukkan harga jual" min="0" required>
                                <div class="invalid-feedback">Isian tidak boleh kosong!</div>
                            </div>
                            <div class="form-group">
                                <label for="outgoing-total-price">Total Harga Jual</label>
                                <input type="number" class="form-control form-control-lg" id="outgoing-total-price"
                                    placeholder="Isi stok keluar dan harga jual terlebih dahulu" required disabled>
                            </div>
                            <div class="form-group">
                                <label for="outgoing-profit">Keuntungan</label>
                                <input type="number" class="form-control form-control-lg" id="outgoing-profit"
                                    placeholder="Isi harga beli dan harga jual terlebih dahulu" required disabled>
                                <div class="invalid-feedback">Isian tidak boleh kosong!</div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                    id="button-close-add-product-outgoing">Tutup</button>
                                <button type="button" class="btn btn-primary" id="add-product-outgoing">Tambah</button>
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
        <div class="modal fade" id="modalEditProductOutgoing" tabindex="-1" role="dialog"
            aria-labelledby="modalEditProductOutgoingTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="exampleModalLongTitle">Ubah Produk Keluar</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            id="button-x-edit-product-outgoing">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="/outgoing" method="POST" class="was-validated">
                            @csrf
                            @method('POST')
                            <div class="form-group">
                                <label for="edit-outgoing-date">Tanggal</label>
                                <input type="date" class="form-control form-control-lg" id="edit-outgoing-date"
                                    required>
                                <div class="invalid-feedback">Isian tidak boleh kosong!</div>
                            </div>
                            <div class="form-group">
                                <label for="edit-outgoing-buyer-name">Nama Pembeli</label>
                                <input type="text" class="form-control form-control-lg" id="edit-outgoing-buyer-name"
                                    placeholder="Masukkan nama pembeli" required>
                                <div class="invalid-feedback">Isian tidak boleh kosong!</div>
                            </div>
                            <div class="form-group">
                                <label for="edit-outgoing-marketplace">Marketplace</label>
                                <select class="form-control form-control-md" id="edit-outgoing-marketplace" required>
                                    <option value="">-- Pilih Marketplace --</option>
                                    <option value="shopee">Shopee</option>
                                    <option value="tokopedia">Tokopedia</option>
                                    <option value="tiktok">Tiktok</option>
                                    <option value="lainnya">Lainnya</option>
                                </select>
                                <div class="invalid-feedback">Isian tidak boleh kosong!</div>
                            </div>
                            <!-- Input text untuk pilihan 'Lainnya' -->
                            <div class="form-group" id="edit-marketplace-form" style="display: none;">
                                <label for="edit-marketplace-other">Masukkan Nama Marketplace</label>
                                <input type="text" class="form-control" id="edit-marketplace-other"
                                    placeholder="Masukkan nama marketplace" required>
                                <div class="invalid-feedback">Isian tidak boleh kosong!</div>
                            </div>
                            <div class="form-group form-group-custom">
                                <label for="edit-outgoing-product-name">Nama Produk</label>
                                <span id="edit-valo" class="material-symbols-rounded valid-logo">
                                    error
                                </span>
                                <span id="edit-invalo" class="material-symbols-rounded invalid-logo hidden">
                                    check
                                </span>
                                <select class="custom-tom-select
                                    empty"
                                    id="edit-outgoing-product-name" required>
                                    <option value="">Pilih produk</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }} ({{ $product->id }})
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Isian tidak boleh kosong!</div>
                            </div>
                            <div class="form-group">
                                <label for="edit-outgoing-stock-out">Stok Keluar</label>
                                <div style="display: flex; gap: 10px;">
                                    <div style="width: 100%">
                                        <input type="number" class="form-control form-control-lg" id="edit-outgoing-stock-out"
                                            placeholder="Masukkan stok keluar" min="1" required>
                                        <div class="invalid-feedback">Isian tidak boleh kosong!</div>
                                    </div>
                                    <div style="width: 100%">
                                        <select class="form-control form-control-md" id="edit-outgoing-unit" required>
                                            <option value="">-- Pilih Satuan --</option>
                                            <option value="1" selected>Pcs</option>
                                            <option value="2">Lusin</option>
                                        </select>
                                        <div class="invalid-feedback">Isian tidak boleh kosong!</div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="edit-outgoing-purchase-price">Harga Beli</label>
                                <input type="number" class="form-control form-control-lg"
                                    id="edit-outgoing-purchase-price" placeholder="Masukkan harga beli" min="0"
                                    required>
                                <div class="invalid-feedback">Isian tidak boleh kosong!</div>
                            </div>
                            <div class="form-group">
                                <label for="edit-outgoing-selling-price">Harga Jual</label>
                                <input type="number" class="form-control form-control-lg"
                                    id="edit-outgoing-selling-price" placeholder="Masukkan harga jual" min="0"
                                    required>
                                <div class="invalid-feedback">Isian tidak boleh kosong!</div>
                            </div>
                            <div class="form-group">
                                <label for="edit-outgoing-total-price">Total Harga Jual</label>
                                <input type="number" class="form-control form-control-lg" id="edit-outgoing-total-price"
                                    placeholder="Isi stok keluar dan harga jual terlebih dahulu" required disabled>
                            </div>
                            <div class="form-group">
                                <label for="edit-outgoing-profit">Keuntungan</label>
                                <input type="number" class="form-control form-control-lg" id="edit-outgoing-profit"
                                    placeholder="Isi harga beli dan harga jual terlebih dahulu" required disabled>
                                <div class="invalid-feedback">Isian tidak boleh kosong!</div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                    id="button-close-edit-product-outgoing">Tutup</button>
                                <button type="button" class="btn btn-primary" id="edit-product-outgoing">Simpan</button>
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
        $(document).ready(function() {
            let selectedData = null;

            $('#table-product-outgoing').DataTable({
                processing: true,
                serverSide: true,
                ajax: "/outgoing",
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
                        data: 'datetime_transaction',
                        name: 'datetime_transaction'
                    },
                    {
                        data: 'buyer_name',
                        name: 'buyer_name'
                    },
                    {
                        data: 'marketplace',
                        name: 'marketplace',
                        render: function(data, type, row) {
                            return data.charAt(0).toUpperCase() + data.slice(1);
                        }
                    },
                    {
                        data: 'product_id',
                        name: 'product_id',
                        render: function(data, type, row) {
                            return '<span class="badge badge-primary p-2" style="min-width: 30px;">' +
                                row.product.id + '</span> ' + row.product.name;
                        }
                    },
                    {
                        data: 'stock_out',
                        name: 'stock_out'
                    },
                    {
                        data: 'purchase_price',
                        name: 'purchase_price',
                        render: $.fn.dataTable.render.number(',', '.', 0, 'Rp ')
                    },
                    {
                        data: 'selling_price',
                        name: 'selling_price',
                        render: $.fn.dataTable.render.number(',', '.', 0, 'Rp ')
                    },
                    {
                        data: 'total_price',
                        name: 'total_price',
                        render: $.fn.dataTable.render.number(',', '.', 0, 'Rp ')
                    },
                    {
                        data: 'profit',
                        name: 'profit',
                        render: $.fn.dataTable.render.number(',', '.', 0, 'Rp ')
                    },
                    {
                        width: '160px',
                        data: 'action',
                        name: 'action'
                    },
                ]
            });

            var tomSelectAddProductOutgoing = new TomSelect("#outgoing-product-name", {
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
                        if (value) {
                            $.ajax({
                                url: '/product-data',
                                type: 'GET',
                                data: {
                                    id: value,
                                },
                                success: function(response) {
                                    $('#outgoing-purchase-price').val(response.price);
                                    calculateTotalPrice();
                                },
                                error: function(xhr) {
                                    console.error(xhr.responseText);
                                }
                            });
                        }
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
                let sellingPrice = $('#outgoing-selling-price').val();
                let unit = $('#outgoing-unit').val();
                if (unit == '' || sellingPrice == '') {
                    return;
                }
                if (unit == 1) {
                    var stockOut = $('#outgoing-stock-out').val();
                } else if (unit == 2) {
                    var stockOut = $('#outgoing-stock-out').val() * 12;
                }
                let totalPrice = sellingPrice * stockOut;
                $('#outgoing-total-price').val(totalPrice);
                calculateProfit();
            }

            function calculateProfit() {
                if ($('#outgoing-unit').val() == 1) {
                    var stockOut = $('#outgoing-stock-out').val();
                } else if ($('#outgoing-unit').val() == 2) {
                    var stockOut = $('#outgoing-stock-out').val() * 12;
                }
                let totalPrice = $('#outgoing-total-price').val();
                let purchasePrice = $('#outgoing-purchase-price').val();
                let profit = totalPrice - (stockOut * purchasePrice);
                $('#outgoing-profit').val(profit);
            }

            $('#outgoing-purchase-price, #outgoing-selling-price, #outgoing-stock-out').on('input', calculateTotalPrice);
            $('#outgoing-unit').on('change', calculateTotalPrice);
            
            $('#outgoing-marketplace').on('change', function() {
                var selectedValue = $(this).val();

                if (selectedValue === 'lainnya') {
                    $('#marketplace-form').show(); 
                    $('#marketplace-other').attr('required', true); 
                } else {
                    $('#marketplace-form').hide(); 
                    $('#marketplace-other').val('');
                    $('#marketplace-other').attr('required', false); 
                }
            });

            $('#add-product-outgoing').click(function() {
                var date = $('#outgoing-date').val();
                var buyerName = $('#outgoing-buyer-name').val();
                var marketplace = $('#outgoing-marketplace').val();
                if (marketplace === 'lainnya') {
                    marketplace = $('#marketplace-other').val();
                    marketplace = marketplace.toLowerCase();
                }
                var product = $('#outgoing-product-name').val();
                if ($('#outgoing-unit').val() == 1) {
                    var stockOut = $('#outgoing-stock-out').val();
                } else if ($('#outgoing-unit').val() == 2) {
                    var stockOut = $('#outgoing-stock-out').val() * 12;
                }
                var purchasePrice = $('#outgoing-purchase-price').val();
                var sellingPrice = $('#outgoing-selling-price').val();
                var totalPrice = $('#outgoing-total-price').val();
                var profit = $('#outgoing-profit').val();

                $.ajax({
                    url: '/outgoing',
                    type: 'POST',
                    data: {
                        datetime_transaction: date,
                        buyer_name: buyerName,
                        marketplace: marketplace,
                        product_id: product,
                        stock_out: stockOut,
                        purchase_price: purchasePrice,
                        selling_price: sellingPrice,
                        total_price: totalPrice,
                        profit: profit,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        $('#outgoing-date').val('');
                        $('#outgoing-buyer-name').val('');
                        $('#outgoing-marketplace').val('');
                        $('#marketplace-other').val('');
                        tomSelectAddProductOutgoing.clear();
                        $('#outgoing-stock-out').val('');
                        $('#outgoing-purchase-price').val('');
                        $('#outgoing-selling-price').val('');
                        $('#outgoing-total-price').val('');
                        $('#outgoing-profit').val('');
                        $('#modalAddProductOutgoing').modal('hide');
                        $('#table-product-outgoing').DataTable().ajax.reload();
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

            $('#button-add-product-outgoing').on('click', function() {
                $('#outgoing-date').val(dateNow());
                $('#modalAddProductOutgoing').modal('show');
            });
            $('#button-x-add-product-outgoing').on('click', function() {
                $('#modalAddProductOutgoing').modal('hide');
            });
            $('#button-close-add-product-outgoing').on('click', function() {
                $('#modalAddProductOutgoing').modal('hide');
            });

            var tomSelectEditProductOutgoing = new TomSelect("#edit-outgoing-product-name", {
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
                        if (value) {
                            $.ajax({
                                url: '/product-data',
                                type: 'GET',
                                data: {
                                    id: value,
                                },
                                success: function(response) {
                                    $('#edit-outgoing-purchase-price').val(response.price);
                                    calculateEditTotalPrice();
                                },
                                error: function(xhr) {
                                    console.error(xhr.responseText);
                                }
                            });
                        }
                    } else {
                        $(this.input).siblings('.custom-tom-select').removeClass('filled').addClass(
                            'empty');
                        $('#edit-invalo').addClass('hidden');
                        $('#edit-valo').removeClass('hidden');
                    }
                }
            });

            $('#edit-outgoing-marketplace').on('change', function() {
                var selectedValue = $(this).val();

                if (selectedValue === 'lainnya') {
                    $('#edit-marketplace-form').show();
                    $('#edit-marketplace-other').attr('required', true);
                } else {
                    $('#edit-marketplace-form').hide();
                    $('#edit-marketplace-other').val('');
                    $('#edit-marketplace-other').attr('required', false);
                }
            });

            $(document).on('click', '.button-edit-product-outgoing', function() {
                selectedData = $('#table-product-outgoing').DataTable().row($(this).parents('tr')).data();

                let date = selectedData.datetime_transaction;
                let dateParts = date.split('-');
                let formattedDate =
                    `${dateParts[2]}-${dateParts[1]}-${dateParts[0]}`;

                $('#edit-outgoing-date').val(formattedDate);
                $('#edit-outgoing-buyer-name').val(selectedData.buyer_name);
                $('#edit-outgoing-marketplace').val(selectedData.marketplace);
                if (selectedData.marketplace != 'shopee' && selectedData.marketplace != 'tokopedia' &&
                    selectedData.marketplace != 'tiktok') {
                    $('#edit-marketplace-form').show();
                    $('#edit-outgoing-marketplace').val('lainnya');
                    $('#edit-marketplace-other').val(selectedData.marketplace);
                } else {
                    $('#edit-marketplace-form').hide();
                    $('#edit-marketplace-other').val('');
                }
                tomSelectEditProductOutgoing.setValue(selectedData.product.id);
                $('#edit-outgoing-stock-out').val(selectedData.stock_out);
                $('#edit-outgoing-purchase-price').val(selectedData.purchase_price);
                $('#edit-outgoing-selling-price').val(selectedData.selling_price);
                $('#edit-outgoing-total-price').val(selectedData.total_price);
                $('#edit-outgoing-profit').val(selectedData.profit);

                $('#modalEditProductOutgoing').modal('show');
            });

            function calculateEditTotalPrice() {
                let sellingPrice = $('#edit-outgoing-selling-price').val();
                let unit = $('#edit-outgoing-unit').val();
                if (unit == '' || sellingPrice == '') {
                    return;
                }
                if (unit == 1) {
                    var stockOut = $('#edit-outgoing-stock-out').val();
                } else if (unit == 2) {
                    var stockOut = $('#edit-outgoing-stock-out').val() * 12;
                }
                let totalPrice = sellingPrice * stockOut;
                $('#edit-outgoing-total-price').val(totalPrice);
                calculateEditProfit();
            }
            $('#edit-outgoing-purchase-price, #edit-outgoing-selling-price, #edit-outgoing-stock-out').on('input', calculateEditTotalPrice);
            $('#edit-outgoing-unit').on('change', calculateEditTotalPrice);

            function calculateEditProfit() {
                if ($('#edit-outgoing-unit').val() == 1) {
                    var stockOut = $('#edit-outgoing-stock-out').val();
                } else if ($('#edit-outgoing-unit').val() == 2) {
                    var stockOut = $('#edit-outgoing-stock-out').val() * 12;
                }
                let totalPrice = $('#edit-outgoing-total-price').val();
                let purchasePrice = $('#edit-outgoing-purchase-price').val();
                let profit = totalPrice - (stockOut * purchasePrice);
                $('#edit-outgoing-profit').val(profit);
            }

            $('#edit-product-outgoing').click(function() {
                var date = $('#edit-outgoing-date').val();
                var buyerName = $('#edit-outgoing-buyer-name').val();
                var marketplace = $('#edit-outgoing-marketplace').val();
                if (marketplace === 'lainnya') {
                    marketplace = $('#edit-marketplace-other').val();
                    marketplace = marketplace.toLowerCase();
                }
                var product = $('#edit-outgoing-product-name').val();
                if ($('#edit-outgoing-unit').val() == 1) {
                    var stockOut = $('#edit-outgoing-stock-out').val();
                } else if ($('#edit-outgoing-unit').val() == 2) {
                    var stockOut = $('#edit-outgoing-stock-out').val() * 12;
                }
                var purchasePrice = $('#edit-outgoing-purchase-price').val();
                var sellingPrice = $('#edit-outgoing-selling-price').val();
                var totalPrice = $('#edit-outgoing-total-price').val();
                var profit = $('#edit-outgoing-profit').val();

                $.ajax({
                    url: '/outgoing' + '/' + selectedData.id,
                    type: 'POST',
                    data: {
                        datetime_transaction: date,
                        buyer_name: buyerName,
                        marketplace: marketplace,
                        product_id: product,
                        stock_out: stockOut,
                        purchase_price: purchasePrice,
                        selling_price: sellingPrice,
                        total_price: totalPrice,
                        profit: profit,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        $('#edit-outgoing-date').val('');
                        $('#edit-outgoing-buyer-name').val('');
                        $('#edit-outgoing-marketplace').val('');
                        $('#edit-marketplace-other').val('');
                        tomSelectEditProductOutgoing.clear();
                        $('#edit-outgoing-stock-out').val('');
                        $('#edit-outgoing-purchase-price').val('');
                        $('#edit-outgoing-selling-price').val('');
                        $('#edit-outgoing-total-price').val('');
                        $('#edit-outgoing-profit').val('');
                        $('#modalEditProductOutgoing').modal('hide');
                        $('#table-product-outgoing').DataTable().ajax.reload();
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

            $('#button-x-edit-product-outgoing').on('click', function() {
                $('#modalEditProductOutgoing').modal('hide');
            });
            $('#button-close-edit-product-outgoing').on('click', function() {
                $('#modalEditProductOutgoing').modal('hide');
            });

            $(document).on('click', '.button-delete-product-outgoing', function() {
                selectedData = $('#table-product-outgoing').DataTable().row($(this).parents('tr')).data();
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
                            url: '/outgoing/' + selectedData.id,
                            type: 'DELETE',
                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(data) {
                                $('#table-product-outgoing').DataTable().ajax.reload();
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
