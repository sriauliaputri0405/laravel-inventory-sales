<?php

namespace App\Http\Controllers;

use App\Sale;
use App\Product;
use App\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Exception;

class SaleController extends Controller
{
    // Menampilkan daftar transaksi penjualan
    public function index()
    {
        $sales = Sale::with(['user', 'items.product'])->latest()->paginate(10);
        return view('sales.index', compact('sales'));
    }

    // Menampilkan form tambah penjualan konvensional / halaman kasir
    public function create()
    {
        $products = Product::where('stock', '>', 0)->get();
        $carts = Cart::with('product')->where('user_id', Auth::id())->get();

        return view('sales.create', compact('products', 'carts'));
    }

    // PROSES CHECKOUT MASSAL DARI KERANJANG
    public function checkout(Request $request)
    {
        DB::transaction(function () {
            $userId = Auth::id();
            $carts = Cart::with('product')->where('user_id', $userId)->get();

            if ($carts->isEmpty()) {
                throw ValidationException::withMessages([
                    'cart' => 'Keranjang belanja Anda kosong.',
                ]);
            }

            // 1. Buat Header Penjualan
            $sale = Sale::create([
                'user_id' => $userId,
                'sale_number' => 'SALE-' . strtoupper(uniqid()),
                'total' => 0,
                'status' => 'completed',
                'sold_at' => now(),
            ]);

            $total = 0;

            // 2. Loop setiap item barang di keranjang
            foreach ($carts as $cartItem) {
                $product = Product::lockForUpdate()->findOrFail($cartItem->product_id);
                $qty = (int) $cartItem->quantity;

                // 3. Validasi stok mencukupi
                if ($product->stock < $qty) {
                    throw ValidationException::withMessages([
                        'items' => "Stok untuk produk {$product->name} tidak mencukupi. Sisa stok: {$product->stock}",
                    ]);
                }

                // Subtotal harga (SUDAH DIPERBAIKI SINTAKS PERKALIANNYA)
                $subtotal = $product->selling_price * $qty;

                // 4. Simpan detail item penjualan
                $sale->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $qty,
                    'unit_price' => $product->selling_price,
                    'subtotal' => $subtotal,
                ]);

                // 5. Kurangi stok produk secara otomatis
                $product->decrement('stock', $qty);
                
                $total += $subtotal;
            }

            // 6. Update total harga di server
            $sale->update(['total' => $total]);

            // 7. Kosongkan keranjang setelah checkout sukses
            Cart::where('user_id', $userId)->delete();
        });

        return redirect()->route('sales.index')->with('success', 'Checkout berhasil! Transaksi tercatat dan stok diperbarui.');
    }

    /**
     * PEMBATALAN TRANSAKSI PENJUALAN (Khusus Admin)
     * Mengembalikan stok produk ke database/display secara otomatis.
     */
    public function cancel($id)
    {
        // Pengecekan role tambahan di level Controller
        if (Auth::user()->role !== 'admin') {
            return redirect()->back()->with('error', 'Akses ditolak! Pembatalan transaksi hanya boleh dilakukan oleh Admin.');
        }

        DB::beginTransaction();
        try {
            $sale = Sale::with('items.product')->findOrFail($id);

            // Cegah pembatalan berulang
            if ($sale->status === 'cancelled') {
                return redirect()->back()->with('error', 'Transaksi ini sudah dibatalkan sebelumnya.');
            }

            // Restorasi stok otomatis ke display/database
            foreach ($sale->items as $item) {
                $product = Product::lockForUpdate()->findOrFail($item->product_id);
                $product->increment('stock', $item->quantity);
            }

            // Ubah status transaksi menjadi cancelled
            $sale->update(['status' => 'cancelled']);

            DB::commit();
            return redirect()->route('sales.index')->with('success', 'Transaksi berhasil dibatalkan dan stok produk telah dikembalikan.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal membatalkan transaksi: ' . $e->getMessage());
        }
    }

    // Menampilkan halaman laporan riwayat penjualan
    public function report()
    {
        $sales = Sale::with(['user', 'items.product'])->latest()->paginate(10);
        $totalTransactions = Sale::where('status', '!=', 'cancelled')->count();
        $totalRevenue = Sale::where('status', '!=', 'cancelled')->sum('total');

        return view('sales.report', compact('sales', 'totalTransactions', 'totalRevenue'));
    }

    // Menampilkan detail transaksi / struk
    public function show($id)
    {
        $sale = Sale::with(['user', 'items.product'])->findOrFail($id);
        return view('sales.receipt', compact('sale'));
    }

    // Menampilkan halaman cetak struk nota
    public function receipt($id)
    {
        $sale = Sale::with(['user', 'items.product'])->findOrFail($id);
        return view('sales.receipt', compact('sale'));
    }

    // Menambahkan Pencarian dan Filter Tanggal
    public function search(Request $request)
    {
        $search = $request->input('search');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $sales = Sale::with(['user', 'items.product'])
            ->when($search, function ($query, $search) {
                return $query->where('sale_number', 'like', "%{$search}%");
            })
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                return $query->whereBetween('sold_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
            })
            ->latest()
            ->paginate(10);

        return view('sales.index', compact('sales', 'search', 'startDate', 'endDate'));
    }
}