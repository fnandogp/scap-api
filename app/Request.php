<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Request extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'type',
        'status',
        'removal_from',
        'removal_to',
        'removal_reason',
        'onus',
        'event',
        'city',
        'event_from',
        'event_to',
        'judgment_at',
        'canceled_at',
        'cancellation_reason',
    ];

    /**
     * Attributes that should be mutated to date
     *
     * @var array
     */
    protected $dates = [
        'removal_from',
        'removal_to',
        'event_from',
        'event_to',
        'judgment_at',
        'canceled_at',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function files()
    {
        $this->hasMany(File::class);
    }
}
