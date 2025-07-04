<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DiskonSeeder extends Seeder
{
    public function run()
    {
        $now = new \DateTime();
        for ($i = 0; $i < 10; $i++) {
            $tanggal = $now->format('Y-m-d');
            $data = [
                'tanggal'    => $tanggal,
                'nominal'    => rand(50000, 150000),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
            $this->db->table('diskon')->insert($data);
            $now->modify('+1 day');
        }
    }
}
