@extends('layouts.app')
@section('title', 'Daftar Produk')
@section('content')
    <div class="page-header mb-4">
        <h1 class="page-title">Produk</h1>
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
                        <th>Kode</th>
                        <th>Gambar</th>
                        <th>Nama</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Deskripsi</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($data->isEmpty())
                        <tr>
                            <td colspan="9" class="text-center">
                                Belum ada data produk.
                            </td>
                        </tr>
                    @else
                        @foreach ($data as $item)
                            <tr>
                                <td>
                                    {{ $loop->iteration }}
                                </td>
                                <td>
                                    {{ $item->kode }}
                                </td>
                                <td>
                                    @if ($item->gambar)
                                        <img src="{{ asset('storage/gambar/' . $item->gambar) }}" alt="{{ $item->nama }}"
                                            width="50" height="50" class="product-image">
                                    @else
                                        <span class="badge bg-secondary">
                                            Tidak ada gambar
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    {{ $item->nama }}
                                </td>
                                <td>
                                   Rp. {{ number_format($item->harga, 2, '.', '') }}
                                </td>
                                <td>
                                    {{ $item->stok }}
                                </td>
                                <td>
                                    {{ $item->deskripsi ?? '-' }}
                                </td>
                                <td>
                                    @if ($item->status)
                                        <span class="badge bg-primary">
                                            Activate
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">
                                            Non Activate
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex gap-1">
                                        {{-- SHOW / EDIT --}}
                                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#modalEdit{{ $item->id }}">
                                            Show
                                        </button>
                                        <form action="{{ route('produk.destroy', $item->id) }}" method="POST"
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
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    {{-- MODAL EDIT PRODUK --}}
    @foreach ($data as $item)
        <div class="modal fade" id="modalEdit{{ $item->id }}" tabindex="-1"
            aria-labelledby="modalEditLabel{{ $item->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    {{-- HEADER --}}
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditLabel{{ $item->id }}">
                            Edit Produk
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>
                    </div>
                    {{-- FORM --}}
                    <form action="{{ route('produk.update', $item->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="row">
                                {{-- KATEGORI --}}
                                <div class="col-md-6 mb-3">
                                    <label for="kategori_id_{{ $item->id }}" class="form-label">
                                        Kategori Produk
                                    </label>
                                    <select name="kategori_id" id="kategori_id_{{ $item->id }}" class="form-select">
                                        <option value="">
                                            -- Pilih Kategori --
                                        </option>
                                        @foreach ($kategori as $kat)
                                            <option value="{{ $kat->id }}"
                                                {{ $item->kategori_id == $kat->id ? 'selected' : '' }}>
                                                {{ $kat->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                {{-- KODE --}}
                                <div class="col-md-6 mb-3">
                                    <label for="kode_{{ $item->id }}" class="form-label">
                                        Kode Produk
                                    </label>
                                    <input type="text" name="kode" id="kode_{{ $item->id }}"
                                        value="{{ $item->kode }}" class="form-control">
                                </div>
                                {{-- NAMA --}}
                                <div class="col-md-6 mb-3">
                                    <label for="nama_{{ $item->id }}" class="form-label">
                                        Nama Produk
                                    </label>
                                    <input type="text" name="nama" id="nama_{{ $item->id }}"
                                        value="{{ $item->nama }}" class="form-control">
                                </div>
                                {{-- GAMBAR --}}
                                <div class="col-md-6 mb-3">
                                    <label for="gambar_{{ $item->id }}" class="form-label">
                                        Gambar Produk
                                    </label>
                                    <input disabled type="file" name="gambar" id="gambar_{{ $item->id }}"
                                        accept="image/*" class="form-control"
                                        onchange="previewGambar(this, 'preview_{{ $item->id }}')">
                                    {{-- PREVIEW GAMBAR --}}
                                    <div class="mt-3">

                                        <img id="preview_{{ $item->id }}"
                                            src="{{ $item->gambar ? asset('storage/gambar/' . $item->gambar) : '' }}"
                                            alt="{{ $item->nama }}"
                                            class="img-thumbnail {{ $item->gambar ? '' : 'd-none' }}"
                                            style="width: 150px; height: 150px; object-fit: cover;">

                                    </div>

                                </div>
                                {{-- HARGA --}}
                                <div class="col-md-6 mb-3">
                                    <label for="harga_{{ $item->id }}" class="form-label">
                                        Harga Produk
                                    </label>
                                    <input type="text" name="harga" id="harga_{{ $item->id }}"
                                        value="{{ $item->harga }}" class="form-control">
                                </div>
                                {{-- STOK --}}
                                <div class="col-md-6 mb-3">
                                    <label for="stok_{{ $item->id }}" class="form-label">
                                        Stok Produk
                                    </label>
                                    <input type="text" name="stok" id="stok_{{ $item->id }}"
                                        value="{{ $item->stok }}" class="form-control">
                                </div>
                                {{-- DESKRIPSI --}}
                                <div class="col-md-6 mb-3">
                                    <label for="deskripsi_{{ $item->id }}" class="form-label">
                                        Deskripsi Produk
                                    </label>
                                    <input type="text" name="deskripsi" id="deskripsi_{{ $item->id }}"
                                        value="{{ $item->deskripsi }}" class="form-control">
                                </div>
                                {{-- STATUS --}}
                                <div class="col-md-6 mb-3">
                                    <label for="status_{{ $item->id }}" class="form-label">
                                        Status Produk
                                    </label>
                                    <select name="status" id="status_{{ $item->id }}" class="form-select">
                                        <option value="">
                                            -- Pilih Status --
                                        </option>
                                        <option value="1" {{ $item->status == 1 ? 'selected' : '' }}>
                                            Active
                                        </option>
                                        <option value="0" {{ $item->status == 0 ? 'selected' : '' }}>
                                            Off
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        {{-- FOOTER --}}
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
    {{-- URL UNTUK DATATABLE --}}
    <script>
        const addProdukUrl = "{{ route('detail.add') }}";
        const pageType = "produk";
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

    {{-- delete confirmation --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            document.querySelectorAll('.delete-form').forEach(function(form) {

                form.addEventListener('submit', function(event) {

                    event.preventDefault();

                    Swal.fire({
                        title: 'Apakah kamu yakin?',
                        text: 'Data Produk akan dihapus!',
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
