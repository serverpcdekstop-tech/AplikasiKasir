$(document).ready(function () {

    $('#myTable').DataTable({

        layout: {
            topStart: {
                buttons: [
                    ...(pageType === 'produk'
                        ? [{
                            text: 'Add Produk',
                            className: 'btn btn-primary dt-btn-add',
                            action: function () {
                                window.location.href = addProdukUrl;
                            }
                        }]
                        : [{
                            text: 'Add Kategori',
                            className: 'btn btn-primary dt-btn-add',
                            action: function () {
                                window.location.href = addcategoriesUrl;
                            }
                        }]
                    ),

                    {
                        extend: 'copy',
                        text: 'Copy',
                        className: 'btn btn-light dt-btn'
                    },
                    {
                        extend: 'csv',
                        text: 'CSV',
                        className: 'btn btn-light dt-btn'
                    },
                    {
                        extend: 'excel',
                        text: 'Excel',
                        className: 'btn btn-light dt-btn'
                    },
                    {
                        extend: 'print',
                        text: 'Print',
                        className: 'btn btn-light dt-btn'
                    }
                ]
            },

            topEnd: {
                search: {
                    placeholder: 'Cari data...'
                }
            },

            bottomStart: {
                info: true
            },

            bottomEnd: {
                paging: true
            }
        },

        language: {
            info: 'Menampilkan _START_ - _END_ dari _TOTAL_ data',
            infoEmpty: 'Tidak ada data',
            zeroRecords: 'Data tidak ditemukan',
            emptyTable: 'Tidak ada data',

            paginate: {
                first: '«',
                previous: '‹',
                next: '›',
                last: '»'
            }
        },

        pageLength: 10,

        responsive: true,

        ordering: true,

        columnDefs: [
            {
                targets: [0],
                className: 'text-center'
            },
            {
                targets: [2],
                className: 'text-center'
            }
        ]

    });

});




// file preview

document.getElementById('gambar').addEventListener('change', function (event) {

    const file = event.target.files[0];
    const preview = document.getElementById('preview');

    if (file) {
        preview.src = URL.createObjectURL(file);
        preview.classList.remove('d-none');
    } else {
        preview.src = '';
        preview.classList.add('d-none');
    }

});
// ================================
// PREVIEW GAMBAR PRODUK
// ================================

document.addEventListener('DOMContentLoaded', function () {

    // ================================
    // ADD PRODUK
    // ================================

    const gambar = document.getElementById('gambar');
    const preview = document.getElementById('preview');

    if (gambar && preview) {

        gambar.addEventListener('change', function (event) {

            const file = event.target.files[0];

            if (!file) {
                preview.src = '';
                preview.classList.add('d-none');
                return;
            }

            if (!file.type.startsWith('image/')) {
                alert('File yang dipilih harus berupa gambar.');

                gambar.value = '';
                preview.src = '';
                preview.classList.add('d-none');

                return;
            }

            preview.src = URL.createObjectURL(file);
            preview.classList.remove('d-none');

        });

    }


    // edit produk

    function previewGambar(input, previewId) {

        const file = input.files[0];
        const preview = document.getElementById(previewId);

        if (!file || !preview) {
            return;
        }

        // Cek file harus gambar
        if (!file.type.startsWith('image/')) {

            alert('File yang dipilih harus berupa gambar.');

            input.value = '';

            return;
        }

        // Buat preview gambar baru
        const reader = new FileReader();

        reader.onload = function (event) {

            preview.src = event.target.result;

            preview.classList.remove('d-none');

        };

        reader.readAsDataURL(file);
    }
});



// card ordewr
document.addEventListener('DOMContentLoaded', function () {

    let cart = {};

    const cartContainer = document.getElementById('cartContainer');
    const cartEmpty = document.getElementById('cartEmpty');
    const cartSummary = document.getElementById('cartSummary');

    const jumlahItem = document.getElementById('jumlahItem');
    const subtotalElement = document.getElementById('subtotal');
    const pajakElement = document.getElementById('pajak');
    const totalElement = document.getElementById('total');


    // =========================
    // FORMAT RUPIAH
    // =========================

    function rupiah(angka) {

        return 'Rp ' + new Intl.NumberFormat('id-ID').format(angka);

    }


    // =========================
    // TAMBAH PRODUK
    // =========================

    document.querySelectorAll('.btn-tambah-produk')
        .forEach(function (button) {

            button.addEventListener('click', function () {

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

                        alert('Stok produk tidak mencukupi.');

                    }

                } else {

                    cart[id] = produk;

                }

                renderCart();

            });

        });


    // =========================
    // TAMPILKAN CART
    // =========================

    function renderCart() {

        cartContainer.innerHTML = '';

        const items = Object.values(cart);


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


        cartSummary.style.display = 'block';


        let subtotal = 0;
        let totalQty = 0;


        items.forEach(function (item) {

            const totalItem = item.harga * item.qty;

            subtotal += totalItem;

            totalQty += item.qty;


            const div = document.createElement('div');

            div.className = 'cart-item';


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
                                    -
                                </button>

                                <span class="quantity-number">
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

        jumlahItem.textContent = totalQty;
        // =========================
        // PAJAK
        // =========================

        const pajak = subtotal * 0.10;

        const total = subtotal + pajak;


        subtotalElement.textContent = rupiah(subtotal);

        pajakElement.textContent = rupiah(pajak);

        totalElement.textContent = rupiah(total);


        // =========================
        // TOMBOL +
        // =========================

        document.querySelectorAll('.btn-plus')
            .forEach(function (button) {

                button.addEventListener('click', function () {

                    const id = this.dataset.id;

                    if (cart[id].qty < cart[id].stok) {

                        cart[id].qty++;

                        renderCart();

                    } else {

                        alert('Stok produk tidak mencukupi.');

                    }

                });

            });


        // =========================
        // TOMBOL -
        // =========================

        document.querySelectorAll('.btn-minus')
            .forEach(function (button) {

                button.addEventListener('click', function () {

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

        document.querySelectorAll('.btn-hapus')
            .forEach(function (button) {

                button.addEventListener('click', function () {

                    const id = this.dataset.id;

                    delete cart[id];

                    renderCart();

                });

            });
    }
    // =========================
    // SEARCH PRODUK
    // =========================
    document.getElementById('searchProduk')
        .addEventListener('input', function () {
            const keyword = this.value.toLowerCase();
            document.querySelectorAll('.produk-item')
                .forEach(function (item) {
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
    // =========================
    // BAYAR
    // =========================
    document.getElementById('btnBayar')
        .addEventListener('click', function () {
            if (Object.keys(cart).length === 0) {
                alert('Keranjang masih kosong.');
                return;
            }
            console.log(cart);
            alert('Lanjut ke pembayaran.');
        });
});