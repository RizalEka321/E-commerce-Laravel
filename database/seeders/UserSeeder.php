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
                'username' => 'pemilik321',
                'role' => 'Pemilik',
                'email' => 'admin@gmail.com',
                'alamat' => 'Gurit RT001 RW001, Desa Pengatigan, Kecamatan Rogojampi',
                'no_hp' => '085936155999',
                'foto' => 'fotonya',
                'password' => bcrypt('Pemilik321'),
                'email_verified_at' => now()
            ],
            [
                'nama_lengkap' => 'Pratama',
                'username' => 'pegawai321',
                'role' => 'Pegawai',
                'email' => 'Rio@gmail.com',
                'alamat' => 'Gurit RT001 RW001, Desa Pengatigan, Kecamatan Rogojampi',
                'no_hp' => '085936155999',
                'foto' => null,
                'password' => bcrypt('Pegawai321'),
                'email_verified_at' => now()
            ],
            [
                'nama_lengkap' => 'Farhan',
                'username' => 'pembeli321',
                'role' => 'Pembeli',
                'email' => 'Rizal@gmail.com',
                'alamat' => 'Gurit RT001 RW001, Desa Pengatigan, Kecamatan Rogojampi',
                'no_hp' => '085936155999',
                'foto' => null,
                'password' => bcrypt('Pembeli321'),
                'email_verified_at' => now()
            ],
        ];

        User::insert($user);
    }
}
