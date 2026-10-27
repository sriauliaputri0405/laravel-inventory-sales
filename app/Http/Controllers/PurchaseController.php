<?php

namespace App\Http\Controllers;

use App\Purchase;
use App\Supplier;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    // Menampilkan daftar riwayat restock
    public function index()
    {
        $purchases = Purchase::with(['supplier', 'user', 'items.product'])->latest()->paginate(10);
        return view('purchases.index', compact('purchases'));
    }

    // Menampilkan form tambah restock
    public function create()
    {
        $suppliers = Supplier::all();
        $products = Product::all();
        return view('purchases.create', compact('suppliers', 'products'));
    }

    // Menyimpan transaksi pembelian dan menambah stok produk otomatis
    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($request) {
            $purchase = Purchase::create([
                'supplier_id' => $request->supplier_id,
                'user_id' => auth()->id() ?? 1,
                'purchase_number' => 'PO-' . strtoupper(uniqid()),
                'total' => 0,
                'purchased_at' => now(),
            ]);

            $total = 0;

            foreach ($request->items as $item) {
                $product = Product::lockForUpdate()->findOrFail($item['product_id']);
                $qty = (int) $item['quantity'];
                $price = (float) $item['unit_price'];
                
                // PERBAIKAN: Menambahkan operator perkalian (*) yang terpotong
                $subtotal = $price * $qty;

                // Simpan item pembelian
                $purchase->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $qty,
                    'unit_price' => $price,
                    'subtotal' => $subtotal,
                ]);

                // Tambah stok produk secara otomatis
                $product->increment('stock', $qty);

                $total += $subtotal;
            }

            $purchase->update(['total' => $total]);
        });

        return redirect()->route('purchases.index')->with('success', 'Berhasil mencatat restock barang dan stok gudang bertambah!');
    }
}