<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PointsModel extends Model
{
    protected $table = 'points';
    protected $fillable = ['name', 'description', 'image', 'geom'];
    public $timestamps = true;

    public function createPoint(array $data)
    {
        return DB::table($this->table)->insert([
            'name'        => $data['name'],
            'description' => $data['description'],
            'image'       => $data['image'] ?? null,
            'geom'        => DB::raw("ST_GeomFromText('" . $data['geom'] . "', 4326)"),
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);
    }

    public function getAllPoints()
    {
        return DB::table($this->table)
            ->select(
                'id',
                'name',
                'description',
                'image',
                'created_at',
                'updated_at',
                DB::raw('ST_AsGeoJSON(geom) as geom')
            )
            ->get();
    }

    public function geojson_points()
    {
        $points = $this->select(DB::raw(
            'id, ST_AsGeoJSON(geom) as geojson, name, description, image, created_at, updated_at'
        ))->get();

        $geojson = [
            'type'     => 'FeatureCollection',
            'features' => []
        ];

        foreach ($points as $p) {
            $feature = [
                'type'       => 'Feature',
                'geometry'   => json_decode($p->geojson),
                'properties' => [
                    'id'          => $p->id,
                    'name'        => $p->name,
                    'description' => $p->description,
                    'image'       => $p->image,
                    'created_at'  => $p->created_at,
                    'updated_at'  => $p->updated_at,
                ]
            ];

            array_push($geojson['features'], $feature);
        }

        return $geojson;
    }
}
