<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UserCreateRequest;
use App\Jobs\User\UserCreate;
use App\Transformers\UserTransformer;

class UserController extends Controller
{

    /**
     * Store a new user
     *
     * @param UserCreateRequest $request
     *
     * @return \Spatie\Fractal\Fractal
     *
     */
    public function store(UserCreateRequest $request)
    {
        $job  = new UserCreate($request->name, $request->email, $request->password, $request->enrollment);
        $user = dispatch($job);

        return fractal()
            ->item($user, new UserTransformer)
            ->addMeta(['message' => __('responses.user.created')])
            ->respond(200);
    }
}
