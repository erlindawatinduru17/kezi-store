<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Produk;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $produks = [
            // Elektronik (ID 1)
            [
                'nama_produk' => 'Headphone Wireless',
                'harga' => 299000,
                'stok' => 50,
                'id_kategori' => 1,
            ],
            [
                'nama_produk' => 'USB Type-C Cable',
                'harga' => 49000,
                'stok' => 100,
                'id_kategori' => 1,
            ],
            [
                'nama_produk' => 'Power Bank 10000mAh',
                'harga' => 199000,
                'stok' => 30,
                'id_kategori' => 1,
            ],

            // Fashion (ID 2)
            [
                'nama_produk' => 'T-Shirt Pria',
                'harga' => 89000,
                'stok' => 150,
                'id_kategori' => 2,
            ],
            [
                'nama_produk' => 'Celana Jeans',
                'harga' => 249000,
                'stok' => 80,
                'id_kategori' => 2,
            ],
            [
                'nama_produk' => 'Jaket Hoodie',
                'harga' => 199000,
                'stok' => 45,
                'id_kategori' => 2,
            ],

            // Makanan & Minuman (ID 3)
            [
                'nama_produk' => 'Kopi Arabika 1kg',
                'harga' => 149000,
                'stok' => 60,
                'id_kategori' => 3,
            ],
            [
                'nama_produk' => 'Teh Premium Kotak',
                'harga' => 29000,
                'stok' => 200,
                'id_kategori' => 3,
            ],
            [
                'nama_produk' => 'Coklat Impor 100g',
                'harga' => 79000,
                'stok' => 40,
                'id_kategori' => 3,
            ],

            // Peralatan Rumah Tangga (ID 4)
            [
                'nama_produk' => 'Sapu Ijuk',
                'harga' => 39000,
                'stok' => 120,
                'id_kategori' => 4,
            ],
            [
                'nama_produk' => 'Ember Plastik 10L',
                'harga' => 49000,
                'stok' => 90,
                'id_kategori' => 4,
            ],
            [
                'nama_produk' => 'Lampu LED 12W',
                'harga' => 99000,
                'stok' => 75,
                'id_kategori' => 4,
            ],

            // Kecantikan (ID 5)
            [
                'nama_produk' => 'Face Wash 100ml',
                'harga' => 59000,
                'stok' => 100,
                'id_kategori' => 5,
            ],
            [
                'nama_produk' => 'Moisturizer SPF 30',
                'harga' => 149000,
                'stok' => 50,
                'id_kategori' => 5,
            ],
            [
                'nama_produk' => 'Lipstik Matte',
                'harga' => 99000,
                'stok' => 60,
                'id_kategori' => 5,
            ],

            // Olahraga (ID 6)
            [
                'nama_produk' => 'Raket Tenis',
                'harga' => 399000,
                'stok' => 20,
                'id_kategori' => 6,
            ],
            [
                'nama_produk' => 'Bola Basket Resmi',
                'harga' => 189000,
                'stok' => 35,
                'id_kategori' => 6,
            ],
            [
                'nama_produk' => 'Sepatu Olahraga',
                'harga' => 449000,
                'stok' => 40,
                'id_kategori' => 6,
            ],

            // Buku & Alat Tulis (ID 7)
            [
                'nama_produk' => 'Buku Tulis 80 Halaman',
                'harga' => 19000,
                'stok' => 300,
                'id_kategori' => 7,
            ],
            [
                'nama_produk' => 'Pensil Standar Box 12',
                'harga' => 29000,
                'stok' => 150,
                'id_kategori' => 7,
            ],
            [
                'nama_produk' => 'Novel Populer',
                'harga' => 89000,
                'stok' => 55,
                'id_kategori' => 7,
            ],

            // Mainan (ID 8)
            [
                'nama_produk' => 'Mobil Remote Control',
                'harga' => 199000,
                'stok' => 35,
                'id_kategori' => 8,
            ],
            [
                'nama_produk' => 'Boneka Beruang',
                'harga' => 79000,
                'stok' => 50,
                'id_kategori' => 8,
            ],
            [
                'nama_produk' => 'Lego Building Set',
                'harga' => 259000,
                'stok' => 25,
                'id_kategori' => 8,
            ],
        ];

        foreach ($produks as $produk) {
            Produk::create($produk);
        }
    }
}
