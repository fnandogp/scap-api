<?php

namespace App\Http\Requests\Opinion;

use Illuminate\Foundation\Http\FormRequest;

class ManifestAgainstFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $removal_request = request()->removal_request;

        return $removal_request->type == 'national' && $removal_request->status == 'released';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'reason' => 'required|max:1024'
        ];
    }
}
