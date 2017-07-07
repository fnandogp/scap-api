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
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UserCreateRequest $request)
    {
        $job  = new UserCreate($request->name, $request->email, $request->password, $request->enrollment);
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
     * @param UserUpdateRequest $request
     * @param $user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        $job  = new UserUpdate($user, $request->name, $request->email, $request->enrollment);
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
