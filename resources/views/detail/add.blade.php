@extends('layouts.app')
@section('title', 'Add Products')
@section('content')
    <div class="page-header mb-4">
        <h1 class="page-title">Halaman add produk</h1>
    </div>
    <div class="container">
        <section class="form">
            <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    {{-- KATEGORI --}}
                    <div class="col">
                        <label for="kategori_id" class="form-label">
                            Kategori Produk
                        </label>
                        <select name="kategori_id" id="kategori_id"
                            class="form-select @error('kategori_id') is-invalid @enderror">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach ($data as $item)
                                <option value="{{ $item->id }}" {{ old('kategori_id') == $item->id ? 'selected' : '' }}>
                                    {{ $item->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('kategori_id')
                            <div class="invalid-feedback">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    {{-- KODE --}}
                    <div class="col">
                        <label for="kode" class="form-label">
                            Kode Produk
                        </label>
                        <input type="text" name="kode" id="kode" value="{{ old('kode') }}"
                            class="form-control @error('kode') is-invalid @enderror">
                        @error('kode')
                            <div class="invalid-feedback">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    {{-- NAMA --}}
                    <div class="col mb-2">
                        <label for="nama" class="form-label">
                            Nama Produk
                        </label>
                        <input type="text" name="nama" id="nama" value="{{ old('nama') }}"
                            class="form-control @error('nama') is-invalid @enderror">
                        @error('nama')
                            <div class="invalid-feedback">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    {{-- GAMBAR --}}
                    <div class="mb-3">
                        <label for="gambar" class="form-label">
                            Gambar Produk
                        </label>
                        <input type="file" name="gambar" id="gambar" accept="image/*"
                            class="form-control @error('gambar') is-invalid @enderror">
                        @error('gambar')
                            <div class="invalid-feedback">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                        <div class="mt-3">
                            <img id="preview" src="" alt="Preview" class="img-thumbnail d-none"
                                style="width: 150px; height: 150px; object-fit: cover;">
                        </div>
                    </div>
                    {{-- HARGA --}}
                    <div class="col mb-2">
                        <label for="harga" class="form-label">
                            Harga Produk
                        </label>
                        <input type="text" name="harga" id="harga" value="{{ old('harga') }}"
                            class="form-control @error('harga') is-invalid @enderror">
                        @error('harga')
                            <div class="invalid-feedback">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    {{-- STOK --}}
                    <div class="col mb-2">
                        <label for="stok" class="form-label">
                            Stok Produk
                        </label>
                        <input type="text" name="stok" id="stok" value="{{ old('stok') }}"
                            class="form-control @error('stok') is-invalid @enderror">
                        @error('stok')
                            <div class="invalid-feedback">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    {{-- DESKRIPSI --}}
                    <div class="col mb-2">
                        <label for="deskripsi" class="form-label">
                            Deskripsi Produk
                        </label>
                        <input type="text" name="deskripsi" id="deskripsi" value="{{ old('deskripsi') }}"
                            class="form-control @error('deskripsi') is-invalid @enderror">
                        @error('deskripsi')
                            <div class="invalid-feedback">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    {{-- STATUS --}}
                    <div class="col mb-2">
                        <label for="status" class="form-label">
                            Status Produk
                        </label>
                        <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
                            <option value="">-- Pilih Status --</option>
                            <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>
                                Active
                            </option>
                            <option value="2" {{ old('status') == '2' ? 'selected' : '' }}>
                                Off
                            </option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                {{-- BUTTON --}}
                <div class="btn">
                    <button class="btn btn-primary" type="submit">
                        Add Data
                    </button>
                    <button type="reset" class="btn btn-warning">
                        Reset
                    </button>
                    <a href="{{ route('pages.produk') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i>
                        Back
                    </a>
                </div>
            </form>
        </section>
    </div>
@endsection
