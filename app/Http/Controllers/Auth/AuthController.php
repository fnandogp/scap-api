<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthLoginRequest;
use App\Repositories\UserRepository;
use App\Transformers\UserTransformer;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{

    /**
     * @var
     */
    private $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    /**
     * Auth a user.
     *
     * @api            {post} /login Login user
     * @apiVersion     1.0.0
     * @apiName        LoginUser
     * @apiGroup       Auth
     * @apiUse         Token
     * @apiUse         Localize
     *
     * @apiDescription Auth a user.
     *
     * @apiParam   (Body) {String} email Users unique e-mail.
     * @apiParam   (Body) {String} password Users password.
     *
     * @apiSuccess (200)  {String} token    Auth Token generated.
     * @apiSuccess (200)  {User}   user     User object.
     *
     * @apiError   (401)  {String} error    Invalid credentials.
     * @apiError   (500)  {String} error    The token could not be created.
     *
     * @param \App\Http\Requests\Auth\AuthLoginRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(AuthLoginRequest $request)
    {
        // grab credentials from the request
        $credentials = $request->only('email', 'password');
        try {
            // attempt to verify the credentials and create a token for the user
            if ( ! $token = \JWTAuth::attempt($credentials)) {
                $data = [
                    'errors' => [
                        'password' => [__('responses.auth.errors.invalid_credentials')]
                    ]
                ];

                return response()->json($data, 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            $data = [
                'errors' => [
                    'password' => [__('responses.auth.errors.could_not_create_token')]
                ]
            ];

            return response()->json($data, 500);
        }

        // all good so return the token and the user
        $data = fractal()
            ->item(\Auth::user(), new UserTransformer)
            ->toArray();

        $data['token']   = $token;
        $data['message'] = __('responses.auth.login');

        return response()->json($data, 200);
    }

    /**
     * Renew the token.
     *
     * @api            {get} /token Renew token
     * @apiVersion     1.0.0
     * @apiName        RefreshToken
     * @apiGroup       Auth
     * @apiUse         Token
     * @apiUse         Localize
     *
     * @apiDescription Renew the token without having to be Authd again.
     *
     * @apiSuccess (200) {String} token Auth token generated.
     *
     * @apiError   (400) {String} error Missing access token.
     * @apiError   (500) {String} error Not able to refresh token.
     *
     *
     * @return \Illuminate\Http\JsonResponse
     */
//    public function token()
//    {
//        $token = JWTAuth::getToken();
//
//        if ( ! $token) {
//            return response()->json(['error' => trans('responses.errors.token.token_absent')], 400);
//        }
//        try {
//            $refreshedToken = JWTAuth::refresh($token);
//        } catch (JWTException $e) {
//            return response()->json(['error' => trans('responses.errors.token.could_not_refresh_token')], 500);
//        }
//
//        return response()->json(['data' => ['token' => $refreshedToken]], 200);
//    }

    /**
     * Get the current authenticated user
     */
    public function me()
    {
        $user = \JWTAuth::toUser();

        $data = fractal()
            ->item($user, new UserTransformer)
            ->toArray();

        return response()->json($data, 200);
    }

    /**
     * Logout a Authd user.
     *
     * @api            {post} /logout Logout user
     * @apiVersion     1.0.0
     * @apiName        LogoutUser
     * @apiGroup       Auth
     * @apiUse         Token
     * @apiUse         Localize
     * @apiUse         Self
     *
     * @apiDescription Logout a Authd user.
     *
     * @apiSuccess (200) {String} message User successfully logged out. The current access token is now invalid.
     *
     *
     * @return \Response
     */
    public function logout()
    {
        $token = \JWTAuth::getToken();
        \JWTAuth::invalidate($token);

        return response()->json(['message' => __('responses.auth.logout')], 200);
    }

    /**
     * Request a code to be sent by e-mail to change the current password.
     *
     * @api            {post} /password/reset Request password reset
     * @apiVersion     1.0.0
     * @apiName        RequestPasswordReset
     * @apiGroup       Auth
     * @apiUse         CORS
     * @apiUse         Localize
     *
     * @apiParam       (Body) {String} email User e-mail (must be a valid email, max 255 chars, must exist in DB).
     *
     * @apiDescription Request a code to be sent by e-mail to change the current password.
     *
     * @apiSuccess     (200) {String} message Password token has been sent.
     * @apiError       (404) {String} error   Resource not found.
     *
     * //     * @param \App\Http\Requests\PasswordReset\PasswordResetRequest $request
     *
     * @return string
     */
//    public function passwordReset(PasswordResetRequest $request)
//    {
//        $user = $this->users->findByEmail($request->email);
//
//        if ( ! $user) {
//            return response()->json(['error' => trans('responses.errors.auth.not_found')], 400);
//        }
//
//        $token = $this->dispatch(new RequestPasswordReset($user->email));
//
//        $user->notify(new PasswordReset($user, $token));
//
//        return response()->json([
//            'message' => trans('responses.messages.user.password_token_sent'),
//            'data'    => [
//                'token' => $token
//            ]
//        ], 200);
//    }

    /**
     * Change the password, by sending the generated code and the new password.
     *
     * @api            {post} /password/change Change password
     * @apiVersion     1.0.0
     * @apiName        RequestPasswordChange
     * @apiGroup       Auth
     * @apiUse         CORS
     * @apiUse         Localize
     * @apiUse         OrderBy
     * @apiUse         Paginate
     * @apiParam       (Body) {String} email User e-mail (must be a valid email, max 255 chars, must exist in DB).
     * @apiParam       (Body) {String} token Token sent by e-mail to allow change password.
     * @apiParam       (Body) {String} password User new password.
     * @apiParam       (Body) {String} password_confirmation User new password confirmation.
     *
     * @apiDescription Change the password, by sending the generated code and the new password.
     *
     * @apiSuccess     (200) {String} message Credentials changed with success.
     * @apiError       (400) {String} error   Password token is invalid.
     * @apiError       (401) {String} error   Invalid credentials.
     *
     * //     * @param \App\Http\Requests\PasswordReset\PasswordChangeRequest $request
     *
     * @return string
     */
//    public function passwordChange(PasswordChangeRequest $request)
//    {
//        $token = $this->users->checkPasswordResetToken($request->email, $request->token);
//
//        if ( ! $token) {
//            return response()->json(['error' => trans('responses.error.auth.password_token_invalid')], 400);
//        }
//
//        $user = $this->users->findByEmail($request->email);
//
//        if ( ! $user) {
//            return response()->json(['error' => trans('responses.error.auth.invalid_credentials')], 401);
//        }
//
//        $job = new RemovePasswordResetRequests($request->email);
//        $this->dispatch($job);
//
//        $job = new ChangeUserPassword($user->id, $request->password);
//        $this->dispatch($job);
//
//        return response()->json(['message' => trans('responses.messages.user.credentials_updated')], 200);
//    }

    /**
     * Change the users credentials (e-mail and password).
     *
     * @api            {patch} /users/{id}/credentials Change credentials
     * @apiVersion     1.0.0
     * @apiName        ChangeCredentials
     * @apiGroup       Auth
     * @apiUse         Token
     * @apiUse         Localize
     * @apiUse         CORS
     * @apiUse         Self
     * @apiParam       (Body) {String} email User e-mail (must be a valid email, max 255 chars, must exist in DB).
     * @apiParam       (Body) {String} password Old password, to validate the user.
     * @apiParam       (Body) {String} new_password User new password.
     * @apiParam       (Body) {String} new_password_confirmation User new password confirmation.
     *
     * @apiDescription Change the users credentials (e-mail and password).
     *
     * @apiError       (200) {String}   message Credentials changed with success.
     * @apiError       (422) {String[]} error   Error messages.
     *
     * @param $id
     * @param \App\Http\Requests\Auth\ChangeCredentialsRequest $request
     *
     * @return string
     */
//    public function changeCredentials(ChangeCredentialsRequest $request, $id)
//    {
//        $job = new UserChangeCredentials($id, $request->email, $request->new_password);
//        $this->dispatch($job);
//
//        return response()->json(['message' => trans('responses.messages.user.credentials_updated')], 200);
//    }
}