<?php

namespace Database\Seeders;

use App\Models\Produk;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dataProduk = [
            [
                'nama_produk'=> 'Vit',
                'harga'=> 3000,
                'stok'=> 10,
                'foto'=> 'default.png',
                'desc'=> 'minuman air mineral saingan le mineral',
                'id_kategori'=> 2,
            ],
            [
                'nama_produk'=> 'Mie Yamin',
                'harga'=> 12000,
                'stok'=> 10,
                'foto'=> 'default.png',
                'desc'=> 'mie pake yamin',
                'id_kategori'=> 1,
            ],
            ];
            foreach($dataProduk as $key => $val){
                Produk::create($val);
            }
    }
}
