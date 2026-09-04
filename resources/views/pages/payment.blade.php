@extends('layouts.app')
@section('title', 'Payment')
@section('content')
    <div class="page-header mb-4">
        <h1 class="page-title">Page Payment Details</h1>
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
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#modalPayment{{ $item->id }}">
                                        Show
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    {{-- MODAL DETAIL PAYMENT --}}
    @if (!$data->isEmpty())
        @foreach ($data as $item)
            <div class="modal fade" id="modalPayment{{ $item->id }}" tabindex="-1"
                aria-labelledby="modalPaymentLabel{{ $item->id }}" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        {{-- HEADER --}}
                        <div class="modal-header">
                            <div>
                                <h5 class="modal-title mb-1" id="modalPaymentLabel{{ $item->id }}">Detail Payment</h5>
                                <small class="text-muted">{{ $item->nomor }}</small>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        {{-- BODY --}}
                        <div class="modal-body">
                            {{-- INFORMASI TRANSAKSI --}}
                            <div class="card mb-4">
                                <div class="card-header">
                                    <strong>Informasi Transaksi</strong>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label text-muted">Nomor Transaksi</label>
                                            <input type="text" class="form-control" value="{{ $item->nomor }}"
                                                readonly>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label text-muted">Tanggal</label>
                                            <input type="text" class="form-control" value="{{ $item->tanggal }}"
                                                readonly>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label text-muted">Pelanggan</label>
                                            <input type="text" class="form-control"
                                                value="{{ $item->nama_pelanggan ?? '-' }}" readonly>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label text-muted">Status</label>
                                            <div class="form-control bg-white">
                                                @if ($item->status == 'Lunas')
                                                    <span class="badge bg-success">Lunas</span>
                                                @elseif ($item->status == 'Pending')
                                                    <span class="badge bg-warning text-dark">Pending</span>
                                                @elseif ($item->status == 'Batal')
                                                    <span class="badge bg-danger">Batal</span>
                                                @else
                                                    <span class="badge bg-secondary">{{ $item->status }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label text-muted">Keterangan</label>
                                            <textarea class="form-control" rows="2" readonly>{{ $item->keterangan ?? '-' }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- DETAIL PRODUK --}}
                            <div class="card mb-4">
                                <div class="card-header">
                                    <strong>Detail Produk</strong>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover mb-0">
                                            <thead>
                                                <tr>
                                                    <th width="50">No</th>
                                                    <th>Produk</th>
                                                    <th width="100" class="text-center">Qty</th>
                                                    <th width="160" class="text-end">Harga</th>
                                                    <th width="180" class="text-end">Subtotal</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($item->transaksi_detail as $detail)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>
                                                            @if ($detail->produk)
                                                                <strong>{{ $detail->produk->nama }}</strong>
                                                                @if (!empty($detail->produk->kode))
                                                                    <br>
                                                                    <small
                                                                        class="text-muted">{{ $detail->produk->kode }}</small>
                                                                @endif
                                                            @else
                                                                <span class="text-muted">Produk tidak ditemukan</span>
                                                            @endif
                                                        </td>
                                                        <td class="text-center">{{ $detail->qty }}</td>
                                                        <td class="text-end">Rp
                                                            {{ number_format($detail->harga, 0, ',', '.') }}</td>
                                                        <td class="text-end"><strong>Rp
                                                                {{ number_format($detail->subtotal, 0, ',', '.') }}</strong>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="5" class="text-center text-muted py-4">Tidak ada
                                                            detail produk.</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            {{-- RINGKASAN PEMBAYARAN --}}
                            <div class="card">
                                <div class="card-header">
                                    <strong>Ringkasan Pembayaran</strong>
                                </div>
                                <div class="card-body">
                                    <div class="row justify-content-end">
                                        <div class="col-md-7">
                                            <div class="d-flex justify-content-between mb-2">
                                                <span>Subtotal</span>
                                                <strong>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</strong>
                                            </div>
                                            <div class="d-flex justify-content-between mb-2">
                                                <span>Diskon</span>
                                                <strong>Rp {{ number_format($item->diskon ?? 0, 0, ',', '.') }}</strong>
                                            </div>
                                            <hr>
                                            <div class="d-flex justify-content-between mb-3">
                                                <span class="fs-5">Total</span>
                                                <strong class="fs-5">Rp
                                                    {{ number_format($item->total, 0, ',', '.') }}</strong>
                                            </div>
                                            <div class="d-flex justify-content-between mb-2">
                                                <span>Bayar</span>
                                                <strong>Rp {{ number_format($item->bayar, 0, ',', '.') }}</strong>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <span>Kembalian</span>
                                                <strong class="text-success">Rp
                                                    {{ number_format($item->kembalian, 0, ',', '.') }}</strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- FOOTER --}}
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="fas fa-times"></i>
                                Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
@endsection
