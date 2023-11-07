<?php

namespace App\Database\Seeds;
use CodeIgniter\I18n\Time;

use CodeIgniter\Database\Seeder;

class DirektorateSeeder extends Seeder
{
    public function run()
    {
        $direktorate = [
            'kode_direktorate' => 'A',
            'nama_direktorate' => "direktur",
            'created_at' => Time::now(),
            'updated_at' => Time::now()
        ];
        $this->db->table('direktorate')->insert($direktorate);
    }
}