<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AuthTest extends FeatureTestCase
{
    use DatabaseMigrations;

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
            ->assertJsonStructure([
                'data',
                'token'
            ])
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
                    'password' => [__('responses.errors.token.invalid_credentials', ['attribute' => 'password'])]
                ]
            ])
            ->assertStatus(401);
    }
}