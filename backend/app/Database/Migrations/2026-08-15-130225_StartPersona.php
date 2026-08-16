<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

use App\Enums\BloodType;
use App\Enums\Gender;
use App\Enums\Citizenship;
use App\Enums\IdentifierTypes;

class StartPersona extends Migration
{
    public function up()
    {
        //
        //
        $this->forge->addField([
            'id' => [
                'type'              => 'INTEGER',
                'unsigned'          => true,
                'auto_increment'    => true,
            ],
            'tipo_documento' => [
                'type'=> 'ENUM',
                'constraint' => array_column(IdentifierTypes::cases(), 'value')
            ],
            'nro_documento' => [
                'type' => 'VARCHAR',
                'constraint' => 64
            ],
            'email' => [
                'type'              => 'VARCHAR',
                'constraint'        => '128',
                'null'              => true,
                'unique'            => true,
            ],
            'telefono' => [
                'type' => 'VARCHAR',
                'constraint' => '32',
                'null'=> true,
            ],
            'nombre' => [
                'type'              => 'VARCHAR',
                'constraint'        => '64',
            ],
            'apellido_paterno' => [
                'type'              => 'VARCHAR',
                'constraint'        => '64',
            ],
            'apellido_materno' => [
                'type'              => 'VARCHAR',
                'constraint'        => '64',
            ],
            'direccion' => [
                'type' => 'VARCHAR',
                'constraint' => '128',
                'null' => true,
            ],

            'nacionalidad' => [
                'type' => 'ENUM',
                'constraint' => array_column(Citizenship::cases(), 'value')
            ],
            'sexo' => [
                'type' => 'ENUM',
                'constraint' => array_column(Gender::cases(), 'value'),
            ],
            'g_sangre' => [
                'type' => 'ENUM',
                'constraint' => array_column(BloodType::cases(), 'value'),
                'null'  => true,
            ]
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey(['tipo_documento', 'nro_documento']);

        $this->forge->createTable('personas', true);
    }

    public function down()
    {
        //
        $this->forge->dropTable('personas');
    }
}
