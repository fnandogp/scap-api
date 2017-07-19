<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestCreateFormRequest;
use App\Jobs\Request\RequestCreate;
use App\Transformers\RequestTransformer;

class RequestController extends Controller
{

    /**
     * Create a new request
     *
     * @param RequestCreateFormRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(RequestCreateFormRequest $request)
    {
        $job         = new RequestCreate($request->all());
        $new_request = dispatch($job);

        $data = fractal()
            ->item($new_request, new RequestTransformer)
            ->toArray();

        $data['message'] = __('responses.request.created');

        return response()->json($data, 201);
    }
}
