<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kontak_Perusahaan;
use App\Models\Profil_Perusahaan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KontakSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $profil = [
            [
                'id_profil_perusahaan' => 'satu',
                'deskripsi' => 'tes',
                'alamat' => 'tes',
                'foto' => 'tes',
            ],
        ];

        $kontak = [
            [
                'id_kontak_perusahaan' => 'satu',
                'instagram' => 'tes',
                'whatsapp' => '0867234234234',
                'email' => 'admin@gmail.com',
                'facebook' => 'tes',
            ],
        ];

        Profil_Perusahaan::insert($profil);
        Kontak_Perusahaan::insert($kontak);
    }
}
