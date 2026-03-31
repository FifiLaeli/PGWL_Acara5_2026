<?php

namespace App\Http\Controllers;

use App\Models\polylinesModel;
use Illuminate\Http\Request;

class PolylinesController extends Controller
{
    public function __construct()
    {
        $this->polylines = new polylinesModel();

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
          $validated = $request->validate([
            'name'              => 'required|string|max:255',
            'geometry_polyline' => 'required|string',
            'description'       => 'required|string',
        ], [
            'name.required'              => 'Nama polyline wajib diisi.',
            'name.max'                   => 'Nama polyline tidak boleh lebih dari 255 karakter.',
            'name.string'                => 'Nama polyline harus berupa teks.',
            'geometry_polyline.required' => 'Geometri polyline wajib diisi.',
            'description.required'       => 'Deskripsi polyline wajib diisi.',
            'description.string'         => 'Deskripsi harus berupa teks.',
        ]);

        $data = [
            'name'        => $validated['name'],
            'geom'        => $validated['geometry_polyline'],
            'description' => $validated['description'],
        ];

        $saved = $this->polylines->create($data);

        if ($saved) {
            return redirect()->route('peta')->with('success', 'Polyline berhasil ditambahkan!');
        }

        return redirect()->route('peta')->with('error', 'Gagal menambahkan polyline!');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
