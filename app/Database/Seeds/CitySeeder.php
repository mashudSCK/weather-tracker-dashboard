<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CitySeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['city_name' => 'Isulan', 'country_code' => 'PH', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['city_name' => 'Davao City', 'country_code' => 'PH', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['city_name' => 'Manila', 'country_code' => 'PH', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['city_name' => 'Cebu City', 'country_code' => 'PH', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['city_name' => 'Cotabato City', 'country_code' => 'PH', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
        ];

        $this->db->table('cities')->insertBatch($data);
    }
}
