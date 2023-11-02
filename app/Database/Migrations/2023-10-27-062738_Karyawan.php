<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Karyawan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'auto_increment' => true
            ],
            'jabatan_id' => [
                'type' => 'INT',
            ],
            'nik' => [
                'type' => 'VARCHAR',
                'constraint' => 16,
            ],
            'nama' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => TRUE,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => TRUE,
            ]
        ]);
        $this->forge->addKey('id',true);
        $this->forge->addForeignKey('jabatan_id','jabatan','id','CASCADE','CASCADE');
        $this->forge->createTable('karyawan',TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('karyawan');
    }
}
