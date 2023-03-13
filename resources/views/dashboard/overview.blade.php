@extends('layouts.material')
@section('content')
<div class="px-5 py-2">
    <h1 class="fw-bold display-4 text-center">Statistik klasifikasi</h1>
    <p class="text-center">Mohon bersabar, halaman ini lambat dimuat karena banyak perhitungan di belakangnya.</p>
    <div class="py-2"></div>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Area</th>
                    @foreach ($categories as $key => $value)
                    <th scope="col">{{ $value->name }}</th>
                    @endforeach
                    <th scope="col">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($areas as $key => $value)
                <tr style="vertical-align: middle">
                    <th scope="row">{{ $spatials->firstItem() + $key }}</th>
                    <td>{{ $value->name }}</td>
                    @php
                    $total = 0;
                    @endphp

                    @foreach ($categories as $key => $subvalue)
                    <td>
                        @php
                        $usedvalue = 0;
                        $curr = 0;
                        @endphp

                        @foreach ($areas as $key => $subsubvalue)
                        @php
                        $i = $spatials
                        ->where('category_id', $subvalue->id)
                        ->where('area_id', $subsubvalue->id)
                        ->count();
                        if ($subvalue->severity == 'very_high' || $subvalue->severity == 'high' || $subvalue->severity
                        == 'normal') {
                        if ($i > $usedvalue) {
                        $usedvalue = $i;
                        }
                        } elseif ($subvalue->severity == 'low' || $subvalue->severity == 'no_effect') {
                        if ($i < $usedvalue) { $usedvalue=$i; } } $curr++; @endphp @endforeach @php $result=0.0; if
                            ($subvalue->severity == 'very_high' || $subvalue->severity == 'high' || $subvalue->severity
                            == 'normal') {
                            $result =$spatials->where('area_id', $value->id)->where('category_id',
                            $subvalue->id)->count() / $usedvalue;
                            } elseif ($subvalue->severity == 'low' || $subvalue->severity == 'no_effect') {
                            if ($usedvalue > 0) {
                            $result = $usedvalue / $spatials->where('area_id', $value->id)->where('category_id',
                            $subvalue->id)->count();
                            }
                            }
                            @endphp
                            @if ($result)
                            @php
                            $total = $total + $result;
                            @endphp
                            {{ $result }}
                            @else
                            0
                            @endif
                    </td>
                    @endforeach
                    <td>
                        {{ $total }}
                        @if($total == 4)
                        {{ "(Sangat berpotensi)" }}
                        @elseif($total >= 3)
                        {{ "(Berpotensi)" }}
                        @elseif($total >= 2)
                        {{ "(Sedikit berpotensi)" }}
                        @elseif($total >= 1)
                        {{ "(Tidak berpotensi)" }}
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $spatials->links() }}
</div>
@endsection