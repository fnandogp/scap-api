<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mandate extends Model
{
    protected $fillable = [
        'user_id',
        'date_from',
        'date_to'
    ];

    protected $dates = [
        'date_from',
        'date_to'
    ];

    /**
     * A mandate always have a user/professor
     *
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
