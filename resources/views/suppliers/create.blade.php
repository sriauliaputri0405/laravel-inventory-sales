@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header font-weight-bold">
                    <i class="fas fa-plus-circle mr-1"></i> Tambah Supplier Baru
                </div>
                <div class="card-body">
                    <form action="{{ route('suppliers.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Nama Supplier / PT <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Contoh: PT Beauty Cosmetics Indonesia" required>
                        </div>
                        <div class="form-group">
                            <label>No. Telepon / WA <span class="text-danger">*</span></label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" placeholder="Contoh: 081234567890" required>
                        </div>
                        <div class="form-group">
                            <label>Email Supplier</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="Contoh: supplier@beauty.com">
                        </div>
                        <div class="form-group">
                            <label>Alamat Lengkap</label>
                            <textarea name="address" class="form-control" rows="3" placeholder="Masukkan alamat supplier">{{ old('address') }}</textarea>
                        </div>
                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-pastel-primary">Simpan Supplier</button>
                            <a href="{{ route('suppliers.index') }}" class="btn btn-secondary" style="border-radius: 8px;">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection