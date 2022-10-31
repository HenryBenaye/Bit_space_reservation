<?php

namespace App\Http\Requests;

use App\Models\Reservation;
use Illuminate\Foundation\Http\FormRequest;

class StoreReservationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'space_name' => 'required|exists:spaces,name',
            'begin_time_hour' => 'required|integer',
            'begin_time_minute' => 'required|integer',
            'end_time_hour' => 'required|integer',
            'end_time_minute' => 'required|integer',
        ];
    }

    public function time_validation()
    {
        $time_check = Reservation::where('user_id',  $user->id)
            ->where('begin_time' , '>=', $begin_time->format('H:i'))
            ->where('end_time', '<=', $end_time->format('H:i'))->get();

        // Controles uitvoeren of de gebruiker juiste data heeft ingevoerd
        if (!$end_time->isAfter($begin_time) || $begin_time->floatDiffInMinutes($end_time) > 60)
        {
            return redirect()->back()->withErrors(['msg' => 'Je moet minimaal 15 minuten reserveren of je hebt meer dan een uur gereserveerd']);
        }
        if (!$time_check->isEmpty())
        {
            return redirect()->back()->withErrors(['msg' => 'Je hebt al een reservering tussen die tijd']);
        }
        if($user->reservations === 5) {
            return redirect()->back()->withErrors(['msg' => 'Je hebt al 5 reserveringen']);
        }
        if($space->max_students - $space->reserved_students <= 0)
        {
            return redirect()->back()->withErrors(['msg' => 'Ruimte is vol']);
        }
    }
}
