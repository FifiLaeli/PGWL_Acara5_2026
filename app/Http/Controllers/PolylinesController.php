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
            'image'          => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'name.required'              => 'Nama polyline wajib diisi.',
            'name.max'                   => 'Nama polyline tidak boleh lebih dari 255 karakter.',
            'name.string'                => 'Nama polyline harus berupa teks.',
            'geometry_polyline.required' => 'Geometri polyline wajib diisi.',
            'description.required'       => 'Deskripsi polyline wajib diisi.',
            'description.string'         => 'Deskripsi harus berupa teks.',
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
        $name_image = time() . "_polyline." . strtolower($image->getClientOriginalExtension());
        $image->move('storage/images', $name_image);
        } else {
        $name_image = null;
        }

        $data = [
            'name'        => $validated['name'],
            'geom'        => $validated['geometry_polyline'],
            'description' => $validated['description'],
            'image'       => $name_image,
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

         $data = [
            'title' => 'Edit Polyline',
            'id'    => $id,
            'polyline' => $this->polylines->find($id),
        ];

        return view('map-edit-polylines', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //validasi input
         $validated = $request->validate([
        'name'              => 'required|string|max:255',
        'geometry_polyline' => 'required|string',
        'description'       => 'required|string',
        'image'             => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);
            $point = $this->polylines->find($id);

        if (!$point) {
            return redirect()->route('peta')
                ->with('error', 'Data polyline tidak ditemukan!');
        }

        if ($request->hasFile('image')) {

            // hapus gambar lama
            if (
                $point->image &&
                file_exists(public_path('storage/images/' . $point->image))
            ) {
                unlink(public_path('storage/images/' . $point->image));
            }

            $image = $request->file('image');

            $name_image = time() . "_polyline." .
                strtolower($image->getClientOriginalExtension());

            $image->move(public_path('storage/images'), $name_image);

        } else {

            $name_image = $point->image;
        }

        $data = [
            'name'        => $validated['name'],
            'geom'        => $validated['geometry_polyline'],
            'description' => $validated['description'],
            'image'       => $name_image,
        ];

        $updated = $this->polylines
            ->where('id', $id)
            ->update($data);

        if ($updated) {
            return redirect()->route('peta')
                ->with('success', 'Polyline berhasil diupdate!');
        }

        return redirect()->route('peta')
            ->with('error', 'Gagal mengupdate polyline!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Cari data polyline
        $polyline = $this->polylines->find($id);

        if (!$polyline) {
            return redirect()->route('peta')
                ->with('error', 'Data polyline tidak ditemukan!');
        }

        $image = $polyline->image;

        // Hapus data polyline
        if ($this->polylines->destroy($id)) {

            // Hapus file gambar jika ada
            if ($image !== null && file_exists(public_path('storage/images/' . $image))) {
                unlink(public_path('storage/images/' . $image));
            }

            return redirect()->route('peta')
                ->with('success', 'Polyline berhasil dihapus!');
        }

        return redirect()->route('peta')
            ->with('error', 'Gagal menghapus polyline!');
    }
}
