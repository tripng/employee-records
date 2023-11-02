<?php

namespace App\Database\Seeds;
use CodeIgniter\I18n\Time;

use CodeIgniter\Database\Seeder;

class KaryawanSeeder extends Seeder
{
    public function run()
    {
        foreach (range(1,23) as $key => $value) {
            $karyawan = [
                'jabatan_id' => $value,
                'nik' => random_int(111111111,999999999),
                'nama' => "Karyawan $value",
                'created_at' => Time::now(),
                'updated_at' => Time::now()
            ];
            $this->db->table('karyawan')->insert($karyawan);
        }
    }
}