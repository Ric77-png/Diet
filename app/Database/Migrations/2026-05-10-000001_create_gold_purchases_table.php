<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateGoldPurchasesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'auto_increment' => true,
            ],
            'user_id' => [
                'type' => 'INT',
                'null' => false,
            ],
            'montant' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => false,
            ],
            'statut' => [
                'type' => 'ENUM',
                'constraint' => ['en_attente', 'approuve', 'rejete'],
                'default' => 'en_attente',
            ],
            'code_gold_id' => [
                'type' => 'INT',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP'),
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('user_id', 'users', 'id', '', 'CASCADE');
        $this->forge->addForeignKey('code_gold_id', 'gold_codes', 'id', '', 'SET NULL');
        $this->forge->createTable('gold_purchases', true);
    }

    public function down()
    {
        $this->forge->dropTable('gold_purchases', true);
    }
}
