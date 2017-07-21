<?php

namespace App\Http\Requests\Mandate;

use Illuminate\Foundation\Http\FormRequest;

class MandateCreateFormRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'date_from' => 'required|date',
            'date_to'   => 'nullable|date|after:date_from'
        ];
    }
}
