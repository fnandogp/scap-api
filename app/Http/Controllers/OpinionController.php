<?php

namespace App\Http\Controllers;

use App\Http\Requests\Opinion\OpinionManifestAgainstFormRequest;
use App\Jobs\Opinion\OpinionManifestAgainst;
use App\RemovalRequest;
use App\Transformers\OpinionTransformer;

class OpinionController extends Controller
{

    public function manifestAgainst(OpinionManifestAgainstFormRequest $request, RemovalRequest $removal_request)
    {
        $data = $request->only(['reason']);

        $data['removal_request_id'] = $removal_request->id;
        $data['user_id']            = \Auth::user()->id;

        $opinion = dispatch(new OpinionManifestAgainst($data));


        $data = fractal()
            ->item($opinion, new OpinionTransformer)
            ->toArray();

        $data['message'] = __('responses.opinion.manifest-against');

        return response()->json($data, 201);
    }
}
