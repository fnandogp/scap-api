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
        $data = $request->only([
            'type',
            'removal_from',
            'removal_to',
            'removal_reason',
            'event',
            'city',
            'event_from',
            'event_to',
            'onus'
        ]);

        $data['user_id'] = \Auth::user()->id;

        $new_request = dispatch(new RequestCreate($data));

        $data = fractal()
            ->item($new_request, new RequestTransformer)
            ->toArray();

        $data['message'] = __('responses.request.created');

        return response()->json($data, 201);
    }
}
