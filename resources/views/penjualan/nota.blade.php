<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Nota Penjualan - Kez iStore</title>

    <style>
        /* ================= VARIABEL WARNA ================= */
        :root {
            --warna-utama: #1a1a1a;
            --warna-aksen: #d4af37;
            --warna-teks: #2d2d2d;
            --warna-abu: #f5f5f5;
            --warna-batas: #e0e0e0;
        }

        /* ================= BODY ================= */
        body {
            font-family: 'Arial', sans-serif;
            background: #f8f9fa;
            padding: 10px;
            margin: 0;
        }

        /* ================= KERTAS NOTA ================= */
        .nota {
            width: 650px;
            margin: auto;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            box-sizing: border-box;
        }

        /* ================= HEADER ATAS ================= */
        .top-header {
            background-color: var(--warna-utama);
            color: white;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
        }

        .top-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, var(--warna-aksen) 0%, #f0c808 100%);
        }

        .logo-wrapper {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logo-box {
            width: 65px;
            height: 65px;
            background: rgba(255, 255, 255, 0.15);
            border: 2px solid var(--warna-aksen);
            border-radius: 10px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            font-weight: bold;
            font-size: 20px;
            color: #ffffff;
        }

        .logo-box small {
            font-size: 10px;
            font-weight: normal;
            letter-spacing: 1px;
            opacity: 0.9;
        }

        .store-detail h1 {
            margin: 0;
            font-size: 22px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #ffffff;
        }

        .store-detail p {
            margin: 3px 0;
            font-size: 11px;
            opacity: 0.85;
            line-height: 1.4;
        }

        .invoice-head {
            text-align: right;
        }

        .invoice-head h2 {
            margin: 0 0 8px 0;
            font-size: 24px;
            text-transform: uppercase;
            font-weight: bold;
            color: var(--warna-aksen);
            letter-spacing: 1px;
        }

        .invoice-head table {
            margin: 0;
        }

        .invoice-head td {
            padding: 2px 0 2px 10px;
            font-size: 11px;
            color: #ffffff;
        }

        .label-info {
            font-weight: 600;
            opacity: 0.8;
        }

        /* ================= KONTEN UTAMA ================= */
        .content-wrapper {
            padding: 20px;
        }

        /* ================= GARIS PEMBATAS ================= */
        .divider {
            border: none;
            border-top: 1px dashed #b0b0b0;
            margin: 12px 0;
        }

        .divider-solid {
            border: none;
            border-top: 2px solid var(--warna-utama);
            margin: 15px 0;
        }

        /* ================= BLOK INFORMASI ================= */
        .info-block {
            background: var(--warna-abu);
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .info-block table {
            width: 100%;
        }

        .info-block td {
            padding: 3px 0;
            font-size: 12px;
            color: var(--warna-teks);
        }

        .info-block td:first-child {
            font-weight: 600;
 width: 18%;
            color: var(--warna-utama);
        }

        /* ================= TABEL PRODUK ================= */
        .table-produk {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }

        .table-produk thead th {
            background: var(--warna-utama);
            color: white;
            padding: 10px 8px;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: none;
        }

        .table-produk thead th:first-child {
            border-top-left-radius: 6px;
        }

        .table-produk thead th:last-child {
            border-top-right-radius: 6px;
        }

        .table-produk tbody td {
            padding: 12px 8px;
            font-size: 12px;
            color: var(--warna-teks);
            border-bottom: 1px solid var(--warna-batas);
            background: #ffffff;
        }

        .table-produk tbody tr:nth-child(even) td {
            background: #fcfcfc;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .text-harga {
            font-weight: 600;
            color: #228b22;
        }

        /* ================= RINCIAN PEMBAYARAN ================= */
        .payment-section {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            margin-top: 15px;
        }

        .note-box {
            width: 48%;
            background: #f9f6f0;
            border-left: 3px solid var(--warna-aksen);
            padding: 12px 15px;
            border-radius: 6px;
        }

        .note-box h4 {
            margin: 0 0 8px 0;
            font-size: 13px;
            color: var(--warna-utama);
            font-weight: bold;
        }

        .note-box p {
            font-size: 11px;
            line-height: 1.6;
            margin: 4px 0;
            color: #444444;
        }

        .total-box {
            width: 48%;
        }

        .total-table {
            width: 100%;
            border-collapse: collapse;
        }

        .total-table td {
            padding: 6px 0;
            font-size: 12px;
            color: var(--warna-teks);
        }

        .total-table td:last-child {
            text-align: right;
            font-weight: 500;
        }

        .grand-total-row {
            background: var(--warna-utama);
            color: white !important;
            border-radius: 6px;
        }

        .grand-total-row td {
            padding: 10px 12px !important;
            font-size: 14px !important;
            font-weight: bold !important;
            color: white !important;
        }

        .status-badge {
            display: inline-block;
            background: #228b22;
            color: white;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: bold;
        }
        
        .status-badge.pending {
            background: #ca8a04;
        }

        /* ================= FOOTER / TERIMA KASIH ================= */
        .footer-note {
            text-align: center;
            margin-top: 20px;
            padding-top: 15px;
            border-top: 1px solid var(--warna-batas);
        }

        .footer-note h3 {
            margin: 0 0 8px 0;
            font-size: 14px;
            color: var(--warna-utama);
            font-weight: bold;
            letter-spacing: 0.5px;
        }

        .footer-note p {
            font-size: 11px;
            color: #666666;
            margin: 3px 0;
        }

        .code-transaksi {
            margin-top: 10px;
            font-family: 'Courier New', monospace;
            font-size: 16px;
            letter-spacing: 2px;
            color: var(--warna-utama);
            font-weight: bold;
            background: var(--warna-abu);
            display: inline-block;
            padding: 5px 12px;
            border-radius: 4px;
        }

        /* ================= PENGATURAN CETAK ================= */
        @media print {
            body {
                background: white;
                padding: 0;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .nota {
                width: 100%;
                border: none;
                box-shadow: none;
                border-radius: 0;
            }
        }
    </style>
</head>

<body onload="window.print()">

    <div class="nota">

        {{-- ================= HEADER ATAS (HITAM & EMAS) ================= --}}
        <div class="top-header">
            <div class="logo-wrapper">
                <div class="logo-box">
                    KEZ
                    <small>iSTORE</small>
                </div>
                <div class="store-detail">
                    <h1>KEZ iSTORE</h1>
                    <p>📍 Pusat Penjualan & Servis Produk Apple dan Aksesoris</p>
                    <p>Jl. Bantul No. 262 KM 5, Yogyakarta | 📞 085815113347</p>
                    <p>📷 Instagram: @kez.istore</p>
                </div>
            </div>

            <div class="invoice-head">
                <h2>NOTA PENJUALAN</h2>
                <table>
                    <tr>
                        <td class="label-info">Nomor Nota</td>
                        {{-- ✅ DIPERBAIKI: Pakai kode_jual yang benar --}}
                        <td>: #{{ $data->kode_jual }}</td>
                    </tr>
                    <tr>
                        <td class="label-info">Tanggal</td>
                        {{-- ✅ DIPERBAIKI: Pakai kolom tanggal_jual --}}
                        <td>: {{ \Carbon\Carbon::parse($data->tanggal_jual)->format('d F Y, H:i') }}</td>
                    </tr>
                    <tr>
                        <td class="label-info">Dilayani</td>
                        {{-- ✅ DIPERBAIKI: Ambil nama dari relasi user --}}
                        <td>: {{ $data->user->name ?? 'Admin' }}</td>
                    </tr>
                </table>
            </div>
        </div>

        {{-- ================= KONTEN UTAMA ================= --}}
        <div class="content-wrapper">

            {{-- INFORMASI PELANGGAN --}}
            <div class="info-block">
                <table>
                    <tr>
                        <td>Nama Pelanggan</td>
                        <td>: {{ $data->nama_pembeli ?? 'Pelanggan Umum' }}</td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td>: {{ $data->alamat ?? '-' }}</td>
                    </tr>
                </table>
            </div>

            <hr class="divider-solid">

            {{-- TABEL PRODUK --}}
            <table class="table-produk">
                <thead>
                    <tr>
                        <th class="text-center" width="5%">No</th>
                        <th width="45%">Nama Produk</th>
                        <th class="text-center" width="10%">Jumlah</th>
                        <th class="text-right" width="20%">Harga Satuan</th>
                        <th class="text-right" width="20%">Total Harga</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data->details as $key => $d)
                    <tr>
                        <td class="text-center">{{ $key + 1 }}</td>
                        <td><strong>{{ $d->produk->nama_produk ?? '-' }}</strong></td>
                        <td class="text-center">{{ $d->jumlah }}</td>
                        <td class="text-right text-harga">Rp {{ number_format($d->harga,0,',','.') }}</td>
                        <td class="text-right text-harga">Rp {{ number_format($d->subtotal,0,',','.') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center" style="font-style: italic; color: #888;">
                            — Data barang tidak tersedia —
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <hr class="divider-solid">

            {{-- PEMBAYARAN & CATATAN --}}
            <div class="payment-section">
                <div class="note-box">
                    <h4>📌 Informasi Penting:</h4>
                    <p>• Barang yang telah dibeli tidak dapat dikembalikan atau ditukar, kecuali terdapat cacat produksi.</p>
                    <p>• Garansi berlaku sesuai ketentuan resmi distributor.</p>
                    <p>• Simpan nota ini sebagai bukti sah pembelian.</p>
                </div>

                <div class="total-box">
                    <table class="total-table">
                        <tr>
                            <td>Subtotal</td>
                            <td>Rp {{ number_format($data->total_jual,0,',','.') }}</td>
                        </tr>
                        <tr class="grand-total-row">
                            <td>Total Pembayaran</td>
                            <td>Rp {{ number_format($data->total_jual,0,',','.') }}</td>
                        </tr>
                        <tr>
                            <td>Metode Bayar</td>
                            <td>{{ $data->metode_bayar ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td>
                                <span class="status-badge {{ $data->status_bayar != 'Lunas' ? 'pending' : '' }}">
                                    {{ $data->status_bayar ?? 'Pending' }}
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            {{-- PENUTUP --}}
            <div class="footer-note">
                <h3>★ TERIMA KASIH ATAS KUNJUNGAN ANDA ★</h3>
                <p>Kami berharap Anda puas dengan produk yang Anda beli.</p>
                <p>Jangan ragu untuk kembali lagi ke Kez iStore untuk kebutuhan perangkat Apple Anda.</p>

                <div class="code-transaksi">
                    KODE: {{ $data->kode_jual }}
                </div>
            </div>

        </div>

    </div>

</body>

</html>