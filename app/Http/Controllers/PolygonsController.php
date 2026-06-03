<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PolygonsModel;
use Illuminate\Support\Facades\Storage;

class PolygonsController extends Controller
{
    protected $polygons;

    public function __construct()
    {
        $this->polygons = new PolygonsModel();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'             => 'required|string|max:255',
            'description'      => 'nullable|string',
            'geometry_polygon' => 'required|string',
            'image'            => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $imageName = null;
        if ($request->hasFile('image')) {
            $stored    = $request->file('image')->store('images', 'public');
            $imageName = basename($stored);
        }

        $this->polygons->storePolygon(
            $request->name,
            $request->description,
            $request->geometry_polygon,
            $imageName
        );

        return redirect()->route('peta')->with('success', 'Polygon berhasil disimpan.');
    }

    public function edit($id)
{
    $polygon = PolygonsModel::findOrFail($id);

    $data = [
        'polygon' => $polygon,
        'id'      => $id,
    ];

        return view('map-edit-polygons', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'             => 'required|string|max:255',
            'description'      => 'nullable|string',
            'geometry_polygon' => 'required|string',
            'image'            => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $polygon   = PolygonsModel::findOrFail($id);
        $imageName = $polygon->image;

        if ($request->hasFile('image')) {
            // Hapus gambar lama
            if ($imageName && Storage::disk('public')->exists('images/' . $imageName)) {
                Storage::disk('public')->delete('images/' . $imageName);
            }
            $stored    = $request->file('image')->store('images', 'public');
            $imageName = basename($stored);
        }

        $this->polygons->updatePolygon(
            $id,
            $request->name,
            $request->description,
            $request->geometry_polygon,
            $imageName
        );

        return redirect()->route('peta')->with('success', 'Polygon berhasil diupdate.');
    }

    public function destroy($id)
    {
        $polygon = PolygonsModel::findOrFail($id);

        if ($polygon->image && Storage::disk('public')->exists('images/' . $polygon->image)) {
            Storage::disk('public')->delete('images/' . $polygon->image);
        }

        $polygon->delete();

        return redirect()->back()->with('success', 'Polygon berhasil dihapus.');
    }
}
