<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UserCreateRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Jobs\User\UserCreate;
use App\Jobs\User\UserUpdate;
use App\Transformers\UserTransformer;
use App\User;

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

    /**
     * @param UserUpdateRequest $request
     * @param $user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        $job  = new UserUpdate($user, $request->name, $request->email, $request->enrollment);
        $user = dispatch($job);

        return fractal()
            ->item($user, new UserTransformer)
            ->addMeta(['message' => __('responses.user.updated')])
            ->respond(200);
    }
}
