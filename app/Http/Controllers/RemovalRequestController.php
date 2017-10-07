<?php

namespace App\Http\Controllers;

use App\Http\Requests\RemovalRequest\ChooseRapporteurFormRequest;
use App\Http\Requests\RemovalRequest\RegisterVotingResultFormRequest;
use App\Http\Requests\RequestCreateFormRequest;
use App\Jobs\RemovalRequest\ChooseRapporteur;
use App\Jobs\RemovalRequest\CreateRemovalRequest;
use App\Jobs\RemovalRequest\RegisterVotingResult;
use App\RemovalRequest;
use App\Repositories\RemovalRequestRepository;
use App\Transformers\RemovalRequestTransformer;

class RemovalRequestController extends Controller
{
    /**
     * @var \App\Repositories\RemovalRequestRepository
     */
    private $removal_requests;


    public function __construct(RemovalRequestRepository $removal_request_repo)
    {
        $this->removal_requests = $removal_request_repo;
    }


    /**
     * Index removal requests
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $users = $this->removal_requests->getAll();

        $data = fractal()
            ->collection($users, new RemovalRequestTransformer)
            ->parseIncludes(['user'])
            ->toArray();

        return response()->json($data, 200);
    }


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
            'onus',
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


    /**
     * @param ChooseRapporteurFormRequest $request
     * @param RemovalRequest $removal_request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function chooseRapporteur(ChooseRapporteurFormRequest $request, RemovalRequest $removal_request)
    {
        $removal_request = dispatch(new ChooseRapporteur($removal_request->id, $request->rapporteur_id));

        $data = fractal()
            ->item($removal_request, new RemovalRequestTransformer)
            ->toArray();

        $data['message'] = __('responses.removal_request.rapporteur_changed');

        return response()->json($data, 200);
    }
}
