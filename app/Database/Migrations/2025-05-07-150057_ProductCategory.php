<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\BaseConnection;

class ProductCategory extends Migration
{
    public function up()
    {
        // Buat koneksi database manual
        $db = \Config\Database::connect();

        // Cek apakah tabel sudah ada
        if ($db->tableExists('product_category')) {
            return; // Skip jika sudah ada
        }

        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'category_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('product_category');
    }

    public function down()
    {
        $this->forge->dropTable('product_category');
    }
}
