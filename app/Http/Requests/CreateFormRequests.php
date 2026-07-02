<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreKategoriRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'kode_kategori' => 'nullable|string|unique:kategoris,kode_kategori',
            'nama_kategori' => 'required|string|max:255'
        ];
    }

    public function messages()
    {
        return [
            'kode_kategori.unique' => 'Kode kategori sudah digunakan',
            'nama_kategori.required' => 'Nama kategori wajib diisi'
        ];
    }
}

class StoreProdukRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'kode_produk' => 'nullable|string|unique:produks,kode_produk',
            'nama_produk' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'id_kategori' => 'required|exists:kategoris,id_kategori',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ];
    }

    public function messages()
    {
        return [
            'kode_produk.unique' => 'Kode produk sudah digunakan',
            'nama_produk.required' => 'Nama produk wajib diisi',
            'harga.required' => 'Harga wajib diisi',
            'stok.required' => 'Stok wajib diisi',
            'id_kategori.required' => 'Kategori wajib dipilih'
        ];
    }
}

class StorePenjualanRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'kode_jual' => 'nullable|string|unique:penjualans,kode_jual',
            'tanggal_jual' => 'required|date',
            'nama_pembeli' => 'required|string|max:255',
            'no_hp' => 'nullable|string|max:20',
            'total_jual' => 'required|numeric|min:0',
            'metode_bayar' => 'required|in:Cash,Transfer,Kartu Kredit,SpayLater,Akulaku,Kredivo,GopayLater',
            'bukti_bayar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status_bayar' => 'required|in:Lunas,Belum Lunas,Sebagian'
        ];
    }

    public function messages()
    {
        return [
            'kode_jual.unique' => 'Kode penjualan sudah digunakan',
            'tanggal_jual.required' => 'Tanggal penjualan wajib diisi',
            'nama_pembeli.required' => 'Nama pembeli wajib diisi',
            'total_jual.required' => 'Total penjualan wajib diisi',
            'metode_bayar.required' => 'Metode pembayaran wajib dipilih'
        ];
    }
}

class StorePenerimaanKasRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'kode_terimakas' => 'nullable|string|unique:penerimaan_kas,kode_terimakas',
            'id_jual' => 'required|exists:penjualans,id_jual',
            'tgl_terimakas' => 'required|date',
            'jmlh_terimakas' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string|max:500'
        ];
    }

    public function messages()
    {
        return [
            'kode_terimakas.unique' => 'Kode terima kas sudah digunakan',
            'id_jual.required' => 'Nomor penjualan wajib dipilih',
            'tgl_terimakas.required' => 'Tanggal penerimaan wajib diisi',
            'jmlh_terimakas.required' => 'Jumlah terima kas wajib diisi'
        ];
    }
}
