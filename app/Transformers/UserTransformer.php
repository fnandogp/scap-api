<?php

namespace App\Transformers;

use App\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param User $user
     *
     * @return array
     */
    public function transform(User $user)
    {
        return [
            'name'       => $user->name,
            'email'      => $user->email,
            'enrollment' => $user->enrollment
        ];
    }
}
