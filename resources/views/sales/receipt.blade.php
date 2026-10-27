<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Belanja - {{ $sale->sale_number }}</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 14px;
            color: #333;
            background-color: #fff;
            margin: 0;
            padding: 20px;
        }
        .receipt-container {
            max-width: 350px;
            margin: 0 auto;
            padding: 20px;
            border: 1px dashed #b5838d;
            background: #fff9f9;
            border-radius: 8px;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-weight-bold { font-weight: bold; }
        .mb-1 { margin-bottom: 5px; }
        .my-2 { margin-top: 10px; margin-bottom: 10px; }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            margin-bottom: 10px;
        }
        th, td {
            padding: 6px 0;
            font-size: 13px;
        }
        th { border-bottom: 1px solid #ddd; }
        .btn-print {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #b5838d;
            color: white;
            border: none;
            border-radius: 5px;
            font-family: 'Nunito', sans-serif;
            font-weight: bold;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            margin-top: 15px;
        }
        .btn-print:hover {
            background-color: #a3707b;
        }
        @media print {
            .btn-print, .no-print {
                display: none;
            }
            body {
                padding: 0;
            }
            .receipt-container {
                border: none;
                background: white;
            }
        }
    </style>
</head>
<body>

    <div class="receipt-container">
        <!-- Header Toko -->
        <div class="text-center">
            <h3 class="mb-1" style="color: #b5838d; margin: 0;">GlowStudio Skincare</h3>
            <p class="mb-1" style="font-size: 12px; color: #666;">Jl. Kecantikan No. 128, Kota</p>
            <p style="font-size: 12px; color: #666; margin-bottom: 15px;">Telp: 0812-3456-7890</p>
        </div>

        <hr style="border: 0; border-top: 1px dashed #ccc;">

        <!-- Info Transaksi -->
        <div style="font-size: 12px; margin: 10px 0;">
            <div>No. Transaksi : <span class="font-weight-bold">{{ $sale->sale_number }}</span></div>
            <div>Tanggal       : {{ date('d/m/Y H:i', strtotime($sale->sold_at)) }}</div>
            <div>Kasir         : {{ $sale->user->name ?? 'Staff' }}</div>
        </div>

        <hr style="border: 0; border-top: 1px dashed #ccc;">

        <!-- Daftar Barang -->
        <table>
            <thead>
                <tr>
                    <th>Item</th>
                    <th class="text-center">Qty</th>
                    <th class="text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sale->items as $item)
                <tr>
                    <td>
                        {{ $item->product->name ?? 'Produk' }}<br>
                        <small style="color: #777;">@Rp {{ number_format($item->unit_price, 0, ',', '.') }}</small>
                    </td>
                    <td class="text-center">{{ $item->quantity }}</td>
                    <td class="text-right">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <hr style="border: 0; border-top: 1px dashed #ccc;">

        <!-- Total Pembayaran -->
        <table style="margin-bottom: 5px;">
            <tr>
                <td class="font-weight-bold" style="font-size: 14px;">TOTAL:</td>
                <td class="text-right font-weight-bold" style="font-size: 15px; color: #b5838d;">
                    Rp {{ number_format($sale->total, 0, ',', '.') }}
                </td>
            </tr>
        </table>

        <hr style="border: 0; border-top: 1px dashed #ccc;">

        <!-- Footer Struk -->
        <div class="text-center" style="font-size: 12px; color: #666; margin-top: 15px;">
            <p class="mb-1">Terima Kasih Telah Berbelanja!</p>
            <p style="margin: 0;">Barang yang sudah dibeli tidak dapat ditukar/dikembalikan.</p>
        </div>

        <!-- Tombol Cetak (Hilang otomatis saat diprint) -->
        <button onclick="window.print()" class="btn-print">Cetak Struk</button>
        <a href="{{ route('sales.index') }}" class="no-print" style="display: block; text-align: center; margin-top: 10px; font-size: 12px; color: #b5838d; text-decoration: none;">Kembali ke Riwayat</a>
    </div>

</body>
</html>