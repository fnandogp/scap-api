<?php

namespace App\Http\Requests\RemovalRequest;

use App\Http\Requests\BaseFormRequest;

class RemovalRequestCancelFormRequest extends BaseFormRequest
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

        return $removal_request->user->id == $user->id && ! in_array($removal_request->status, [
                'archived',
                'disapproved',
                'cancelled',
            ]);
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'cancellation_reason' => 'required|string|max:1024',
        ];
    }
}
