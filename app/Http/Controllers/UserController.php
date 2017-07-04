<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UserCreateRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Jobs\User\UserCreate;
use App\Jobs\User\UserDelete;
use App\Jobs\User\UserUpdate;
use App\Repositories\UserRepository;
use App\Transformers\UserTransformer;
use App\User;

class UserController extends Controller
{
    /**
     * @var UserRepository
     */
    private $users;

    public function __construct(UserRepository $user_repository)
    {
        $this->users = $user_repository;
    }

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
     * Show a single user
     *
     * @param User $user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(User $user)
    {
        return fractal()
            ->item($user, new UserTransformer)
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

    /**
     * Destoy a user
     *
     * @param User $user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(User $user)
    {
        $job = new UserDelete($user);
        dispatch($job);

        return response()->json([
            'message' => __('responses.user.deleted')
        ], 204);
    }

    /**
     * Get all users
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $users = $this->users->getAll();

        return fractal()
            ->collection($users, new UserTransformer)
            ->respond(200);
    }
}
