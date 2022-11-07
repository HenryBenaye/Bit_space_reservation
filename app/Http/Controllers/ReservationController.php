<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditReservationRequest;
use App\Http\Requests\StoreReservationRequest;
use App\Models\Reservation;
use App\Models\Space;
use App\Models\User;
use App\Rules\EditTimeRule;
use App\Rules\TimeRule;
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
       return redirect()->route('reservations.show',Auth::user()->id);
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
     *
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'space_name' => ['required', 'exists:spaces,name'],
            'begin_time_hour' => ['required', 'integer'],
            'begin_time_minute' => ['required', 'integer'],
            'end_time_hour' => ['required', 'integer'],
            'end_time_minute' => ['required', 'integer', new TimeRule()],
        ]);

        $user = User::find(Auth::user()->id);
        $space = Space::where('name', $request['space_name'])->first();
        $begin_time = Carbon::create(0, 0, 0, $request['begin_time_hour'], $request['begin_time_minute']);
        $end_time = Carbon::create(0, 0, 0, $request['end_time_hour'], $request['end_time_minute']);

        $reservation = new Reservation();
        $reservation->user_id= $user->id;
        $reservation->space_id = $space->id;
        $reservation->begin_time = $begin_time->format('H:i');
        $reservation->end_time = $end_time->format('H:i');

        $user->reservations++;

        $space->save();
        $user->save();
        $reservation->save();
        return redirect()->route('reservations.show',Auth::user()->id);
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
        return view('reservation.index', ['reservations' => $reservations]);
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
        Reservation::destroy($reservation->id);

        $request->validate([
            'space_name' => ['required', 'exists:spaces,name'],
            'begin_time_hour' => ['required', 'integer'],
            'begin_time_minute' => ['required', 'integer'],
            'end_time_hour' => ['required', 'integer'],
            'end_time_minute' => ['required', 'integer', new EditTimeRule()],
        ]);

        $reservation = new Reservation();
        $reservation->space_id = Space::where('name', $request['space_name'])->first()->id;
        $reservation->user_id= Auth::user()->id;
        $reservation->begin_time = Carbon::create(0,0,0,$request['begin_time_hour'],$request['begin_time_minute'])->format('H:i');
        $reservation->end_time =  Carbon::create(0,0,0,$request['end_time_hour'],$request['end_time_minute'])->format('H:i');
        $reservation->save();
        return redirect()->route('reservations.show',Auth::user()->id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reservation  $reservation
     * @return RedirectResponse
     */
    public function destroy(Reservation $reservation)
    {
        $user = User::find(Auth::user()->id);
        $space = Space::find($reservation->space_id);
        $user->reservations--;
        $space->save();
        $user->save();
        Reservation::destroy($reservation->id);
        return redirect()->route('reservations.show',Auth::user()->id);
    }

}
