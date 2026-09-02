@extends('layouts.app')

@section('title', 'Daftar Produk')

@section('content')

    <div class="page-header mb-4">
        <h1 class="page-title">Categories</h1>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Data belum bisa disimpan!</strong>

            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="table">
        <div class="table-responsive">

            <table id="myTable" class="table table-hover align-middle mb-0">

                <thead>
                    <tr>
                        <th>Nomor</th>
                        <th>Nama</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach ($data as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                {{ $item->nama }}
                            </td>
                            <td>
                                {{ $item->keterangan }}
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#modalEdit{{ $item->id }}">
                                        Show
                                    </button>
                                    <form action="{{ route('kategori.destroy', $item->id) }}" method="POST"
                                        class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        {{-- MODAL EDIT --}}
                        <div class="modal fade" id="modalEdit{{ $item->id }}" tabindex="-1"
                            aria-labelledby="modalEditLabel{{ $item->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalEditLabel{{ $item->id }}">
                                            Edit Categories
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                                        </button>
                                    </div>
                                    <form action="{{ route('kategori.update', $item->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body">
                                            <div class="row">
                                                {{-- NAMA --}}
                                                <div class="col-md-6 mb-3">

                                                    <label class="form-label">
                                                        Nama Kategori
                                                    </label>
                                                    <input type="text" name="nama" class="form-control"
                                                        value="{{ $item->nama }}" required>
                                                </div>
                                                {{-- KETERANGAN --}}
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">
                                                        Keterangan
                                                    </label>
                                                    <input type="text" name="keterangan" class="form-control"
                                                        value="{{ $item->keterangan }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                Close
                                            </button>
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-save"></i>
                                                Edit Data
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


    {{-- URL UNTUK DATATABLE --}}
    <script>
        const addcategoriesUrl = "{{ route('detail.addkategori') }}";
        const pageType = "kategori";
    </script>

    {{-- ALERT SUCCESS --}}
    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {

                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: @json(session('success')),
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#0d6efd'
                });

            });
        </script>
    @endif


    {{-- KONFIRMASI DELETE --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            document.querySelectorAll('.delete-form').forEach(function(form) {

                form.addEventListener('submit', function(event) {

                    event.preventDefault();

                    Swal.fire({
                        title: 'Apakah kamu yakin?',
                        text: 'Data kategori akan dihapus!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal',
                        confirmButtonColor: '#dc3545',
                        cancelButtonColor: '#6c757d'
                    }).then((result) => {

                        if (result.isConfirmed) {
                            form.submit();
                        }

                    });

                });

            });

        });
    </script>

@endsection
