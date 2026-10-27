@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0" style="background-color: #fff9f9; border-radius: 12px;">
                <div class="card-header bg-white py-3" style="border-top-left-radius: 12px; border-top-right-radius: 12px;">
                    <h5 class="mb-0 font-weight-bold" style="color: #6d6875;">Tambah Data Produk Skincare Baru</h5>
                </div>
                <div class="card-body">
                    
                    @if ($errors->any())
                        <div class="alert alert-danger" style="border-radius: 8px;">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('products.store') }}" method="POST">
                        @csrf
                        
                        <!-- INPUT SKU (WAJIB ADA) -->
                        <div class="form-group mb-3">
                            <label class="font-weight-bold" style="color: #6d6875;">SKU Produk *</label>
                            <input type="text" name="sku" class="form-control" value="{{ old('sku') }}" placeholder="Contoh: SKN-001" required style="border-radius: 8px;">
                        </div>

                        <!-- INPUT NAMA PRODUK -->
                        <div class="form-group mb-3">
                            <label class="font-weight-bold" style="color: #6d6875;">Nama Produk *</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Contoh: Sunscreen OMG" required style="border-radius: 8px;">
                        </div>

                        <!-- INPUT KATEGORI -->
                        <div class="form-group mb-3">
                            <label class="font-weight-bold" style="color: #6d6875;">Kategori *</label>
                            <select name="category_id" class="form-control" required style="border-radius: 8px;">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- INPUT SUPPLIER -->
                        <div class="form-group mb-3">
                            <label class="font-weight-bold" style="color: #6d6875;">Supplier *</label>
                            <select name="supplier_id" class="form-control" required style="border-radius: 8px;">
                                <option value="">-- Pilih Supplier --</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>{{ $supplier->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label class="font-weight-bold" style="color: #6d6875;">Harga Beli (Rp) *</label>
                                <input type="number" name="purchase_price" class="form-control" value="{{ old('purchase_price') }}" min="0" required style="border-radius: 8px;">
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label class="font-weight-bold" style="color: #6d6875;">Harga Jual (Rp) *</label>
                                <input type="number" name="selling_price" class="form-control" value="{{ old('selling_price') }}" min="0" required style="border-radius: 8px;">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 form-group">
                                <label class="font-weight-bold" style="color: #6d6875;">Stok Awal *</label>
                                <input type="number" name="stock" class="form-control" value="{{ old('stock', 0) }}" min="0" required style="border-radius: 8px;">
                            </div>
                            <!-- INPUT STOK MINIMUM (WAJIB ADA) -->
                            <div class="col-md-6 form-group">
                                <label class="font-weight-bold" style="color: #6d6875;">Stok Minimum *</label>
                                <input type="number" name="minimum_stock" class="form-control" value="{{ old('minimum_stock', 5) }}" min="0" required style="border-radius: 8px;">
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('products.index') }}" class="btn btn-secondary" style="border-radius: 8px;">Batal</a>
                            <button type="submit" class="btn text-white" style="background-color: #b5838d; border-radius: 8px;">Simpan Produk</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection