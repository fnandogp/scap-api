<?php

namespace App\Http\Requests\Mandate;

use App\Http\Requests\BaseFormRequest;

class MandateCreateFormRequest extends BaseFormRequest
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
            'date_to'   => 'nullable|date|after:date_from',
        ];
    }
}
