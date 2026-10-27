@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-sm border-0" style="background-color: #fff9f9; border-radius: 12px;">
                <div class="card-header bg-white d-flex justify-content-between align-items-center py-3" style="border-top-left-radius: 12px; border-top-right-radius: 12px;">
                    <h5 class="mb-0 font-weight-bold" style="color: #6d6875;">Riwayat Penjualan & Transaksi</h5>
                    <a href="{{ route('sales.create') }}" class="btn btn-sm text-white" style="background-color: #b5838d; border-radius: 8px;">
                        <i class="fas fa-plus mr-1"></i> Kasir / Transaksi Baru
                    </a>
                </div>

                <div class="card-body">
                    {{-- Alert Notification --}}
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show border-0" style="background-color: #d4edda; color: #155724;" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show border-0" role="alert">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <!-- Form Pencarian & Filter Tanggal Penjualan -->
                    <form action="{{ route('sales.index') }}" method="GET" class="mb-4">
                        <div class="row">
                            <div class="col-md-4 mb-2">
                                <input type="text" name="search" class="form-control" placeholder="Cari No. Transaksi..." value="{{ request('search') }}" style="border-radius: 8px;">
                            </div>
                            <div class="col-md-3 mb-2">
                                <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}" style="border-radius: 8px;" title="Dari Tanggal">
                            </div>
                            <div class="col-md-3 mb-2">
                                <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}" style="border-radius: 8px;" title="Sampai Tanggal">
                            </div>
                            <div class="col-md-2 mb-2">
                                <button type="submit" class="btn text-white w-100" style="background-color: #b5838d; border-radius: 8px;">
                                    <i class="fas fa-filter"></i> Filter
                                </button>
                            </div>
                        </div>
                        @if(request('search') || request('start_date') || request('end_date'))
                            <div class="mt-2">
                                <a href="{{ route('sales.index') }}" class="btn btn-sm btn-outline-secondary" style="border-radius: 6px;">
                                    <i class="fas fa-undo mr-1"></i> Reset Filter
                                </a>
                            </div>
                        @endif
                    </form>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead style="background-color: #f8edeb; color: #6d6875;">
                                <tr>
                                    <th>No. Transaksi</th>
                                    <th>Kasir / User</th>
                                    <th>Total (Rp)</th>
                                    <th>Status</th>
                                    <th>Tanggal Penjualan</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($sales as $sale)
                                <tr>
                                    <td class="font-weight-bold" style="color: #b5838d;">{{ $sale->sale_number }}</td>
                                    <td>{{ $sale->user->name ?? '-' }}</td>
                                    <td>Rp {{ number_format($sale->total, 0, ',', '.') }}</td>
                                    <td>
                                        @if($sale->status === 'cancelled')
                                            <span class="badge badge-danger">Dibatalkan</span>
                                        @else
                                            <span class="badge badge-success">Selesai</span>
                                        @endif
                                    </td>
                                    <td>{{ date('d/m/Y H:i', strtotime($sale->sold_at)) }}</td>
                                    <td class="text-center">
                                        <!-- Tombol Cetak Struk -->
                                        <a href="{{ route('sales.show', $sale->id) }}" class="btn btn-sm text-white mr-1" style="background-color: #b5838d; border-radius: 6px;" target="_blank">
                                            <i class="fas fa-print"></i> Struk
                                        </a>

                                        <!-- Tombol Batal Transaksi (KHUSUS ADMIN) -->
                                        @if(auth()->check() && auth()->user()->role === 'admin' && $sale->status !== 'cancelled')
                                            <form action="{{ route('sales.cancel', $sale->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan transaksi ini? Stok barang akan otomatis dikembalikan ke display.');">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-danger" style="border-radius: 6px;">
                                                    <i class="fas fa-times-circle"></i> Batal
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">Belum ada riwayat transaksi penjualan yang ditemukan.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-3">
                        {{ $sales->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection