<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PointsModel;
use App\Models\PolylinesModel;
use App\Models\PolygonsModel;

class APIController extends Controller
{
    protected $points;
    protected $polylines;
    protected $polygons;

    public function __construct()
    {
        $this->points = new PointsModel();
        $this->polylines = new PolylinesModel();
        $this->polygons = new PolygonsModel();
    }

    public function getPoints()
    {
        $points = $this->points->geojson_points();
        return response()->json($points, 200, [], JSON_NUMERIC_CHECK);
    }

    public function geojson_point($id)
    {
        $point = $this->points->geojson_point($id);
        return response()->json($point, 200, [], JSON_NUMERIC_CHECK);
    }

    public function getPolylines()
    {
        $polylines = $this->polylines->geojson_polylines();
        return response()->json($polylines, 200, [], JSON_NUMERIC_CHECK);
    }

      public function geojson_polyline($id)
    {
        $polyline = $this->polylines->geojson_polyline($id);
        return response()->json($polyline, 200, [], JSON_NUMERIC_CHECK);
    }

    public function getPolygons()
    {
        $polygons = $this->polygons->geojson_polygons();
        return response()->json($polygons, 200, [], JSON_NUMERIC_CHECK);
    }

    public function geojson_polygon($id)
    {
        $polygon = $this->polygons->geojson_polygon($id);
        return response()->json($polygon, 200, [], JSON_NUMERIC_CHECK);
    }

}
