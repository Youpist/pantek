<?php

namespace Database\Seeders;

use App\Models\Wallet;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class WalletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dataWallet = [
            [
                'rekening'=> '123456789',
                'id_user'=> 1,
                'saldo'=> 100000,
                'status'=> 'aktif',
            ],
            [
                'rekening'=> '987654321',
                'id_user'=> 2,
                'saldo'=> 100000,
                'status'=> 'aktif',
            ],
            [
                'rekening'=> '678912345',
                'id_user'=> 3,
                'saldo'=> 100000,
                'status'=> 'aktif',
            ],
            [
                'rekening'=> '543216789',
                'id_user'=> 4,
                'saldo'=> 100000,
                'status'=> 'aktif',
            ],
            ];
            foreach($dataWallet as $key => $val){
                Wallet::create($val);
            }
    }
}
