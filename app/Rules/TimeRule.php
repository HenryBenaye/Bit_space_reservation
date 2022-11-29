<?php

namespace App\Rules;

use App\Models\Reservation;
use App\Models\Space;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\InvokableRule;
use Illuminate\Contracts\Validation\ValidatorAwareRule;
use Illuminate\Http\Client\Request;
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
            $fail( 'Er is een reservering tussen die tijd.');
        }
        if ($this->max_reservation()) {
            $fail('space_name', 'Je hebt al 5 reserveringen');
        }
        if ($this->max_space_reached()) {
            $fail('space_name', 'Ruimte is vol');
        }

    }

    private function time_diffrence()
    {
        $begin_time = Carbon::create(0, 0, 0,
            request()
                ->begin_time_hour,
            request()
                ->begin_time_minute);
        $end_time = Carbon::create(0, 0, 0,
            request()
                ->end_time_hour,
            request()
                ->end_time_minute);
        return (!$end_time->isAfter($begin_time) || $begin_time->floatDiffInMinutes($end_time) > 60);
    }
    private function exisisting_reservation()
    {
        $UserCheck = Reservation::UserTimeCheck()->count();
        $SpaceCheck = Reservation::SpaceTimeCheck()->count();
        dd($UserCheck, $SpaceCheck);

        if ($UserCheck > 0 || $SpaceCheck > 0)
        {
           return ($UserCheck > 0 || $SpaceCheck > 0);
        }
    }

    private function max_reservation()
    {
        $user = User::find(Auth::user()->id);
        return ($user->reservations === 5);
    }

    private function max_space_reached()
    {
        $space = Space::where('name',
            request()
                ->space_name)
            ->first();
        $reserved_students = Reservation::SpaceTimeCheck()->count();

        return ($space->max_students == $reserved_students);

    }

    public function setValidator($validator)
    {
        $this->validator = $validator;

        return $this;
    }
}
