<?php

namespace App\Http\Controllers;

use App\Models\PointsModel;
use Illuminate\Http\Request;

class PointController extends Controller
{
    protected $points;

    public function __construct()
    {
        $this->points = new PointsModel();
    }

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {

         // Validasi input
        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'geometry_point' => 'required|string',
            'description'    => 'required|string',
            'image'          => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'name.required'           => 'Nama point wajib diisi.',
            'name.max'                => 'Nama point tidak boleh lebih dari 255 karakter.',
            'name.string'             => 'Nama point harus berupa teks.',
            'geometry_point.required' => 'Geometri point wajib diisi.',
            'description.required'    => 'Deskripsi point wajib diisi.',
            'description.string'      => 'Deskripsi harus berupa teks.',
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
        $name_image = time() . "_point." . strtolower($image->getClientOriginalExtension());
        $image->move('storage/images', $name_image);
        } else {
        $name_image = null;
        }

        $data = [
            'name'        => $validated['name'],
            'geom'        => $validated['geometry_point'],
            'description' => $validated['description'],
            'image'       => $name_image,
        ];

        // Simpan ke database
        $saved = $this->points->create($data);

        if ($saved) {
            return redirect()->route('peta')->with('success', 'Point berhasil ditambahkan!');
        }

        return redirect()->route('peta')->with('error', 'Gagal menambahkan point!');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
