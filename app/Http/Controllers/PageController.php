<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// IMPORT MODEL
use App\Models\PointsModel;
use App\Models\PolylinesModel;
use App\Models\PolygonsModel;
use App\Models\User;

class PageController extends Controller
{

public function __construct()
{
    $this->points = new PointsModel();
    $this->polylines = new PolylinesModel();
    $this->polygons = new PolygonsModel();
    $this->users = new User();
}


public function landingpage()
    {
        $data = [
            'title' => 'PGWL',
            'points_count' => $this->points->count(),
            'polylines_count' => $this->polylines->count(),
            'polygons_count' => $this->polygons->count(),
            'users_count' => $this->users->count(),
        ];
        return view('home', $data);
    }

    public function peta()
    {
        $data = [
            'title' => 'Peta',
        ];
        return view('map', $data);
    }

    public function tabel()
{
    $data = [
        'title' => 'Tabel',
        'points' => $this->points->getAllPoints(),
        'polylines' => $this->polylines->all(),
        'polygons' => $this->polygons->all(),
    ];

    return view('table', $data);
}
}
