<?php

namespace App\Http\Requests\Opinion;

use App\Enums\OpinionType;
use App\Http\Requests\BaseFormRequest;

class DeferOpinionFormRequest extends BaseFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $removal_request = request()->removal_request;
        $user = \Auth::user();

        if ($removal_request->type != 'international' || $removal_request->status != 'released') {
            return false;
        }

        return $user->hasRole('admin') || ($removal_request->rapporteur && $removal_request->rapporteur->id == $user->id);
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'type'   => 'required|in:'.OpinionType::implode(),
            'reason' => 'required|max:1024',
        ];
    }
}
