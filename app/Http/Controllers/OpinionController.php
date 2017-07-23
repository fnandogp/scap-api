<?php

namespace App\Http\Controllers;

use App\Http\Requests\Opinion\DeferOpinionFormRequest;
use App\Http\Requests\Opinion\ManifestAgainstFormRequest;
use App\Jobs\Opinion\DeferOpinion;
use App\Jobs\Opinion\ManifestAgainstRemovalRequest;
use App\RemovalRequest;
use App\Transformers\OpinionTransformer;

class OpinionController extends Controller
{

    /**
     * Manifest against national removal request
     *
     * @param ManifestAgainstFormRequest $request
     * @param RemovalRequest $removal_request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function manifestAgainst(ManifestAgainstFormRequest $request, RemovalRequest $removal_request)
    {
        $data = $request->only(['reason']);

        $data['removal_request_id'] = $removal_request->id;
        $data['user_id']            = \Auth::user()->id;

        $opinion = dispatch(new ManifestAgainstRemovalRequest($data));

        $data = fractal()
            ->item($opinion, new OpinionTransformer)
            ->toArray();

        $data['message'] = __('responses.opinion.manifest-against');

        return response()->json($data, 201);
    }

    /**
     * Defer a opinion to a international removal request
     *
     * @param DeferOpinionFormRequest $request
     * @param RemovalRequest $removal_request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function defer(DeferOpinionFormRequest $request, RemovalRequest $removal_request)
    {
        $data = $request->only(['type', 'reason']);

        $data['removal_request_id'] = $removal_request->id;
        $data['user_id']            = \Auth::user()->id;

        $opinion = dispatch(new DeferOpinion($data));

        $data = fractal()
            ->item($opinion, new OpinionTransformer)
            ->toArray();

        $data['message'] = __('responses.opinion.deferred');

        return response()->json($data, 201);
    }
}
