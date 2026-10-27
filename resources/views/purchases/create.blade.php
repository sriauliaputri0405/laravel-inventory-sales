@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0" style="background-color: #fff9f9; border-radius: 12px;">
                <div class="card-header bg-white py-3" style="border-top-left-radius: 12px; border-top-right-radius: 12px;">
                    <h5 class="mb-0 font-weight-bold" style="color: #6d6875;">Form Tambah Restock Barang</h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('purchases.store') }}" method="POST">
                        @csrf
                        
                        <div class="form-group mb-3">
                            <label class="font-weight-bold" style="color: #6d6875;">Pilih Supplier</label>
                            <select name="supplier_id" class="form-control" required style="border-radius: 8px;">
                                <option value="">-- Pilih Supplier --</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <hr class="my-4">

                        <h6 class="font-weight-bold mb-3" style="color: #6d6875;">Detail Barang Masuk</h6>
                        
                        <div class="form-row mb-3">
                            <div class="col-md-5">
                                <label>Produk Skincare</label>
                                <select name="items[0][product_id]" class="form-control" required style="border-radius: 8px;">
                                    <option value="">-- Pilih Produk --</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }} (Stok Sisa: {{ $product->stock }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Jumlah (Qty)</label>
                                <input type="number" name="items[0][quantity]" class="form-control" min="1" value="1" required style="border-radius: 8px;">
                            </div>
                            <div class="col-md-4">
                                <label>Harga Beli Satuan (Rp)</label>
                                <input type="number" name="items[0][unit_price]" class="form-control" min="0" placeholder="Contoh: 25000" required style="border-radius: 8px;">
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('purchases.index') }}" class="btn btn-secondary" style="border-radius: 8px;">Kembali</a>
                            <button type="submit" class="btn text-white" style="background-color: #b5838d; border-radius: 8px;">Simpan Restock & Tambah Stok</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection