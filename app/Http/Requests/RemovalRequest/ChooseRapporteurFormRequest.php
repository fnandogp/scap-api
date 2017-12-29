<?php

namespace App\Http\Requests\RemovalRequest;

use App\Http\Requests\BaseFormRequest;

class ChooseRapporteurFormRequest extends BaseFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $removal_request = request()->removal_request;

        if ($removal_request->type == 'national' || $removal_request->status != 'started') {
            return false;
        }

        $user = \Auth::user();

        return $user->hasRole('admin') || $user->hasRole('professor') && $user->is_department_chief;
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'rapporteur_id' => 'required|exists:users,id',
        ];
    }
}
