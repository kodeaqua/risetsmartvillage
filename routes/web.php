<?php

use App\Models\Area;
use App\Models\Spatial;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\RequestSpatial;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SpatialController;
use App\Http\Controllers\CategoryController;
use App\Models\SimpleAdditiveWeighting;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function (Request $request) {
    $spatials = Spatial::with('category', 'area')->where('is_deleted', false);

    if ($request->has('search')) {
        $spatials->where('name', 'LIKE', '%' . $request->search . '%');
    }

    $saw = SimpleAdditiveWeighting::showResult();

    return view('landing', compact('spatials', 'saw'));
})->name('landing');

Route::get('/request', function () {
    return view('request_form');
})->name('requestForm');

Route::post('/request/send', function (Request $request) {
    $data = $request->validate([
        'name' => ['required'],
        'description' => ['required'],
        'latlong' => ['required']
    ]);

    RequestSpatial::create([
        'spatial_id' => $request->spatial_id,
        'name' => $request->name,
        'description' => $request->description,
        'latlong' => $request->latlong
    ]);

    if ($data) {
        return redirect()->back()->with('success', 'Data berhasil masuk!');
    } else {
        return redirect()->back()->withInput()->withErrors($data);
    }
})->name('sendRequest');

Route::get('/research', function () {

    $categories = Category::where('is_deleted', false)->where('severity', 'very_high')->get();
    $saw = SimpleAdditiveWeighting::showResult();
    return view('research', compact('saw', 'categories'));
})->name('research');

Route::get('/about', function () {
    return view('about');
})->name('about');

Auth::routes();

// Route::get('/login', function () {
//     return abort(404);
// });

// Route::post('/login', function () {
//     return abort(404);
// });

// Route::put('/login', function () {
//     return abort(404);
// });

// Route::get('/register', function () {
//     return abort(404);
// });

// Route::post('/register', function () {
//     return abort(404);
// });



Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::resource('home/spatials', SpatialController::class)->middleware('auth');
Route::resource('master/areas', AreaController::class)->middleware('auth');
Route::resource('master/categories', CategoryController::class)->middleware('auth');
Route::get('home/overview', function (Request $request) {
    $spatials = Spatial::where('is_deleted', false)->paginate(200);
    $categories = Category::where('is_deleted', false)->where('severity', 'very_high')->get();
    $areas = Area::where('is_deleted', false)->get();
    return view('dashboard.overview', compact('spatials', 'categories', 'areas'));
})->middleware('auth')->name('overview');

Route::get('/test', function () {
    return view('test');
});

Route::get('/csv', function () {
    $filePath = 'assets/datasets/kemang.csv';
    $headers = [
        'Content-Type' => 'text/csv',
    ];
    return response()->download($filePath, 'kemang.csv', $headers);
});
