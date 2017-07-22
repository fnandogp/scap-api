<?php

namespace App\Http\Controllers;

use App\Http\Requests\RemovalRequest\RegisterVotingResultFormRequest;
use App\Http\Requests\RequestCreateFormRequest;
use App\Jobs\RemovalRequest\CreateRemovalRequest;
use App\Jobs\RemovalRequest\RegisterVotingResult;
use App\RemovalRequest;
use App\Transformers\RemovalRequestTransformer;

class RemovalRequestController extends Controller
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
        $input = $request->only([
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

        $input['user_id'] = \Auth::user()->id;

        $removal_request = dispatch(new CreateRemovalRequest($input));

        $data = fractal()
            ->item($removal_request, new RemovalRequestTransformer)
            ->toArray();

        $data['message'] = __('responses.removal_request.created');

        return response()->json($data, 201);
    }

    /**
     * Register the result of the voting section
     *
     * @param RegisterVotingResultFormRequest $request
     * @param RemovalRequest $removal_request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function registerVotingResult(RegisterVotingResultFormRequest $request, RemovalRequest $removal_request)
    {
        $data = $request->only('type');
        $data = array_add($data, 'removal_request_id', $removal_request->id);

        $removal_request = dispatch(new RegisterVotingResult($data));
        
        $data = fractal()
            ->item($removal_request, new RemovalRequestTransformer)
            ->toArray();

        $data['message'] = __('responses.removal_request.voting_registered');

        return response()->json($data, 200);
    }
}
