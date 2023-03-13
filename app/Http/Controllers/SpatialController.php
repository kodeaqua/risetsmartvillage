<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\Area;
use App\Models\Spatial;
use App\Models\Category;
use Illuminate\Http\Request;

class SpatialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $spatials = Spatial::where('is_deleted', false);
        $request->has('search') ? $spatials = $spatials->where('name', 'LIKE', '%' . $request->search . '%') : false;
        $spatials = $spatials->paginate(10);
        $categories = Category::where('is_deleted', false)->get();
        $areas = Area::where('is_deleted', false)->get();
        return view('dashboard.spatials', compact('spatials', 'areas', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => ['required'],
            'category_id' => ['required'],
            'address' => ['required'],
            'contact' => ['required'],
            'additional_description' => ['required'],
            'area_id' => ['required'],
            'latitude' => ['required'],
            'longitude' => ['required'],
        ]);

        if (!$validate) {
            return redirect()->back()->withErrors($validate);
        }

        Spatial::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'address' => $request->address,
            'contact' => $request->contact,
            'additional_description' => $request->additional_description,
            'area_id' => $request->area_id,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'is_village_mascot' => boolval($request->is_village_mascot) ? 1 : 0,
            'has_online_store' => boolval($request->has_online_store) ? 1 : 0,
            'has_smart_payment_support' => boolval($request->has_smart_payment_support) ? 1 : 0
        ]);

        return redirect()->back()->with('success', 'Successfully added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $spatial = Spatial::findOrFail($id);
            $spatial->update([
                'is_deleted' => true
            ]);
            return redirect()->back()->with('success', 'Successfully deleted');
        } catch (Throwable $th) {
            return redirect()->back()->withErrors($th);
        }
    }
}
