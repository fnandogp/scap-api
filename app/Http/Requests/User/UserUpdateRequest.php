<?php

namespace App\Http\Requests\User;

use App\Http\Requests\BaseFormRequest;

class UserUpdateRequest extends BaseFormRequest
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
            'id'         => 'exists:users',
            'name'       => 'required|max:255',
            'email'      => 'required|email|unique:users|max:255',
            'enrollment' => 'required|max:15'
        ];
    }
}
