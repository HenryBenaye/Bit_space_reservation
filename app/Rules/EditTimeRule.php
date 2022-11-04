<?php

namespace App\Rules;

use App\Models\Reservation;
use App\Models\Space;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\InvokableRule;
use Illuminate\Contracts\Validation\ValidatorAwareRule;
use Illuminate\Support\Facades\Auth;

class TimeRule implements ValidatorAwareRule, InvokableRule
{
    /**
     * Run the validation rule.
     *
     * @param string $attribute
     * @param mixed $value
     * @param \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString $fail
     * @return void
     */
    public function __invoke($attribute, $value, $fail)
    {
        if ($this->time_diffrence()) {
            $fail('Je moet minimaal 15 minuten reserveren mag maximaal 60 minuten reserveren');
        }
        if ($this->exisisting_reservation()) {
            $fail( 'Je hebt al een reservering tussen die tijd.');
        }
        if ($this->after_time()) {
            $fail('end_time_hour', 'Je mag niet na 17:00 reserveren');
        }
    }

    private function time_diffrence()
    {
        $begin_time = Carbon::create(0, 0, 0, request()->begin_time_hour, request()->begin_time_minute);
        $end_time = Carbon::create(0, 0, 0, request()->end_time_hour, request()->end_time_minute);
        return (!$end_time->isAfter($begin_time) || $begin_time->floatDiffInMinutes($end_time) > 60);
    }
    private function exisisting_reservation()
    {
        $user = User::find(Auth::user()->id);

        $begin_time = Carbon::create(0, 0, 0, request()->begin_time_hour, request()->begin_time_minute);
        $end_time = Carbon::create(0, 0, 0, request()->end_time_hour, request()->end_time_minute);

        $time_check = Reservation::where('user_id', $user->id)
            ->where('begin_time', '>=', $begin_time->format('H:i'))
            ->where('end_time', '<=', $end_time->format('H:i'))->get();
        return (!$time_check->isEmpty());
    }
    private function after_time()
    {
        $end_time = Carbon::create(0, 0, 0, request()->end_time_hour, request()->end_time_minute);
        return ($end_time->isAfter(Carbon::create(0, 0, 0, 17, 0)));
    }
    public function setValidator($validator)
    {
        $this->validator = $validator;
        return $this;
    }
}
