<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Direktorate extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
				'type' => 'INT',
				'auto_increment' => true,
			],
            'kode_direktorate' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => false,
            ], 
            'nama_direktorate' => [
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
        $this->forge->createTable('direktorate',TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('direktorate');
    }
}
