<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UserCreateFormRequest;
use App\Http\Requests\User\UserUpdateFormRequest;
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
     * @param UserCreateFormRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UserCreateFormRequest $request)
    {
        $job  = new UserCreate($request->all());
        $user = dispatch($job);

        $data = fractal()
            ->item($user, new UserTransformer)
            ->toArray();

        $data['message'] = __('responses.user.created');

        return response()->json($data, 201);
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
        $data = fractal()
            ->item($user, new UserTransformer)
            ->toArray();

        return response()->json($data, 200);
    }

    /**
     * @param UserUpdateFormRequest $request
     * @param $user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UserUpdateFormRequest $request, User $user)
    {
        $job  = new UserUpdate($user, $request->all());
        $user = dispatch($job);

        $data = fractal()
            ->item($user, new UserTransformer)
            ->toArray();

        $data['message'] = __('responses.user.updated');

        return response()->json($data, 200);
    }

    /**
     * Destroy a user
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
        ], 200);
    }

    /**
     * Get all users
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $users = $this->users->getAll();

        $data = fractal()
            ->collection($users, new UserTransformer)
            ->toArray();

        return response()->json($data, 200);
    }
}
