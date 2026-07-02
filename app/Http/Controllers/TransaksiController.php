<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Penjualan;
use App\Models\DetailPenjualan;
use App\Models\PenerimaanKas;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    // ========================
    // HALAMAN TRANSAKSI
    // ========================
    public function index()
    {
        $produk = Produk::latest()->get();
        $cart = session()->get('cart', []);

        // 🔥 LOG
        if (Auth::check()) {
            ActivityLog::create([
                'id_user'   => Auth::user()->id_user,
                'aktivitas' => 'Buka Menu Transaksi',
                'keterangan'=> 'Mengakses halaman transaksi'
            ]);
        }

        return view('transaksi.index', compact('produk', 'cart'));
    }

    // ========================
    // TAMBAH KE KERANJANG
    // ========================
    public function add(Request $request)
    {
        $produk = Produk::find($request->id_produk);

        if (!$produk) {
            return back()->with('error', 'Produk tidak ditemukan');
        }

        if ($produk->stok <= 0) {
            return back()->with('error', 'Stok produk habis');
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$produk->id_produk])) {

            if ($cart[$produk->id_produk]['qty'] >= $produk->stok) {
                return back()->with('error', 'Stok tidak mencukupi');
            }

            $cart[$produk->id_produk]['qty']++;

        } else {

            $cart[$produk->id_produk] = [
                'id_produk' => $produk->id_produk,
                'nama'      => $produk->nama_produk,
                'harga'     => $produk->harga,
                'qty'       => 1
            ];
        }

        session()->put('cart', $cart);

        // 🔥 LOG
        if (Auth::check()) {
            ActivityLog::create([
                'id_user'   => Auth::user()->id_user,
                'aktivitas' => 'Tambah Produk ke Keranjang',
                'keterangan'=> 'Produk: ' . $produk->nama_produk
            ]);
        }

        return back()->with('success', 'Produk ditambahkan ke keranjang');
    }

    // ========================
    // UPDATE JUMLAH KERANJANG
    // ========================
    public function update(Request $request)
    {
        $request->validate([
            'id_produk' => 'required',
            'qty' => 'required|integer|min:1'
        ]);

        $produk = Produk::find($request->id_produk);

        if (!$produk) {
            return back()->with('error', 'Produk tidak ditemukan');
        }

        if ($request->qty > $produk->stok) {
            return back()->with('error', 'Stok tidak mencukupi');
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$request->id_produk])) {
            $cart[$request->id_produk]['qty'] = $request->qty;
        }

        session()->put('cart', $cart);

        // 🔥 LOG
        if (Auth::check()) {
            ActivityLog::create([
                'id_user'   => Auth::user()->id_user,
                'aktivitas' => 'Update Jumlah Keranjang',
                'keterangan'=> 'Produk: ' . $produk->nama_produk . ' - Jumlah: ' . $request->qty
            ]);
        }

        return back()->with('success', 'Jumlah produk berhasil diupdate');
    }

    // ========================
    // HAPUS DARI KERANJANG
    // ========================
    public function delete(Request $request)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$request->id_produk])) {
            unset($cart[$request->id_produk]);
        }

        session()->put('cart', $cart);

        // 🔥 LOG
        if (Auth::check()) {
            ActivityLog::create([
                'id_user'   => Auth::user()->id_user,
                'aktivitas' => 'Hapus Produk dari Keranjang',
                'keterangan'=> 'ID Produk: ' . $request->id_produk
            ]);
        }

        return back()->with('success', 'Produk dihapus dari keranjang');
    }

    // ========================
    // CHECKOUT
    // ========================
    public function checkout(Request $request)
    {
        try {

            $request->validate([
                'metode_bayar' => 'required',
                'nama_pembeli' => 'nullable|string|max:100',
                'no_hp'        => 'nullable|string|max:20',
                'bukti_bayar'  => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
            ]);

            $cart = session()->get('cart');

            if (!$cart || count($cart) == 0) {
                return back()->with('error', 'Keranjang kosong!');
            }

            DB::beginTransaction();

            $total = 0;
            foreach ($cart as $item) {
                $total += $item['harga'] * $item['qty'];
            }

            $bukti = null;

            if ($request->hasFile('bukti_bayar')) {

                $path = public_path('bukti');

                if (!File::exists($path)) {
                    File::makeDirectory($path, 0755, true);
                }

                $file = $request->file('bukti_bayar');
                $bukti = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move($path, $bukti);
            }

            // Status pembayaran berdasarkan metode dan bukti
            $status = 'Belum Lunas'; // Default

            if ($request->metode_bayar == 'Cash' || $bukti) {
                $status = 'Lunas'; // Langsung lunas jika Cash atau ada bukti
            }

            $penjualan = Penjualan::create([
                'id_user'      => Auth::user()->id_user,
                'tanggal_jual' => now(),
                'nama_pembeli' => $request->nama_pembeli ?? 'Umum',
                'no_hp'        => $request->no_hp,
                'total_jual'   => $total,
                'metode_bayar' => $request->metode_bayar,
                'bukti_bayar'  => $bukti,
                'status_bayar' => $status
            ]);

            // 🔥 MASUK KAS
            if ($status == 'Lunas') {

                $cekKas = PenerimaanKas::where('kode_jual', $penjualan->kode_jual)->first();

                if (!$cekKas) {
                    PenerimaanKas::create([
                        'kode_jual'        => $penjualan->kode_jual,
                        'tgl_terimakas'  => now(),
                        'jmlh_terimakas' => $total,
                        'keterangan'     => 'Penerimaan dari penjualan'
                    ]);
                }
            }

            foreach ($cart as $item) {

                $produk = Produk::find($item['id_produk']);

                if (!$produk) {
                    throw new \Exception('Produk tidak ditemukan');
                }

                if ($produk->stok < $item['qty']) {
                    throw new \Exception('Stok tidak cukup untuk ' . $produk->nama_produk);
                }

                DetailPenjualan::create([
                    'kode_jual'   => $penjualan->kode_jual,
                    'id_produk' => $item['id_produk'],
                    'jumlah'    => $item['qty'],
                    'harga'     => $item['harga'],
                    'subtotal'  => $item['harga'] * $item['qty']
                ]);

                $produk->decrement('stok', $item['qty']);
            }

            DB::commit();

            // 🔥 LOG CHECKOUT
            if (Auth::check()) {
                ActivityLog::create([
                    'id_user'   => Auth::user()->id_user,
                    'aktivitas' => 'Checkout',
                    'keterangan'=> 'Total transaksi: Rp ' . number_format($total)
                ]);
            }

            session()->forget('cart');

            return redirect()->route('penjualan.index')
                ->with('success', 'Transaksi berhasil disimpan');

        } catch (\Exception $e) {

            DB::rollback();

            return back()->with('error', $e->getMessage());
        }
    }
}