<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddWalletBalanceToUsers extends Migration
{
    public function up()
    {
        $db = \Config\Database::connect();
        
        // Vérifier si la colonne existe déjà
        if (!$db->fieldExists('wallet_balance', 'users')) {
            $this->forge->addColumn('users', [
                'wallet_balance' => [
                    'type'       => 'DECIMAL',
                    'constraint' => [10, 2],
                    'null'       => false,
                    'default'    => 0,
                    'after'      => 'gold_purchased_at',
                ],
            ]);
        }
    }

    public function down()
    {
        $this->forge->dropColumn('users', 'wallet_balance');
    }
}
