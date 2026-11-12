<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShiftRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'client_name' => ['required', 'string', 'max:255'],
            'work_date'   => ['required', 'date'],
            'hours'       => ['required', 'numeric', 'min:0.25', 'max:24'],
            'hourly_rate' => ['required', 'numeric', 'min:0', 'max:1000'],
            'vat_rate'    => ['required', 'in:0,9,21'],
        ];
    }

    public function attributes(): array
    {
        return [
            'client_name' => 'opdrachtgever',
            'work_date'   => 'datum',
            'hours'       => 'gewerkte uren',
            'hourly_rate' => 'uurtarief',
            'vat_rate'    => 'BTW-tarief',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'Vul het veld :attribute in.',
            'numeric'  => 'Het veld :attribute moet een getal zijn.',
            'date'     => 'Vul een geldige :attribute in.',
            'hours.min' => 'Je moet minimaal 0,25 uur invullen.',
            'hours.max' => 'Een shift kan maximaal 24 uur zijn.',
            'in'       => 'Kies een geldig :attribute.',
        ];
    }
}