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
        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'geometry_point' => 'required|string',
            'description'    => 'required|string',
            'image'          => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // buat folder jika belum ada
        if (!is_dir(public_path('storage/images'))) {
            mkdir(public_path('storage/images'), 0777, true);
        }

        // upload gambar
        if ($request->hasFile('image')) {

            $image = $request->file('image');

            $name_image = time() . "_point." .
                strtolower($image->getClientOriginalExtension());

            $image->move(public_path('storage/images'), $name_image);

        } else {

            $name_image = null;
        }

        // simpan data
        $data = [
            'name'        => $validated['name'],
            'geom'        => $validated['geometry_point'],
            'description' => $validated['description'],
            'image'       => $name_image,
        ];

        $saved = $this->points->create($data);

        if ($saved) {
            return redirect()->route('peta')
                ->with('success', 'Point berhasil ditambahkan!');
        }

        return redirect()->route('peta')
            ->with('error', 'Gagal menambahkan point!');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $data = [
            'title' => 'Edit Point',
            'id'    => $id,
            'point' => $this->points->find($id),
        ];

        return view('map-EDIT-POINT', $data);
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'geometry_point' => 'required|string',
            'description'    => 'required|string',
            'image'          => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $point = $this->points->find($id);

        if (!$point) {
            return redirect()->route('peta')
                ->with('error', 'Data point tidak ditemukan!');
        }

        // upload gambar baru
        if ($request->hasFile('image')) {

            // hapus gambar lama
            if (
                $point->image &&
                file_exists(public_path('storage/images/' . $point->image))
            ) {
                unlink(public_path('storage/images/' . $point->image));
            }

            $image = $request->file('image');

            $name_image = time() . "_point." .
                strtolower($image->getClientOriginalExtension());

            $image->move(public_path('storage/images'), $name_image);

        } else {

            $name_image = $point->image;
        }

        // update data
        $data = [
            'name'        => $validated['name'],
            'geom'        => $validated['geometry_point'],
            'description' => $validated['description'],
            'image'       => $name_image,
        ];

        $updated = $this->points
            ->where('id', $id)
            ->update($data);

        if ($updated) {
            return redirect()->route('peta')
                ->with('success', 'Point berhasil diupdate!');
        }

        return redirect()->route('peta')
            ->with('error', 'Gagal mengupdate point!');
    }

    public function destroy(string $id)
    {
        $point = $this->points->find($id);

        if (!$point) {
            return redirect()->route('peta')
                ->with('error', 'Data point tidak ditemukan!');
        }

        $image = $point->image;

        if ($this->points->destroy($id)) {

            // hapus gambar
            if (
                $image &&
                file_exists(public_path('storage/images/' . $image))
            ) {
                unlink(public_path('storage/images/' . $image));
            }

            return redirect()->route('peta')
                ->with('success', 'Point berhasil dihapus!');
        }

        return redirect()->route('peta')
            ->with('error', 'Gagal menghapus point!');
    }
}
