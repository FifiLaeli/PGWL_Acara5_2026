@extends('layouts.template')

@section('styles')
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>

    <!-- Leaflet Draw CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css">

    <style>
        body{
            margin:0;
            padding:0;
        }

        #map{
            height:90vh;
            width:100%;
        }

        .navbar{
            box-shadow:0 2px 5px rgba(0,0,0,0.2);
        }
    </style>

@endsection

@section('content')

<div id="map"></div>

<!-- Modal Form Input Polygon -->
<div class="modal" tabindex="-1" id="inputPolygonModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Input Polygon</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('polygons.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">

          <div class="mb-3">
            <label for="polygon_name" class="form-label">Name</label>
            <input type="text" class="form-control" id="polygon_name" name="name" placeholder="Fill Name of Polygon">
          </div>

          <div class="mb-3">
            <label for="polygon_description" class="form-label">Description</label>
            <textarea class="form-control" id="polygon_description" name="description" rows="3"></textarea>
          </div>

          <div class="mb-3">
            <label for="geometry_polygon" class="form-label">Geometry Polygon</label>
            <textarea class="form-control" id="geometry_polygon" name="geometry_polygon" rows="3" readonly></textarea>
          </div>

          <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <input class="form-control" type="file" id="Image" name="image"
            onchange="document.getElementById('preview-image-polygon').src = window.URL.createObjectURL(this.files[0])">
            <img src="" alt="" id="preview-image-polygon" class="img-thumbnail" width="400">
          </div>


        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>


<!-- Modal Form Input Polyline -->
<div class="modal" tabindex="-1" id="inputPolylineModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Input Polyline</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('polylines.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">

          <div class="mb-3">
            <label for="polyline_name" class="form-label">Name</label>
            <input type="text" class="form-control" id="polyline_name" name="name" placeholder="Fill Name of Polyline">
          </div>

          <div class="mb-3">
            <label for="polyline_description" class="form-label">Description</label>
            <textarea class="form-control" id="polyline_description" name="description" rows="3"></textarea>
          </div>

          <div class="mb-3">
            <label for="geometry_polyline" class="form-label">Geometry Polyline</label>
            <textarea class="form-control" id="geometry_polyline" name="geometry_polyline" rows="3" readonly></textarea>
          </div>

          <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <input class="form-control" type="file" id="Image" name="image"
            onchange="document.getElementById('preview-image-polyline').src = window.URL.createObjectURL(this.files[0])">
            <img src="" alt="" id="preview-image-polyline" class="img-thumbnail" width="400">
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Form Input Point -->
<div class="modal" tabindex="-1" id="inputPointModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Input Point</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('points.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">

          <div class="mb-3">
            <label for="point_name" class="form-label">Name</label>
            <input type="text" class="form-control" id="point_name" name="name" placeholder="Fill Name of Point">
          </div>

          <div class="mb-3">
            <label for="point_description" class="form-label">Description</label>
            <textarea class="form-control" id="point_description" name="description" rows="3"></textarea>
          </div>

          <div class="mb-3">
            <label for="geometry_point" class="form-label">Geometry Point</label>
            <textarea class="form-control" id="geometry_point" name="geometry_point" rows="3" readonly></textarea>
          </div>

         <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <input class="form-control" type="file" id="Image" name="image"
            onchange="document.getElementById('preview-image-point').src = window.URL.createObjectURL(this.files[0])">

            <img src="" alt="" id="preview-image-point" class="img-thumbnail" width="400">
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection

@section('scripts')

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<!-- Leaflet Draw JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></script>

<!-- Terraformer JS -->
<script src="https://unpkg.com/@terraformer/wkt"></script>

<!-- JQuery JS -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
    var map = L.map('map').setView([-7.7956, 110.3695], 13);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap'
    }).addTo(map);

    /* Digitize Function */
    var drawnItems = new L.FeatureGroup();
    map.addLayer(drawnItems);

    var drawControl = new L.Control.Draw({
        draw: {
            position: 'topleft',
            polyline: true,
            polygon: true,
            rectangle: true,
            circle: false,
            marker: true,
            circlemarker: false
        },
        edit: false
    });

    map.addControl(drawControl);

    map.on('draw:created', function(e) {
        var type = e.layerType,
            layer = e.layer;

        console.log(type);

        var drawnJSONObject = layer.toGeoJSON();
        var objectGeometry = Terraformer.geojsonToWKT(drawnJSONObject.geometry);

        console.log(drawnJSONObject);
        console.log(objectGeometry);

        if (type === 'polyline') {
            console.log("Create " + type);

            // Set value ke textarea geometry_polyline
            $('#geometry_polyline').val(objectGeometry);

            // Tampilkan Modal Form Input Polyline
            $('#inputPolylineModal').modal('show');

            // Event saat modal ditutup, reload halaman
            $('#inputPolylineModal').off('hidden.bs.modal').on('hidden.bs.modal', function () {
                location.reload();
            });

        } else if (type === 'polygon' || type === 'rectangle') {
            console.log("Create " + type);
            // Tambahkan modal polygon/rectangle di sini jika diperlukan
            // Set value ke textarea geometry_polygon
            $('#geometry_polygon').val(objectGeometry);

            // Tampilkan Modal Form Input Polygon
            $('#inputPolygonModal').modal('show');

            // Event saat modal ditutup, reload halaman
            $('#inputPolygonModal').off('hidden.bs.modal').on('hidden.bs.modal', function () {
                location.reload();
            });

        } else if (type === 'marker') {
            console.log("Create " + type);

            // Set value ke textarea geometry_point
            $('#geometry_point').val(objectGeometry);

            // Tampilkan Modal Form Input Point
            $('#inputPointModal').modal('show');

            // Event saat modal ditutup, reload halaman
            $('#inputPointModal').off('hidden.bs.modal').on('hidden.bs.modal', function () {
                location.reload();
            });

        } else {
            console.log('__undefined__');
        }

        drawnItems.addLayer(layer);
    });

// Points Layer
var pointsLayer = L.geoJSON(null, {
    onEachFeature: function (feature, layer) {
        var popup_content = "Nama: " + feature.properties.name + "<br>" +
                            "Deskripsi: " + feature.properties.description + "<br>" +
                            "Dibuat: " + feature.properties.created_at + "<br>" +
                            (feature.properties.image ? "<img src='http://localhost:8000/storage/images/" + feature.properties.image + "' alt='Image Point' class='img-thumbnail' width='400'>" : "");
        layer.bindPopup(popup_content);
    }
});

// Polyline Layer
var polylinesLayer = L.geoJSON(null, {
    onEachFeature: function (feature, layer) {
        var popup_content = "Nama: " + feature.properties.name + "<br>" +
                            "Deskripsi: " + feature.properties.description + "<br>" +
                            "Dibuat: " + feature.properties.created_at + "<br>"+
                            (feature.properties.image ? "<img src='http://localhost:8000/storage/images/" + feature.properties.image + "' alt='Image Polyline' class='img-thumbnail' width='400'>" : "");
        layer.bindPopup(popup_content);
    }
});

// Polygon Layer
var polygonsLayer = L.geoJSON(null, {
    onEachFeature: function (feature, layer) {
        var popup_content = "Nama: " + feature.properties.name + "<br>" +
                            "Deskripsi: " + feature.properties.description + "<br>" +
                            "Dibuat: " + feature.properties.created_at + "<br>"+
                            (feature.properties.image ? "<img src='http://localhost:8000/storage/images/" + feature.properties.image + "' alt='Image Polygon' class='img-thumbnail' width='400'>" : "");
        layer.bindPopup(popup_content);
    }
});

$.getJSON("http://localhost:8000/api/points", function (data) {
    pointsLayer.addData(data);
    map.addLayer(pointsLayer);
});

$.getJSON("http://localhost:8000/api/polylines", function (data) {
    polylinesLayer.addData(data);
    map.addLayer(polylinesLayer);
});

$.getJSON("http://localhost:8000/api/polygons", function (data) {
    polygonsLayer.addData(data);
    map.addLayer(polygonsLayer);
});

// Basemap Layers
var osm = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; OpenStreetMap'
});

var satellite = L.tileLayer('https://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', {
    maxZoom: 20,
    subdomains:['mt0','mt1','mt2','mt3'],
    attribution: '&copy; Google Satellite'
});

var hybrid = L.tileLayer('https://{s}.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
    maxZoom: 20,
    subdomains:['mt0','mt1','mt2','mt3'],
    attribution: '&copy; Google Hybrid'
});

var terrain = L.tileLayer('https://{s}.google.com/vt/lyrs=p&x={x}&y={y}&z={z}', {
    maxZoom: 20,
    subdomains:['mt0','mt1','mt2','mt3'],
    attribution: '&copy; Google Terrain'
});

// Control Layer
var baseMaps = {
    "OpenStreetMap": osm,
    "Satellite": satellite,
    "Hybrid": hybrid,
    "Terrain": terrain
};


var overlayMaps = {
	"Points": pointsLayer,
	"Polylines": polylinesLayer,
	"Polygons": polygonsLayer
};

var controllayer = L.control.layers(baseMaps, overlayMaps);
controllayer.addTo(map);

</script>

@endsection
