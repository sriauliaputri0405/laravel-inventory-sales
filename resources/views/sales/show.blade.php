@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0" style="background-color: #fff9f9; border-radius: 12px;">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center" style="border-top-left-radius: 12px; border-top-right-radius: 12px;">
                    <h5 class="mb-0 font-weight-bold" style="color: #6d6875;"><i class="fas fa-receipt mr-2"></i>Struk Transaksi #{{ $sale->sale_number }}</h5>
                    <div>
                        <button onclick="window.print()" class="btn btn-sm text-white" style="background-color: #b5838d; border-radius: 8px;"><i class="fas fa-print"></i> Cetak</button>
                        <a href="{{ route('sales.index') }}" class="btn btn-sm btn-outline-secondary ml-1" style="border-radius: 8px;">Kembali</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <p class="mb-1 text-muted">Tanggal Transaksi:</p>
                            <h6 class="font-weight-bold" style="color: #6d6875;">{{ date('d/m/Y H:i', strtotime($sale->sold_at)) }}</h6>
                        </div>
                        <div class="col-sm-6 text-sm-right">
                            <p class="mb-1 text-muted">Kasir:</p>
                            <h6 class="font-weight-bold" style="color: #b5838d;">{{ $sale->user->name ?? 'Admin' }}</h6>
                        </div>
                    </div>

                    <hr>

                    <div class="table-responsive">
                        <table class="table table-sm align-middle">
                            <thead style="background-color: #f8edeb; color: #6d6875;">
                                <tr>
                                    <th>Produk</th>
                                    <th class="text-center">Jumlah</th>
                                    <th class="text-right">Harga Satuan</th>
                                    <th class="text-right">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sale->items as $item)
                                <tr>
                                    <td>{{ $item->product->name ?? 'Produk Dihapus' }}</td>
                                    <td class="text-center">{{ $item->quantity }} pcs</td>
                                    <td class="text-right">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                    <td class="text-right">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3" class="text-right py-3">Total Pembayaran:</th>
                                    <th class="text-right py-3 font-weight-bold" style="color: #b5838d; font-size: 1.1rem;">
                                        Rp {{ number_format($sale->total, 0, ',', '.') }}
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection