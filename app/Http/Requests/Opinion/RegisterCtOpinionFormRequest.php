<?php

namespace App\Http\Requests\Opinion;

use App\Enums\OpinionType;
use App\Http\Requests\BaseFormRequest;

class RegisterCtOpinionFormRequest extends BaseFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $removal_request = request()->removal_request;

        return $removal_request->type == 'international' && $removal_request->status == 'approved-di';
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
