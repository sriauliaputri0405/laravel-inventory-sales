@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            
            <!-- Kartu Selamat Datang -->
            <div class="card shadow-sm border-0 mb-4" style="background-color: #fff9f9; border-radius: 12px;">
                <div class="card-body p-4">
                    <h4 class="font-weight-bold" style="color: #6d6875;">Selamat Datang di Dashboard GlowStudio! ✨</h4>
                    <p class="text-muted mb-0">Kelola inventaris dan pantau transaksi penjualan produk kecantikan dengan mudah di sini.</p>
                </div>
            </div>

            <!-- Ringkasan Kartu Statistik -->
            <div class="row mb-4">
                <div class="col-md-4 mb-3 mb-md-0">
                    <div class="card shadow-sm border-0 text-center p-3" style="background-color: #fff9f9; border-radius: 12px;">
                        <h6 class="text-muted">Total Produk</h6>
                        <h3 class="font-weight-bold mb-0" style="color: #b5838d;">{{ $totalProducts ?? 0 }}</h3>
                    </div>
                </div>
                <div class="col-md-4 mb-3 mb-md-0">
                    <div class="card shadow-sm border-0 text-center p-3" style="background-color: #fff9f9; border-radius: 12px;">
                        <h6 class="text-muted">Total Transaksi</h6>
                        <h3 class="font-weight-bold mb-0" style="color: #b5838d;">{{ $totalSales ?? 0 }}</h3>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm border-0 text-center p-3" style="background-color: #fff9f9; border-radius: 12px;">
                        <h6 class="text-muted">Pendapatan</h6>
                        <h3 class="font-weight-bold mb-0" style="color: #b5838d;">Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</h3>
                    </div>
                </div>
            </div>

            <!-- Peringatan Stok Menipis -->
            @if(isset($lowStockProducts) && $lowStockProducts->count() > 0)
                <div class="card shadow-sm border-0 mb-4" style="background-color: #fdf0ed; border-radius: 12px; border-left: 5px solid #e5989b !important;">
                    <div class="card-body">
                        <h5 class="font-weight-bold mb-3" style="color: #b5838d;">
                            <i class="fas fa-exclamation-triangle mr-1"></i> Peringatan: Stok Produk Menipis!
                        </h5>
                        <div class="table-responsive">
                            <table class="table table-sm table-hover mb-0">
                                <thead>
                                    <tr style="color: #6d6875;">
                                        <th>Nama Produk</th>
                                        <th>Kategori</th>
                                        <th>Sisa Stok</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($lowStockProducts as $product)
                                    <tr>
                                        <td class="font-weight-bold">{{ $product->name }}</td>
                                        <td>{{ $product->category->name ?? '-' }}</td>
                                        <td>
                                            <span class="badge px-2 py-1 text-white" style="background-color: #e5989b;">
                                                {{ $product->stock }} pcs
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('purchases.create') }}" class="btn btn-sm text-white" style="background-color: #b5838d; border-radius: 6px;">
                                                <i class="fas fa-truck-loading"></i> Restock Sekarang
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Grafik Tren Penjualan -->
            <div class="card shadow-sm border-0" style="background-color: #fff9f9; border-radius: 12px;">
                <div class="card-header bg-white py-3" style="border-top-left-radius: 12px; border-top-right-radius: 12px;">
                    <h5 class="mb-0 font-weight-bold" style="color: #6d6875;">Grafik Pendapatan 7 Hari Terakhir</h5>
                </div>
                <div class="card-body">
                    <canvas id="salesChart" height="100"></canvas>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Library Chart.js & Script Grafik -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('salesChart').getContext('2d');
        const salesChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($chartDates) !!},
                datasets: [{
                    label: 'Pendapatan (Rp)',
                    data: {!! json_encode($chartTotals) !!},
                    borderColor: '#b5838d',
                    backgroundColor: 'rgba(181, 131, 141, 0.2)',
                    fill: true,
                    tension: 0.3,
                    borderWidth: 2,
                    pointBackgroundColor: '#b5838d',
                    pointRadius: 4
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endsection