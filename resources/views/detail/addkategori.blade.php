@extends('layouts.app')

@section('title', 'Add Categories')

@section('content')

    <div class="page-header mb-4">
        <h1 class="page-title">Halaman Add Kategori</h1>
    </div>

    <div class="container">
        <section class="form">
            <form action="{{ route('kategori.store') }}" method="POST">
                @csrf
                <div class="row">
                    {{-- Nama --}}
                    <div class="col-md-6 mb-3">
                        <label for="nama" class="form-label">
                            Nama Kategori
                        </label>
                        <input type="text" name="nama" id="nama" value="{{ old('nama') }}"
                            placeholder="Nama Kategori...." class="form-control @error('nama') is-invalid @enderror">
                        @error('nama')
                            <div class="invalid-feedback">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    {{-- Keterangan --}}
                    <div class="col-md-6 mb-3">
                        <label for="keterangan" class="form-label">
                            Keterangan
                        </label>
                        <input type="text" name="keterangan" id="keterangan" value="{{ old('keterangan') }}"
                            placeholder="Keterangan Kategori...."
                            class="form-control @error('keterangan') is-invalid @enderror">
                        @error('keterangan')
                            <div class="invalid-feedback">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                {{-- Button --}}
                <div class="mt-3">
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-plus"></i>
                        Add Data
                    </button>
                    <button type="reset" class="btn btn-warning">
                        <i class="fas fa-undo"></i>
                        Reset
                    </button>
                    <a href="{{ route('pages.kategori') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i>
                        Back
                    </a>
                </div>
            </form>
        </section>
    </div>
@endsection
