<?php

namespace App\Http\Requests;

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
}
