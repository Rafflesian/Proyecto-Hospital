<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

use App\Enums\StatusTypes;

class StartInforme extends Migration
{
    public function up()
    {
        //
        $this->forge->addField([
            'id' => [
                'type'              => 'INTEGER',
                'unsigned'          => true,
                'auto_increment'    => true,
            ],
            'id_paciente' => [
                'type' => 'INTEGER',
                'unsigned' => true,
            ],
            'id_emisor' => [
                'type' => 'INTEGER',
                'unsigned' => true,
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => 128,
            ],
            'motivo' => [
                'type' => 'VARCHAR',
                'constraint' => 128,
            ],
            'hallazgos' => [
                'type' => 'VARCHAR',
                'constraint' => 128,
            ],
            'diagnosis' => [
                'type' => 'TEXT'
            ],
            'tratamiento' => [
                'type' => 'TEXT'
            ],
            'recomendaciones' => [
                'type' => 'TEXT'
            ],
            'observaciones' => [
                'type' => 'TEXT'
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => array_column(StatusTypes::cases(), 'value')
            ]
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('id_paciente', 'personas', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->addForeignKey('id_emisor', 'personas', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('informes', true);
    }

    public function down()
    {
        //
        $this->forge->dropTable('informes');
    }
}
