<?php

namespace App\Http\Requests;

use App\Models\Reservation;
use App\Models\Space;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

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

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->time_diffrence()) {
                $validator->errors()->add('DOB', 'You must be 18 years or older to use this site.');
            }
            if ($this->exisisting_reservation()) {
                $validator->errors()->add('DOB', 'You must be 18 years or older to use this site.');
            }
            if ($this->max_reservation()) {
                $validator->errors()->add('DOB', 'You must be 18 years or older to use this site.');
            }
            if ($this->max_space_reached()) {
                $validator->errors()->add('DOB', 'You must be 18 years or older to use this site.');
            }
        });
    }

    private function time_diffrence()
    {
        $begin_time = Carbon::create(0, 0, 0, $this->input('begin_time_hour'), $this->input('begin_time_minute'));
        $end_time = Carbon::create(0, 0, 0, $this->input('end_time_hour'), $this->input('end_time_minute'));
        return (!$end_time->isAfter($begin_time) || $begin_time->floatDiffInMinutes($end_time) > 60);
    }

    private function exisisting_reservation()
    {
        $user = User::find(Auth::user()->id);

        $begin_time = Carbon::create(0, 0, 0, $this->input('begin_time_hour'), $this->input('begin_time_minute'));
        $end_time = Carbon::create(0, 0, 0, $this->input('end_time_hour'), $this->input('end_time_minute'));

        $time_check = Reservation::where('user_id', $user->id)
            ->where('begin_time', '>=', $begin_time->format('H:i'))
            ->where('end_time', '<=', $end_time->format('H:i'))->get();
        return (!$time_check->isEmpty());
    }

    private function max_reservation()
    {
        $user = User::find(Auth::user()->id);
        return ($user->reservations === 5);
    }

    private function max_space_reached()
    {
        $space = Space::where('name', $this->input('space_name'))->first();
        return ($space->max_students - $space->reserved_students <= 0);

    }
}

