<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu - Break Coffee</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="customer.css">
</head>
<body>
    <div class="bg-pattern"></div>
    <div class="menu-screen">
        {{-- HEADER --}}
        <header class="header">
            {{-- BRAND --}}
            <div class="brand">
                <div class="brand-left">
                    <div class="logo">☕</div>
                    <div>
                        <div class="brand-name">
                            Break Coffee
                        </div>
                        <div class="brand-subtitle">
                            Fresh Coffee • Good Mood
                        </div>
                    </div>
                </div>
                {{-- CLOCK --}}
                <div id="clock">
                    <i class="far fa-clock"></i>
                    <span id="clock-text">
                        00:00:00
                    </span>
                </div>
            </div>
            {{-- MENU TITLE --}}
            <div class="menu-title">

                <div class="subtitle-top">
                    ✦ Premium Selection
                </div>

                <h1>
                    Menu <span>Kami</span>
                </h1>

                <p>
                    Pilih menu favoritmu hari ini
                </p>

            </div>
            {{-- CATEGORY --}}
            <div class="categories">

                <button type="button" class="category-btn active" data-category="all">

                    <i class="fas fa-th-large"></i>
                    Semua
                </button>

                @foreach ($kategori as $kat)
                    <button type="button" class="category-btn" data-category="{{ $kat->id }}">

                        <i class="fas fa-tag"></i>

                        {{ $kat->nama }}

                    </button>
                @endforeach

            </div>

        </header>


        {{-- MENU --}}
        <main class="menu-container">

            <div class="menu-grid">

                @forelse ($data as $item)
                    <div class="product-card" data-category="{{ $item->kategori_id }}">

                        {{-- IMAGE --}}
                        <div class="product-image">
                            @if ($item->gambar)
                                <img src="{{ asset('storage/gambar/' . $item->gambar) }}" alt="{{ $item->nama }}">
                            @else
                                <div class="no-image">
                                    <i class="bi bi-image"></i>
                                    <span>No Image</span>
                                </div>
                            @endif
                            {{-- CATEGORY --}}
                            @if ($item->kategori)
                                <div class="category-badge">
                                    {{ $item->kategori->nama }}
                                </div>
                            @endif
                        </div>

                        {{-- PRODUCT BODY --}}
                        <div class="product-body">
                            <div class="product-name">
                                {{ $item->nama }}
                            </div>


                            <div class="product-description">

                                {{ $item->deskripsi ?? 'Menu pilihan terbaik dari Break Coffee.' }}

                            </div>


                            {{-- BOTTOM --}}
                            <div class="product-bottom">

                                <div class="product-price">

                                    <span class="currency">
                                        Rp
                                    </span>

                                    {{ number_format($item->harga, 0, ',', '.') }}

                                </div>


                                <div class="available">

                                    <i class="fas fa-check-circle"></i>

                                    Tersedia

                                </div>

                            </div>

                        </div>

                    </div>

                @empty

                    <div class="empty-state">

                        <div class="icon">
                            ☕
                        </div>

                        <h4>
                            Menu belum tersedia
                        </h4>

                        <p>
                            Silakan tambahkan produk terlebih dahulu.
                        </p>

                    </div>
                @endforelse

            </div>

        </main>


        {{-- FOOTER --}}
        <footer class="footer">

            © {{ date('Y') }}

            <span>
                Break Coffee
            </span>

            · Selamat menikmati

        </footer>

    </div>


    {{-- JAVASCRIPT --}}
    <script>
        /*
                                |--------------------------------------------------------------------------
                                | FILTER KATEGORI
                                |--------------------------------------------------------------------------
                                */

        const categoryButtons =
            document.querySelectorAll('.category-btn');

        const products =
            document.querySelectorAll('.product-card');


        categoryButtons.forEach(button => {

            button.addEventListener('click', function() {

                categoryButtons.forEach(item => {

                    item.classList.remove('active');

                });


                this.classList.add('active');


                const selectedCategory =
                    this.dataset.category;


                products.forEach(product => {

                    const productCategory =
                        product.dataset.category;


                    if (
                        selectedCategory === 'all' ||
                        productCategory === selectedCategory
                    ) {

                        product.style.display = '';

                        product.style.animation =
                            'none';

                        product.offsetHeight;

                        product.style.animation =
                            'productAppear 0.4s ease both';

                    } else {

                        product.style.display =
                            'none';

                    }

                });

            });

        });


        /*
        |--------------------------------------------------------------------------
        | JAM REAL-TIME
        |--------------------------------------------------------------------------
        */

        function updateClock() {

            const now = new Date();

            const clock =
                document.getElementById('clock-text');


            clock.textContent =
                now.toLocaleTimeString('id-ID', {

                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit'

                });

        }


        updateClock();

        setInterval(updateClock, 1000);
    </script>

</body>

</html>
