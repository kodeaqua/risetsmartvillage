@extends('layouts.material')
@section('content')
    <div class="px-3 py-2">
        <h1 class="fw-bold display-4">Simple Additive Weighting</h1>
        <p class="fs-5">Allows the system to make a decision based on data.</p>
        <p class="text-muted">*Real-time feature, it depends on data.</p>
        <div class="table-responsive card p-3 rounded-5 border-3">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Area</th>
                        @foreach ($categories as $key => $value)
                            <th scope="col">{{ $value->name }}</th>
                        @endforeach
                        <th scope="col">Total</th>
                        <th scope="col">Description</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        for ($i = 0; $i < count($saw); $i++) {
                            echo '<tr>';
                            for ($j = 0; $j < count($saw[$i]); $j++) {
                                if ($j != 1) {
                                    echo '<td>' . $saw[$i][$j] . '</td>';
                                }
                            }
                            echo '</tr>';
                        }
                    @endphp
                </tbody>
            </table>
        </div>
    </div>
    <div class="my-3"></div>
    <div class="px-3 py-2">
        <h1 class="fw-bold display-4">Classification</h1>

        <p class="fs-5">Classification using Random Forest vs some other classification methods.</p>
        <p class="text-muted">*Not a real-time feature, it based on researcher (using Python and Orange Data Mining).</p>

        <div class="table-responsive card p-3 rounded-5 border-3">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Model</th>
                        <th scope="col">AUC</th>
                        <th scope="col">CA</th>
                        <th scope="col">F1</th>
                        <th scope="col">Precision</th>
                        <th scope="col">Recall</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <th scope="row">Random Forest</th>
                        <td>1.000</td>
                        <td>1.000</td>
                        <td>1.000</td>
                        <td>1.000</td>
                        <td>1.000</td>
                    </tr>
                    <tr>
                        <th scope="row">Tree</th>
                        <td>0.857</td>
                        <td>0.778</td>
                        <td>0.796</td>
                        <td>0.889</td>
                        <td>0.778</td>
                    </tr>
                    <tr>
                        <th scope="row">Naive Bayes</th>
                        <td>0.929</td>
                        <td>0.778</td>
                        <td>0.796</td>
                        <td>0.889</td>
                        <td>0.778</td>
                    </tr>
                    <tr>
                        <th scope="row">k-Nearest Neighbour</th>
                        <td>0.571</td>
                        <td>0.778</td>
                        <td>0.681</td>
                        <td>0.605</td>
                        <td>0.778</td>
                    </tr>
                    <tr>
                        <th scope="row">Support Vector Machine</th>
                        <td>1.000</td>
                        <td>1.000</td>
                        <td>1.000</td>
                        <td>1.000</td>
                        <td>1.000</td>
                    </tr>
                    <tr>
                        <th scope="row">Neural Network</th>
                        <td>1.000</td>
                        <td>1.000</td>
                        <td>1.000</td>
                        <td>1.000</td>
                        <td>1.000</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="my-3"></div>

        <div class="card bg-white rounded-5 border-3 p-3">
            <script src="https://gist.github.com/kodeaqua/0ef6fd83e78b8b67eda2e672fab7e175.js"></script>
        </div>
    </div>
@endsection
