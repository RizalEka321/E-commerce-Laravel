<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = [
            [
                'nama_lengkap' => 'Rizal Eka Budi Pratama',
                'username' => 'admin',
                'role' => 'Pemilik',
                'email' => 'admin@gmail.com',
                'alamat' => 'Gurit RT001 RW001, Desa Pengatigan, Kecamatan Rogojampi',
                'no_hp' => '085936155999',
                'foto' => 'fotonya',
                'password' => bcrypt('admin'),
            ],
            [
                'nama_lengkap' => 'Farhan',
                'username' => 'pembeli',
                'role' => 'Pembeli',
                'email' => 'Rizal@gmail.com',
                'alamat' => 'Gurit RT001 RW001, Desa Pengatigan, Kecamatan Rogojampi',
                'no_hp' => '085936155999',
                'foto' => 'fotonya',
                'password' => bcrypt('pembeli'),
            ],
        ];

        User::insert($user);
    }
}
