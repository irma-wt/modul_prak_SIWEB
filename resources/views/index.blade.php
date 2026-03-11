<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sistem Manajemen Sepatu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
</head>
<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">CIBADUYUT SHOES</a>

            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <button
                    class="btn btn-outline-warning btn-sm me-2"
                    data-bs-toggle="modal"
                    data-bs-target="#wishlistModal"
                >
                    ⭐ Wishlist (<span id="wishlist-count">0</span>)
                </button>

                <button id="btn-theme" class="btn btn-outline-light btn-sm me-2">
                    Mode Gelap
                </button>

                @if(session()->has('user'))
                    <span class="text-white me-3">
                        {{ session('user') }}
                    </span>
                    <a href="{{ route('logout') }}" class="btn btn-danger btn-sm">
                        Logout
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-warning btn-sm">
                        Login
                    </a>
                @endif
            </div>
        </div>
    </nav>

    <!-- HERO -->
    <div class="hero text-center text-white d-flex align-items-center">
        <div class="container">
            <h1>Sistem Manajemen Sepatu</h1>
            <p>Kelola Data Sepatu Dengan Mudah</p>
        </div>
    </div>

    <!-- DASHBOARD CARDS -->
    <div class="container mt-5">
        <div class="row text-center">
            <div class="col-md-4">
                <div class="card dashboard-card">
                    <div class="card-body">
                        <h5>Total Produk</h5>
                        <h2>3</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card dashboard-card">
                    <div class="card-body">
                        <h5>Stok Tersedia</h5>
                        <h2>27</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card dashboard-card">
                    <div class="card-body">
                        <h5>Kategori</h5>
                        <h2>3</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- DAFTAR SEPATU -->
    <div class="container mt-5">
        <h3 class="mb-4">Daftar Sepatu</h3>
        <div class="row" id="container-barang">

            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <img src="{{ asset('assets/NIKE_P_6000.jpg') }}" class="card-img-top" alt="Sepatu" />
                    <div class="card-body">
                        <h5 class="card-title">Nike P-6000</h5>
                        <p class="card-text harga-text">Harga: Rp 1.429.000</p>
                        <p class="card-text stok-text">Stok: 10</p>
                        <div class="d-flex justify-content-between">
                            <button class="btn btn-primary btn-detail w-50 me-2">Beli</button>
                            <button class="btn btn-outline-danger btn-wishlist w-50">❤ Wishlist</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <img src="assets/AIR_FORCE_1.jpg" class="card-img-top" />
                    <div class="card-body">
                        <h5 class="card-title">Nike Air Force 1</h5>
                        <p class="card-text harga-text">Harga: Rp 1.259.000</p>
                        <p class="card-text stok-text">Stok: 7</p>
                        <div class="d-flex justify-content-between">
                            <button class="btn btn-primary btn-detail w-50 me-2">Beli</button>
                            <button class="btn btn-outline-danger btn-wishlist w-50">❤ Wishlist</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <img src="assets/AIR_JORDAN_1_LOW.jpg" class="card-img-top" />
                    <div class="card-body">
                        <h5 class="card-title">Nike Air Jordan 1 Low</h5>
                        <p class="card-text harga-text">Harga: Rp 1.729.000</p>
                        <p class="card-text stok-text">Stok: 10</p>
                        <div class="d-flex justify-content-between">
                            <button class="btn btn-primary btn-detail w-50 me-2">Beli</button>
                            <button class="btn btn-outline-danger btn-wishlist w-50">❤ Wishlist</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- MODAL WISHLIST -->
    <div class="modal fade" id="wishlistModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">⭐ Daftar Wishlist Saya</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="list-group" id="daftar-wishlist"></ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-danger" onclick="hapusWishlist()">Kosongkan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- FORM TAMBAH SEPATU — hanya tampil kalau sudah login -->
    @if(session()->has('user'))
    <div class="container mt-5 mb-5">
        <h3 class="mb-4">Tambah Sepatu</h3>
        <div class="card p-4">
            <form id="form-tambah">
                <div class="mb-3">
                    <label class="form-label">Nama Sepatu</label>
                    <input type="text" id="input-nama" class="form-control" placeholder="Masukkan nama sepatu" required />
                </div>
                <div class="mb-3">
                    <label class="form-label">Harga</label>
                    <input type="number" id="input-harga" class="form-control" placeholder="Masukkan harga" required />
                </div>
                <div class="mb-3">
                    <label class="form-label">Stok</label>
                    <input type="number" id="input-stok" class="form-control" placeholder="Masukkan Stok" required />
                </div>
                <div class="mb-3">
                    <label class="form-label">Kategori</label>
                    <select id="input-kategori" class="form-select">
                        <option>Running</option>
                        <option>Basket</option>
                        <option>Casual</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-success">Simpan</button>
            </form>
        </div>
    </div>
    @else
    <div class="container mt-5 mb-5 text-center">
        <div class="card p-4">
            <p class="mb-3 text-muted">🔒 Silakan <a href="{{ route('login') }}">login</a> terlebih dahulu untuk menambah produk sepatu.</p>
        </div>
    </div>
    @endif

    <!-- FOOTER -->
    <footer class="bg-dark text-white text-center p-3">
        &copy; 2026 Sistem Manajemen Sepatu Toko Sepatu.
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>