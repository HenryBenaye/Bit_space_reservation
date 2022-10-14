<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Space;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    private $route;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reservations = Reservation::all();
        return view('reservation.index',['reservations' => $reservations]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $spaces = Space::all();
        return view('reservation.create', ['spaces' => $spaces]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {

        $user = User::find(Auth::user()->id);
        $space = Space::where('name', $request['space_name'])->first();
        $begin_time = strtotime($request['begin_time']);
        $end_time = strtotime($request['end_time']);
        $time_diff = round(abs($begin_time- $end_time )/ 60,2);

        // Controles uitvoeren of de gebruiker juiste data heeft ingevoerd
        if ($time_diff < 15 || $time_diff > 60)
        {
            return redirect()->back()->withErrors(['msg' => 'Je moet minimaal 15 minuten reserveren of je hebt meer dan een uur gereserveerd']);
        }
        if($user->reservations === 5) {
            return redirect()->back()->withErrors(['msg' => 'Je hebt al 5 reserveringen']);
        }
        if($space->max_students - $space->reserved_students <= 0)
        {
            return redirect()->back()->withErrors(['msg' => 'Ruimte is vol']);
        }

        $user->reservations++;
        $space->reserved_students++;
        $user->save();

        $reservation = new Reservation();
        $reservation->user_id= Auth::user()->id;
        $reservation->space_id = $space->id;
        $reservation->begin_time = date('H:i:s',$begin_time);
        $reservation->end_time = date('H:i:s',$end_time);
        $reservation->save();
        $this->route = redirect()->route('dashboard');
        return $this->route;


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function show(Reservation $reservation)
    {
        $reservations = Reservation::where('user_id', '=', Auth::user()->id)->get();
        return view('dashboard', ['reservations' => $reservations]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function edit(Reservation $reservation)
    {
        $reservation = Reservation::find($reservation->id);
        $spaces = Space::all();
        return view('reservation.edit', ['reservation' => $reservation, 'spaces' => $spaces]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reservation $reservation)
    {
        $reservation = Reservation::find($reservation->id);
        $reservation->space_id = Space::where('name', $request['space_name'])->first()->id;
        $reservation->user_id= Auth::user()->id;
        $reservation->begin_time = date('H:i:s',strtotime($request['begin_time']));
        $reservation->end_time = date('H:i:s',strtotime($request['end_time']));
        $reservation->update();
        return redirect()->route('dashboard');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reservation $reservation)
    {
        $user = User::find(Auth::user()->id);
        $user->reservations--;
        $user->save();
        Reservation::destroy($reservation->id);
        return redirect()->route('dashboard');
    }
}
