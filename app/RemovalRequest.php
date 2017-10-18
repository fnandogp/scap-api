<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class RemovalRequest extends Model
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
        'rapporteur_id',
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
        'deleted_at',
    ];


    /**
     * The author of the removal request
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    /**
     * The rapporteur in case of international removal request
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rapporteur()
    {
        return $this->belongsTo(User::class, 'rapporteur_id');
    }


    /**
     * Opinions deferred to the removal request
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function opinions()
    {
        return $this->hasMany(Opinion::class);
    }


    /**
     * removal_from mutator
     *
     * @param $value
     */
    public function setRemovalFromAttribute($value)
    {
        $this->attributes['removal_from'] = Carbon::parse($value)
                                                  ->format('Y-m-d H:i:s');
    }


    /**
     * removal_to mutator
     *
     * @param $value
     */
    public function setRemovalToAttribute($value)
    {
        $this->attributes['removal_to'] = Carbon::parse($value)
                                                ->format('Y-m-d H:i:s');
    }


    /**
     * event_from mutator
     *
     * @param $value
     */
    public function setEventFromAttribute($value)
    {
        $this->attributes['event_from'] = Carbon::parse($value)
                                                ->format('Y-m-d H:i:s');
    }


    /**
     * event_to mutator
     *
     * @param $value
     */
    public function setEventToAttribute($value)
    {
        $this->attributes['event_to'] = Carbon::parse($value)
                                              ->format('Y-m-d H:i:s');
    }
}
