<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\Area;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $areas = Area::where('is_deleted', false);
        $request->has('search') ? $areas = $areas->where('name', 'LIKE', '%' . $areas->search . '%') : false;
        $areas = $areas->paginate(10);
        return view('dashboard.areas', compact('areas'));
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
            'name' => ['required', 'string', 'max:32'],
        ]);

        if (!$validate) {
            return redirect()->back()->withErrors($validate);
        }

        Area::create([
            'name' => $request->name,
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
        $area = Area::findOrFail($id);
        if ($area->name != $request->name && $request->name != "") {
            $area->update([
                'name' => $request->name
            ]);
        }

        if ($area) {
            return redirect()->back()->with('success', 'Successfully updated');
        } else {
            return redirect()->back()->withInput()->withErrors($area);
        }
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
            $area = Area::findOrFail($id);
            $area->update([
                'is_deleted' => true
            ]);
            return redirect()->back()->with('success', 'Successfully deleted');
        } catch (Throwable $th) {
            return redirect()->back()->withErrors($th);
        }
    }
}
