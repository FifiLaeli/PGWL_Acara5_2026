@extends('layouts.template')

@section('styles')
<link rel="stylesheet"
    href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">

<style>
    body {
        margin: 0;
    }

    .card {
        margin-bottom: 20px;
    }

    .card-header {
        background-color: #8B5E3C;
        color: white;
    }
</style>
@endsection

@section('content')

<div class="container mt-4">

    {{-- ================= POINT ================= --}}
    <div class="card shadow-sm">
        <div class="card-header">
            <h4>Tabel Point</h4>
        </div>

        <div class="card-body">
            <table class="table table-bordered table-striped" id="table-point">

                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Deskripsi</th>
                        <th>Foto</th>
                        <th>Tanggal Dibuat</th>
                    </tr>
                </thead>

                <tbody>
                    @php $no = 1; @endphp

                    @foreach ($points as $p)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $p->name }}</td>
                        <td>{{ $p->description }}</td>

                        <td>
                            <img src="{{ asset('storage/images/' . $p->image) }}"
                                width="100">
                        </td>

                        <td>{{ $p->created_at }}</td>
                    </tr>
                    @endforeach

                </tbody>

            </table>
        </div>
    </div>

{{-- ================= POLYLINE ================= --}}
<div class="card shadow-sm">
    <div class="card-header">
        <h4>Tabel Polyline</h4>
    </div>

    <div class="card-body">
        <table class="table table-bordered table-striped" id="table-polyline">

            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Deskripsi</th>
                    <th>Foto</th>
                    <th>Tanggal Dibuat</th>
                </tr>
            </thead>

            <tbody>
                @php $no = 1; @endphp

                @foreach ($polylines as $pl)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $pl->name }}</td>
                    <td>{{ $pl->description }}</td>

                    <td>
                        <img src="{{ asset('storage/images/' . $pl->image) }}"
                            width="100">
                    </td>

                    <td>{{ $pl->created_at }}</td>
                </tr>
                @endforeach

            </tbody>

        </table>
    </div>
</div>


{{-- ================= POLYGON ================= --}}
<div class="card shadow-sm">
    <div class="card-header">
        <h4>Tabel Polygon</h4>
    </div>

    <div class="card-body">
        <table class="table table-bordered table-striped" id="table-polygon">

            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Deskripsi</th>
                    <th>Foto</th>
                    <th>Tanggal Dibuat</th>
                </tr>
            </thead>

            <tbody>
                @php $no = 1; @endphp

                @foreach ($polygons as $pg)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $pg->name }}</td>
                    <td>{{ $pg->description }}</td>

                    <td>
                        <img src="{{ asset('storage/images/' . $pg->image) }}"
                            width="100">
                    </td>

                    <td>{{ $pg->created_at }}</td>
                </tr>
                @endforeach

            </tbody>

        </table>
    </div>
</div>

</div>

@endsection


@section('scripts')

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function () {

        $('#table-point').DataTable();

        $('#table-polyline').DataTable();

        $('#table-polygon').DataTable();

    });
</script>

@endsection
