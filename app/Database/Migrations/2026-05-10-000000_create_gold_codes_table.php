<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateGoldCodesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'auto_increment' => true,
            ],
            'code' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'unique' => true,
            ],
            'duree_jours' => [
                'type' => 'INT',
                'default' => 30,
            ],
            'utilise' => [
                'type' => 'BOOLEAN',
                'default' => false,
            ],
            'utilisateur_id' => [
                'type' => 'INT',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('utilisateur_id', 'users', 'id', '', 'CASCADE');
        $this->forge->createTable('gold_codes', true);
    }

    public function down()
    {
        $this->forge->dropTable('gold_codes', true);
    }
}
