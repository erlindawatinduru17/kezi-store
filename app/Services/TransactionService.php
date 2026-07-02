<?php

namespace App\Services;

use App\Models\Penjualan;
use App\Models\DetailPenjualan;
use App\Models\PenerimaanKas;
use App\Models\Produk;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

class TransactionService
{
    /**
     * ================================
     * CART MANAGEMENT
     * ================================
     */

    /**
     * Ambil data keranjang dari session
     */
    public function getCart()
    {
        return session()->get('cart', []);
    }

    /**
     * Simpan keranjang ke session
     */
    public function saveCart($cart)
    {
        session()->put('cart', $cart);
    }

    /**
     * Tambah produk ke keranjang
     */
    public function addToCart($productId, $quantity = 1)
    {
        $produk = Produk::find($productId);

        if (!$produk) {
            throw new \Exception('Produk tidak ditemukan');
        }

        if ($produk->stok <= 0) {
            throw new \Exception('Stok produk habis');
        }

        $cart = $this->getCart();

        if (isset($cart[$produk->id_produk])) {
            if ($cart[$produk->id_produk]['qty'] >= $produk->stok) {
                throw new \Exception('Stok tidak mencukupi');
            }
            $cart[$produk->id_produk]['qty'] += $quantity;
        } else {
            $cart[$produk->id_produk] = [
                'id_produk' => $produk->id_produk,
                'nama'      => $produk->nama_produk,
                'harga'     => $produk->harga,
                'qty'       => $quantity
            ];
        }

        $this->saveCart($cart);

        // Log aktivitas
        if (Auth::check()) {
            ActivityLog::create([
                'id_user'   => Auth::user()->id_user,
                'aktivitas' => 'Tambah Produk ke Keranjang',
                'keterangan'=> 'Produk: ' . $produk->nama_produk . ' (x' . $quantity . ')'
            ]);
        }

        return $cart;
    }

    /**
     * Update jumlah produk di keranjang
     */
    public function updateCart($productId, $quantity)
    {
        if ($quantity < 1) {
            throw new \Exception('Jumlah minimal 1');
        }

        $produk = Produk::find($productId);

        if (!$produk) {
            throw new \Exception('Produk tidak ditemukan');
        }

        if ($quantity > $produk->stok) {
            throw new \Exception('Stok tidak mencukupi');
        }

        $cart = $this->getCart();

        if (isset($cart[$productId])) {
            $cart[$productId]['qty'] = $quantity;
        }

        $this->saveCart($cart);

        // Log aktivitas
        if (Auth::check()) {
            ActivityLog::create([
                'id_user'   => Auth::user()->id_user,
                'aktivitas' => 'Update Jumlah Keranjang',
                'keterangan'=> 'Produk: ' . $produk->nama_produk . ' - Jumlah: ' . $quantity
            ]);
        }

        return $cart;
    }

    /**
     * Hapus produk dari keranjang
     */
    public function removeFromCart($productId)
    {
        $cart = $this->getCart();

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
        }

        $this->saveCart($cart);

        // Log aktivitas
        if (Auth::check()) {
            ActivityLog::create([
                'id_user'   => Auth::user()->id_user,
                'aktivitas' => 'Hapus Produk dari Keranjang',
                'keterangan'=> 'ID Produk: ' . $productId
            ]);
        }

        return $cart;
    }

    /**
     * Kosongkan keranjang
     */
    public function clearCart()
    {
        session()->forget('cart');

        if (Auth::check()) {
            ActivityLog::create([
                'id_user'   => Auth::user()->id_user,
                'aktivitas' => 'Kosongkan Keranjang',
                'keterangan'=> 'Keranjang telah dikosongkan'
            ]);
        }
    }

    /**
     * Hitung total keranjang
     */
    public function calculateCartTotal()
    {
        $cart = $this->getCart();
        $total = 0;

        foreach ($cart as $item) {
            $total += $item['harga'] * $item['qty'];
        }

        return $total;
    }

    /**
     * ================================
     * CHECKOUT & TRANSACTION
     * ================================
     */

    /**
     * Proses checkout
     */
    public function checkout(array $data)
    {
        $cart = $this->getCart();

        if (!$cart || count($cart) == 0) {
            throw new \Exception('Keranjang kosong!');
        }

        DB::beginTransaction();

        try {
            // Hitung total
            $total = $this->calculateCartTotal();

            // Handle bukti pembayaran
            $bukti = null;
            if (isset($data['bukti_bayar'])) {
                $bukti = $this->saveBuktiPembayaran($data['bukti_bayar']);
            }

            // Tentukan status pembayaran
            $status = 'Belum Lunas'; // Default
            if ($data['metode_bayar'] == 'Cash' || $bukti) {
                $status = 'Lunas'; // Langsung lunas jika Cash atau ada bukti
            }

            // Buat penjualan
            $penjualan = Penjualan::create([
                'id_user'      => Auth::user()->id_user,
                'tanggal_jual' => now(),
                'nama_pembeli' => $data['nama_pembeli'] ?? 'Umum',
                'no_hp'        => $data['no_hp'] ?? null,
                'total_jual'   => $total,
                'metode_bayar' => $data['metode_bayar'],
                'bukti_bayar'  => $bukti,
                'status_bayar' => $status
            ]);

            // Tambah ke penerimaan kas jika lunas
            if ($status == 'Lunas') {
                PenerimaanKas::create([
                    'id_jual'        => $penjualan->id_jual,
                    'tgl_terimakas'  => now(),
                    'jmlh_terimakas' => $total,
                    'keterangan'     => 'Penerimaan dari transaksi penjualan'
                ]);
            }

            // Simpan detail produk dan update stok
            foreach ($cart as $item) {
                $produk = Produk::find($item['id_produk']);

                if (!$produk) {
                    throw new \Exception('Produk tidak ditemukan: ' . $item['id_produk']);
                }

                if ($produk->stok < $item['qty']) {
                    throw new \Exception('Stok tidak cukup untuk ' . $produk->nama_produk);
                }

                DetailPenjualan::create([
                    'id_jual'   => $penjualan->id_jual,
                    'id_produk' => $item['id_produk'],
                    'jumlah'    => $item['qty'],
                    'harga'     => $item['harga'],
                    'subtotal'  => $item['harga'] * $item['qty']
                ]);

                $produk->decrement('stok', $item['qty']);
            }

            DB::commit();

            // Log checkout
            if (Auth::check()) {
                ActivityLog::create([
                    'id_user'   => Auth::user()->id_user,
                    'aktivitas' => 'Checkout Transaksi',
                    'keterangan'=> 'Total: Rp ' . number_format($total) . ' | Status: ' . $status
                ]);
            }

            // Kosongkan keranjang
            $this->clearCart();

            return $penjualan;

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    /**
     * Simpan bukti pembayaran
     */
    private function saveBuktiPembayaran($file)
    {
        $path = public_path('bukti');

        if (!File::exists($path)) {
            File::makeDirectory($path, 0755, true);
        }

        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move($path, $filename);

        return $filename;
    }

    /**
     * ================================
     * TRANSACTION QUERIES
     * ================================
     */

    /**
     * Dapatkan semua transaksi
     */
    public function getAllTransactions($filters = [])
    {
        $query = Penjualan::with('user', 'details.produk', 'penerimaanKas')->latest();

        if (isset($filters['from']) && $filters['from']) {
            $query->whereDate('tanggal_jual', '>=', $filters['from']);
        }

        if (isset($filters['to']) && $filters['to']) {
            $query->whereDate('tanggal_jual', '<=', $filters['to']);
        }

        if (isset($filters['status']) && $filters['status']) {
            $query->where('status_bayar', $filters['status']);
        }

        return $query->get();
    }

    /**
     * Dapatkan transaksi berdasarkan ID
     */
    public function getTransactionById($id)
    {
        return Penjualan::with('user', 'details.produk', 'penerimaanKas')
            ->findOrFail($id);
    }

    /**
     * Dapatkan penerimaan kas
     */
    public function getPaymentReceipts($filters = [])
    {
        $query = PenerimaanKas::with('penjualan', 'penjualan.user')->latest();

        if (isset($filters['from']) && $filters['from']) {
            $query->whereDate('tgl_terimakas', '>=', $filters['from']);
        }

        if (isset($filters['to']) && $filters['to']) {
            $query->whereDate('tgl_terimakas', '<=', $filters['to']);
        }

        return $query->get();
    }

    /**
     * ================================
     * PAYMENT MANAGEMENT
     * ================================
     */

    /**
     * Verifikasi pembayaran transaksi
     */
    public function verifyPayment($transactionId, $keterangan = null)
    {
        $penjualan = $this->getTransactionById($transactionId);

        if ($penjualan->isLunas()) {
            throw new \Exception('Transaksi sudah lunas sebelumnya');
        }

        DB::beginTransaction();

        try {
            $penjualan->markAsLunas($keterangan ?? 'Verifikasi pembayaran oleh admin');

            DB::commit();

            // Log aktivitas
            if (Auth::check()) {
                ActivityLog::create([
                    'id_user'   => Auth::user()->id_user,
                    'aktivitas' => 'Verifikasi Pembayaran',
                    'keterangan'=> 'Transaksi #' . $penjualan->kode_jual . ' - Rp ' . number_format($penjualan->total_jual)
                ]);
            }

            return $penjualan;

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    /**
     * Tambah penerimaan kas
     */
    public function addPaymentReceipt($transactionId, array $data)
    {
        $penjualan = $this->getTransactionById($transactionId);

        $penerimaanKas = PenerimaanKas::create([
            'id_jual'        => $transactionId,
            'tgl_terimakas'  => $data['tgl_terimakas'] ?? now(),
            'jmlh_terimakas' => $data['jmlh_terimakas'],
            'keterangan'     => $data['keterangan'] ?? null
        ]);

        // Check apakah sudah lunas
        $totalPaid = $penjualan->penerimaanKas()->sum('jmlh_terimakas');

        if ($totalPaid >= $penjualan->total_jual && $penjualan->isPending()) {
            $penjualan->update(['status_bayar' => 'Lunas']);
        } elseif ($totalPaid > 0 && $totalPaid < $penjualan->total_jual) {
            $penjualan->update(['status_bayar' => 'Sebagian']);
        }

        // Log aktivitas
        if (Auth::check()) {
            ActivityLog::create([
                'id_user'   => Auth::user()->id_user,
                'aktivitas' => 'Tambah Penerimaan Kas',
                'keterangan'=> 'Transaksi #' . $penjualan->kode_jual . ' - Rp ' . number_format($data['jmlh_terimakas'])
            ]);
        }

        return $penerimaanKas;
    }

    /**
     * ================================
     * TRANSACTION STATISTICS
     * ================================
     */

    /**
     * Hitung statistik penjualan
     */
    public function getSalesStatistics($filters = [])
    {
        $query = Penjualan::query();

        if (isset($filters['from']) && $filters['from']) {
            $query->whereDate('tanggal_jual', '>=', $filters['from']);
        }

        if (isset($filters['to']) && $filters['to']) {
            $query->whereDate('tanggal_jual', '<=', $filters['to']);
        }

        $transactions = $query->get();

        return [
            'total_transactions' => $transactions->count(),
            'total_revenue' => $transactions->sum('total_jual'),
            'total_paid' => $transactions->where('status_bayar', 'Lunas')->sum('total_jual'),
            'total_pending' => $transactions->where('status_bayar', 'Belum Lunas')->sum('total_jual'),
            'avg_transaction' => $transactions->count() > 0 ? $transactions->sum('total_jual') / $transactions->count() : 0,
        ];
    }

    /**
     * Hitung statistik kas
     */
    public function getCashStatistics($filters = [])
    {
        $query = PenerimaanKas::query();

        if (isset($filters['from']) && $filters['from']) {
            $query->whereDate('tgl_terimakas', '>=', $filters['from']);
        }

        if (isset($filters['to']) && $filters['to']) {
            $query->whereDate('tgl_terimakas', '<=', $filters['to']);
        }

        $receipts = $query->get();

        return [
            'total_receipts' => $receipts->count(),
            'total_cash' => $receipts->sum('jmlh_terimakas'),
            'avg_receipt' => $receipts->count() > 0 ? $receipts->sum('jmlh_terimakas') / $receipts->count() : 0,
        ];
    }
}
