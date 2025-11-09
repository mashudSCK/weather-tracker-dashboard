<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateWeatherLogsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'city_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'temperature' => [
                'type' => 'DECIMAL',
                'constraint' => '5,2',
            ],
            'feels_like' => [
                'type' => 'DECIMAL',
                'constraint' => '5,2',
                'null' => true,
            ],
            'humidity' => [
                'type' => 'INT',
                'constraint' => 3,
                'null' => true,
            ],
            'condition' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'description' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'wind_speed' => [
                'type' => 'DECIMAL',
                'constraint' => '5,2',
                'null' => true,
            ],
            'fetched_at' => [
                'type' => 'DATETIME',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('city_id', 'cities', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('weather_logs');
    }

    public function down()
    {
        $this->forge->dropTable('weather_logs');
    }
}
