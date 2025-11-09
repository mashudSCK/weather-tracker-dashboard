<?php

namespace App\Models;

use CodeIgniter\Model;

class WeatherModel extends Model
{
    protected $table            = 'weather_logs';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['city_id', 'temperature', 'feels_like', 'humidity', 'condition', 'description', 'wind_speed', 'fetched_at'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = '';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules = [
        'city_id'     => 'required|is_natural_no_zero',
        'temperature' => 'required|decimal',
        'condition'   => 'required|min_length[2]|max_length[100]',
    ];
    
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function getLatestWeatherByCity($cityId)
    {
        return $this->where('city_id', $cityId)
                    ->orderBy('fetched_at', 'DESC')
                    ->first();
    }

    public function getWeatherHistory($cityId, $limit = 10)
    {
        return $this->where('city_id', $cityId)
                    ->orderBy('fetched_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    public function getAllCitiesLatestWeather()
    {
        return $this->select('weather_logs.*, cities.city_name, cities.country_code')
                    ->join('cities', 'cities.id = weather_logs.city_id')
                    ->groupBy('weather_logs.city_id')
                    ->orderBy('weather_logs.fetched_at', 'DESC')
                    ->findAll();
    }
}
