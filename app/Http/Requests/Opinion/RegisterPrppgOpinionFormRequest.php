<?php

namespace App\Http\Requests\Opinion;

use App\Enums\OpinionType;
use Illuminate\Foundation\Http\FormRequest;

class RegisterPrppgOpinionFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $removal_request = request()->removal_request;

        if ($removal_request->status != 'approved-ct' || $removal_request->type != 'international') {
            return false;
        }

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
            'type'   => 'required|in:' . OpinionType::implode(),
            'reason' => 'required|max:1024',
        ];
    }
}
