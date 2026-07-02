<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kategori;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategoris = [
            'Elektronik',
            'Fashion',
            'Makanan & Minuman',
            'Peralatan Rumah Tangga',
            'Kecantikan',
            'Olahraga',
            'Buku & Alat Tulis',
            'Mainan',
        ];

        foreach ($kategoris as $kategori) {
            Kategori::create([
                'nama_kategori' => $kategori,
            ]);
        }
    }
}
