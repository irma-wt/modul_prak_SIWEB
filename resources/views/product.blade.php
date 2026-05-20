{{-- code untuk file product.blade.php --}}
@extends('layouts.main')
@include('modal.wishlist')
@include('modal.createProduct')
@include('modal.updateProduct')

@section('content')
    <div class="container mt-5">
        <div class="d-flex justify-content-between mb-3 align-items-center">
            <h3 class="mb-4">Daftar Sepatu</h3>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahProdukModal">
                Tambah Produk
            </button>
        </div>
        <div class="row" id="container-barang">
            @foreach ($products as $item)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body d-flex flex-column">
                            <img src="{{ asset('storage/' . $item->product_image) }}" class="card-img-top" 
                            alt="{{ $item->product_name }}" style="height: 250px; object-fit: cover;" />
                            <h5 class="card-title">{{ $item->product_name }}</h5>

                            <p class="card-text harga-text text-danger mb-1">
                                Harga: Rp {{ number_format($item->product_price, 0, ',', '.') }}
                            </p>

                            <p class="card-text stok-text mb-3">Stok: {{ $item->product_stock }}</p>

                            <div class="d-flex gap-2 mt-auto">
                                <button class="btn btn-primary btn-sm w-100" data-bs-toggle="modal"
                                    data-bs-target="#editProdukModal{{ $item->product_id }}">Update</button>

                                <form action="{{ route('products.destroy', $item->product_id) }}" method="POST" 
                                    class="w-100 m-0"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini {{ $item->product_id }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm w-100">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection