<?php

use App\Models\Spatial;
use Illuminate\Http\Request;
use Phpml\Preprocessing\Normalizer;
use Phpml\Classification\RandomForest;
use Illuminate\Support\Facades\Route;







/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/spasial', function (Request $request) {
    $spatials = Spatial::with('category', 'area');

    if ($request->has('search')) {
        $spatials->where('name', 'LIKE', '%' . $request->search . '%');
    }

    $request->has('paginate') ? $spatials = $spatials->paginate($request->paginate) : $spatials = $spatials->get();

    return response()->json([
        'spasial' => $spatials
    ]);
});