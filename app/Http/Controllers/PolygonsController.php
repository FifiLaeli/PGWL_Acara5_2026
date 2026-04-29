<?php

namespace App\Http\Controllers;

use App\Models\polygonsModel;
use Illuminate\Http\Request;

class PolygonsController extends Controller
{
    //Fungsi untuk menghubungkan dengan model polygonsModel
    public function __construct()
    {
        $this->polygons = new polygonsModel();

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
            'name'             => 'required|string|max:255',
            'geometry_polygon' => 'required|string',
            'description'      => 'required|string',
            'image'          => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'name.required'             => 'Nama polygon wajib diisi.',
            'name.max'                  => 'Nama polygon tidak boleh lebih dari 255 karakter.',
            'name.string'               => 'Nama polygon harus berupa teks.',
            'geometry_polygon.required' => 'Geometri polygon wajib diisi.',
            'description.required'      => 'Deskripsi polygon wajib diisi.',
            'description.string'        => 'Deskripsi harus berupa teks.',
            'image.image'             => 'File yang diunggah harus berupa gambar.',
            'image.mimes'             => 'Format gambar yang diizinkan adalah: jpeg, png, jpg, gif.',
            'image.max'               => 'Ukuran gambar tidak boleh lebih dari 2MB.',
        ]);

         // Pastikan direktori penyimpanan gambar ada
        if (!is_dir('storage/images')) {
            mkdir('./storage/images', 0777);
            }

        // Simpan gambar jika ada
        if ($request->hasFile('image')) {
        $image = $request->file('image');
        $name_image = time() . "_polygon." . strtolower($image->getClientOriginalExtension());
        $image->move('storage/images', $name_image);
        } else {
        $name_image = null;
        }

        $data = [
            'name'        => $validated['name'],
            'geom'        => $validated['geometry_polygon'],
            'description' => $validated['description'],
            'image'       => $name_image,
        ];

        $saved = $this->polygons->create($data);

        if ($saved) {
            return redirect()->route('peta')->with('success', 'Polygon berhasil ditambahkan!');
        }

        return redirect()->route('peta')->with('error', 'Gagal menambahkan polygon!');
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
