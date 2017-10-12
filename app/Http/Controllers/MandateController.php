<?php

namespace App\Http\Controllers;

use App\Http\Requests\Mandate\MandateCreateFormRequest;
use App\Jobs\Mandate\CreateMandate;
use App\Transformers\MandateTransformer;
use App\User;

class MandateController extends Controller
{

    /**
     * @param MandateCreateFormRequest $request
     * @param User $user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(MandateCreateFormRequest $request, User $user)
    {
        $job     = new CreateMandate(
            array_add($request->only(['date_from', 'date_to']), 'user_id', $user->id));
        $mandate = dispatch($job);

        $data = fractal()
            ->item($mandate, new MandateTransformer)
            ->toArray();

        $data['message'] = __('responses.mandate.created');

        return response()->json($data, 201);
    }
}
