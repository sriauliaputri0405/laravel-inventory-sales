@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-sm border-0" style="background-color: #fff9f9; border-radius: 12px;">
                <div class="card-header bg-white d-flex justify-content-between align-items-center py-3" style="border-top-left-radius: 12px; border-top-right-radius: 12px;">
                    <h5 class="mb-0 font-weight-bold" style="color: #6d6875;">Laporan Penjualan GlowStudio</h5>
                    <button onclick="window.print()" class="btn btn-sm text-white" style="background-color: #b5838d; border-radius: 8px;">
                        <i class="fas fa-print"></i> Cetak Laporan
                    </button>
                </div>

                <div class="card-body">
                    <!-- Form Filter Tanggal Laporan -->
                    <form action="{{ route('sales.report') }}" method="GET" class="mb-4">
                        <div class="row">
                            <div class="col-md-4 mb-2">
                                <label class="small text-muted">Dari Tanggal</label>
                                <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}" style="border-radius: 8px;">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label class="small text-muted">Sampai Tanggal</label>
                                <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}" style="border-radius: 8px;">
                            </div>
                            <div class="col-md-4 mb-2 d-flex align-items-end">
                                <button type="submit" class="btn text-white w-100" style="background-color: #b5838d; border-radius: 8px;">
                                    <i class="fas fa-filter"></i> Tampilkan Laporan
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Ringkasan Statistik -->
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <div class="p-3 border-0 shadow-sm text-center" style="background-color: #f8edeb; border-radius: 10px;">
                                <h6 class="text-muted mb-1">Total Transaksi</h6>
                                <h4 class="font-weight-bold mb-0" style="color: #b5838d;">{{ $totalTransactions }}</h4>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="p-3 border-0 shadow-sm text-center" style="background-color: #f8edeb; border-radius: 10px;">
                                <h6 class="text-muted mb-1">Total Pendapatan</h6>
                                <h4 class="font-weight-bold mb-0" style="color: #b5838d;">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h4>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead style="background-color: #f8edeb; color: #6d6875;">
                                <tr>
                                    <th>No. Transaksi</th>
                                    <th>Kasir</th>
                                    <th>Total (Rp)</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($sales as $sale)
                                <tr>
                                    <td class="font-weight-bold" style="color: #b5838d;">{{ $sale->sale_number }}</td>
                                    <td>{{ $sale->user->name ?? '-' }}</td>
                                    <td>Rp {{ number_format($sale->total, 0, ',', '.') }}</td>
                                    <td>{{ date('d/m/Y H:i', strtotime($sale->sold_at)) }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">Tidak ada data penjualan pada rentang tanggal tersebut.</td>
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