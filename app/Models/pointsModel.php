<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class pointsModel extends Model
{
    protected $table = 'points';
    protected $fillable = ['name', 'description', 'geom'];
    public $timestamps = false;

    public function createPoint(array $data)
    {
        return DB::table($this->table)->insert([
            'name'        => $data['name'],
            'description' => $data['description'],
            'geom'        => DB::raw("ST_GeomFromText('" . $data['geom'] . "', 4326)")
        ]);
    }

    public function getAllPoints()
    {
        return DB::table($this->table)
            ->select('id', 'name', 'description', DB::raw('ST_AsGeoJSON(geom) as geom'))
            ->get();
    }
}
