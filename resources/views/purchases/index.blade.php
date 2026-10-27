@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-sm border-0" style="background-color: #fff9f9; border-radius: 12px;">
                <div class="card-header bg-white d-flex justify-content-between align-items-center py-3" style="border-top-left-radius: 12px; border-top-right-radius: 12px;">
                    <h5 class="mb-0 font-weight-bold" style="color: #6d6875;">Riwayat Restock Barang</h5>
                    <a href="{{ route('purchases.create') }}" class="btn btn-sm text-white" style="background-color: #b5838d; border-radius: 8px;">
                        + Tambah Restock Barang
                    </a>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success" style="background-color: #e3d5ca; color: #4a4e69; border: none;">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead style="background-color: #f8edeb; color: #6d6875;">
                                <tr>
                                    <th>No. PO</th>
                                    <th>Supplier</th>
                                    <th>Admin / Staff</th>
                                    <th>Total Pembelian (Rp)</th>
                                    <th>Tanggal Masuk</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($purchases as $purchase)
                                <tr>
                                    <td class="font-weight-bold" style="color: #b5838d;">{{ $purchase->purchase_number }}</td>
                                    <td>{{ $purchase->supplier->name ?? '-' }}</td>
                                    <td>{{ $purchase->user->name ?? '-' }}</td>
                                    <td>Rp {{ number_format($purchase->total, 0, ',', '.') }}</td>
                                    <td>{{ date('d/m/Y H:i', strtotime($purchase->purchased_at)) }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">Belum ada riwayat restock barang.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-3">
                        {{ $purchases->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection