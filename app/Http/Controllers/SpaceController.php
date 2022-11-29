<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Space;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class SpaceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $spaces = Space::all();
        return view('space.index' , ['spaces'=>$spaces]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('space.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $space = new Space();
        $space->name = $request['space_name'];
        $space->max_students = $request['max_students'];
        $space->save();
        return redirect()->route('space.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Space  $space
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Space $space)
    {

        $reservations = Reservation::where('space_id', '=', $space->id)->orderBy('begin_time', 'asc')->paginate(2);
        return view('space.show', ['reservations' => $reservations, 'SpaceName' =>$space->name, 'MaxStudents' => $space->max_students]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Space  $space
     * @return Response
     */
    public function edit(Space $space)
    {
        $space = Space::find($space->id);
        return view('space.edit', ['space' => $space]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Space  $space
     * @return Response
     */
    public function update(Request $request, Space $space)
    {

        $space = Space::find($space->id);
        $space->name = $request['space_name'];
        $space->max_students = $request['max_students'];
        $space->update();
        return redirect()->route('space.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Space  $space
     * @return Response
     */
    public function destroy(Space $space, Request $request)
    {
        Space::destroy($space->id);
        return redirect()->route('space.index');
    }
}
