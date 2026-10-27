@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-sm border-0" style="background-color: #fff9f9; border-radius: 12px;">
                <div class="card-header bg-white d-flex justify-content-between align-items-center py-3" style="border-top-left-radius: 12px; border-top-right-radius: 12px;">
                    <h5 class="mb-0 font-weight-bold" style="color: #6d6875;"><i class="fas fa-pump-soap mr-2"></i>Daftar Produk Skincare & Kosmetik</h5>
                    
                    {{-- TOMBOL HANYA MUNCUL UNTUK ADMIN --}}
                    @if(Auth::check() && Auth::user()->role === 'admin')
                        <a href="{{ route('products.create') }}" class="btn text-white btn-sm" style="background-color: #b5838d; border-radius: 8px;">
                            <i class="fas fa-plus mr-1"></i> Tambah Produk
                        </a>
                    @endif
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show border-0" style="background-color: #e3d5ca; color: #4a4e69;" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <!-- FORM PENCARIAN PRODUK -->
                    <form action="{{ route('products.index') }}" method="GET" class="mb-4">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Cari SKU atau nama produk skincare..." value="{{ request('search') }}" style="border-radius: 8px 0 0 8px;">
                            <button class="btn text-white" type="submit" style="background-color: #b5838d;">
                                <i class="fas fa-search"></i> Cari
                            </button>
                            @if(request('search'))
                                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary ml-2" style="border-radius: 8px;">Reset</a>
                            @endif
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr style="color: #6d6875;">
                                    <th width="50" class="text-center">No</th>
                                    <th>SKU</th>
                                    <th>Nama Produk</th>
                                    <th>Kategori</th>
                                    <th>Supplier</th>
                                    <th>Harga Beli</th>
                                    <th>Harga Jual</th>
                                    <th class="text-center">Stok</th>
                                    
                                    {{-- KOLOM AKSI HANYA MUNCUL UNTUK ADMIN --}}
                                    @if(Auth::check() && Auth::user()->role === 'admin')
                                        <th width="160" class="text-center">Aksi</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($products as $index => $product)
                                    <tr>
                                        <td class="text-center font-weight-bold" style="color: #b5838d;">{{ $products->firstItem() + $index }}</td>
                                        <td class="font-weight-bold" style="color: #6d6875;">{{ $product->sku ?? '-' }}</td>
                                        <td class="font-weight-medium">{{ $product->name }}</td>
                                        <td><span class="badge" style="background-color: #f8edeb; color: #6d6875;">{{ $product->category->name ?? 'Tanpa Kategori' }}</span></td>
                                        <td>{{ $product->supplier->name ?? 'Tanpa Supplier' }}</td>
                                        <td>Rp {{ number_format($product->purchase_price, 0, ',', '.') }}</td>
                                        <td>Rp {{ number_format($product->selling_price, 0, ',', '.') }}</td>
                                        <td class="text-center">
                                            <span class="badge {{ $product->stock <= ($product->minimum_stock ?? 5) ? 'badge-danger' : 'badge-success' }}" style="padding: 6px 10px; border-radius: 8px; background-color: {{ $product->stock <= ($product->minimum_stock ?? 5) ? '#e5989b' : '#b5838d' }};">
                                                {{ $product->stock }} pcs
                                            </span>
                                        </td>
                                        
                                        {{-- TOMBOL EDIT & DELETE HANYA MUNCUL UNTUK ADMIN --}}
                                        @if(Auth::check() && Auth::user()->role === 'admin')
                                            <td class="text-center">
                                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm text-white" style="background-color: #e5989b; border-radius: 6px;"><i class="fas fa-edit"></i></a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm text-white" style="background-color: #6d6875; border-radius: 6px;"><i class="fas fa-trash"></i></button>
                                                </form>
                                            </td>
                                        @endif
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="{{ Auth::check() && Auth::user()->role === 'admin' ? 9 : 8 }}" class="text-center text-muted py-4">Belum ada data produk skincare yang ditemukan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $products->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection