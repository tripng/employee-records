<?php

namespace App\Database\Seeds;
use CodeIgniter\I18n\Time;

use CodeIgniter\Database\Seeder;

class DivisiSeeder extends Seeder
{
    public function run()
    {
        $alphabet = range('A','Z');
        foreach(range(1,2) as $idx => $num){
            // $direktorate_id = $num>1 ? array_rand(range(1,2)) : 1;
            $divisi = [
                'direktorate_id' => 1,
                'kode_divisi' => $alphabet[$idx],
                'nama_divisi' => "divisi ".$num,
                'created_at' => Time::now(),
                'updated_at' => Time::now()
            ];
            $this->db->table('divisi')->insert($divisi);
        }
    }
}