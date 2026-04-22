<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class APIController extends Controller
{
    public function __construct()
    {
        $this->points = new \App\Models\pointsModel();
        $this->polylines = new \App\Models\polylinesModel();
        $this->polygons = new \App\Models\polygonsModel();
    }

    public function getPoints()
    {
        $points=$this->points->geojson_points();
        return response()->json($points, 200, [], JSON_NUMERIC_CHECK);
    }

    public function getPolylines()
    {
        $polylines=$this->polylines->geojson_polylines();
        return response()->json($polylines, 200, [], JSON_NUMERIC_CHECK);
    }

    public function getPolygons()
    {
        $polygons=$this->polygons->geojson_polygons();
        return response()->json($polygons, 200, [], JSON_NUMERIC_CHECK);
    }
}
