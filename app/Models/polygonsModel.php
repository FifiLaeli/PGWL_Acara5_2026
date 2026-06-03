<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PolygonsModel extends Model
{
    protected $table  = 'polygon';
    protected $guarded = ['id'];

    // -------------------------------------------------------
    // GeoJSON — semua polygon
    // -------------------------------------------------------
    public function geojson_polygons()
    {
        $rows = $this->select(DB::raw(
            'id, ST_AsGeoJSON(geom) as geojson, name, description, image, created_at, updated_at'
        ))->get();

        $geojson = [
            'type'     => 'FeatureCollection',
            'features' => []
        ];

        foreach ($rows as $p) {
            $geojson['features'][] = [
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
        }

        return $geojson;
    }

    // -------------------------------------------------------
    // GeoJSON — satu polygon by id
    // -------------------------------------------------------
    public function geojson_polygon($id)
    {
        $p = $this->select(DB::raw(
            'id, ST_AsGeoJSON(geom) as geojson, name, description, image, created_at, updated_at'
        ))->where('id', $id)->first();

        if (!$p) return null;

        return [
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
    }

    // -------------------------------------------------------
    // Store polygon baru
    // -------------------------------------------------------
    public function storePolygon($name, $description, $geometry, $image)
    {
        return DB::statement("
            INSERT INTO polygon (name, description, geom, image, created_at, updated_at)
            VALUES (?, ?, ST_GeomFromText(?, 4326), ?, NOW(), NOW())
        ", [$name, $description, $geometry, $image]);
    }

    // -------------------------------------------------------
    // Update polygon by id
    // -------------------------------------------------------
    public function updatePolygon($id, $name, $description, $geometry, $image)
    {
        return DB::statement("
            UPDATE polygon
            SET name        = ?,
                description = ?,
                geom        = ST_GeomFromText(?, 4326),
                image       = ?,
                updated_at  = NOW()
            WHERE id = ?
        ", [$name, $description, $geometry, $image, $id]);
    }
}
