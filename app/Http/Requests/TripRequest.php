<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TripRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'trip_date'     => ['required', 'date'],
            'from_location' => ['required', 'string', 'max:255'],
            'to_location'   => ['required', 'string', 'max:255'],
            'kilometers'    => ['required', 'numeric', 'min:0.1', 'max:5000'],
            'vehicle'       => ['required', 'string', 'max:100'],
        ];
    }

    public function attributes(): array
    {
        return [
            'trip_date'     => 'datum',
            'from_location' => 'vertrekplaats',
            'to_location'   => 'bestemming',
            'kilometers'    => 'aantal kilometers',
            'vehicle'       => 'voertuig',
        ];
    }

    public function messages(): array
    {
        return [
            'required'       => 'Vul het veld :attribute in.',
            'numeric'        => 'Het veld :attribute moet een getal zijn.',
            'date'           => 'Vul een geldige :attribute in.',
            'kilometers.min' => 'Een rit moet minimaal 0,1 km zijn.',
            'kilometers.max' => 'Een rit kan maximaal 5000 km zijn.',
        ];
    }
}