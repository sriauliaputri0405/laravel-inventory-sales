@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header font-weight-bold">
                    <i class="fas fa-edit mr-1"></i> Edit Data Supplier
                </div>
                <div class="card-body">
                    <form action="{{ route('suppliers.update', $supplier->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>Nama Supplier / PT <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $supplier->name) }}" required>
                        </div>
                        <div class="form-group">
                            <label>No. Telepon / WA <span class="text-danger">*</span></label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone', $supplier->phone) }}" required>
                        </div>
                        <div class="form-group">
                            <label>Email Supplier</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $supplier->email) }}">
                        </div>
                        <div class="form-group">
                            <label>Alamat Lengkap</label>
                            <textarea name="address" class="form-control" rows="3">{{ old('address', $supplier->address) }}</textarea>
                        </div>
                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-pastel-primary">Update Supplier</button>
                            <a href="{{ route('suppliers.index') }}" class="btn btn-secondary" style="border-radius: 8px;">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection