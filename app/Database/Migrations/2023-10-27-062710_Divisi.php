<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Divisi extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'auto_increment' => true
            ],
            'direktorate_id' => [
                'type' => 'INT',
            ],
            'kode_divisi' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'nama_divisi' => [
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
        $this->forge->addForeignKey('direktorate_id','direktorate','id','CASCADE','CASCADE');
        $this->forge->createTable('divisi',TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('divisi');
    }
}
