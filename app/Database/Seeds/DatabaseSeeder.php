<?php

namespace App\Database\Seeds;
use CodeIgniter\I18n\Time;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call('DirektorateSeeder');
        $this->call('DivisiSeeder');
        $this->call('DepartemenSeeder');
        $this->call('SectionHeadSeeder');
        $this->call('JabatanSeeder');
        $this->call('KaryawanSeeder');
    }
}