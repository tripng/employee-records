<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class SectionHead extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'auto_increment' => true
            ],
            'departemen_id' => [
                'type' => 'INT',
            ],
            'kode_section_head' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'kode_staff' =>[
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
            ],
            // 'nama_section_head' => [
            //     'type' => 'VARCHAR',
            //     'constraint' => 255,
            // ],
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
        $this->forge->addForeignKey('departemen_id','departemen','id','CASCADE','CASCADE');
        $this->forge->createTable('section_head',TRUE);
    }
    public function down()
    {
        $this->forge->dropTable('section_head');
    }
}
