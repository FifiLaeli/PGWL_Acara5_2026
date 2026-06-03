@extends('layouts.template')

@section('styles')
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <!-- Leaflet Draw CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
        }

        #map {
            height: 90vh;
            width: 100%;
        }
    </style>
@endsection

@section('content')
    <div id="map"></div>

    <!-- Modal Form Edit -->
    <div class="modal" tabindex="-1" id="modalEdit">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Edit Polyline</h5>
                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>

                <form action="{{ route('polylines.update', ['id' => $polyline->id]) }}"
                      method="POST"
                      enctype="multipart/form-data">

                    @csrf
                    @method('PATCH')

                    <div class="modal-body">

                        <!-- Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label">
                                Name
                            </label>

                            <input type="text"
                                   class="form-control"
                                   id="name"
                                   name="name"
                                   value="{{ $polyline->name }}"
                                   placeholder="Fill Name">
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label for="description" class="form-label">
                                Description
                            </label>

                            <textarea class="form-control"
                                      id="description"
                                      name="description"
                                      rows="3">{{ $polyline->description }}</textarea>
                        </div>

                        <!-- Geometry -->
                        <div class="mb-3">
                            <label for="geometry_polyline"
                                   class="form-label">
                                Geometry
                            </label>

                            <textarea class="form-control"
                                      id="geometry_polyline"
                                      name="geometry_polyline"
                                      rows="3">{{ $polyline->geom }}</textarea>
                        </div>

                        <!-- Image -->
                        <div class="mb-3">
                            <label for="image" class="form-label">
                                Image
                            </label>

                            <input class="form-control"
                                   type="file"
                                   id="image"
                                   name="image"
                                   onchange="
                                        document.getElementById('preview-image').src =
                                        window.URL.createObjectURL(this.files[0])
                                   ">

                            <img src="{{ asset('storage/images/' . $polyline->image) }}"
                                 alt=""
                                 id="preview-image"
                                 class="img-thumbnail mt-2"
                                 width="400">
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button"
                                class="btn btn-secondary"
                                data-bs-dismiss="modal">
                            Close
                        </button>

                        <button type="submit"
                                class="btn btn-primary">
                            Save
                        </button>
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

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>

        /*
        |--------------------------------------------------------------------------
        | Initialize Map
        |--------------------------------------------------------------------------
        */

        var map = L.map('map').setView([-7.7956, 110.3695], 13);

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap'
        }).addTo(map);

        /*
        |--------------------------------------------------------------------------
        | Feature Group
        |--------------------------------------------------------------------------
        */

        var drawnItems = new L.FeatureGroup();
        map.addLayer(drawnItems);

        /*
        |--------------------------------------------------------------------------
        | Draw Control
        |--------------------------------------------------------------------------
        */

            var drawControl = new L.Control.Draw({
            draw: false,
            edit: {
                featureGroup: drawnItems,
                poly: {
                    allowIntersection: false
                },
                remove: false
            }
        });

        map.addControl(drawControl);

        /*
        |--------------------------------------------------------------------------
        | Draw Edited Event
        |--------------------------------------------------------------------------
        */

        map.on('draw:edited', function(e) {

            var layers = e.layers;

            layers.eachLayer(function(layer) {

                var drawnJSONObject = layer.toGeoJSON();

                console.log(drawnJSONObject);

                var objectGeometry =
                    Terraformer.geojsonToWKT(drawnJSONObject.geometry);

                console.log(objectGeometry);

                var properties = drawnJSONObject.properties;

                console.log(properties);

                $('#name').val(properties.name);

                $('#description').val(properties.description);

                $('#geometry_polyline').val(objectGeometry);

                $('#preview-image').attr(
                    'src',
                    "{{ asset('storage/images/') }}/" + properties.image
                );

                var modalEdit = new bootstrap.Modal(
                    document.getElementById('modalEdit'),
                    {
                        keyboard: false
                    }
                );

                modalEdit.show();

            });

        });

        /*
|--------------------------------------------------------------------------
| Load GeoJSON Polyline
|--------------------------------------------------------------------------
*/

$.getJSON("{{ route('geojson.polyline', $id) }}", function(data) {

    var geojsonLayer = L.geoJSON(data, {

        onEachFeature: function(feature, layer) {

            // masukkan ke editable feature group
            drawnItems.addLayer(layer);

            var properties = feature.properties;

            var objectGeometry =
                Terraformer.geojsonToWKT(feature.geometry);

            layer.on({

                click: function(e) {

                    $('#name').val(properties.name);

                    $('#description').val(properties.description);

                    $('#geometry_polyline').val(objectGeometry);

                    $('#preview-image').attr(
                        'src',
                        "{{ asset('storage/images/') }}/" +
                        properties.image
                    );

                    var modalEdit = new bootstrap.Modal(
                        document.getElementById('modalEdit'),
                        {
                            keyboard: false
                        }
                    );

                    modalEdit.show();

                }

            });

        }

    });

    map.addLayer(geojsonLayer);

});

    </script>

@endsection
