@extends('layout.adminKit')

@section('sidebar')
    @include('layout.sidebar')
@endsection
@section('navbar')
    @include('layout.navbar')
@endsection

@section('content')
    <div class="ml-[60px] md:ml-64">
        <div class="mb-4 d-flex justify-content-end">
            <button type="button" class="btn btn-primary" id="button-add-product">
                Tambah Produk
            </button>
        </div>
        <table id="table-product" class="table table-hover table-striped">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Id</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Tipe</th>
                    <th scope="col">Harga</th>
                    <th scope="col">Stok</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
        </table>
    </div>

    <!-- Modal Add -->
    <div id="modal-add">
        <div class="modal fade" id="modalAddProduct" tabindex="-1" role="dialog" aria-labelledby="modalAddProductTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="exampleModalLongTitle">Tambah Produk</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            id="button-x-add-product">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="/product" method="POST" class="was-validated">
                            @csrf
                            @method('POST')
                            <div class="form-group">
                                <label for="product-name">Nama Produk</label>
                                <input type="text" class="form-control form-control-lg" id="product-name"
                                    placeholder="Masukkan nama produk" required>
                                <div class="invalid-feedback">Isian tidak boleh kosong!</div>
                            </div>
                            <div class="form-group">
                                <label for="product-type">Tipe Produk</label>
                                <select class="form-control" id="product-type" required>
                                    <option value="">-- Pilih tipe produk --</option>
                                    @foreach ($productTypes as $productType)
                                        <option value="{{ $productType->id }}">{{ $productType->name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Isian tidak boleh kosong!</div>
                            </div>
                            <div class="form-group">
                                <label for="product-price">Harga Produk</label>
                                <input type="number" class="form-control form-control-lg" id="product-price"
                                    placeholder="Masukkan harga produk" min="0" required>
                                <div class="invalid-feedback">Isian tidak boleh kosong!</div>
                            </div>
                            <div class="form-group">
                                <label for="product-stock">Stok Produk</label>
                                <input type="number" class="form-control form-control-lg" id="product-stock"
                                    placeholder="Masukkan stok produk" min="0" required>
                                <div class="invalid-feedback">Isian tidak boleh kosong!</div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                    id="button-close-add-product">Tutup</button>
                                <button type="button" class="btn btn-primary" id="add-product">Tambah</button>
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
        <div class="modal fade" id="modalEditProduct" tabindex="-1" role="dialog" aria-labelledby="modalEditProductTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="exampleModalLongTitle">Ubah Data Product</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            id="button-x-edit-product">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="/product" method="POST" class="was-validated">
                            @csrf
                            @method('POST')
                            <div class="form-group">
                                <label for="edit-product-name">Nama Produk</label>
                                <input type="text" class="form-control form-control-lg" id="edit-product-name"
                                    placeholder="Masukkan nama produk" required>
                                <div class="invalid-feedback">Isian tidak boleh kosong!</div>
                            </div>
                            <div class="form-group">
                                <label for="edit-product-type">Tipe Produk</label>
                                <select class="form-control" id="edit-product-type" required>
                                    <option value="">-- Pilih tipe produk --</option>
                                    @foreach ($productTypes as $productType)
                                        <option value="{{ $productType->id }}">{{ $productType->name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Isian tidak boleh kosong!</div>
                            </div>
                            <div class="form-group">
                                <label for="edit-product-price">Harga Produk</label>
                                <input type="number" class="form-control form-control-lg" id="edit-product-price"
                                    placeholder="Masukkan harga produk" min="0" required>
                                <div class="invalid-feedback">Isian tidak boleh kosong!</div>
                            </div>
                            <div class="form-group">
                                <label for="edit-product-stock">Stok Produk</label>
                                <input type="number" class="form-control form-control-lg" id="edit-product-stock"
                                    placeholder="Masukkan stok produk" min="0" required>
                                <div class="invalid-feedback">Isian tidak boleh kosong!</div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                    id="button-close-edit-product">Tutup</button>
                                <button type="button" class="btn btn-primary" id="save-edit-product">Simpan</button>
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
            $('#table-product').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                ajax: "/product",
                columns: [{
                        data: null,
                        searchable: false,
                        orderable: false,
                        width: '50px',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'id',
                        name: 'id',
                        width: '100px',
                        searchable: true,
                        orderable: true,
                        render: function(data, type, row) {
                            return '<span class="badge badge-primary p-2" style="min-width: 30px;">' +
                                data + '</span>';
                        }
                    },
                    {
                        data: 'name',
                        name: 'name',
                        // width: '1000px',
                        searchable: true,
                        orderable: true
                    },
                    {
                        data: 'product_type_name',
                        name: 'product_type_name',
                        width: '300px',
                        searchable: true,
                        orderable: true
                    },
                    {
                        data: 'price',
                        name: 'price',
                        width: '150px',
                        searchable: true,
                        orderable: true,
                        render: $.fn.dataTable.render.number(',', '.', 0, 'Rp ')

                    },
                    {
                        data: 'stock',
                        name: 'stock',
                        width: '200px',
                        searchable: true,
                        orderable: true
                    },
                    {
                        data: 'action',
                        name: 'action',
                        width: '200px',
                        searchable: false,
                        orderable: false
                    },
                ]
            });

            $('#add-product').click(function() {
                var name = $('#product-name').val();
                var type = $('#product-type').val();
                var price = $('#product-price').val();
                var stock = $('#product-stock').val();
                $.ajax({
                    url: '/product',
                    type: 'POST',
                    data: {
                        name: name,
                        product_type_id: type,
                        price: price,
                        stock: stock,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        $('#product-name').val('');
                        $('#product-type').val('');
                        $('#product-price').val('');
                        $('#product-stock').val('');
                        $('#modalAddProduct').modal('hide');
                        $('#table-product').DataTable().ajax.reload();
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

            $('#button-add-product').on('click', function() {
                $('#modalAddProduct').modal('show');
            });
            $('#button-x-add-product').on('click', function() {
                $('#modalAddProduct').modal('hide');
            });
            $('#button-close-add-product').on('click', function() {
                $('#modalAddProduct').modal('hide');
            });

            $(document).on('click', '.button-edit-product', function() {
                selectedData = $('#table-product').DataTable().row($(this).parents('tr')).data();

                console.log(selectedData); // Log untuk memeriksa struktur data

                $('#edit-product-name').val(selectedData.name);
                $('#edit-product-type').val(selectedData.product_type_id);
                $('#edit-product-price').val(selectedData.price);
                $('#edit-product-stock').val(selectedData.stock);

                // Cek jika produk dimiliki oleh productOutgoing atau productIncoming
                if (selectedData.productOutgoing || selectedData.productIncoming) {
                    $('#edit-product-stock').prop('disabled', true);
                } else {
                    $('#edit-product-stock').prop('disabled', false);
                }

                $('#modalEditProduct').modal('show');
            });

            $('#save-edit-product').click(function() {
                var name = $('#edit-product-name').val();
                var type = $('#edit-product-type').val();
                var price = $('#edit-product-price').val();
                var stock = $('#edit-product-stock').val();
                $.ajax({
                    url: '/product' + '/' + selectedData.id,
                    type: 'POST',
                    data: {
                        name: name,
                        product_type_id: type,
                        price: price,
                        stock: stock,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        $('#product-name').val('');
                        $('#product-type').val('');
                        $('#product-price').val('');
                        $('#product-stock').val('');
                        $('#modalEditProduct').modal('hide');
                        $('#table-product').DataTable().ajax.reload();
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

            $('#button-x-edit-product').on('click', function() {
                $('#modalEditProduct').modal('hide');
            });
            $('#button-close-edit-product').on('click', function() {
                $('#modalEditProduct').modal('hide');
            });

            $(document).on('click', '.button-delete-product', function() {
                selectedData = $('#table-product').DataTable().row($(this).parents('tr')).data();
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
                            url: '/product' + '/' + selectedData.id,
                            type: 'DELETE',
                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(data) {
                                $('#table-product').DataTable().ajax.reload();
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
