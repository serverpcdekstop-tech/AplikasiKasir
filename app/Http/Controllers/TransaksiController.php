<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function index()
    {
        $data = Transaksi::latest()->get();
        $produk = Produk::latest()->get();

        return view('pages.order', compact('data', 'produk'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.id' => 'required|exists:produks,id',
            'items.*.qty' => 'required|integer|min:1',
            'bayar' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            $subtotal = 0;
            $produkItems = [];

            foreach ($request->items as $item) {
                $produk = Produk::lockForUpdate()
                    ->findOrFail($item['id']);

                if ($produk->status != 1) {
                    throw new \Exception(
                        "Produk {$produk->nama} sudah tidak aktif."
                    );
                }

                if ($produk->stok < $item['qty']) {
                    throw new \Exception(
                        "Stok {$produk->nama} tidak mencukupi."
                    );
                }

                $harga = $produk->harga;
                $itemSubtotal = $harga * $item['qty'];

                $subtotal += $itemSubtotal;

                $produkItems[] = [
                    'produk' => $produk,
                    'qty' => $item['qty'],
                    'harga' => $harga,
                    'subtotal' => $itemSubtotal,
                ];
            }

            $diskon = 0;
            $total = $subtotal - $diskon;
            $bayar = $request->bayar;

            if ($bayar < $total) {
                throw new \Exception(
                    'Uang pembayaran tidak mencukupi.'
                );
            }

            $kembalian = $bayar - $total;

            $nomor = 'TRX-' . now()->format('YmdHis');

            $transaksi = Transaksi::create([
                'nomor' => $nomor,
                'tanggal' => now(),
                'subtotal' => $subtotal,
                'diskon' => $diskon,
                'total' => $total,
                'bayar' => $bayar,
                'kembalian' => $kembalian,
                'status' => 'selesai',
                'keterangan' => null,
            ]);

            foreach ($produkItems as $item) {
                TransaksiDetail::create([
                    'transaksi_id' => $transaksi->id,
                    'produk_id' => $item['produk']->id,
                    'qty' => $item['qty'],
                    'harga' => $item['harga'],
                    'subtotal' => $item['subtotal'],
                ]);

                $item['produk']->decrement(
                    'stok',
                    $item['qty']
                );
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil disimpan.',
                'nomor' => $transaksi->nomor,
                'kembalian' => $kembalian,
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    public function show(Transaksi $transaksi)
    {
        //
    }

    public function edit(Transaksi $transaksi)
    {
        //
    }

    public function update(Request $request, Transaksi $transaksi)
    {
        //
    }

    public function destroy(Transaksi $transaksi)
    {
        //
    }
}
