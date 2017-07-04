<?php

namespace App\Transformers;

use App\User;
use Carbon\Carbon;
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
            'id'         => (int) $user->id,
            'name'       => $user->name,
            'email'      => $user->email,
            'enrollment' => $user->enrollment,
            'created_at' => $user->created_at->toDateTimeString(),
            'updated_at' => $user->updated_at->toDateTimeString()
        ];
    }
}
