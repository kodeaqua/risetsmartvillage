@extends('layouts.material')

@include('components.map')

@section('content')
    {{-- <div class="card border-0 bg-primary-subtle rounded-pill p-5">Hehe</div> --}}

    <div class="px-5 py-2">
        <h1 class="fw-bold display-4">Kemang Smart Tourism</h1>
        <p class="fs-5">Geographically it is located in the northwestern part of Bogor Regency, with a distance of 23 km
            from the center of Bogor City (point taken from the mayor's office). Kemang District is part of Bogor Regency,
            West Java Province with an area of ​​33.61 km2, consisting of 8 villages and 1 sub-district. Below are the
            leading villages based on the Decision Support System.</p>
    </div>

    <div class="my-3"></div>

    <div class="px-5 py-4 ">


        <div class="d-flex flex-row flex-wrap justify-content-between align-items-center">
            @php
                for ($i = 0; $i < count($saw); $i++) {
                    if ($saw[$i][6] == 4) {
                        echo '<button class="btn border-0 btn-primary rounded-5 px-5 py-5 my-1 flex-grow-1 mx-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapse' .
                            $saw[$i][0] .
                            '"
                aria-expanded="false" aria-controls="collapseExample"><h3 class="fw-bold">' .
                            $saw[$i][0] .
                            '</h3>
                <h5>Smart Tourism index = ' .
                            $saw[$i][6] .
                            '</h5></button>';
                    }
                }
            @endphp
        </div>

        @php
            for ($i = 0; $i < count($saw); $i++) {
                if ($saw[$i][6] == 4) {
                    echo '<div class="collapse" id="collapse' .
                        $saw[$i][0] .
                        '">
        <div class="card card-body rounded-5 bg-dark-subtle border-0 m-3 px-5 py-5">
            <h1>' .
                        $saw[$i][0] .
                        '</h1>
            <p>' .
                        $saw[$i][1] .
                        '</p>
        </div>
    </div>';
                }
            }
        @endphp
    </div>


    <div class="my-5"></div>

    <div class="px-5 py-4">
        <h1 class="fw-bold display-4">Search the area</h1>
        <div class="py-2"></div>
        <div id="map" class="card rounded-5  border-3">
            <script>
                // const map = L.map('map').setView([-6.5029305, 106.7371722], 13);
                // const tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                //     maxZoom: 19,
                //     attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                // }).addTo(map);

                // const geojsonLayer = new L.GeoJSON.AJAX("{{ asset('assets/geojson/kemang.geojson') }}", {
                //     style: function (feature) {
                //         return {
                //             fillColor: feature.properties.Warna,
                //             fillOpacity: 0.5,
                //             color: 'black', 
                //             weight: 1
                //         };
                //     }
                // }).addTo(map);

                // var overlayMaps = {
                //     "Cities": cities
                // };

                const lokasi = L.layerGroup();

                /* Streets */
                const mbAttr =
                    'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>';
                const mbUrl =
                    'https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw';
                const streets = L.tileLayer(mbUrl, {
                    id: 'mapbox/streets-v11',
                    tileSize: 512,
                    zoomOffset: -1,
                    attribution: mbAttr
                });

                /* OSM */
                const osm = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                });

                /* ADM Kemang */
                const admkemang = new L.GeoJSON.AJAX("{{ asset('assets/geojson/kemang.geojson') }}");

                const map = L.map('map', {
                    center: [-6.5029305, 106.7371722],
                    zoom: 13,
                    layers: [osm, admkemang]
                });

                const baseLayers = {
                    'OpenStreetMap': osm,
                    'Streets': streets,
                };

                const overlays = {
                    'Kemang': admkemang,
                    'Lokasi': lokasi
                };

                const layerControl = L.control.layers(baseLayers, overlays).addTo(map);

                const satellite = L.tileLayer(mbUrl, {
                    id: 'mapbox/satellite-v9',
                    tileSize: 512,
                    zoomOffset: -1,
                    attribution: mbAttr
                });
                layerControl.addBaseLayer(satellite, 'Satellite');
            </script>

            @foreach ($spatials->get() as $key => $value)
                <script>
                    L.marker([{{ $value->latitude }}, {{ $value->longitude }}]).bindPopup('{{ $value->name }}').addTo(lokasi);
                </script>
            @endforeach
        </div>
    </div>

    <div class="px-5 py-4 mt-4">
        <h1 class="fw-bold display-4">or search data</h1>
        <div class="py-2"></div>
        <form action="{{ route('landing') }}" method="GET">
            @csrf
            <input type="search" name="search" class="card p-3 form-control rounded-4"
                placeholder="Search places like hotels or any else">
            @if (request('search'))
                <div class="d-flex flex-row align-items-baseline my-3">
                    <p>Showing {{ $spatials->count() }} results for <span
                            class="text-primary fw-bold">{{ request('search') }}</span></p>
                    <a class="btn bg-danger-subtle text-danger ms-3 rounded-pill fw-bold" href="{{ route('landing') }}">
                        Clear
                    </a>
                </div>
            @endif
        </form>

        <div class="list-group border-3 rounded-5 ">
            @foreach ($spatials->latest()->paginate(5) as $key => $value)
                <a class="list-group-item list-group-item-action px-5 py-3">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1 fw-bold">{{ $value->name }}</h5>
                    </div>
                    <p class="mb-1">ID {{ $value->id }} | {{ $value->category->name }} at {{ $value->area->name }}.
                        {{ $value->address }}</p>
                </a>
            @endforeach
        </div>
        <div class="py-2"></div>
        {{ $spatials->paginate(10)->links() }}
    </div>
@endsection
