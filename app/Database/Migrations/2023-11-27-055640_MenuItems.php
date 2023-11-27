<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\RawSql;
use CodeIgniter\Database\Migration;

class MenuItems extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true
            ],
            'restaurant_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true
            ],
            'nama' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'price' => [
                'type' => 'DOUBLE',
            ],
            'created_at' => [
                'type'    => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('restaurant_id', 'restaurant', 'id', 'CASCADE', 'SET NULL');
        $this->forge->createTable('menu_items');
    }

    public function down()
    {
        $this->forge->dropForeignKey('menu_items', 'menu_items_restaurant_id_foreign');
        $this->forge->dropTable('menu_items');
    }
}
