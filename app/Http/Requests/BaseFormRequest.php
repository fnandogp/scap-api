<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BaseFormRequest extends FormRequest
{
    /**
     * Return all validation responses as JSON.
     *
     * @param array $errors
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function response(array $errors)
    {
        return response()->json(['errors' => $errors], 422);
    }

}