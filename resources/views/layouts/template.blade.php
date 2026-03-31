<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Peta</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    @yield('styles')

</head>

<body>

    @include('components.navbar')

    @yield('content')

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

@yield('scripts')

@include('components.toast')

</body>
</html>
