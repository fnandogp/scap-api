<?php

namespace App\Http\Requests\User;

use App\Http\Requests\BaseFormRequest;

class UserUpdateFormRequest extends BaseFormRequest
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
        $user = $this->route()->user;

        return [
            'id'         => 'exists:users',
            'name'       => 'required|max:255',
            'email'      => "required|email|unique:users,email,{$user->id}|max:255",
            'enrollment' => 'required|max:15'
        ];
    }
}
