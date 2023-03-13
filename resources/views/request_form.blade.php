@extends('layouts.material')

@include('components.map')

@section('content')
    <div class="px-5 py-2">
        <h1 class="fw-bold display-4">Pengajuan</h1>
        <div class="py-2"></div>
        <p class="fs-5">Ajukan apabila terjadi kesalahan dalam pendataan maupun belum terdata</p>
    </div>

    @if (session('success'))
        <div class="py-4 alert alert-success border-0 rounded-5 text-center" role="alert">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="py-4 alert alert-danger border-0 rounded-5 text-center" role="alert">
            {{ $errors->first() }}
        </div>
    @endif

    <div class="px-5 py-4 card rounded-5">
        <form action="{{ route('sendRequest') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="idCheck" class="form-label">ID</label>
                <input type="text" class="form-control rounded-pill" id="idCheck" name="spatial_id"
                    aria-describedby="idCheckHelp">
                <div id="idCheckHelp" class="form-text">Kolom ini ditujukan bagi data yang salah. Silakan cek ID di halaman
                    utama. Cari usaha Anda, kemudian sentuh untuk melihat ID.</div>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Nama pengaju (Wajib)</label>
                <input type="text" class="form-control rounded-pill" id="name" name="name"
                    aria-describedby="nameHelp" required>
                <div id="nameHelp" class="form-text">Isi nama Anda. Anda bertanggungjawab penuh.</div>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi Pengajuan (Wajib)</label>
                <input type="text" class="form-control rounded-pill" id="description" name="description"
                    aria-describedby="descriptionHelp" required>
                <div id="descriptionHelp" class="form-text">Uraikan apa yang ingin Anda ajukan (Misal: terjadi kesalahan,
                    atau
                    belum terdata. Kemudian berikan rincian seperti alamat dan lainnya).</div>
            </div>

            <div class="mb-3">
                <div id="map" class="card border-0 rounded-5">
                    <script>
                        const map = L.map('map').setView([-6.5029305, 106.7371722], 13);
                        const tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            maxZoom: 19,
                            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                        }).addTo(map);
                        const geojsonlayer = new L.GeoJSON.AJAX("{{ asset('assets/geojson/kemang.geojson') }}").addTo(map);
                        map.on('click', function(e) {
                            document.getElementById("latlong").value = e.latlng;
                        });
                    </script>
                </div>
                <div class="my-3"></div>
                <label for="latlong" class="form-label">Latitude dan Longitude (Wajib)</label>
                <input type="text" class="form-control rounded-pill" id="latlong" name="latlong"
                    aria-describedby="latlongHelp" required>
                <div id="latlongHelp" class="form-text">Isi koordinat tempat yang sesuai. Klik pada peta agar otomatis
                    terisi
                </div>
            </div>
            <div class="d-grid gap-2 mt-4">
                <button type="submit"
                    class="btn btn-primary border-0 py-3 rounded-pill fw-bold">Kirim</button>
            </div>

        </form>
    </div>
@endsection
