@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <!-- FORM TAMBAH BARANG KE KERANJANG -->
        <div class="col-md-5 mb-4">
            <div class="card shadow-sm border-0" style="background-color: #fff9f9; border-radius: 12px;">
                <div class="card-header bg-white py-3" style="border-top-left-radius: 12px; border-top-right-radius: 12px;">
                    <h5 class="mb-0 font-weight-bold" style="color: #6d6875;">
                        <i class="fas fa-cart-plus mr-2"></i>Pilih Produk Skincare
                    </h5>
                </div>
                <div class="card-body">
                    @if (session('error'))
                        <div class="alert alert-danger" style="border-radius: 8px;">
                            {{ session('error') }}
                        </div>
                    @endif
                    @if (session('success'))
                        <div class="alert alert-success" style="border-radius: 8px;">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('cart.store') }}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label class="font-weight-bold" style="color: #6d6875;">Produk *</label>
                            <select name="product_id" class="form-control" required style="border-radius: 8px;">
                                <option value="">-- Pilih Produk --</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}">
                                        {{ $product->sku ?? '-' }} - {{ $product->name }} (Stok: {{ $product->stock }}) - Rp {{ number_format($product->selling_price, 0, ',', '.') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-4">
                            <label class="font-weight-bold" style="color: #6d6875;">Jumlah (Qty) *</label>
                            <input type="number" name="quantity" class="form-control" value="1" min="1" required style="border-radius: 8px;">
                        </div>

                        <button type="submit" class="btn text-white btn-block" style="background-color: #b5838d; border-radius: 8px;">
                            <i class="fas fa-plus mr-1"></i> Masukkan ke Keranjang
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- DAFTAR KERANJANG BELANJA & TOMBOL CHECKOUT -->
        <div class="col-md-7">
            <div class="card shadow-sm border-0" style="background-color: #fff9f9; border-radius: 12px;">
                <div class="card-header bg-white d-flex justify-content-between align-items-center py-3" style="border-top-left-radius: 12px; border-top-right-radius: 12px;">
                    <h5 class="mb-0 font-weight-bold" style="color: #6d6875;">
                        <i class="fas fa-shopping-bag mr-2"></i>Keranjang Belanja
                    </h5>
                    <a href="{{ route('sales.index') }}" class="btn btn-sm btn-outline-secondary" style="border-radius: 8px;">
                        <i class="fas fa-arrow-left mr-1"></i> Kembali ke Riwayat
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr style="color: #6d6875;">
                                    <th>Produk</th>
                                    <th>Harga</th>
                                    <th class="text-center">Qty</th>
                                    <th>Subtotal</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $grandTotal = 0; @endphp
                                @forelse($carts as $cart)
                                    @php 
                                        $subtotal = $cart->product->selling_price * $cart->quantity; 
                                        $grandTotal += $subtotal;
                                    @endphp
                                    <tr>
                                        <td>
                                            <span class="font-weight-bold d-block">{{ $cart->product->name }}</span>
                                            <small class="text-muted">SKU: {{ $cart->product->sku ?? '-' }}</small>
                                        </td>
                                        <td>Rp {{ number_format($cart->product->selling_price, 0, ',', '.') }}</td>
                                        <td class="text-center">{{ $cart->quantity }}</td>
                                        <td>Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                                        <td class="text-center">
                                            <form action="{{ route('cart.destroy', $cart->id) }}" method="POST" onsubmit="return confirm('Hapus item dari keranjang?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm text-white" style="background-color: #e5989b; border-radius: 6px;">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">
                                            Belum ada produk di dalam keranjang belanja.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($carts->isNotEmpty())
                        <hr class="my-4" style="border-color: #ebd5d8;">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="font-weight-bold mb-0" style="color: #6d6875;">Total Pembayaran:</h5>
                            <h4 class="font-weight-bold mb-0" style="color: #b5838d;">Rp {{ number_format($grandTotal, 0, ',', '.') }}</h4>
                        </div>

                        <form action="{{ route('sales.checkout') }}" method="POST" onsubmit="return confirm('Selesaikan transaksi pembelian ini?')">
                            @csrf
                            <button type="submit" class="btn text-white btn-block btn-lg font-weight-bold" style="background-color: #b5838d; border-radius: 8px;">
                                <i class="fas fa-check-circle mr-1"></i> Selesaikan Transaksi / Checkout
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection