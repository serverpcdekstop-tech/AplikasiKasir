@extends('layouts.app')

@section('title', 'Payment')

@section('content')
    <div class="page-header mb-4">
        <h1 class="page-title">Halaman Payment</h1>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

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
                        <th>No</th>
                        <th>Nomor Transaksi</th>
                        <th>Pelanggan</th>
                        <th>Tanggal</th>
                        <th>Subtotal</th>
                        <th>Diskon</th>
                        <th>Total</th>
                        <th>Bayar</th>
                        <th>Kembalian</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($data->isEmpty())
                        <tr>
                            <td colspan="12" class="text-center">Belum ada data transaksi.</td>
                        </tr>
                    @else
                        @foreach ($data as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><strong>{{ $item->nomor }}</strong></td>
                                <td>{{ $item->nama_pelanggan ?? '-' }}</td>
                                <td>{{ $item->tanggal }}</td>
                                <td>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($item->diskon ?? 0, 0, ',', '.') }}</td>
                                <td><strong>Rp {{ number_format($item->total, 0, ',', '.') }}</strong></td>
                                <td>Rp {{ number_format($item->bayar, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($item->kembalian, 0, ',', '.') }}</td>
                                <td>
                                    @if ($item->status == 'Lunas')
                                        <span class="badge bg-success">Lunas</span>
                                    @elseif ($item->status == 'Pending')
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @elseif ($item->status == 'Batal')
                                        <span class="badge bg-danger">Batal</span>
                                    @else
                                        <span class="badge bg-secondary">{{ $item->status }}</span>
                                    @endif
                                </td>
                                <td>{{ $item->keterangan ?? '-' }}</td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#modalShow{{ $item->id }}">
                                            Show
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection
