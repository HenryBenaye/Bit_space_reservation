<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReservationRequest;
use App\Models\Reservation;
use App\Models\Space;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
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
     * @param StoreReservationRequest $request
     * @return RedirectResponse
     */
    public function store(StoreReservationRequest $request)
    {


        $user = User::find(Auth::user()->id);
        $space = Space::where('name', $request['space_name'])->first();

        $begin_time = Carbon::create(0,0,0,$request['begin_time_hour'],$request['begin_time_minute']);
        $end_time = Carbon::create(0,0,0,$request['end_time_hour'],$request['end_time_minute']);

        return $this->data_check($user,$space,$begin_time,$end_time);
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
        $reservation->begin_time = Carbon::create(0,0,0,$request['begin_time_hour'],$request['begin_time_minute']);
        $reservation->end_time =  Carbon::create(0,0,0,$request['end_time_hour'],$request['end_time_minute']);
        $this->data_check(User::find(Auth::user()->id), Space::where('name', $request['space_name'])->first(),$reservation->begin_time,$reservation->end_time,$reservation->update());
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
        $space = Space::find($reservation->space_id);
        $user->reservations--;
        $space->reserved_students--;
        $space->save();
        $user->save();
        Reservation::destroy($reservation->id);
        return redirect()->route('dashboard');
    }

    private function data_check($user,$space, $begin_time, $end_time, $type )
    {


        $user->reservations++;
        $space->reserved_students++;
        $space->save();
        $user->save();

        $reservation = new Reservation();
        $reservation->user_id= Auth::user()->id;
        $reservation->space_id = $space->id;
        $reservation->begin_time = $begin_time->format('H:i');
        $reservation->end_time = $end_time->format('H:i');
        $reservation->save();
        $type;
        $this->route = redirect()->route('dashboard');
        return $this->route;

    }
}
