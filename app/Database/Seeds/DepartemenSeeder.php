<?php

namespace App\Database\Seeds;
use CodeIgniter\I18n\Time;

use CodeIgniter\Database\Seeder;

class DepartemenSeeder extends Seeder
{
    public function run()
    {
        $alphabet = range('A','Z');
        foreach(range(1,4) as $idx => $num){
            $departemen = [
                'divisi_id' => $num<=2 ? 1 : 2,
                'kode_departemen' => $alphabet[$idx],
                'nama_departemen' => "departemen $num",
                'created_at' => Time::now(),
                'updated_at' => Time::now()
            ];
            $this->db->table('departemen')->insert($departemen);
        }
    }
}