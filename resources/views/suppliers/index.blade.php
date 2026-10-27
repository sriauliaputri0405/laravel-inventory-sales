@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 font-weight-bold"><i class="fas fa-truck mr-2"></i>Daftar Supplier / Distributor</h5>
                    <a href="{{ route('suppliers.create') }}" class="btn btn-pastel-primary btn-sm"><i class="fas fa-plus mr-1"></i> Tambah Supplier</a>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show border-0" style="background-color: #d8bbff; color: #4a3b52;" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th width="60" class="text-center">No</th>
                                    <th>Nama Supplier</th>
                                    <th>No. Telepon</th>
                                    <th>Email</th>
                                    <th>Alamat</th>
                                    <th width="180" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($suppliers as $index => $supplier)
                                    <tr>
                                        <td class="text-center font-weight-bold" style="color: #b5838d;">{{ $index + 1 }}</td>
                                        <td class="font-weight-medium">{{ $supplier->name }}</td>
                                        <td><i class="fas fa-phone-alt text-muted mr-1"></i> {{ $supplier->phone }}</td>
                                        <td>{{ $supplier->email ?? '-' }}</td>
                                        <td>{{ $supplier->address ?? '-' }}</td>
                                        <td class="text-center">
                                            <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus supplier ini?')">
                                                <a href="{{ route('suppliers.edit', $supplier->id) }}" class="btn btn-pastel-warning btn-sm"><i class="fas fa-edit"></i> Edit</a>
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-pastel-danger btn-sm"><i class="fas fa-trash"></i> Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4">Belum ada data supplier. Silakan tambahkan supplier baru!</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection