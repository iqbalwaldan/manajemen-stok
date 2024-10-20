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
            <button type="button" id="button-add-product-type" class="btn btn-primary">
                Tambah Tipe Produk
            </button>
        </div>
        <table id="table-product-type" class="table table-hover table-striped">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
        </table>
    </div>
    <!-- Modal Add -->
    <div id="modal-add">
        <div class="modal fade" id="modalAddProductType" tabindex="-1" role="dialog"
            aria-labelledby="modalAddProductTypeTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="exampleModalLongTitle">Tambah Tipe Produk</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            id="button-x-add-product-type">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="form-add" action="/type" method="POST" class="was-validated">
                            @csrf
                            @method('POST')
                            <div class="form-group">
                                <label for="product-type-name">Nama Tipe Produk</label>
                                <input type="text" class="form-control form-control-lg" id="product-type-name"
                                    placeholder="Masukkan nama tipe produk" required>
                                <div class="invalid-feedback">Isian tidak boleh kosong!</div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                    id="button-close-add-product-type">Tutup</button>
                                <button type="button" class="btn btn-primary" id="add-product-type">Tambah</button>
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
        <div class="modal fade" id="modalEditProductType" tabindex="-1" role="dialog"
            aria-labelledby="modalEditProductTypeTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="exampleModalLongTitle">Ubah Data Tipe Produk</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            id="button-x-edit-product-type">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="form-edit" action="/type" method="POST" class="was-validated">
                            @csrf
                            @method('POST')
                            <div class="form-group">
                                <label for="edit-product-name">Nama Tipe Produk</label>
                                <input type="text" class="form-control form-control-lg" id="edit-product-type-name"
                                    placeholder="Masukkan nama tipe produk" required>
                                <div class="invalid-feedback">Isian tidak boleh kosong!</div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                    id="button-close-edit-product-type">Tutup</button>
                                <button type="button" class="btn btn-primary" id="save-edit-product-type">Simpan</button>
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
            $('#table-product-type').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                ajax: "/type",
                columns: [{
                        // title: 'No',
                        data: null,
                        searchable: false,
                        orderable: false,
                        width: '50px',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'name',
                        name: 'name',
                    },
                    {
                        data: 'action',
                        name: 'action',
                        width: '150px',
                    },
                ]
            });

            $('#form-add').on('submit', function(e) {
                e.preventDefault();
                $('#add-product-type').click();
            });

            $('#add-product-type').click(function() {
                var name = $('#product-type-name').val();
                $.ajax({
                    url: '/type',
                    type: 'POST',
                    data: {
                        name: name,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        $('#product-type-name').val('');
                        $('#modalAddProductType').modal('hide');
                        $('#table-product-type').DataTable().ajax.reload();
                        Swal.fire({
                            icon: "success",
                            title: data.title,
                            text: data.message,
                            confirmButtonColor: "#3085d6",
                        });
                    },
                    error: function(data) {
                        Swal.fire({
                            icon: "error",
                            title: data.responseJSON.title,
                            text: data.responseJSON.message,
                            confirmButtonColor: "#3085d6",
                        });
                    }
                });
            });

            $('#button-add-product-type').on('click', function() {
                $('#modalAddProductType').modal('show');
            });
            $('#button-x-add-product-type').on('click', function() {
                $('#modalAddProductType').modal('hide');
            });
            $('#button-close-add-product-type').on('click', function() {
                $('#modalAddProductType').modal('hide');
            });

            $(document).on('click', '.button-edit-product-type', function() {
                selectedData = $('#table-product-type').DataTable().row($(this).parents('tr')).data();

                $('#edit-product-type-name').val(selectedData.name);
                $('#modalEditProductType').modal('show');
            });

            $('#form-edit').on('submit', function(e) {
                e.preventDefault();
                $('#save-edit-product-type').click();
            });

            $('#save-edit-product-type').click(function() {
                var name = $('#edit-product-type-name').val();
                $.ajax({
                    url: '/type' + '/' + selectedData.id,
                    type: 'POST',
                    data: {
                        name: name,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        $('#edit-product-type-name').val('');
                        $('#modalEditProductType').modal('hide');
                        $('#table-product-type').DataTable().ajax.reload();
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

            $('#button-x-edit-product-type').on('click', function() {
                $('#modalEditProductType').modal('hide');
            });
            $('#button-close-edit-product-type').on('click', function() {
                $('#modalEditProductType').modal('hide');
            });

            $(document).on('click', '.button-delete-product-type', function() {
                selectedData = $('#table-product-type').DataTable().row($(this).parents('tr')).data();
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
                            url: '/type' + '/' + selectedData.id,
                            type: 'DELETE',
                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(data) {
                                $('#table-product-type').DataTable().ajax.reload();
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
