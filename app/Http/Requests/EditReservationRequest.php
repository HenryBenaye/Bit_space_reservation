<?php

namespace App\Http\Requests;

use App\Models\Reservation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class EditReservationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
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
            'reservation_id' => 'required',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->time_diffrence()) {
                $validator->errors()->add('begin_time_hour','Je moet minimaal 15 minuten reserveren mag maximaal 60 minuten reserveren');
            }
            if ($this->exisisting_reservation()) {
                $validator->errors()->add('begin_time_hour','Je hebt al een reservering tussen die tijd.');
            }
            if ($this->after_time()) {
                $validator->errors()->add('end_time_hour','Je mag niet na 17:0r0 reserveren');
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
//        dd($time_check[0]->id,$this->input('reservation_id'),$time_check[0]->id != $this->input('id'));
        return (!$time_check->isEmpty() && $time_check[0]->id != $this->input('reservation_id'));
    }

    private function after_time()
    {
        $end_time = Carbon::create(0, 0, 0, $this->input('end_time_hour'), $this->input('end_time_minute'));
        return ($end_time->isAfter(Carbon::create(0, 0, 0, 17, 0)));
    }
}
