<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\RawSql;
use CodeIgniter\Database\Migration;

class Reservation extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true
            ],
            'in_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ],
            'restaurant_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true
            ],
            'date' => [
                'type' => 'DATE',
            ],
            'time' => [
                'type' => 'TIME',
            ],
            'num_guest' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'created_at' => [
                'type'    => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'SET NULL');
        $this->forge->addForeignKey('restaurant_id', 'restaurant', 'id', 'CASCADE', 'SET NULL');
        $this->forge->createTable('reservation');
    }

    public function down()
    {
        $this->forge->dropForeignKey('reservation', 'reservation_user_id_foreign');
        $this->forge->dropForeignKey('reservation', 'reservation_restaurant_id_foreign');
        $this->forge->dropTable('reservation');
    }
}
