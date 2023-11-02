<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Departemen extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'auto_increment' => true
            ],
            'divisi_id' => [
                'type' => 'INT',
            ],
            'kode_departemen' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'nama_departemen' => [
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
        $this->forge->addForeignKey('divisi_id','divisi','id','CASCADE','CASCADE');
        $this->forge->createTable('departemen',TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('departemen');
    }
}
