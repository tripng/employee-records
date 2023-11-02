<?php

namespace App\Database\Seeds;
use CodeIgniter\I18n\Time;

use CodeIgniter\Database\Seeder;

class SectionHeadSeeder extends Seeder
{
    public function run()
    {
        $alphabet = range('A','Z');
        $count = 1;
        $dep = 1;
        foreach(range(1,16) as $idx => $num){
            if($num==9){
                $count = 1;
                $dep = 1;
            }
            $section_head = [
                'departemen_id' => $count%2===0?$dep++:$dep,
                'kode_section_head' => $alphabet[$count-1],
                'kode_staff' => $num>8 ? $alphabet[$count-1] : null,
                'created_at' => Time::now(),
                'updated_at' => Time::now()
            ];
            $this->db->table('section_head')->insert($section_head);
            $count++;
        }
    }
}