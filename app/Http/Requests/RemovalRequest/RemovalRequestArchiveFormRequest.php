<?php

namespace App\Http\Requests\RemovalRequest;

use App\Http\Requests\BaseFormRequest;

class RemovalRequestArchiveFormRequest extends BaseFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $removal_request = request()->removal_request;

        return $removal_request->type == 'international' && $removal_request->status == 'approved-prppg';
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }
}
