<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Jabatan extends Migration
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
                'null' => true,
            ],
            'divisi_id' => [
                'type' => 'INT',
                'null' => true,
            ],
            'departemen_id' => [
                'type' => 'INT',
                'null' => true,
            ],
            'section_head_id' => [
                'type' => 'INT',
                'null' => true,
            ],
            'kode_jabatan' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'hirarki' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'nama_jabatan' => [
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
        $this->forge->addForeignKey('divisi_id','divisi','id','CASCADE','CASCADE');
        $this->forge->addForeignKey('departemen_id','departemen','id','CASCADE','CASCADE');
        $this->forge->createTable('jabatan',TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('jabatan');
    }
}
