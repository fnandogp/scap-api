<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestCreateFormRequest extends FormRequest
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
            'type'           => 'required|in:' . \App\Enums\RequestType::implode(),
            'status'         => 'required|in:' . \App\Enums\RequestStatus::implode(),
            'removal_from'   => 'required|date',
            'removal_to'     => 'required|date|after:removal_from',
            'removal_reason' => 'required|string',
            'onus'           => 'required|in:' . \App\Enums\RequestOnus::implode(),
            'event'          => 'required|string',
            'city'           => 'required|string',
            'event_from'     => 'required|date|after:removal_from',
            'event_to'       => 'required|date|after:event_from'
        ];
    }
}
