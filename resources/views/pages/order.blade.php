@extends('layouts.app')
@section('title', 'Order')
@section('content')
    {{-- <div class="page-header mb-4">
        <h1 class="page-title">Order</h1>
    </div> --}}
    <div class="row g-4">
        {{-- BAGIAN PRODUK --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                <div class="card-body">
                    {{-- Header Produk --}}
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h4 class="fw-bold mb-1">Daftar Produk</h4>
                            <small class="text-muted">Pilih produk untuk ditambahkan ke pesanan</small>
                        </div>
                        {{-- Search --}}
                        <div style="width: 250px;">
                            <input type="text" id="searchProduk" class="form-control" placeholder="Cari produk...">
                        </div>
                    </div>

                    {{-- CARD PRODUK --}}
                    <div class="row g-3" id="produkContainer">
                        @forelse ($produk as $item)
                            <div class="col-xl-4 col-md-6 produk-item" data-nama="{{ strtolower($item->nama) }}"
                                data-kode="{{ strtolower($item->kode) }}">
                                <div class="card product-card h-100 border" style="border-radius: 14px; overflow: hidden;">
                                    {{-- Gambar --}}
                                    <div class="product-image">
                                        @if ($item->gambar)
                                            <img src="{{ asset('storage/gambar/' . $item->gambar) }}"
                                                alt="{{ $item->nama }}">
                                        @else
                                            <div class="no-image">
                                                <i class="bi bi-image"></i>
                                                <span>No Image</span>
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Detail --}}
                                    <div class="card-body">
                                        <small class="text-muted">{{ $item->kode }}</small>
                                        <h5 class="fw-bold mt-1 mb-2">{{ $item->nama }}</h5>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="text-primary fw-bold">
                                                Rp {{ number_format($item->harga, 0, ',', '.') }}
                                            </span>
                                            <small class="text-muted">Stok {{ $item->stok }}</small>
                                        </div>
                                    </div>

                                    {{-- Tombol --}}
                                    <div class="card-footer bg-white border-0 p-3">
                                        @if ($item->status == 1 && $item->stok > 0)
                                            <button type="button" class="btn btn-primary w-100 btn-tambah-produk"
                                                data-id="{{ $item->id }}" data-kode="{{ $item->kode }}"
                                                data-nama="{{ $item->nama }}" data-harga="{{ $item->harga }}"
                                                data-stok="{{ $item->stok }}" data-status="{{ $item->status }}">
                                                <i class="bi bi-cart-plus me-1"></i>
                                                Tambah
                                            </button>
                                        @else
                                            <button type="button" class="btn btn-secondary w-100" disabled>
                                                <i class="bi bi-x-circle me-1"></i>
                                                @if ($item->stok <= 0)
                                                    Stok Habis
                                                @else
                                                    Tidak Aktif
                                                @endif
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="text-center py-5">
                                    <i class="bi bi-box-seam fs-1 text-muted"></i>
                                    <h5 class="mt-3 text-muted">Belum ada produk</h5>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        {{-- KERANJANG --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                <div class="card-body">
                    {{-- Header --}}
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h4 class="fw-bold mb-1">Pesanan</h4>
                            <small class="text-muted">Daftar produk yang dipilih</small>
                        </div>
                        <span class="badge bg-primary" id="jumlahItem">0</span>
                    </div>

                    {{-- Keranjang --}}
                    <div id="cartContainer">
                        <div class="text-center py-5" id="cartEmpty">
                            <i class="bi bi-cart3 fs-1 text-muted"></i>
                            <h6 class="mt-3 text-muted">Keranjang masih kosong</h6>
                            <small class="text-muted">Klik tombol Tambah pada produk</small>
                        </div>
                    </div>

                    {{-- TOTAL --}}
                    <div id="cartSummary" style="display: none;">
                        <hr>

                        {{-- Subtotal --}}
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Subtotal</span>
                            <span id="subtotal" class="fw-semibold">Rp 0</span>
                        </div>

                        <hr>

                        {{-- Total --}}
                        <div class="d-flex justify-content-between mb-3">
                            <span class="fw-bold fs-5">Total</span>
                            <span id="total" class="fw-bold fs-5 text-primary">Rp 0</span>
                        </div>

                        {{-- Bayar --}}
                        <button type="button" class="btn btn-primary w-100 py-2" id="btnBayar">
                            <i class="bi bi-credit-card me-1"></i>
                            Bayar Sekarang
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- JAVASCRIPT --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            let cart = {};

            // =========================
            // ELEMENT
            // =========================

            const cartContainer = document.getElementById('cartContainer');
            const cartSummary = document.getElementById('cartSummary');
            const jumlahItem = document.getElementById('jumlahItem');
            const subtotalElement = document.getElementById('subtotal');
            const totalElement = document.getElementById('total');
            const searchProduk = document.getElementById('searchProduk');
            const btnBayar = document.getElementById('btnBayar');


            // =========================
            // FORMAT RUPIAH
            // =========================

            function rupiah(angka) {
                return 'Rp ' + new Intl.NumberFormat('id-ID').format(angka);
            }


            // =========================
            // TAMBAH PRODUK
            // =========================

            document.querySelectorAll('.btn-tambah-produk').forEach(function(button) {

                button.addEventListener('click', function() {

                    const id = this.dataset.id;

                    const produk = {
                        id: id,
                        kode: this.dataset.kode,
                        nama: this.dataset.nama,
                        harga: parseInt(this.dataset.harga),
                        stok: parseInt(this.dataset.stok),
                        qty: 1
                    };


                    if (cart[id]) {

                        if (cart[id].qty < cart[id].stok) {

                            cart[id].qty++;

                        } else {

                            Swal.fire({
                                icon: 'warning',
                                title: 'Stok Tidak Cukup',
                                text: `${cart[id].nama} hanya tersedia ${cart[id].stok} stok.`,
                                confirmButtonText: 'OK',
                                confirmButtonColor: '#0d6efd'
                            });

                            return;
                        }

                    } else {

                        cart[id] = produk;

                    }

                    renderCart();

                });

            });


            // =========================
            // RENDER CART
            // =========================

            function renderCart() {

                cartContainer.innerHTML = '';

                const items = Object.values(cart);


                // =========================
                // CART KOSONG
                // =========================

                if (items.length === 0) {

                    cartContainer.innerHTML = `
                    <div class="text-center py-5">

                        <i class="bi bi-cart3 fs-1 text-muted"></i>

                        <h6 class="mt-3 text-muted">
                            Keranjang masih kosong
                        </h6>

                        <small class="text-muted">
                            Klik tombol Tambah pada produk
                        </small>

                    </div>
                `;

                    cartSummary.style.display = 'none';

                    jumlahItem.textContent = '0';

                    return;
                }


                // =========================
                // TAMPILKAN SUMMARY
                // =========================

                cartSummary.style.display = 'block';


                let subtotal = 0;
                let totalQty = 0;


                // =========================
                // ITEM CART
                // =========================

                items.forEach(function(item) {

                    const totalItem = item.harga * item.qty;

                    subtotal += totalItem;
                    totalQty += item.qty;


                    const div = document.createElement('div');

                    div.className = 'cart-item mb-3 pb-3 border-bottom';


                    div.innerHTML = `

                    <div class="d-flex justify-content-between">

                        <div style="min-width: 0;">

                            <div class="fw-semibold text-truncate">
                                ${item.nama}
                            </div>

                            <small class="text-muted">
                                ${rupiah(item.harga)}
                            </small>

                        </div>


                        <button type="button"
                            class="btn btn-sm text-danger btn-hapus"
                            data-id="${item.id}">

                            <i class="bi bi-trash"></i>

                        </button>

                    </div>


                    <div class="d-flex justify-content-between align-items-center mt-2">

                        <div class="quantity-control">

                            <button type="button"
                                class="btn-minus"
                                data-id="${item.id}">
                                −
                            </button>


                            <span class="quantity-number mx-2">
                                ${item.qty}
                            </span>


                            <button type="button"
                                class="btn-plus"
                                data-id="${item.id}">
                                +
                            </button>

                        </div>


                        <span class="fw-bold">
                            ${rupiah(totalItem)}
                        </span>

                    </div>

                `;


                    cartContainer.appendChild(div);

                });


                // =========================
                // TOTAL
                // =========================

                jumlahItem.textContent = totalQty;

                const total = subtotal;

                subtotalElement.textContent = rupiah(subtotal);

                totalElement.textContent = rupiah(total);


                // =========================
                // TOMBOL +
                // =========================

                document.querySelectorAll('.btn-plus').forEach(function(button) {

                    button.addEventListener('click', function() {

                        const id = this.dataset.id;


                        if (cart[id].qty < cart[id].stok) {

                            cart[id].qty++;

                            renderCart();

                        } else {

                            Swal.fire({
                                icon: 'warning',
                                title: 'Stok Tidak Cukup',
                                text: `${cart[id].nama} hanya tersedia ${cart[id].stok} stok.`,
                                confirmButtonText: 'OK',
                                confirmButtonColor: '#0d6efd'
                            });

                        }

                    });

                });


                // =========================
                // TOMBOL -
                // =========================

                document.querySelectorAll('.btn-minus').forEach(function(button) {

                    button.addEventListener('click', function() {

                        const id = this.dataset.id;

                        cart[id].qty--;


                        if (cart[id].qty <= 0) {

                            delete cart[id];

                        }


                        renderCart();

                    });

                });


                // =========================
                // HAPUS
                // =========================

                document.querySelectorAll('.btn-hapus').forEach(function(button) {

                    button.addEventListener('click', function() {

                        const id = this.dataset.id;


                        Swal.fire({

                            icon: 'question',

                            title: 'Hapus Produk?',

                            text: `Hapus ${cart[id].nama} dari pesanan?`,

                            showCancelButton: true,

                            confirmButtonText: 'Ya, Hapus',

                            cancelButtonText: 'Batal',

                            confirmButtonColor: '#dc3545',

                            cancelButtonColor: '#6c757d'

                        }).then(function(result) {

                            if (result.isConfirmed) {

                                delete cart[id];

                                renderCart();

                            }

                        });

                    });

                });

            }


            // =========================
            // SEARCH PRODUK
            // =========================

            if (searchProduk) {

                searchProduk.addEventListener('input', function() {

                    const keyword = this.value.toLowerCase();


                    document.querySelectorAll('.produk-item').forEach(function(item) {

                        const nama = item.dataset.nama;
                        const kode = item.dataset.kode;


                        if (
                            nama.includes(keyword) ||
                            kode.includes(keyword)
                        ) {

                            item.style.display = '';

                        } else {

                            item.style.display = 'none';

                        }

                    });

                });

            }


            // =========================
            // BAYAR SEKARANG
            // =========================

            btnBayar.addEventListener('click', function() {

                const items = Object.values(cart);


                // =========================
                // CEK CART
                // =========================

                if (items.length === 0) {

                    Swal.fire({

                        icon: 'warning',

                        title: 'Keranjang Kosong',

                        text: 'Silakan pilih produk terlebih dahulu.',

                        confirmButtonText: 'OK',

                        confirmButtonColor: '#0d6efd'

                    });

                    return;
                }


                // =========================
                // HITUNG TOTAL
                // =========================

                let subtotal = 0;


                items.forEach(function(item) {

                    subtotal += item.harga * item.qty;

                });


                const total = subtotal;


                // =========================
                // MODAL PEMBAYARAN
                // =========================

                Swal.fire({

                    title: 'Pembayaran',

                    html: `

                    <div style="text-align: left;">

                        <div class="d-flex justify-content-between mb-3">

                            <span>
                                Total
                            </span>

                            <strong class="text-primary fs-5">
                                ${rupiah(total)}
                            </strong>

                        </div>


                        <hr>


                        <label class="form-label fw-semibold">
                            Uang Dibayar
                        </label>


                        <input
                            type="number"
                            id="uangDibayar"
                            class="form-control form-control-lg"
                            placeholder="Masukkan uang dibayar"
                            min="${total}"
                        >


                        <div
                            id="infoKembalian"
                            class="mt-3 p-3 rounded"
                            style="display:none;">
                        </div>

                    </div>

                `,

                    showCancelButton: true,

                    confirmButtonText: 'Bayar',

                    cancelButtonText: 'Batal',

                    confirmButtonColor: '#0d6efd',

                    cancelButtonColor: '#6c757d',

                    allowOutsideClick: false,


                    // =========================
                    // MODAL DIBUKA
                    // =========================

                    didOpen: function() {

                        const input =
                            document.getElementById('uangDibayar');

                        const info =
                            document.getElementById('infoKembalian');


                        input.focus();


                        input.addEventListener('input', function() {

                            const dibayar = Number(this.value);


                            if (!dibayar) {

                                info.style.display = 'none';

                                return;
                            }


                            const kembalian =
                                dibayar - total;


                            if (kembalian >= 0) {

                                info.style.display = 'block';

                                info.style.background = '#e8f7ee';

                                info.style.color = '#198754';


                                info.innerHTML = `

                                <div class="d-flex justify-content-between">

                                    <span>
                                        Kembalian
                                    </span>

                                    <strong>
                                        ${rupiah(kembalian)}
                                    </strong>

                                </div>

                            `;

                            } else {

                                info.style.display = 'block';

                                info.style.background = '#fff1f1';

                                info.style.color = '#dc3545';


                                info.innerHTML = `

                                <div>
                                    Uang masih kurang
                                </div>

                                <strong>
                                    ${rupiah(Math.abs(kembalian))}
                                </strong>

                            `;

                            }

                        });

                    },


                    // =========================
                    // VALIDASI BAYAR
                    // =========================

                    preConfirm: function() {

                        const input =
                            document.getElementById('uangDibayar');

                        const dibayar =
                            Number(input.value);


                        if (!input.value) {

                            Swal.showValidationMessage(
                                'Masukkan jumlah uang yang dibayar.'
                            );

                            return false;
                        }


                        if (dibayar < total) {

                            Swal.showValidationMessage(
                                `Uang dibayar kurang ${rupiah(total - dibayar)}.`
                            );

                            return false;
                        }


                        return {

                            dibayar: dibayar,

                            kembalian: dibayar - total

                        };

                    }

                }).then(function(result) {


                    // =========================
                    // KONFIRMASI PEMBAYARAN
                    // =========================

                    if (!result.isConfirmed) {
                        return;
                    }


                    const dibayar =
                        result.value.dibayar;

                    const kembalian =
                        result.value.kembalian;


                    // =========================
                    // SIMPAN KE DATABASE
                    // =========================

                    fetch("{{ route('transaksi.store') }}", {

                            method: 'POST',

                            headers: {

                                'Content-Type': 'application/json',

                                'Accept': 'application/json',

                                'X-CSRF-TOKEN': document
                                    .querySelector(
                                        'meta[name="csrf-token"]'
                                    )
                                    .getAttribute('content')

                            },


                            body: JSON.stringify({
                                items: items.map(function(item) {
                                    return {
                                        id: item.id,
                                        qty: item.qty
                                    };
                                }),
                                bayar: dibayar
                            })

                        })


                        // =========================
                        // RESPONSE
                        // =========================

                        .then(function(response) {

                            return response.json();

                        })


                        .then(function(data) {


                            // =========================
                            // GAGAL
                            // =========================

                            if (!data.success) {

                                Swal.fire({

                                    icon: 'error',

                                    title: 'Transaksi Gagal',

                                    text: data.message,

                                    confirmButtonText: 'OK',

                                    confirmButtonColor: '#dc3545'

                                });

                                return;
                            }


                            // =========================
                            // BERHASIL
                            // =========================

                            Swal.fire({

                                icon: 'success',

                                title: 'Pembayaran Berhasil!',

                                html: `

                            <div class="text-start">

                                <div class="d-flex justify-content-between mb-2">

                                    <span>
                                        Nomor Transaksi
                                    </span>

                                    <strong>
                                        ${data.nomor}
                                    </strong>

                                </div>


                                <div class="d-flex justify-content-between mb-2">

                                    <span>
                                        Total
                                    </span>

                                    <strong>
                                        ${rupiah(total)}
                                    </strong>

                                </div>


                                <div class="d-flex justify-content-between mb-2">

                                    <span>
                                        Dibayar
                                    </span>

                                    <strong>
                                        ${rupiah(dibayar)}
                                    </strong>

                                </div>


                                <hr>


                                <div class="d-flex justify-content-between">

                                    <span class="fw-bold">
                                        Kembalian
                                    </span>

                                    <strong class="text-success">
                                        ${rupiah(kembalian)}
                                    </strong>

                                </div>

                            </div>

                        `,

                                confirmButtonText: 'Selesai',

                                confirmButtonColor: '#0d6efd',

                                allowOutsideClick: false

                            }).then(function() {


                                // =========================
                                // KOSONGKAN CART
                                // =========================

                                cart = {};

                                renderCart();


                                // =========================
                                // REFRESH PRODUK
                                // =========================

                                location.reload();

                            });

                        })


                        // =========================
                        // ERROR FETCH
                        // =========================

                        .catch(function(error) {

                            console.error(error);


                            Swal.fire({

                                icon: 'error',

                                title: 'Terjadi Kesalahan',

                                text: 'Tidak dapat menyimpan transaksi.',

                                confirmButtonText: 'OK',

                                confirmButtonColor: '#dc3545'

                            });

                        });

                });

            });

        });
    </script>
@endsection
