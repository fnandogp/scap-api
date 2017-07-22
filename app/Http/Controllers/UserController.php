<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UserCreateFormRequest;
use App\Http\Requests\User\UserUpdateFormRequest;
use App\Jobs\User\CreateUser;
use App\Jobs\User\DeleteUser;
use App\Jobs\User\UpdateUser;
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
        $job  = new CreateUser($request->all());
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
        $job  = new UpdateUser($user, $request->all());
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
        $job = new DeleteUser($user);
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
