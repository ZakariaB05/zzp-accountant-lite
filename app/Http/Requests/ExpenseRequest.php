<?php

namespace App\Http\Requests;

use App\Models\Expense;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ExpenseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'        => ['required', 'string', 'max:255'],
            'category'     => ['required', Rule::in(Expense::CATEGORIES)],
            'expense_date' => ['required', 'date'],
            'amount'       => ['required', 'numeric', 'min:0.01', 'max:1000000'],
            'vat_amount'   => ['required', 'numeric', 'min:0', 'max:1000000'],
        ];
    }

    public function attributes(): array
    {
        return [
            'title'        => 'titel',
            'category'     => 'categorie',
            'expense_date' => 'datum',
            'amount'       => 'bedrag',
            'vat_amount'   => 'BTW-bedrag',
        ];
    }

    public function messages(): array
    {
        return [
            'required'   => 'Vul het veld :attribute in.',
            'numeric'    => 'Het veld :attribute moet een getal zijn.',
            'date'       => 'Vul een geldige :attribute in.',
            'amount.min' => 'Het bedrag moet hoger zijn dan € 0.',
            'in'         => 'Kies een geldige :attribute.',
        ];
    }
}