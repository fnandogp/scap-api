<?php

namespace Tests\Feature;

use App\User;

class AuthTest extends FeatureTestCase
{
    /** @test */
    public function it_authenticate_a_user()
    {
        $user = factory(User::class)->create([
            'password' => bcrypt('secret'),
        ]);

        $credentials = [
            'email'    => $user->email,
            'password' => 'secret'
        ];

        $this
            ->post('/auth/login', $credentials, $this->getCustomHeader())
            ->assertJsonStructure(['data', 'token', 'message'])
            ->assertJsonFragment([
                    'message' => __('responses.auth.login')
                ]
            )
            ->assertStatus(200);
    }

    /** @test */
    public function it_fails_when_inputs_are_empty()
    {
        $this
            ->post('/auth/login', [], $this->getCustomHeader())
            ->assertJson([
                'errors' => [
                    'email'    => [__('validation.required', ['attribute' => 'email'])],
                    'password' => [__('validation.required', ['attribute' => 'password'])]
                ]
            ])
            ->assertStatus(422);
    }

    /** @test */
    public function it_fails_when_wrong_password_is_used()
    {
        $user = factory(User::class)->create();

        $credentials = [
            'email'    => $user->email,
            'password' => $user->password // the $user->password is already hashed
        ];

        $this
            ->post('/auth/login', $credentials, $this->getCustomHeader())
            ->assertJson([
                'errors' => [
                    'password' => [__('responses.auth.errors.invalid_credentials', ['attribute' => 'password'])]
                ]
            ])
            ->assertStatus(401);
    }

    /** @test */
    public function it_logs_out_a_authenticated_user()
    {
        $this
            ->delete('/auth/logout', [], $this->getCustomHeader($this->admin))
            ->assertJson([
                'message' => __('responses.auth.logout')
            ])
            ->assertStatus(200);
    }

    /** @test */
    public function it_get_the_authenticated_user()
    {
        $this
            ->get('/auth/me', [], $this->getCustomHeader($this->admin))
            ->assertJsonStructure(['data'])
            ->assertStatus(200);
    }

    /** @test */
    public function it_fails_if_none_user_is_authenticated()
    {
        $this
            ->get('/auth/me', [], $this->getCustomHeader())
            ->assertStatus(400);
    }

    /** @test */
    public function it_fails_if_user_token_is_invalid()
    {
        $token = \JWTAuth::fromUser($this->admin);
        \JWTAuth::setToken($token);
        \JWTAuth::invalidate($token);
        $headers['Authorization'] = 'Bearer ' . $token;

        $this
            ->get('/auth/me', [], $this->getCustomHeader(null, $headers))
            ->assertStatus(401);
    }
}
