@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-sm border-0" style="background-color: #fff9f9; border-radius: 12px;">
                <div class="card-header bg-white d-flex justify-content-between align-items-center py-3" style="border-top-left-radius: 12px; border-top-right-radius: 12px;">
                    <h5 class="mb-0 font-weight-bold" style="color: #6d6875;">Manajemen Staff & Kasir</h5>
                    <a href="{{ route('staff.create') }}" class="btn btn-sm text-white" style="background-color: #b5838d; border-radius: 8px;">
                        + Tambah Staff Baru
                    </a>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success" style="background-color: #e3d5ca; color: #4a4e69; border: none;">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('staff.index') }}" method="GET" class="mb-4">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Cari nama atau email staff..." value="{{ request('search') }}" style="border-radius: 8px 0 0 8px;">
                            <div class="input-group-append">
                                <button type="submit" class="btn text-white" style="background-color: #b5838d; border-radius: 0 8px 8px 0;">Cari</button>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead style="background-color: #f8edeb; color: #6d6875;">
                                <tr>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Role / Jabatan</th>
                                    <th>Terdaftar</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($staffs as $staff)
                                <tr>
                                    <td class="font-weight-bold" style="color: #b5838d;">{{ $staff->name }}</td>
                                    <td>{{ $staff->email }}</td>
                                    <td>
                                        <span class="badge px-2 py-1" style="background-color: {{ $staff->role == 'admin' ? '#e5989b' : '#b5838d' }}; color: white; border-radius: 6px;">
                                            {{ ucfirst($staff->role ?? 'kasir') }}
                                        </span>
                                    </td>
                                    <td>{{ $staff->created_at->format('d/m/Y') }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('staff.edit', $staff->id) }}" class="btn btn-sm text-white mr-1" style="background-color: #e5989b; border-radius: 6px;">Edit</a>
                                        <form action="{{ route('staff.destroy', $staff->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus staff ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" style="border-radius: 6px;">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">Belum ada data staff.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-3">
                        {{ $staffs->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection