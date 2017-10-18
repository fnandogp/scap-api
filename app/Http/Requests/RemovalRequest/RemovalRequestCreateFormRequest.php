<?php

namespace App\Http\Requests\RemovalRequest;

use App\Enums\RemovalRequestOnus;
use App\Enums\RemovalRequestStatus;
use App\Enums\RemovalRequestType;
use Illuminate\Foundation\Http\FormRequest;

class RemovalRequestCreateFormRequest extends FormRequest
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
            'type'           => 'required|in:'.RemovalRequestType::implode(),
            'removal_from'   => 'required|date_format:Y-m-d|after:now',
            'removal_to'     => 'required|date_format:Y-m-d|after:removal_from',
            'removal_reason' => 'required|string',
            'onus'           => 'required|in:'.RemovalRequestOnus::implode(),
            'event'          => 'required|string',
            'city'           => 'required|string',
            'event_from'     => 'required|date_format:Y-m-d|after:removal_from',
            'event_to'       => 'required|date_format:Y-m-d||after:event_from|before:removal_to',
        ];
    }
}
