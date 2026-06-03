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
                    <h5 class="modal-title">Edit Polygon</h5>

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>

                <form action="{{ route('polygons.update', ['id' => $polygon->id]) }}"
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
                                   value="{{ $polygon->name }}"
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
                                      rows="3">{{ $polygon->description }}</textarea>
                        </div>

                        <!-- Geometry -->
                        <div class="mb-3">
                            <label for="geometry_polygon"
                                   class="form-label">
                                Geometry
                            </label>

                            <textarea class="form-control"
                                      id="geometry_polygon"
                                      name="geometry_polygon"
                                      rows="3">{{ $polygon->geom }}</textarea>
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

                            <img src="{{ asset('storage/images/' . $polygon->image) }}"
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
                edit: true,
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

                $('#geometry_polygon').val(objectGeometry);

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
        | GeoJSON Polygon
        |--------------------------------------------------------------------------
        */

        var polygons = L.geoJSON(null, {

            style: function(feature) {
                return {
                    color: 'blue',
                    weight: 3,
                    fillOpacity: 0.5
                };
            },

            onEachFeature: function(feature, layer) {

                drawnItems.addLayer(layer);

                var properties = feature.properties;

                var objectGeometry =
                    Terraformer.geojsonToWKT(feature.geometry);

                layer.on({

                    click: function(e) {

                        $('#name').val(properties.name);

                        $('#description').val(properties.description);

                        $('#geometry_polygon').val(objectGeometry);

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

        /*
        |--------------------------------------------------------------------------
        | Load GeoJSON
        |--------------------------------------------------------------------------
        */

        $.getJSON("{{ route('geojson.polygon', $id) }}", function(data) {

            polygons.addData(data);

            map.addLayer(polygons);

        });

    </script>

@endsection
