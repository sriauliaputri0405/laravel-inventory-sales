@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0" style="background-color: #fff9f9; border-radius: 12px;">
                <div class="card-header bg-white py-3" style="border-top-left-radius: 12px; border-top-right-radius: 12px;">
                    <h5 class="mb-0 font-weight-bold" style="color: #6d6875;">Edit Data Staff</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('staff.update', $staff->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group mb-3">
                            <label class="font-weight-bold" style="color: #6d6875;">Nama Lengkap *</label>
                            <input type="text" name="name" class="form-control" required style="border-radius: 8px;" value="{{ old('name', $staff->name) }}">
                        </div>
                        <div class="form-group mb-3">
                            <label class="font-weight-bold" style="color: #6d6875;">Email *</label>
                            <input type="email" name="email" class="form-control" required style="border-radius: 8px;" value="{{ old('email', $staff->email) }}">
                        </div>
                        <div class="form-group mb-3">
                            <label class="font-weight-bold" style="color: #6d6875;">Password Baru <small class="text-muted">(Kosongkan jika tidak ingin mengubah password)</small></label>
                            <input type="password" name="password" class="form-control" style="border-radius: 8px;">
                        </div>
                        <div class="form-group mb-4">
                            <label class="font-weight-bold" style="color: #6d6875;">Role / Hak Akses *</label>
                            <select name="role" class="form-control" required style="border-radius: 8px;">
                                <option value="kasir" {{ $staff->role == 'kasir' ? 'selected' : '' }}>Kasir</option>
                                <option value="admin" {{ $staff->role == 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('staff.index') }}" class="btn btn-secondary" style="border-radius: 8px;">Batal</a>
                            <button type="submit" class="btn text-white" style="background-color: #b5838d; border-radius: 8px;">Update Staff</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection